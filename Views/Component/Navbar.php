<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header text-capitalize"><?= $role ?></span>

                <div class="dropdown-divider"></div>

                <a href="<?= BASE_URL ?>profile" class="dropdown-item">
                    Profile
                </a>

                <div class="dropdown-divider"></div>
                <a href="<?= BASE_URL ?>logout" class="dropdown-item dropdown-footer">
                    <i class="fas fa-door-open"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
