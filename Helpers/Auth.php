<?php

if (session_start() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in()
{
    return isset($_SESSION['user']);
}

function require_login()
{
    require_once __DIR__ . '/../Config/Config.php';
    if (!is_logged_in()) {
        header("Location: " . BASE_URL);
    }
}

function require_admin(){
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        $_SESSION['toast'] = [
            'type' => 'danger',
            'title' => 'Akses Ditolak',
            'subtitle' => 'Error',
            'body' => 'Anda tidak punya hak akses ke halaman ini.'
        ];
        header("Location: " . BASE_URL . "dashboard");
        exit;
    }
}
