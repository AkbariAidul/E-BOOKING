-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2025 at 09:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_kamar` varchar(150) NOT NULL,
  `harga_per_malam` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id`, `id_kategori`, `nama_kamar`, `harga_per_malam`, `stok`, `deskripsi`, `gambar`) VALUES
(1, 1, 'Consequat Dignissim', 1000000.00, 0, 'Ut doloremque possim', 'kamar_6858bf6652561_1750646630.png'),
(2, 4, 'Sunt quod sunt dol', 53.00, 3, 'Similique amet omni', 'kamar_685c4e12535f7_1750879762.png');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Consequuntur reprehe', 'Nisi eius dolores es'),
(4, 'Quia ipsum temporib', 'Vel rerum quas dolor');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id` int(11) NOT NULL,
  `id_kamar` int(11) NOT NULL,
  `jumlah_kamar` int(11) NOT NULL DEFAULT 1,
  `nama_pemesan` varchar(100) NOT NULL,
  `email_pemesan` varchar(100) NOT NULL,
  `telepon_pemesan` varchar(25) DEFAULT NULL,
  `tgl_checkin` date NOT NULL,
  `tgl_checkout` date NOT NULL,
  `jumlah_malam` int(11) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id`, `id_kamar`, `jumlah_kamar`, `nama_pemesan`, `email_pemesan`, `telepon_pemesan`, `tgl_checkin`, `tgl_checkout`, `jumlah_malam`, `total_harga`, `status`, `created_at`) VALUES
(1, 1, 1, 'Qui esse recusandae', 'bivih@mailinator.com', '+1 (675) 266-5558', '2025-06-26', '2025-06-27', 1, 1000000.00, 'Completed', '2025-06-25 18:29:45'),
(2, 1, 1, 'Officiis ullam labor', 'honafu@mailinator.com', '+1 (499) 313-9577', '2025-06-26', '2025-06-27', 1, 1000000.00, 'Confirmed', '2025-06-25 18:45:43'),
(3, 2, 15, 'Est cillum accusanti', 'xebikelu@mailinator.com', '+1 (575) 973-3938', '2025-06-26', '2025-06-27', 1, 795.00, 'Confirmed', '2025-06-25 19:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `username`, `password`, `created_at`) VALUES
(1, 'Administrator', 'admin', '$2y$10$fWJgR1lAf5OUC2Jd2U.A/uLz1d.3e1sB2.M6.2wPn7aV5i8a.s8XG', '2025-06-23 02:14:57'),
(2, 'sanah', 'sanah', '$2y$10$TSHqm5ECKjJUKsmAPeKqaOD2XVFFMar.vDVYxKS4PMqzdWvCsmaLO', '2025-06-23 03:43:34'),
(3, 'anaa', 'naa', '$2y$10$h3h01phnKCJQGKMNok4ti.7mdc2AgY/JDb9NSgt9XIiQ0l6AZx5nW', '2025-06-25 17:24:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kamar` (`id_kamar`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kamar`
--
ALTER TABLE `kamar`
  ADD CONSTRAINT `kamar_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
