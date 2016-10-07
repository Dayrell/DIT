CREATE DATABASE Brairemon;

USE Brairemon;

CREATE TABLE users (
	U_ID INT NOT NULL AUTO_INCREMENT,
	username varchar(30) NOT NULL,
	fullName varchar(30) NOT NULL,
	email varchar(30) NOT NULL UNIQUE, 
	hash_password varchar(80) NOT NULL,
	salt varchar(30) NOT NULL,
	uType varchar(1) NOT NULL DEFAULT 'S',
	created_at datetime,
	
	PRIMARY KEY (U_ID)
);
