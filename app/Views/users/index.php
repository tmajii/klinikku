<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Manajemen User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="<?= base_url('users/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>
                
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $key => $user): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['full_name'] ?></td>
                                <td><span class="badge badge-info"><?= ucfirst($user['role_name']) ?></span></td>
                                <td>
                                    <?php if ($user['is_active']): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : '-' ?></td>
                                <td>
                                    <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($user['id'] != session()->get('user_id')): ?>
                                        <a href="<?= base_url('users/delete/' . $user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
