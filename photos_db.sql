-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 02:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `face`
--

CREATE TABLE `face` (
  `face_id` int(10) NOT NULL,
  `image_id` int(10) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `file_path` varchar(200) NOT NULL,
  `x_axis` int(10) NOT NULL,
  `y_axis` int(10) NOT NULL,
  `width` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `confidence` double NOT NULL,
  `is_face` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` int(10) NOT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `file_path` varchar(200) DEFAULT NULL,
  `thumbnail_path` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `face`
--
ALTER TABLE `face`
  ADD PRIMARY KEY (`face_id`),
  ADD KEY `face_image_id_fk` (`image_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `face`
--
ALTER TABLE `face`
  MODIFY `face_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4673;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `image_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `face`
--
ALTER TABLE `face`
  ADD CONSTRAINT `face_image_id_fk` FOREIGN KEY (`image_id`) REFERENCES `image` (`image_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
