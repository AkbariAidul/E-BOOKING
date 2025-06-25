# Luminary Stays - Panel Admin Booking Hotel

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

Sebuah panel admin web modern yang dirancang untuk mengelola operasional sistem booking hotel. Proyek ini dibangun menggunakan PHP native dengan struktur MVC sederhana dan antarmuka yang bersih menggunakan Tailwind CSS.

---

### Tampilan Aplikasi

<table>
  <tr>
    <td align="center"><strong>Halaman Login Interaktif</strong></td>
    <td align="center"><strong>Dashboard Utama</strong></td>
  </tr>
  <tr>
    <td><img src="https://i.imgur.com/gK6kUuH.jpeg" alt="Halaman Login"></td>
    <td><img src="https://i.imgur.com/0iS9P5T.jpeg" alt="Dashboard"></td>
  </tr>
  <tr>
    <td align="center"><strong>Kalender Ketersediaan</strong></td>
    <td align="center"><strong>Manajemen Reservasi</strong></td>
  </tr>
  <tr>
    <td><img src="https://i.imgur.com/gU8mS6k.jpeg" alt="Kalender Ketersediaan"></td>
    <td><img src="https://i.imgur.com/4gWjT4r.jpeg" alt="Manajemen Reservasi"></td>
  </tr>
</table>

*(**Catatan**: Anda bisa mengganti URL gambar di atas dengan screenshot proyek Anda sendiri yang sudah diunggah ke GitHub atau Imgur)*

---

### ✨ Fitur Utama

-   **Dashboard Statistik**: Menampilkan ringkasan data penting seperti total kamar, total reservasi, dan total pendapatan.
-   **Manajemen Kamar**: Operasi CRUD (Create, Read, Update, Delete) penuh untuk data kamar, lengkap dengan fungsionalitas upload gambar.
-   **Manajemen Kategori**: CRUD untuk mengelola kategori kamar (e.g., Standard, Deluxe, Suite).
-   **Manajemen Reservasi**:
    -   Membuat reservasi baru langsung dari panel admin.
    -   Melihat semua data reservasi.
    -   Mengubah status reservasi (`Pending`, `Confirmed`, `Completed`, `Cancelled`) melalui menu dropdown interaktif.
    -   Melihat detail lengkap setiap reservasi melalui modal pop-up.
-   **Kalender Ketersediaan**: Tampilan kalender visual untuk melihat jadwal booking setiap kamar, memudahkan pelacakan kamar yang tersedia dan yang terisi.
-   **Sistem Autentikasi**: Halaman Login dan Register yang aman untuk admin.
-   **Desain Modern & Responsif**: Antarmuka yang bersih dan modern dibangun dengan Tailwind CSS.
-   **Halaman Login Interaktif**: Latar belakang partikel dinamis menggunakan `particles.js` untuk memberikan kesan pertama yang canggih.

---

### 💻 Teknologi yang Digunakan

-   **Backend**: PHP Native (v8+)
-   **Database**: MySQL (dijalankan melalui XAMPP/MariaDB)
-   **Frontend**: HTML, Tailwind CSS, JavaScript (Vanilla)
-   **Library Eksternal**:
    -   [FullCalendar.js](https://fullcalendar.io/) - Untuk fitur kalender ketersediaan.
    -   [Particles.js](https://vincentgarreau.com/particles.js/) - Untuk animasi latar belakang di halaman login.
    -   [SweetAlert2](https://sweetalert2.github.io/) - Untuk notifikasi pop-up yang indah.
    -   [Font Awesome](https://fontawesome.com/) - Untuk ikon.

---

### 🚀 Instalasi & Konfigurasi

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Clone Repositori**
    ```bash
    git clone [URL_REPOSITORI_ANDA]
    ```

2.  **Pindahkan ke Direktori Web Server**
    -   Pindahkan folder proyek `E-BOOKING` ke dalam direktori `htdocs` pada instalasi XAMPP Anda.
    -   Contoh path: `C:\xampp\htdocs\E-BOOKING`

3.  **Jalankan XAMPP**
    -   Buka XAMPP Control Panel dan jalankan service **Apache** dan **MySQL**.

4.  **Buat & Impor Database**
    -   Buka browser dan akses `http://localhost/phpmyadmin`.
    -   Buat database baru dengan nama `db_hotel`.
    -   Pilih database `db_hotel`, lalu klik tab **Import**.
    -   Pilih file `.sql` yang ada di proyek ini (Anda perlu mengekspornya terlebih dahulu dari database Anda dan menyimpannya di repositori, misal dengan nama `db_hotel.sql`).
    -   Klik **Go** atau **Import**.

5.  **Konfigurasi Koneksi Database**
    -   Buka file `config/database.php`.
    -   Pastikan detail koneksi (host, nama database, username, password) sudah sesuai dengan pengaturan XAMPP Anda. Secara default, username adalah `root` dan password dikosongkan.
    ```php
    <?php
    $host = 'localhost';
    $db_name = 'db_hotel';
    $username = 'root';
    $password = ''; // Kosongkan jika tidak ada password
    // ...
    ?>
    ```

6.  **Jalankan Aplikasi**
    -   Buka browser dan akses URL: `http://localhost:8080/E-BOOKING/` atau `http://localhost/E-BOOKING/` (sesuaikan port jika berbeda).
    -   Anda akan diarahkan ke halaman login.

---

### 📁 Struktur Folder

```
E-BOOKING/
├── api_get_reservations.php   # API untuk kalender
├── config/                    # File konfigurasi database
│   └── database.php
├── controllers/               # Logika bisnis dan pemrosesan data
│   ├── auth_controller.php
│   ├── dashboard_controller.php
│   ├── kamar_controller.php
│   ├── kategori_controller.php
│   └── reservasi_controller.php
├── core/                      # File inti seperti pengecekan autentikasi
│   └── auth_check.php
├── views/                     # Semua file tampilan (HTML & PHP)
│   ├── auth/
│   ├── kalender/
│   ├── kamar/
│   ├── kategori/
│   ├── reservasi/
│   └── layouts/
├── uploads/                   # Tempat menyimpan gambar kamar yang di-upload
├── assets/                    # Aset statis seperti gambar atau CSS kustom
├── index.php                  # Router utama aplikasi
├── logout.php
└── README.md                  # File ini
```

---

### 🙏 Ucapan Terima Kasih

Proyek ini dikembangkan sebagai bagian dari proses belajar dan eksplorasi pengembangan web. Sebagian besar pengembangan, perbaikan bug, dan penambahan fitur dilakukan melalui sesi kolaboratif dengan AI Asisten Google, Gemini.