<?php

namespace Controller;

require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Helpers/Auth.php';

use Database;

class UserController {
    public function index()
    {
        require_login();

        $_SESSION['active_page'] = 'user';
        $_SESSION['page_title'] = 'Data User';

        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM users ORDER BY role, id ASC");
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/User/Index.php';
    }

    public function create()
    {
        require_login();

        $_SESSION['active_page'] = 'user/create';
        $_SESSION['page_title'] = 'Form Tambah User';

        require_once __DIR__ . '/../Views/User/Form_User.php';
    }

    public function store()
    {
        require_login();

        $pdo = Database::getInstance()->getConnection();

        $nama_lengkap = empty(trim($_POST['nama_lengkap'] ?? '')) ? null : trim($_POST['nama_lengkap']);
        $email = $_POST['email'];
        $no_telp = empty(trim($_POST['no_telp'] ?? '')) ? null : trim($_POST['no_telp']);
        $alamat = empty(trim($_POST['alamat'] ?? '')) ? null : trim($_POST['alamat']);
        $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
        $role = $_POST['role'] ?? 'user';

        if (strlen($password) < 8) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Password',
                'subtitle' => 'Gagal',
                'body' => 'Password minimal 8 karakter.'
            ];

            header("Location: " . BASE_URL . "profile");
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Tambah Data User',
                'subtitle' => 'Error',
                'body' => "Email $email sudah digunakan."
            ];
            header("Location: " . BASE_URL . "user/create");
            exit();
        }

        $now = date('Y-m-d H:i:s');

        $telp = is_null($no_telp) ? null : '62' . $no_telp;

        $stmt = $pdo->prepare("INSERT INTO users (nama_lengkap, email, no_telp, alamat, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama_lengkap, $email, $telp, $alamat, $password, $role, $now, $now]);

        $_SESSION['toast'] = [
            'type' => 'success',
            'title' => 'Tambah Data User',
            'subtitle' => 'Berhasil',
            'body' => "User dengan email $email berhasil ditambahkan."
        ];

        header('Location: ' . BASE_URL . 'user');
        exit();
    }

    public function edit()
    {
        require_login();

        $_SESSION['active_page'] = 'user/edit';
        $_SESSION['page_title'] = 'Form Edit User';

        $pdo = Database::getInstance()->getConnection();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Data User',
                'subtitle' => 'Error',
                'body' => "Data user dengan ID: $id tidak ada."
            ];
            header("Location: " . BASE_URL . 'user');
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Data User',
                'subtitle' => 'Error',
                'body' => "Data user dengan ID: $id tidak ada."
            ];
            header('Location: ' . BASE_URL . 'user');
            exit;
        }

        require_once __DIR__ . '/../Views/User/Form_Edit_User.php';
    }

    public function update()
    {
        require_login();

        $pdo = Database::getInstance()->getConnection();

        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Data User',
                'subtitle' => 'Error',
                'body' => "Data user dengan ID: $id tidak ada."
            ];

            header("Location: " . BASE_URL . 'user');
            exit;
        }

        $nama_lengkap = empty(trim($_POST['nama_lengkap'] ?? '')) ? null : trim($_POST['nama_lengkap']);
        $email = $_POST['email'];
        $no_telp = empty(trim($_POST['no_telp'] ?? '')) ? null : trim($_POST['no_telp']);
        $alamat = empty(trim($_POST['alamat'] ?? '')) ? null : trim($_POST['alamat']);
        $role = $_POST['role'] ?? 'user';
        $password = $_POST['password'] ?? null;
        $type_page = $_POST['type_page'] ?? null;

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND id != :id");
        $stmt->execute([
            'email' => $email,
            'id' => $id
        ]);
        if ($stmt->fetch()) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Tambah Data User',
                'subtitle' => 'Error',
                'body' => "Email $email sudah digunakan."
            ];
            header("Location: " . BASE_URL . "user/edit");
            exit();
        }

        $now = date('Y-m-d H:i:s');

        if (!empty($password)) {
            if (strlen($password) < 8) {
                $_SESSION['toast'] = [
                    'type' => 'danger',
                    'title' => 'Password',
                    'subtitle' => 'Gagal',
                    'body' => 'Password minimal 8 karakter.'
                ];

                header("Location: " . BASE_URL . "profile");
                exit;
            }

            if ($_POST['password'] !== $_POST['confirm_password']) {
                $_SESSION['toast'] = [
                    'type' => 'danger',
                    'title' => 'Password',
                    'subtitle' => 'Gagal',
                    'body' => 'Konfirmasi password tidak cocok.'
                ];
                header("Location: " . BASE_URL . 'profile');
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = ?, email = ?, no_telp = ?, alamat = ?, role = ?, password = ?, updated_at = ? WHERE id = ?");
            $stmt->execute([$nama_lengkap, $email, $no_telp, $alamat, $role, $hashedPassword, $now, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = ?, email = ?, no_telp = ?, alamat = ?, role = ?, updated_at = ? WHERE id = ?");
            $stmt->execute([$nama_lengkap, $email, $no_telp, $alamat, $role, $now, $id]);
        }

        if ($type_page === 'edit_user') {
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Update Data',
                'subtitle' => 'Success',
                'body' => "Data dengan id: $id berhasil diupdate."
            ];
            header("Location: " . BASE_URL . 'user');
        } elseif ($type_page === 'profile') {
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Update Data',
                'subtitle' => 'Success',
                'body' => "Profil berhasil diupdate."
            ];
            header("Location: " . BASE_URL . 'profile');
        }
        exit;
    }

    public function delete()
    {
        require_login();

        $pdo = Database::getInstance()->getConnection();

        $id = $_GET['id'] ?? null;
        $userLoginId = $_SESSION['user_id'];

        if (!$id || $id == 1) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'title' => 'Hapus Data User',
                'subtitile' => 'Gagal',
                'body' => 'Akun ini tidak dapat dihapus.'
            ];

            header("Location: " . BASE_URL . "user");
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['toast'] = [
            'type' => 'success',
            'title' => 'Hapus User',
            'subtitle' => 'Berhasil',
            'body' => 'User berhasil dihapus.'
        ];
        header("Location: " . BASE_URL . "user");
        exit;
    }
}
