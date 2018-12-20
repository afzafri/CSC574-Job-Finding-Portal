-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2018 at 06:42 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jfp`
--

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `J_ID` int(11) NOT NULL,
  `J_TITLE` varchar(50) NOT NULL,
  `J_DESC` text NOT NULL,
  `J_AREA` varchar(100) NOT NULL,
  `J_ADDRESS` varchar(250) NOT NULL,
  `J_SALARY` float NOT NULL,
  `J_START` datetime DEFAULT NULL,
  `J_END` datetime DEFAULT NULL,
  `JP_ID` int(11) NOT NULL,
  `J_STATUS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`J_ID`, `J_TITLE`, `J_DESC`, `J_AREA`, `J_ADDRESS`, `J_SALARY`, `J_START`, `J_END`, `JP_ID`, `J_STATUS`) VALUES
(2, 'Potong rumput UiTM', 'Potong kasi elok, kalau cun, up bonus', 'perkebunan,trimming', 'Kangaq, Perlis', 200, '2018-11-21 13:48:00', '2018-11-21 16:48:00', 1, 1),
(3, 'Buat LR afif', 'tolong afif redo lr dia ciannnnn redho', 'WritingFYP,msword,fyp', 'Wisma Kospek, Perak', 10000, '2018-11-20 01:00:00', '2018-11-22 01:00:00', 1, 1),
(5, 'Android Programmer', 'tolong buat fyp aku', 'Programming', 'Wisma Kospek, Tapah, Perak', 200, '2018-11-22 17:03:00', '2018-12-07 11:30:00', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_application`
--

CREATE TABLE `job_application` (
  `J_ID` int(11) NOT NULL,
  `JS_ID` int(11) NOT NULL,
  `APPLY_DATE` datetime NOT NULL,
  `STATUS` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_application`
--

INSERT INTO `job_application` (`J_ID`, `JS_ID`, `APPLY_DATE`, `STATUS`) VALUES
(2, 1, '2018-11-21 05:08:00', 0),
(3, 1, '2018-11-02 03:09:08', 1),
(5, 1, '2018-11-21 17:23:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_done`
--

CREATE TABLE `job_done` (
  `JD_ID` int(11) NOT NULL,
  `JD_DESC` text NOT NULL,
  `JD_PICTURE` varchar(100) NOT NULL,
  `JS_ID` int(11) NOT NULL,
  `J_ID` int(11) NOT NULL,
  `POST_TIME` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_done`
--

INSERT INTO `job_done` (`JD_ID`, `JD_DESC`, `JD_PICTURE`, `JS_ID`, `J_ID`, `POST_TIME`) VALUES
(1, '<p>Penat buat kerja uihhh gaji sikit.</p>\r\n\r\n<p>Ingat aku ironman ka. Aku flash kot</p>\r\n', 'flash_family_002.jpg', 1, 3, '2018-11-21 17:47:49'),
(3, '<p><strong>Kerja paling best</strong></p>\r\n\r\n<p>Best gilerws jadi programmer android. Susah jugak la tapi aku belajar benda baru. gempak do</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>kalau malas jangan</p>\r\n', 'Screenshot_1540713156.png', 1, 5, '2018-11-21 22:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `job_provider`
--

CREATE TABLE `job_provider` (
  `JP_ID` int(11) NOT NULL,
  `JP_NAME` varchar(200) DEFAULT NULL,
  `JP_DESCRIPTION` varchar(250) DEFAULT NULL,
  `JP_AREA` varchar(100) DEFAULT NULL,
  `JP_ADDRESS` varchar(250) DEFAULT NULL,
  `JP_PHONE` varchar(20) DEFAULT NULL,
  `JP_WEBSITE` varchar(50) DEFAULT NULL,
  `JP_PROFILEPIC` varchar(100) DEFAULT NULL,
  `L_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_provider`
--

INSERT INTO `job_provider` (`JP_ID`, `JP_NAME`, `JP_DESCRIPTION`, `JP_AREA`, `JP_ADDRESS`, `JP_PHONE`, `JP_WEBSITE`, `JP_PROFILEPIC`, `L_ID`) VALUES
(1, 'Afif Zafri', 'kerja kerja kontrak', 'Developer', 'NO 4, BATU 4 3/4, KAMPUNG PAYA, JALAN KAKI BUKIT', '0174105440', 'https://twitter.com/afzafri', '8a606ea4ab3111e286b922000a9f14cd_7.jpg', 1),
(2, 'Hassan Hamid', 'Saya student fyp buntu', 'Programming', 'UiTM Tapah', '01312544544', '', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `job_seeker`
--

CREATE TABLE `job_seeker` (
  `JS_ID` int(11) NOT NULL,
  `JS_NAME` varchar(200) DEFAULT NULL,
  `JS_ABOUT` text,
  `JS_IC` varchar(13) DEFAULT NULL,
  `JS_ADDRESS` varchar(250) DEFAULT NULL,
  `JS_SKILL` varchar(250) DEFAULT NULL,
  `JS_PHONE` varchar(20) DEFAULT NULL,
  `JS_PROFILEPIC` varchar(100) DEFAULT NULL,
  `L_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_seeker`
--

INSERT INTO `job_seeker` (`JS_ID`, `JS_NAME`, `JS_ABOUT`, `JS_IC`, `JS_ADDRESS`, `JS_SKILL`, `JS_PHONE`, `JS_PROFILEPIC`, `L_ID`) VALUES
(1, 'Akmal Irham', 'saya suka cat', '961103055577', 'seremban', 'melancap', '0174105440', 'Flash_0012.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `L_ID` int(11) NOT NULL,
  `L_EMAIL` varchar(100) NOT NULL,
  `L_USERNAME` varchar(20) NOT NULL,
  `L_PASSWORD` varchar(50) NOT NULL,
  `L_LEVEL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`L_ID`, `L_EMAIL`, `L_USERNAME`, `L_PASSWORD`, `L_LEVEL`) VALUES
(1, 'afzafri@gmail.com', 'afzafri', 'd5215a4d1da0bfe8860dd9c61a105a8a', 2),
(2, 'akmal@gmail.com', 'akmalirham', 'a4b409d73f441c78cb65cc5b55149e85', 3),
(3, 'hassan@gmail.com', 'hassan', '118c5c147f6d3136cd66005c14e5dd20', 2);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `S_ID` int(11) NOT NULL,
  `S_NAME` varchar(200) NOT NULL,
  `S_IC` varchar(13) NOT NULL,
  `S_ADDRESS` varchar(250) NOT NULL,
  `S_DEPARTMENT` varchar(200) NOT NULL,
  `S_PHONE` varchar(20) NOT NULL,
  `S_PROFILEPIC` varchar(100) NOT NULL,
  `L_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`J_ID`),
  ADD KEY `JP_ID` (`JP_ID`);

--
-- Indexes for table `job_application`
--
ALTER TABLE `job_application`
  ADD PRIMARY KEY (`J_ID`,`JS_ID`),
  ADD KEY `J_ID` (`J_ID`),
  ADD KEY `U_ID` (`JS_ID`);

--
-- Indexes for table `job_done`
--
ALTER TABLE `job_done`
  ADD PRIMARY KEY (`JD_ID`),
  ADD KEY `U_ID` (`JS_ID`),
  ADD KEY `J_ID` (`J_ID`);

--
-- Indexes for table `job_provider`
--
ALTER TABLE `job_provider`
  ADD PRIMARY KEY (`JP_ID`),
  ADD KEY `L_ID` (`L_ID`);

--
-- Indexes for table `job_seeker`
--
ALTER TABLE `job_seeker`
  ADD PRIMARY KEY (`JS_ID`),
  ADD KEY `L_ID` (`L_ID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`L_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`S_ID`),
  ADD KEY `L_ID` (`L_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `J_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_done`
--
ALTER TABLE `job_done`
  MODIFY `JD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job_provider`
--
ALTER TABLE `job_provider`
  MODIFY `JP_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_seeker`
--
ALTER TABLE `job_seeker`
  MODIFY `JS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `L_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `S_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `fk_job_job_provider` FOREIGN KEY (`JP_ID`) REFERENCES `job_provider` (`JP_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_application`
--
ALTER TABLE `job_application`
  ADD CONSTRAINT `fk_bridge_job` FOREIGN KEY (`J_ID`) REFERENCES `job` (`J_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bridge_user` FOREIGN KEY (`JS_ID`) REFERENCES `job_seeker` (`JS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_done`
--
ALTER TABLE `job_done`
  ADD CONSTRAINT `fk_job_done_job` FOREIGN KEY (`J_ID`) REFERENCES `job` (`J_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_job_done_user` FOREIGN KEY (`JS_ID`) REFERENCES `job_seeker` (`JS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_provider`
--
ALTER TABLE `job_provider`
  ADD CONSTRAINT `fk_job_provider_login` FOREIGN KEY (`L_ID`) REFERENCES `login` (`L_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_seeker`
--
ALTER TABLE `job_seeker`
  ADD CONSTRAINT `fk_job_seeker_login` FOREIGN KEY (`L_ID`) REFERENCES `login` (`L_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `fk_staff_login` FOREIGN KEY (`L_ID`) REFERENCES `login` (`L_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
