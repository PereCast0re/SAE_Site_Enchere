-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 27 avr. 2026 à 21:11
-- Version du serveur : 9.1.0
-- Version de PHP : 8.5.4

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
(6, 3),
(7, 3),
(8, 4),
(9, 3);

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
  `license` varchar(200) DEFAULT NULL,
  `artist` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_celebrity`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=239 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(7, 'Vincent Mc Doom', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/3/38/Vincent_Mc_Doom_Cannes_2015.jpg', 1),
(8, 'Matt Damon', 'CC BY-SA 4.0', 'Martin Kraft', 'https://upload.wikimedia.org/wikipedia/commons/5/52/MKr347638_Matt_Damon_%28Small_Things_Like_These%2C_Berlinale_2024%29.jpg', 1),
(9, 'Morgan Freeman', 'Public domain', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/127934495@N07\">DoD News Features</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/93/Academy_Award-winning_actor_Morgan_Freeman_narrates_for_the_opening_ceremony_%2826904746425%29_%28cropped%29_3.jpg', 1),
(10, 'Bradley Cooper', 'CC BY 4.0', 'Raph_PH', 'https://upload.wikimedia.org/wikipedia/commons/a/a7/Bradley_Cooper.jpg', 1),
(11, 'Pierce Brosnan', 'CC BY 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:PhilipRomanoPhoto\" title=\"User:PhilipRomanoPhoto\">PhilipRomanoPhoto</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/37/PierceBrosnan-byPhilipRomano.jpg', 1),
(12, 'Sean Connery', 'CC BY-SA 3.0 nl', 'Rob Bogaerts / Anefo', 'https://upload.wikimedia.org/wikipedia/commons/9/96/Sean_Connery_%281983%29.jpg', 1),
(13, 'George Clooney', 'CC BY 4.0', 'Raph_PH', 'https://upload.wikimedia.org/wikipedia/commons/c/c8/George_Clooney.jpg', 1),
(14, 'Hugh Laurie', 'CC BY-SA 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/watchwithkristin/\">Kristin Dos Santos</a>', 'https://upload.wikimedia.org/wikipedia/commons/8/87/Hugh_Laurie_2009_crop.jpg', 1),
(15, 'Denzel Washington', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Gabriel_Hutchinson\" title=\"User:Gabriel Hutchinson\">Gabriel Hutchinson</a>', 'https://upload.wikimedia.org/wikipedia/commons/c/cc/Denzel_Washington_at_the_2025_Cannes_Film_Festival.jpg', 1),
(16, 'Benoît Magimel', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/4/4f/Benoit_Magimel_Cannes_2006.jpg', 1),
(17, 'Jonah Hill', 'CC BY-SA 4.0', 'Harald Krichel', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/Jonah_Hill-4939_%28cropped%29_%28cropped%29.jpg', 1),
(18, 'Joaquin Phoenix', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Harald_Krichel\" title=\"User:Harald Krichel\">Harald Krichel</a>', 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Joaquin_Phoenix_in_2018.jpg', 1),
(19, 'Sean Penn', 'CC BY-SA 3.0', '<bdi><a href=\"https://www.wikidata.org/wiki/Q640\" class=\"extiw\" title=\"d:Q640\"><span title=\"German photographer; former vice chair of Wikimedia Deutschland\">Harald Krichel</span></a></bdi>', 'https://upload.wikimedia.org/wikipedia/commons/3/3d/Superpower_%282023%29-60535.jpg', 1),
(20, 'Ian McKellen', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/69880995@N04\">Raph_PH</a>', 'https://upload.wikimedia.org/wikipedia/commons/8/86/McKellenRichmnd040219-5_%2846275370484%29_%28cropped%29.jpg', 1),
(21, 'John Travolta', 'CC BY 2.0', 'lauraleedooley', 'https://upload.wikimedia.org/wikipedia/commons/a/a8/John_Travolta%2C_2014_%28cropped%29.jpg', 1),
(22, 'Michael B. Jordan', 'CC BY 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:PaulLim11\" title=\"User:PaulLim11\">Kevin Paul</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/23/Michael_B_Jordan_-_Sinners_%28cropped%29.jpg', 1),
(23, 'Tahar Rahim', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/e/e7/Tahar_Rahim_2012.jpg', 1),
(24, 'Christian Bale', 'CC BY-SA 4.0', 'Harald Krichel', 'https://upload.wikimedia.org/wikipedia/commons/0/0a/Christian_Bale-7837.jpg', 1),
(25, 'Jake Gyllenhaal', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Toglenn\" title=\"User:Toglenn\">Toglenn</a>', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/Jake_Gyllenhaal_2019_by_Glenn_Francis.jpg', 1),
(26, 'Robert Downey Jr.', 'CC BY-SA 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/photos/gageskidmore\">Gage Skidmore</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/94/Robert_Downey_Jr_2014_Comic_Con_%28cropped%29.jpg', 1),
(27, 'Kevin Costner', 'Public domain', '<bdi><a href=\"https://www.wikidata.org/wiki/Q71171454\" class=\"extiw\" title=\"d:Q71171454\"><span title=\"American photographer\">Bill Ingalls</span></a></bdi>', 'https://upload.wikimedia.org/wikipedia/commons/9/9a/Kevin_Costner_2016.jpg', 1),
(28, 'Pierre Dux', 'CC0', '<p>Titre :  [Recueil. Photographies. Conférence de presse de Pierre Dux et Terry Hands. Festival d\'Avignon. 1972 / Fernand Michaud] \nAuteur :  Michaud, Fernand (1929-2012). Photographe \nDate d\'édition', 'https://upload.wikimedia.org/wikipedia/commons/e/e0/Pierre_Dux.png', 1),
(29, 'Cillian Murphy', 'CC BY 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:JoshPopov\" title=\"User:JoshPopov\">JoshPopov</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/9e/CillianMurphy-TIFF2025-01-Cropped_%28cropped%29.png', 1),
(30, 'Roschdy Zem', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/d/d3/Roschdy_Zem_2017_2.jpg', 1),
(31, 'Al Pacino', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/39309480@N05\">Embajada de EEUU en la Argentina</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/20/ALPACINO_0234e_%2830401875260%29_%28cropped%29.jpg', 1),
(32, 'Ryan Gosling', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/69880995@N04\">Raph_PH</a>', 'https://upload.wikimedia.org/wikipedia/commons/6/62/GoslingBFI081223_%2822_of_30%29_%2853388157347%29_%28cropped%29.jpg', 1),
(33, 'Nikolai Kinski', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"http://www.ipernity.com/doc/14900\">Siebbi</a>', 'https://upload.wikimedia.org/wikipedia/commons/8/8e/Nikolai_Kinski_Berlinale_2008.jpg', 1),
(34, 'Barry Keoghan', 'Public domain', 'Senior Airman Austin Pate', 'https://upload.wikimedia.org/wikipedia/commons/4/40/Barry_Keoghan_2024_%28cropped%29.jpg', 1),
(35, 'Sagamore Stévenin', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/7/79/Sagamore_St%C3%A9venin_2012.jpg', 1),
(36, 'Gérard Lanvin', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/8/89/G%C3%A9rard_Lanvin_Cannes.jpg', 1),
(37, 'Tony Danza', 'CC BY 4.0', '<a href=\"https://en.wikipedia.org/wiki/User:Nv8200p\" class=\"extiw\" title=\"en:User:Nv8200p\">Larry D. Moore</a>', 'https://upload.wikimedia.org/wikipedia/commons/e/ee/Tony_danza_2012.jpg', 1),
(38, 'Idris Elba', 'CC BY-SA 4.0', 'Harald Krichel', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/Idris_Elba-4580_%28cropped%29.jpg', 1),
(39, 'Christoph Waltz', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:LucaFazPhoto\" title=\"User:LucaFazPhoto\">LucaFazPhoto</a>', 'https://upload.wikimedia.org/wikipedia/commons/5/54/Christoph_Waltz_at_82nd_Venice_International_Film_Festival-1_%28cropped%29.jpg', 1),
(40, 'Adrien Brody', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Berlination\" title=\"User:Berlination\">Bryan Berlin</a>', 'https://upload.wikimedia.org/wikipedia/commons/5/5e/Adrien_Brody_Is_This_Thing_On-89_%28cropped%29.jpg', 1),
(41, 'David Dufresne', 'CC BY-SA 4.0', 'Patrice Normand', 'https://upload.wikimedia.org/wikipedia/commons/f/f3/David_Dufresne.jpg', 1),
(42, 'Julien Pestel', NULL, NULL, NULL, 1),
(43, 'Leos Carax', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/f/f0/Leos_Carax_Cannes_2012.jpg', 1),
(44, 'Christophe Ruggia', NULL, NULL, NULL, 1),
(45, 'Jensen Ackles', NULL, NULL, NULL, 1),
(46, 'Guillaume Canet', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Gilzetbase\" title=\"User:Gilzetbase\">Gilzetbase</a>', 'https://upload.wikimedia.org/wikipedia/commons/8/87/Guillaume_Canet.jpg', 1),
(47, 'Gérard Oury', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/d/dc/G%C3%A9rard_Oury_Mich%C3%A8le_Morgan.jpg', 1),
(48, 'Jalil Lespert', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/e/ed/Jalil_Lespert_C%C3%A9sars.jpg', 1),
(49, 'Dany Boon', 'CC BY-SA 3.0', 'Alain FLANDRIN', 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Dany_Boon_Postier.JPG', 1),
(50, 'Léonide Moguy', 'Public domain', 'Unknown (Mondadori Publishers)', 'https://upload.wikimedia.org/wikipedia/commons/7/79/L%C3%A9onide_Moguy_1955.jpg', 1),
(51, 'Bernard Campan', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Siren-Com\" title=\"User:Siren-Com\">Siren-Com</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/28/Bernard_Campan_2010.jpg', 1),
(52, 'Jonathan Zaccaï', 'CC BY 3.0', 'VL-Media', 'https://upload.wikimedia.org/wikipedia/commons/7/76/Jonathan_Zacca%C3%AF.jpg', 1),
(53, 'Éric Rochant', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/9/99/Eric_Rochant_2013.jpg', 1),
(54, 'Clovis Cornillac', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/6/6c/Clovis_Cornillac_Cabourg_2015.jpg', 1),
(55, 'Jean-François Stévenin', 'CC BY-SA 2.5', '<a href=\"//commons.wikimedia.org/wiki/User:Che\" title=\"User:Che\">che</a> <br>(Please credit as <i>\"Petr Novák, Wikipedia\"</i> in case you use this outside Wikimedia projects.)', 'https://upload.wikimedia.org/wikipedia/commons/9/90/Jean-Francois_Stevenin.jpg', 1),
(56, 'Henry Winkler', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/27238804@N03\">Super Festivals</a> from Ft. Lauderdale, USA', 'https://upload.wikimedia.org/wikipedia/commons/0/07/Henry_Winkler_%2843968252532%29.jpg', 1),
(57, 'Christophe Malavoy', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Selbymay\" title=\"User:Selbymay\">Selbymay</a>', 'https://upload.wikimedia.org/wikipedia/commons/7/7a/ChristopheMalavoyLM2015.jpg', 1),
(58, 'Richard Attenborough', 'CC BY 2.0', 'gdcgraphics at <a rel=\"nofollow\" class=\"external free\" href=\"https://www.flickr.com/photos/gdcgraphics/\">https://www.flickr.com/photos/gdcgraphics/</a>', 'https://upload.wikimedia.org/wikipedia/commons/c/c3/RichardAttenborough07TIFF.jpg', 1),
(59, 'Stephen Baldwin', 'CC BY-SA 3.0', 'Gage Skidmore', 'https://upload.wikimedia.org/wikipedia/commons/2/2a/Stephen_Baldwin_by_Gage_Skidmore.jpg', 1),
(60, 'Philippe Rebbot', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/a/a1/Philippe_Rebbot_Cabourg_2015.jpg', 1),
(61, 'Frédéric Mitterrand', 'CC BY 3.0', '<table style=\"margin: 1.5em auto; width:60%; background-color:#CCCCCC; border:2px solid #aaaaaa; padding:1px;\" cellspacing=\"10\">\n\n<tbody><tr>\n<td><i><a href=\"https://upload.wikimedia.org/wikipedia/com', 'https://upload.wikimedia.org/wikipedia/commons/6/6f/R%C3%A9ception_pour_les_Fran%C3%A7ais_de_Shanghai_20100430_-_10.jpg', 1),
(62, 'Diego Luna', 'CC BY 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:PaulLim11\" title=\"User:PaulLim11\">Kevin Paul</a>', 'https://upload.wikimedia.org/wikipedia/commons/e/e9/Diego_Luna_-_Andor.jpg', 1),
(63, 'Fabrice Éboué', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/3/33/Fabrice_Ebou%C3%A9_Deauville_2012.jpg', 1),
(64, 'Jean-Louis Trintignant', 'Public domain', 'Reporters Associati &amp; Archivi / Mondadori', 'https://upload.wikimedia.org/wikipedia/commons/a/a2/Trintignant-Italie-1963.png', 1),
(65, 'Mehdi Nebbou', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/d/d8/Mehdi_Nebbou_Cabourg_2013.jpg', 1),
(66, 'Lorenzo Lamas', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/photos/alan-light/\">Alan Light</a>', 'https://upload.wikimedia.org/wikipedia/commons/7/71/Lorenzo_Lamas.jpg', 1),
(67, 'Hippolyte Girardot', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/5/57/Hippolyte_Girardot_Cannes_2011.jpg', 1),
(68, 'Mathieu Amalric', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:MisterHP7&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:MisterHP7 (page does not exist)\">MisterHP7</a>', 'https://upload.wikimedia.org/wikipedia/commons/c/c9/Mathieu_Amalric_UCR.jpg', 1),
(69, 'Sean Astin', 'CC BY-SA 2.0', 'Gage Skidmore', 'https://upload.wikimedia.org/wikipedia/commons/1/13/Sean_Astin_2_SDCC_2014.jpg', 1),
(70, 'Daniel Balavoine', 'CC BY-SA 3.0', 'François Alquier', 'https://upload.wikimedia.org/wikipedia/commons/5/59/Daniel_Balavoine.jpg', 1),
(71, 'Jack Black', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/69880995@N04\">Raph_PH</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/92/TenaciousDO2160623_%2838_of_62%29_Jack_Black.jpg', 1),
(72, 'Bernie Bonvoisin', 'Public domain', 'Inconnu', 'https://upload.wikimedia.org/wikipedia/commons/d/d7/Identite-Bonvoisin-1978-Sacem.jpg', 1),
(73, 'Yvan Le Bolloc\'h', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Eriotac\" title=\"User:Eriotac\">Eriotac</a>', 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Yvan_le_Bolloch.jpg', 1),
(74, 'Enrico Macias', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/3/35/Enrico_Macias_2016.jpg', 1),
(75, 'Spike Jonze', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/66728752@N00\">aphrodite-in-nyc</a>', 'https://upload.wikimedia.org/wikipedia/commons/0/09/Spike_Jonze_Her_Premiere_NYFF_2013_%28cropped%29.jpg', 1),
(76, 'DJ Snake', 'CC BY-SA 4.0', 'Arno Partissimo', 'https://upload.wikimedia.org/wikipedia/commons/f/f0/DJS-Presskit05_%28cropped%29.jpg', 1),
(77, 'Ian Curtis', NULL, NULL, NULL, 1),
(78, 'Ravi Shankar', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Markgoff2972&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Markgoff2972 (page does not exist)\">Markgoff2972</a>', 'https://upload.wikimedia.org/wikipedia/commons/6/60/Ravi_Shankar.jpg', 1),
(79, 'James Hetfield', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Kreepin_Deth&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Kreepin Deth (page does not exist)\">Kreepin Deth</a>', 'https://upload.wikimedia.org/wikipedia/commons/0/03/2024-07-12_DSC03974.jpg', 1),
(80, 'Caleb Landry Jones', 'CC BY 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:PaulLim11\" title=\"User:PaulLim11\">Kevin Paul</a>', 'https://upload.wikimedia.org/wikipedia/commons/4/4a/Caleb_Landry_Jones_-_Dracula.jpg', 1),
(81, 'Finn Wolfhard', 'CC BY 3.0', 'HEYFOMO', 'https://upload.wikimedia.org/wikipedia/commons/b/bd/Finn_Wolfhard_2025_%28crop%29.png', 1),
(82, 'Charlie Heaton', 'CC BY-SA 2.0', 'Greg2600', 'https://upload.wikimedia.org/wikipedia/commons/9/9b/CharlieHeaton2017_%28cropped%29.jpg', 1),
(83, 'Seal', 'CC BY-SA 2.0', '<bdi><a href=\"https://www.wikidata.org/wiki/Q37885816\" class=\"extiw\" title=\"d:Q37885816\"><span title=\"Australian photographer\">Eva Rinaldi</span></a></bdi>', 'https://upload.wikimedia.org/wikipedia/commons/c/c0/Seal_2012_%28cropped%29.jpg', 1),
(84, 'Scott Grimes', 'CC BY 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:PaulLim11\" title=\"User:PaulLim11\">Kevin Paul</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/28/Scott_Grimes_at_WonderCon_2026.jpg', 1),
(85, 'Bo Burnham', 'CC BY 2.0', 'Montclair Film', 'https://upload.wikimedia.org/wikipedia/commons/9/98/Bo_Burnham_at_the_Montclair_Film_Festival_2018_12.jpg', 1),
(86, 'Ben Mazué', 'CC BY 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Selbymay\" title=\"User:Selbymay\">Selbymay</a>', 'https://upload.wikimedia.org/wikipedia/commons/b/b8/NDLE2025BenMazue_1.jpg', 1),
(87, 'Frankie Muniz', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/photos/realtvfilms/\">Real TV Films/Carole Lowe Photography</a>', 'https://upload.wikimedia.org/wikipedia/commons/8/8b/Frankie_Muniz_2011.jpg', 1),
(88, 'Gary O\'Neil', 'CC BY 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Egghead06\" title=\"User:Egghead06\">Egghead06</a>', 'https://upload.wikimedia.org/wikipedia/commons/6/68/GaryO%27NeilWHU.jpg', 1),
(89, 'Sergio Ramos', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://m.youtube.com/c/realmadrid/videos\">Real Madrid</a>', 'https://upload.wikimedia.org/wikipedia/commons/4/4b/Sergio_Ramos_Interview_2021_%28cropped%29.jpg', 1),
(90, 'Alexander Sørloth', 'CC BY 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:MichaelEmilio&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:MichaelEmilio (page does not exist)\">MichaelEmilio</a>', 'https://upload.wikimedia.org/wikipedia/commons/e/e2/Norway_Italy_-_June_2025_E_10.jpg', 1),
(91, 'Cristian Chivu', 'CC BY-SA 3.0', 'Майоров Владимир', 'https://upload.wikimedia.org/wikipedia/commons/4/4d/Cristian_Chivu_2011.jpg', 1),
(92, 'Joël Cantona', NULL, NULL, NULL, 1),
(93, 'Rúrik Gíslason', 'CC BY-SA 4.0', 'Please attribute as: \"Wikipedia / Tobias Klenze\" (user page link optional). Remember that you must also mention the license (and link to it). So for example, if this picture is licensed under CC-BY-SA', 'https://upload.wikimedia.org/wikipedia/commons/3/39/R%C3%BArik_G%C3%ADslason_0379-cropped.jpg', 1),
(94, 'Mickaël Pagis', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Buffoleo\" class=\"mw-redirect\" title=\"User:Buffoleo\">S. Plaine</a>', 'https://upload.wikimedia.org/wikipedia/commons/1/1a/CFA2_Saint-L%C3%B4_-_Rennes_05.04.2014_%289bis%29.JPG', 1),
(95, 'Tony Vairelles', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Antho33\" title=\"User:Antho33\">Antho33</a>', 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Tony_vairelles_fcg.jpg', 1),
(96, 'Vicente Lucas', NULL, NULL, NULL, 1),
(97, 'Andoni Iraola', 'CC BY 3.0', 'AFC Bournemouth', 'https://upload.wikimedia.org/wikipedia/commons/8/8c/Andoni_Iraola_2023.jpg', 1),
(98, 'Marc Guéhi', 'CC BY-SA 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/121676765@N07\">@cfcunofficial (Chelsea Debs) London</a> from London, UK', 'https://upload.wikimedia.org/wikipedia/commons/6/64/Marc_Guehi_December_2018.jpg', 1),
(99, 'Daniel Bravo', 'CC BY-SA 3.0', '<ul><li>Photo by <a href=\"//commons.wikimedia.org/wiki/User:Liondartois\" title=\"User:Liondartois\">Liondartois</a></li>\n<li>Cropped and retouched by <a href=\"//commons.wikimedia.org/w/index.php?title=U', 'https://upload.wikimedia.org/wikipedia/commons/5/58/Daniel_Bravo_%28edited%29.jpg', 1),
(100, 'Lilian Thuram', 'CC BY 3.0', '<p><br style=\"clear:both\">\n</p>\n<table style=\"margin: 1.5em auto; width:90%; background-color:#ECF5FF; border:2px solid #B2E3FF; padding:1px;\" cellspacing=\"10\">\n\n<tbody><tr>\n<td>\n<div style=\"font-size', 'https://upload.wikimedia.org/wikipedia/commons/2/24/Lilian_Thuram_-_F%C3%A9vrier_2013.jpg', 1),
(101, 'Hervé Mathoux', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Flo63&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Flo63 (page does not exist)\">Flo63</a>', 'https://upload.wikimedia.org/wikipedia/commons/8/86/Mathoux_clermont1.jpg', 1),
(102, 'Emmanuel Adebayor', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Jan_S0L0&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Jan S0L0 (page does not exist)\">Jan S0L0</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/2d/Adebayor.jpg', 1),
(103, 'Bud Spencer', 'Public domain', 'Marcello Fondato', 'https://upload.wikimedia.org/wikipedia/commons/2/21/Bud_Spencer_1974.png', 1),
(104, 'Habib Beye', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/photos/sarki/\">scartinho</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/29/Habib_Beye2_%28cropped%29.jpg', 1),
(105, 'Bras de fer', 'Public domain', '<bdi><a href=\"https://www.wikidata.org/wiki/Q4233718\" class=\"extiw\" title=\"d:Q4233718\"><span title=\'unknown creator of a work (do not use as value of P50; use \"unknown value\" instead)\'>anonymous</span', 'https://upload.wikimedia.org/wikipedia/commons/2/25/La-Noue.jpg', 1),
(106, 'Christian Jeanpierre', NULL, NULL, NULL, 1),
(107, 'Thierry Gilardi', NULL, NULL, NULL, 1),
(108, 'Amélie Oudéa-Castéra', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:GailLeenstra&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:GailLeenstra (page does not exist)\">Gail Leenstra</a>', 'https://upload.wikimedia.org/wikipedia/commons/1/1b/Am%C3%A9lie_Oud%C3%A9a-Cast%C3%A9ra_at_a_2024_Paralympic_Games_media_conference_in_2024_3.jpg', 1),
(109, 'Carl Lewis', 'CC BY-SA 3.0', 'Manfred Werner - <a href=\"//commons.wikimedia.org/wiki/User:Tsui\" title=\"User:Tsui\">Tsui</a>', 'https://upload.wikimedia.org/wikipedia/commons/8/81/Save_The_World_Awards_2009_show06_-_Carl_Lewis.jpg', 1),
(110, 'Roman Doduik', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:MisterDorli&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:MisterDorli (page does not exist)\">MisterDorli</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/39/Roman_Doduik.jpg', 1),
(111, 'Nasdas', 'CC BY 3.0', 'Nasser Sari', 'https://upload.wikimedia.org/wikipedia/commons/4/4d/Nasdas_en_2025.png', 1),
(112, 'Clavicular', 'Public domain', 'Fort Lauderdale Sheriff\'s Office or Broward County Sheriff\'s Office', 'https://upload.wikimedia.org/wikipedia/commons/1/16/Clavicular_mugshot_March_2026.jpg', 1),
(113, 'Mila Orriols', NULL, NULL, NULL, 1),
(114, 'Just Riadh', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:YanRB\" title=\"User:YanRB\">YanRB</a>', 'https://upload.wikimedia.org/wikipedia/commons/7/7a/Just_Riadh_2025.jpg', 1),
(115, 'Léna Situations', 'CC BY-SA 4.0', 'yoann lothaire | other viewnewsmedia', 'https://upload.wikimedia.org/wikipedia/commons/a/a2/L%C3%A9na_Situations_2021.png', 1),
(116, 'Adrien Laurent', 'CC BY 3.0', 'Break-Out Company', 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Arien_Laurent_en_2019.png', 1),
(117, 'Hugo Manos', NULL, NULL, NULL, 1),
(118, 'Rayan PSN', NULL, NULL, NULL, 1),
(119, 'Dylan Thiry', NULL, NULL, NULL, 1),
(120, 'Alice Cordier', 'CC BY 4.0', 'VL', 'https://upload.wikimedia.org/wikipedia/commons/0/00/Alice_Cordier.jpg', 1),
(121, 'Farnell Morisset', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:FarnellMorisset&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:FarnellMorisset (page does not exist)\">FarnellMorisset</a>', 'https://upload.wikimedia.org/wikipedia/commons/e/e9/Farnell_Morisset.jpg', 1),
(122, 'Hugo Philip', 'Public domain', 'Unknown<span style=\"display: none;\">Unknown </span> Photograf', 'https://upload.wikimedia.org/wikipedia/commons/4/44/Postcard-1910_Hugo_Wolf.jpg', 1),
(123, 'Le Général Tchoutchoubatchou', NULL, NULL, NULL, 1),
(124, 'Magali Berdah', 'CC BY 3.0', 'VL', 'https://upload.wikimedia.org/wikipedia/commons/2/28/Magali_Berdah.jpg', 1),
(125, 'Matthieu Raffray', NULL, NULL, NULL, 1),
(126, 'Féris Barkat', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Akerck&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Akerck (page does not exist)\">Akerck</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/20/F%C3%A9ris_Barkat.jpg', 1),
(127, 'Paul-Adrien d\'Hardemare', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Breizhpierre&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Breizhpierre (page does not exist)\">Breizhpierre</a>', 'https://upload.wikimedia.org/wikipedia/commons/f/fb/Fr%C3%A8re_Paul_Adrien_d%27Hardemare.jpg', 1),
(128, 'Hasbulla Magomedov', NULL, NULL, NULL, 1),
(129, 'Poupette Kenza', NULL, NULL, NULL, 1),
(130, 'Ilyas El Maliki', NULL, NULL, NULL, 1),
(131, 'Aqababe', 'CC0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Skyisgrey&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Skyisgrey (page does not exist)\">Skyisgrey</a>', 'https://upload.wikimedia.org/wikipedia/commons/b/b9/AQABABE-AnissZitouni.jpg', 1),
(132, 'Sulivan Gwed', NULL, NULL, NULL, 1),
(133, 'Abdelmonaim Boussenna', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Mohatatou\" title=\"User:Mohatatou\">Mohatatou</a>', 'https://upload.wikimedia.org/wikipedia/commons/8/84/Abdelmonem_Bousenna_%28l%27imam_de_Lille%29%2C_RAMF_2019.jpg', 1),
(134, 'Paul Antony', NULL, NULL, NULL, 1),
(135, 'Sammy Basso', NULL, NULL, NULL, 1),
(136, 'Jean Pormanove', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.youtube.com/@NasLive\">Nasdas Live</a>', 'https://upload.wikimedia.org/wikipedia/commons/5/5d/Jean_Pormanove_chez_Nasdas_Live%2C_12_mai_2025.png', 1),
(137, 'Niko Omilana', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.youtube.com/@SoccerAidforUnicef\">Soccer Aid</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/3c/Niko_Omilana_in_2023.png', 1),
(138, 'Antoine Daniel', 'Public domain', 'Unknown author<span style=\"display: none;\">Unknown author</span>', 'https://upload.wikimedia.org/wikipedia/commons/4/43/North_American_Martyrs.jpg', 1),
(139, 'Technoblade', NULL, NULL, NULL, 1),
(140, 'Johan Lelièvre', NULL, NULL, NULL, 1),
(141, 'Mikaela Hoover', 'CC BY 4.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/27238804@N03\">Super Festivals</a> from Ft. Lauderdale, USA', 'https://upload.wikimedia.org/wikipedia/commons/b/b8/Mikaela_Hoover_Photo_Op_GalaxyCon_St._Louis_2025_%28cropped%29.jpg', 1),
(142, 'Emma Chamberlain', 'CC BY-SA 2.0', 'Patou Cornette', 'https://upload.wikimedia.org/wikipedia/commons/3/31/Emma_Chamberlain_at_%2721_Paris_Fashion_Week_%28cropped%29.jpg', 1),
(143, 'Jacksepticeye', 'CC BY-SA 3.0', 'Gage Skidmore', 'https://upload.wikimedia.org/wikipedia/commons/8/86/Jacksepticeye_by_Gage_Skidmore.jpg', 1),
(144, 'Etika', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.youtube.com/channel/UC73QX85bGegswROr-UylY3A\">TR1Iceman</a>', 'https://upload.wikimedia.org/wikipedia/commons/d/de/Etika_in_2019_-_2.jpg', 1),
(145, 'MrBeast', 'CC BY 4.0', 'Steven Khan', 'https://upload.wikimedia.org/wikipedia/commons/c/ce/MrBeast_2023_%28cropped%29.jpg', 1),
(146, 'Tubbo', 'CC BY 3.0', '<a href=\"https://en.wikipedia.org/wiki/Nihachu\" class=\"extiw\" title=\"w:Nihachu\">Nihachu</a>', 'https://upload.wikimedia.org/wikipedia/commons/0/0a/Tubbo_in_2021.jpg', 1),
(147, 'Davie504', 'CC BY 3.0', 'Viaceslav Svedov', 'https://upload.wikimedia.org/wikipedia/commons/5/54/Davie5042013.png', 1),
(148, 'PL Cloutier', 'CC BY 3.0', 'Montreal.TV', 'https://upload.wikimedia.org/wikipedia/commons/d/de/PL_Cloutier_2018.png', 1),
(149, 'Tommy Fury', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.youtube.com/channel/UCbIH_0cXTRZedYawf_Cp2RQ\">UKGossip TV</a>', 'https://upload.wikimedia.org/wikipedia/commons/0/08/Tommy_Fury_at_the_National_Television_Awards_%28cropped%29.jpg', 1),
(150, 'Jenna Marbles', 'CC BY 2.0', 'RISE', 'https://upload.wikimedia.org/wikipedia/commons/1/11/RISE_-_Jenna_Marbles_01_%28cropped%29.jpg', 1),
(151, 'Jake Paul', 'CC BY 2.0', 'Erik Drost', 'https://upload.wikimedia.org/wikipedia/commons/0/01/Jake_Paul_%2853116882732%29.jpg', 1),
(152, 'Juliette Tresanini', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:PaulLap&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:PaulLap (page does not exist)\">Paul Lapierre</a>', 'https://upload.wikimedia.org/wikipedia/commons/5/53/Juliette_Tresanini_2021.jpg', 1),
(153, 'Thomas Ngijol', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/5/50/Thomas_Ngijol_2014.jpg', 1),
(154, 'Chris Chan', 'CC0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Jshehehe&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Jshehehe (page does not exist)\">Jshehehe</a>', 'https://upload.wikimedia.org/wikipedia/commons/5/53/Chris-chan-sighting-2026-v0-7gc9lel97eeg1.jpg', 1),
(155, 'Germán Garmendia', 'CC BY-SA 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/itoogatuno/\">itoogatuno</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/3d/Garmendia_at_the_Colosseum_Theater_%28cropped%29.jpg', 1),
(156, 'Olivier Kissita', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Floyd_K%C3%A9mit&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Floyd Kémit (page does not exist)\">Floyd Kémit</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/99/Olivier_Kissita_-_portrait_2.jpg', 1),
(157, 'Rick Beato', 'CC BY 4.0', 'Raph_PH', 'https://upload.wikimedia.org/wikipedia/commons/d/dc/Rick_Beato_-_Cadogan_Hall_-_Monday_3rd_November_2025.jpg', 1),
(158, 'PewDiePie', 'CC BY 3.0', 'Cold Ones Clips', 'https://upload.wikimedia.org/wikipedia/commons/5/53/Pewdiepie_head_shot.jpg', 1),
(159, 'Georges Pernoud', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Pymouss\" title=\"User:Pymouss\">Pymouss</a>', 'https://upload.wikimedia.org/wikipedia/commons/6/6b/FIG_2015_-_Georges_Pernoud_01.jpg', 1),
(160, 'Simon Rex', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.youtube.com/channel/UCRUQaKw9apN9AXBiC_VwzQQ\">Lyn Fairly Media</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/9a/Simon_Rex_during_an_interview%2C_March_2022.jpg', 1),
(161, 'Willy Dumbo', 'CC0', '<a href=\"//commons.wikimedia.org/wiki/User:Blessingedi76\" title=\"User:Blessingedi76\">Blessingedi76</a>', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/La_C%C3%A9r%C3%A9monie_de_NISA_2024_31.jpg', 1),
(162, 'Jérôme Anthony', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Frantogian\" title=\"User:Frantogian\">Frantogian</a>', 'https://upload.wikimedia.org/wikipedia/commons/4/4d/J%C3%A9r%C3%B4me_Anthony_-_Monte-Carlo_Television_Festival.JPG', 1),
(163, 'Philippe Lacheau', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/a/af/Philippe_Lacheau_Cannes_2014.jpg', 1),
(164, 'Cyril Hanouna', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Siren-Com\" title=\"User:Siren-Com\">Siren-Com</a>', 'https://upload.wikimedia.org/wikipedia/commons/b/b0/Cyril_Hanouna_2010.jpg', 1),
(165, 'Malika Ménard', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Benoit-caen\" title=\"User:Benoit-caen\">Benoit-caen</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/21/Malika_M%C3%A9nard_%C3%A0_Caen_en_2010.JPG', 1),
(166, 'Philippe Risoli', NULL, NULL, NULL, 1),
(167, 'Cyril Féraud', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:XIIIfromTOKYO\" title=\"User:XIIIfromTOKYO\">XIIIfromTOKYO</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/3c/FIL_2016_-_Cyril_F%C3%A9raud_4735.jpg', 1),
(168, 'Ken Bogard', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Gotonin&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Gotonin (page does not exist)\">Arnaud Picard</a>', 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Kenbogard2.jpg', 1),
(169, 'Frédéric Lopez', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Frantogian\" title=\"User:Frantogian\">Frantogian</a>', 'https://upload.wikimedia.org/wikipedia/commons/d/d0/Fr%C3%A9d%C3%A9ric_Lopez_-_Monte-Carlo_Television_Festival.jpg', 1),
(170, 'Jean-Luc Gadreau', 'CC BY-SA 4.0', 'Jean-Luc Gadreau (selfie)', 'https://upload.wikimedia.org/wikipedia/commons/f/f0/Jean-Luc_Gadreau_%28selfie%29.jpg', 1),
(171, 'Benjamin Castaldi', NULL, NULL, NULL, 1),
(172, 'Pascale de La Tour du Pin', 'CC BY 4.0', 'Pascale de La Tour du Pin, Cathy Lantuejoul and Soraya Meziane', 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Pascale_de_La_Tour_du_Pin_2023.jpg', 1),
(173, 'Juan Arbeláez', NULL, NULL, NULL, 1),
(174, 'Jean-Jacques Bourdin', 'CC0', '<a href=\"//commons.wikimedia.org/wiki/User:ManoSolo13241324\" title=\"User:ManoSolo13241324\">ManoSolo13241324</a>', 'https://upload.wikimedia.org/wikipedia/commons/3/33/Jean-Jacques_Bourdin_2024.jpg', 1),
(175, 'Julien Courbet', 'CC BY-SA 4.0', 'Loreinatv', 'https://upload.wikimedia.org/wikipedia/commons/d/da/Julien_Courbet_sanspub%28cropped%29.jpg', 1),
(176, 'Laurent Ruquier', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Starus\" title=\"User:Starus\">Starus</a>', 'https://upload.wikimedia.org/wikipedia/commons/1/15/Casino_de_Paris_2013_-_Laurent_Ruquier.jpg', 1),
(177, 'Camille Combal', NULL, NULL, NULL, 1),
(178, 'Vincent Moscato', 'CC BY-SA 4.0', 'Vincent Moscato', 'https://upload.wikimedia.org/wikipedia/commons/8/89/Vincent_Moscato_01-2009.jpg', 1),
(179, 'Marion Jollès', 'CC BY 3.0', 'Romain Grosjean Official', 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Marion_Joll%C3%A8s_in_2021.jpg', 1),
(180, 'Michaël Youn', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/8/85/Michael_Youn_2012.jpg', 1),
(181, 'Jean-Luc Reichmann', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Jeriby\" title=\"User:Jeriby\">Jérôme IBY</a>', 'https://upload.wikimedia.org/wikipedia/commons/c/c5/Jean-Luc_Reichmann_%28cropped%29.jpg', 1),
(182, 'Alexandre Delpérier', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Gind2005\" title=\"User:Gind2005\">Gind2005</a>', 'https://upload.wikimedia.org/wikipedia/commons/4/49/Alexandre_Delp%C3%A9rier%2C_2012_%28cropped%29.jpg', 1),
(183, 'Caroline Tresca', NULL, NULL, NULL, 1),
(184, 'Philippe Lellouche', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/e/e1/Philippe_Lellouche_Cannes_2013.jpg', 1),
(185, 'Mia Khalifa', 'CC BY 3.0', 'Mia Khalifa', 'https://upload.wikimedia.org/wikipedia/commons/9/9c/Mia_Khalifa_in_2016.jpg', 1),
(186, 'Meryem Benoua', NULL, NULL, NULL, 1),
(187, 'Tiffany Trump', 'Public domain', 'Ali Shaker/VOA', 'https://upload.wikimedia.org/wikipedia/commons/0/0d/Tiffany_Trump_RNC_July_2016.jpg', 1),
(188, 'Laeticia Hallyday', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/9/90/Laeticia_Hallyday_Cannes_2009.jpg', 1),
(189, 'Tori Spelling', 'CC BY-SA 2.0', 'Gage Skidmore', 'https://upload.wikimedia.org/wikipedia/commons/b/b5/ToriSpelling2018.jpg', 1),
(190, 'Jean-Philippe Mayence', NULL, NULL, NULL, 1),
(191, 'Richard Chanfray', 'Public domain', 'Angelo Deligio / Mondadori via Getty Images', 'https://upload.wikimedia.org/wikipedia/commons/c/c2/RichardChambray-Dalida-Italie-1975.png', 1),
(192, 'Sylvie Tellier', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/d/de/Sylvie_Tellier_2009.jpg', 1),
(193, 'Marie Kondō', 'CC BY 2.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://riseconf.com/\">RISE</a>', 'https://upload.wikimedia.org/wikipedia/commons/9/98/Marie_Kond%C5%8D%2C_2016_%28cropped%29.jpg', 1),
(194, 'Adeline Toniutti', 'CC BY-SA 4.0', '<bdi><a href=\"//commons.wikimedia.org/wiki/User:ComputerHotline\" title=\"User:ComputerHotline\">Thomas Bresson</a></bdi>', 'https://upload.wikimedia.org/wikipedia/commons/5/52/2015-12-05_16-53-30_inaug-mois-givre.jpg', 1),
(195, 'Noah Beck', 'CC BY 3.0', 'Soccer Aid for UNICEF', 'https://upload.wikimedia.org/wikipedia/commons/0/02/Beck_in_2023.png', 1),
(196, 'Sarah Saldmann', NULL, NULL, NULL, 1),
(197, 'Lee Soo-hyuk', 'CC BY 3.0', 'Marie Claire Korea', 'https://upload.wikimedia.org/wikipedia/commons/7/7e/210910_%EC%9D%B4%EB%A0%87%EA%B2%8C_%EC%8B%9C%ED%81%AC%ED%95%98%EA%B2%8C_%ED%92%8D%EC%84%A0_%ED%84%B0%EB%9C%A8%EB%A6%AC%EB%8A%94_%EC%82%AC%EB%9E%8C_%', 1),
(198, 'Lise Boëll', NULL, NULL, NULL, 1),
(199, 'Kourtney Kardashian', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/wiki/User:Toglenn\" title=\"User:Toglenn\">Toglenn</a>', 'https://upload.wikimedia.org/wikipedia/commons/1/1a/Kourtney_Kardashian_2_2009.jpg', 1),
(200, 'Afida Turner', NULL, NULL, NULL, 1),
(201, 'Nicky Hilton', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Myleskalus\" title=\"User:Myleskalus\">Myles Kalus Anak Jihem</a>', 'https://upload.wikimedia.org/wikipedia/commons/5/5a/Nicky_Hilton_Paris_Fashion_Week_Autumn_Winter_2019.jpg', 1),
(202, 'Yolanda Hadid', 'CC BY-SA 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/photos/sharongraphics/\">Angela George</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/21/YolandaFosterHWOFMay2013.jpg', 1),
(203, 'Arno Klarsfeld', NULL, NULL, NULL, 1),
(204, 'Jean-François Revel', 'CC BY 2.5', '<bdi><a href=\"https://en.wikipedia.org/wiki/en:Elsa_Dorfman\" class=\"extiw\" title=\"w:en:Elsa Dorfman\"><span title=\"American photographer (1937-2020)\">Elsa Dorfman</span></a></bdi>', 'https://upload.wikimedia.org/wikipedia/commons/d/da/Jean-Fran%C3%A7ois_Revel_1999.jpg', 1),
(205, 'Frigide Barjot', 'CC BY-SA 3.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:LudoVersailles89&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:LudoVersailles89 (page does not exist)\">LudoVersailles89</a>', 'https://upload.wikimedia.org/wikipedia/commons/f/f4/Frigide_Barjot_en_avril_2014.jpg', 1),
(206, 'Nabilla Benattia', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Gilzetbase\" title=\"User:Gilzetbase\">Gilzetbase</a>', 'https://upload.wikimedia.org/wikipedia/commons/4/4f/Nabilla_Benattia_2023_%28cropped%29.jpg', 1),
(207, 'Mathieu Ceschin', NULL, NULL, NULL, 1),
(208, 'Nicole Polizzi', 'CC BY-SA 2.0', 'Amy Nicole Waltney', 'https://upload.wikimedia.org/wikipedia/commons/2/28/Snooki_at_James_Madison_University_%28cropped%29.jpg', 1),
(209, 'Kim Kardashian', 'Public domain', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.flickr.com/people/148748355@N05\">The White House</a> from Washington, DC', 'https://upload.wikimedia.org/wikipedia/commons/0/08/President_Trump_Meets_with_Sentencing_Commutation_Recipients_%2849624188912%29_%28cropped%29.jpg', 1),
(210, 'Hailey Baldwin', 'CC BY 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:PaulLim11\" title=\"User:PaulLim11\">Kevin Paul</a>', 'https://upload.wikimedia.org/wikipedia/commons/d/d6/Hailey_Bieber_at_WWD_Style_Awards_2026.jpg', 1),
(211, 'Christine Angot', 'CC BY-SA 3.0', 'François Alquier', 'https://upload.wikimedia.org/wikipedia/commons/4/4c/Christine_Angot_nineties.JPG', 1),
(212, 'Issei Sagawa', NULL, NULL, NULL, 1),
(213, 'Ève Angeli', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Vinckie&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Vinckie (page does not exist)\">Vinckie</a>', 'https://upload.wikimedia.org/wikipedia/commons/b/be/Eve_Angeli_Saint-Just2.JPG', 1),
(214, 'Oussama Chaouali', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Mmmwlhi&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Mmmwlhi (page does not exist)\">Mmmwlhi</a>', 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Oussama_Chaouali_photo.jpg', 1),
(215, 'Hunter Schafer', 'CC BY-SA 4.0', '<bdi><a href=\"https://www.wikidata.org/wiki/Q640\" class=\"extiw\" title=\"d:Q640\"><span title=\"German photographer; former vice chair of Wikimedia Deutschland\">Harald Krichel</span></a></bdi>', 'https://upload.wikimedia.org/wikipedia/commons/b/b3/Hunter_Schafer-64616_%28cropped%29.jpg', 1),
(216, 'Laetitia Casta', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Gilzetbase\" title=\"User:Gilzetbase\">Gilzetbase</a>', 'https://upload.wikimedia.org/wikipedia/commons/b/b4/Laetitia_Casta_%28cropped%29.jpg', 1),
(217, 'Deva Cassel', 'CC BY 3.0', 'Letture Metropolitane', 'https://upload.wikimedia.org/wikipedia/commons/3/3c/Deva_Cassel_Inside_Out_2_2024.png', 1),
(218, 'Adriana Karembeu', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/9/9e/Adriana_Sklenarikova_Karembeu_NRJ_Music_Awards_2012_%28cropped%29.jpg', 1),
(219, 'Isabelle Funaro', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:YanRB\" title=\"User:YanRB\">YanRB</a>', 'https://upload.wikimedia.org/wikipedia/commons/c/cc/Isabelle_Funaro_2013.jpg', 1),
(220, 'Alice Dufour', NULL, NULL, NULL, 1),
(221, 'Tatiana Silva', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/w/index.php?title=User:Hellendorff&amp;action=edit&amp;redlink=1\" class=\"new\" title=\"User:Hellendorff (page does not exist)\">Hellendorff Philippe</a>', 'https://upload.wikimedia.org/wikipedia/commons/0/09/Tatiana_Silva.jpg', 1),
(222, 'Melania Trump', 'Public domain', 'FLOTUS – Melania Trump', 'https://upload.wikimedia.org/wikipedia/commons/6/6c/Melania_Trump%E2%80%99s_Official_White_House_Portrait_%282025%29_%28much_further_cropped%29.jpg', 1),
(223, 'Emma Heming', NULL, NULL, NULL, 1),
(224, 'Jason Statham', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.youtube.com/channel/UCuwUfM8E79h2sqp34Fut6kw\">MTV International</a>', 'https://upload.wikimedia.org/wikipedia/commons/d/d3/Jason_Statham_2018.jpg', 1),
(225, 'Ivana Trump', 'CC BY-SA 3.0', 'By Christopherpeterson at English Wikipedia, CC BY 3.0, <a class=\"external free\" href=\"https://commons.wikimedia.org/w/index.php?curid=3071583\">https://commons.wikimedia.org/w/index.php?curid=3071583<', 'https://upload.wikimedia.org/wikipedia/commons/c/cd/Ivana_Trump_cropped_retouched.jpg', 1),
(226, 'Maye Musk', 'CC BY 2.0', 'Luan Luu', 'https://upload.wikimedia.org/wikipedia/commons/f/fb/Maye_Musk_in_2015.jpg', 1),
(227, 'Gennifer Demey', NULL, NULL, NULL, 1),
(228, 'Vaimalama Chaves', 'CC BY 3.0', '<a rel=\"nofollow\" class=\"external text\" href=\"https://www.youtube.com/channel/UCJW0boLGdOnbv7w5AXfeE6Q\">Viince Movie\'s - Suscite l\'émotion !</a>', 'https://upload.wikimedia.org/wikipedia/commons/2/27/Vaimalama_Chaves_%C3%A0_Malemort.jpg', 1),
(229, 'Scott Disick', 'CC BY 2.0', 'Jeff Cleary', 'https://upload.wikimedia.org/wikipedia/commons/a/a7/Scott_Disick_cropped.jpg', 1),
(230, 'Clara Morgane', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:G%C3%A9rald_Garitan\" title=\"User:Gérald Garitan\">G.Garitan</a>', 'https://upload.wikimedia.org/wikipedia/commons/7/78/Clara_morgan_france_bleu_champagne_1008361.jpg', 1),
(231, 'Ester Expósito', 'CC BY-SA 4.0', '<a href=\"//commons.wikimedia.org/wiki/User:Pedro_J_Pacheco\" title=\"User:Pedro J Pacheco\">Pedro J Pacheco</a>', 'https://upload.wikimedia.org/wikipedia/commons/0/05/Goyas_2025_-_Ester_Exp%C3%B3sito_%28cropped%29.jpg', 1),
(232, 'Ruby Rose', 'CC BY-SA 2.0', '<bdi><a href=\"https://www.wikidata.org/wiki/Q37885816\" class=\"extiw\" title=\"d:Q37885816\"><span title=\"Australian photographer\">Eva Rinaldi</span></a></bdi>', 'https://upload.wikimedia.org/wikipedia/commons/3/36/Ruby_Rose_%288192089034%29_%28cropped%29.jpg', 1),
(233, 'Albert Delègue', NULL, NULL, NULL, 1),
(234, 'Vanessa Paradis', 'CC BY-SA 3.0', 'Georges Biard', 'https://upload.wikimedia.org/wikipedia/commons/4/4d/Vanessa_Paradis_24-01-2012.jpg', 1),
(235, 'Jean Castex', 'Licence Ouverte', 'Service photo de Matignon', 'https://upload.wikimedia.org/wikipedia/commons/9/99/Castex_Matignon.jpg', 1),
(236, 'George Lucas', NULL, NULL, NULL, 0),
(237, 'Pierre Niney', NULL, NULL, NULL, 0),
(238, 'Amy Winehouse', NULL, NULL, NULL, 0);

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

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id_product`, `id_user`, `comment`, `comment_date`) VALUES
(7, 6, 'Si vous avez des questions, n\'hésitez surtout pas !', '2026-04-27 22:56:25'),
(7, 7, 'Très impressionnant, comment avez-vous obtenu cet objet ?', '2026-04-27 22:57:33');

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
(6, 236),
(7, 115),
(8, 237),
(9, 238);

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_image`, `id_product`, `path_image`, `alt`) VALUES
(9, 6, 'Annonce/6/6_1.jpg', '6_1.jpg'),
(10, 7, 'Annonce/7/7_0.jpg', '7_0.jpg'),
(11, 7, 'Annonce/7/7_Certificate.pdf', '7Certificate.pdf'),
(12, 9, 'Annonce/9/9_0.jpg', '9_0.jpg');

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id_product`, `title`, `description`, `start_date`, `end_date`, `reserve_price`, `start_price`, `status`, `mailIsSent`) VALUES
(6, 'Vaisseau X-Wing de Star Wars', 'Ce X‑Wing, reproduction fidèle du célèbre chasseur stellaire de Star Wars, est proposé aujourd’hui par un revendeur spécialisé, avec une provenance exceptionnelle : il a appartenu au créateur de la saga lui‑même, George Lucas.\r\n\r\nModèle emblématique de l’Alliance Rebelle, le X‑Wing est reconnaissable à ses ailes en configuration “X”, ses quatre canons laser et son cockpit conçu pour accueillir un droïde astromécano. Symbole de courage et de liberté, il reste l’un des vaisseaux les plus iconiques de l’univers galactique.\r\n\r\nCe modèle de collection, soigneusement conservé par son ancien propriétaire prestigieux, représente une opportunité rare pour les passionnés : acquérir une pièce authentique ayant appartenu à l’homme qui a donné naissance à Star Wars.\r\n\r\nUne occasion unique pour tout collectionneur ou fan souhaitant posséder un objet chargé d’histoire et de légende.', '2026-04-27 00:00:00', '2026-09-09 00:00:00', NULL, 0.00, 0, 0),
(7, 'Radiographie dentaire de Léna Situations', 'Cette radiographie dentaire authentique, aujourd’hui proposée par un revendeur spécialisé, provient directement de la célèbre créatrice de contenu Léna Situations. Conservée avec soin, cette pièce insolite et totalement unique offre un aperçu inattendu et intime de la personnalité pétillante qui a marqué toute une génération sur YouTube, Instagram et au‑delà.\r\n\r\nObjet rare et atypique, cette radiographie représente une opportunité exceptionnelle pour les collectionneurs de memorabilia liés aux influenceurs et aux figures majeures du web. Sa provenance certifiée — anciennement propriété de Léna Situations — en fait un article de collection à la fois surprenant, amusant et hautement convoité.\r\n\r\nUne occasion unique d’acquérir un objet réellement personnel ayant appartenu à l’une des créatrices françaises les plus influentes de la dernière décennie.', '2026-04-27 00:00:00', '2026-07-01 00:00:00', 2000.00, 0.00, 1, 0),
(8, 'Mouchoir de Pierre Niney', 'Ce mouchoir usagé, aujourd’hui proposé par un revendeur spécialisé, a été authentiquement utilisé par l’acteur français Pierre Niney, figure majeure du cinéma contemporain. L’objet est devenu viral après une séquence humoristique tournée avec le créateur de contenu Antton Racca, où l’acteur a accepté de rejouer une anecdote célèbre impliquant Scarlett Johansson.\r\nMis initialement en vente pour 1 euro, le mouchoir a rapidement affolé les enchères, atteignant des montants spectaculaires allant jusqu’à 100 000 euros, porté par l’enthousiasme des fans et la dimension caritative de l’opération. \r\n\r\nClassé comme objet « neuf » malgré son caractère insolite, ce mouchoir est devenu un véritable phénomène médiatique, illustrant à quel point la popularité de Pierre Niney peut transformer un simple accessoire en pièce de collection convoitée. L’intégralité des bénéfices de la vente originale devait être reversée à une association, renforçant encore l’intérêt autour de cet objet unique. \r\n\r\nAujourd’hui, ce mouchoir authentique ayant appartenu à Pierre Niney est disponible via un revendeur, offrant aux collectionneurs une opportunité rare d’acquérir un objet à la fois insolite, médiatisé et chargé d’histoire. Une pièce parfaite pour les amateurs de memorabilia liés au cinéma français et aux phénomènes culturels viraux.', '2026-04-27 00:00:00', '2026-06-30 00:00:00', NULL, 0.00, 0, 0),
(9, 'Tableau peint avec le sang de Amy Winehouse', 'Ce tableau exceptionnel, aujourd’hui proposé par un revendeur spécialisé, est l’une des œuvres les plus rares et les plus marquantes associées à la chanteuse Amy Winehouse. Réalisée selon une technique artistique atypique utilisant du sang comme médium, cette pièce unique témoigne d’une démarche créative aussi audacieuse que personnelle.\r\n\r\nL’œuvre présente un style brut et expressif, mêlant symboles, traits spontanés et éléments graphiques qui reflètent l’univers tourmenté et profondément artistique de la chanteuse. Sa provenance directe, liée à l’entourage artistique d’Amy Winehouse, en fait une pièce de collection d’une rare intensité émotionnelle.\r\n\r\nAujourd’hui disponible via un revendeur, ce tableau représente une opportunité exceptionnelle pour les collectionneurs d’art contemporain et les admirateurs de la chanteuse. Par son histoire, sa technique et sa dimension profondément intime, il s’impose comme une œuvre unique, chargée d’émotion et de symbolique, destinée à rejoindre une collection prestigieuse.', '2026-04-27 00:00:00', '2026-05-31 00:00:00', NULL, 0.00, 0, 0);

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
(7, 6, 1, '2026-04-27 22:44:36'),
(7, 6, 1, '2026-04-27 22:56:04');

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
(6, 6),
(6, 7),
(6, 8),
(7, 9);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `name`, `firstname`, `birth_date`, `address`, `city`, `postal_code`, `email`, `password`, `newsletter`, `admin`) VALUES
(6, 'Vendeur', 'Mr.', '2026-04-27', 'Rue de Nevers', 'Nevers', '58000', 'vendeur@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$QUtlOGVuZGhOenREWlhwUQ$D74jT4QYtZPcj8/XZ/NsuSAKf1HsPhJKGRFh29fQzMo', 0, 0),
(7, 'Encherisseur', 'Mr.', '2026-04-27', 'Rue de Nevers', 'Nevers', '58000', 'encherisseur@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$YUY1bU42NVpvcGtuNkFDRw$TcxnppHI4j47WEa3/Cxf7NnG/3ua4wz59X/pvdX6T/4', 0, 0),
(8, 'Admin', 'Mr.', '2026-04-27', 'Rue de Nevers', 'Nevers', '58000', 'sae.administrateur@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$dVFXNTZUYmZ0ZlhkS0xVUw$+tYX47GAu7K4GsqCHI1ZsPyB3jBTfb5gCDcXiFJVYaQ', 0, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
