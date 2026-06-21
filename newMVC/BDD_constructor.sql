-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : dim. 21 juin 2026 à 08:07
-- Version du serveur : 8.0.46
-- Version de PHP : 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS auction_site;
CREATE DATABASE auction_site;
USE auction_site;


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

CREATE TABLE `belongsto` (
  `id_product` int NOT NULL,
  `id_category` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `belongsto`
--

INSERT INTO `belongsto` (`id_product`, `id_category`) VALUES
(6, 4),
(7, 4),
(8, 3),
(9, 3),
(10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `bid`
--

CREATE TABLE `bid` (
  `id_product` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `current_price` decimal(15,2) DEFAULT NULL,
  `new_price` decimal(15,2) DEFAULT NULL,
  `bid_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bid`
--

INSERT INTO `bid` (`id_product`, `id_user`, `current_price`, `new_price`, `bid_date`) VALUES
(10, 7, NULL, 15.00, '2026-06-21 08:05:27');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE `celebrity` (
  `id_celebrity` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `license` varchar(200) DEFAULT NULL,
  `artist` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `celebrity`
--

INSERT INTO `celebrity` (`id_celebrity`, `name`, `license`, `artist`, `url`, `statut`) VALUES
(1, 'Michael Schumacher', NULL, NULL, NULL, 1),
(2, 'Cristiano Ronaldo', NULL, NULL, NULL, 1),
(3, 'Angelina Jolie', NULL, NULL, NULL, 1),
(4, 'Banksy', NULL, NULL, NULL, 1),
(5, 'Daft Punk', NULL, NULL, NULL, 1),
(6, 'Furious Jumper', NULL, NULL, NULL, 0),
(60, 'Pierre Niney', NULL, NULL, NULL, 0),
(8, 'Fabrice Luchini', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/9/93/Fabrice_Luchini_2010.jpg', 1),
(9, 'Matt Damon', 'CC BY-SA 4.0', 'Martin Kraft', 'https://upload.wikimedia.org/wikipedia/commons/5/52/MKr347638_Matt_Damon_%28Small_Things_Like_These%2C_Berlinale_2024%29.jpg', 1),
(10, 'Sean Penn', 'CC BY-SA 3.0', '<bdi><a href=\"https://www.wikidata.org/wiki/Q640\" class=\"extiw\" title=\"d:Q640\"><span title=\"German photographer; former vice chair of Wikimedia Deutschland\">Harald Krichel</span></a></bdi>', 'https://upload.wikimedia.org/wikipedia/commons/3/3d/Superpower_%282023%29-60535.jpg', 1),
(11, 'Robert Downey Jr.', 'CC BY-SA 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/photos/gageskidmore\">Gage Skidmore</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/94/Robert_Downey_Jr_2014_Comic_Con_%28cropped%29.jpg', 1),
(12, 'Bradley Cooper', 'CC BY 4.0', 'Raph_PH', 'https://upload.wikimedia.org/wikipedia/commons/a/a7/Bradley_Cooper.jpg', 1),
(13, 'Georges Pernoud', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Pymouss\" title=\"User:Pymouss\">Pymouss</a>', 'https://upload.wikimedia.org/wikipedia/commons/6/6b/FIG_2015_-_Georges_Pernoud_01.jpg', 1),
(14, 'Hugo Manos', NULL, NULL, NULL, 1),
(15, 'Morgan Freeman', 'Public domain', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/127934495@N07\">DoD News Features</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/93/Academy_Award-winning_actor_Morgan_Freeman_narrates_for_the_opening_ceremony_%2826904746425%29_%28cropped%29_3.jpg', 1),
(16, 'Daniel Radcliffe', 'CC BY-SA 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/22007612@N05\">Gage Skidmore</a> from Peoria, AZ, United States of America', 'https://upload.wikimedia.org/wikipedia/commons/3/3b/Daniel_Radcliffe_in_July_2015.jpg', 1),
(17, 'Asghar Farhadi', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:FrankieF\" class=\"mw-redirect\" title=\"User:FrankieF\">Frankie Fouganthin</a>', 'https://upload.wikimedia.org/wikipedia/commons/4/47/Asghar_Farhadi_in_2018-2_%28cropped%29.jpg', 1),
(18, 'Colman Domingo', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:LucaFazPhoto\" title=\"User:LucaFazPhoto\">LucaFazPhoto</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/96/Colman_Domingo_at_82nd_Venice_International_Film_Festival-1.jpg', 1),
(19, 'Franck Gastambide', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/3/33/Franck_Gastambide_2013.jpg', 1),
(20, 'Taylor Sheridan', NULL, NULL, NULL, 1),
(21, 'Patrick Ridremont', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Micha%C3%ABl_Bemelmans&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Michaël Bemelmans (page does not exist)\">Michaël Bemelmans</a>', 'https://upload.wikimedia.org/wikipedia/commons/5/5d/PATRICK_RIDREMONT_2012_FIFF.jpg', 1),
(22, 'Antoine de Maximy', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Pymouss\" title=\"User:Pymouss\">Pymouss</a>', 'https://upload.wikimedia.org/wikipedia/commons/7/7e/FIL_2013_-_Antoine_de_Maximy_06.JPG', 1),
(23, 'Éric Caravaca', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:YanRB\" title=\"User:YanRB\">YanRB</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/27/Eric_Caravaca_2013.jpg', 1),
(24, 'Tristán Ulloa', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Trisulloa2020&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Trisulloa2020 (page does not exist)\">Trisulloa2020</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/34/TRISTAN_ULLOA-3.jpg', 1),
(25, 'Henry Winkler', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/27238804@N03\">Super Festivals</a> from Ft. Lauderdale, USA', 'https://upload.wikimedia.org/wikipedia/commons/0/07/Henry_Winkler_%2843968252532%29.jpg', 1),
(26, 'Yvan Le Bolloc\'h', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Eriotac\" title=\"User:Eriotac\">Eriotac</a>', 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Yvan_le_Bolloch.jpg', 1),
(27, 'Tepr', NULL, NULL, NULL, 1),
(28, 'Rohan Marley', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/26728047@N05\">pop culture geek</a> from Los Angeles, CA, USA', 'https://upload.wikimedia.org/wikipedia/commons/e/e7/CES_2012_-_House_of_Marley_%28Rohan_Marley%29.jpg', 1),
(29, 'Fabrice Lepaul', NULL, NULL, NULL, 1),
(30, 'Brice Maubleu', 'CC0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Supporterh%C3%A9ninois&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Supporterhéninois (page does not exist)\">Supporterhéninois</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/29/RC_Lens_-_Grenoble_Foot_38_%2824-11-2018%29_9.jpg', 1),
(31, 'Jean Butez', 'CC0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Supporterh%C3%A9ninois&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Supporterhéninois (page does not exist)\">Supporterhéninois</a>', 'https://upload.wikimedia.org/wikipedia/commons/5/53/Jean_Butez_%28cropped%29.jpg', 1),
(32, 'Didier Santini', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Pichasso\" title=\"User:Pichasso\">Pichasso</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/2d/Didier_Santini_USLD.jpg', 1),
(33, 'Kevin Ndjomo', NULL, NULL, NULL, 1),
(34, 'Nasdas', 'CC BY 3.0', 'Nasser Sari', 'https://upload.wikimedia.org/wikipedia/commons/4/4d/Nasdas_en_2025.png', 1),
(35, 'Roman Doduik', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:MisterDorli&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:MisterDorli (page does not exist)\">MisterDorli</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/39/Roman_Doduik.jpg', 1),
(36, 'Adrien Laurent', 'CC BY 3.0', 'Break-Out Company', 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Arien_Laurent_en_2019.png', 1),
(37, 'Mila Orriols', NULL, NULL, NULL, 1),
(38, 'Just Riadh', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:YanRB\" title=\"User:YanRB\">YanRB</a>', 'https://upload.wikimedia.org/wikipedia/commons/7/7a/Just_Riadh_2025.jpg', 1),
(39, 'Léna Situations', 'CC BY-SA 4.0', 'yoann lothaire | other viewnewsmedia', 'https://upload.wikimedia.org/wikipedia/commons/a/a2/L%C3%A9na_Situations_2021.png', 1),
(40, 'Emma Chamberlain', 'CC BY-SA 2.0', 'Patou Cornette', 'https://upload.wikimedia.org/wikipedia/commons/3/31/Emma_Chamberlain_at_%2721_Paris_Fashion_Week_%28cropped%29.jpg', 1),
(41, 'Antoine Daniel', 'Public domain', 'Unknown author<span style=\"display: none;\">Unknown author</span>', 'https://upload.wikimedia.org/wikipedia/commons/4/43/North_American_Martyrs.jpg', 1),
(42, 'Technoblade', NULL, NULL, NULL, 1),
(43, 'Niko Omilana', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.youtube.com/@SoccerAidforUnicef\">Soccer Aid</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/3c/Niko_Omilana_in_2023.png', 1),
(44, 'Johan Lelièvre', NULL, NULL, NULL, 1),
(45, 'Simon Rex', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.youtube.com/channel/UCRUQaKw9apN9AXBiC_VwzQQ\">Lyn Fairly Media</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/9a/Simon_Rex_during_an_interview%2C_March_2022.jpg', 1),
(46, 'Willy Dumbo', 'CC0', '<a href=\"//commons.wikimedia.org/wiki/User:Blessingedi76\" title=\"User:Blessingedi76\">Blessingedi76</a>', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/La_C%C3%A9r%C3%A9monie_de_NISA_2024_31.jpg', 1),
(47, 'Frédéric Lopez', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Frantogian\" title=\"User:Frantogian\">Frantogian</a>', 'https://upload.wikimedia.org/wikipedia/commons/d/d0/Fr%C3%A9d%C3%A9ric_Lopez_-_Monte-Carlo_Television_Festival.jpg', 1),
(48, 'Philippe Risoli', NULL, NULL, NULL, 1),
(49, 'Julien Courbet', 'CC BY-SA 4.0', 'Loreinatv', 'https://upload.wikimedia.org/wikipedia/commons/d/da/Julien_Courbet_sanspub%28cropped%29.jpg', 1),
(50, 'Cyril Féraud', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:XIIIfromTOKYO\" title=\"User:XIIIfromTOKYO\">XIIIfromTOKYO</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/3c/FIL_2016_-_Cyril_F%C3%A9raud_4735.jpg', 1),
(51, 'Jean-Philippe Mayence', NULL, NULL, NULL, 1),
(52, 'Vincent Mc Doom', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/3/38/Vincent_Mc_Doom_Cannes_2015.jpg', 1),
(53, 'Mia Khalifa', 'CC BY 3.0', 'Mia Khalifa', 'https://upload.wikimedia.org/wikipedia/commons/9/9c/Mia_Khalifa_in_2016.jpg', 1),
(54, 'Tiffany Trump', 'Public domain', 'Ali Shaker/VOA', 'https://upload.wikimedia.org/wikipedia/commons/0/0d/Tiffany_Trump_RNC_July_2016.jpg', 1),
(55, 'Meryem Benoua', NULL, NULL, NULL, 1),
(56, 'Richard Chanfray', 'Public domain', 'Angelo Deligio / Mondadori via Getty Images', 'https://upload.wikimedia.org/wikipedia/commons/c/c2/RichardChambray-Dalida-Italie-1975.png', 1),
(57, 'Laeticia Hallyday', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/9/90/Laeticia_Hallyday_Cannes_2009.jpg', 1),
(58, 'Tori Spelling', 'CC BY-SA 2.0', 'Gage Skidmore', 'https://upload.wikimedia.org/wikipedia/commons/b/b5/ToriSpelling2018.jpg', 1),
(59, 'Hunter Schafer', 'CC BY-SA 4.0', '<bdi><a href=\"https://www.wikidata.org/wiki/Q640\" class=\"extiw\" title=\"d:Q640\"><span title=\"German photographer; former vice chair of Wikimedia Deutschland\">Harald Krichel</span></a></bdi>', 'https://upload.wikimedia.org/wikipedia/commons/b/b3/Hunter_Schafer-64616_%28cropped%29.jpg', 1),
(61, 'Amy Winehouse', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id_product` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `comment` varchar(550) DEFAULT NULL,
  `comment_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id_product`, `id_user`, `comment`, `comment_date`) VALUES
(8, 6, 'Pour toute question, n’hésitez pas à nous contacter !', '2026-06-21 08:02:35'),
(8, 7, 'Est-ce qu\'elle est en bon état ?', '2026-06-21 08:06:36');

-- --------------------------------------------------------

--
-- Structure de la table `concerned`
--

CREATE TABLE `concerned` (
  `id_product` int NOT NULL,
  `id_celebrity` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `concerned`
--

INSERT INTO `concerned` (`id_product`, `id_celebrity`) VALUES
(7, 60),
(8, 39),
(9, 61),
(10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id_image` int NOT NULL,
  `id_product` int DEFAULT NULL,
  `path_image` varchar(250) DEFAULT NULL,
  `alt` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_image`, `id_product`, `path_image`, `alt`) VALUES
(9, 8, 'Annonce/8/8_0.avif', '8_0.avif'),
(10, 8, 'Annonce/8/8_Certificate.pdf', '8Certificate.pdf'),
(11, 9, 'Annonce/9/9_2.avif', '9_2.avif'),
(12, 10, 'Annonce/10/10_0.avif', '10_0.avif'),
(13, 10, 'Annonce/10/10_1.avif', '10_1.avif');

-- --------------------------------------------------------

--
-- Structure de la table `interest`
--

CREATE TABLE `interest` (
  `id_product` int DEFAULT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `interest`
--

INSERT INTO `interest` (`id_product`, `id_user`) VALUES
(10, 7),
(8, 7);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id_product` int NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `reserve_price` decimal(15,2) DEFAULT NULL,
  `start_price` decimal(15,2) DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0',
  `mailIsSent` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id_product`, `title`, `description`, `start_date`, `end_date`, `reserve_price`, `start_price`, `status`, `mailIsSent`) VALUES
(7, 'Mouchoir usagé', 'Mouchoir en soie naturelle, finition brodée à la main, présentant un état de conservation remarquable. Ourlets roulottés traditionnels, texture fluide et légère caractéristique des soies de haute qualité. Accompagné de son certificat d\'authenticité attestant de sa provenance et de son origine. Une pièce élégante, idéale pour les passionnés d\'objets de collection liés au monde du cinéma et du spectacle.', '2026-06-21 00:00:00', '2026-11-14 00:00:00', NULL, 0.00, 0, 0),
(8, 'Molaire', 'Molaire conservée dans un écrin sécurisé, accompagnée d\'un certificat d\'authenticité confirmant sa provenance. Objet insolite et rare, parfait pour les collectionneurs à la recherche de pièces atypiques liées à l\'univers des réseaux sociaux et de l\'influence digitale. Conservation optimale garantie.', '2026-06-21 00:00:00', '2026-10-09 00:00:00', NULL, 0.00, 1, 0),
(9, 'Tableau peint avec du sang', 'Toile peinte à partir du sang de l\'artiste, technique rare et viscérale mêlant performance corporelle et création picturale. Pièce unique, accompagnée d\'un certificat d\'authenticité attestant de la technique et de la provenance de l\'œuvre. Un témoignage artistique fort, à la croisée de l\'intime et du symbolique, destiné aux collectionneurs d\'art contemporain en quête de pièces singulières.', '2026-06-21 00:00:00', '2026-08-30 00:00:00', 15000.00, 0.00, 0, 0),
(10, 'Slip kangourou', 'Slip porté par Cristiano Ronaldo, pièce rare destinée aux collectionneurs et passionnés de football. Cet article unique provient de l’un des joueurs les plus emblématiques de sa génération, multiple vainqueur du Ballon d’Or et légende du football international.\r\n\r\nÉtat : Bon état général\r\nProvenance : Collection privée\r\nType : Sous-vêtement de sport / souvenir de collection\r\nAuthenticité : Non certifiée (à adapter selon ton cas)\r\nIdéal pour : Collection, exposition, objet insolite ou souvenir de fan\r\n\r\nUne occasion originale d’acquérir un objet atypique lié à l’univers de Cristiano Ronaldo.', '2026-06-21 00:00:00', '2026-08-01 00:00:00', NULL, 0.00, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `productview`
--

CREATE TABLE `productview` (
  `id_product` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `view_number` int DEFAULT NULL,
  `view_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `productview`
--

INSERT INTO `productview` (`id_product`, `id_user`, `view_number`, `view_date`) VALUES
(NULL, NULL, 1, '2026-06-20 22:53:04'),
(10, 6, 1, '2026-06-21 10:00:55'),
(8, 6, 1, '2026-06-21 10:01:39');

-- --------------------------------------------------------

--
-- Structure de la table `published`
--

CREATE TABLE `published` (
  `id_user` int NOT NULL,
  `id_product` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `published`
--

INSERT INTO `published` (`id_user`, `id_product`) VALUES
(6, 7),
(6, 8),
(6, 9),
(6, 10);

-- --------------------------------------------------------

--
-- Structure de la table `rating`
--

CREATE TABLE `rating` (
  `id_buyer` int DEFAULT NULL,
  `id_seller` int DEFAULT NULL,
  `rating` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT '0',
  `admin` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `name`, `firstname`, `birth_date`, `address`, `city`, `postal_code`, `email`, `password`, `newsletter`, `admin`) VALUES
(6, 'Vendeur', 'Mr.', '2026-04-27', 'Rue de Nevers', 'Nevers', '58000', 'vendeur@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$QUtlOGVuZGhOenREWlhwUQ$D74jT4QYtZPcj8/XZ/NsuSAKf1HsPhJKGRFh29fQzMo', 0, 0),
(7, 'Encherisseur', 'Mr.', '2026-04-27', 'Rue de Nevers', 'Nevers', '58000', 'encherisseur@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$YUY1bU42NVpvcGtuNkFDRw$TcxnppHI4j47WEa3/Cxf7NnG/3ua4wz59X/pvdX6T/4', 0, 0),
(8, 'Admin', 'Mr.', '2026-04-27', 'Rue de Nevers', 'Nevers', '58000', 'sae.administrateur@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$dVFXNTZUYmZ0ZlhkS0xVUw$+tYX47GAu7K4GsqCHI1ZsPyB3jBTfb5gCDcXiFJVYaQ', 0, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `belongsto`
--
ALTER TABLE `belongsto`
  ADD PRIMARY KEY (`id_product`,`id_category`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `bid`
--
ALTER TABLE `bid`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fk_bid_product` (`id_product`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Index pour la table `celebrity`
--
ALTER TABLE `celebrity`
  ADD PRIMARY KEY (`id_celebrity`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fk_comment_product` (`id_product`);

--
-- Index pour la table `concerned`
--
ALTER TABLE `concerned`
  ADD PRIMARY KEY (`id_product`,`id_celebrity`),
  ADD KEY `id_celebrity` (`id_celebrity`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `fk_image_product` (`id_product`);

--
-- Index pour la table `interest`
--
ALTER TABLE `interest`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fk_interest_product` (`id_product`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Index pour la table `productview`
--
ALTER TABLE `productview`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fk_productview_product` (`id_product`);

--
-- Index pour la table `published`
--
ALTER TABLE `published`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fk_published_product` (`id_product`);

--
-- Index pour la table `rating`
--
ALTER TABLE `rating`
  ADD KEY `id_buyer` (`id_buyer`),
  ADD KEY `id_seller` (`id_seller`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `celebrity`
--
ALTER TABLE `celebrity`
  MODIFY `id_celebrity` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id_image` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
