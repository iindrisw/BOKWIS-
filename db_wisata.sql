-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2026 at 04:51 PM
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
-- Database: `db_wisata`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `foto`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator Wisata', '1779164089_admin.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `id_destinasi` int(11) DEFAULT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tanggal_wisata` date NOT NULL,
  `jumlah_tiket` int(11) NOT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `status_bayar` enum('Pending','Lunas') DEFAULT 'Pending',
  `waktu_transaksi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id_booking`, `id_destinasi`, `nama_user`, `email`, `tanggal_wisata`, `jumlah_tiket`, `total_bayar`, `status_bayar`, `waktu_transaksi`) VALUES
(1, 5, 'Rifa\'ah Fatihatu Sa\'adah', 'rifa@gmail.com', '2026-12-05', 1, 15000, 'Lunas', '2026-05-18 22:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `destinasi`
--

CREATE TABLE `destinasi` (
  `id_destinasi` int(11) NOT NULL,
  `nama_wisata` varchar(100) NOT NULL,
  `kategori` enum('Alam','Gunung','Pantai') NOT NULL,
  `harga_tiket` int(11) DEFAULT 50000,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `maps` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinasi`
--

INSERT INTO `destinasi` (`id_destinasi`, `nama_wisata`, `kategori`, `harga_tiket`, `deskripsi`, `gambar`, `maps`) VALUES
(1, 'Gunung Ciremai', 'Gunung', 50000, NULL, 'c1.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31687.728428234554!2d108.38606686441699!3d-6.894663952902141!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f3d455552df21%3A0xb2853e1d35351916!2sTaman%20Nasional%20Gunung%20Ciremai!5e0!3m2!1sid!2sid!4v1779200149030!5m2!1sid!2sid'),
(2, 'Bukit SahyangDora', 'Gunung', 20000, NULL, 'sd1.jpeg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.2343754811486!2d108.35917987356245!3d-6.741239965912392!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f217e4cdaf53f%3A0x8e19f26647af1f6c!2sPuncak%20Bukit%20Sanghyangdora!5e0!3m2!1sid!2sid!4v1779200189106!5m2!1sid!2sid'),
(3, 'Pantai Tiris', 'Pantai', 20000, NULL, 'tiris2.webp', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15864.206215206601!2d108.30060715541988!3d-6.256939299999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ebb4ee9a62899%3A0x44dace8e4dd5d9c1!2sPantai%20Tiris%20Indramayu!5e0!3m2!1sid!2sid!4v1779200236623!5m2!1sid!2sid'),
(4, 'Pantai Balongan Indah', 'Pantai', 15000, NULL, 'bali1.webp', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31722.28765563821!2d108.36683856386479!3d-6.357019540257621!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ebe5099984bc7%3A0xa4324214cb8373e1!2sPantai%20Balongan%20Indah!5e0!3m2!1sid!2sid!4v1779200300592!5m2!1sid!2sid'),
(5, 'Curug Cilengkrang', 'Alam', 15000, NULL, 'cile1.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5850099768036!2d108.44683387356568!3d-6.94009791793489!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1635bc1cd5dd%3A0xb40d8ca361ae6084!2sWisata%20Alam%20Lembah%20Cilengkrang!5e0!3m2!1sid!2sid!4v1779198842810!5m2!1sid!2sid'),
(6, 'Situ Cipanten', 'Alam', 25000, NULL, 'cp1.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15846.241852714635!2d108.3091473678466!3d-6.8231880431055725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f2406b0ed6805%3A0x86493d5c4d863bc5!2sWisata%20Situ%20Cipanten!5e0!3m2!1sid!2sid!4v1779200336470!5m2!1sid!2sid'),
(22, 'Terasering Panyaweuyan', 'Alam', 12000, NULL, '1779979171_467.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7725777463456!2d108.34353927356533!3d-6.917770267704602!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f3cbd246b010d%3A0xb911177c0565c856!2sTerasering%20Panyaweuyan!5e0!3m2!1sid!2sid!4v1779201296439!5m2!1sid!2sid'),
(23, 'Gunung Ciwaru', 'Gunung', 10000, NULL, '1779979183_163.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.5952191974566!2d108.3688753735638!3d-6.8189856666954585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f23d619683f09%3A0x36df2f053f5a8856!2sGunung%20Ciwaru!5e0!3m2!1sid!2sid!4v1779201341633!5m2!1sid!2sid'),
(24, 'Curug Muara Jaya', 'Alam', 15000, NULL, '1779979203_918.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.30000881294!2d108.3349258679568!3d-6.911516942610636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f3cb99da1693f%3A0xd217ba4a61824031!2sWisata%20Alam%20Curug%20Muara%20Jaya!5e0!3m2!1sid!2sid!4v1779201379262!5m2!1sid!2sid'),
(25, 'Curug Ibun Pelangi', 'Alam', 12000, NULL, '1779979220_860.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8731534899307!2d108.32663127356523!3d-6.905768367581169!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f3b543272e9ef%3A0x751449b26abc7650!2sAir%20Terjun%20IBUN%20PELANGI!5e0!3m2!1sid!2sid!4v1779201419665!5m2!1sid!2sid'),
(26, 'Cibuntu', 'Alam', 15000, NULL, '1779979234_818.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63380.06118084102!2d108.38508778623812!3d-6.860153024015287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f2281f376dea1%3A0x1b557c018dbe8d41!2sCibuntu%2C%20Kec.%20Pasawahan%2C%20Kabupaten%20Kuningan%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1779201451783!5m2!1sid!2sid');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int(11) NOT NULL,
  `id_destinasi` int(11) DEFAULT NULL,
  `foto_wisata` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id_review` int(11) NOT NULL,
  `id_destinasi` int(11) DEFAULT NULL,
  `nama_user` varchar(100) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `komentar` text DEFAULT NULL,
  `foto_review` varchar(255) DEFAULT NULL,
  `tanggal_review` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id_review`, `id_destinasi`, `nama_user`, `rating`, `komentar`, `foto_review`, `tanggal_review`) VALUES
(1, 1, 'Anonim', 2, 'WAW', '', '2026-04-14 07:07:46'),
(2, 1, 'Anonim', 1, 'JELEK', '1776150522_Screenshot 2026-04-13 225556.png', '2026-04-14 07:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT 'default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `username`, `email`, `password`, `foto_profil`, `created_at`) VALUES
(3, 'Rifa\'ah Fatihatu Sa\'adah', 'rifa', 'rifa@gmail.com', '27f44a4c926d2ad3e9f5827b491450d0', 'default.png', '2026-05-19 03:40:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `fk_destinasi` (`id_destinasi`);

--
-- Indexes for table `destinasi`
--
ALTER TABLE `destinasi`
  ADD PRIMARY KEY (`id_destinasi`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`),
  ADD KEY `id_destinasi` (`id_destinasi`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `id_destinasi` (`id_destinasi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `destinasi`
--
ALTER TABLE `destinasi`
  MODIFY `id_destinasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_destinasi` FOREIGN KEY (`id_destinasi`) REFERENCES `destinasi` (`id_destinasi`) ON DELETE CASCADE;

--
-- Constraints for table `galeri`
--
ALTER TABLE `galeri`
  ADD CONSTRAINT `galeri_ibfk_1` FOREIGN KEY (`id_destinasi`) REFERENCES `destinasi` (`id_destinasi`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`id_destinasi`) REFERENCES `destinasi` (`id_destinasi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
