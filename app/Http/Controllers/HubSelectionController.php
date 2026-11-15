<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Hub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HubSelectionController extends Controller
{
    /**
     * Tampilkan halaman pemilihan hub
     */
    public function show()
    {
        $user = Auth::user();

        // Jika user tidak perlu pilih hub, redirect ke dashboard
        if (!$user->needsHubSelection()) {
            return $this->redirectToDashboard($user);
        }

        // Jika sudah pilih hub, redirect ke dashboard
        if ($user->hasSelectedHub()) {
            return $this->redirectToDashboard($user);
        }

        // Ambil data cities dengan hubs aktif
        $cities = City::with(['hubs' => function ($query) {
            $query->where('status', 'active')->orderBy('name');
        }])
        ->where('status', 'active')
        ->orderBy('name')
        ->get();

        return view('hub-selection.index', [
            'user' => $user,
            'cities' => $cities,
        ]);
    }

    /**
     * Simpan pilihan hub
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi
        $validator = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'hub_id' => 'required|exists:hubs,id',
        ], [
            'city_id.required' => 'Kota harus dipilih',
            'city_id.exists' => 'Kota tidak valid',
            'hub_id.required' => 'Hub harus dipilih',
            'hub_id.exists' => 'Hub tidak valid',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verifikasi hub ada di city yang dipilih
        $hub = Hub::where('id', $request->hub_id)
            ->where('city_id', $request->city_id)
            ->where('status', 'active')
            ->first();

        if (!$hub) {
            return back()
                ->withErrors(['hub_id' => 'Hub tidak valid untuk kota yang dipilih'])
                ->withInput();
        }

        // Simpan pilihan
        $user->update([
            'selected_city_id' => $request->city_id,
            'selected_hub_id' => $request->hub_id,
        ]);

        // Log audit trail
        \Log::info('User selected hub', [
            'user_id' => $user->id,
            'username' => $user->username,
            'city_id' => $request->city_id,
            'hub_id' => $request->hub_id,
            'hub_code' => $hub->code,
            'ip' => $request->ip(),
        ]);

        // Redirect ke dashboard
        return $this->redirectToDashboard($user);
    }

    /**
     * API: Get hubs by city
     */
    public function getHubsByCity(Request $request)
    {
        $cityId = $request->input('city_id');

        if (!$cityId) {
            return response()->json([
                'success' => false,
                'message' => 'City ID required',
            ], 400);
        }

        $hubs = Hub::where('city_id', $cityId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $hubs,
        ]);
    }

    /**
     * Redirect ke dashboard sesuai role
     */
    protected function redirectToDashboard($user)
    {
        $hubName = $user->selectedHub ? $user->selectedHub->name : '';
        $message = "Selamat datang di {$hubName}, {$user->nama_lengkap}";

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', $message);
        }

        if ($user->isHR()) {
            return redirect()->route('hr.dashboard')->with('success', $message);
        }

        if ($user->isAuditor()) {
            return redirect()->route('audit.dashboard')->with('success', $message);
        }

        // Fallback
        return redirect()->route('dashboard')->with('success', $message);
    }
}
