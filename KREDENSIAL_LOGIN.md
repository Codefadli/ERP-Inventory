# 🔐 KREDENSIAL LOGIN - ERP INVENTORY

**Tanggal Update**: 2026-11-05  
**Status**: Password berhasil direset untuk semua user

---

## ✅ AKUN LOGIN YANG TERSEDIA

### 1. Super Admin
- **Email**: `superadmin@astro.com`
- **Password**: `password123`
- **Role**: Super Admin
- **Status**: Active
- **Akses**: Full system access + Hub Selection required

### 2. HR Manager
- **Email**: `hr.manager@astro.com`
- **Password**: `password123`
- **Role**: HR (Human Resource)
- **Status**: Active
- **Akses**: HR dashboard + Hub Selection required

### 3. Auditor
- **Email**: `auditor@astro.com`
- **Password**: `password123`
- **Role**: Auditor
- **Status**: Active
- **Akses**: Audit dashboard + Hub Selection required

### 4. Kepala Gudang
- **Email**: `kepala.gudang@astro.com`
- **Password**: `password123`
- **Role**: Kepala Gudang
- **Status**: Active
- **Akses**: Warehouse dashboard (NO hub selection)

### 5. Pegawai Gudang #1
- **Email**: `pegawai1@astro.com`
- **Password**: `password123`
- **Role**: Pegawai Gudang
- **Status**: Active
- **Akses**: Employee dashboard (NO hub selection)

### 6. Pegawai Gudang #2
- **Email**: `pegawai2@astro.com`
- **Password**: `password123`
- **Role**: Pegawai Gudang
- **Status**: Active
- **Akses**: Employee dashboard (NO hub selection)

---

## 🚀 CARA LOGIN

### Step 1: Akses Halaman Login
```
URL: http://localhost/login
atau
URL: http://127.0.0.1:8000/login (jika menggunakan php artisan serve)
```

### Step 2: Masukkan Kredensial
- Pilih salah satu email di atas
- Password: `password123` (untuk semua akun)

### Step 3: Hub Selection (untuk admin/hr/audit)
Setelah login berhasil, role **Super Admin**, **HR**, dan **Auditor** akan diredirect ke:
- URL: `/hub-selection`
- Pilih Kota (5 pilihan tersedia)
- Pilih Hub (sesuai kota yang dipilih)
- Klik "Lanjutkan ke Dashboard"

### Step 4: Dashboard
Setelah hub selection selesai (atau langsung jika kepala gudang/pegawai):
- Super Admin → `/admin/dashboard`
- HR → `/hr/dashboard` (belum dibuat)
- Auditor → `/audit/dashboard` (belum dibuat)
- Kepala Gudang → `/gudang/dashboard` (belum dibuat)
- Pegawai → `/pegawai/dashboard` (belum dibuat)

---

## 🏢 DATA HUB YANG TERSEDIA

### DKI Jakarta (4 Hubs)
1. Hub Cakung DC-01
2. Hub Sunter WH-02
3. Hub Pluit LOG-03
4. Hub Kelapa Gading MKT-04

### Bandung (3 Hubs)
1. Hub Cibiru DC-01
2. Hub Cimahi WH-02
3. Hub Soreang LOG-03

### Surabaya (3 Hubs)
1. Hub Rungkut DC-01
2. Hub Sidoarjo WH-02
3. Hub Waru LOG-03

### Semarang (2 Hubs)
1. Hub Tembalang DC-01
2. Hub Ngaliyan WH-02

### Medan (2 Hubs)
1. Hub Medan Polonia DC-01
2. Hub Belawan WH-02

---

## ⚠️ TROUBLESHOOTING

### Masalah: "Tidak bisa login"
**Penyebab**: Password salah atau tidak ter-hash dengan benar  
**Solusi**: Password sudah direset ke `password123` untuk semua user ✓

### Masalah: "Redirect loop setelah login"
**Penyebab**: Middleware hub selection atau routing issue  
**Solusi**: 
- Clear cache: `php artisan config:clear && php artisan route:clear`
- Check middleware di `app/Http/Kernel.php`
- Check LoginController redirectAfterLogin()

### Masalah: "404 Not Found"
**Penyebab**: View errors/404 tidak ada  
**Solusi**: File `errors/404.blade.php` sudah dibuat ✓

### Masalah: "Hub selection tidak muncul"
**Penyebab**: Role tidak termasuk dalam needsHubSelection()  
**Solusi**: Check User model method needsHubSelection() - hanya untuk role code: super_admin, hr, audit

---

## 🔄 RESET PASSWORD (Jika Diperlukan)

Jika suatu saat perlu reset password lagi:

```bash
# Reset semua user ke password123
php artisan tinker

# Di dalam tinker:
\App\Models\User::all()->each(function($u) { 
    $u->password = 'password123'; 
    $u->save(); 
});

# Atau reset user tertentu:
$user = \App\Models\User::where('email', 'superadmin@astro.com')->first();
$user->password = 'passwordbaru123';
$user->save();
```

---

## ✅ STATUS SAAT INI

- ✅ Password direset untuk 6 user
- ✅ Login route tersedia
- ✅ Hub selection system aktif
- ✅ Middleware berfungsi
- ✅ Error view 404 dibuat
- ✅ Dashboard admin tersedia
- ⚠️ Dashboard role lain belum dibuat (hr, audit, gudang, pegawai)

---

## 📝 CATATAN PENTING

1. **Password Default**: Semua user menggunakan `password123`
2. **Hub Selection**: Hanya untuk Super Admin, HR, dan Auditor
3. **Dashboard**: Hanya dashboard admin yang sudah lengkap
4. **Production**: Ganti password default sebelum production!

---

**Selamat mencoba login! 🎉**
