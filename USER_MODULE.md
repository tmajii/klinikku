# Modul Manajemen User

## Deskripsi
Modul untuk mengelola user/pengguna sistem klinik dengan fitur CRUD lengkap dan role-based access.

## Fitur
- Tambah user baru dengan role
- Edit data user
- Hapus user (dengan proteksi tidak bisa hapus diri sendiri)
- Lihat daftar user dengan role
- Status aktif/non-aktif user
- Password hashing untuk keamanan

## Struktur Database

### Tabel: users
- id (PK)
- username
- email
- password (hashed)
- full_name
- role_id (FK ke roles)
- is_active (1=aktif, 0=tidak aktif)
- last_login
- created_at
- updated_at

### Tabel: roles
- id (PK)
- role_name
- description
- created_at
- updated_at

## Role Default
1. Admin - Administrator dengan akses penuh
2. Dokter - Dokter yang menangani pasien
3. Perawat - Perawat yang membantu dokter
4. Resepsionis - Staff pendaftaran dan administrasi

## User Default (Seeder)
- Username: admin, Password: admin123, Role: Admin
- Username: dokter1, Password: dokter123, Role: Dokter
- Username: perawat1, Password: perawat123, Role: Perawat
- Username: resepsionis1, Password: resepsionis123, Role: Resepsionis

## Endpoint API

### GET /users
Menampilkan halaman index user

### POST /users/datatable
Mengambil data user untuk DataTable (AJAX)

### GET /users/get/{id}
Mengambil detail user berdasarkan ID

### GET /users/get-roles
Mengambil daftar semua role

### POST /users/save
Menyimpan user baru atau update user existing
- Validasi: username (min 3 char), email (valid), full_name (min 3 char), role_id (required)
- Password required untuk user baru, optional untuk update

### POST /users/delete/{id}
Menghapus user berdasarkan ID
- Proteksi: tidak bisa hapus diri sendiri

## Cara Menggunakan

### 1. Jalankan Migration
```bash
php spark migrate
```

### 2. Jalankan Seeder
```bash
php spark db:seed RoleSeeder
php spark db:seed UserSeeder
```

Atau jalankan semua seeder sekaligus:
```bash
php spark db:seed TestDataSeeder
```

### 3. Login
Gunakan salah satu user default untuk login ke sistem.

### 4. Akses Menu User
Klik menu "Manajemen User" di sidebar untuk mengelola user.

## Fitur Keamanan
- Password di-hash menggunakan PASSWORD_DEFAULT
- Validasi input di server-side
- Proteksi hapus diri sendiri
- Auth filter untuk semua endpoint

## Catatan
- Password tidak ditampilkan saat edit user
- Jika password dikosongkan saat edit, password lama tetap digunakan
- Status user bisa diubah menjadi tidak aktif tanpa menghapus data
