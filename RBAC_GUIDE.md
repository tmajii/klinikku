# Role-Based Access Control (RBAC) Guide

## Daftar Role

### 1. Superadmin (role_id = 1)
**Akses:** Penuh ke semua fitur sistem

**Hak Akses:**
- ✅ CRUD Data Pasien
- ✅ CRUD Pendaftaran
- ✅ CRUD Kunjungan
- ✅ CRUD Asesmen
- ✅ CRUD Diagnosa
- ✅ CRUD Manajemen User

**User Default:**
- Username: `superadmin`
- Password: `admin123`
- Email: superadmin@klinik.com

---

### 2. Admisi (role_id = 2)
**Akses:** Hanya bisa CRUD Pendaftaran dan Kunjungan, tidak bisa lihat Asesmen dan Data Pasien

**Hak Akses:**
- ❌ Tidak bisa akses Data Pasien
- ✅ CRUD Pendaftaran
- ✅ CRUD Kunjungan
- ❌ Tidak bisa akses Asesmen
- ❌ Tidak bisa akses Diagnosa
- ❌ Tidak bisa akses Manajemen User

**User Default:**
- Username: `admisi`
- Password: `admisi123`
- Email: admisi@klinik.com

---

### 3. Perawat (role_id = 3)
**Akses:** Hanya bisa view Pendaftaran dan Kunjungan, bisa CRUD Asesmen dan Diagnosis, tidak bisa akses Data Pasien

**Hak Akses:**
- ❌ Tidak bisa akses Data Pasien
- 👁️ View Only Pendaftaran (tidak bisa tambah/edit/hapus)
- 👁️ View Only Kunjungan (tidak bisa tambah/edit/hapus)
- ✅ CRUD Asesmen
- ✅ CRUD Diagnosa
- ❌ Tidak bisa akses Manajemen User

**User Default:**
- Username: `perawat`
- Password: `perawat123`
- Email: perawat@klinik.com

---

## Implementasi Teknis

### 1. Helper Functions

File: `app/Helpers/permission_helper.php`

```php
// Cek akses ke modul
can_access($module, $action = 'view')

// Shortcut functions
can_view($module)
can_create($module)
can_edit($module)
can_delete($module)

// Cek role
is_superadmin()
is_admisi()
is_perawat()
```

### 2. Penggunaan di View

**Menyembunyikan Menu di Sidebar:**
```php
<?php if (can_view('asesmen')): ?>
<li class="nav-item">
    <a href="<?= base_url('asesmen') ?>" class="nav-link">
        <i class="nav-icon fas fa-notes-medical"></i>
        <p>Asesmen</p>
    </a>
</li>
<?php endif; ?>
```

**Menyembunyikan Tombol Tambah:**
```php
<?php if (can_create('pendaftaran')): ?>
<button type="button" class="btn btn-primary" onclick="addPendaftaran()">
    <i class="fas fa-plus"></i> Tambah Pendaftaran
</button>
<?php endif; ?>
```

**Menyembunyikan Tombol Edit/Delete:**
```javascript
render: function(data, type, row) {
    let buttons = `
        <button class="btn btn-sm btn-info" onclick="print(${row.id})">
            <i class="fas fa-print"></i>
        </button>
    `;
    
    <?php if (can_edit('pendaftaran')): ?>
    buttons += `
        <button class="btn btn-sm btn-warning" onclick="edit(${row.id})">
            <i class="fas fa-edit"></i>
        </button>
    `;
    <?php endif; ?>
    
    <?php if (can_delete('pendaftaran')): ?>
    buttons += `
        <button class="btn btn-sm btn-danger" onclick="delete(${row.id})">
            <i class="fas fa-trash"></i>
        </button>
    `;
    <?php endif; ?>
    
    return buttons;
}
```

### 3. Filter di Routes (Opsional)

Untuk keamanan tambahan, bisa menambahkan filter permission di routes:

```php
$routes->get('/asesmen', 'AsesmenController::index', [
    'filter' => 'auth',
    'filter' => 'permission:asesmen,view'
]);
```

---

## Matrix Hak Akses

| Modul | Superadmin | Admisi | Perawat |
|-------|-----------|--------|---------|
| **Data Pasien** |
| - View | ✅ | ❌ | ❌ |
| - Create | ✅ | ❌ | ❌ |
| - Edit | ✅ | ❌ | ❌ |
| - Delete | ✅ | ❌ | ❌ |
| **Pendaftaran** |
| - View | ✅ | ✅ | ✅ |
| - Create | ✅ | ✅ | ❌ |
| - Edit | ✅ | ✅ | ❌ |
| - Delete | ✅ | ✅ | ❌ |
| **Kunjungan** |
| - View | ✅ | ✅ | ✅ |
| - Create | ✅ | ✅ | ❌ |
| - Edit | ✅ | ✅ | ❌ |
| - Delete | ✅ | ✅ | ❌ |
| **Asesmen** |
| - View | ✅ | ❌ | ✅ |
| - Create | ✅ | ❌ | ✅ |
| - Edit | ✅ | ❌ | ✅ |
| - Delete | ✅ | ❌ | ✅ |
| **Diagnosa** |
| - View | ✅ | ❌ | ✅ |
| - Create | ✅ | ❌ | ✅ |
| - Edit | ✅ | ❌ | ✅ |
| - Delete | ✅ | ❌ | ✅ |
| **Manajemen User** |
| - View | ✅ | ❌ | ❌ |
| - Create | ✅ | ❌ | ❌ |
| - Edit | ✅ | ❌ | ❌ |
| - Delete | ✅ | ❌ | ❌ |

---

## Testing

### Test Superadmin
1. Login dengan username: `superadmin`, password: `admin123`
2. Verifikasi semua menu muncul di sidebar
3. Verifikasi semua tombol CRUD tersedia

### Test Admisi
1. Login dengan username: `admisi`, password: `admisi123`
2. Verifikasi menu yang muncul: Dashboard, Pendaftaran, Kunjungan
3. Verifikasi menu yang TIDAK muncul: Data Pasien, Asesmen, Diagnosa, Manajemen User
4. Verifikasi tombol tambah/edit/hapus tersedia di Pendaftaran dan Kunjungan

### Test Perawat
1. Login dengan username: `perawat`, password: `perawat123`
2. Verifikasi menu yang muncul: Dashboard, Pendaftaran, Kunjungan, Asesmen, Diagnosa
3. Verifikasi menu yang TIDAK muncul: Data Pasien, Manajemen User
4. Verifikasi tombol tambah/edit/hapus TIDAK tersedia di Pendaftaran dan Kunjungan
5. Verifikasi tombol tambah/edit/hapus tersedia di Asesmen dan Diagnosa

---

## Troubleshooting

### Menu tidak muncul sesuai role
- Pastikan helper `permission_helper.php` sudah di-autoload di `Config/Autoload.php`
- Cek session `role_id` sudah tersimpan saat login
- Clear cache browser dan reload halaman

### Tombol masih muncul padahal tidak punya akses
- Pastikan kondisi `<?php if (can_xxx()): ?>` sudah diterapkan di view
- Cek JavaScript render function sudah menggunakan PHP conditional

### Error saat akses halaman
- Pastikan PermissionFilter sudah terdaftar di `Config/Filters.php`
- Cek routes sudah menggunakan filter yang benar
