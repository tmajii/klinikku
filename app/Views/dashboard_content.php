<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Welcome Message -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info-circle"></i> Selamat Datang, <?= session()->get('full_name') ?>!</h5>
                    Anda login sebagai <strong><?= ucfirst(session()->get('role_name')) ?></strong>. 
                    Sistem Informasi Klinik siap digunakan.
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row">
            <?php if (can_view('pasien')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $total_pasien ?></h3>
                        <p>Total Pasien</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <a href="<?= base_url('pasien') ?>" class="small-box-footer spa-link" data-title="Data Pasien">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (can_view('pendaftaran')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $total_pendaftaran ?></h3>
                        <p>Total Pendaftaran</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <a href="<?= base_url('pendaftaran') ?>" class="small-box-footer spa-link" data-title="Pendaftaran">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (can_view('kunjungan')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $total_kunjungan ?></h3>
                        <p>Total Kunjungan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hospital-user"></i>
                    </div>
                    <a href="<?= base_url('kunjungan') ?>" class="small-box-footer spa-link" data-title="Kunjungan">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (can_view('asesmen')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $total_asesmen ?></h3>
                        <p>Total Asesmen</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-notes-medical"></i>
                    </div>
                    <a href="<?= base_url('asesmen') ?>" class="small-box-footer spa-link" data-title="Asesmen">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Second Row Statistics -->
        <div class="row">
            <?php if (can_view('diagnosa')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= $total_diagnosa ?></h3>
                        <p>Total Diagnosa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <a href="<?= base_url('diagnosa') ?>" class="small-box-footer spa-link" data-title="Diagnosa">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (can_view('users')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?= $total_users ?></h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= base_url('users') ?>" class="small-box-footer spa-link" data-title="Manajemen User">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Recent Data Tables -->
        <div class="row">
            <!-- Recent Pasien -->
            <?php if (can_view('pasien') && !empty($recent_pasien)): ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-user-injured mr-1"></i>
                            Pasien Terbaru
                        </h3>
                        <div class="card-tools">
                            <a href="<?= base_url('pasien') ?>" class="btn btn-sm btn-primary spa-link" data-title="Data Pasien">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No. RM</th>
                                    <th>Nama</th>
                                    <th>Tgl. Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_pasien as $p): ?>
                                <tr>
                                    <td><?= $p['norm'] ?></td>
                                    <td><?= $p['nama'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Recent Pendaftaran -->
            <?php if (can_view('pendaftaran') && !empty($recent_pendaftaran)): ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list mr-1"></i>
                            Pendaftaran Terbaru
                        </h3>
                        <div class="card-tools">
                            <a href="<?= base_url('pendaftaran') ?>" class="btn btn-sm btn-success spa-link" data-title="Pendaftaran">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No. Reg</th>
                                    <th>Pasien</th>
                                    <th>Tgl. Registrasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_pendaftaran as $p): ?>
                                <tr>
                                    <td><?= $p['noregistrasi'] ?></td>
                                    <td><?= $p['nama'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($p['tglregistrasi'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Recent Kunjungan -->
        <?php if (can_view('kunjungan') && !empty($recent_kunjungan)): ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-hospital-user mr-1"></i>
                            Kunjungan Terbaru
                        </h3>
                        <div class="card-tools">
                            <a href="<?= base_url('kunjungan') ?>" class="btn btn-sm btn-warning spa-link" data-title="Kunjungan">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No. Reg</th>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Jenis Kunjungan</th>
                                    <th>Tgl. Kunjungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_kunjungan as $k): ?>
                                <tr>
                                    <td><?= $k['noregistrasi'] ?></td>
                                    <td><?= $k['norm'] ?></td>
                                    <td><?= $k['nama'] ?></td>
                                    <td>
                                        <span class="badge badge-info"><?= $k['jeniskunjungan'] ?></span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($k['tglkunjungan'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Info Box for Empty Data -->
        <?php if ($total_pasien == 0 && $total_pendaftaran == 0): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Belum Ada Data</h5>
                    Sistem belum memiliki data. Silakan jalankan seeder untuk mengisi data dummy:
                    <br><br>
                    <code>php spark db:seed TestDataSeeder</code>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
