-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 11 sep. 2025 à 08:53
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `site_enchere`
--

DROP DATABASE IF EXISTS site_enchere;
CREATE DATABASE site_enchere;
USE site_enchere;

-- --------------------------------------------------------

--
-- Structure de la table `afficher`
--

DROP TABLE IF EXISTS `afficher`;
CREATE TABLE IF NOT EXISTS `afficher` (
  `id_annonce` int NOT NULL,
  `id_commentaire` int NOT NULL,
  PRIMARY KEY (`id_annonce`,`id_commentaire`),
  KEY `id_commentaire` (`id_commentaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

DROP TABLE IF EXISTS `annonces`;
CREATE TABLE IF NOT EXISTS `annonces` (
  `id_annonce` int NOT NULL,
  `titre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_de_debut` datetime DEFAULT NULL,
  `date_de_fin` datetime DEFAULT NULL,
  `prix_en_cours` decimal(15,2) DEFAULT NULL,
  `prix_de_reserve` decimal(15,2) DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `fini` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_annonce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `associer`
--

DROP TABLE IF EXISTS `associer`;
CREATE TABLE IF NOT EXISTS `associer` (
  `id_annonce` int NOT NULL,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id_annonce`,`id_categorie`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id_client` int NOT NULL,
  `id_avis` int NOT NULL,
  PRIMARY KEY (`id_client`,`id_avis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL,
  `nom` enum('voiture','art','logement','vêtement','autre') COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_de_naissance` date DEFAULT NULL,
  `adresse` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ville` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_postale` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mdp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int NOT NULL,
  `description` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_commentaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `donner`
--

DROP TABLE IF EXISTS `donner`;
CREATE TABLE IF NOT EXISTS `donner` (
  `id_annonce` int NOT NULL,
  `id_client` int NOT NULL,
  `id_avis` int NOT NULL,
  PRIMARY KEY (`id_annonce`,`id_client`,`id_avis`),
  KEY `id_client` (`id_client`,`id_avis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enchere`
--

DROP TABLE IF EXISTS `enchere`;
CREATE TABLE IF NOT EXISTS `enchere` (
  `id_statistique` char(50) COLLATE utf8mb4_general_ci NOT NULL,
  `prix` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_` date DEFAULT NULL,
  PRIMARY KEY (`id_statistique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `encherir`
--

DROP TABLE IF EXISTS `encherir`;
CREATE TABLE IF NOT EXISTS `encherir` (
  `id_client` int NOT NULL,
  `id_statistique` char(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_client`,`id_statistique`),
  KEY `id_statistique` (`id_statistique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id_image` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_annonce` int NOT NULL,
  PRIMARY KEY (`id_image`),
  KEY `id_annonce` (`id_annonce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `interesser`
--

DROP TABLE IF EXISTS `interesser`;
CREATE TABLE IF NOT EXISTS `interesser` (
  `id_annonce` int NOT NULL,
  `id_client` int NOT NULL,
  PRIMARY KEY (`id_annonce`,`id_client`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `noter_client`
--

DROP TABLE IF EXISTS `noter_client`;
CREATE TABLE IF NOT EXISTS `noter_client` (
  `id_client` int NOT NULL,
  `id_client_1` int NOT NULL,
  PRIMARY KEY (`id_client`,`id_client_1`),
  KEY `id_client_1` (`id_client_1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `numeriser`
--

DROP TABLE IF EXISTS `numeriser`;
CREATE TABLE IF NOT EXISTS `numeriser` (
  `id_annonce` int NOT NULL,
  `id_statistique` char(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_annonce`,`id_statistique`),
  KEY `id_statistique` (`id_statistique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `numeriser_vu`
--

DROP TABLE IF EXISTS `numeriser_vu`;
CREATE TABLE IF NOT EXISTS `numeriser_vu` (
  `id_annonce` int NOT NULL,
  `id_vu` int NOT NULL,
  PRIMARY KEY (`id_annonce`,`id_vu`),
  KEY `id_vu` (`id_vu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `publier`
--

DROP TABLE IF EXISTS `publier`;
CREATE TABLE IF NOT EXISTS `publier` (
  `id_client` int NOT NULL,
  `id_commentaire` int NOT NULL,
  PRIMARY KEY (`id_client`,`id_commentaire`),
  KEY `id_commentaire` (`id_commentaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vendre`
--

DROP TABLE IF EXISTS `vendre`;
CREATE TABLE IF NOT EXISTS `vendre` (
  `id_annonce` int NOT NULL,
  `id_client` int NOT NULL,
  PRIMARY KEY (`id_annonce`,`id_client`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `visionner`
--

DROP TABLE IF EXISTS `visionner`;
CREATE TABLE IF NOT EXISTS `visionner` (
  `id_client` int NOT NULL,
  `id_vu` int NOT NULL,
  PRIMARY KEY (`id_client`,`id_vu`),
  KEY `id_vu` (`id_vu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vu`
--

DROP TABLE IF EXISTS `vu`;
CREATE TABLE IF NOT EXISTS `vu` (
  `id_vu` int NOT NULL,
  `nbr` int DEFAULT NULL,
  `date_` date DEFAULT NULL,
  PRIMARY KEY (`id_vu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `afficher`
--
ALTER TABLE `afficher`
  ADD CONSTRAINT `afficher_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`),
  ADD CONSTRAINT `afficher_ibfk_2` FOREIGN KEY (`id_commentaire`) REFERENCES `commentaire` (`id_commentaire`);

--
-- Contraintes pour la table `associer`
--
ALTER TABLE `associer`
  ADD CONSTRAINT `associer_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`),
  ADD CONSTRAINT `associer_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `donner`
--
ALTER TABLE `donner`
  ADD CONSTRAINT `donner_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`),
  ADD CONSTRAINT `donner_ibfk_2` FOREIGN KEY (`id_client`,`id_avis`) REFERENCES `avis` (`id_client`, `id_avis`);

--
-- Contraintes pour la table `encherir`
--
ALTER TABLE `encherir`
  ADD CONSTRAINT `encherir_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `encherir_ibfk_2` FOREIGN KEY (`id_statistique`) REFERENCES `enchere` (`id_statistique`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`);

--
-- Contraintes pour la table `interesser`
--
ALTER TABLE `interesser`
  ADD CONSTRAINT `interesser_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`),
  ADD CONSTRAINT `interesser_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `noter_client`
--
ALTER TABLE `noter_client`
  ADD CONSTRAINT `noter_client_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `noter_client_ibfk_2` FOREIGN KEY (`id_client_1`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `numeriser`
--
ALTER TABLE `numeriser`
  ADD CONSTRAINT `numeriser_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`),
  ADD CONSTRAINT `numeriser_ibfk_2` FOREIGN KEY (`id_statistique`) REFERENCES `enchere` (`id_statistique`);

--
-- Contraintes pour la table `numeriser_vu`
--
ALTER TABLE `numeriser_vu`
  ADD CONSTRAINT `numeriser_vu_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`),
  ADD CONSTRAINT `numeriser_vu_ibfk_2` FOREIGN KEY (`id_vu`) REFERENCES `vu` (`id_vu`);

--
-- Contraintes pour la table `publier`
--
ALTER TABLE `publier`
  ADD CONSTRAINT `publier_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `publier_ibfk_2` FOREIGN KEY (`id_commentaire`) REFERENCES `commentaire` (`id_commentaire`);

--
-- Contraintes pour la table `vendre`
--
ALTER TABLE `vendre`
  ADD CONSTRAINT `vendre_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`),
  ADD CONSTRAINT `vendre_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `visionner`
--
ALTER TABLE `visionner`
  ADD CONSTRAINT `visionner_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `visionner_ibfk_2` FOREIGN KEY (`id_vu`) REFERENCES `vu` (`id_vu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
