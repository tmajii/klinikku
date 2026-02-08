<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= session()->get('full_name') ?></a>
                <small class="text-muted"><?= ucfirst(session()->get('role_name')) ?></small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url() ?>" class="nav-link spa-link" data-title="Dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <?php if (can_view('pasien')): ?>
                <li class="nav-header">MASTER DATA</li>
                <li class="nav-item">
                    <a href="<?= base_url('pasien') ?>" class="nav-link spa-link" data-title="Data Pasien">
                        <i class="nav-icon fas fa-user-injured"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if (can_view('pendaftaran') || can_view('kunjungan') || can_view('asesmen') || can_view('diagnosa')): ?>
                <li class="nav-header">TRANSAKSI</li>
                <?php endif; ?>
                
                <?php if (can_view('pendaftaran')): ?>
                <li class="nav-item">
                    <a href="<?= base_url('pendaftaran') ?>" class="nav-link spa-link" data-title="Pendaftaran">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Pendaftaran</p>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if (can_view('kunjungan')): ?>
                <li class="nav-item">
                    <a href="<?= base_url('kunjungan') ?>" class="nav-link spa-link" data-title="Kunjungan">
                        <i class="nav-icon fas fa-hospital-user"></i>
                        <p>Kunjungan</p>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if (can_view('asesmen')): ?>
                <li class="nav-item">
                    <a href="<?= base_url('asesmen') ?>" class="nav-link spa-link" data-title="Asesmen">
                        <i class="nav-icon fas fa-notes-medical"></i>
                        <p>Asesmen</p>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if (can_view('diagnosa')): ?>
                <li class="nav-item">
                    <a href="<?= base_url('diagnosa') ?>" class="nav-link spa-link" data-title="Diagnosa">
                        <i class="nav-icon fas fa-stethoscope"></i>
                        <p>Diagnosa</p>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if (can_view('users')): ?>
                <li class="nav-header">PENGATURAN</li>
                <li class="nav-item">
                    <a href="<?= base_url('users') ?>" class="nav-link spa-link" data-title="Manajemen User">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Manajemen User</p>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
