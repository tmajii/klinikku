<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Diagnosa
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Diagnosa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('diagnosa') ?>">Diagnosa</a></li>
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
                <form action="<?= base_url('diagnosa/store') ?>" method="post">
                    <div class="form-group">
                        <label>Pilih Asesmen Pasien</label>
                        <select name="asesmenid" class="form-control" required>
                            <option value="">Pilih Asesmen</option>
                            <?php foreach ($asesmen as $a): ?>
                                <option value="<?= $a['id'] ?>">
                                    <?= $a['noregistrasi'] ?> - <?= $a['norm'] ?> - <?= $a['nama'] ?> 
                                    (<?= date('d/m/Y', strtotime($a['tglkunjungan'])) ?>) - <?= substr($a['keluhan_utama'], 0, 30) ?>...
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kode ICD</label>
                        <input type="text" name="kode_icd" class="form-control" placeholder="Contoh: A00.0">
                        <small class="text-muted">Opsional - Kode ICD-10</small>
                    </div>
                    <div class="form-group">
                        <label>Nama Diagnosa <span class="text-danger">*</span></label>
                        <input type="text" name="nama_diagnosa" class="form-control" required placeholder="Contoh: Demam Berdarah Dengue">
                    </div>
                    <div class="form-group">
                        <label>Jenis Diagnosa <span class="text-danger">*</span></label>
                        <select name="jenis_diagnosa" class="form-control" required>
                            <option value="primer">Primer (Diagnosa Utama)</option>
                            <option value="sekunder">Sekunder (Diagnosa Tambahan)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('diagnosa') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
