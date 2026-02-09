<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= view('dashboard_content', [
    'total_pasien' => $total_pasien ?? 0,
    'total_pendaftaran' => $total_pendaftaran ?? 0,
    'total_kunjungan' => $total_kunjungan ?? 0,
    'total_asesmen' => $total_asesmen ?? 0,
    'total_diagnosa' => $total_diagnosa ?? 0,
    'total_users' => $total_users ?? 0,
    'recent_pasien' => $recent_pasien ?? [],
    'recent_pendaftaran' => $recent_pendaftaran ?? [],
    'recent_kunjungan' => $recent_kunjungan ?? []
]) ?>
<?= $this->endSection() ?>
