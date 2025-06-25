<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';
require_once '../core/auth_check.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'store':
        // Logika 'store' dari sebelumnya tetap di sini
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_pemesan = trim($_POST['nama_pemesan']);
            $email_pemesan = trim($_POST['email_pemesan']);
            $telepon_pemesan = trim($_POST['telepon_pemesan']);
            $id_kamar = $_POST['id_kamar'];
            $jumlah_kamar = (int)$_POST['jumlah_kamar'];
            $tgl_checkin = $_POST['tgl_checkin'];
            $tgl_checkout = $_POST['tgl_checkout'];
            
            if (empty($nama_pemesan) || empty($email_pemesan) || empty($id_kamar) || empty($tgl_checkin) || empty($tgl_checkout) || $jumlah_kamar <= 0) {
                $_SESSION['error_message'] = "Semua field yang bertanda (*) wajib diisi.";
                header("Location: ../index.php?page=reservasi-create");
                exit();
            }

            try {
                $stmt_kamar = $pdo->prepare("SELECT harga_per_malam, stok FROM kamar WHERE id = ?");
                $stmt_kamar->execute([$id_kamar]);
                $kamar = $stmt_kamar->fetch(PDO::FETCH_ASSOC);

                if (!$kamar) throw new Exception("Kamar tidak ditemukan.");
                if ($kamar['stok'] < $jumlah_kamar) throw new Exception("Stok kamar tidak mencukupi. Sisa stok: {$kamar['stok']}");

                $checkin_date = new DateTime($tgl_checkin);
                $checkout_date = new DateTime($tgl_checkout);
                $interval = $checkin_date->diff($checkout_date);
                $jumlah_malam = $interval->days;

                if ($jumlah_malam <= 0) throw new Exception("Tanggal check-out harus setelah tanggal check-in.");
                
                $total_harga = $jumlah_malam * $kamar['harga_per_malam'] * $jumlah_kamar;
                $status = 'Confirmed';

                $stmt_insert = $pdo->prepare(
                    "INSERT INTO reservasi (nama_pemesan, email_pemesan, telepon_pemesan, id_kamar, jumlah_kamar, tgl_checkin, tgl_checkout, jumlah_malam, total_harga, status, created_at) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())"
                );
                $stmt_insert->execute([$nama_pemesan, $email_pemesan, $telepon_pemesan, $id_kamar, $jumlah_kamar, $tgl_checkin, $tgl_checkout, $jumlah_malam, $total_harga, $status]);

                $stmt_update_stok = $pdo->prepare("UPDATE kamar SET stok = stok - ? WHERE id = ?");
                $stmt_update_stok->execute([$jumlah_kamar, $id_kamar]);

                $_SESSION['success_message'] = "Reservasi baru berhasil ditambahkan.";
                header("Location: ../index.php?page=reservasi");
                exit();

            } catch (Exception $e) {
                $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
                header("Location: ../index.php?page=reservasi-create");
                exit();
            }
        }
        break;

    // [FUNGSI BARU] Untuk mengambil detail reservasi via AJAX
    case 'get_detail':
        header('Content-Type: application/json');
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id === 0) {
            echo json_encode(['error' => 'ID tidak valid']);
            exit;
        }
        
        $stmt = $pdo->prepare("
            SELECT r.*, k.nama_kamar, k.harga_per_malam 
            FROM reservasi r 
            JOIN kamar k ON r.id_kamar = k.id 
            WHERE r.id = ?
        ");
        $stmt->execute([$id]);
        $reservasi = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reservasi) {
            echo json_encode($reservasi);
        } else {
            echo json_encode(['error' => 'Reservasi tidak ditemukan']);
        }
        exit;

    // [FUNGSI BARU] Untuk mengubah status reservasi
    case 'update_status':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $new_status = isset($_GET['status']) ? $_GET['status'] : '';
        $valid_statuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];

        if ($id === 0 || !in_array($new_status, $valid_statuses)) {
            $_SESSION['error_message'] = "Permintaan tidak valid.";
            header("Location: ../index.php?page=reservasi");
            exit();
        }

        try {
            // Ambil data reservasi saat ini untuk cek status lama dan jumlah kamar
            $stmt_get = $pdo->prepare("SELECT status, id_kamar, jumlah_kamar FROM reservasi WHERE id = ?");
            $stmt_get->execute([$id]);
            $current_reservasi = $stmt_get->fetch(PDO::FETCH_ASSOC);
            $old_status = $current_reservasi['status'];

            // Logika penyesuaian stok
            if ($old_status !== $new_status) {
                $jumlah_kamar = $current_reservasi['jumlah_kamar'];
                $id_kamar = $current_reservasi['id_kamar'];

                // Jika dibatalkan, stok kembali
                if ($new_status === 'Cancelled' && ($old_status === 'Confirmed' || $old_status === 'Completed')) {
                    $pdo->prepare("UPDATE kamar SET stok = stok + ? WHERE id = ?")->execute([$jumlah_kamar, $id_kamar]);
                }
                // Jika dikonfirmasi dari batal/pending, stok berkurang
                else if ($new_status === 'Confirmed' && ($old_status === 'Cancelled' || $old_status === 'Pending')) {
                    $pdo->prepare("UPDATE kamar SET stok = stok - ? WHERE id = ?")->execute([$jumlah_kamar, $id_kamar]);
                }
            }

            // Update status di tabel reservasi
            $stmt_update = $pdo->prepare("UPDATE reservasi SET status = ? WHERE id = ?");
            $stmt_update->execute([$new_status, $id]);
            
            $_SESSION['success_message'] = "Status reservasi berhasil diperbarui.";

        } catch (Exception $e) {
            $_SESSION['error_message'] = "Gagal memperbarui status: " . $e->getMessage();
        }

        header("Location: ../index.php?page=reservasi");
        exit();

    default:
        header("Location: ../index.php?page=reservasi");
        exit();
}