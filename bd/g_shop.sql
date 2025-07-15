-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 06:00 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `g_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `command`
--

CREATE TABLE `command` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` double NOT NULL,
  `photo` text NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `command`
--

INSERT INTO `command` (`id`, `date`, `description`, `quantite`, `prix`, `photo`, `statut`) VALUES
(1, '2024-10-16', 'Montre Plastique', 500, 2, 'G_Shop670f305d7f6e4.jpg', 0),
(2, '2024-10-16', 'Montre Chaine', 2000, 3, 'G_Shop671017eb22642.png', 0),
(3, '2024-10-16', 'Chainette Simple', 1000, 2, 'G_Shop67101fa57cd58.png', 0),
(4, '2024-10-17', 'chainette', 1000, 3, 'G_Shop671186be50475.jpg', 0),
(5, '2024-10-21', 'Bague', 5000, 3, 'G_Shop6716c169d80d8.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `commad` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `user`, `commad`, `quantite`, `statut`) VALUES
(1, 2, 1, 250, 0),
(2, 1, 1, 250, 0),
(3, 1, 2, 1500, 0),
(4, 2, 2, 500, 0),
(5, 1, 3, 1000, 0),
(6, 1, 4, 200, 0),
(7, 2, 4, 800, 0),
(8, 1, 5, 2500, 0),
(9, 2, 5, 2500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `postnom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `photo` text NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `statut` int(11) NOT NULL,
  `etat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nom`, `postnom`, `prenom`, `phone`, `photo`, `pwd`, `statut`, `etat`) VALUES
(1, 'dddddd', 'dd', 'Glad', '0876545373', 'IMG-20240714-WA0017.jpg', 'ddd', 0, 0),
(2, 'Rylah', 'Muv', 'RG', '0231456', 'istockphoto-1133566360-1024x1024.jpg', '1234', 0, 0),
(3, 'Gift', 'Samoja', 'mum', '098776', 'G_Shop6760890f77b06.jpg', '1234', 0, 0),
(4, 'Milhanne', 'muv', 'milhan', '09876534', 'G_Shop.jpg', '1234', 0, 0),
(5, 'Glad', 'Kombi', 'Rylah', '09877', 'G_Shop6760a5f25be0a.jpg', '1234', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ventes`
--

CREATE TABLE `ventes` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `Libelle` varchar(100) NOT NULL,
  `produit` int(11) NOT NULL,
  `quantité` int(11) NOT NULL,
  `prix` double NOT NULL,
  `participation` int(11) NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `command`
--
ALTER TABLE `command`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `command`
--
ALTER TABLE `command`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
