-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 15, 2023 at 08:43 AM
-- Server version: 10.9.4-MariaDB-1:10.9.4+maria~ubu2204
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `NavigationBarItems`
--

CREATE TABLE `NavigationBarItems` (
  `id` int(11) NOT NULL,
  `pageId` int(11) NOT NULL,
  `parentNavId` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `NavigationBarItems`
--

INSERT INTO `NavigationBarItems` (`id`, `pageId`, `parentNavId`, `order`) VALUES
(1, 1, NULL, 0),
(2, 4, NULL, 1),
(3, 5, NULL, 2),
(4, 6, NULL, 3),
(5, 7, NULL, 4),
(6, 8, NULL, 5),
(7, 9, NULL, 6),
(8, 10, 2, 100),
(9, 11, 2, 101),
(10, 12, 2, 103),
(11, 13, 2, 104),
(12, 14, 2, 105);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `NavigationBarItems`
--
ALTER TABLE `NavigationBarItems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_PageId` (`pageId`),
  ADD KEY `PK_ParentId` (`parentNavId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `NavigationBarItems`
--
ALTER TABLE `NavigationBarItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `NavigationBarItems`
--
ALTER TABLE `NavigationBarItems`
  ADD CONSTRAINT `FK_PageId` FOREIGN KEY (`pageId`) REFERENCES `Pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PK_ParentId` FOREIGN KEY (`parentNavId`) REFERENCES `NavigationBarItems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
