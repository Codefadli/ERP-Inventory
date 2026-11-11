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
     * Tampilkan halaman profil user
     */
    public function show()
    {
        $user = Auth::user()->load('role', 'selectedCity', 'selectedHub');
        
        return view('profile.show', compact('user'));
    }

    /**
     * Tampilkan form edit profil
     */
    public function edit()
    {
        $user = Auth::user()->load('role', 'selectedCity', 'selectedHub');
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update informasi profil (nama lengkap, phone)
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        
        $user->update($request->validated());
        
        return redirect()->route('profile.show')
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
        
        return redirect()->route('profile.show')
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
        
        return redirect()->route('profile.show')
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
        
        return redirect()->route('profile.show')
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
            
            return redirect()->route('profile.show')
                ->with('success', 'Foto profil berhasil dihapus');
        }
        
        return redirect()->route('profile.show')
            ->with('info', 'Tidak ada foto profil untuk dihapus');
    }
}
