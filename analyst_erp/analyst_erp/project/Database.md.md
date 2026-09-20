# Database

## Purpose

Database digunakan untuk menyimpan seluruh data utama yang digunakan
oleh sistem ERP.

---

## Entities

### Users

Menyimpan data pengguna sistem.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| name | varchar | Nama pengguna |
| email | varchar | Email pengguna |
| password | varchar | Password terenkripsi |
| role | enum | admin / customer |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diperbarui |

---

### Products

Menyimpan data produk.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| name | varchar | Nama produk |
| description | text | Deskripsi produk |
| price | decimal | Harga produk |
| stock | integer | Jumlah stok |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diperbarui |

---

### Orders

Menyimpan data pesanan.

| Field | Type | Description |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint | User pemesan |
| total | decimal | Total pesanan |
| status | varchar | Status pesanan |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diperbarui |

---

## Relationships

users
  │
  └── orders

orders
  │
  └── order_items

products
  │
  └── order_items

---

## Database Rules

1. Setiap tabel harus memiliki primary key.
2. Foreign key harus memiliki referensi yang jelas.
3. Nama tabel dan field harus konsisten.
4. Data sensitif tidak boleh disimpan dalam bentuk plaintext.
5. Struktur database harus terdokumentasi sebelum implementasi.