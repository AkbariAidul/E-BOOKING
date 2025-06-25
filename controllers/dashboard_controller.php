<?php
/**
 * Controller untuk Dashboard
 *
 * File ini bertanggung jawab untuk mengambil data statistik dari database
 * yang akan ditampilkan di halaman dashboard.
 *
 * Data yang diambil:
 * 1. Jumlah total kamar.
 * 2. Jumlah total kategori kamar.
 * 3. Jumlah reservasi yang berhasil (status 'Confirmed' atau 'Completed').
 * 4. Total pendapatan dari reservasi yang berhasil.
 * 5. Data 5 reservasi terbaru untuk ditampilkan di tabel.
 *
 * File ini tidak diakses langsung, melainkan di-include oleh view yang membutuhkannya (views/dashboard.php).
 */

// Pastikan file ini tidak diakses langsung oleh user
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    die('Akses ditolak.');
}

// Memanggil koneksi database
// Menggunakan __DIR__ agar path selalu benar tidak peduli dari mana file ini dipanggil
require_once __DIR__ . '/../config/database.php';

// Menyiapkan variabel default untuk menampung data
$total_kamar = 0;
$total_kategori = 0;
$total_reservasi_sukses = 0;
$total_pendapatan = 0;
$reservasi_terbaru = [];

try {
    // 1. Mengambil Jumlah Total Kamar
    $total_kamar = $pdo->query("SELECT COUNT(*) FROM kamar")->fetchColumn() ?? 0;

    // 2. Mengambil Jumlah Total Kategori
    $total_kategori = $pdo->query("SELECT COUNT(*) FROM kategori")->fetchColumn() ?? 0;

    // 3. Mengambil Jumlah Reservasi yang Berhasil (Confirmed atau Completed)
    $stmt_reservasi = $pdo->prepare("SELECT COUNT(*) FROM reservasi WHERE status = 'Confirmed' OR status = 'Completed'");
    $stmt_reservasi->execute();
    $total_reservasi_sukses = $stmt_reservasi->fetchColumn() ?? 0;

    // 4. Mengambil Total Pendapatan dari Reservasi yang Berhasil
    $stmt_pendapatan = $pdo->prepare("SELECT SUM(total_harga) FROM reservasi WHERE status = 'Confirmed' OR status = 'Completed'");
    $stmt_pendapatan->execute();
    $total_pendapatan = $stmt_pendapatan->fetchColumn() ?? 0;

    // 5. Mengambil 5 Reservasi Terbaru
    $stmt_terbaru = $pdo->query("
        SELECT 
            r.id, 
            r.nama_pemesan, 
            k.nama_kamar, 
            r.tgl_checkin, 
            r.total_harga, 
            r.status 
        FROM reservasi r
        JOIN kamar k ON r.id_kamar = k.id
        ORDER BY r.created_at DESC
        LIMIT 5
    ");
    $reservasi_terbaru = $stmt_terbaru->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Jika terjadi error koneksi atau query, tampilkan pesan error sederhana
    // Dalam produksi, ini sebaiknya dicatat (logged) bukan ditampilkan ke user
    // Untuk tujuan development, kita bisa menampilkan error di dashboard.
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">';
    echo '<strong>Error Database:</strong> Tidak dapat mengambil data statistik. ' . $e->getMessage();
    echo '</div>';
}

?>