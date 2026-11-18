<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Support\AuditLogger;
use App\Support\SettingCatalog;
use App\Support\SettingService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PengaturanController extends Controller
{
    public function __construct(private SettingService $settings)
    {
    }

    /**
     * Menampilkan halaman Pengaturan untuk role yang sedang login.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $hub = $user->selectedHub;
        $roleCode = $user->role?->code;

        $values = $this->settings->valuesFor($user, $hub);

        // Kelompokkan definisi per tab; sembunyikan kelompok yang tidak
        // memiliki satu pun field yang dapat dilihat role ini.
        $groups = [];
        foreach (SettingCatalog::GROUPS as $key => $label) {
            $fields = [];
            foreach (SettingCatalog::definitions() as $settingKey => $definition) {
                if (($definition['group'] ?? null) !== $key) {
                    continue;
                }

                $fields[$settingKey] = $definition + [
                    'value' => $values[$settingKey] ?? ($definition['default'] ?? null),
                    'can_edit' => SettingCatalog::canEdit($settingKey, $roleCode),
                    'supported' => SettingCatalog::isSupported($settingKey),
                ];
            }

            if (!empty($fields)) {
                $groups[$key] = ['label' => $label, 'fields' => $fields];
            }
        }

        $routePrefix = $this->routePrefix($user);

        return view('dashboard.pengaturan', [
            'user' => $user,
            'hub' => $hub,
            'groups' => $groups,
            'routePrefix' => $routePrefix,
            'canEditAny' => count(SettingCatalog::editableKeys($roleCode)) > 0,
        ]);
    }

    /**
     * Menyimpan konfigurasi yang diizinkan untuk role pengguna.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $hub = $user->selectedHub;

        $payload = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable'],
        ]);

        try {
            $result = $this->settings->save($user, $hub, $payload['settings']);
        } catch (ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (AccessDeniedHttpException $e) {
            abort(403, $e->getMessage());
        }

        if (empty($result['changed'])) {
            return back()->with('info', 'Tidak ada perubahan konfigurasi yang perlu disimpan.');
        }

        return back()->with(
            'success',
            count($result['changed']) . ' konfigurasi berhasil disimpan dan dicatat pada jejak audit.'
        );
    }

    /**
     * Mengembalikan konfigurasi yang dapat diedit role ke nilai default.
     */
    public function reset(Request $request)
    {
        $user = $request->user();

        if (empty(SettingCatalog::editableKeys($user->role?->code))) {
            abort(403, 'Role Anda tidak memiliki konfigurasi yang dapat direset.');
        }

        $deleted = $this->settings->reset($user, $user->selectedHub);

        return back()->with(
            'success',
            $deleted > 0
                ? $deleted . ' konfigurasi dikembalikan ke nilai default.'
                : 'Tidak ada konfigurasi tersimpan; seluruh nilai sudah memakai default.'
        );
    }

    /**
     * Riwayat perubahan konfigurasi untuk modal "Log Perubahan".
     */
    public function history(Request $request)
    {
        $query = AuditLog::with('user')
            ->where('entity_type', 'Setting')
            ->latest()
            ->limit(50);

        // Role non-Super Admin hanya melihat riwayat perubahan miliknya.
        if (!$request->user()->isSuperAdmin()) {
            $query->where('user_id', $request->user()->id);
        }

        $logs = $query->get()
            ->map(fn (AuditLog $log) => [
                'actor' => $log->user?->nama_lengkap ?? 'Sistem',
                'description' => $log->description,
                'changes' => $log->changes,
                'created_at' => optional($log->created_at)->format('d M Y H:i'),
            ]);

        return response()->json(['data' => $logs]);
    }

    private function routePrefix(User $user): string
    {
        return match (true) {
            $user->isSuperAdmin() => 'admin',
            $user->isKepalaGudang() => 'kepalagudang',
            $user->isHR() => 'hr',
            $user->isPegawai() => 'pegawai',
            default => 'audit',
        };
    }
}
