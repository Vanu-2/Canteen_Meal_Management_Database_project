-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 17, 2024 at 10:08 AM
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
-- Table structure for table `add_or_modify`
--

DROP TABLE IF EXISTS `add_or_modify`;
CREATE TABLE IF NOT EXISTS `add_or_modify` (
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
  `Manager_id` int NOT NULL,
  `Manager_name` varchar(30) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(8) NOT NULL,
  `Mobile_No` varchar(11) NOT NULL,
  `Type` int NOT NULL,
  PRIMARY KEY (`Manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`Manager_id`, `Manager_name`, `Email`, `Password`, `Mobile_No`, `Type`) VALUES
(17, 'Sourav', 'shomesourav32@gmail.com', '17', '01992154304', 0),
(210217, 'Shome', 'shomesourav32@gmail.com', '17', '01992154304', 1);

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
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `Menu_id` int NOT NULL,
  `Price` int NOT NULL,
  `Manager_id` int NOT NULL,
  PRIMARY KEY (`Menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`Menu_id`, `Price`, `Manager_id`) VALUES
(103, 35, 1),
(301, 50, 1),
(302, 25, 1),
(401, 70, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_food`
--

DROP TABLE IF EXISTS `menu_food`;
CREATE TABLE IF NOT EXISTS `menu_food` (
  `Menu_id` int NOT NULL,
  `Food_item` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`Menu_id`,`Food_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu_food`
--

INSERT INTO `menu_food` (`Menu_id`, `Food_item`) VALUES
(0, 'rice'),
(103, 'Alu Vorta, Singara, Rice'),
(301, 'খিচুরি, ডিম'),
(302, 'ভাত, আলু ভর্তা, ডাল'),
(401, 'ডাল'),
(401, 'বিরিয়ানী'),
(401, 'মুরগি');

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_meal`
--

DROP TABLE IF EXISTS `ongoing_meal`;
CREATE TABLE IF NOT EXISTS `ongoing_meal` (
  `Date` varchar(20) NOT NULL,
  `Lunch_Menu_Id` int DEFAULT NULL,
  `Dinner_Menu_Id` int DEFAULT NULL,
  PRIMARY KEY (`Date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ongoing_meal`
--

INSERT INTO `ongoing_meal` (`Date`, `Lunch_Menu_Id`, `Dinner_Menu_Id`) VALUES
('2024-04-12', 201, 202),
('2024-04-13', 301, 103),
('2024-04-14', 301, 401),
('2024-04-15', 103, 401),
('2024-04-17', 103, 301);

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
  `Type` int NOT NULL,
  PRIMARY KEY (`Student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_id`, `Student_name`, `Email`, `Password`, `Mobile_No`, `Type`) VALUES
('210217', 'Sourav', 'sh@gmail.com', '12', '019921543045', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
