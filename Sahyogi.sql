-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 20, 2023 at 10:52 AM
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
(2, '000000', '111111', '0f58d5a5515f1a8a9d179aa58858b67b2f8a3388', '3333333@gmail.com', 'user');

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
(31, 18, 'Full bed / 131-150 cm wide', 2),
(32, 19, 'King bed / 181-210 cm wide', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Calendar`
--

CREATE TABLE `Calendar` (
  `DateID` int(11) NOT NULL,
  `RoomId` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Availabilities` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Calendar`
--

INSERT INTO `Calendar` (`DateID`, `RoomId`, `Date`, `Availabilities`) VALUES
(1085, 18, '2023-08-16', 2),
(1086, 18, '2023-08-17', 2),
(1087, 18, '2023-08-18', 2),
(1088, 18, '2023-08-19', 0),
(1089, 18, '2023-08-20', 2),
(1090, 18, '2023-08-21', 0),
(1091, 18, '2023-08-22', 1),
(1092, 18, '2023-08-23', 2),
(1093, 18, '2023-08-24', 1),
(1094, 18, '2023-08-25', 0),
(1095, 18, '2023-08-26', 0),
(1096, 18, '2023-08-27', 1),
(1097, 18, '2023-08-28', 2),
(1098, 18, '2023-08-29', 2),
(1099, 18, '2023-08-30', 2),
(1100, 18, '2023-08-31', 2),
(1101, 18, '2023-09-01', 2),
(1102, 18, '2023-09-02', 2),
(1103, 18, '2023-09-03', 2),
(1104, 18, '2023-09-04', 2),
(1105, 18, '2023-09-05', 2),
(1106, 18, '2023-09-06', 2),
(1107, 18, '2023-09-07', 2),
(1108, 18, '2023-09-08', 2),
(1109, 18, '2023-09-09', 2),
(1110, 18, '2023-09-10', 2),
(1111, 18, '2023-09-11', 2),
(1112, 18, '2023-09-12', 2),
(1113, 18, '2023-09-13', 2),
(1114, 18, '2023-09-14', 2),
(1115, 18, '2023-09-15', 2),
(1116, 18, '2023-09-16', 2),
(1117, 18, '2023-09-17', 2),
(1118, 18, '2023-09-18', 2),
(1119, 18, '2023-09-19', 2),
(1120, 18, '2023-09-20', 2),
(1121, 18, '2023-09-21', 2),
(1122, 18, '2023-09-22', 2),
(1123, 18, '2023-09-23', 2),
(1124, 18, '2023-09-24', 2),
(1125, 18, '2023-09-25', 2),
(1126, 18, '2023-09-26', 2),
(1127, 18, '2023-09-27', 2),
(1128, 18, '2023-09-28', 2),
(1129, 18, '2023-09-29', 2),
(1130, 18, '2023-09-30', 2),
(1131, 18, '2023-10-01', 2),
(1132, 18, '2023-10-02', 2),
(1133, 18, '2023-10-03', 2),
(1134, 18, '2023-10-04', 2),
(1135, 18, '2023-10-05', 2),
(1136, 18, '2023-10-06', 2),
(1137, 18, '2023-10-07', 2),
(1138, 18, '2023-10-08', 2),
(1139, 18, '2023-10-09', 2),
(1140, 18, '2023-10-10', 2),
(1141, 18, '2023-10-11', 2),
(1142, 18, '2023-10-12', 2),
(1143, 18, '2023-10-13', 2),
(1144, 18, '2023-10-14', 2),
(1145, 18, '2023-10-15', 2),
(1146, 18, '2023-10-16', 2),
(1147, 18, '2023-10-17', 2),
(1148, 18, '2023-10-18', 2),
(1149, 18, '2023-10-19', 2),
(1150, 18, '2023-10-20', 2),
(1151, 18, '2023-10-21', 2),
(1152, 18, '2023-10-22', 2),
(1153, 18, '2023-10-23', 2),
(1154, 18, '2023-10-24', 2),
(1155, 18, '2023-10-25', 2),
(1156, 18, '2023-10-26', 2),
(1157, 18, '2023-10-27', 2),
(1158, 18, '2023-10-28', 2),
(1159, 18, '2023-10-29', 2),
(1160, 18, '2023-10-30', 2),
(1161, 18, '2023-10-31', 2),
(1162, 18, '2023-11-01', 2),
(1163, 18, '2023-11-02', 2),
(1164, 18, '2023-11-03', 2),
(1165, 18, '2023-11-04', 2),
(1166, 18, '2023-11-05', 2),
(1167, 18, '2023-11-06', 2),
(1168, 18, '2023-11-07', 2),
(1169, 18, '2023-11-08', 2),
(1170, 18, '2023-11-09', 2),
(1171, 18, '2023-11-10', 2),
(1172, 18, '2023-11-11', 2),
(1173, 18, '2023-11-12', 2),
(1174, 18, '2023-11-13', 2),
(1175, 18, '2023-11-14', 2),
(1176, 18, '2023-11-15', 2),
(1177, 18, '2023-11-16', 2),
(1178, 18, '2023-11-17', 2),
(1179, 18, '2023-11-18', 2),
(1180, 18, '2023-11-19', 2),
(1181, 18, '2023-11-20', 2),
(1182, 18, '2023-11-21', 2),
(1183, 18, '2023-11-22', 2),
(1184, 18, '2023-11-23', 2),
(1185, 18, '2023-11-24', 2),
(1186, 18, '2023-11-25', 2),
(1187, 18, '2023-11-26', 2),
(1188, 18, '2023-11-27', 2),
(1189, 18, '2023-11-28', 2),
(1190, 18, '2023-11-29', 2),
(1191, 18, '2023-11-30', 2),
(1192, 19, '2023-08-17', 0),
(1193, 19, '2023-08-18', 1),
(1194, 19, '2023-08-19', 1),
(1195, 19, '2023-08-20', 1),
(1196, 19, '2023-08-21', 1),
(1197, 19, '2023-08-22', 1),
(1198, 19, '2023-08-23', 1),
(1199, 19, '2023-08-24', 1),
(1200, 19, '2023-08-25', 1),
(1201, 19, '2023-08-26', 1),
(1202, 19, '2023-08-27', 1),
(1203, 19, '2023-08-28', 1),
(1204, 19, '2023-08-29', 1),
(1205, 19, '2023-08-30', 1),
(1206, 19, '2023-08-31', 1),
(1207, 19, '2023-09-01', 1),
(1208, 19, '2023-09-02', 1),
(1209, 19, '2023-09-03', 1),
(1210, 19, '2023-09-04', 1),
(1211, 19, '2023-09-05', 1),
(1212, 19, '2023-09-06', 1),
(1213, 19, '2023-09-07', 1),
(1214, 19, '2023-09-08', 1),
(1215, 19, '2023-09-09', 1),
(1216, 19, '2023-09-10', 1),
(1217, 19, '2023-09-11', 1),
(1218, 19, '2023-09-12', 1),
(1219, 19, '2023-09-13', 1),
(1220, 19, '2023-09-14', 1),
(1221, 19, '2023-09-15', 1),
(1222, 19, '2023-09-16', 1),
(1223, 19, '2023-09-17', 1),
(1224, 19, '2023-09-18', 1),
(1225, 19, '2023-09-19', 1),
(1226, 19, '2023-09-20', 1),
(1227, 19, '2023-09-21', 0),
(1228, 19, '2023-09-22', 1),
(1229, 19, '2023-09-23', 1),
(1230, 19, '2023-09-24', 1),
(1231, 19, '2023-09-25', 1),
(1232, 19, '2023-09-26', 1),
(1233, 19, '2023-09-27', 1),
(1234, 19, '2023-09-28', 1),
(1235, 19, '2023-09-29', 1),
(1236, 19, '2023-09-30', 1),
(1237, 19, '2023-10-01', 1),
(1238, 19, '2023-10-02', 1),
(1239, 19, '2023-10-03', 1),
(1240, 19, '2023-10-04', 1),
(1241, 19, '2023-10-05', 1),
(1242, 19, '2023-10-06', 1),
(1243, 19, '2023-10-07', 1),
(1244, 19, '2023-10-08', 1),
(1245, 19, '2023-10-09', 1),
(1246, 19, '2023-10-10', 1),
(1247, 19, '2023-10-11', 1),
(1248, 19, '2023-10-12', 1),
(1249, 19, '2023-10-13', 1),
(1250, 19, '2023-10-14', 1),
(1251, 19, '2023-10-15', 1),
(1252, 19, '2023-10-16', 1),
(1253, 19, '2023-10-17', 1),
(1254, 19, '2023-10-18', 1),
(1255, 19, '2023-10-19', 1),
(1256, 19, '2023-10-20', 1),
(1257, 19, '2023-10-21', 1),
(1258, 19, '2023-10-22', 1),
(1259, 19, '2023-10-23', 1),
(1260, 19, '2023-10-24', 1),
(1261, 19, '2023-10-25', 1),
(1262, 19, '2023-10-26', 1),
(1263, 19, '2023-10-27', 1),
(1264, 19, '2023-10-28', 1),
(1265, 19, '2023-10-29', 1),
(1266, 19, '2023-10-30', 1),
(1267, 19, '2023-10-31', 1),
(1268, 19, '2023-11-01', 1),
(1269, 19, '2023-11-02', 1),
(1270, 19, '2023-11-03', 1),
(1271, 19, '2023-11-04', 1),
(1272, 19, '2023-11-05', 1),
(1273, 19, '2023-11-06', 1),
(1274, 19, '2023-11-07', 1),
(1275, 19, '2023-11-08', 1),
(1276, 19, '2023-11-09', 1),
(1277, 19, '2023-11-10', 1),
(1278, 19, '2023-11-11', 1),
(1279, 19, '2023-11-12', 1),
(1280, 19, '2023-11-13', 1),
(1281, 19, '2023-11-14', 1),
(1282, 19, '2023-11-15', 1),
(1283, 19, '2023-11-16', 1),
(1284, 19, '2023-11-17', 1),
(1285, 19, '2023-11-18', 1),
(1286, 19, '2023-11-19', 1),
(1287, 19, '2023-11-20', 1),
(1288, 19, '2023-11-21', 1),
(1289, 19, '2023-11-22', 1),
(1290, 19, '2023-11-23', 1),
(1291, 19, '2023-11-24', 1),
(1292, 19, '2023-11-25', 1),
(1293, 19, '2023-11-26', 1),
(1294, 19, '2023-11-27', 1),
(1295, 19, '2023-11-28', 1),
(1296, 19, '2023-11-29', 1),
(1297, 19, '2023-11-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Guests`
--

CREATE TABLE `Guests` (
  `GuestID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) NOT NULL,
  `ID_Verification` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `Review` varchar(100) DEFAULT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `image_path` varchar(255) NOT NULL DEFAULT 'Image/Hotel/GuestImg/defult.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Guests`
--

INSERT INTO `Guests` (`GuestID`, `FullName`, `Email`, `Phone`, `ID_Verification`, `Country`, `Review`, `Username`, `Password`, `image_path`) VALUES
(1, 'John Doe', 'john@example.com', '123-456-7890', 'A123456789', 'USA', 'Great experience', 'johndoe', 'password123', 'Image/Hotel/GuestImg/defult.jpg'),
(2, 'Jane Smith', 'jane@example.com', '987-654-3210', 'B987654321', 'Canada', 'Nice stay', 'janesmith', 'securepass', 'Image/Hotel/GuestImg/defult.jpg'),
(3, 'Michael Johnson', 'michael@example.com', '555-123-4567', 'C555123456', 'UK', 'Enjoyed the stay', 'michaelj', 'mypassword', 'Image/Hotel/GuestImg/defult.jpg'),
(4, 'Emily Brown', 'emily@example.com', '111-222-3333', 'D111222333', 'Australia', 'Amazing service', 'emilyb', 'pass123', 'Image/Hotel/GuestImg/defult.jpg'),
(5, 'David Lee', 'david@example.com', '444-555-6666', 'E444555666', 'Germany', 'Will come again', 'davidlee', 'strongpass', 'Image/Hotel/GuestImg/defult.jpg'),
(6, 'Jennifer Wilson', 'jennifer@example.com', '777-888-9999', 'F777888999', 'France', 'Lovely place', 'jenniferw', 'myp@ssword', 'Image/Hotel/GuestImg/defult.jpg'),
(7, 'Daniel Martin', 'daniel@example.com', '222-333-4444', 'G222333444', 'Spain', 'Excellent staff', 'danielm', '12345678', 'Image/Hotel/GuestImg/defult.jpg'),
(8, 'Sarah Taylor', 'sarah@example.com', '888-999-0000', 'H888999000', 'Italy', 'Top-notch facilities', 'saraht', 'secretpass', 'Image/Hotel/GuestImg/defult.jpg'),
(9, 'William Anderson', 'william@example.com', '666-777-8888', 'I666777888', 'Japan', 'Memorable stay', 'williama', 'p@ssw0rd', 'Image/Hotel/GuestImg/defult.jpg'),
(10, 'Olivia Davis', 'olivia@example.com', '333-444-5555', 'J333444555', 'South Korea', 'Friendly atmosphere', 'oliviad', 'welcome123', 'Image/Hotel/GuestImg/defult.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `Reservations`
--

CREATE TABLE `Reservations` (
  `ReservationID` int(11) NOT NULL,
  `GuestID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `CheckInDate` date NOT NULL,
  `CheckOutDate` date NOT NULL,
  `NumAdults` int(11) NOT NULL,
  `NumChildren` int(11) NOT NULL,
  `Stay` int(11) GENERATED ALWAYS AS (to_days(`CheckOutDate`) - to_days(`CheckInDate`)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Reservations`
--

INSERT INTO `Reservations` (`ReservationID`, `GuestID`, `RoomID`, `CheckInDate`, `CheckOutDate`, `NumAdults`, `NumChildren`) VALUES
(1, 1, 18, '2023-08-24', '2023-08-26', 2, 0),
(5, 5, 18, '2023-08-25', '2023-08-27', 2, 1),
(6, 6, 18, '2023-08-26', '2023-08-28', 2, 1),
(7, 7, 18, '2023-08-25', '2023-08-26', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE `Rooms` (
  `RoomId` int(11) NOT NULL,
  `CustomNo` varchar(11) DEFAULT NULL,
  `RoomType` varchar(255) DEFAULT NULL,
  `RoomName` varchar(255) DEFAULT NULL,
  `AttachBathroom` tinyint(1) DEFAULT NULL,
  `NonSmokingRoom` tinyint(1) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `TotalOccupancy` int(11) DEFAULT NULL,
  `imgpath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Rooms`
--

INSERT INTO `Rooms` (`RoomId`, `CustomNo`, `RoomType`, `RoomName`, `AttachBathroom`, `NonSmokingRoom`, `Price`, `TotalOccupancy`, `imgpath`) VALUES
(18, '101/102', 'Twin/Double', 'Deluxe  Room', 0, 0, 250.00, 2, 'Image/Hotel/Room/110.jpeg'),
(19, '101', 'Family', 'Deluxe Room', 1, 1, 1000.00, 1, 'Image/Hotel/Room/101.jpg');

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
(1, 'nik', 'owner', 11111.00, '2023-07-12', 1075.26, '2222222', 'nike@gmail.com'),
(3, 'Michael Johnson', 'Supervisor', 4500.00, '2012-03-01', 425.48, '44444444444', 'michael.johnson@example.com');

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
(11, 3, '2023-07-13', 10.00, '10 Re');

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
-- Indexes for table `Calendar`
--
ALTER TABLE `Calendar`
  ADD PRIMARY KEY (`DateID`),
  ADD UNIQUE KEY `UC_RoomDate` (`RoomId`,`Date`),
  ADD KEY `RoomId` (`RoomId`);

--
-- Indexes for table `Guests`
--
ALTER TABLE `Guests`
  ADD PRIMARY KEY (`GuestID`);

--
-- Indexes for table `Reservations`
--
ALTER TABLE `Reservations`
  ADD PRIMARY KEY (`ReservationID`),
  ADD KEY `GuestID` (`GuestID`),
  ADD KEY `RoomID` (`RoomID`);

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
  MODIFY `BedTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `Calendar`
--
ALTER TABLE `Calendar`
  MODIFY `DateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1298;

--
-- AUTO_INCREMENT for table `Guests`
--
ALTER TABLE `Guests`
  MODIFY `GuestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Reservations`
--
ALTER TABLE `Reservations`
  MODIFY `ReservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Rooms`
--
ALTER TABLE `Rooms`
  MODIFY `RoomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Withdrawals`
--
ALTER TABLE `Withdrawals`
  MODIFY `withdrawal_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `BedTypes`
--
ALTER TABLE `BedTypes`
  ADD CONSTRAINT `BedTypes_ibfk_1` FOREIGN KEY (`RoomId`) REFERENCES `Rooms` (`RoomId`) ON DELETE CASCADE;

--
-- Constraints for table `Calendar`
--
ALTER TABLE `Calendar`
  ADD CONSTRAINT `fk_Calendar_RoomId` FOREIGN KEY (`RoomId`) REFERENCES `Rooms` (`RoomId`) ON DELETE CASCADE;

--
-- Constraints for table `Reservations`
--
ALTER TABLE `Reservations`
  ADD CONSTRAINT `Reservations_ibfk_1` FOREIGN KEY (`GuestID`) REFERENCES `Guests` (`GuestID`),
  ADD CONSTRAINT `Reservations_ibfk_2` FOREIGN KEY (`RoomID`) REFERENCES `Rooms` (`RoomId`);

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
