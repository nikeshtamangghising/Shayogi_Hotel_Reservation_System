-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 08, 2023 at 02:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Sahyogi`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateStaffBalance` ()   BEGIN
  -- Update the balance for each staff member
  UPDATE Staff
  SET balance = balance + (staff_salary / DAY(LAST_DAY(CURRENT_DATE()))) -- Divide salary by total days in the month
  WHERE hire_date <= LAST_DAY(CURRENT_DATE());
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`ID`, `Name`, `Username`, `Password`, `Email`, `role`) VALUES
(1, 'John Doe', 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'johndoe@example.com', 'admin'),
(2, 'dsadsadasd', 'sadsadas', '1f0fc0e623f9ad25c4773cd4f2ac180237216465', 'dsadasdsadasdas@gmail.com', 'user'),
(3, '', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', 'user'),
(4, 'saaaaaa', 'aaaaaaaaaaaaa', 'd23ff281b3c603ea43eab4c81bf7cf3850e4d75c', 'johndoe@example.com', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `BedTypes`
--

CREATE TABLE `BedTypes` (
  `BedTypeId` int(11) NOT NULL,
  `RoomId` int(11) DEFAULT NULL,
  `BedType` varchar(255) DEFAULT NULL,
  `NumberOfBeds` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `BedTypes`
--

INSERT INTO `BedTypes` (`BedTypeId`, `RoomId`, `BedType`, `NumberOfBeds`) VALUES
(25, 17, 'Queen bed 151-180 cm wide', 2),
(27, 17, 'Futon bed / Variable size', 11),
(28, 17, 'Futon bed / Variable size', 11);

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE `Rooms` (
  `RoomId` int(11) NOT NULL,
  `CustomNo` int(11) DEFAULT NULL,
  `RoomType` varchar(255) DEFAULT NULL,
  `RoomName` varchar(255) DEFAULT NULL,
  `AttachBathroom` tinyint(1) DEFAULT NULL,
  `NonSmokingRoom` tinyint(1) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `TotalOccupancy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Rooms`
--

INSERT INTO `Rooms` (`RoomId`, `CustomNo`, `RoomType`, `RoomName`, `AttachBathroom`, `NonSmokingRoom`, `Price`, `TotalOccupancy`) VALUES
(17, 102, 'Double', 'Deluxe  Room with Balcony', 0, 0, 200000.00, 16);

-- --------------------------------------------------------

--
-- Table structure for table `Staff`
--

CREATE TABLE `Staff` (
  `staff_id` int(11) NOT NULL,
  `staff_fullname` varchar(100) DEFAULT NULL,
  `staff_position` varchar(50) DEFAULT NULL,
  `staff_salary` decimal(10,2) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `staff_phone` varchar(20) DEFAULT NULL,
  `staff_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Staff`
--

INSERT INTO `Staff` (`staff_id`, `staff_fullname`, `staff_position`, `staff_salary`, `hire_date`, `balance`, `staff_phone`, `staff_email`) VALUES
(1, 'John Doe', 'Manager', 5000.00, '2022-01-15', 11.29, '123456789', 'john.doe@example.com'),
(2, 'Jane Smith', 'Assistant', 3000.00, '2021-08-10', 96.77, '987654321', 'jane.smith@example.com'),
(3, 'Michael Johnson', 'Supervisor', 4500.00, '2012-03-01', -54.84, '555555555', 'michael.johnson@example.com'),
(4, 'Emily Brown', 'Clerk', 2500.00, '2022-06-05', 80.65, '111111111', 'emily.brown@example.com'),
(5, 'David Wilson', 'Technician', 3500.00, '2022-02-01', 112.90, '999999999', 'david.wilson@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `Withdrawals`
--

CREATE TABLE `Withdrawals` (
  `withdrawal_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `withdrawal_date` date DEFAULT NULL,
  `withdrawal_amount` decimal(10,2) DEFAULT NULL,
  `withdrawal_reason` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Withdrawals`
--

INSERT INTO `Withdrawals` (`withdrawal_id`, `staff_id`, `withdrawal_date`, `withdrawal_amount`, `withdrawal_reason`) VALUES
(1, 1, '2023-07-08', 100.00, 'Expense reimbursement'),
(2, 1, '2023-07-08', 50.00, 'Office supplies'),
(3, 3, '2023-07-08', 200.00, 'Travel expenses');

--
-- Triggers `Withdrawals`
--
DELIMITER $$
CREATE TRIGGER `update_staff_balance_trigger` AFTER INSERT ON `Withdrawals` FOR EACH ROW BEGIN
  -- Update the staff's balance
  UPDATE Staff
  SET balance = balance - NEW.withdrawal_amount
  WHERE staff_id = NEW.staff_id;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `BedTypes`
--
ALTER TABLE `BedTypes`
  ADD PRIMARY KEY (`BedTypeId`),
  ADD KEY `RoomId` (`RoomId`);

--
-- Indexes for table `Rooms`
--
ALTER TABLE `Rooms`
  ADD PRIMARY KEY (`RoomId`);

--
-- Indexes for table `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `Withdrawals`
--
ALTER TABLE `Withdrawals`
  ADD PRIMARY KEY (`withdrawal_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `BedTypes`
--
ALTER TABLE `BedTypes`
  MODIFY `BedTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `Rooms`
--
ALTER TABLE `Rooms`
  MODIFY `RoomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `Withdrawals`
--
ALTER TABLE `Withdrawals`
  MODIFY `withdrawal_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `BedTypes`
--
ALTER TABLE `BedTypes`
  ADD CONSTRAINT `BedTypes_ibfk_1` FOREIGN KEY (`RoomId`) REFERENCES `Rooms` (`RoomId`) ON DELETE CASCADE;

--
-- Constraints for table `Withdrawals`
--
ALTER TABLE `Withdrawals`
  ADD CONSTRAINT `Withdrawals_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `Staff` (`staff_id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `DailyBalanceUpdate` ON SCHEDULE EVERY 1 DAY STARTS '2023-07-09 18:20:13' ON COMPLETION PRESERVE ENABLE DO CALL UpdateStaffBalance()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
