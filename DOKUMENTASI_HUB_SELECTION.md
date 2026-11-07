# DOKUMENTASI SISTEM PEMILIHAN HUB

## 📋 RINGKASAN

Sistem pemilihan hub telah berhasil diimplementasikan untuk role **Admin**, **HR**, dan **Audit**. User dengan role tersebut WAJIB memilih kota dan hub operasional sebelum dapat mengakses dashboard.

---

## 🎯 FITUR YANG DIIMPLEMENTASIKAN

### 1. Database Schema
- **Table `cities`**: Menyimpan data kota operasional
  - Kolom: id, name, region, status, active_hubs_count, areas (JSON)
  
- **Table `hubs`**: Menyimpan data hub/gudang operasional
  - Kolom: id, city_id, code, name, category, address, capacity, occupancy, area, status
  
- **Update `users` table**: Menambahkan kolom untuk menyimpan pilihan hub
  - Kolom baru: selected_city_id, selected_hub_id

### 2. Models
- **City Model** (`app/Models/City.php`)
  - Relasi dengan Hub (hasMany)
  - Relasi dengan Users yang memilih city ini
  - Scope: active()
  
- **Hub Model** (`app/Models/Hub.php`)
  - Relasi dengan City (belongsTo)
  - Relasi dengan Users yang memilih hub ini
  - Scope: active(), inCity()

- **User Model Updates** (`app/Models/User.php`)
  - Method baru: `needsHubSelection()` - cek apakah user perlu pilih hub
  - Method baru: `hasSelectedHub()` - cek apakah user sudah pilih hub
  - Relasi: selectedCity(), selectedHub()

### 3. Controller
- **HubSelectionController** (`app/Http/Controllers/HubSelectionController.php`)
  - `show()`: Tampilkan halaman pemilihan hub
  - `store()`: Simpan pilihan hub user
  - `getHubsByCity()`: API untuk load hub berdasarkan city

### 4. Middleware
- **EnsureHubSelected** (`app/Http/Middleware/EnsureHubSelected.php`)
  - Otomatis redirect user ke halaman hub selection jika:
    - User memiliki role admin/hr/audit
    - User belum memilih hub
  - Terintegrasi di web middleware group

### 5. Routes
```php
// Hub Selection Routes (authenticated users only)
GET  /hub-selection              → hub.selection.show
POST /hub-selection              → hub.selection.store
GET  /hub-selection/hubs-by-city → hub.selection.hubs-by-city (AJAX)
```

### 6. View
- **Hub Selection Page** (`resources/views/hub-selection/index.blade.php`)
  - Multi-step form dengan progress stepper (3 langkah)
  - Tahap 1: Pilih kota operasional (5 kota tersedia)
  - Tahap 2: Pilih hub operasional (dynamic load berdasarkan kota)
  - Real-time validation dengan JavaScript
  - Responsive design dengan Tailwind CSS
  - Interface sesuai dengan design Pemilihan_Hub.png

---

## 📊 DATA YANG TERSEDIA

### Cities (5 kota):
1. **DKI Jakarta** - 4 Hub Aktif (Cakung, Halim, Pluit, Cengkareng)
2. **Kota Bandung** - 3 Hub Aktif (Soekarno Hatta, Pasteur, Gedebage)
3. **Kota Surabaya** - 3 Hub Aktif (Rungkut, Tanjung Perak, Waru)
4. **Kota Semarang** - 2 Hub Aktif (Tanjung Mas, Genuk)
5. **Kota Medan** - 2 Hub Aktif (Belawan, Amplas)

### Total Hubs: 14 hub aktif tersebar di 5 kota

---

## 🔄 ALUR KERJA SISTEM

### Login Flow untuk Admin/HR/Audit:
```
1. User login dengan credentials
   ↓
2. LoginController cek: needsHubSelection() && !hasSelectedHub()
   ↓
3. Jika belum pilih hub → Redirect ke /hub-selection
   ↓
4. User pilih kota (Tahap 1)
   ↓
5. System load daftar hub di kota tersebut (AJAX)
   ↓
6. User pilih hub (Tahap 2)
   ↓
7. Submit form → HubSelectionController->store()
   ↓
8. Update users table (selected_city_id, selected_hub_id)
   ↓
9. Redirect ke dashboard sesuai role
```

### Protection Middleware:
```
Setiap request authenticated user:
   ↓
EnsureHubSelected middleware cek:
   - Apakah user perlu pilih hub? (admin/hr/audit)
   - Sudah pilih hub?
   ↓
Jika belum → Redirect ke /hub-selection
Jika sudah → Lanjutkan ke route yang diminta
```

---

## 🚀 CARA TESTING

### 1. Testing dengan User Admin/HR/Audit
```bash
# Login dengan salah satu akun:
- admin@astro.com / Admin123!
- hr@astro.com / HR123!
- audit@astro.com / Audit123!

# Flow yang terjadi:
1. Setelah login berhasil → Auto redirect ke /hub-selection
2. Pilih kota (misal: DKI Jakarta)
3. Pilih hub (misal: Hub Cakung DC-01)
4. Klik "Lanjutkan ke Dashboard Operasional"
5. Sistem redirect ke dashboard sesuai role
6. Hub selection tersimpan di session user
```

### 2. Testing Middleware Protection
```bash
# Coba akses dashboard langsung tanpa pilih hub:
GET /admin/dashboard
# Hasilnya: Auto redirect ke /hub-selection

# Setelah pilih hub, akses lagi:
GET /admin/dashboard
# Hasilnya: Berhasil masuk dashboard
```

### 3. Testing dengan User Role Lain (Kepala Gudang, Pegawai)
```bash
# Login dengan akun kepala_gudang atau pegawai
# Hasilnya: Langsung masuk dashboard tanpa perlu pilih hub
```

---

## 📁 FILE YANG DIBUAT/DIUBAH

### File Baru:
1. `database/migrations/2026_11_05_062322_create_cities_table.php`
2. `database/migrations/2026_11_05_062324_create_hubs_table.php`
3. `database/migrations/2026_11_05_062326_add_selected_hub_to_users_table.php`
4. `database/seeders/CitiesAndHubsSeeder.php`
5. `app/Models/City.php`
6. `app/Models/Hub.php`
7. `app/Http/Controllers/HubSelectionController.php`
8. `app/Http/Middleware/EnsureHubSelected.php`
9. `resources/views/hub-selection/index.blade.php`

### File yang Dimodifikasi:
1. `app/Models/User.php`
   - Tambah fillable: selected_city_id, selected_hub_id
   - Tambah method: needsHubSelection(), hasSelectedHub()
   - Tambah relasi: selectedCity(), selectedHub()

2. `app/Http/Controllers/Auth/LoginController.php`
   - Update redirectAfterLogin() untuk redirect ke hub selection

3. `routes/web.php`
   - Tambah route group hub-selection

4. `app/Http/Kernel.php`
   - Register middleware EnsureHubSelected di web middleware group
   - Tambah alias 'hub.selected'

---

## ✅ VERIFIKASI DATABASE

```bash
# Cek data cities dan hubs
php artisan tinker --execute="
    echo 'Cities: ' . \App\Models\City::count() . PHP_EOL;
    echo 'Hubs: ' . \App\Models\Hub::count() . PHP_EOL;
    echo 'Users (admin/hr/audit): ' . \App\Models\User::whereHas('role', function(\$q) { 
        \$q->whereIn('code', ['super_admin', 'hr', 'audit']); 
    })->count() . PHP_EOL;
"

# Output:
# Cities: 5
# Hubs: 14
# Users (admin/hr/audit): 3
```

---

## 🔐 SECURITY & VALIDATION

### Backend Validation:
- City ID wajib ada dan valid (exists in cities table)
- Hub ID wajib ada dan valid (exists in hubs table)
- Hub harus milik city yang dipilih
- Hub dan city harus berstatus 'active'

### Middleware Protection:
- User harus authenticated (auth middleware)
- Role-based access (hanya admin/hr/audit yang perlu pilih hub)
- Automatic redirect jika belum pilih hub

### Audit Trail:
- Setiap hub selection dicatat di log dengan info:
  - user_id, username, city_id, hub_id, hub_code, IP address

---

## 🎨 UI/UX FEATURES

1. **Progress Stepper**: Visual indicator 3 langkah
2. **Real-time Selection**: Card selection dengan visual feedback
3. **Dynamic Hub Loading**: AJAX load hubs saat city dipilih
4. **Responsive Design**: Mobile-friendly layout
5. **Hover Effects**: Card hover animation
6. **Selected State**: Border highlight untuk item terpilih
7. **Form Validation**: Disable submit button sampai semua dipilih
8. **Info Display**: Tampilkan summary pilihan sebelum submit

---

## 🛠️ COMMAND YANG DIJALANKAN

```bash
# 1. Create migrations
php artisan make:migration create_cities_table
php artisan make:migration create_hubs_table
php artisan make:migration add_selected_hub_to_users_table

# 2. Create models
php artisan make:model City
php artisan make:model Hub

# 3. Create controller
php artisan make:controller HubSelectionController

# 4. Create middleware
php artisan make:middleware EnsureHubSelected

# 5. Create seeder
php artisan make:seeder CitiesAndHubsSeeder

# 6. Run migrations
php artisan migrate

# 7. Run seeder
php artisan db:seed --class=CitiesAndHubsSeeder

# 8. Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🎯 HASIL AKHIR

✅ **Migration**: 3 migration berhasil dijalankan
✅ **Seeder**: 5 cities dan 14 hubs berhasil di-seed
✅ **Models**: City, Hub, dan User model dengan relasi lengkap
✅ **Controller**: HubSelectionController dengan 3 method
✅ **Middleware**: EnsureHubSelected terintegrasi di web middleware group
✅ **Routes**: 3 route terdaftar untuk hub selection
✅ **View**: Halaman hub selection responsive dengan JavaScript interactivity
✅ **Security**: Validation, middleware protection, dan audit trail

---

## 📌 CATATAN PENTING

1. **Role yang Wajib Pilih Hub**: 
   - super_admin
   - hr
   - audit

2. **Role yang TIDAK Perlu Pilih Hub**:
   - kepala_gudang
   - pegawai

3. **Middleware Auto-Protection**:
   - Middleware EnsureHubSelected sudah ditambahkan ke web middleware group
   - Semua route authenticated otomatis terlindungi
   - Tidak perlu manual tambah middleware di setiap route

4. **Session Persistence**:
   - Pilihan hub tersimpan di database (users.selected_city_id & selected_hub_id)
   - User tidak perlu pilih ulang setiap login
   - Pilihan hub bisa diubah kapan saja (perlu tambahan fitur nanti)

---

## 🔜 FUTURE ENHANCEMENT (Opsional)

1. **Change Hub Feature**: Fitur untuk ganti hub dari dashboard
2. **Hub Statistics**: Dashboard per-hub statistics
3. **Multi-Hub Access**: User bisa akses multiple hubs
4. **Hub Permissions**: Permission berbeda per hub
5. **Hub Activity Log**: Track user activity per hub

---

## 📞 TROUBLESHOOTING

### Issue: Redirect loop ke hub-selection
**Solusi**: Pastikan route hub-selection tidak di-exclude di middleware

### Issue: Hubs tidak muncul saat pilih city
**Solusi**: Cek JavaScript console, pastikan AJAX endpoint benar

### Issue: Submit button tidak aktif
**Solusi**: Pastikan city dan hub sudah dipilih, cek JavaScript selectHub()

### Issue: Error 404 di hub-selection
**Solusi**: Jalankan `php artisan route:clear`

---

**Implementasi Selesai!** ✨
Sistem pemilihan hub untuk role admin, hr, dan audit telah berhasil diimplementasikan sesuai dengan design Pemilihan_Hub.png.
