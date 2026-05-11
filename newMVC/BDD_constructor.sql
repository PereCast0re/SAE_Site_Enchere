-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 17 jan. 2026 à 23:20
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

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

INSERT INTO `belongsto` (`id_product`, `id_category`) VALUES
(1, 1),
(2, 8),
(3, 4),
(4, 6),
(5, 1);

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

INSERT INTO `bid` (`id_product`, `id_user`, `current_price`, `new_price`, `bid_date`) VALUES
(3, 3, NULL, 50.00, '2026-01-18 00:09:08'),
(1, 5, NULL, 230.00, '2026-01-18 00:10:09'),
(1, 4, 230.00, 750.00, '2026-01-18 00:11:34'),
(1, 3, 750.00, 900.00, '2026-01-18 10:20:00'),
(1, 5, 900.00, 1200.00, '2026-01-18 11:10:00'),
(5, 4, NULL, 400.00, '2026-01-18 10:00:00'),
(5, 5, 400.00, 650.00, '2026-01-18 11:30:00'),
(5, 3, 650.00, 850.00, '2026-01-18 12:15:00');

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
  `statut` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_celebrity`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `celebrity`
--

INSERT INTO `celebrity` (`id_celebrity`, `name`, `url`, `statut`) VALUES
(1, 'Michael Schumacher', NULL, 1),
(2, 'Cristiano Ronaldo', NULL, 1),
(3, 'Angelina Jolie', NULL, 1),
(4, 'Banksy', NULL, 1),
(5, 'Daft Punk', NULL, 1),
(6, 'Furious Jumper', NULL, 0);

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

INSERT INTO `concerned` (`id_product`, `id_celebrity`) VALUES
(1, 2),
(2, 6),
(3, 3),
(4, 5),
(5, 1);

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

INSERT INTO `image` (`id_image`, `id_product`, `path_image`, `alt`) VALUES
(1, 1, 'Annonce/1/1_0.jpg', '1_0.jpg'),
(2, 1, 'Annonce/1/1_1.jpg', '1_1.jpg'),
(3, 2, 'Annonce/2/2_0.jpg', '2_0.jpg'),
(4, 3, 'Annonce/3/3_0.jpg', '3_0.jpg'),
(5, 3, 'Annonce/3/3_1.jpg', '3_1.jpg'),
(6, 4, 'Annonce/4/4_0.jpg', '4_0.jpg'),
(7, 4, 'Annonce/4/4_1.jpg', '4_1.jpg'),
(8, 5, 'Annonce/5/5_0.jpg', '5_0.jpg');

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

INSERT INTO `interest` (`id_product`, `id_user`) VALUES
(5, 3),
(3, 3),
(3, 5),
(1, 5),
(1, 4);

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

INSERT INTO `product` (`id_product`, `title`, `description`, `start_date`, `end_date`, `reserve_price`, `start_price`, `status`, `mailIsSent`) VALUES
(1, 'Lamborghini', 'D&eacute;couvrez une pi&egrave;ce automobile d&rsquo;exception : une Lamborghini ayant appartenu &agrave; Cristiano Ronaldo, l&rsquo;un des sportifs les plus c&eacute;l&egrave;bres et admir&eacute;s au monde. Ce v&eacute;hicule ne se contente pas d&rsquo;incarner la performance et l&rsquo;audace caract&eacute;ristiques de la marque italienne, il porte &eacute;galement l&rsquo;empreinte d&rsquo;une ic&ocirc;ne internationale dont le go&ucirc;t pour les supercars est reconnu dans le monde entier. Poss&eacute;der une Lamborghini issue de la collection personnelle de Ronaldo, c&rsquo;est acc&eacute;der &agrave; un niveau de prestige extr&ecirc;mement rare.\r\n\r\nCette Lamborghini se distingue par son design agressif, ses lignes ac&eacute;r&eacute;es et son allure r&eacute;solument sportive. Chaque courbe a &eacute;t&eacute; pens&eacute;e pour optimiser l&rsquo;a&eacute;rodynamisme et offrir une pr&eacute;sence visuelle incomparable. Sous le capot, le moteur d&eacute;livre une puissance impressionnante, offrant des acc&eacute;l&eacute;rations explosives et une tenue de route irr&eacute;prochable. La sonorit&eacute; profonde et envo&ucirc;tante du moteur rappelle imm&eacute;diatement l&rsquo;ADN Lamborghini : brut, intense et sans compromis. L&rsquo;habitacle, quant &agrave; lui, combine luxe et sportivit&eacute;, avec des mat&eacute;riaux haut de gamme, des finitions pr&eacute;cises et une ergonomie pens&eacute;e pour le plaisir de conduite.\r\n\r\nLe fait que ce mod&egrave;le ait appartenu &agrave; Cristiano Ronaldo lui conf&egrave;re une valeur historique et &eacute;motionnelle unique. L&rsquo;athl&egrave;te est connu pour entretenir ses v&eacute;hicules avec un soin m&eacute;ticuleux, et cette Lamborghini ne fait pas exception. Son &eacute;tat g&eacute;n&eacute;ral t&eacute;moigne d&rsquo;une attention constante et d&rsquo;un respect absolu pour la m&eacute;canique. Elle repr&eacute;sente non seulement une supercar d&rsquo;exception, mais aussi un objet de collection charg&eacute; d&rsquo;histoire, associ&eacute; &agrave; l&rsquo;un des plus grands joueurs de football de tous les temps.\r\n\r\nPropos&eacute;e aujourd&rsquo;hui aux ench&egrave;res, cette Lamborghini offre une opportunit&eacute; extr&ecirc;mement rare d&rsquo;acqu&eacute;rir un v&eacute;hicule prestigieux, alliant performance extr&ecirc;me, design iconique et provenance exceptionnelle. Que vous soyez collectionneur, passionn&eacute; d&rsquo;automobile ou investisseur, cette pi&egrave;ce unique constitue un ajout incomparable &agrave; tout patrimoine. Pr&eacute;parez-vous &agrave; prendre le volant d&rsquo;une v&eacute;ritable l&eacute;gende, &agrave; la fois m&eacute;canique et sportive.', '2025-01-06 00:00:00', '2026-02-08 00:00:00', NULL, 0.00, 1, 0),
(2, 'T01: La Vid&eacute;o de tous les dangers d&eacute;dicac&eacute;', 'Plongez dans l&rsquo;univers explosif et d&eacute;jant&eacute; de Furious Jumper avec ce premier tome intitul&eacute; La Vid&eacute;o de tous les dangers, une bande dessin&eacute;e inspir&eacute;e de l&rsquo;un des cr&eacute;ateurs de contenu les plus populaires de la sc&egrave;ne gaming francophone. Cette &eacute;dition rare et recherch&eacute;e est d&eacute;dicac&eacute;e, ce qui en fait un v&eacute;ritable objet de collection pour les fans comme pour les amateurs de BD modernes.\r\n\r\nDans ce premier volume, Furious Jumper se retrouve entra&icirc;n&eacute; dans une aventure aussi impr&eacute;visible que palpitante. Ce qui devait &ecirc;tre une simple vid&eacute;o se transforme rapidement en mission p&eacute;rilleuse, m&ecirc;lant humour, action et rebondissements. Le r&eacute;cit, rythm&eacute; et accessible, s&eacute;duira aussi bien les jeunes lecteurs que les passionn&eacute;s d&rsquo;univers fantastiques. Les illustrations dynamiques d&rsquo;Emmanuel Nhieu donnent vie &agrave; un monde color&eacute;, vivant et rempli de cr&eacute;atures &eacute;tonnantes, tout en conservant l&rsquo;esprit fun et &eacute;nergique du YouTuber.\r\n\r\nL&rsquo;exemplaire propos&eacute; ici b&eacute;n&eacute;ficie d&rsquo;une d&eacute;dicace authentique, ajoutant une dimension unique et personnelle &agrave; l&rsquo;ouvrage. Ce type d&rsquo;&eacute;dition est particuli&egrave;rement pris&eacute;, car il t&eacute;moigne d&rsquo;un lien direct entre l&rsquo;auteur, l&rsquo;artiste et le lecteur. Que vous soyez collectionneur, fan de Furious Jumper ou simplement amateur de belles BD, cette version d&eacute;dicac&eacute;e repr&eacute;sente une opportunit&eacute; rare d&rsquo;acqu&eacute;rir un tome &agrave; la fois divertissant, original et charg&eacute; de valeur sentimentale.\r\n\r\nEn excellent &eacute;tat et pr&ecirc;t &agrave; rejoindre une collection ou &agrave; &ecirc;tre offert, Furious Jumper T01 : La Vid&eacute;o de tous les dangers d&eacute;dicac&eacute; est une pi&egrave;ce incontournable pour tous ceux qui souhaitent poss&eacute;der un ouvrage unique, &agrave; la crois&eacute;e du gaming, de l&rsquo;aventure et de la bande dessin&eacute;e contemporaine.', '2024-12-17 00:00:00', '2026-02-26 00:00:00', NULL, 0.00, 0, 0),
(3, 'Un script de film', 'D&eacute;couvrez une pi&egrave;ce exceptionnelle du patrimoine cin&eacute;matographique : un script de film authentique annot&eacute; par Angelina Jolie, l&rsquo;une des actrices les plus influentes et respect&eacute;es de sa g&eacute;n&eacute;ration. Cet objet rare offre un acc&egrave;s privil&eacute;gi&eacute; aux coulisses de son travail, r&eacute;v&eacute;lant la pr&eacute;cision, la sensibilit&eacute; et l&rsquo;exigence artistique qui ont fa&ccedil;onn&eacute; sa carri&egrave;re internationale.\r\n\r\nCe script contient de v&eacute;ritables annotations manuscrites de l&rsquo;actrice : remarques sur les &eacute;motions &agrave; transmettre, indications de jeu, r&eacute;flexions personnelles sur certaines sc&egrave;nes, ajustements de dialogues ou notes techniques destin&eacute;es &agrave; affiner son interpr&eacute;tation. Ces traces directes de son processus cr&eacute;atif conf&egrave;rent &agrave; l&rsquo;ouvrage une valeur unique, &agrave; la fois historique et artistique. Chaque page t&eacute;moigne de l&rsquo;implication profonde d&rsquo;Angelina Jolie dans la construction de ses personnages, offrant un regard intime sur sa m&eacute;thode de travail.\r\n\r\nAu-del&agrave; de son int&eacute;r&ecirc;t cin&eacute;phile, ce script repr&eacute;sente un objet de collection prestigieux, recherch&eacute; par les passionn&eacute;s de cin&eacute;ma, les admirateurs de l&rsquo;actrice et les collectionneurs d&rsquo;artefacts hollywoodiens. Sa provenance, associ&eacute;e &agrave; une figure embl&eacute;matique du cin&eacute;ma contemporain, en fait une pi&egrave;ce rare dont la valeur ne cesse de cro&icirc;tre. Conserv&eacute; avec soin, l&rsquo;exemplaire est en excellent &eacute;tat, pr&eacute;servant parfaitement les annotations et la structure originale du document.\r\n\r\nPropos&eacute; aujourd&rsquo;hui aux ench&egrave;res, ce script annot&eacute; par Angelina Jolie constitue une opportunit&eacute; exceptionnelle d&rsquo;acqu&eacute;rir un objet charg&eacute; d&rsquo;histoire, t&eacute;moin direct du travail d&rsquo;une artiste mondialement reconnue. Une pi&egrave;ce unique, &agrave; la crois&eacute;e de l&rsquo;art, du cin&eacute;ma et de la m&eacute;moire culturelle, pr&ecirc;te &agrave; rejoindre une collection d&rsquo;exception.', '2025-08-14 00:00:00', '2026-02-05 00:00:00', NULL, 0.00, 1, 0),
(4, 'Casque audio', 'Plongez au c&oelig;ur de la l&eacute;gende &eacute;lectro fran&ccedil;aise avec ce casque authentique ayant appartenu &agrave; Daft Punk, le duo mythique qui a marqu&eacute; l&rsquo;histoire de la musique &eacute;lectronique mondiale. V&eacute;ritable symbole de leur identit&eacute; artistique, le casque repr&eacute;sente bien plus qu&rsquo;un simple accessoire : c&rsquo;est une ic&ocirc;ne culturelle, un fragment tangible de l&rsquo;univers myst&eacute;rieux et futuriste qui a fa&ccedil;onn&eacute; leur succ&egrave;s plan&eacute;taire.\r\n\r\nCe mod&egrave;le, soigneusement conserv&eacute;, refl&egrave;te l&rsquo;esth&eacute;tique unique du groupe : lignes &eacute;pur&eacute;es, design avant‑gardiste et finition impeccable. Chaque d&eacute;tail rappelle l&rsquo;aura &eacute;nigmatique de Thomas Bangalter et Guy‑Manuel de Homem‑Christo, qui ont fait du casque un &eacute;l&eacute;ment central de leur image publique. Port&eacute; lors de sessions de travail ou d&rsquo;&eacute;v&eacute;nements priv&eacute;s, cet objet rare t&eacute;moigne de l&rsquo;exigence artistique et du perfectionnisme qui ont toujours caract&eacute;ris&eacute; le duo.\r\n\r\nL&rsquo;&eacute;tat g&eacute;n&eacute;ral du casque est remarquable, pr&eacute;servant son allure embl&eacute;matique et son caract&egrave;re collector. Sa provenance, associ&eacute;e &agrave; l&rsquo;un des groupes les plus influents de la sc&egrave;ne &eacute;lectro, lui conf&egrave;re une valeur exceptionnelle. Les objets li&eacute;s &agrave; Daft Punk sont extr&ecirc;mement recherch&eacute;s, notamment depuis la fin officielle du duo, ce qui renforce encore l&rsquo;int&eacute;r&ecirc;t historique et &eacute;motionnel de cette pi&egrave;ce.\r\n\r\nPropos&eacute; aujourd&rsquo;hui aux ench&egrave;res, ce casque repr&eacute;sente une opportunit&eacute; unique d&rsquo;acqu&eacute;rir un objet charg&eacute; d&rsquo;histoire, intimement li&eacute; &agrave; l&rsquo;un des plus grands ph&eacute;nom&egrave;nes musicaux de notre &eacute;poque. Que vous soyez collectionneur, passionn&eacute; de musique, amateur de culture pop ou investisseur, cette pi&egrave;ce iconique constitue un ajout incomparable &agrave; toute collection prestigieuse.', '2026-01-01 00:00:00', '2026-01-18 00:01:02', 800.00, 0.00, 1, 1),
(5, 'Casque de course', 'D&eacute;couvrez une pi&egrave;ce exceptionnelle de l&rsquo;histoire du sport automobile : un casque authentique port&eacute; par Michael Schumacher, le pilote le plus titr&eacute; de la Formule 1 moderne et une v&eacute;ritable l&eacute;gende du sport. Cet objet rare incarne &agrave; lui seul la passion, la pr&eacute;cision et l&rsquo;intensit&eacute; qui ont marqu&eacute; la carri&egrave;re du septuple champion du monde.\r\n\r\nCe casque, imm&eacute;diatement reconnaissable par son design embl&eacute;matique, refl&egrave;te l&rsquo;identit&eacute; visuelle forte de Schumacher : couleurs vives, motifs distinctifs et finitions soign&eacute;es. Port&eacute; lors de sessions officielles, il t&eacute;moigne de l&rsquo;engagement total du pilote, de sa concentration extr&ecirc;me et de son style de pilotage unique. Chaque trace d&rsquo;usure, chaque d&eacute;tail de la coque raconte une histoire, celle d&rsquo;un champion qui a repouss&eacute; les limites de la performance et marqu&eacute; &agrave; jamais l&rsquo;histoire de la F1.\r\n\r\nConserv&eacute; avec le plus grand soin, ce casque pr&eacute;sente un &eacute;tat remarquable pour un objet de cette importance. Sa provenance, associ&eacute;e &agrave; l&rsquo;un des sportifs les plus admir&eacute;s au monde, lui conf&egrave;re une valeur historique et &eacute;motionnelle exceptionnelle. Les pi&egrave;ces authentiques li&eacute;es &agrave; Michael Schumacher sont extr&ecirc;mement recherch&eacute;es par les collectionneurs, et leur raret&eacute; ne cesse d&rsquo;accro&icirc;tre leur prestige et leur valeur sur le march&eacute;.\r\n\r\nPropos&eacute; aujourd&rsquo;hui aux ench&egrave;res, ce casque repr&eacute;sente une opportunit&eacute; unique d&rsquo;acqu&eacute;rir un objet mythique, symbole d&rsquo;une carri&egrave;re hors du commun. Que vous soyez passionn&eacute; de Formule 1, collectionneur d&rsquo;objets sportifs ou investisseur averti, cette pi&egrave;ce iconique constitue un ajout incomparable &agrave; toute collection d&rsquo;exception. Un v&eacute;ritable fragment de l&eacute;gende, pr&ecirc;t &agrave; rejoindre les mains d&rsquo;un nouveau propri&eacute;taire.', '2025-12-31 00:00:00', '2026-02-08 00:00:00', NULL, 0.00, 1, 0);

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

INSERT INTO `productview` (`id_product`, `id_user`, `view_number`, `view_date`) VALUES
(5, 3, 1, '2026-01-18 00:08:38'),
(3, 5, 1, '2026-01-18 00:09:01'),
(1, 3, 1, '2026-01-18 00:10:01'),
(1, 4, 1, '2026-01-18 10:05:00'),
(1, 5, 1, '2026-01-18 10:10:00'),
(1, 4, 1, '2026-01-18 12:30:00'),
(5, 4, 1, '2026-01-18 11:00:00'),
(5, 5, 1, '2026-01-18 11:45:00'),
(5, 3, 1, '2026-01-18 13:00:00');

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

INSERT INTO `published` (`id_user`, `id_product`) VALUES
(3, 1),
(3, 2),
(5, 3),
(5, 4),
(3, 5);

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

INSERT INTO `users` (`id_user`, `name`, `firstname`, `birth_date`, `address`, `city`, `postal_code`, `email`, `password`, `newsletter`, `admin`) VALUES
(3, 'test', 'test', '2026-01-12', 'blablabla', 'blablabla', '58000', 'test@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$SXZsLktHM2l3UlhLSTdCeQ$IxIV3pjNBb/fOFk5PCudTrHyGS1Xdw7VeEIshnanyhg', 0, 0),
(4, 'admin', 'admin', '2026-01-12', 'blablabla', 'blablabla', '58000', 'admin@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$b1Y2WUF1UXBCbTdyZW55Ng$LOqQ4IgcRdKmKzCwhUKrgn5afyfZUDP83FepnbOIrVQ', 0, 1),
(5, 'Garnier', 'Jimmy', '2026-10-11', 'blablabla', 'blablabla', '58000', 'jimmygarnier11@outlook.fr', '$argon2id$v=19$m=65536,t=4,p=1$ejJQRGFFY3IzU2NSVy9pdA$ITH3RZq/iaKL/tAa0xlO2v4kjhIpRwATHxhZVfKuZ2Y', 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
