-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2026 at 11:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kedai_maung_fiks`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_menu`, `qty`, `subtotal`, `catatan`) VALUES
(1, 1, 29, 1, 18000, 'irfan'),
(2, 2, 29, 1, 18000, ''),
(3, 3, 29, 1, 18000, 'halo'),
(4, 4, 46, 1, 25000, 'hlo'),
(5, 5, 37, 1, 18000, ''),
(6, 6, 50, 1, 32000, ''),
(7, 6, 48, 1, 25000, ''),
(8, 7, 27, 1, 18000, 'irfan'),
(9, 7, 29, 1, 18000, 'halo'),
(10, 8, 27, 1, 18000, 'kurangin gula'),
(11, 8, 29, 1, 18000, 'bobanya dikit aja'),
(12, 9, 29, 1, 18000, 'manis'),
(13, 10, 28, 1, 22000, 'manis'),
(14, 11, 50, 1, 32000, 'halo'),
(15, 12, 49, 1, 28000, ''),
(16, 12, 47, 1, 22000, 'bro'),
(17, 13, 29, 1, 18000, ''),
(18, 14, 45, 1, 20000, ''),
(19, 15, 27, 1, 18000, ''),
(20, 15, 28, 1, 22000, 'manis'),
(22, 17, 27, 1, 18000, 'boba bayakin'),
(23, 18, 27, 1, 18000, 'irfan'),
(24, 19, 26, 2, 44000, 'boba banyak'),
(25, 20, 28, 1, 22000, 'halo'),
(26, 21, 29, 1, 18000, 'ppp'),
(27, 22, 29, 1, 18000, 'hjduj'),
(28, 23, 26, 1, 22000, 'manis'),
(29, 24, 27, 1, 18000, ''),
(30, 25, 27, 1, 18000, ''),
(31, 25, 29, 1, 18000, ''),
(32, 26, 27, 1, 18000, 'manis'),
(33, 26, 26, 1, 22000, 'es banyak'),
(34, 27, 26, 1, 22000, 'lebih manis'),
(35, 28, 26, 1, 22000, ''),
(36, 29, 26, 1, 22000, 'manis'),
(37, 30, 29, 1, 18000, 'BANYAKIN GULA'),
(38, 31, 29, 1, 18000, ''),
(39, 32, 29, 2, 36000, 'less sugar'),
(40, 33, 26, 1, 22000, ''),
(41, 34, 27, 1, 18000, 'tambahkan gula lebih banyak'),
(42, 35, 26, 1, 22000, ''),
(43, 36, 27, 1, 18000, 'cepetan'),
(44, 37, 26, 1, 22000, ''),
(45, 38, 26, 1, 22000, ''),
(46, 39, 26, 1, 22000, ''),
(47, 40, 26, 1, 22000, 'Tambahkan gula'),
(48, 41, 26, 1, 22000, 'Tambahkan gula'),
(49, 42, 49, 1, 28000, ''),
(50, 42, 26, 1, 22000, ''),
(51, 42, 29, 1, 18000, ''),
(52, 43, 26, 1, 22000, ''),
(53, 43, 47, 1, 22000, ''),
(54, 44, 26, 1, 22000, ''),
(55, 45, 26, 1, 22000, ''),
(56, 46, 49, 1, 28000, ''),
(57, 47, 26, 1, 22000, ''),
(58, 48, 26, 1, 22000, ''),
(59, 49, 38, 1, 22000, ''),
(60, 50, 26, 1, 22000, ''),
(61, 51, 26, 1, 22000, ''),
(62, 52, 26, 1, 22000, ''),
(63, 53, 26, 1, 22000, ''),
(64, 54, 26, 1, 22000, ''),
(65, 55, 26, 1, 22000, ''),
(66, 56, 26, 1, 22000, ''),
(67, 57, 26, 1, 22000, ''),
(68, 58, 26, 1, 22000, ''),
(69, 59, 26, 1, 22000, ''),
(70, 60, 26, 1, 22000, ''),
(71, 61, 26, 1, 22000, ''),
(72, 62, 26, 1, 22000, ''),
(73, 63, 26, 1, 22000, ''),
(74, 64, 26, 1, 22000, ''),
(75, 65, 26, 1, 22000, ''),
(76, 66, 28, 1, 22000, ''),
(77, 67, 28, 1, 22000, ''),
(78, 68, 27, 1, 18000, ''),
(79, 69, 29, 1, 18000, ''),
(80, 70, 29, 1, 18000, ''),
(81, 71, 26, 1, 22000, ''),
(82, 72, 27, 1, 18000, ''),
(83, 73, 26, 1, 22000, ''),
(84, 74, 26, 1, 22000, ''),
(85, 75, 26, 1, 22000, ''),
(86, 76, 26, 1, 22000, ''),
(87, 77, 26, 1, 22000, ''),
(88, 78, 30, 1, 22000, ''),
(89, 79, 26, 1, 22000, ''),
(90, 80, 26, 1, 22000, ''),
(91, 81, 26, 1, 22000, ''),
(92, 82, 26, 1, 22000, ''),
(93, 83, 26, 1, 22000, ''),
(94, 84, 26, 1, 22000, ''),
(95, 85, 26, 1, 22000, ''),
(96, 86, 26, 1, 22000, '');

--
-- Triggers `detail_pesanan`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok` AFTER INSERT ON `detail_pesanan` FOR EACH ROW UPDATE menu

SET stok = stok - NEW.qty

WHERE id_menu = NEW.id_menu
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Minuman'),
(2, 'Makanan');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('tersedia','habis') DEFAULT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `id_kategori`, `nama_menu`, `harga`, `deskripsi`, `gambar`, `status`, `stok`) VALUES
(26, 1, 'Alpukat Large', 22000, 'Minuman alpukat ukuran large', 'alpukatlarge.jpeg', 'tersedia', 785),
(27, 1, 'Alpukat Medium', 18000, 'Minuman alpukat ukuran medium', 'alpukatmedium.jpeg', 'tersedia', 96),
(28, 1, 'Capucino Large', 22000, 'Capucino ukuran large', 'capucinolarge.jpeg', 'tersedia', 796),
(29, 1, 'Capucino Medium', 18000, 'Capucino ukuran medium', 'capucinomedium.jpeg', 'tersedia', 85),
(30, 1, 'Caramel Large', 22000, 'Minuman caramel ukuran large', 'caramellarge.jpeg', 'tersedia', 799),
(31, 1, 'Caramel Medium', 18000, 'Minuman caramel ukuran medium', 'caramelmedium.jpeg', 'tersedia', 800),
(32, 1, 'Coklat Large', 22000, 'Minuman coklat ukuran large', 'coklatlarge.jpeg', 'tersedia', 800),
(33, 1, 'Coklat Medium', 18000, 'Minuman coklat ukuran medium', 'coklatmedium.jpeg', 'tersedia', 800),
(34, 1, 'Green Tea Large', 22000, 'Green tea ukuran large', 'greentealarge.jpeg', 'tersedia', 800),
(35, 1, 'Green Tea Medium', 18000, 'Green tea ukuran medium', 'greentemedium.jpeg', 'tersedia', 800),
(36, 1, 'Oreo Large', 22000, 'Minuman oreo ukuran large', 'oreolarge.jpeg', 'tersedia', 800),
(37, 1, 'Oreo Medium', 18000, 'Minuman oreo ukuran medium', 'oreomedium.jpeg', 'tersedia', 800),
(38, 1, 'Original Large', 22000, 'Minuman original ukuran large', 'originallarge.jpeg', 'tersedia', 800),
(39, 1, 'Original Medium', 18000, 'Minuman original ukuran medium', 'originalmedium.jpeg', 'tersedia', 800),
(40, 1, 'Repepet Large', 22000, 'Minuman repepet ukuran large', 'repepetlarge.jpeg', 'tersedia', 800),
(41, 1, 'Repepet Medium', 18000, 'Minuman repepet ukuran medium', 'repepetmedium.jpeg', 'tersedia', 100),
(42, 1, 'Taro Large', 22000, 'Minuman taro ukuran large', 'tarolarge.jpeg', 'tersedia', 100),
(43, 1, 'Taro Medium', 18000, 'Minuman taro ukuran medium', 'taromedium.jpeg', 'tersedia', 100),
(44, 2, 'Burger', 28000, 'Burger beef spesial', 'burger.jpeg', 'tersedia', 0),
(45, 2, 'Roti Bakar', 20000, 'Roti bakar spesial', 'rotbak.jpeg', 'tersedia', 0),
(46, 2, 'Toast Telor Keju', 25000, 'Toast isi telor dan keju', 'toasttelorkeju.jpeg', 'tersedia', 0),
(47, 2, 'Telor Keju', 22000, 'Roti telor keju', 'telorkeju.jpeg', 'tersedia', 98),
(48, 2, 'Daging Keju', 25000, 'Roti isi daging dan keju', 'dagingkeju.jpeg', 'tersedia', 0),
(49, 2, 'Daging Telur Keju', 28000, 'Roti isi daging telur keju', 'dagingtelurkeju.jpeg', 'tersedia', 95),
(50, 2, 'Double Daging Telur Keju', 18000, 'Double daging telur keju', 'dobledagingtelurkeju.jpeg', 'tersedia', 10);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `kode_pesanan` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `status_pesanan` enum('menunggu','diproses','selesai') DEFAULT NULL,
  `nomor_antrian` int(11) DEFAULT NULL,
  `nama_pemesan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `kode_pesanan`, `tanggal`, `total_harga`, `status_pesanan`, `nomor_antrian`, `nama_pemesan`) VALUES
(59, 'ORD20260608000345', '2026-06-08 07:03:45', 22000, 'selesai', 1, 'kopi'),
(60, 'ORD20260608001013', '2026-06-08 07:10:13', 22000, 'selesai', 2, 'kopi'),
(61, 'ORD20260608002204', '2026-06-08 07:22:04', 22000, 'selesai', 3, 'kopi'),
(62, 'ORD20260608003726', '2026-06-08 07:37:26', 22000, 'selesai', 4, 'kopi'),
(63, 'ORD20260608004446', '2026-06-08 07:44:46', 22000, 'selesai', 5, 'kopi'),
(64, 'ORD20260608005537', '2026-06-08 07:55:37', 22000, 'selesai', 6, 'kopi'),
(65, 'ORD20260608011021', '2026-06-08 08:10:21', 22000, 'selesai', 7, 'kopi'),
(66, 'ORD20260608012158', '2026-06-08 08:21:58', 22000, 'selesai', 8, 'kopi'),
(67, 'ORD20260608013055', '2026-06-08 08:30:55', 22000, 'selesai', 9, 'kopi'),
(68, 'ORD20260608013529', '2026-06-08 08:35:29', 18000, 'selesai', 10, 'kopi'),
(69, 'ORD20260608014221', '2026-06-08 08:42:21', 18000, 'selesai', 11, 'kopi'),
(70, 'ORD20260608014258', '2026-06-08 08:42:58', 18000, 'selesai', 12, 'kopi'),
(71, 'ORD20260608014558', '2026-06-08 08:45:58', 22000, 'selesai', 13, 'Ariel'),
(72, 'ORD20260612235240', '2026-06-13 06:52:40', 18000, 'selesai', 14, 'kopi'),
(73, 'ORD20260613001105', '2026-06-13 07:11:05', 22000, 'selesai', 15, 'kopi1'),
(74, 'ORD20260613001824', '2026-06-13 07:18:24', 22000, 'selesai', 16, 'kopi12'),
(75, 'ORD20260613002330', '2026-06-13 07:23:30', 22000, 'selesai', 17, 'kopi123'),
(76, 'ORD20260613002519', '2026-06-13 07:25:19', 22000, 'selesai', 18, 'kopi1234'),
(77, 'ORD20260613004043', '2026-06-13 07:40:43', 22000, 'selesai', 77, 'liongbulan'),
(78, 'ORD20260613004044', '2026-06-13 07:40:44', 22000, 'selesai', 78, 'ariel'),
(79, 'ORD20260613004355', '2026-06-13 07:43:55', 22000, 'selesai', 79, 'okeoke'),
(80, 'ORD20260613004356', '2026-06-13 07:43:56', 22000, 'selesai', 80, 'sipppp'),
(81, 'ORD20260613005007', '2026-06-13 07:50:07', 22000, 'selesai', 81, 'oke'),
(82, 'ORD20260613005415', '2026-06-13 07:54:15', 22000, 'selesai', 82, 'ok'),
(83, 'ORD20260613005518', '2026-06-13 07:55:18', 22000, 'selesai', 83, 'okeh'),
(84, 'ORD20260613005519', '2026-06-13 07:55:19', 22000, 'selesai', 84, 'sipppah'),
(85, 'ORD20260613005657', '2026-06-13 07:56:57', 22000, 'selesai', 85, 'sipppahh'),
(86, 'ORD20260613005701', '2026-06-13 07:57:01', 22000, 'selesai', 86, 'okehh');

--
-- Triggers `pesanan`
--
DELIMITER $$
CREATE TRIGGER `after_insert_pesanan` AFTER INSERT ON `pesanan` FOR EACH ROW INSERT INTO status_pesanan(

id_pesanan,
status,
waktu_update

)

VALUES(

NEW.id_pesanan,
NEW.status_pesanan,
NOW()

)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `status_pesanan`
--

CREATE TABLE `status_pesanan` (
  `id_status` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `status` enum('menunggu','diproses','selesai') DEFAULT NULL,
  `waktu_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_pesanan`
--

INSERT INTO `status_pesanan` (`id_status`, `id_pesanan`, `status`, `waktu_update`) VALUES
(37, 59, 'menunggu', '2026-06-08 07:03:45'),
(38, 60, 'menunggu', '2026-06-08 07:10:13'),
(39, 61, 'menunggu', '2026-06-08 07:22:04'),
(40, 62, 'menunggu', '2026-06-08 07:37:26'),
(41, 63, 'menunggu', '2026-06-08 07:44:46'),
(42, 64, 'menunggu', '2026-06-08 07:55:37'),
(43, 65, 'menunggu', '2026-06-08 08:10:21'),
(44, 66, 'menunggu', '2026-06-08 08:21:58'),
(45, 67, 'menunggu', '2026-06-08 08:30:55'),
(46, 68, 'menunggu', '2026-06-08 08:35:29'),
(47, 69, 'menunggu', '2026-06-08 08:42:21'),
(48, 70, 'menunggu', '2026-06-08 08:42:58'),
(49, 71, 'menunggu', '2026-06-08 08:45:58'),
(50, 72, 'menunggu', '2026-06-13 06:52:40'),
(51, 73, 'menunggu', '2026-06-13 07:11:05'),
(52, 74, 'menunggu', '2026-06-13 07:18:24'),
(53, 75, 'menunggu', '2026-06-13 07:23:30'),
(54, 76, 'menunggu', '2026-06-13 07:25:19'),
(55, 77, 'menunggu', '2026-06-13 07:40:43'),
(56, 78, 'menunggu', '2026-06-13 07:40:44'),
(57, 79, 'menunggu', '2026-06-13 07:43:55'),
(58, 80, 'menunggu', '2026-06-13 07:43:56'),
(59, 81, 'menunggu', '2026-06-13 07:50:07'),
(60, 82, 'menunggu', '2026-06-13 07:54:15'),
(61, 83, 'menunggu', '2026-06-13 07:55:18'),
(62, 84, 'menunggu', '2026-06-13 07:55:19'),
(63, 85, 'menunggu', '2026-06-13 07:56:57'),
(64, 86, 'menunggu', '2026-06-13 07:57:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `role` enum('admin') DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`, `foto`) VALUES
(1, 'Pemilik', '7488e331b8b64e5794da3fa4eb10ad5d', 'Rahmat Jarkasih', 'admin', '1780847280_Screenshot 2026-06-07 224056.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_detail_pesanan` (`id_pesanan`),
  ADD KEY `fk_detail_menu` (`id_menu`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `fk_menu_kategori` (`id_kategori`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD UNIQUE KEY `nomor_antrian` (`nomor_antrian`);

--
-- Indexes for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  ADD PRIMARY KEY (`id_status`),
  ADD KEY `fk_status_pesanan` (`id_pesanan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  ADD CONSTRAINT `fk_detail_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detail_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menu_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL,
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  ADD CONSTRAINT `fk_status_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `status_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
