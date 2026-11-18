<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AuditLog;
use App\Models\Division;
use App\Models\Hub;
use App\Models\Role;
use App\Models\User;
use App\Models\UserSession;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserManagementController extends Controller
{
    private const SORTABLE = ['nama_lengkap', 'username', 'email', 'nip', 'status', 'last_login_at', 'created_at'];

    /**
     * Daftar pengguna dengan pencarian, filter, pengurutan, dan paginasi
     * yang seluruhnya dijalankan di sisi server.
     */
    public function index(Request $request)
    {
        $this->authorizeManage($request->user());

        $filters = $this->validateFilters($request);

        $users = $this->filteredQuery($request)->paginate($filters['per_page'])->withQueryString();

        $stats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'new_this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
            'online' => UserSession::where('status', 'active')
                ->where('last_activity_at', '>=', now()->subMinutes(30))
                ->distinct('user_id')->count('user_id'),
        ];

        $roles = Role::withCount('users')->orderBy('name')->get();
        $divisions = Division::orderBy('nama')->get();
        $hubs = Hub::orderBy('name')->get();

        return view('dashboard.superadmin.manajemenPengguna', compact(
            'users', 'stats', 'roles', 'divisions', 'hubs', 'filters'
        ));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = DB::transaction(function () use ($data) {
            // Kota mengikuti hub penugasan agar status "sudah memilih hub"
            // konsisten dan metrik dashboard langsung ter-scope dengan benar.
            $hub = !empty($data['selected_hub_id'])
                ? Hub::find($data['selected_hub_id'])
                : null;

            $user = User::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'username' => $data['username'],
                'email' => $data['email'],
                'nip' => $data['nip'],
                'phone' => $data['phone'] ?? null,
                'role_id' => $data['role_id'],
                'division_id' => $data['division_id'] ?? null,
                'selected_hub_id' => $hub?->id,
                'selected_city_id' => $hub?->city_id,
                'status' => $data['status'],
                'password' => $data['password'],
            ]);

            AuditLogger::log(
                auth()->user(),
                'create',
                User::class,
                $user->id,
                ['after' => $this->snapshot($user)],
                'success',
                'Membuat akun pengguna ' . $user->nama_lengkap . '.'
            );

            return $user;
        });

        return redirect()
            ->route('admin.pengguna', $request->only(['q', 'role', 'status', 'hub', 'division']))
            ->with('success', 'Akun ' . $user->nama_lengkap . ' berhasil dibuat.');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorizeManage($request->user());
        $data = $request->validated();

        // Super Admin terakhir tidak boleh diturunkan perannya.
        if ($user->isSuperAdmin() && (int) $data['role_id'] !== (int) $user->role_id) {
            $otherSuperAdmins = User::where('role_id', $user->role_id)
                ->where('id', '!=', $user->id)
                ->where('status', 'active')
                ->count();

            if ($otherSuperAdmins === 0) {
                return back()->with('error', 'Super Admin terakhir tidak dapat diubah perannya.');
            }
        }

        DB::transaction(function () use ($data, $user) {
            $before = $this->snapshot($user);

            // Kota mengikuti hub penugasan agar status "sudah memilih hub"
            // konsisten dan metrik dashboard langsung ter-scope dengan benar.
            $hub = !empty($data['selected_hub_id'])
                ? Hub::find($data['selected_hub_id'])
                : null;

            $attributes = [
                'nama_lengkap' => $data['nama_lengkap'],
                'username' => $data['username'],
                'email' => $data['email'],
                'nip' => $data['nip'],
                'phone' => $data['phone'] ?? null,
                'role_id' => $data['role_id'],
                'division_id' => $data['division_id'] ?? null,
                'selected_hub_id' => $hub?->id,
                'selected_city_id' => $hub?->city_id,
                'status' => $data['status'],
            ];

            if (!empty($data['password'])) {
                $attributes['password'] = $data['password'];
            }

            $user->update($attributes);

            AuditLogger::log(
                auth()->user(),
                'update',
                User::class,
                $user->id,
                ['before' => $before, 'after' => $this->snapshot($user)],
                'success',
                'Memperbarui akun pengguna ' . $user->nama_lengkap . '.'
            );
        });

        return redirect()
            ->route('admin.pengguna', $request->only(['q', 'role', 'status', 'hub', 'division']))
            ->with('success', 'Data ' . $user->nama_lengkap . ' berhasil diperbarui.');
    }

    public function toggleStatus(Request $request, User $user)
    {
        $this->authorizeManage($request->user());

        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        if ($user->isSuperAdmin() && $user->status === 'active') {
            $activeSuperAdmins = User::where('role_id', $user->role_id)
                ->where('status', 'active')
                ->count();

            if ($activeSuperAdmins <= 1) {
                return back()->with('error', 'Super Admin aktif terakhir tidak dapat dinonaktifkan.');
            }
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';

        DB::transaction(function () use ($user, $newStatus) {
            $previousStatus = $user->status;
            $user->update(['status' => $newStatus]);

            AuditLogger::log(
                auth()->user(),
                $newStatus === 'active' ? 'activate' : 'deactivate',
                User::class,
                $user->id,
                ['status' => ['before' => $previousStatus, 'after' => $newStatus]],
                'success',
                ($newStatus === 'active' ? 'Mengaktifkan' : 'Menonaktifkan') . ' akun ' . $user->nama_lengkap . '.'
            );
        });

        return back()->with('success', 'Status akun ' . $user->nama_lengkap . ' menjadi ' . $newStatus . '.');
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorizeManage($request->user());

        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if ($user->isSuperAdmin()) {
            $activeSuperAdmins = User::where('role_id', $user->role_id)
                ->where('status', 'active')
                ->count();

            if ($activeSuperAdmins <= 1) {
                return back()->with('error', 'Super Admin aktif terakhir tidak dapat dihapus.');
            }
        }

        DB::transaction(function () use ($user) {
            $snapshot = $this->snapshot($user);

            // Cabut seluruh sesi aktif sebelum akun dihapus (soft delete).
            UserSession::where('user_id', $user->id)->where('status', 'active')
                ->update(['status' => 'revoked', 'revoked_at' => now()]);

            $user->delete();

            AuditLogger::log(
                auth()->user(),
                'delete',
                User::class,
                $user->id,
                ['before' => $snapshot],
                'success',
                'Menghapus akun ' . $user->nama_lengkap . '.'
            );
        });

        return back()->with('success', 'Akun ' . $user->nama_lengkap . ' berhasil dihapus.');
    }

    public function bulk(Request $request)
    {
        $this->authorizeManage($request->user());

        $data = $request->validate([
            'action' => ['required', Rule::in(['activate', 'deactivate', 'delete'])],
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ]);

        $targets = User::whereIn('id', $data['user_ids'])->get();
        $skipped = [];
        $processed = 0;

        DB::transaction(function () use ($targets, $data, $request, &$skipped, &$processed) {
            foreach ($targets as $target) {
                if ($target->id === $request->user()->id) {
                    $skipped[] = $target->nama_lengkap . ' (akun sendiri)';
                    continue;
                }

                if ($target->isSuperAdmin()) {
                    $activeSuperAdmins = User::where('role_id', $target->role_id)
                        ->where('status', 'active')->count();

                    if ($data['action'] !== 'activate' && $activeSuperAdmins <= 1) {
                        $skipped[] = $target->nama_lengkap . ' (Super Admin terakhir)';
                        continue;
                    }
                }

                if ($data['action'] === 'delete') {
                    UserSession::where('user_id', $target->id)->where('status', 'active')
                        ->update(['status' => 'revoked', 'revoked_at' => now()]);
                    $target->delete();
                    $action = 'delete';
                } else {
                    $target->update(['status' => $data['action'] === 'activate' ? 'active' : 'inactive']);
                    $action = $data['action'] === 'activate' ? 'activate' : 'deactivate';
                }

                AuditLogger::log(
                    $request->user(),
                    $action,
                    User::class,
                    $target->id,
                    ['bulk' => true],
                    'success',
                    'Tindakan massal: ' . $action . ' pada ' . $target->nama_lengkap . '.'
                );

                $processed++;
            }
        });

        $message = $processed . ' akun diproses.';
        if (!empty($skipped)) {
            $message .= ' Dilewati: ' . implode(', ', $skipped) . '.';
        }

        return back()->with($processed > 0 ? 'success' : 'error', $message);
    }

    /**
     * Ekspor CSV mengikuti filter aktif. Tidak menyertakan password/token.
     */
    public function export(Request $request): StreamedResponse
    {
        $this->authorizeManage($request->user());
        $this->validateFilters($request);

        $query = $this->filteredQuery($request, false);
        $filename = 'pengguna-' . now()->format('Ymd-His') . '.csv';

        AuditLogger::log(
            $request->user(),
            'export',
            User::class,
            null,
            ['filters' => $request->only(['q', 'role', 'status', 'hub', 'division'])],
            'success',
            'Mengekspor daftar pengguna ke CSV.'
        );

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Username', 'Email', 'NIP', 'Telepon', 'Peran', 'Divisi', 'Hub', 'Status', 'Login Terakhir']);

            $query->chunk(500, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->nama_lengkap,
                        $user->username,
                        $user->email,
                        $user->nip,
                        $user->phone,
                        $user->role?->name,
                        $user->division?->nama,
                        $user->selectedHub?->name,
                        $user->status,
                        optional($user->last_login_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Riwayat aktivitas pengguna dari audit_logs + user_sessions.
     */
    public function activity(Request $request, User $user)
    {
        $this->authorizeManage($request->user());

        return response()->json([
            'user' => [
                'id' => $user->id,
                'nama_lengkap' => $user->nama_lengkap,
            ],
            'audit_logs' => AuditLog::where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere(function ($q) use ($user) {
                        $q->where('entity_type', User::class)->where('entity_id', $user->id);
                    });
            })->latest()->limit(25)->get()->map(fn ($log) => [
                'action' => $log->action,
                'description' => $log->description,
                'result' => $log->result,
                'created_at' => optional($log->created_at)->format('Y-m-d H:i:s'),
            ]),
            'sessions' => UserSession::where('user_id', $user->id)
                ->latest('last_activity_at')->limit(10)->get()->map(fn ($session) => [
                    'device_name' => $session->device_name,
                    'platform' => $session->platform,
                    'browser' => $session->browser,
                    'ip_address' => $session->ip_address,
                    'status' => $session->status,
                    'last_activity_at' => optional($session->last_activity_at)->format('Y-m-d H:i:s'),
                ]),
        ]);
    }

    private function filteredQuery(Request $request, bool $withRelations = true)
    {
        $query = User::query();

        if ($withRelations) {
            $query->with(['role', 'division', 'selectedHub']);
        } else {
            $query->with(['role:id,name', 'division:id,nama', 'selectedHub:id,name']);
        }

        if ($q = trim((string) $request->input('q'))) {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_lengkap', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('nip', 'like', "%{$q}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->whereHas('role', fn ($sub) => $sub->where('code', $role));
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($hub = $request->input('hub')) {
            $query->where('selected_hub_id', $hub);
        }

        if ($division = $request->input('division')) {
            $query->where('division_id', $division);
        }

        $sort = $request->input('sort', 'created_at');
        if (!in_array($sort, self::SORTABLE, true)) {
            $sort = 'created_at';
        }

        $direction = strtolower((string) $request->input('dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sort, $direction);
    }

    private function validateFilters(Request $request): array
    {
        return $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'role' => ['nullable', 'string', 'max:40'],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
            'hub' => ['nullable', 'integer', 'exists:hubs,id'],
            'division' => ['nullable', 'integer', 'exists:divisions,id'],
            'sort' => ['nullable', Rule::in(self::SORTABLE)],
            'dir' => ['nullable', Rule::in(['asc', 'desc'])],
            'per_page' => ['nullable', 'integer', 'min:5', 'max:100'],
        ]) + [
            'per_page' => 10,
            'sort' => 'created_at',
            'dir' => 'desc',
        ];
    }

    private function authorizeManage(User $actor): void
    {
        abort_unless(
            $actor->isSuperAdmin() || $actor->hasPermission('user.manage'),
            403,
            'Anda tidak memiliki izin mengelola pengguna.'
        );
    }

    private function snapshot(User $user): array
    {
        return [
            'nama_lengkap' => $user->nama_lengkap,
            'username' => $user->username,
            'email' => $user->email,
            'nip' => $user->nip,
            'phone' => $user->phone,
            'role_id' => $user->role_id,
            'division_id' => $user->division_id,
            'selected_hub_id' => $user->selected_hub_id,
            'status' => $user->status,
        ];
    }
}
