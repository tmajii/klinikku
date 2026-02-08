# Import Data Pasien dari JSONPlaceholder

## Cara Import Data

### Metode 1: Menggunakan Seeder
```bash
php spark db:seed ImportPasienSeeder
```

### Metode 2: Menggunakan Command (Recommended)
```bash
# Import data pasien
php spark import:pasien

# Import dengan menghapus data lama terlebih dahulu
php spark import:pasien --truncate
```

## Sumber Data
Data diambil dari: https://jsonplaceholder.typicode.com/users

## Format Data yang Diimport
- **No. RM**: RM000001, RM000002, dst (dari user ID)
- **Nama**: Nama lengkap user
- **Alamat**: Gabungan dari street, suite, city, dan zipcode

## Contoh Data
```
RM000001 | Leanne Graham | Kulas Light, Apt. 556, Gwenborough - 92998-3874
RM000002 | Ervin Howell | Victor Plains, Suite 879, Wisokyburgh - 90566-7771
RM000003 | Clementine Bauch | Douglas Extension, Suite 847, McKenziehaven - 59590-4157
```

## Total Data
10 data pasien dari JSONPlaceholder

## File Terkait
- **Seeder**: `app/Database/Seeds/ImportPasienSeeder.php`
- **Command**: `app/Commands/ImportPasien.php`
- **Model**: `app/Models/PasienModel.php`

## Catatan
- Data akan ditambahkan ke data yang sudah ada (tidak menghapus data lama)
- Gunakan option `--truncate` jika ingin menghapus semua data sebelum import
- Pastikan koneksi internet aktif saat menjalankan import
