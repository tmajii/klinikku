<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah User</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('users/store') ?>" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" class="form-control" required>
                            <option value="">Pilih Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= ucfirst($role['role_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                            <label class="custom-control-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('users') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
