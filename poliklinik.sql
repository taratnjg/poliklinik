-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2024 at 03:48 PM
-- Server version: 5.7.33
-- PHP Version: 8.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poliklinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`) VALUES
(5, 'Tempora rem at cillu123', 'Omnis est aspernatu', '+1 (467) 663-6665');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_hp`) VALUES
(2, 'Enim ea occaecat ali123', 'Sed tempora in dolor123', '+1 (779) 501-5485123'),
(4, 'Harum nihil ex illo ', 'Quisquam tenetur exc', '+1 (581) 365-3635'),
(5, 'Ut incididunt et dol', 'Eaque labore totam q', '+1 (836) 403-5155');

-- --------------------------------------------------------

--
-- Table structure for table `periksa`
--

CREATE TABLE `periksa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pasien` bigint(20) UNSIGNED DEFAULT NULL,
  `id_dokter` int(10) UNSIGNED DEFAULT NULL,
  `tgl_periksa` datetime DEFAULT NULL,
  `catatan` text,
  `obat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `periksa`
--

INSERT INTO `periksa` (`id`, `id_pasien`, `id_dokter`, `tgl_periksa`, `catatan`, `obat`) VALUES
(1, 2, 5, '2019-10-01 21:11:00', 'Minima deleniti veni', NULL),
(3, 4, 5, '1978-07-03 18:06:00', 'Quisquam veritatis l111', NULL),
(4, 5, 5, '1986-09-19 10:01:00', 'Laboriosam quis ani', 'Fugiat et quo paria'),
(5, 4, 5, '1994-09-13 10:42:00', 'Incidunt qui aperia', 'Fugit nihil tenetur');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'rudun', '$2y$10$tmTgz5jmvCUZuMgl.OH2GO/ApRkIl/Nc4AN6XNXDZatylvklgV8UC'),
(2, 'mipuzuza', '$2y$10$RFpDdRIzn.4CW0AtH0Z8J.IeZASx6yAux54lIhXxKH54H0kycr7ky'),
(5, 'habeh', '$2y$10$5loS9eYyAenX0NwNLNqVdOSiq.FmEZYs.1buWl5Y7KvBPDl3YeK7K'),
(6, 'puvara', '$2y$10$f7QiXDIFwwU0QP.1sV4My.3ildXuniayRuKbHV2IQvepyOL5fQEwa'),
(7, 'kidukix', '$2y$10$y7z4dNTFb9RKYtHa0OygJ.x7T5APKp3PCKDgvp8h6qWpkC4WdqlmG'),
(8, 'xumeg', '$2y$10$5I6KLZlRgjMmIQiUHRSlqeoPIX/cI4ne.WEKmStf0LztNl/N4IcYG'),
(10, 'zohutofe', '$2y$10$xYGKxur6E2Ku3Ud/4.oafe3c50slqo6PAZRRD9/MSDc6.icOYiWby');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `periksa_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `periksa_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
