-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 03:39 PM
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
-- Database: `retail`
--
CREATE DATABASE IF NOT EXISTS `retail` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `retail`;

-- --------------------------------------------------------

--
-- Table structure for table `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `idmasuk` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `idtransaksii` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `namaproduk` varchar(60) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `idtransaksii`, `idproduk`, `namaproduk`, `harga`, `jumlah`, `sub_total`) VALUES
(7, 3, 1, 'Pepsi 250ml2', 7000, 1, 7000),
(8, 4, 1, 'Pepsi 250ml2', 7000, 23, 161000),
(12, 5, 1, 'Pepsi 250ml2', 7000, 4, 28000),
(13, 5, 2, 'Coca-Cola 250 ml', 3000, 56, 15000),
(14, 5, 3, 'Pepsi 250ml1', 3000, 4, 12000),
(19, 6, 2, 'Coca-Cola 250 ml', 3000, 4, 12000),
(20, 6, 3, 'Pepsi 250ml1', 3000, 3, 15000),
(21, 6, 1, 'Pepsi 250ml2', 70000, 4, 280000),
(22, 7, 1, 'Pepsi 250ml2', 70000, 4, 280000),
(23, 7, 2, 'Coca-Cola 250 ml', 3000, 3, 9000),
(24, 7, 3, 'Pepsi 250ml1', 3000, 55, 165000),
(25, 8, 1, 'Pepsi 250ml2', 70000, 4, 280000),
(26, 8, 2, 'Coca-Cola 250 ml', 3000, 55, 165000),
(27, 8, 3, 'Pepsi 250ml1', 3000, 55, 165000),
(28, 9, 1, 'Pepsi 250ml2', 70000, 6, 420000),
(29, 10, 1, 'Pepsi 250ml2', 70000, 3, 210000),
(30, 11, 1, 'Pepsi 250ml', 7000, 2, 14000),
(31, 11, 2, 'Coca-Cola 250 ml', 3000, 3, 9000),
(32, 11, 3, 'Sprite 250ml', 3000, 2, 6000);

-- --------------------------------------------------------

--
-- Table structure for table `idtransaksi`
--

CREATE TABLE `idtransaksi` (
  `nomor` int(11) NOT NULL,
  `idtransaksii` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `idtransaksi`
--

INSERT INTO `idtransaksi` (`nomor`, `idtransaksii`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `namaproduk` varchar(60) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `namaproduk`, `harga`, `stok`) VALUES
(1, 'Pepsi 250ml', 7000, 30),
(2, 'Coca-Cola 250 ml', 3000, 3),
(3, 'Sprite 250ml', 3000, 22);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idtransaksii` int(11) NOT NULL,
  `tanggaltransaksi` date NOT NULL DEFAULT current_timestamp(),
  `jumlahtransaksi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`idtransaksii`, `tanggaltransaksi`, `jumlahtransaksi`) VALUES
(2, '2024-06-09', 17000),
(3, '2024-06-09', 7000),
(10, '2024-06-09', 210000),
(30, '2024-07-10', 2000),
(31, '2024-08-14', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` int(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `username`, `password`) VALUES
(0, 'admin', 123456);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `idtransaksi`
--
ALTER TABLE `idtransaksi`
  ADD PRIMARY KEY (`nomor`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idtransaksii`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `idtransaksi`
--
ALTER TABLE `idtransaksi`
  MODIFY `nomor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
