# Modul Kunjungan

## Fitur Lengkap
✅ DataTable dengan client-side processing  
✅ Modal CRUD (Create, Read, Update, Delete)  
✅ SweetAlert2 untuk validasi dan feedback  
✅ PDF Export (Individual & Rekap)  
✅ SPA Navigation (tanpa reload halaman)  
✅ Validasi form required fields  
✅ Relasi dengan tabel Pendaftaran dan Pasien  
✅ Badge warna untuk jenis kunjungan  

## Struktur Database
**Tabel**: `kunjungan`
- `id` (INT, Primary Key)
- `pendaftaranpasienid` (INT, Foreign Key ke tabel pendaftaran)
- `jeniskunjungan` (VARCHAR 100)
- `tglkunjungan` (DATE)
- `created_at` (DATETIME)
- `updated_at` (DATETIME)

## Jenis Kunjungan
1. **Rawat Jalan** (Badge hijau)
2. **Rawat Inap** (Badge biru)
3. **IGD** (Badge merah)
4. **Kontrol** (Badge kuning)
5. **Konsultasi** (Badge info)

## Endpoint API

### DataTable
```
POST /kunjungan/datatable
```
Response: JSON dengan data kunjungan + join pendaftaran + join pasien

### Get Single Record
```
GET /kunjungan/get/{id}
```

### Get Pendaftaran List (untuk dropdown)
```
GET /kunjungan/get-pendaftaran-list
```
Response: List pendaftaran dengan format: No. Reg - No. RM - Nama Pasien

### Save (Create/Update)
```
POST /kunjungan/save
Body: id (optional), pendaftaranpasienid, jeniskunjungan, tglkunjungan
```

### Delete
```
POST /kunjungan/delete/{id}
```

### PDF Individual
```
GET /kunjungan/pdf/{id}
```
Output: Bukti kunjungan pasien (Portrait A4)

### PDF Rekap
```
GET /kunjungan/pdf-rekap
```
Output: Rekap semua kunjungan dengan badge warna (Landscape A4)

## File Terkait

### Controller
- `app/Controllers/KunjunganController.php`

### Model
- `app/Models/KunjunganModel.php`

### Views
- `app/Views/kunjungan/index.php` (Full page)
- `app/Views/kunjungan/index_content.php` (AJAX content)
- `app/Views/kunjungan/pdf.php` (PDF individual)
- `app/Views/kunjungan/pdf_rekap.php` (PDF rekap)

### Migration
- `app/Database/Migrations/2026-02-08-090003_CreateKunjunganTable.php`

### Seeder
- `app/Database/Seeds/KunjunganSeeder.php`

## Cara Generate Dummy Data
```bash
php spark db:seed KunjunganSeeder
```
Akan membuat 20 data kunjungan dengan:
- Jenis kunjungan random
- Tanggal bervariasi (10 hari ke belakang sampai 5 hari ke depan)

## Fitur Khusus

### 1. Auto-fill Tanggal
Saat membuka modal tambah, tanggal kunjungan otomatis diisi dengan tanggal hari ini

### 2. Dropdown Pendaftaran
Dropdown menampilkan format: `{No. Registrasi} - {No. RM} - {Nama Pasien}`
Contoh: `REG202602080001 - RM000001 - Leanne Graham`

### 3. Badge Warna di PDF Rekap
Setiap jenis kunjungan memiliki warna badge berbeda:
- Rawat Jalan: Hijau (#28a745)
- Rawat Inap: Biru (#007bff)
- IGD: Merah (#dc3545)
- Kontrol: Kuning (#ffc107)
- Konsultasi: Info (#17a2b8)

### 4. Status Kunjungan di PDF Rekap
- **Hari Ini**: Kunjungan dengan tanggal hari ini (hijau)
- **Akan Datang**: Kunjungan dengan tanggal di masa depan (biru)
- **Selesai**: Kunjungan dengan tanggal di masa lalu (abu-abu)

### 5. Validasi
- Pendaftaran: Required, harus dipilih dari dropdown
- Jenis Kunjungan: Required, harus dipilih dari dropdown
- Tanggal Kunjungan: Required, format date valid

## Relasi Database
```
kunjungan.pendaftaranpasienid → pendaftaran.id
pendaftaran.pasienid → pasien.id
```

Dengan relasi ini, kunjungan bisa menampilkan:
- Data pendaftaran (No. Registrasi, Tanggal Registrasi)
- Data pasien (No. RM, Nama, Alamat)

## Integrasi dengan Modul Lain
- **Pendaftaran**: Foreign key ke tabel pendaftaran
- **Pasien**: Indirect relation melalui pendaftaran
- **Asesmen**: Kunjungan bisa dijadikan dasar untuk asesmen
- **User**: Tracking siapa yang input/cetak (dari session)

## Contoh Data
```
REG202602080001 | RM000001 - Leanne Graham | Rawat Jalan | 03/02/2026
REG202602080002 | RM000002 - Ervin Howell | IGD | 11/02/2026
REG202602080003 | RM000006 - Mrs. Dennis | Konsultasi | 02/02/2026
```

## Flow Proses
1. Pasien terdaftar di sistem (tabel `pasien`)
2. Pasien melakukan pendaftaran (tabel `pendaftaran`)
3. Pasien melakukan kunjungan berdasarkan pendaftaran (tabel `kunjungan`)
4. Kunjungan bisa dilanjutkan dengan asesmen dan diagnosa

## Catatan Penting
- Satu pendaftaran bisa memiliki banyak kunjungan
- Dropdown pendaftaran menampilkan semua pendaftaran yang ada
- Pastikan data pendaftaran sudah ada sebelum membuat kunjungan
- PDF individual menampilkan detail lengkap kunjungan + data pasien
- PDF rekap menampilkan semua kunjungan dalam format tabel
