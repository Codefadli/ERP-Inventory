<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilePageController extends Controller
{
    /**
     * Menampilkan halaman Profil Saya.
     * Satu view bersama untuk semua role (Super Admin, Kepala Gudang, HR, Pegawai, Auditor)
     * dengan blok konten per-role.
     */
    public function index()
    {
        return view('dashboard.profile');
    }
}
