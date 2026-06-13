-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2026 at 01:29 PM
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
-- Database: `maung_boba`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'pending',
  `order_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `total`, `created_at`, `status`, `order_code`) VALUES
(1, NULL, 25000, '2026-04-12 07:53:24', 'pending', NULL),
(2, NULL, 23000, '2026-04-12 08:01:15', 'pending', NULL),
(3, NULL, 47000, '2026-04-12 08:19:41', 'pending', NULL),
(4, NULL, 42000, '2026-04-12 08:31:56', 'pending', NULL),
(5, NULL, 25000, '2026-04-12 08:44:45', 'pending', NULL),
(6, 'Customer', 35000, '2026-04-17 03:11:17', 'pending', NULL),
(7, 'Customer', 25000, '2026-04-17 03:11:28', 'pending', NULL),
(8, 'Customer', 25000, '2026-04-17 03:11:38', 'pending', NULL),
(9, 'Customer', 10000, '2026-04-17 03:17:38', 'selesai', NULL),
(10, 'Customer', 25000, '2026-04-17 03:21:28', 'selesai', NULL),
(11, 'nurul', 20000, '2026-04-20 07:19:28', 'selesai', NULL),
(12, 'irfan', 20000, '2026-04-20 07:32:38', 'selesai', NULL),
(13, 'nurul', 20000, '2026-04-20 07:44:53', 'selesai', NULL),
(14, 'ariel', 44000, '2026-04-20 07:56:32', 'selesai', NULL),
(15, 'halo', 45000, '2026-04-20 08:12:52', 'selesai', NULL),
(16, 'nurul', 15000, '2026-04-22 03:44:47', 'selesai', NULL),
(17, 'Nurul', 115000, '2026-04-27 06:19:38', 'pending', 'MB-E570BC'),
(18, 'nurul', 50000, '2026-04-27 06:20:14', 'pending', 'MB-7BD12F'),
(19, 'nurul', 25000, '2026-04-27 06:21:04', 'pending', 'MB-EC4CE5'),
(20, 'dd', 50000, '2026-04-27 06:36:12', 'pending', 'MB-93C3D8');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `subtotal`, `note`) VALUES
(1, 1, 17, 1, 25000, '3def'),
(2, 2, 13, 1, 23000, 'halo'),
(3, 3, 15, 1, 27000, ''),
(4, 3, 16, 1, 20000, ''),
(5, 4, 15, 1, 27000, ''),
(6, 4, 18, 1, 15000, ''),
(7, 5, 2, 1, 25000, 'nbjj'),
(8, 6, 18, 1, 15000, '|'),
(9, 6, 1, 1, 20000, 'Sedikit Extra |'),
(10, 7, 2, 1, 25000, 'Normal Normal |'),
(11, 8, 2, 1, 25000, 'Normal Normal |'),
(12, 9, 25, 1, 10000, 'Normal Normal |'),
(13, 10, 2, 1, 25000, 'Normal Normal |'),
(14, 11, 6, 1, 20000, NULL),
(15, 12, 3, 1, 20000, NULL),
(16, 13, 3, 1, 20000, 'Normal | Normal'),
(17, 14, 5, 2, 44000, 'Gula: Normal | Es: Normal'),
(18, 15, 7, 1, 25000, 'Gula: Normal | Es: Normal'),
(19, 15, 23, 1, 20000, 'pepep'),
(20, 16, 18, 1, 15000, 'aril'),
(21, 17, 4, 3, 75000, NULL),
(22, 17, 1, 2, 40000, NULL),
(23, 18, 2, 2, 50000, NULL),
(24, 19, 2, 1, 25000, NULL),
(25, 20, 2, 2, 50000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `image`, `created_at`, `category`, `description`) VALUES
(1, 'Alpukat Medium', 20000, 10, 'alpukatmedium.jpeg', '2026-04-11 13:49:50', 'boba', 'Rasa alpukat creamy, manisnya pas, bikin nagih di setiap tegukan.'),
(2, 'Alpukat Large', 25000, 10, 'alpukatlarge.jpeg', '2026-04-11 13:49:50', 'boba', 'Alpukat lebih banyak, lebih puas. Cocok buat kamu yang lagi butuh mood booster.'),
(3, 'Cappuccino Medium', 20000, 10, 'capucinomedium.jpeg', '2026-04-11 13:49:50', 'boba', 'Cappuccino lembut dengan rasa kopi yang ringan, santai tapi tetap berasa.'),
(4, 'Cappuccino Large', 25000, 10, 'capucinolarge.jpeg', '2026-04-11 13:49:50', 'boba', 'Cappuccino ukuran besar, nikmatin kopi lebih lama tanpa buru-buru habis.'),
(5, 'Caramel Medium', 22000, 10, 'caramelmedium.jpeg', '2026-04-11 13:49:50', 'boba', 'Perpaduan caramel manis dan susu creamy, simple tapi enak banget.'),
(6, 'Coklat Medium', 20000, 10, 'coklatmedium.jpeg', '2026-04-11 13:49:50', 'boba', 'Coklat klasik yang manis dan hangat di hati, cocok buat semua suasana.'),
(7, 'Coklat Large', 25000, 10, 'coklatlarge.jpeg', '2026-04-11 13:49:50', 'boba', 'Coklat lebih banyak, lebih puas, cocok buat kamu pecinta manis.'),
(8, 'Green Tea Medium', 20000, 10, 'greentemedium.jpeg', '2026-04-11 13:49:50', 'boba', 'Green tea yang ringan dan segar, bikin tenang di setiap tegukan.'),
(9, 'Green Tea Large', 25000, 10, 'greentealarge.jpeg', '2026-04-11 13:49:50', 'boba', 'Green tea ukuran besar, pas buat nemenin santai lebih lama.'),
(10, 'Oreo Medium', 20000, 10, 'oreomedium.jpeg', '2026-04-11 13:49:50', 'boba', 'Oreo creamy dengan rasa khas yang selalu jadi favorit semua orang.'),
(11, 'Oreo Large', 25000, 10, 'oreolarge.jpeg', '2026-04-11 13:49:50', 'boba', 'Oreo lebih banyak, lebih seru, sekali minum langsung happy.'),
(12, 'Original Medium', 18000, 10, 'originalmedium.jpeg', '2026-04-11 13:49:50', 'boba', 'Rasa original yang simpel, ringan, tapi tetap enak diminum kapan aja.'),
(13, 'Original Large', 23000, 10, 'originallarge.jpeg', '2026-04-11 13:49:50', 'boba', 'Versi besar dari original, lebih puas tanpa ribet milih.'),
(14, 'Repepet Medium', 22000, 10, 'repepetmedium.jpeg', '2026-04-11 13:49:50', 'boba', 'Rasa unik dan beda, cocok buat kamu yang pengen coba sesuatu baru.'),
(15, 'Repepet Large', 27000, 10, 'repepetlarge.jpeg', '2026-04-11 13:49:50', 'boba', 'Lebih banyak, lebih berasa. Minuman yang beda dari yang lain.'),
(16, 'Taro Medium', 20000, 10, 'taromedium.jpeg', '2026-04-11 13:49:50', 'boba', 'Taro lembut dengan rasa manis khas, bikin mood langsung naik.'),
(17, 'Taro Large', 25000, 10, 'tarolarge.jpeg', '2026-04-11 13:49:50', 'boba', 'Taro ukuran besar, creamy dan bikin kenyang lebih lama.'),
(18, 'Burger', 15000, 10, 'burger.jpeg', '2026-04-11 13:49:50', 'toast', 'Burger simpel tapi mantap, pas buat ganjel lapar cepat.'),
(19, 'Roti Bakar', 12000, 10, 'rotbak.jpeg', '2026-04-11 13:49:50', 'toast', 'Roti bakar hangat dengan rasa klasik yang selalu bikin nyaman.'),
(20, 'Toast Telor Keju', 15000, 10, 'toasttelorkeju.jpeg', '2026-04-11 13:49:50', 'toast', 'Perpaduan telur dan keju yang gurih, cocok buat sarapan santai.'),
(21, 'Telor Keju', 12000, 10, 'telorkeju.jpeg', '2026-04-11 13:49:50', 'toast', 'Telur dan keju yang sederhana tapi selalu bikin nagih.'),
(22, 'Daging Keju', 18000, 10, 'dagingkeju.jpeg', '2026-04-11 13:49:50', 'toast', 'Daging dan keju gurih, cocok buat kamu yang lagi lapar berat.'),
(23, 'Daging Telor Keju', 20000, 10, 'dagingtelurkeju.jpeg', '2026-04-11 13:49:50', 'toast', 'Kombo lengkap daging, telur, dan keju. Kenyang, puas, mantap.'),
(25, 'Tato', 10000, 10, 'tato.jpeg', '2026-04-11 13:49:50', 'lainnya', 'Menu santai buat ngemil ringan, simple tapi tetap enak.'),
(26, 'Grass Jelly Original', 12000, 50, 'default.png', '2026-04-15 08:28:00', 'grass', 'Grass jelly segar dengan rasa ringan, cocok diminum saat panas.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
