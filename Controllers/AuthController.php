<?php

namespace Controller;

require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Config/Config.php';

use Database;

class AuthController {
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "dashboard");
            exit;
        }

        require_once __DIR__ . '/../Views/Login.php';
    }

    public function sign_in()
    {
        session_start();

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $pdo = \Database::getInstance()->getConnection();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nama_lengkap' => $user['nama_lengkap'],
                'email' => $user['email'],
                'role' => $user['role'],
                'no_telp' => $user['no_telp'],
                'alamat' => $user['alamat']
            ];

            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Berhasil Login',
                'subtitle' => 'Welcome!',
                'body' => 'Anda berhasil masuk ke dalam sistem.'
            ];

            header("Location: " . BASE_URL . "dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Sign In Gagal!";
            header("Location: " . BASE_URL);
            exit;
        }
    }

    public function register()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "dashboard");
            exit;
        }

        require_once __DIR__ . '/../Views/Register.php';
    }

    public function create_user()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "dashboard");
            exit;
        }

        $nama_lengkap = $_POST['nama_lengkap'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (strlen($password) < 8) {
            $_SESSION['error'] = "Password minimal 8 karakter!";
            header("Location: " . BASE_URL . "sign-up");
            exit;
        }

        if (empty($nama_lengkap) || empty($email) || empty($password) || empty($confirm_password)) {
            $_SESSION['error'] = "Semua field wajib diisi.";
            header("Location: " . BASE_URL . "sign-up");
            exit;
        }

        if ($password !== $confirm_password) {
            $_SESSION['error'] = "Password tidak cocok.";
            header("Location: " . BASE_URL . "sign-up");
            exit;
        }

        $pdo = \Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $_SESSION['error'] = "Email sudah digunakan.";
            header("Location: " . BASE_URL . "sign-up");
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (nama_lengkap, email, password, role, created_at, updated_at) VALUES (:nama_lengkap, :email, :password, 'user', :created_at, :updated_at)");
        $stmt->execute([
            'nama_lengkap' => $nama_lengkap,
            'email' => $email,
            'password' => $hashedPassword,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $_SESSION['success'] = "Register berhasil. Silahkan login.";
        header("Location: " . BASE_URL);
        exit;
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header("Location: " . BASE_URL . "");
        exit;
    }
}
