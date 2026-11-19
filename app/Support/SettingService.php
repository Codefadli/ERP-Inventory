<?php

namespace App\Support;

use App\Models\Hub;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SettingService
{
    public const SECRET_MASK = '••••••••';

    /**
     * Nilai efektif seluruh konfigurasi untuk user + hub yang dipilih.
     *
     * @return array<string, mixed>
     */
    public function valuesFor(User $user, ?Hub $hub = null): array
    {
        $stored = $this->storedValues($user, $hub);
        $values = [];

        foreach (SettingCatalog::definitions() as $key => $def) {
            if (array_key_exists($key, $stored) && $stored[$key] !== null) {
                $values[$key] = $this->castValue($stored[$key], $def);
                continue;
            }

            $fallback = $def['fallback_attribute'] ?? null;
            if ($fallback && $hub && $hub->{$fallback} !== null) {
                $values[$key] = $hub->{$fallback};
                continue;
            }

            $values[$key] = $def['default'] ?? null;
        }

        // Secret tidak boleh dikirim utuh ke browser.
        if (!empty($values['erp.api_key'])) {
            $values['erp.api_key'] = self::SECRET_MASK;
        }

        return $values;
    }

    /**
     * Nilai mentah (sudah didekripsi) untuk scope yang relevan.
     *
     * @return array<string, string|null>
     */
    public function storedValues(User $user, ?Hub $hub = null): array
    {
        $query = Setting::query()->where(function ($q) use ($user, $hub) {
            $q->where(function ($q) {
                $q->where('scope', Setting::SCOPE_GLOBAL)->where('scope_id', 0);
            });

            if ($hub) {
                $q->orWhere(function ($q) use ($hub) {
                    $q->where('scope', Setting::SCOPE_HUB)->where('scope_id', $hub->id);
                });
            }

            $q->orWhere(function ($q) use ($user) {
                $q->where('scope', Setting::SCOPE_USER)->where('scope_id', $user->id);
            });
        });

        return $query->get()
            ->mapWithKeys(fn (Setting $setting) => [$setting->key => $setting->decrypted_value])
            ->toArray();
    }

    /**
     * Simpan hanya field yang boleh diubah oleh role user.
     *
     * @param  array<string, mixed>  $input
     * @return array{saved: array<int, string>, changed: array<string, array{before: mixed, after: mixed}>}
     */
    public function save(User $user, ?Hub $hub, array $input): array
    {
        $roleCode = $user->role?->code;

        $unknown = array_diff(array_keys($input), array_keys(SettingCatalog::definitions()));
        if (!empty($unknown)) {
            throw ValidationException::withMessages([
                'settings' => 'Terdapat field konfigurasi yang tidak dikenal: ' . implode(', ', $unknown),
            ]);
        }

        $saved = [];
        $changes = [];

        DB::transaction(function () use ($user, $hub, $input, $roleCode, &$saved, &$changes) {
            foreach ($input as $key => $value) {
                if (!SettingCatalog::canEdit($key, $roleCode)) {
                    throw new AccessDeniedHttpException(
                        "Anda tidak berwenang mengubah konfigurasi '{$key}'."
                    );
                }

                $def = SettingCatalog::get($key);
                [$scope, $scopeId] = $this->resolveScope($def, $user, $hub);

                $normalized = $this->normalizeInput($key, $value, $def);

                // Nilai rahasia: kosong/mask berarti "jangan diubah".
                if ($def['type'] === 'secret') {
                    if ($normalized === null || $normalized === '' || $normalized === self::SECRET_MASK) {
                        continue;
                    }
                }

                $this->validateValue($key, $normalized, $def);

                $existing = Setting::where('scope', $scope)
                    ->where('scope_id', $scopeId)
                    ->where('key', $key)
                    ->first();

                $before = $existing?->decrypted_value;
                $before = $before ?? ($def['fallback_attribute'] ?? null ? ($hub?->{$def['fallback_attribute']}) : ($def['default'] ?? null));

                $storedValue = $def['type'] === 'secret'
                    ? Crypt::encryptString((string) $normalized)
                    : (is_bool($normalized) ? ($normalized ? '1' : '0') : (string) $normalized);

                Setting::updateOrCreate(
                    ['scope' => $scope, 'scope_id' => $scopeId, 'key' => $key],
                    [
                        'value' => $storedValue,
                        'type' => $def['type'],
                        'is_encrypted' => $def['type'] === 'secret',
                        'updated_by' => $user->id,
                    ]
                );

                $after = $def['type'] === 'secret' ? self::SECRET_MASK : $normalized;

                if ((string) $before !== (string) $after) {
                    $changes[$key] = [
                        'before' => $def['type'] === 'secret' ? ($before ? self::SECRET_MASK : null) : $before,
                        'after' => $after,
                    ];
                }

                $saved[] = $key;
            }
        });

        if (!empty($changes)) {
            AuditLogger::log(
                $user,
                'update',
                'Setting',
                null,
                ['settings' => $changes],
                'success',
                'Memperbarui ' . count($changes) . ' konfigurasi (' . implode(', ', array_keys($changes)) . ').'
            );
        }

        return ['saved' => $saved, 'changed' => $changes];
    }

    /**
     * Hapus override konfigurasi yang boleh diubah role, kembali ke default.
     */
    public function reset(User $user, ?Hub $hub): int
    {
        $roleCode = $user->role?->code;
        $keys = SettingCatalog::editableKeys($roleCode);
        $deleted = 0;

        DB::transaction(function () use ($keys, $user, $hub, &$deleted) {
            foreach ($keys as $key) {
                $def = SettingCatalog::get($key);
                [$scope, $scopeId] = $this->resolveScope($def, $user, $hub);

                $deleted += Setting::where('scope', $scope)
                    ->where('scope_id', $scopeId)
                    ->where('key', $key)
                    ->delete();
            }
        });

        AuditLogger::log(
            $user,
            'update',
            'Setting',
            null,
            ['reset_keys' => $keys],
            'success',
            'Mengembalikan ' . count($keys) . ' konfigurasi ke nilai default.'
        );

        return $deleted;
    }

    /**
     * Ambil satu nilai global (dipakai runtime aplikasi).
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $def = SettingCatalog::get($key);
        if (!$def) {
            return $default;
        }

        try {
            $setting = Setting::where('scope', Setting::SCOPE_GLOBAL)
                ->where('scope_id', 0)
                ->where('key', $key)
                ->first();
        } catch (\Throwable $e) {
            return $def['default'] ?? $default;
        }

        if (!$setting) {
            return $def['default'] ?? $default;
        }

        return $this->castValue($setting->decrypted_value, $def) ?? $default;
    }

    /**
     * @return array{0: string, 1: int}
     */
    private function resolveScope(array $def, User $user, ?Hub $hub): array
    {
        $scope = $def['scope'] ?? Setting::SCOPE_GLOBAL;

        if ($scope === Setting::SCOPE_HUB) {
            if (!$hub) {
                throw ValidationException::withMessages([
                    'settings' => 'Pilih hub operasional terlebih dahulu sebelum menyimpan konfigurasi hub.',
                ]);
            }

            return [Setting::SCOPE_HUB, $hub->id];
        }

        if ($scope === Setting::SCOPE_USER) {
            return [Setting::SCOPE_USER, $user->id];
        }

        return [Setting::SCOPE_GLOBAL, 0];
    }

    private function normalizeInput(string $key, mixed $value, array $def): mixed
    {
        if ($def['type'] === 'boolean') {
            if (is_bool($value)) {
                return $value;
            }

            return in_array($value, [1, '1', 'true', 'on', 'yes'], true);
        }

        if ($def['type'] === 'integer' && $value !== null && $value !== '') {
            return (int) $value;
        }

        if (is_string($value)) {
            return trim($value);
        }

        return $value;
    }

    private function validateValue(string $key, mixed $value, array $def): void
    {
        $field = 'setting_' . str_replace('.', '__', $key);
        $rules = $def['validation'] ?? ['nullable'];

        // Secret yang baru diisi harus lolos aturan string.
        if ($def['type'] === 'secret') {
            $rules = ['required', 'string', 'min:8', 'max:255'];
        }

        $validator = Validator::make([$field => $value], [$field => $rules], [
            'required' => 'Nilai :attribute wajib diisi.',
        ], [$field => $def['label']]);

        if ($validator->fails()) {
            throw ValidationException::withMessages([
                'settings' => $def['label'] . ': ' . $validator->errors()->first($field),
            ]);
        }
    }

    private function castValue(mixed $value, array $def): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($def['type']) {
            'boolean' => (bool) $value,
            'integer' => (int) $value,
            default => (string) $value,
        };
    }
}
