-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 08, 2022 at 04:54 PM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Zepto_Ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `Id` int NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Image` varchar(100) NOT NULL,
  `Price` double(10,2) NOT NULL,
  `Entry_By` int NOT NULL,
  `Entry_Time` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`Id`, `Name`, `Image`, `Price`, `Entry_By`, `Entry_Time`) VALUES
(1, 'Testy', 'scr.png', 180.00, 1, '2022-04-07 14:54:10'),
(2, 'Laptop', '1144.jpg', 45000.00, 1, '2022-04-08 00:19:08'),
(4, 'Bottole', 'sssssss.jpg', 15.00, 1, '2022-04-08 02:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `Id` int NOT NULL,
  `Name` varchar(70) NOT NULL,
  `Email` varchar(70) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Is_Admin` tinyint(1) NOT NULL,
  `Registered_At` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`Id`, `Name`, `Email`, `Username`, `Password`, `Is_Admin`, `Registered_At`) VALUES
(1, 'Admin', 'admin@zepto.com', 'admin', '$2y$10$AjO4HaVnyjeWzKtqEAocbegdRiOd.1eEKgmxraquQF3fc8YMKxjPe', 1, '2022-04-06 14:26:32'),
(2, 'Mahfuzur Rahman Arif', 'Arifmahfuz99@gmail.com', 'Mahfuz98', '$2y$10$e/nLF4T0zWde5w9TzuaFB..kaWHNzsfXw1Z13mi3yS4s.ypCmJnSy', 0, '2022-04-07 13:12:44'),
(3, 'Helal Ahmed', 'helal@gmail.com', 'helal98', '$2y$10$NUFbwKZZhi0MIkHd3H9rcOCTmqZGHHHL86yFoMrI2ug4smdBlkCMu', 0, '2022-04-08 03:22:10'),
(4, 'Atif Aslam', 'atif@gmail.com', '_atif', '$2y$10$PGVSO8UWQMlPKUCsnyhCxORQiFWvS32GRm7RQAgO8kESaEQoONomS', 0, '2022-04-08 10:49:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
