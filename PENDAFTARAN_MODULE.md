# Modul Pendaftaran

## Fitur Lengkap
✅ DataTable dengan client-side processing  
✅ Modal CRUD (Create, Read, Update, Delete)  
✅ SweetAlert2 untuk validasi dan feedback  
✅ PDF Export (Individual & Rekap)  
✅ SPA Navigation (tanpa reload halaman)  
✅ Validasi form required fields  
✅ Relasi dengan tabel Pasien  

## Struktur Database
**Tabel**: `pendaftaran`
- `id` (INT, Primary Key)
- `pasienid` (INT, Foreign Key ke tabel pasien)
- `noregistrasi` (VARCHAR 50, Unique)
- `tglregistrasi` (DATE)
- `created_at` (DATETIME)
- `updated_at` (DATETIME)

## Endpoint API

### DataTable
```
POST /pendaftaran/datatable
```
Response: JSON dengan data pendaftaran + join pasien (norm, nama)

### Get Single Record
```
GET /pendaftaran/get/{id}
```

### Get Pasien List (untuk dropdown)
```
GET /pendaftaran/get-pasien-list
```

### Save (Create/Update)
```
POST /pendaftaran/save
Body: id (optional), noregistrasi, pasienid, tglregistrasi
```

### Delete
```
POST /pendaftaran/delete/{id}
```

### PDF Individual
```
GET /pendaftaran/pdf/{id}
```
Output: Bukti pendaftaran pasien (Portrait A4)

### PDF Rekap
```
GET /pendaftaran/pdf-rekap
```
Output: Rekap semua pendaftaran (Landscape A4)

## File Terkait

### Controller
- `app/Controllers/PendaftaranController.php`

### Model
- `app/Models/PendaftaranModel.php`

### Views
- `app/Views/pendaftaran/index.php` (Full page)
- `app/Views/pendaftaran/index_content.php` (AJAX content)
- `app/Views/pendaftaran/pdf.php` (PDF individual)
- `app/Views/pendaftaran/pdf_rekap.php` (PDF rekap)

### Migration
- `app/Database/Migrations/2026-02-08-090002_CreatePendaftaranTable.php`

### Seeder
- `app/Database/Seeds/PendaftaranSeeder.php`

## Cara Generate Dummy Data
```bash
php spark db:seed PendaftaranSeeder
```
Akan membuat 15 data pendaftaran dengan tanggal bervariasi (7 hari ke belakang sampai 7 hari ke depan)

## Fitur Khusus

### 1. Auto-fill Tanggal
Saat membuka modal tambah, tanggal registrasi otomatis diisi dengan tanggal hari ini

### 2. Dropdown Pasien
Dropdown pasien menampilkan format: `{No. RM} - {Nama Pasien}`

### 3. Status di PDF Rekap
- **Hari Ini**: Pendaftaran dengan tanggal hari ini (hijau)
- **Akan Datang**: Pendaftaran dengan tanggal di masa depan (biru)
- **Selesai**: Pendaftaran dengan tanggal di masa lalu (abu-abu)

### 4. Validasi
- No. Registrasi: Required, min 3 karakter
- Pasien: Required, harus dipilih dari dropdown
- Tanggal Registrasi: Required, format date valid

## Integrasi dengan Modul Lain
- **Pasien**: Foreign key ke tabel pasien
- **Kunjungan**: Pendaftaran bisa dijadikan dasar untuk kunjungan
- **User**: Tracking siapa yang input/cetak (dari session)

## Contoh Data
```
REG202602080001 | RM000001 - Leanne Graham | 02/02/2026
REG202602080002 | RM000002 - Ervin Howell | 09/02/2026
REG202602080003 | RM000006 - Mrs. Dennis Schulist | 04/02/2026
```
