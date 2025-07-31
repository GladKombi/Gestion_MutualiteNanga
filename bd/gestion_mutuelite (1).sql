-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2025 at 11:11 AM
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
-- Database: `gestion_mutuelite`
--

-- --------------------------------------------------------

--
-- Table structure for table `adhesion`
--

CREATE TABLE `adhesion` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `membre` int(11) NOT NULL,
  `montant` double NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adhesion`
--

INSERT INTO `adhesion` (`id`, `date`, `membre`, `montant`, `statut`) VALUES
(1, '2025-07-20', 1, 13, 0);

-- --------------------------------------------------------

--
-- Table structure for table `annees`
--

CREATE TABLE `annees` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `libelle2` varchar(50) NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `annees`
--

INSERT INTO `annees` (`id`, `libelle`, `libelle2`, `statut`) VALUES
(1, '2025', '2026', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cotisation`
--

CREATE TABLE `cotisation` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  `montant` double NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cotisation`
--

INSERT INTO `cotisation` (`id`, `date`, `description`, `type`, `montant`, `statut`) VALUES
(1, '2025-07-16', 'Assistance Glad ', 1, 12, 0),
(2, '2025-07-20', '', 0, 12, 0),
(3, '2025-07-25', 'assasasa', 2, 500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `postnom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `adresse` text NOT NULL,
  `fonction` varchar(100) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `photo` text NOT NULL,
  `statut` int(11) NOT NULL,
  `approbation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`id`, `nom`, `postnom`, `prenom`, `email`, `adresse`, `fonction`, `pwd`, `photo`, `statut`, `approbation`) VALUES
(1, 'kombi', 'Muvunga', 'glad', 'kombiMuvaunga@glad.com', 'Procure', 'Gérant', '1234', 'JSB68763773a992e.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paiement`
--

CREATE TABLE `paiement` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `adhesion` int(11) NOT NULL,
  `cotisation` int(11) NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_cotisation`
--

CREATE TABLE `type_cotisation` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type_cotisation`
--

INSERT INTO `type_cotisation` (`id`, `description`, `statut`) VALUES
(1, 'Cotisation mensuel', 0),
(2, 'developement web', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adhesion`
--
ALTER TABLE `adhesion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `annees`
--
ALTER TABLE `annees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotisation`
--
ALTER TABLE `cotisation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_cotisation`
--
ALTER TABLE `type_cotisation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adhesion`
--
ALTER TABLE `adhesion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `annees`
--
ALTER TABLE `annees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cotisation`
--
ALTER TABLE `cotisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_cotisation`
--
ALTER TABLE `type_cotisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
