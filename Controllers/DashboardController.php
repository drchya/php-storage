<?php

namespace Controller;

require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Helpers/Auth.php';

use Database;

class DashboardController {
    public function index()
    {
        require_login();

        $_SESSION['active_page'] = 'dashboard';
        $_SESSION['page_title'] = 'Dashboard';

        require_once __DIR__ . '/../Views/Admin/Dashboard.php';
    }

    public function profile()
    {
        require_login();

        $_SESSION['active_page'] = 'user/profile';
        $_SESSION['page_title'] = 'Profil Data User';

        require_once __DIR__ . '/../Views/User/Profile.php';
    }

    public function loker_index()
    {
        require_login();

        $_SESSION['active_page'] = 'loker';
        $_SESSION['page_title'] = 'Data Tabel Loker';

        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM loker ORDER BY nomor_loker, id ASC");
        $lokers = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/Loker/Index.php';
    }

    public function loker_store()
    {
        require_login();

        $angka = isset($_POST['nomor_loker']) ? intval($_POST['nomor_loker']) : 0;
        $kapasitas = isset($_POST['kapasitas']) ? intval($_POST['kapasitas']) : 0;

        if ($angka <= 0 || $angka > 99) {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Tambah Data Loker',
                'subtitle' => 'Error',
                'body' => "Angka tidak valid"
            ];

            header("Location: " . BASE_URL . 'loker');
            exit;
        }

        $pdo = Database::getInstance()->getConnection();

        $nomor_loker = null;
        foreach (range('A', 'Z') as $huruf) {
            $kode = $huruf . $angka;
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM loker WHERE nomor_loker = ?');
            $stmt->execute([$kode]);
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                $nomor_loker = $kode;
                break;
            }
        }

        if (!$nomor_loker) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Tambah Data Loker',
                'subtitle' => 'Error',
                'body' => "Nomor loker tersebut sudah digunakan."
            ];

            header("Location: " . BASE_URL . 'loker');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO loker (nomor_loker, kapasitas, status, created_at, updated_at) VALUES (?, ?, 'kosong', NOW(), NOW())");
        $stmt->execute([$nomor_loker, $kapasitas]);

        $_SESSION['toast'] = [
            'type' => 'success',
            'title' => 'Tambah Data Loker',
            'subtitle' => 'Success',
            'body' => "Nomor loker sudah ditambahkan."
        ];

        header("Location: " . BASE_URL . 'loker');
        exit;
    }

    public function loker_edit()
    {
        require_login();

        $_SESSION['active_page'] = 'loker';
        $_SESSION['page_title'] = 'Edit Data Loker';

        $pdo = Database::getInstance()->getConnection();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Data Loker',
                'subtitle' => 'Error',
                'body' => "Data loker tidak ada."
            ];
            header("Location: " . BASE_URL . "loker");
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM loker WHERE id = ?");
        $stmt->execute([$id]);
        $loker = $stmt->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/Loker/Edit.php';
    }

    public function loker_update()
    {
        require_login();

        $pdo = Database::getInstance()->getConnection();
        $id = $_POST['id'] ?? null;
        $nomor_lama = $_POST['nomor_loker'] ?? '';
        $kapasitas = isset($_POST['kapasitas']) ? intval($_POST['kapasitas']) : 0;

        $stmtCheck = $pdo->prepare("SELECT * FROM loker WHERE id = ?");
        $stmtCheck->execute([$id]);
        $loker = $stmtCheck->fetchColumn();

        if (!$loker) {
            $_SESSION['toast'] = [
                'type' => 'Error',
                'title' => 'Edit Data Loker',
                'subtitle' => 'Error',
                'body' => 'Data loker tidak ditemukan.'
            ];

            header("Location: " . BASE_URL . "loker/edit");
            exit;
        }

        if ($loker['status'] === 'booked') {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Edit Data Loker',
                'subtitle' => 'Warning',
                'body' => 'Loker tidak dapat diedit karena sedang digunakan (booked).'
            ];

            header("Location: " . BASE_URL . "loker/edit");
            exit;
        }

        if ($kapasitas <= 0) {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Edit Data Loker',
                'subtitle' => 'Warning',
                'body' => 'Loker tidak dapat diedit karena sedang digunakan (booked).'
            ];

            header("Location: " . BASE_URL . "loker/edit");
            exit;
        }

        if (!preg_match('/^[A-Z]{1}[0-9]{1,2}$/', $nomor_lama)) {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Edit Data Loker',
                'subtitle' => 'Format Salah',
                'body' => 'Nomor loker harus terdiri dari 1 huruf (A-Z) diikuti angka, contoh: A1 atau Z99.'
            ];
            header("Location: " . BASE_URL . "loker/edit?id=" . $id);
            exit;
        }

        $stmtCheckNomor = $pdo->prepare("SELECT COUNT(*) FROM loker WHERE nomor_loker = ? AND id = ?");
        $stmtCheckNomor->execute([$nomor_lama, $id]);
        $count = $stmtCheckNomor->fetchColumn();
        if ($count > 0) {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Edit Data Loker',
                'subtitle' => 'Gagal',
                'body' => 'Nomor loker sudah digunakan.'
            ];
            header("Location: " . BASE_URL . "loker/edit?id=" . $id);
            exit;
        }

        $stmtUpdate = $pdo->prepare("UPDATE loker SET nomor_loker = ?, kapasitas = ?, updated_at = NOW() WHERE id = ?");
        $stmtUpdate->execute([$nomor_lama, $kapasitas, $id]);

        $_SESSION['toast'] = [
            'type' => 'success',
            'title' => 'Edit Data Loker',
            'subtitle' => 'Berhasil',
            'body' => 'Data loker berhasil diperbarui.'
        ];

        header("Location: " . BASE_URL . "loker");
        exit;
    }

    public function loker_delete()
    {
        require_login();

        $pdo = Database::getInstance()->getConnection();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Hapus Data Loker',
                'subtitile' => 'Error',
                'body' => 'Tidak ada data loker yang dihapus.'
            ];

            header("Location: " . BASE_URL . "loker");
            exit;
        }

        $stmtCheck = $pdo->prepare("SELECT status FROM loker WHERE id = ?");
        $stmtCheck->execute([$id]);
        $status = $stmtCheck->fetchColumn();

        if ($status === 'kosong') {
            $stmt = $pdo->prepare("DELETE FROM loker WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Hapus Data Loker',
                'subtitle' => 'Berhasil',
                'body' => 'Berhasil menghapus data loker.'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'title' => 'Hapus Data Loker',
                'subtitle' => 'Warning',
                'body' => 'Loker tidak dapat dihapus karena sedang digunakan (booked).'
            ];
        }


        header("Location: " . BASE_URL . "loker");
        exit;
    }
}
