<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= BASE_URL ?>Public/Assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <?php
                $inisial = strtoupper(substr($nama_lengkap, 0, 1));
            ?>
            <div class="image">
                <span class="img-circle elevation-2 text-light" style="display: flex; align-items: center; justify-content: center; width: 2.1rem; height: 2.1rem"><?= $inisial ?></span>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $nama_lengkap ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>dashboard" class="nav-link <?= ($_SESSION['active_page'] ?? '') === 'dashboard' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <?php if ($role === 'admin') : ?>
                    <li class="nav-item <?= is_active_page_group('user') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= is_active_page_group('user') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                User Manajemen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>user" class="nav-link <?= is_active_menu('user') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data User</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>profile" class="nav-link <?= is_active_menu('profile') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Profile User</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item <?= is_active_page_group(['loker', 'penitipan']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= is_active_page_group(['loker', 'penitipan']) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Loker
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if ($role === 'admin') : ?>
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>loker" class="nav-link <?= is_active_menu('loker') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Loker</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>penitipan" class="nav-link <?= is_active_menu('penitipan') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Penitipan</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
