<?php
/**
 * File index.php (Router Utama)
 * * Ini adalah file pusat yang menangani semua permintaan ke panel admin.
 * Alur kerjanya:
 * 1. Memulai sesi PHP dengan aman.
 * 2. Memeriksa otentikasi (apakah user sudah login?). Jika belum, akan diarahkan ke halaman login.
 * 3. Memuat template header (sidebar, navigasi atas, dll).
 * 4. Menggunakan switch-case untuk menentukan konten halaman mana yang akan dimuat berdasarkan parameter URL `?page=...`.
 * 5. Memuat file view yang sesuai.
 * 6. Memuat template footer.
 */

// 1. Memulai sesi PHP dengan aman
// Memastikan session_start() hanya dipanggil sekali.
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// 2. Memeriksa otentikasi
// Semua halaman di dalam panel ini memerlukan login.
require_once 'core/auth_check.php'; 

// 3. Memuat template header
// Ini akan menampilkan bagian atas halaman dan sidebar navigasi.
require_once 'views/layouts/header.php';

// 4. Mengambil halaman yang diminta dari URL
// Jika parameter 'page' tidak ada, defaultnya adalah 'dashboard'.
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// 5. Router sederhana untuk memuat konten halaman
switch ($page) {
  case 'dashboard':
        require_once 'views/dashboard.php';
        break;
    
    // [BARU] Rute untuk halaman kalender
    case 'kalender':
        require_once 'views/kalender/index.php';
        break;
  
  // --- Rute untuk Reservasi ---
  // --- Rute untuk Reservasi ---
    case 'reservasi':
        require_once 'views/reservasi/index.php';
        break;
    case 'reservasi-create':
        require_once 'views/reservasi/create.php';
        break;
    
  // --- Rute untuk Kategori ---
  case 'kategori':
    require_once 'views/kategori/index.php';
    break;
  case 'kategori-create':
    require_once 'views/kategori/create.php';
    break;
  case 'kategori-edit':
    require_once 'views/kategori/edit.php';
    break;
    
  // --- Rute untuk Kamar ---
  case 'kamar':
    require_once 'views/kamar/index.php';
    break;
  case 'kamar-create':
    require_once 'views/kamar/create.php';
    break;
  case 'kamar-edit':
    require_once 'views/kamar/edit.php';
    break;

  // --- Halaman Default Jika Rute Tidak Ditemukan ---
  default:
    // Menampilkan halaman error 404 yang simpel dan sesuai tema
    echo '
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
      <h2 class="font-bold text-xl">Error 404</h2>
      <p>Halaman yang Anda cari tidak ditemukan.</p>
    </div>
    ';
    break;
}

// 6. Memuat template footer
// Ini akan menutup tag HTML dan body, serta memuat script global jika ada.
require_once 'views/layouts/footer.php';
?>