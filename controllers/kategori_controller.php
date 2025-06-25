<?php
session_start();
require_once '../config/database.php';
require_once '../core/auth_check.php'; // Pastikan hanya admin yang bisa akses

// Cek aksi yang diminta
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'store':
        // Logika untuk menyimpan data baru
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama = $_POST['nama_kategori'];
            $deskripsi = $_POST['deskripsi'];

            // Validasi Sederhana
            if (empty($nama)) {
                $_SESSION['error_message'] = "Nama kategori tidak boleh kosong.";
                header("Location: ../index.php?page=kategori-create");
                exit();
            }

            $stmt = $pdo->prepare("INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)");
            if ($stmt->execute([$nama, $deskripsi])) {
                $_SESSION['success_message'] = "Kategori berhasil ditambahkan.";
            } else {
                $_SESSION['error_message'] = "Gagal menambahkan kategori.";
            }
            header("Location: ../index.php?page=kategori");
        }
        break;

    case 'update':
        // Logika untuk memperbarui data
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $nama = $_POST['nama_kategori'];
            $deskripsi = $_POST['deskripsi'];

            if (empty($nama) || empty($id)) {
                $_SESSION['error_message'] = "Data tidak lengkap.";
                header("Location: ../index.php?page=kategori");
                exit();
            }

            $stmt = $pdo->prepare("UPDATE kategori SET nama_kategori = ?, deskripsi = ? WHERE id = ?");
            if ($stmt->execute([$nama, $deskripsi, $id])) {
                $_SESSION['success_message'] = "Kategori berhasil diperbarui.";
            } else {
                $_SESSION['error_message'] = "Gagal memperbarui kategori.";
            }
            header("Location: ../index.php?page=kategori");
        }
        break;

    case 'delete':
        // Logika untuk menghapus data
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        if ($id > 0) {
            try {
                // Cek dulu apakah kategori ini dipakai di tabel kamar
                $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM kamar WHERE id_kategori = ?");
                $check_stmt->execute([$id]);
                if ($check_stmt->fetchColumn() > 0) {
                     $_SESSION['error_message'] = "Gagal menghapus! Kategori ini sedang digunakan oleh beberapa kamar.";
                } else {
                    $stmt = $pdo->prepare("DELETE FROM kategori WHERE id = ?");
                    if ($stmt->execute([$id])) {
                        $_SESSION['success_message'] = "Kategori berhasil dihapus.";
                    } else {
                        $_SESSION['error_message'] = "Gagal menghapus kategori.";
                    }
                }
            } catch (PDOException $e) {
                $_SESSION['error_message'] = "Terjadi error: " . $e->getMessage();
            }
        }
        header("Location: ../index.php?page=kategori");
        break;

    default:
        // Aksi tidak dikenal, redirect ke halaman utama
        header("Location: ../index.php?page=kategori");
        break;
}
?>