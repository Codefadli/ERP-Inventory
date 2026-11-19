<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\TemuanAudit;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Temuan audit / LTA.
class TemuanAuditController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $hubId = $this->resolveHubId($request, $user);

        $query = TemuanAudit::query()
            ->with(['user', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('kode', 'like', "%{$q}%")
                    ->orWhere('judul', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%");
            });
        }

        $temuans = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = TemuanAudit::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats = [
            'total'   => (clone $base)->count(),
            'baru'    => (clone $base)->where('status', 'Temuan Baru')->count(),
            'verif'   => (clone $base)->where('status', 'Diverifikasi')->count(),
            'selesai' => (clone $base)->where('status', 'Selesai')->count(),
            'kritis'  => (clone $base)->where('tingkat', 'Kritis')->count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.audit.temuanAudit', [
            'user'          => $user,
            'routeName'     => 'audit.temuan-audit',
            'temuans'       => $temuans,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
            'status'        => $request->query('status', ''),
        ]);
    }

    /**
     * Simpan temuan audit baru.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!($user->isAuditor() || $user->isSuperAdmin())) {
            abort(403, 'Anda tidak memiliki izin untuk mencatat temuan audit.');
        }

        $validated = $request->validate([
            'kode' => 'required|string|max:30|unique:temuan_audits,kode',
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:2000',
            'tingkat' => 'required|in:Ringan,Sedang,Kritis',
            'status' => 'required|in:Temuan Baru,Diverifikasi,Selesai',
            'lokasi' => 'nullable|string|max:150',
            'hub_id' => 'nullable|exists:hubs,id',
        ]);

        $hubId = $validated['hub_id'] ?? ($user->selectedHub?->id ?? null);

        $temuan = DB::transaction(function () use ($validated, $hubId, $user) {
            $t = TemuanAudit::create(array_merge($validated, [
                'user_id' => $user->id,
                'hub_id' => $hubId,
            ]));

            AuditLogger::log(
                $user,
                'create',
                TemuanAudit::class,
                $t->id,
                ['kode' => $t->kode, 'tingkat' => $t->tingkat, 'hub_id' => $hubId],
                'success',
                'Mencatat temuan audit: ' . $t->kode . ' - ' . $t->judul
            );

            return $t;
        });

        return redirect()
            ->route('audit.temuan-audit')
            ->with('success', 'Temuan ' . $temuan->kode . ' berhasil dicatat.');
    }

    /**
     * Ubah status temuan (baru -> diverifikasi -> selesai).
     */
    public function updateStatus(Request $request, int $id)
    {
        $user = auth()->user();
        if (!($user->isAuditor() || $user->isSuperAdmin())) {
            abort(403, 'Anda tidak memiliki izin mengubah status temuan.');
        }

        $temuan = TemuanAudit::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:Temuan Baru,Diverifikasi,Selesai',
        ]);

        $temuan->status = $validated['status'];
        $temuan->save();

        AuditLogger::log(
            $user,
            'update',
            TemuanAudit::class,
            $temuan->id,
            ['status' => $temuan->status, 'kode' => $temuan->kode],
            'success',
            'Mengubah status temuan ' . $temuan->kode . ' -> ' . $temuan->status
        );

        return redirect()
            ->route('audit.temuan-audit')
            ->with('success', 'Status temuan ' . $temuan->kode . ' diperbarui.');
    }

    private function resolveHubId(Request $request, $user): string
    {
        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $user->selectedHub ? (string) $user->selectedHub->id : 'all';
        }
        return $hubId;
    }
}
