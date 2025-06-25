<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';
require_once '../core/auth_check.php'; // Pastikan hanya admin yang bisa akses

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Fungsi untuk menghapus gambar lama dengan aman
function deleteOldImage($filename) {
    // Jangan hapus gambar default
    if ($filename && $filename !== 'default.jpg' && file_exists("../uploads/" . $filename)) {
        unlink("../uploads/" . $filename);
    }
}

switch ($action) {
    case 'store':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ambil data dari form
            $nama_kamar = $_POST['nama_kamar'];
            $id_kategori = $_POST['id_kategori'];
            $harga_per_malam = $_POST['harga_per_malam'];
            $stok = $_POST['stok'];
            $deskripsi = $_POST['deskripsi'];

            // Validasi dasar
            if (empty($nama_kamar) || empty($id_kategori) || empty($harga_per_malam) || !isset($stok)) {
                $_SESSION['error_message'] = "Semua field yang bertanda (*) wajib diisi.";
                header("Location: ../index.php?page=kamar-create");
                exit();
            }

            // Logika Upload Gambar
            $gambar_name = 'default.jpg';
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
                $gambar = $_FILES['gambar'];
                $target_dir = "../uploads/";
                
                // Buat nama file unik
                $imageFileType = strtolower(pathinfo($gambar["name"], PATHINFO_EXTENSION));
                $gambar_name = uniqid('kamar_') . '_' . time() . '.' . $imageFileType;
                $target_file = $target_dir . $gambar_name;

                // Validasi file
                $check = getimagesize($gambar["tmp_name"]);
                if ($check === false) {
                    $_SESSION['error_message'] = 'File yang diupload bukan gambar.';
                    header('Location: ../index.php?page=kamar-create');
                    exit();
                }
                if ($gambar["size"] > 2000000) { // maks 2MB
                    $_SESSION['error_message'] = 'Ukuran gambar terlalu besar (maks 2MB).';
                    header('Location: ../index.php?page=kamar-create');
                    exit();
                }
                if (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                     $_SESSION['error_message'] = 'Format gambar tidak valid (hanya JPG, PNG, JPEG).';
                    header('Location: ../index.php?page=kamar-create');
                    exit();
                }
                
                // Pindahkan file
                if (!move_uploaded_file($gambar["tmp_name"], $target_file)) {
                    $_SESSION['error_message'] = 'Terjadi kesalahan saat mengupload gambar.';
                    header('Location: ../index.php?page=kamar-create');
                    exit();
                }
            }

            // Simpan ke database
            $stmt = $pdo->prepare("INSERT INTO kamar (nama_kamar, id_kategori, harga_per_malam, stok, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$nama_kamar, $id_kategori, $harga_per_malam, $stok, $deskripsi, $gambar_name])) {
                $_SESSION['success_message'] = "Kamar baru berhasil ditambahkan.";
            } else {
                $_SESSION['error_message'] = "Gagal menambahkan kamar.";
            }
            header("Location: ../index.php?page=kamar");
            exit();
        }
        break;

    case 'update':
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $nama_kamar = $_POST['nama_kamar'];
            $id_kategori = $_POST['id_kategori'];
            $harga_per_malam = $_POST['harga_per_malam'];
            $stok = $_POST['stok'];
            $deskripsi = $_POST['deskripsi'];
            $gambar_lama = $_POST['gambar_lama'];

            // Logika Upload Gambar Baru
            $gambar_name = $gambar_lama;
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
                // Proses upload gambar baru (sama seperti di 'store')
                // ... (tambahkan validasi seperti di atas)
                $gambar = $_FILES['gambar'];
                $target_dir = "../uploads/";
                $imageFileType = strtolower(pathinfo($gambar["name"], PATHINFO_EXTENSION));
                $gambar_name_baru = uniqid('kamar_') . '_' . time() . '.' . $imageFileType;
                $target_file = $target_dir . $gambar_name_baru;

                if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
                    // Jika upload baru berhasil, hapus gambar lama
                    deleteOldImage($gambar_lama);
                    $gambar_name = $gambar_name_baru;
                }
            }

            // Update ke database
            $stmt = $pdo->prepare("UPDATE kamar SET nama_kamar = ?, id_kategori = ?, harga_per_malam = ?, stok = ?, deskripsi = ?, gambar = ? WHERE id = ?");
            if ($stmt->execute([$nama_kamar, $id_kategori, $harga_per_malam, $stok, $deskripsi, $gambar_name, $id])) {
                $_SESSION['success_message'] = "Data kamar berhasil diperbarui.";
            } else {
                $_SESSION['error_message'] = "Gagal memperbarui data kamar.";
            }
            header("Location: ../index.php?page=kamar");
            exit();
        }
        break;

    case 'delete':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        
        // Ambil nama file gambar sebelum menghapus data dari DB
        $stmt = $pdo->prepare("SELECT gambar FROM kamar WHERE id = ?");
        $stmt->execute([$id]);
        $kamar = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($kamar) {
            $stmt_delete = $pdo->prepare("DELETE FROM kamar WHERE id = ?");
            if ($stmt_delete->execute([$id])) {
                // Hapus file gambar terkait
                deleteOldImage($kamar['gambar']);
                $_SESSION['success_message'] = "Kamar berhasil dihapus.";
            } else {
                $_SESSION['error_message'] = "Gagal menghapus kamar.";
            }
        } else {
             $_SESSION['error_message'] = "Kamar tidak ditemukan.";
        }
        header("Location: ../index.php?page=kamar");
        exit();

    default:
        header("Location: ../index.php?page=kamar");
        exit();
}
?>