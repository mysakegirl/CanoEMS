-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2022 at 09:07 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `archiedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblevent`
--

CREATE TABLE `tblevent` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(300) NOT NULL,
  `date` date NOT NULL,
  `venue` varchar(300) NOT NULL,
  `time` time NOT NULL,
  `event_name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblevent`
--

INSERT INTO `tblevent` (`event_id`, `event_title`, `date`, `venue`, `time`, `event_name`) VALUES
(1, 'THE INTERNATIONAL 10', '2022-03-25', 'KATOWICE', '05:00:00', 'DOTA 2'),
(2, 'DREAMHACK', '2022-03-24', 'BELGIUM', '08:20:00', 'DOTA 2'),
(3, 'Beyond the Summit', '2022-03-25', 'Dubai', '09:00:00', 'DOTA 2'),
(4, 'ACT GRADUATION 2022', '2022-06-15', 'ASIAN COLLEGE OF TECHNOLOGY', '05:49:00', 'ACT GRADUATION'),
(5, 'ACT GRADUATION 2022', '2022-06-15', 'ASIAN COLLEGE OF TECHNOLOGY', '05:49:00', 'ACT GRADUATION'),
(6, 'ACT GRADUATION PRACTICE', '2022-06-16', '10TH FLOOR', '21:03:00', 'ACT PRACTICE'),
(9, 'GRADUATES RING HOP 2022', '2022-02-05', 'ACT 10TH FLOOR', '08:00:00', 'RING HOP');

-- --------------------------------------------------------

--
-- Table structure for table `tbleventdetails`
--

CREATE TABLE `tbleventdetails` (
  `EventDetailsId` int(11) NOT NULL,
  `EventId` int(11) NOT NULL,
  `SpeakerName` varchar(300) NOT NULL,
  `Title` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbleventdetails`
--

INSERT INTO `tbleventdetails` (`EventDetailsId`, `EventId`, `SpeakerName`, `Title`) VALUES
(1, 6, 'DEVORAH', 'SPEECH'),
(2, 6, 'ELEANOIR', 'SPEECH'),
(3, 9, 'SIR JAY', 'DEANS SPEECH');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(300) NOT NULL,
  `UserType` varchar(100) NOT NULL,
  `SQuestion` varchar(300) NOT NULL,
  `SAnswer` varchar(300) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`UserID`, `Name`, `UserType`, `SQuestion`, `SAnswer`, `Username`, `Password`, `Status`) VALUES
(1, 'Archie', 'ADMIN', 'In what city were you born?', 'admin', 'admin', '$2y$10$c8Sp.BrIq3OZSRteHtrpf..u4bpaU/hwlTW2f2v8e25rj7r1i51Zm', 'ACTIVE'),
(2, 'John Doe', 'TA', 'What high school did you attend?', 'uva', 'admin22', '$2y$10$C4c5FbpqW7zEKHosEGjUmuisyU9ltv2ysrLBipVMX/1QFklUhjVfy', 'ACTIVE'),
(3, 'admin 3', 'TA', 'In what city were you born?', 'cebu city', 'admin3', '$2y$10$vSMX5d.N0dAaOENOcBeMTefFFgONAUqDBuTnaisJb9VfYgK2eylIC', 'ACTIVE'),
(4, 'Eleanoir', 'TA', '', '', 'user4', '$2y$10$Gaq2hU837xh.awPi9x7I4eQkvtTEC4a5Zy4vGwdk7MeVPQAuNHhu2', 'ACTIVE'),
(5, 'Caera', 'TA', 'What is the name of your favorite pet?', 'Pepper', 'admin5', '$2y$10$6zp2IK73gjavDyraBmbWYuB8KLtPZiSaltEN2Kjq3rj1ebWaQ1VjS', 'ACTIVE'),
(6, 'Seris', 'ADMIN', 'In what city were you born?', 'Alacrya', 'user6', '$2y$10$oS2/NR.M1tBGcFW6BB8wwuXZW6TrxEu2IH.1Nl3WPJmOvWJPviosm', 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblevent`
--
ALTER TABLE `tblevent`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tbleventdetails`
--
ALTER TABLE `tbleventdetails`
  ADD PRIMARY KEY (`EventDetailsId`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblevent`
--
ALTER TABLE `tblevent`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbleventdetails`
--
ALTER TABLE `tbleventdetails`
  MODIFY `EventDetailsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
