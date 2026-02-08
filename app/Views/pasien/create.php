<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Pasien</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('pasien') ?>">Pasien</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('pasien/store') ?>" method="post">
                    <div class="form-group">
                        <label>No. RM</label>
                        <input type="text" name="norm" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('pasien') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
