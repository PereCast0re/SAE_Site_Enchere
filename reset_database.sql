-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 17 jan. 2026 à 23:20
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

DROP DATABASE IF EXISTS auction_site;
CREATE DATABASE auction_site;
USE auction_site;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `auction_site`
--

-- --------------------------------------------------------

--
-- Structure de la table `belongsto`
--

DROP TABLE IF EXISTS `belongsto`;
CREATE TABLE IF NOT EXISTS `belongsto` (
  `id_product` int NOT NULL,
  `id_category` int NOT NULL,
  PRIMARY KEY (`id_product`,`id_category`),
  KEY `id_category` (`id_category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `belongsto`
--

-- --------------------------------------------------------

--
-- Structure de la table `bid`
--

DROP TABLE IF EXISTS `bid`;
CREATE TABLE IF NOT EXISTS `bid` (
  `id_product` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `current_price` decimal(15,2) DEFAULT NULL,
  `new_price` decimal(15,2) DEFAULT NULL,
  `bid_date` datetime DEFAULT NULL,
  KEY `id_user` (`id_user`),
  KEY `fk_bid_product` (`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bid`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `name`, `statut`) VALUES
(1, 'Automobile', 1),
(2, 'Sportif', 1),
(3, 'Artiste', 1),
(4, 'Acteur', 1),
(5, 'Dessinateur', 1),
(6, 'Musicien', 1),
(7, 'Informatique', 1),
(8, 'Influenceur', 0);

-- --------------------------------------------------------

--
-- Structure de la table `celebrity`
--

DROP TABLE IF EXISTS `celebrity`;
CREATE TABLE IF NOT EXISTS `celebrity` (
  `id_celebrity` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `license` varchar(200) DEFAULT NULL,
  `artist` varchar(200) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_celebrity`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `celebrity`
--

INSERT INTO `celebrity` (`id_celebrity`, `name`, `url`, `license`, `artist`, `statut`) VALUES
(1, 'Michael Schumacher', NULL, NULL, NULL, 1),
(2, 'Cristiano Ronaldo', NULL, NULL, NULL, 1),
(3, 'Angelina Jolie', NULL, NULL, NULL, 1),
(4, 'Banksy', NULL, NULL, NULL, 1),
(5, 'Daft Punk', NULL, NULL, NULL, 1),
(6, 'Furious Jumper', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id_product` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `comment` varchar(550) DEFAULT NULL,
  `comment_date` datetime DEFAULT NULL,
  KEY `id_user` (`id_user`),
  KEY `fk_comment_product` (`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `concerned`
--

DROP TABLE IF EXISTS `concerned`;
CREATE TABLE IF NOT EXISTS `concerned` (
  `id_product` int NOT NULL,
  `id_celebrity` int NOT NULL,
  PRIMARY KEY (`id_product`,`id_celebrity`),
  KEY `id_celebrity` (`id_celebrity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `concerned`
--

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id_image` int NOT NULL AUTO_INCREMENT,
  `id_product` int DEFAULT NULL,
  `path_image` varchar(250) DEFAULT NULL,
  `alt` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_image`),
  KEY `fk_image_product` (`id_product`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `image`
--

-- --------------------------------------------------------

--
-- Structure de la table `interest`
--

DROP TABLE IF EXISTS `interest`;
CREATE TABLE IF NOT EXISTS `interest` (
  `id_product` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  KEY `id_user` (`id_user`),
  KEY `fk_interest_product` (`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `interest`
--

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id_product` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `reserve_price` decimal(15,2) DEFAULT NULL,
  `start_price` decimal(15,2) DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0',
  `mailIsSent` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_product`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `product`
--

-- --------------------------------------------------------

--
-- Structure de la table `productview`
--

DROP TABLE IF EXISTS `productview`;
CREATE TABLE IF NOT EXISTS `productview` (
  `id_product` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `view_number` int DEFAULT NULL,
  `view_date` datetime DEFAULT NULL,
  KEY `id_user` (`id_user`),
  KEY `fk_productview_product` (`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `productview`
--

-- --------------------------------------------------------

--
-- Structure de la table `published`
--

DROP TABLE IF EXISTS `published`;
CREATE TABLE IF NOT EXISTS `published` (
  `id_user` int NOT NULL,
  `id_product` int NOT NULL,
  KEY `id_user` (`id_user`),
  KEY `fk_published_product` (`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `published`
--

-- --------------------------------------------------------

--
-- Structure de la table `rating`
--

DROP TABLE IF EXISTS `rating`;
CREATE TABLE IF NOT EXISTS `rating` (
  `id_buyer` int DEFAULT NULL,
  `id_seller` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  KEY `id_buyer` (`id_buyer`),
  KEY `id_seller` (`id_seller`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT '0',
  `admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
