-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2020 at 09:00 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `spiecal` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `username`, `password`, `spiecal`, `image`) VALUES
(1, 'mahmoud', '123', 1, '2290_member5.jpg'),
(2, 'ahmed', '123', 2, '2065_81742794_478388032824724_7061326396726968320_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `university` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `qualifications` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `categor` varchar(255) NOT NULL,
  `nameofhost` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`ID`, `name`, `university`, `age`, `qualifications`, `rating`, `image`, `categor`, `nameofhost`) VALUES
(2, 'mahmoud ahmed', 'assuit', 35, 1, 4, '7669_member5.jpg', 'brain', 'elkser'),
(3, 'ibrahim', 'ain shmas', 35, 2, 3, '9407_member3.jpg', 'knee', 'aelx'),
(4, 'hossam elsayed', 'Alex', 55, 2, 2, '1484_member5.jpg', 'lung', 'ain shmas');

-- --------------------------------------------------------

--
-- Table structure for table `sick`
--

CREATE TABLE `sick` (
  `ID` int(11) NOT NULL,
  `namesick` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `categor` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `disease` int(11) NOT NULL DEFAULT 0 COMMENT 'for heart',
  `Heartbeat` int(11) NOT NULL DEFAULT 0 COMMENT 'for heart',
  `problemsleep` int(11) NOT NULL DEFAULT 0 COMMENT 'for brain',
  `break` int(11) NOT NULL DEFAULT 0 COMMENT 'for knee',
  `smoking` int(11) NOT NULL DEFAULT 0 COMMENT 'for lung',
  `doc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sick`
--

INSERT INTO `sick` (`ID`, `namesick`, `gender`, `message`, `date`, `categor`, `email`, `phone`, `age`, `disease`, `Heartbeat`, `problemsleep`, `break`, `smoking`, `doc_id`) VALUES
(3, 'mahmoud', 1, 'eeeeeeeeeeeeeeeeeeeeee', '2020-10-03', 'brain', 'mahbn@gmail.com', 1143124020, 62, 0, 0, 2, 0, 0, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sick`
--
ALTER TABLE `sick`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`,`namesick`),
  ADD KEY `doc_id` (`doc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sick`
--
ALTER TABLE `sick`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sick`
--
ALTER TABLE `sick`
  ADD CONSTRAINT `sick_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `doctors` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
