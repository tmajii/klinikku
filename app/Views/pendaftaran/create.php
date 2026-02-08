<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Pendaftaran
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Pendaftaran</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('pendaftaran/store') ?>" method="post">
                    <div class="form-group">
                        <label>Pasien</label>
                        <select name="pasienid" class="form-control" required>
                            <option value="">Pilih Pasien</option>
                            <?php foreach ($pasien as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= $p['norm'] ?> - <?= $p['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>No. Registrasi</label>
                        <input type="text" name="noregistrasi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Registrasi</label>
                        <input type="date" name="tglregistrasi" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('pendaftaran') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
