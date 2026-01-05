DROP DATABASE IF EXISTS auction_site;
CREATE DATABASE auction_site;
USE auction_site;

-- =======================
--  USERS AND CELEBRITIES
-- =======================
CREATE TABLE Users (
   id_user INT AUTO_INCREMENT,
   name VARCHAR(50),
   firstname VARCHAR(50),
   birth_date DATE,
   address VARCHAR(100),
   city VARCHAR(50),
   postal_code VARCHAR(10),
   email VARCHAR(250),
   password VARCHAR(255),
   newsletter BOOLEAN DEFAULT FALSE,
   admin BOOLEAN DEFAULT FALSE,
   PRIMARY KEY(id_user)
);

CREATE TABLE Celebrity (
   id_celebrity INT AUTO_INCREMENT,
   name VARCHAR(50),
   PRIMARY KEY(id_celebrity)
);

-- =======================
--  PRODUCT AND CATEGORY
-- =======================
CREATE TABLE Category (
   id_category INT AUTO_INCREMENT,
   name VARCHAR(50),
   PRIMARY KEY(id_category)
);

CREATE TABLE Product (
   id_product INT AUTO_INCREMENT,
   title VARCHAR(100),
   description VARCHAR(250),
   start_date DATETIME,
   end_date DATETIME,
   reserve_price DECIMAL(15,2),
   start_price DECIMAL(15,2) DEFAULT 0,
   status BOOLEAN DEFAULT FALSE,
   PRIMARY KEY(id_product)
);

-- =======================
--  ASSOCIATIVE TABLES
-- =======================
CREATE TABLE BelongsTo (
   id_product INT,
   id_category INT,
   PRIMARY KEY(id_product, id_category),
   FOREIGN KEY(id_product) REFERENCES Product(id_product),
   FOREIGN KEY(id_category) REFERENCES Category(id_category)
);

CREATE TABLE Published (
   id_user INT NOT NULL,
   id_product INT NOT NULL,
   FOREIGN KEY(id_user) REFERENCES Users(id_user),
   FOREIGN KEY(id_product) REFERENCES Product(id_product)
);

CREATE TABLE Concerned (
   id_product INT,
   id_celebrity INT,
   PRIMARY KEY(id_product, id_celebrity),
   FOREIGN KEY(id_product) REFERENCES Product(id_product),
   FOREIGN KEY(id_celebrity) REFERENCES Celebrity(id_celebrity)
);

-- =======================
--  USER INTERACTIONS
-- =======================
CREATE TABLE Interest (
   id_product INT,
   id_user INT,
   FOREIGN KEY(id_product) REFERENCES Product(id_product),
   FOREIGN KEY(id_user) REFERENCES Users(id_user)
);

CREATE TABLE Bid (
   id_product INT,
   id_user INT,
   current_price DECIMAL(15,2),
   new_price DECIMAL(15,2),
   bid_date DATETIME,
   FOREIGN KEY(id_product) REFERENCES Product(id_product),
   FOREIGN KEY(id_user) REFERENCES Users(id_user)
);

CREATE TABLE Comment (
   id_product INT,
   id_user INT,
   comment VARCHAR(550),
   comment_date DATETIME,
   FOREIGN KEY(id_product) REFERENCES Product(id_product),
   FOREIGN KEY(id_user) REFERENCES Users(id_user)
);

CREATE TABLE ProductView (
   id_product INT,
   id_user INT,
   view_number INT,
   view_date DATETIME PRIMARY KEY,
   UNIQUE(id_product, view_date),
   FOREIGN KEY(id_product) REFERENCES Product(id_product),
   FOREIGN KEY(id_user) REFERENCES Users(id_user)
);

-- =======================
--  IMAGES AND RATINGS
-- =======================
CREATE TABLE Image (
   id_image INT AUTO_INCREMENT,
   id_product INT,
   path_image VARCHAR(250),
   alt VARCHAR(50),
   PRIMARY KEY(id_image),
   FOREIGN KEY(id_product) REFERENCES Product(id_product)
);

CREATE TABLE Rating (
   id_buyer INT,
   id_seller INT,
   rating INT CHECK (rating BETWEEN 0 AND 5),
   FOREIGN KEY(id_buyer) REFERENCES Users(id_user),
   FOREIGN KEY(id_seller) REFERENCES Users(id_user)
);

-- =======================
--  Jeux de données TEST
-- =======================

INSERT INTO Category(name) VALUES ("Automobile");
INSERT INTO Category(name) VALUES ("Sportif");
INSERT INTO Category(name) VALUES ("Artiste");
INSERT INTO Category(name) VALUES ("Acteur");
INSERT INTO Category(name) VALUES ("Dessinateur");
INSERT INTO Category(name) VALUES ("Musicien");
INSERT INTO Category(name) VALUES ("Informatique");


-- =======================
--  USERS
-- =======================
INSERT INTO Users (name, firstname, birth_date, address, city, postal_code, email, password, newsletter, admin) VALUES
('Dupont',   'Jean',   '1990-05-12', '10 rue de Paris',      'Paris',      '75001', 'jean.dupont@example.com',   'pwd1', TRUE,  FALSE),
('Martin',   'Claire', '1985-08-23', '25 avenue de Lyon',    'Lyon',       '69000', 'claire.martin@example.com', 'pwd2', TRUE,  TRUE),
('Durand',   'Paul',   '1995-11-02', '5 rue Nationale',      'Lille',      '59000', 'paul.durand@example.com',   'pwd3', FALSE, FALSE),
('Bernard',  'Sophie', '2000-01-15', '3 place de la Gare',   'Marseille',  '13000', 'sophie.bernard@example.com','pwd4', TRUE,  FALSE),
('Leroy',    'Luc',    '1988-03-30', '8 rue des Fleurs',     'Nice',       '06000', 'luc.leroy@example.com',     'pwd5', FALSE, FALSE);

-- =======================
--  CELEBRITIES
-- =======================
INSERT INTO Celebrity (name) VALUES
('Michael Schumacher'),
('Cristiano Ronaldo'),
('Angelina Jolie'),
('Banksy'),
('Daft Punk');

-- =======================
--  PRODUCTS
-- =======================
INSERT INTO Product (title, description, start_date, end_date, reserve_price, start_price, status) VALUES
('Casque F1 signé', 'Casque de pilote de F1 signé par Michael Schumacher', '2025-01-01 10:00:00', '2025-01-10 18:00:00', 5000.00, 1000.00, TRUE),
('Maillot Ronaldo', 'Maillot dédicacé de Cristiano Ronaldo',                '2025-01-02 09:00:00', '2025-01-12 20:00:00', 2000.00, 300.00, TRUE),
('Affiche Banksy',  'Affiche limitée signée par Banksy',                    '2025-01-03 12:00:00', '2025-01-15 21:00:00', 8000.00, 1500.00, TRUE),
('Photo Angelina',  'Photo dédicacée d’Angelina Jolie',                     '2025-01-05 14:00:00', '2025-01-16 19:00:00', 1500.00, 200.00, TRUE),
('Vinyle Daft Punk','Vinyle collector signé par Daft Punk',                 '2025-01-07 08:00:00', '2025-01-20 22:00:00', 3000.00, 400.00, TRUE);

-- =======================
--  BELONGS TO (categories déjà créées 1..7)
-- =======================
-- 1 Automobile, 2 Sportif, 3 Artiste, 4 Acteur, 5 Dessinateur, 6 Musicien, 7 Informatique
INSERT INTO BelongsTo (id_product, id_category) VALUES
(1, 1), -- Casque F1 -> Automobile
(1, 2), -- Casque F1 -> Sportif
(2, 2), -- Maillot Ronaldo -> Sportif
(3, 3), -- Affiche Banksy -> Artiste
(3, 5), -- Affiche Banksy -> Dessinateur
(4, 4), -- Photo Angelina -> Acteur
(5, 3), -- Vinyle Daft Punk -> Artiste
(5, 6); -- Vinyle Daft Punk -> Musicien

-- =======================
--  PUBLISHED (qui met en vente)
-- =======================
INSERT INTO Published (id_user, id_product) VALUES
(1, 1),
(2, 2),
(3, 3),
(2, 4),
(4, 5);

-- =======================
--  CONCERNED (produit lié à célébrité)
-- =======================
INSERT INTO Concerned (id_product, id_celebrity) VALUES
(1, 1), -- Casque F1 / Schumacher
(2, 2), -- Maillot / Ronaldo
(3, 4), -- Banksy
(4, 3), -- Angelina
(5, 5); -- Daft Punk

-- =======================
--  INTEREST (watchlist / favoris)
-- =======================
INSERT INTO Interest (id_product, id_user) VALUES
(1, 3),
(1, 4),
(2, 1),
(2, 5),
(3, 1),
(3, 2),
(4, 5),
(5, 3);

-- =======================
--  BID (enchères)
-- =======================
INSERT INTO Bid (id_product, id_user, current_price, new_price, bid_date) VALUES
(1, 3, 1200.00, 1500.00, '2025-01-01 11:00:00'),
(1, 4, 1500.00, 1800.00, '2025-01-01 12:30:00'),
(2, 1,  300.00,  500.00, '2025-01-02 10:15:00'),
(2, 5,  500.00,  750.00, '2025-01-02 11:45:00'),
(3, 2, 1500.00, 2000.00, '2025-01-03 13:20:00'),
(3, 1, 2000.00, 2500.00, '2025-01-03 15:05:00'),
(5, 3,  400.00,  650.00, '2025-01-07 09:10:00');

-- =======================
--  COMMENT
-- =======================
INSERT INTO Comment (id_product, id_user, comment, comment_date) VALUES
(1, 3, 'Super objet, très rare.',             '2025-01-01 13:00:00'),
(1, 4, 'J’espère gagner cette enchère !',     '2025-01-01 14:10:00'),
(2, 1, 'Maillot en parfait état ?',           '2025-01-02 12:00:00'),
(3, 2, 'Pièce de collection incroyable.',     '2025-01-03 16:00:00'),
(5, 3, 'Fan de ce groupe depuis toujours.',   '2025-01-07 10:00:00');

-- =======================
--  PRODUCT VIEW
-- =======================
INSERT INTO ProductView (id_product, id_user, view_number, view_date) VALUES
(1, 3, 1, '2025-01-01 10:05:00'),
(1, 3, 2, '2025-01-01 10:10:00'),
(1, 4, 1, '2025-01-01 11:50:00'),
(2, 1, 1, '2025-01-02 09:30:00'),
(2, 5, 1, '2025-01-02 10:45:00'),
(3, 2, 1, '2025-01-03 12:30:00'),
(3, 1, 1, '2025-01-03 14:30:00'),
(5, 3, 1, '2025-01-07 08:30:00');

-- =======================
--  RATING
-- =======================
INSERT INTO Rating (id_buyer, id_seller, rating) VALUES
(3, 1, 5),
(4, 1, 4),
(1, 2, 5),
(5, 2, 3),
(3, 4, 4);
