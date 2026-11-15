<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfilePhotoRequest;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil user (halaman baru dashboard.profile per-role)
     */
    public function show()
    {
        return view('dashboard.profile');
    }

    /**
     * Tampilkan form edit profil (diarahkan ke halaman profil tunggal)
     */
    public function edit()
    {
        return view('dashboard.profile');
    }

    /**
     * Update informasi profil (nama lengkap, phone, email)
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());

        return redirect()->back()
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Update email user
     */
    public function updateEmail(UpdateEmailRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'email' => $request->email,
            'email_verified_at' => null, // Reset verifikasi email
        ]);

        return redirect()->back()
            ->with('success', 'Email berhasil diperbarui. Silakan verifikasi email baru Anda.');
    }

    /**
     * Update password user
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil diubah. Gunakan password baru untuk login berikutnya.');
    }

    /**
     * Upload foto profil
     */
    public function uploadPhoto(UpdateProfilePhotoRequest $request)
    {
        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Simpan foto baru
        $path = $request->file('photo')->store('profiles', 'public');

        $user->update(['profile_photo' => $path]);

        return redirect()->back()
            ->with('success', 'Foto profil berhasil diupload');
    }

    /**
     * Hapus foto profil
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);

            return redirect()->back()
                ->with('success', 'Foto profil berhasil dihapus');
        }

        return redirect()->back()
            ->with('info', 'Tidak ada foto profil untuk dihapus');
    }
}
