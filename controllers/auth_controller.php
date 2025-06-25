<?php
// Cara aman untuk memulai sesi di setiap controller
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';

// Ambil aksi dari URL dengan aman
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Gunakan switch untuk mengatur semua aksi
switch ($action) {
    case 'login':
        // Logika untuk login
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (empty($username) || empty($password)) {
                header("Location: ../views/auth/login.php?error=Username dan password tidak boleh kosong");
                exit();
            }

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Login berhasil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                
                // Jangan gunakan session message di sini, langsung redirect
                header("Location: ../index.php?page=dashboard");
                exit();
            } else {
                // Login gagal
                header("Location: ../views/auth/login.php?error=Username atau password salah");
                exit();
            }
        }
        // Jika bukan POST, redirect saja
        header("Location: ../views/auth/login.php");
        exit();

    case 'register':
        // Logika untuk registrasi
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $konfirmasi_password = $_POST['konfirmasi_password'];

            // Validasi Input
            if (empty($nama_lengkap) || empty($username) || empty($password)) {
                header("Location: ../views/auth/register.php?error=Semua field wajib diisi.");
                exit();
            }
            if (strlen($password) < 6) {
                header("Location: ../views/auth/register.php?error=Password minimal harus 6 karakter.");
                exit();
            }
            if ($password !== $konfirmasi_password) {
                header("Location: ../views/auth/register.php?error=Konfirmasi password tidak cocok.");
                exit();
            }

            // Cek username duplikat
            $stmt_check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt_check->execute([$username]);
            if ($stmt_check->fetch()) {
                header("Location: ../views/auth/register.php?error=Username sudah digunakan.");
                exit();
            }

            // Hash Password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert ke Database
            $stmt_insert = $pdo->prepare("INSERT INTO users (nama_lengkap, username, password) VALUES (?, ?, ?)");
            if ($stmt_insert->execute([$nama_lengkap, $username, $hashed_password])) {
                header("Location: ../views/auth/login.php?success=Registrasi berhasil! Silakan login.");
                exit();
            } else {
                header("Location: ../views/auth/register.php?error=Gagal membuat akun.");
                exit();
            }
        }
        // Jika bukan POST, redirect
        header("Location: ../views/auth/register.php");
        exit();

    default:
        // Jika aksi tidak dikenal, tendang ke halaman login
        header("Location: ../views/auth/login.php");
        header("Location: ../views/auth/login.php");
        exit();
}