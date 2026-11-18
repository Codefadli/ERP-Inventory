Anda bertindak sebagai Senior Laravel Backend Developer sekaligus Software Tester. Tugas Anda adalah memeriksa, mengimplementasikan, mengintegrasikan, dan menguji backend pada proyek ERP-Inventory 
Fokus pengerjaan hanya pada tiga modul berikut:

1. Dashboard untuk seluruh role.
2. Manajemen Pengguna khusus Super Admin.
3. Pengaturan untuk seluruh role.
Jangan langsung menulis kode sebelum memahami struktur proyek. Baca implementasi yang sudah ada, lalu lanjutkan dengan perubahan sekecil dan setepat mungkin agar fitur baru tetap kompatibel dengan sistem yang berjalan.
A. ATURAN UTAMA PENGERJAAN
1. Jadikan source code proyek sebagai sumber kebenaran utama. Jangan mengarang struktur tabel, nama kolom, route, permission, model, atau proses bisnis yang tidak ada.
2. Periksa composer.json, routes/web.php, routes/api.php, seluruh controller, middleware, model, Form Request, migration, seeder, Blade, JavaScript, dan test yang berkaitan.
3. Pertahankan teknologi dan pola proyek yang sudah digunakan. Proyek menggunakan Laravel 10, PHP 8.1+, Blade, Eloquent ORM, session authentication untuk web, dan Laravel Sanctum untuk API sesuai implementasi yang tersedia.
4. Pertahankan desain UI, layout, warna, komponen, navigasi, dan interaksi frontend yang sudah ada. Ubah frontend hanya jika diperlukan untuk menghubungkan fitur ke backend.
5. Semua tombol yang mengklaim menyimpan, mengubah, menghapus, mengekspor, mencadangkan, atau menjalankan proses harus benar-benar terhubung ke backend. Hapus perilaku simulasi seperti notifikasi sukses palsu.
6. Jangan menampilkan pesan berhasil sebelum backend benar-benar berhasil menyelesaikan proses.
7. Jangan menghapus fitur lama yang masih digunakan. Jangan mengubah modul lain di luar cakupan kecuali memang menjadi dependensi langsung dan perubahan tersebut diperlukan.
8. Jangan membuat data statistik, histori, aktivitas, konfigurasi, atau akun palsu untuk menggantikan data database.
9. Gunakan validasi server-side melalui Form Request atau pola validasi yang konsisten dengan proyek.
10. Gunakan transaksi database (DB::transaction) untuk proses yang melibatkan beberapa perubahan data yang harus konsisten.
11. Terapkan otorisasi di backend. Menyembunyikan tombol di Blade saja tidak cukup.
12. Lindungi data sensitif. Jangan mengirim password, token, hash, secret API, atau informasi keamanan ke response yang tidak berwenang.
13. Jangan menampilkan atau menyalin isi rahasia dari .env. Jangan mengubah kredensial tanpa alasan dan persetujuan.
14. Jika ada kebutuhan yang tidak didukung struktur database saat ini, jelaskan sebagai gap. Buat migration baru hanya jika benar-benar diperlukan dan sesuai ruang lingkup.
15. Jangan mengklaim testing berhasil jika perintah atau skenario tersebut belum benar-benar dijalankan.
Aturan khusus penamaan route Kepala Gudang
Seluruh route web yang ditujukan untuk role Kepala Gudang wajib menggunakan prefix URL kepalagudang, bukan gudang.

Contoh pola URL:
- /kepalagudang/dashboard
- /kepalagudang/pengaturan
- /kepalagudang/... untuk seluruh halaman web Kepala Gudang lainnya.
Nama route Laravel juga harus konsisten menggunakan prefix kepalagudang., misalnya:
- kepalagudang.dashboard
- kepalagudang.pengaturan
Periksa dan sesuaikan semua deklarasi route, pemanggilan route() di Blade/controller, redirect setelah login, navigasi/sidebar, breadcrumb, link, dan test yang merujuk route Kepala Gudang.

Catatan penting:
- Prefix URL dan nama route untuk Kepala Gudang adalah kepalagudang.
- Jangan otomatis mengganti identifier role database/middleware kepala_gudang menjadi kepalagudang. Pertahankan identifier role yang benar-benar digunakan oleh model, database, seeder, dan middleware, kecuali hasil pemeriksaan membuktikan identifier role juga memang perlu diubah.
- Jangan mengubah route role lain.
- Pastikan tidak ada route web Kepala Gudang yang masih memakai prefix URL atau nama route gudang. setelah pengerjaan.
- Periksa juga apakah ada API route yang memang khusus Kepala Gudang. Jika ada, sesuaikan secara konsisten tanpa mengubah endpoint API milik role lain.
B. KONDISI AWAL PROYEK YANG WAJIB DIVERIFIKASI
Informasi berikut merupakan petunjuk awal dari struktur proyek. Verifikasi kembali langsung ke file sebelum melakukan perubahan.
1. Dashboard
- View dashboard bersama berada di resources/views/dashboard/index.blade.php.
- Blade menggunakan pemeriksaan role pengguna, antara lain isSuperAdmin(), isKepalaGudang(), isHR(), isPegawai(), dan isAuditor().
- Dashboard role diarahkan melalui route web masing-masing.
- Pada implementasi awal, route dashboard mengembalikan view secara langsung dan belum tentu mengambil statistik dari database melalui controller khusus.
- Periksa apakah dashboard menampilkan angka, grafik, tabel aktivitas, stok kritis, antrean persetujuan, dan informasi lain yang masih berupa nilai statis.
2. Manajemen Pengguna
- View awal berada di resources/views/dashboard/superadmin/manajemenPengguna.blade.php.
- Halaman ditujukan untuk Super Admin.
- UI memiliki tabel pengguna, pencarian, filter, pagination, tombol tambah pengguna, edit, riwayat aktivitas, tindakan massal, ekspor, serta bagian RBAC/kebijakan keamanan.
- Pada implementasi awal, beberapa interaksi JavaScript hanya menampilkan toast atau simulasi dan belum melakukan request ke backend.
- Periksa route admin.pengguna, middleware role/permission, model User, model Role, model Permission, relasi, migration, dan seeder sebelum membuat CRUD.
- Jangan menganggap seluruh tombol UI sudah mempunyai fungsi backend.
3. Pengaturan
- Controller awal berada di app/Http/Controllers/PengaturanController.php.
- View bersama berada di resources/views/dashboard/pengaturan.blade.php.
- Controller awal memiliki method index() yang mengembalikan view pengaturan.
- View mempunyai konten berbeda berdasarkan role dan enam kelompok tab utama: Umum/Profil Hub, Aturan Inventaris & Stok, Perangkat & Printer Barcode, Integrasi ERP & API, Keamanan & Kebijakan Sesi, serta Backup & Pemulihan.
- Pada implementasi awal, beberapa tombol seperti Simpan, Reset, Test Print, Backup, dan aksi lain hanya memunculkan notifikasi JavaScript. Verifikasi setiap tombol dan jangan menganggap proses tersebut telah tersimpan atau benar-benar berjalan.
- Jangan mengklaim integrasi SAP, AWS S3, printer, webhook, Redis, atau layanan eksternal aktif jika konfigurasi dan integrasinya tidak tersedia di proyek.
4. Role yang menjadi acuan
Gunakan role aktual yang ditemukan pada model, migration, dan seeder. Petunjuk role proyek:
- super_admin
- kepala_gudang
- hr
- pegawai
- audit
Verifikasi ejaan, slug, relasi, dan permission aktual. Jangan membuat role baru hanya karena label UI menyebut nama lain.
C. MODUL 1: BACKEND DASHBOARD (ALL ROLE)
Tujuan
Membuat dashboard yang mengambil data aktual dari database dan menampilkan informasi sesuai role pengguna yang sedang login. Satu view bersama boleh tetap digunakan jika sesuai arsitektur proyek, tetapi pengambilan data harus terstruktur dan tidak mencampurkan data yang tidak boleh dilihat role lain.
Role yang harus didukung
1. Super Admin.
2. Kepala Gudang.
3. HR.
4. Pegawai.
5. Auditor.
Tahapan implementasi
1. Audit dashboard saat ini
- Baca seluruh resources/views/dashboard/index.blade.php.
- Inventarisasi semua kartu statistik, angka, grafik, tabel, daftar aktivitas, status, dan tombol.
- Catat bagian yang statis, hard-coded, menggunakan data dummy, atau belum mempunyai sumber data.
- Petakan setiap komponen dashboard ke tabel/model yang benar-benar tersedia.
- Periksa route dashboard untuk setiap role dan alur redirect setelah login.
- Pastikan route Kepala Gudang menggunakan /kepalagudang/dashboard dan nama route kepalagudang.dashboard.
2. Buat pengambilan data dashboard
- Gunakan controller khusus dashboard atau service class jika sesuai pola proyek.
- Hindari menaruh query database yang kompleks langsung di Blade.
- Gunakan Eloquent relationship, eager loading, agregasi, dan query yang efisien.
- Terapkan filter berdasarkan hub/kota yang dipilih pengguna jika struktur data dan aturan akses proyek mendukungnya.
- Pastikan pengguna tidak dapat melihat data hub lain tanpa hak akses.
- Terapkan rentang waktu untuk statistik jika komponen UI membutuhkan filter periode.
- Gunakan pagination untuk daftar aktivitas yang panjang.
- Tangani kondisi data kosong dengan tampilan empty state, bukan angka rekaan.
3. Isi dashboard berdasarkan role
Pertahankan tujuan konten yang telah dirancang pada view. Cocokkan setiap elemen dengan sumber data aktual.
A. Super Admin
- Ringkasan operasional yang memang didukung database.
- Ringkasan pengguna dan status akun jika tersedia.
- Ringkasan data inventaris yang tersedia.
- Informasi stok kritis hanya jika data stok aktual tersedia.
- Aktivitas sistem dari sumber log yang benar-benar digunakan.
- Ringkasan persetujuan hanya jika tabel dan proses persetujuannya tersedia.
- Informasi lintas hub hanya jika Super Admin memang berwenang melihatnya.
B. Kepala Gudang
- Ringkasan operasional hub yang dipilih.
- Data barang dan master data yang relevan.
- Ringkasan stok hanya jika jumlah stok aktual tersedia.
- Barang masuk/keluar hanya jika tabel dan proses transaksinya tersedia.
- Aktivitas operasional hub jika sumber pencatatannya tersedia.
- Persetujuan gudang hanya jika proses dan tabel persetujuan tersedia.
C. HR
- Antrean persetujuan hanya jika tabel/proses persetujuan tersedia.
- Ringkasan aktivitas yang memang dapat diakses HR.
- Data kepatuhan atau rekonsiliasi hanya jika sumber datanya tersedia.
- Jangan membuat angka SLA, jumlah approval, atau temuan fiktif.
D. Pegawai
- Informasi operasional yang relevan dengan akun dan hub pegawai.
- Data tugas/aktivitas hanya jika modul dan tabel tugas tersedia.
- Informasi barang atau lokasi sesuai permission.
- Jangan menampilkan data administrasi seluruh pengguna.
E. Auditor
- Informasi audit dari sumber log yang benar-benar tersedia.
- Riwayat aktivitas yang dapat diakses auditor.
- Temuan, jadwal audit, dan akurasi rekonsiliasi hanya jika tabel dan prosesnya tersedia.
- Jangan mengarang data temuan atau jadwal audit.
4. Data yang belum tersedia
Jika UI meminta data yang belum memiliki tabel/model/proses backend:
- Jangan membuat nilai dummy.
- Jangan mengambil angka dari teks statis di Blade sebagai data aktual.
- Tandai komponen sebagai belum didukung backend.
- Laporkan kebutuhan tabel, relasi, atau modul transaksi yang harus dibuat pada tahap terpisah.
- Jangan membangun sistem transaksi inventaris baru di luar ruang lingkup ini tanpa menjelaskan dan meminta persetujuan.
5. Output Dashboard
- Dashboard menampilkan data aktual sesuai role.
- Query tidak membocorkan data lintas role/hub.
- Semua route dashboard dapat diakses role yang sesuai.
- Dashboard memiliki loading/empty/error state yang wajar.
- Statistik konsisten dengan query database.
- UI yang sudah ada tetap dipertahankan.
D. MODUL 2: MANAJEMEN PENGGUNA (KHUSUS SUPER ADMIN)
Tujuan
Mengubah halaman Manajemen Pengguna dari antarmuka yang sebagian masih simulasi menjadi fitur backend yang benar-benar terhubung dengan database, dengan pembatasan akses khusus Super Admin.
1. Audit sebelum implementasi
Periksa:
- resources/views/dashboard/superadmin/manajemenPengguna.blade.php.
- routes/web.php dan routes/api.php.
- app/Models/User.php.
- Model Role dan Permission yang benar-benar tersedia.
- Relasi User, Role, Permission, City, Hub, Division, dan Session.
- Migration terkait users, roles, permissions, role_permissions, cities, hubs, divisions, user_sessions, dan audit log.
- Seeder role dan pengguna.
- Middleware auth, role, dan permission.
- Seluruh form, modal, tombol, filter, pencarian, pagination, dan JavaScript.
Buat matriks kesenjangan UI dengan backend sebelum mulai coding.
2. Otorisasi
- Halaman dan seluruh endpoint Manajemen Pengguna hanya dapat diakses Super Admin yang memiliki permission pengelolaan pengguna sesuai pola proyek.
- Terapkan middleware pada route dan Policy/Gate atau pemeriksaan permission pada operasi sensitif.
- Jangan hanya menyembunyikan menu dari role lain.
- Pengguna tidak boleh mengubah role atau permission dirinya sendiri jika hal tersebut dapat menyebabkan eskalasi hak akses, kecuali ada aturan eksplisit yang aman di proyek.
- Cegah Super Admin terakhir/nonaktif terakhir terhapus atau kehilangan akses jika kebijakan tersebut diperlukan oleh sistem.
- Pastikan pengguna tidak dapat memanipulasi ID akun untuk mengubah akun yang tidak berhak diubah.
3. Fitur yang perlu diimplementasikan
Implementasikan fitur berikut sesuai elemen yang benar-benar tersedia pada UI dan struktur database.
A. Daftar pengguna
- Ambil data dari tabel/model User.
- Tampilkan kolom yang memang tersedia, misalnya nama, username/NIK, email, role, divisi, hub, status, dan aktivitas terakhir jika datanya tersedia.
- Jangan menampilkan password/hash/token.
- Gunakan pagination server-side.
- Gunakan eager loading untuk relasi yang diperlukan.
- Sediakan sorting yang aman dengan whitelist kolom.
B. Pencarian dan filter
- Pencarian nama, username/NIK, atau email berdasarkan kolom aktual.
- Filter role berdasarkan data role aktual.
- Filter divisi jika relasi dan kolom tersedia.
- Filter status sesuai definisi status pada database.
- Filter hub sesuai relasi yang tersedia.
- Filter harus bekerja di server, bukan hanya menyembunyikan baris HTML.
- Parameter filter harus divalidasi dan tidak boleh menjadi raw SQL.
- Tombol reset mengembalikan filter ke kondisi awal.
C. Tambah pengguna
- Form mengirim data ke endpoint backend.
- Validasi nama, username/NIK, email, password atau mekanisme undangan sesuai struktur aplikasi.
- Validasi keunikan identifier berdasarkan kolom dan aturan database.
- Validasi role, divisi, kota, dan hub terhadap data yang benar-benar tersedia.
- Password harus di-hash menggunakan mekanisme Laravel.
- Jangan menyimpan password mentah.
- Jangan mengirim undangan email jika konfigurasi mail belum tersedia. Jika belum tersedia, tampilkan status yang jujur atau catat sebagai pekerjaan lanjutan.
- Gunakan transaksi database jika pembuatan akun melibatkan relasi atau tabel tambahan.
D. Edit pengguna
- Ambil data akun berdasarkan ID yang valid.
- Validasi setiap field yang dapat diubah.
- Periksa keunikan email/username/NIK saat update dengan mengecualikan akun yang sedang diedit.
- Validasi perubahan role dan relasi hub/divisi.
- Lindungi perubahan permission sensitif.
- Jangan mengubah password jika kolom password dibiarkan kosong.
- Catat perubahan penting jika mekanisme audit tersedia.
E. Aktif/nonaktif akun
- Implementasikan sesuai kolom status yang benar-benar ada.
- Jangan mengasumsikan nilai status sebelum memeriksa migration dan model.
- Akun nonaktif tidak boleh login jika aturan autentikasi proyek memang menggunakan status tersebut. Integrasikan secara konsisten dengan LoginController.
- Berikan konfirmasi sebelum perubahan status.
- Catat pelaku, target, waktu, dan perubahan jika audit log tersedia.
F. Riwayat aktivitas pengguna
- Gunakan sumber aktivitas yang benar-benar tersedia, misalnya user_sessions, Laravel log, atau tabel audit yang sudah diimplementasikan.
- Jangan menampilkan riwayat palsu.
- Jangan mengklaim audit_logs aktif jika belum ada proses pencatatannya.
- Jika sumber audit belum tersedia, jelaskan gap dan usulkan implementasi pencatatan yang sesuai.
G. Tindakan massal
- Implementasikan hanya tindakan yang aman dan memang disediakan UI.
- Validasi daftar ID di server.
- Pastikan seluruh target berada dalam cakupan kewenangan Super Admin.
- Gunakan transaksi database.
- Cegah tindakan massal yang dapat menonaktifkan atau menghapus seluruh akun administrator.
- Tampilkan ringkasan hasil berhasil/gagal per akun.
H. Ekspor data
- Ekspor harus mengambil data database dengan filter yang sedang aktif.
- Jangan mengekspor password, token, hash, atau data sensitif.
- Gunakan format yang sudah didukung proyek atau library yang sudah terpasang.
- Jika library ekspor belum tersedia, jangan mengklaim ekspor Excel berfungsi. Jelaskan dependensi dan pilihan implementasinya.
I. Role dan permission
- Gunakan tabel roles, permissions, dan role_permissions yang sudah ada.
- Jangan membuat label role baru yang tidak ada di database.
- Jangan mengubah skema RBAC tanpa kebutuhan dan penjelasan.
- Jika UI menyediakan halaman konfigurasi role tetapi belum ada backend, laporkan sebagai gap terpisah. Jangan membuat perubahan permission bebas tanpa aturan keamanan.
4. Validasi dan keamanan
- Gunakan Form Request untuk create/update jika sesuai pola proyek.
- Gunakan CSRF protection untuk form web.
- Gunakan authorization pada setiap operasi.
- Gunakan mass assignment secara aman melalui $fillable atau mekanisme yang sesuai.
- Gunakan soft delete hanya jika migration dan kebutuhan proyek mendukungnya.
- Jangan melakukan hard delete akun jika data historis/relasinya harus dipertahankan.
- Tangani constraint foreign key dan akun yang masih memiliki relasi.
- Berikan response dan pesan error yang informatif tanpa membocorkan detail internal.
5. Output Manajemen Pengguna
- Daftar pengguna berasal dari database.
- Search, filter, sorting, dan pagination berfungsi.
- Tambah, edit, dan perubahan status benar-benar tersimpan.
- Riwayat aktivitas hanya menampilkan sumber data yang nyata.
- Ekspor berfungsi atau secara eksplisit dinyatakan belum tersedia karena dependensi.
- Seluruh endpoint dilindungi otorisasi Super Admin.
- Tidak ada toast sukses palsu.
E. MODUL 3: PENGATURAN (ALL ROLE)
Tujuan
Menghubungkan halaman Pengaturan ke backend sehingga nilai konfigurasi yang diizinkan dapat dibaca, divalidasi, disimpan, di-reset, dan dicatat secara benar. Konten dan hak edit harus menyesuaikan role.
1. Audit halaman dan konfigurasi
Periksa:
- app/Http/Controllers/PengaturanController.php.
- resources/views/dashboard/pengaturan.blade.php.
- Route pengaturan untuk semua role.
- Seluruh input, select, checkbox, toggle, slider, tab, modal, tombol simpan/reset, test print, backup, restore, dan log perubahan.
- Tabel dan model konfigurasi yang sudah ada. Jangan menganggap tabel settings tersedia sebelum memeriksa migration.
- Mekanisme audit log yang benar-benar digunakan.
2. Role dan route
Pengaturan tersedia bagi:
- Super Admin.
- Kepala Gudang.
- HR.
- Pegawai.
- Auditor.
Pastikan seluruh route Kepala Gudang menggunakan prefix URL /kepalagudang dan nama route kepalagudang.*.

Route pengaturan role lain harus mengikuti prefix dan nama route yang benar-benar dipakai proyek.
3. Enam kelompok pengaturan
Pertahankan enam kelompok/tab yang sudah ada di UI. Petakan setiap field ke konfigurasi backend yang nyata.
A. Umum dan Profil Hub
- Identitas sistem/hub.
- Profil hub operasional.
- Parameter umum yang memang tersedia.
- Pastikan data hub mengikuti hak akses dan hub yang dipilih.
- Jangan izinkan role biasa mengubah identitas global sistem jika bukan kewenangannya.
B. Aturan Inventaris dan Stok
- Reorder point.
- Safety stock.
- Parameter stok lain yang memang digunakan sistem.
- Batch, ED, satuan, dan aturan barang jika didukung model/database.
- Validasi angka, batas minimum/maksimum, dan konsistensi satuan.
- Jangan mengklaim parameter memengaruhi perhitungan stok jika proses bisnisnya belum menggunakannya.
C. Perangkat dan Printer Barcode
- Konfigurasi printer/scanner hanya jika ada mekanisme backend atau integrasi yang tersedia.
- Simpan identitas/perangkat yang memang perlu disimpan.
- Fitur test print harus benar-benar memanggil integrasi yang terkonfigurasi.
- Jika tidak ada driver, service, atau integrasi perangkat, tandai sebagai belum tersedia. Jangan menampilkan pesan seolah cetak berhasil.
D. Integrasi ERP dan API
- Simpan konfigurasi endpoint dan status integrasi yang memang diperlukan.
- Secret/API key harus dienkripsi atau disimpan melalui mekanisme aman yang sesuai.
- Jangan mengembalikan secret penuh ke frontend setelah disimpan.
- Jangan membuat koneksi SAP, webhook, atau API eksternal tanpa endpoint, kredensial, dan persetujuan yang valid.
- Fitur test connection harus benar-benar menguji koneksi dan melaporkan hasil aktual.
E. Keamanan dan Kebijakan Sesi
- Hubungkan ke mekanisme autentikasi/session yang sudah ada jika memungkinkan.
- Validasi durasi sesi, kebijakan password, batas login, atau pengaturan keamanan sesuai dukungan sistem.
- Jangan membuat konfigurasi yang hanya tersimpan tetapi tidak pernah dipakai middleware/controller.
- Perubahan kebijakan keamanan harus memiliki otorisasi yang sesuai.
- Jangan mengizinkan role biasa mengubah kebijakan global keamanan.
F. Backup dan Pemulihan
- Periksa apakah proyek sudah memiliki sistem backup, scheduler, storage disk, atau integrasi penyimpanan.
- Jika belum ada, jangan menampilkan notifikasi backup berhasil.
- Implementasikan hanya sesuai infrastruktur yang tersedia dan ruang lingkup yang disetujui.
- Backup dan restore harus dibatasi untuk role berwenang.
- Restore harus memiliki konfirmasi kuat, validasi file, dan pencatatan aktivitas.
- Jangan mengirim atau menyimpan arsip database di lokasi publik.
4. Hak akses konfigurasi per role
Buat matriks permission berdasarkan role aktual dan kebutuhan yang ditemukan dari UI. Jangan mengarang kewenangan. Gunakan prinsip least privilege.

Petunjuk pengelompokan UI awal:
- Super Admin: pengaturan sistem dan konfigurasi global yang memang menjadi kewenangannya.
- Kepala Gudang: pengaturan operasional gudang/hub yang menjadi cakupannya.
- HR: pengaturan proses persetujuan atau konfigurasi HR yang memang didukung sistem.
- Pegawai: preferensi perangkat/terminal pribadi jika didukung sistem.
- Auditor: preferensi dan parameter audit yang memang menjadi kewenangannya.
Untuk setiap field, tentukan:
1. Role yang boleh melihat.
2. Role yang boleh mengubah.
3. Apakah konfigurasi berlaku global, per kota, per hub, atau per pengguna.
4. Sumber data dan tempat penyimpanan.
5. Validasi dan dampak perubahan.
Jangan menggunakan satu endpoint update tanpa pembatasan field. Pengguna tidak boleh mengirim field milik role lain melalui manipulasi request.
5. Penyimpanan konfigurasi
- Tentukan apakah tabel konfigurasi sudah tersedia.
- Jika belum, rancang migration yang sederhana dan konsisten dengan pola proyek setelah menjelaskan kebutuhan.
- Tentukan scope konfigurasi: global, city, hub, atau user.
- Gunakan key/value atau struktur relasional sesuai kebutuhan nyata, bukan sekadar memilih pola secara asal.
- Validasi tipe data dan nilai konfigurasi.
- Gunakan transaksi saat menyimpan beberapa konfigurasi sekaligus.
- Simpan metadata pembuat/perubah jika skema mendukung.
- Terapkan enkripsi untuk secret.
- Buat mekanisme cache hanya jika diperlukan dan pastikan cache dihapus saat konfigurasi berubah.
6. Simpan, reset, log, dan aksi khusus
Simpan
- Tombol Simpan mengirim data ke backend.
- Backend memeriksa role, permission, scope, dan validasi.
- Backend menyimpan perubahan.
- Backend mengembalikan nilai terbaru.
- UI menampilkan pesan sukses hanya setelah proses berhasil.
Reset
- Reset harus mengembalikan konfigurasi ke default yang ditetapkan secara eksplisit.
- Minta konfirmasi sebelum reset.
- Jangan menghapus konfigurasi global atau konfigurasi role lain tanpa hak akses.
- Catat perubahan jika audit tersedia.
Log perubahan
- Tampilkan perubahan yang benar-benar tercatat.
- Catat aktor, waktu, key konfigurasi, nilai sebelum/sesudah yang aman, dan scope jika mekanisme audit tersedia.
- Jangan mencatat secret secara plaintext.
Test Print, Test Connection, Backup, Restore
- Hubungkan hanya jika integrasi teknis benar-benar tersedia.
- Jika belum tersedia, nonaktifkan atau tampilkan status belum dikonfigurasi.
- Jangan memberikan toast sukses palsu.
7. Output Pengaturan
- Semua role dapat membuka halaman Pengaturan sesuai route masing-masing.
- Tiap role hanya melihat/mengubah konfigurasi yang diizinkan.
- Nilai yang ditampilkan berasal dari backend/database atau sumber konfigurasi yang jelas.
- Simpan dan reset benar-benar bekerja.
- Log perubahan berdasarkan data nyata.
- Integrasi eksternal hanya dinyatakan aktif setelah diuji.
F. ROUTING, CONTROLLER, MODEL, DAN API
1. Periksa seluruh route yang sudah ada sebelum menambah route baru.
2. Hindari route duplikat dan nama route yang bertabrakan.
3. Gunakan route name yang konsisten.
4. Untuk halaman web, pertahankan session authentication dan CSRF protection.
5. Untuk endpoint API, gunakan auth:sanctum sesuai arsitektur proyek.
6. Tambahkan middleware role/permission yang sesuai untuk setiap endpoint.
7. Jangan memindahkan seluruh proses web ke API jika tidak diperlukan.
8. Pisahkan tanggung jawab controller, service, request validation, model, dan policy secara wajar.
9. Gunakan HTTP method yang tepat: GET untuk membaca, POST untuk membuat/aksi, PUT/PATCH untuk memperbarui, DELETE untuk menghapus.
10. Gunakan status code dan format response yang konsisten.
11. Pastikan route model binding tidak memungkinkan akses lintas akun/hub tanpa izin.
12. Perbarui redirect login dan navigasi berdasarkan nama route baru Kepala Gudang.
G. DATABASE DAN MIGRATION
1. Audit semua migration yang sudah ada sebelum membuat migration baru.
2. Cocokkan nama kolom dengan model dan Form Request.
3. Pastikan foreign key dan relasi sesuai.
4. Jangan menghapus atau mengganti nama kolom lama tanpa memeriksa dampaknya ke modul lain.
5. Gunakan migration baru untuk perubahan skema. Jangan mengedit migration lama yang sudah mungkin diterapkan di lingkungan lain, kecuali proyek secara eksplisit masih dalam tahap awal dan perubahan disepakati.
6. Buat seeder hanya untuk data referensi yang memang diperlukan.
7. Jangan memasukkan akun atau password produksi.
8. Pastikan DatabaseSeeder memanggil seeder yang memang dibutuhkan, tetapi jangan mengubah data seeder yang tidak terkait.
9. Uji migration pada database testing atau database lokal terpisah. Jangan menjalankan migrate:fresh pada database yang berisi data penting.
H. TESTING WAJIB
Lakukan testing nyata setelah implementasi. Gunakan PHPUnit/Pest sesuai framework yang tersedia di proyek.
1. Testing Dashboard
- Setiap role yang valid dapat membuka dashboard masing-masing.
- Pengguna yang belum login ditolak atau diarahkan ke login.
- Role yang salah tidak dapat membuka dashboard role lain.
- Kepala Gudang menggunakan URL /kepalagudang/dashboard dan route name kepalagudang.dashboard.
- Data statistik sesuai query database.
- Data kosong tidak menghasilkan error.
- Pembatasan hub berjalan.
- Tidak ada data sensitif yang bocor ke role lain.
2. Testing Manajemen Pengguna
- Super Admin dengan permission yang benar dapat membuka halaman.
- Role lain menerima 403 atau ditolak sesuai pola proyek.
- Daftar pengguna tampil dari database.
- Search, filter, sorting, dan pagination bekerja.
- Tambah pengguna berhasil dengan data valid.
- Tambah pengguna gagal dengan email/username/NIK duplikat.
- Validasi field wajib berjalan.
- Password tersimpan dalam bentuk hash.
- Edit pengguna berhasil.
- Edit dengan ID yang tidak ada ditangani dengan benar.
- Pengguna tidak dapat mengubah akun di luar kewenangannya.
- Status aktif/nonaktif tersimpan dan berpengaruh sesuai aturan login.
- Tindakan massal hanya memproses ID yang valid dan diizinkan.
- Ekspor tidak menyertakan password/hash/token.
- Riwayat aktivitas tidak menampilkan data fiktif.
3. Testing Pengaturan
- Kelima role dapat membuka halaman pengaturan masing-masing.
- Kepala Gudang menggunakan URL /kepalagudang/pengaturan dan route name kepalagudang.pengaturan.
- Setiap role hanya dapat melihat/mengubah field yang diizinkan.
- Request manipulasi field role lain ditolak.
- Nilai valid tersimpan dan dapat dibaca kembali.
- Nilai tidak valid ditolak.
- Reset bekerja sesuai default yang ditetapkan.
- Secret tidak dikembalikan secara terbuka.
- Test print/connection/backup/restore tidak mengklaim berhasil jika integrasi tidak tersedia.
- Log perubahan sesuai aktivitas nyata.
4. Testing keamanan dan regresi
- CSRF untuk form web.
- Authentication dan authorization.
- Mass assignment.
- Validasi ID dan foreign key.
- SQL injection melalui parameter pencarian/filter.
- XSS pada data pengguna/konfigurasi yang ditampilkan.
- Kebocoran data antar-role dan antar-hub.
- Route name dan URL tidak duplikat.
- Navigasi/sidebar tidak menghasilkan route not found.
- Fitur login, pemilihan hub, profil, dan sesi yang sudah ada tetap berjalan.
5. Perintah pemeriksaan
Jalankan perintah yang sesuai dengan kondisi proyek, misalnya:
php artisan route:list
php artisan route:list --path=kepalagudang
php artisan migrate:status
php artisan test
Jalankan juga pemeriksaan syntax PHP dan format/static analysis jika tool tersebut tersedia. Jangan mengarang output perintah. Jika environment, database, atau layanan eksternal belum tersedia, catat dengan jelas dan berikan langkah untuk menjalankannya.
I. DOKUMENTASI HASIL AKHIR
Setelah implementasi dan testing selesai, buat dokumentasi Markdown yang berisi:
1. Ringkasan kondisi awal proyek.
2. Daftar file yang diperiksa.
3. Daftar file yang dibuat/diubah.
4. Penjelasan arsitektur backend setiap modul.
5. Diagram alur Dashboard.
6. Diagram alur Manajemen Pengguna.
7. Diagram alur Pengaturan.
8. Tabel route lengkap per role, termasuk HTTP method, URL, route name, controller/action, middleware, dan fungsi.
9. Matriks role-permission.
10. Hubungan model dan tabel database.
11. Penjelasan validasi dan keamanan.
12. Daftar fitur yang berhasil diimplementasikan.
13. Daftar fitur yang belum dapat diimplementasikan karena keterbatasan source/infrastruktur.
14. Hasil testing: nama skenario, hasil aktual, status PASS/FAIL/BLOCKED, dan bukti/perintah yang dijalankan.
15. Bug yang ditemukan dan perbaikannya.
16. Risiko atau pekerjaan lanjutan.
17. Summary alur backend dari request pengguna sampai response.
Sediakan diagram menggunakan Mermaid jika dokumentasi Markdown mendukungnya.
J. KRITERIA SELESAI (DEFINITION OF DONE)
Pekerjaan dianggap selesai hanya jika:
- Dashboard untuk lima role mengambil data aktual yang tersedia dan menerapkan pembatasan akses.
- Manajemen Pengguna benar-benar terhubung dengan database dan seluruh operasi yang ditampilkan telah diimplementasikan atau secara jelas ditandai belum tersedia.
- Pengaturan benar-benar menyimpan konfigurasi yang didukung proyek, dengan hak akses per role.
- Tidak ada notifikasi sukses palsu.
- Semua route Kepala Gudang menggunakan prefix URL kepalagudang dan route name kepalagudang.*.
- Identifier role database tetap konsisten dengan source proyek.
- Seluruh route dan navigasi telah diperiksa.
- Migration aman dan dapat dijalankan.
- Test otomatis dan pengujian manual telah dijalankan sejauh environment memungkinkan.
- Tidak ada regresi pada login, pemilihan hub, profil, atau sesi pengguna.
- Dokumentasi hasil akhir lengkap dan sesuai implementasi aktual.
Instruksi penutup
Kerjakan secara bertahap. Mulai dari audit source code dan buat daftar temuan serta rencana perubahan. Setelah itu implementasikan Dashboard, Manajemen Pengguna, lalu Pengaturan. Jalankan testing setiap modul sebelum melanjutkan ke modul berikutnya.

Jangan berhenti pada analisis atau contoh kode. Lakukan perubahan langsung pada proyek, integrasikan frontend dengan backend, uji hasilnya, dan berikan ringkasan file yang berubah serta bukti pengujian.

Jika ada kebutuhan yang tidak didukung oleh source code atau infrastruktur, jangan menutupinya dengan data dummy atau simulasi. Jelaskan keterbatasannya dan pisahkan dari fitur yang benar-benar sudah selesai.