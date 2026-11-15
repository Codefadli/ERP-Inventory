<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    /**
     * Menampilkan Pusat Notifikasi & Pemberitahuan.
     * Satu view bersama untuk semua role (Kepala Gudang, HR, Pegawai, dst)
     * dengan blok konten per-role.
     */
    public function index()
    {
        return view('dashboard.notifikasi');
    }
}
