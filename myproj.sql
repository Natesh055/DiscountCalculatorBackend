-- Set SQL mode and transaction properties
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Drop the database if it exists and create a new one
DROP DATABASE IF EXISTS myproj;
CREATE DATABASE IF NOT EXISTS myproj;
USE myproj;

-- Create the 'login' table
CREATE TABLE `login` (
  `username` VARCHAR(50) PRIMARY KEY,
  `email` VARCHAR(100),
  `password` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert a sample user into the 'login' table
INSERT INTO `login` (`username`, `email`, `password`) VALUES
('Admin', 'singhnatesh50@gmail.com', 'nitin@2004');

-- Create the 'items' table
CREATE TABLE `items` (
  `username` VARCHAR(50) NOT NULL,
  `itemname` VARCHAR(50) NOT NULL,
  `quantity` INT,
  `original_price` FLOAT,
  `discounted_price` FLOAT,
  `date_added` DATE NOT NULL,
  PRIMARY KEY (`username`,`itemname`,`date_added`, `quantity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert an item with today's date into the 'items' table
INSERT INTO `items` (`username`, `itemname`, `quantity`, `original_price`, `discounted_price`, `date_added`)  
VALUES ('Admin', 'Lipstick', 2, 200, 180, CURDATE());

-- Commit the transaction
COMMIT;
