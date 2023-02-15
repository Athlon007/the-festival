-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 15, 2023 at 08:42 AM
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
-- Table structure for table `Pages`
--

CREATE TABLE `Pages` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `href` varchar(128) NOT NULL,
  `location` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Pages`
--

INSERT INTO `Pages` (`id`, `title`, `href`, `location`) VALUES
(1, 'Home', '', '/views/home/index.php'),
(2, 'Page Not Found', '/404', '/views/404.php'),
(3, 'Dynamic Page Test', '/dynamic', '/views/dynamic_page_test.php'),
(4, 'Festival', '/festival', '/views/festival/index.php'),
(5, 'Music & Dance', '/music-and-dance', '/views/home/music-and-dance.php'),
(6, 'Food', '/food', '/views/home/food.php'),
(7, 'History', '/history', '/views/home/history.php'),
(8, 'Art', '/art', '/views/home/art'),
(9, 'Kids', '/kids', '/views/home/kids.php'),
(10, 'Dance!', '/festival/dance', '/views/festival/dance.php'),
(11, 'Jazz & More', '/festival/jazz-and-more', '/views/festival/jazz-and-more.php'),
(12, 'History Stroll', '/festival/history-stroll', '/views/festival/history-stroll.php'),
(13, 'Yummy!', '/festival/yummy', '/views/festival/yummy'),
(14, 'The Teyler Mystery', '/festival/teyler-mystery', '/views/festival/teyler-mystery.php');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Pages`
--
ALTER TABLE `Pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `href` (`href`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Pages`
--
ALTER TABLE `Pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
