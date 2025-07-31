-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 30 juil. 2025 à 23:43
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_mutuelite`
--

-- --------------------------------------------------------

--
-- Structure de la table `adhesion`
--

CREATE TABLE `adhesion` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `membre` int(11) NOT NULL,
  `montant` double NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `adhesion`
--

INSERT INTO `adhesion` (`id`, `date`, `membre`, `montant`, `statut`) VALUES
(1, '2025-07-20', 1, 13, 0),
(5, '2025-07-26', 2, 10, 0);

-- --------------------------------------------------------

--
-- Structure de la table `annees`
--

CREATE TABLE `annees` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `libelle2` varchar(50) NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `annees`
--

INSERT INTO `annees` (`id`, `libelle`, `libelle2`, `statut`) VALUES
(1, '2025', '2026', 0);

-- --------------------------------------------------------

--
-- Structure de la table `cotisation`
--

CREATE TABLE `cotisation` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  `montant` double NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cotisation`
--

INSERT INTO `cotisation` (`id`, `date`, `description`, `type`, `montant`, `statut`) VALUES
(1, '2025-07-16', 'Assistance Glad ', 1, 12, 0),
(2, '2025-07-20', '', 0, 12, 0),
(3, '2025-07-25', 'assasasa', 2, 500, 0);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id`, `nom`, `postnom`, `prenom`, `email`, `adresse`, `fonction`, `pwd`, `photo`, `statut`, `approbation`) VALUES
(1, 'kombi', 'Muvunga', 'glad', 'kombiMuvaunga@glad.com', 'Procure', 'Gérant', '1234', 'JSB68763773a992e.jpg', 0, 1),
(2, 'Mumbere', 'Muyisa', 'Eloge', 'mumbere@gmail.com', 'Lobdon', 'Enseignant', '1234', 'JSB68856ab288d8e.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `adhesion` int(11) NOT NULL,
  `cotisation` int(11) NOT NULL,
  `montant` double NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `date`, `adhesion`, `cotisation`, `montant`, `statut`) VALUES
(1, '2025-07-28', 1, 1, 1, 0),
(2, '2025-07-28', 1, 1, 9, 0),
(3, '2025-07-28', 1, 3, 50, 0);

-- --------------------------------------------------------

--
-- Structure de la table `type_cotisation`
--

CREATE TABLE `type_cotisation` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `type_cotisation`
--

INSERT INTO `type_cotisation` (`id`, `description`, `statut`) VALUES
(1, 'Cotisation mensuel', 0),
(2, 'developement web', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adhesion`
--
ALTER TABLE `adhesion`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `annees`
--
ALTER TABLE `annees`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cotisation`
--
ALTER TABLE `cotisation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_cotisation`
--
ALTER TABLE `type_cotisation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adhesion`
--
ALTER TABLE `adhesion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `annees`
--
ALTER TABLE `annees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cotisation`
--
ALTER TABLE `cotisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `type_cotisation`
--
ALTER TABLE `type_cotisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
