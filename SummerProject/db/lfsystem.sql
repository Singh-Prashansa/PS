-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 10:01 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lfsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_items`
--

CREATE TABLE `all_items` (
  `ID` int(11) NOT NULL,
  `item` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `collected` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `all_items`
--

INSERT INTO `all_items` (`ID`, `item`, `description`, `date`, `location`, `image`, `collected`) VALUES
(20, 'Keys', 'Bike Keys', '2024-04-05 19:05:00', 'ground', 'bikekey.jfif', 0),
(27, 'Key', 'Keys', '2024-04-05 19:34:00', 'hall', 'keys2.jpg', 0),
(28, 'Key', 'Key', '2024-04-28 19:04:00', 'hall', 'keys.jfif', 0),
(42, 'Bottle', 'Black 1 Liter Bottle', '2024-04-05 21:59:00', 'class 102', 'black bottle.jpg', 0),
(44, 'Calculator', 'Casio Calculator', '2024-04-05 22:04:00', 'class 303', 'calculator.jfif', 0),
(45, 'Calculator', 'Calculator', '2024-04-05 22:07:00', 'library', 'calc.jfif', 0),
(47, 'Purse', 'Blue Purse', '2024-04-24 19:30:00', 'class 104', 'purse.jpg', 0),
(51, 'Bottle', 'Blue Bottle 1 Liter', '2024-04-28 17:57:00', 'class 301', 'bottle.jfif', 0),
(52, 'Glasses', 'Grey Prescription Glasses', '2024-04-28 18:45:00', 'canteen', 'glasses.jpg', 0),
(54, 'Wallet', 'Brown Wallet', '2024-05-01 10:30:00', 'class 107', 'wallet.jpg', 0),
(55, 'Braclet', 'Silver Braclet', '2024-05-01 14:34:00', 'canteen', 'braclet.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `collected`
--

CREATE TABLE `collected` (
  `ItemID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `item` varchar(200) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `date_found` datetime NOT NULL,
  `location` varchar(200) NOT NULL,
  `image` varchar(500) NOT NULL,
  `date_collected` datetime NOT NULL,
  `date_returned` datetime DEFAULT NULL,
  `returned` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collected`
--

INSERT INTO `collected` (`ItemID`, `CID`, `UID`, `item`, `fname`, `lname`, `date_found`, `location`, `image`, `date_collected`, `date_returned`, `returned`) VALUES
(55, 23, 1, 'Braclet', 'Ram', 'Thapa', '2024-05-01 14:34:00', 'canteen', 'braclet.jpg', '2024-05-01 02:48:59', '2024-05-01 11:04:40', 1),
(54, 29, 2, 'Wallet', 'Sita', 'Shrestha', '2024-05-01 10:30:00', 'class 107', 'wallet.jpg', '2024-05-01 03:49:46', NULL, 0),
(51, 30, 2, 'Bottle', 'Sita', 'Shrestha', '2024-04-28 17:57:00', 'class 301', 'bottle.jfif', '2024-05-01 04:10:38', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_lost`
--

CREATE TABLE `item_lost` (
  `Lost_ID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `Item` varchar(200) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Location` varchar(200) DEFAULT NULL,
  `Image` varchar(500) DEFAULT NULL,
  `Code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_lost`
--

INSERT INTO `item_lost` (`Lost_ID`, `UID`, `Item`, `Description`, `Date`, `Location`, `Image`, `Code`) VALUES
(38, 1, 'Braclet', 'Silver Braclet', '2024-05-01 14:33:00', '', '', 9382),
(39, 1, 'Glasses', 'Silver Glasses', '2024-05-01 14:58:00', '', 'glasses.jpg', 6658),
(40, 1, 'Bottle', 'Black 1 Liter Bottle', '2024-05-01 14:58:00', '', '', 8768),
(41, 5, 'Purse', '', '2024-05-01 15:04:00', '', '', 5423);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `NID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `Lost_ID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `UID` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(256) NOT NULL,
  `scode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`UID`, `fname`, `lname`, `email`, `password`, `scode`) VALUES
(1, 'Ram', 'Thapa', 'ram@gmail.com', '$2y$10$bKDjdI2nq6pmMwStqT1Eauf9BKKpaQj9gcL8C0YnDPT0ZnpTYUFHS', NULL),
(2, 'Sita', 'Shrestha', 'sita0123@gmail.com', '$2y$10$oklJQj1zNhvqgNeaUN2RtuDU6UJYV3GJtq4jpwJIQzW3fGcWh7tca', NULL),
(5, 'Hari', 'Maharjan', 'hari@gmail.com', '$2y$10$J8UwmmZrYLTIv.nYucfal.L4GnFvRou5PhI/5FIV43Ut1RoTbr5aq', '20-2020-20'),
(6, 'Sravan', 'Ghimire', 'sra@gmail.com', '$2y$10$GTd5lUYM5dPb1gj0Ks5yy.yIgun6gfc/rvSM2tfOExh4OupULlTrK', '20-2020-21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_claim`
--

CREATE TABLE `user_claim` (
  `sn` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `item` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date_returned` datetime DEFAULT NULL,
  `date_claimed` datetime DEFAULT NULL,
  `date_found` datetime NOT NULL,
  `code` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_items`
--
ALTER TABLE `all_items`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `collected`
--
ALTER TABLE `collected`
  ADD PRIMARY KEY (`CID`),
  ADD KEY `UID` (`UID`),
  ADD KEY `ItemID` (`ItemID`);

--
-- Indexes for table `item_lost`
--
ALTER TABLE `item_lost`
  ADD PRIMARY KEY (`Lost_ID`),
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`NID`),
  ADD KEY `notification_ibfk_1` (`UID`),
  ADD KEY `ID` (`ID`),
  ADD KEY `Lost_ID` (`Lost_ID`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_claim`
--
ALTER TABLE `user_claim`
  ADD PRIMARY KEY (`sn`),
  ADD KEY `UID` (`UID`),
  ADD KEY `user_claim_ibfk_2` (`ItemID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_items`
--
ALTER TABLE `all_items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `collected`
--
ALTER TABLE `collected`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `item_lost`
--
ALTER TABLE `item_lost`
  MODIFY `Lost_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `NID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_claim`
--
ALTER TABLE `user_claim`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collected`
--
ALTER TABLE `collected`
  ADD CONSTRAINT `collected_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `register` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `collected_ibfk_2` FOREIGN KEY (`ItemID`) REFERENCES `all_items` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_lost`
--
ALTER TABLE `item_lost`
  ADD CONSTRAINT `item_lost_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `register` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `register` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`ID`) REFERENCES `all_items` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_3` FOREIGN KEY (`Lost_ID`) REFERENCES `item_lost` (`Lost_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_claim`
--
ALTER TABLE `user_claim`
  ADD CONSTRAINT `user_claim_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `register` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_claim_ibfk_2` FOREIGN KEY (`ItemID`) REFERENCES `all_items` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
