# 🌐 CARA AKSES APLIKASI ERP-INVENTORY

**Tanggal**: 2026-11-05  
**Status**: Aplikasi siap digunakan

---

## ✅ OPSI 1: Melalui XAMPP Apache (URL Lengkap)

Karena project berada di `C:\xampp\htdocs\ERP-Inventory`, gunakan URL lengkap:

### Login Page:
```
http://localhost/ERP-Inventory/public/login
```

### Homepage (akan redirect ke login):
```
http://localhost/ERP-Inventory/public/
```

### Dashboard Admin:
```
http://localhost/ERP-Inventory/public/admin/dashboard
```

**Kelebihan:**
- ✅ Tidak perlu jalankan command
- ✅ Selalu aktif selama XAMPP running

**Kekurangan:**
- ⚠️ URL panjang
- ⚠️ Harus include `/public/`

---

## ✅ OPSI 2: Melalui Laravel Development Server (RECOMMENDED)

Jalankan Laravel built-in server:

```bash
cd C:\xampp\htdocs\ERP-Inventory
php artisan serve
```

Atau dengan custom host/port:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Akses dengan URL Simple:

**Login Page:**
```
http://127.0.0.1:8000/login
```

**Homepage:**
```
http://127.0.0.1:8000/
```

**Dashboard Admin:**
```
http://127.0.0.1:8000/admin/dashboard
```

**Kelebihan:**
- ✅ URL lebih simple (tidak perlu `/public/`)
- ✅ Lebih cepat untuk development
- ✅ Hot reload jika ada perubahan code

**Kekurangan:**
- ⚠️ Harus jalankan command setiap kali
- ⚠️ Akan stop jika terminal ditutup

---

## ✅ OPSI 3: Setup Virtual Host (Advanced)

File virtual host sudah dibuat di:
```
C:\xampp\apache\conf\extra\erp-inventory-vhost.conf
```

### Langkah Setup:

#### 1. Edit httpd.conf
Buka: `C:\xampp\apache\conf\httpd.conf`

Cari baris:
```apache
# Virtual hosts
#Include conf/extra/httpd-vhosts.conf
```

Tambahkan di bawahnya:
```apache
Include conf/extra/erp-inventory-vhost.conf
```

#### 2. Edit Hosts File (Run as Administrator)
Buka: `C:\Windows\System32\drivers\etc\hosts`

Tambahkan:
```
127.0.0.1    erp-inventory.test
```

#### 3. Restart Apache
Di XAMPP Control Panel, klik "Stop" lalu "Start" pada Apache

#### 4. Akses dengan URL Custom
```
http://erp-inventory.test/login
```

**Kelebihan:**
- ✅ URL paling simple
- ✅ Mirip production environment
- ✅ Tidak perlu `/public/` di URL

**Kekurangan:**
- ⚠️ Setup agak kompleks
- ⚠️ Perlu restart Apache

---

## 🔐 KREDENSIAL LOGIN

Setelah bisa akses halaman login, gunakan:

**Super Admin:**
- Email: `superadmin@astro.com`
- Password: `password123`

**HR Manager:**
- Email: `hr.manager@astro.com`
- Password: `password123`

**Auditor:**
- Email: `auditor@astro.com`
- Password: `password123`

**Kepala Gudang:**
- Email: `kepala.gudang@astro.com`
- Password: `password123`

**Pegawai:**
- Email: `pegawai1@astro.com` atau `pegawai2@astro.com`
- Password: `password123`

---

## 📋 FLOW SETELAH LOGIN

### Untuk Super Admin / HR / Auditor:
1. Login berhasil
2. Redirect ke **Hub Selection** (`/hub-selection`)
3. Pilih Kota (Jakarta, Bandung, Surabaya, Semarang, atau Medan)
4. Pilih Hub sesuai kota
5. Klik "Lanjutkan ke Dashboard"
6. Masuk ke Dashboard sesuai role

### Untuk Kepala Gudang / Pegawai:
1. Login berhasil
2. Langsung ke Dashboard (bypass hub selection)

---

## ⚠️ TROUBLESHOOTING

### Problem: "404 Not Found"
**Penyebab:** URL salah atau mod_rewrite tidak aktif

**Solusi:**
1. Pastikan URL include `/public/`: 
   ```
   http://localhost/ERP-Inventory/public/login
   ```
2. Atau gunakan `php artisan serve`

### Problem: "500 Internal Server Error"
**Penyebab:** Permissions atau .env issue

**Solusi:**
```bash
cd C:\xampp\htdocs\ERP-Inventory
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Problem: "Connection Refused"
**Penyebab:** Apache/Server tidak running

**Solusi:**
1. Buka XAMPP Control Panel
2. Start Apache
3. Atau gunakan: `php artisan serve`

---

## 🎯 REKOMENDASI

### Untuk Development (Sekarang):
**Gunakan OPSI 2** - Laravel Development Server
```bash
php artisan serve
```
Akses: `http://127.0.0.1:8000/login`

### Untuk Production (Nanti):
**Setup Virtual Host** atau deploy ke server dengan nginx/Apache proper

---

## 📝 QUICK START (Copy-Paste)

```bash
# 1. Masuk ke folder project
cd C:\xampp\htdocs\ERP-Inventory

# 2. Clear cache
php artisan config:clear && php artisan route:clear && php artisan view:clear

# 3. Jalankan server
php artisan serve

# 4. Buka browser:
# http://127.0.0.1:8000/login

# 5. Login dengan:
# Email: superadmin@astro.com
# Password: password123
```

---

**Status:** ✅ Aplikasi siap digunakan  
**Recommended URL:** `http://127.0.0.1:8000/login` (setelah jalankan `php artisan serve`)  
**Alternative URL:** `http://localhost/ERP-Inventory/public/login` (via XAMPP)
