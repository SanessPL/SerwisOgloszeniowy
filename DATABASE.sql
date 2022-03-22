DROP DATABASE IF EXISTS serwis_ogloszeniowy;

CREATE DATABASE serwis_ogloszeniowy CHARACTER SET utf8 COLLATE utf8_polish_ci;

USE serwis_ogloszeniowy;

CREATE TABLE users (
   id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   username VARCHAR(32) NOT NULL UNIQUE,
   email VARCHAR(255) NOT NULL UNIQUE,
   first_name VARCHAR(60),
   last_name VARCHAR(60),
   password CHAR(60) NOT NULL,
   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   last_seen_at DATETIME
);

CREATE TABLE offers (
   id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   user_id INT NOT NULL REFERENCES users(id),
   title varchar(50),
   price DECIMAL(10, 2),
   offer_description varchar(255)
);

