-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 11, 2024 at 04:48 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `. add or modify`
--

DROP TABLE IF EXISTS `. add or modify`;
CREATE TABLE IF NOT EXISTS `. add or modify` (
  `Admin_id` varchar(10) NOT NULL,
  `Student_id` varchar(6) NOT NULL,
  PRIMARY KEY (`Admin_id`,`Student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `administrator_valid_time`
--

DROP TABLE IF EXISTS `administrator_valid_time`;
CREATE TABLE IF NOT EXISTS `administrator_valid_time` (
  `Admin_id` varchar(10) NOT NULL,
  `Start_date` date NOT NULL,
  `End_date` date NOT NULL,
  PRIMARY KEY (`Admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appoint`
--

DROP TABLE IF EXISTS `appoint`;
CREATE TABLE IF NOT EXISTS `appoint` (
  `Admin_id` varchar(10) NOT NULL,
  `Manager_id` varchar(10) NOT NULL,
  PRIMARY KEY (`Admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `Manager_id` varchar(10) NOT NULL,
  `Manager_name` varchar(30) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(8) NOT NULL,
  `Mobile_No` int NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`Manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manager_valid_time`
--

DROP TABLE IF EXISTS `manager_valid_time`;
CREATE TABLE IF NOT EXISTS `manager_valid_time` (
  `Manager_id` varchar(10) NOT NULL,
  `Start_date` date NOT NULL,
  `End_date` date NOT NULL,
  PRIMARY KEY (`Manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manu`
--

DROP TABLE IF EXISTS `manu`;
CREATE TABLE IF NOT EXISTS `manu` (
  `Manu_id` varchar(20) NOT NULL,
  `Price` int NOT NULL,
  `Manager_id` varchar(10) NOT NULL,
  PRIMARY KEY (`Manu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manu_food`
--

DROP TABLE IF EXISTS `manu_food`;
CREATE TABLE IF NOT EXISTS `manu_food` (
  `Manu_id` varchar(20) NOT NULL,
  `food_item` varchar(50) NOT NULL,
  PRIMARY KEY (`Manu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `Order_id` varchar(40) NOT NULL,
  `Date` date NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Student_id` varchar(6) NOT NULL,
  `Manu_id` varchar(20) NOT NULL,
  PRIMARY KEY (`Order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `Payment_id` varchar(20) NOT NULL,
  `Value` int NOT NULL,
  `Order_id` varchar(20) NOT NULL,
  PRIMARY KEY (`Payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provost`
--

DROP TABLE IF EXISTS `provost`;
CREATE TABLE IF NOT EXISTS `provost` (
  `Admin_id` varchar(10) NOT NULL,
  `Admin_name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(8) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`Admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `Student_id` varchar(6) NOT NULL,
  `Student_name` varchar(30) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(8) NOT NULL,
  `Mobile_No` varchar(13) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`Student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_id`, `Student_name`, `Email`, `Password`, `Mobile_No`, `isActive`) VALUES
('210224', 'susmi', 'biswassusmita755@gmail.com', 'asdf', '01990901768', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
