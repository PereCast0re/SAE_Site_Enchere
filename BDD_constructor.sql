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
   view_date DATETIME,
   PRIMARY KEY(id_product, id_user),
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
   PRIMARY KEY(id_buyer, id_seller),
   FOREIGN KEY(id_buyer) REFERENCES Users(id_user),
   FOREIGN KEY(id_seller) REFERENCES Users(id_user)
);

-- =======================
--  TESTS
-- =======================

INSERT INTO Category(name) VALUES ("voiture");
INSERT INTO Category(name) VALUES ("art");