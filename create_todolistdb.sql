/*INF653_VC_Back-End Web Development I - Homework 4*/
/*Feb 12, 2021*/
/* The ToDo List application will need a simple database named "todolist" (case-sensitive). You can create the database using myPhPAdmin for MySQL in XAMPP. It should have a table named "todoitems" (again, case-sensitive). The table should have 3 fields: 
An ItemNum field that is type = INT, Index = Primary, and has auto increment (A_I checkbox).
A Title field that is Type = VARCHAR and  limited to 20 characters max. 
A Description field that is Type = VARCHAR and  limited to 50 characters max. */

-- create and select the database
CREATE DATABASE IF NOT EXISTS todolist
	COLLATE utf8mb4_general_ci;
USE todolist;

-- create the tables for the database
CREATE TABLE todoitems (
  ItemNum           INT            NOT NULL   AUTO_INCREMENT,
  Title             VARCHAR(20)    NOT NULL,
  Description       VARCHAR(50)    NOT NULL,
  PRIMARY KEY (ItemNum)
);

-- create user named mgs_user
CREATE USER IF NOT EXISTS 'mgs_user'@'localhost' IDENTIFIED BY 'pa55word';

-- grant user access to todolist database
GRANT SELECT, INSERT, UPDATE, DELETE
ON todolist.*
TO mgs_user@localhost IDENTIFIED BY 'pa55word';