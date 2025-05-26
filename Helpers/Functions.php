<?php

function is_active_page_group($prefix)
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['active_page'])) {
        return false;
    }

    $active = $_SESSION['active_page'];

    if (is_array($prefix)) {
        foreach ($prefix as $p) {
            if (strpos($active, $p) === 0) {
                return true;
            }
        }
        return false;
    } else {
        return strpos($active, $prefix) === 0;
    }
}

function build_breadcrumb()
{
    $uri = $_SERVER['REQUEST_URI'];

    // Ambil path tanpa query string
    $uri = parse_url($uri, PHP_URL_PATH);

    // Buang slash di awal/akhir dan pecah menjadi segmen
    $segments = array_values(array_filter(explode('/', trim($uri, '/'))));

    // Jika berada di folder sub seperti 'php-crud', buang itu
    if (!empty($segments) && $segments[0] === 'php-crud') {
        array_shift($segments);
    }

    $baseUrl = BASE_URL;
    $breadcrumbs = [];

    // Jika hanya di dashboard
    if (empty($segments) || (count($segments) === 1 && $segments[0] === 'dashboard')) {
        $breadcrumbs[] = '<li class="breadcrumb-item active">Dashboard</li>';
    } else {
        // Mulai dengan Dashboard
        $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . $baseUrl . 'dashboard">Dashboard</a></li>';

        // Ambil hanya segmen pertama setelah dashboard untuk menentukan page utama
        $page = ucfirst(str_replace('-', ' ', $segments[0]));
        $breadcrumbs[] = '<li class="breadcrumb-item active">' . $page . '</li>';
    }

    return implode("\n", $breadcrumbs);
}

function get_current_segment($index)
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = array_values(array_filter(explode('/', trim($uri, '/'))));

    // Hilangkan folder root seperti php-crud jika ada
    if (!empty($segments) && $segments[0] === 'php-crud') {
        array_shift($segments);
    }

    return $segments[$index] ?? null;
}

function is_active_menu($slug)
{
    return get_current_segment(0) === $slug;
}

function dateCustom($datetime)
{
    $hari = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    $timestamp = strtotime($datetime);
    $hariIndo = $hari[date('l', $timestamp)];
    $tanggal = date('j', $timestamp);
    $bulanIndo = $bulan[(int)date('n', $timestamp)];
    $tahun = date('Y', $timestamp);
    $jam = date('H:i', $timestamp);

    return "$hariIndo, $tanggal $bulanIndo $tahun $jam";
}
