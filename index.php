<?php

require_once __DIR__ . '/Config/Config.php';
require_once __DIR__ . '/Helpers/Auth.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$base = trim(parse_url(BASE_URL, PHP_URL_PATH), '/');
if ($base && strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
    $uri = trim($uri, '/');
}

switch ($uri) {
    case '':
        require_once __DIR__ . '/Controllers/AuthController.php';
        $controller = new Controller\AuthController();
        $controller->index();
        break;
    case 'sign-in':
        require_once __DIR__ . '/Controllers/AuthController.php';
        $controller = new Controller\AuthController();
        $controller->sign_in();
        break;
    case 'sign-up':
        require_once __DIR__ . '/Controllers/AuthController.php';
        $controller = new Controller\AuthController();
        $controller->register();
        break;
    case 'create-user':
        require_once __DIR__ . '/Controllers/AuthController.php';
        $controller = new Controller\AuthController();
        $controller->create_user();
    case 'logout':
        require_once __DIR__ . '/Controllers/AuthController.php';
        $controller = new Controller\AuthController();
        $controller->logout();
        break;

    case 'dashboard':
        require_once __DIR__ . '/Controllers/DashboardController.php';
        $controller = new Controller\DashboardController();
        $controller->index();
        break;

    case 'profile':
        require_once __DIR__ . '/Controllers/DashboardController.php';
        $controller = new Controller\DashboardController();
        $controller->profile();
        break;

    case 'user':
    case 'user/create':
    case 'user/store':
    case 'user/edit':
    case 'user/update':
    case 'user/delete':
        require_admin();

        require_once __DIR__ . '/Controllers/UserController.php';
        $controller = new Controller\UserController();

        switch ($uri) {
            case 'user':
                $controller->index();
                break;
            case 'user/create':
                $controller->create();
                break;
            case 'user/store':
                $controller->store();
                break;
            case 'user/edit':
                $controller->edit();
                break;
            case 'user/update':
                $controller->update();
                break;
            case 'user/delete':
                $controller->delete();
                break;
        }
        break;

    case 'loker':
    case 'loker/edit':
    case 'loker/update':
    case 'loker/store':
    case 'loker/delete':
        require_admin();

        require_once __DIR__ . '/Controllers/DashboardController.php';
        $controller = new Controller\DashboardController();

        switch ($uri) {
            case 'loker':
                $controller->loker_index();
                break;
            case 'loker/edit':
                $controller->loker_edit();
                break;
            case 'loker/update':
                $controller->loker_update();
                break;
            case 'loker/store':
                $controller->loker_store();
                break;
            case 'loker/delete':
                $controller->loker_delete();
                break;
        }
        break;


    case 'penitipan':
    case 'penitipan/create':
    case 'penitipan/store':
    case 'penitipan/edit':
    case 'penitipan/detail':
    case 'penitipan/transaksi/update-biaya':
    case 'penitipan/pengajuan':
    case 'penitipan/pembayaran-user':
    case 'penitipan/pembayaran/update':
    case 'penitipan/cancel':
        require_once __DIR__ . '/Controllers/PenitipanController.php';
        $controller = new Controller\PenitipanController();

        switch ($uri) {
            case 'penitipan':
                $controller->index();
                break;
            case 'penitipan/create':
                $controller->create();
                break;
            case 'penitipan/store':
                $controller->store();
                break;
            case 'penitipan/transaksi/update-biaya':
                $controller->update_payment();
                break;
            case 'penitipan/pengajuan':
                $controller->pengajuan_penitipan();
                break;
            case 'penitipan/pembayaran-user':
                $controller->pembayaran_user();
                break;
            case 'penitipan/pembayaran/update':
                $controller->pembayaran_update();
                break;
            case 'penitipan/cancel':
                $controller->penitipan_cancel();
                break;
            case 'penitipan/edit':
                $controller->edit();
                break;
            case 'penitipan/detail':
                $controller->detail();
                break;
        }
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        break;
}
