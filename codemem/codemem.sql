-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2015 at 03:15 PM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codemem`
--
CREATE DATABASE IF NOT EXISTS `codemem` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `codemem`;

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

DROP TABLE IF EXISTS `assignment`;
CREATE TABLE `assignment` (
  `id` int(11) NOT NULL,
  `Assignment_no` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `upload_date` date NOT NULL,
  `file` varchar(50) NOT NULL,
  `class_id` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`id`, `Assignment_no`, `due_date`, `upload_date`, `file`, `class_id`) VALUES
(1, 1, '2015-12-05', '2015-12-01', '', '12A'),
(2, 1, '2015-12-02', '2015-12-01', '', '14D'),
(3, 3, '2015-12-05', '2015-12-01', '', '14D'),
(4, 0, '2015-01-01', '2015-12-11', 'uploads/Hello1.cpp', '12A'),
(5, 0, '2015-01-01', '2015-12-11', 'uploads/Hello1.cpp', '12A');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `id` varchar(3) NOT NULL,
  `instructor_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `instructor_id`) VALUES
('14D', 'adnanwaheed@nu.edu.pk'),
('12A', 'rabiamaqsood@nu.edu.pk');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades` (
  `student_id` varchar(30) NOT NULL,
  `marks` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`student_id`, `marks`, `assignment_id`) VALUES
('f128035@nu.edu.pk', 20, 2),
('f128035@nu.edu.pk', 30, 3);

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

DROP TABLE IF EXISTS `instructor`;
CREATE TABLE `instructor` (
  `id` varchar(30) NOT NULL,
  `pass` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`id`, `pass`) VALUES
('adnanwaheed@nu.edu.pk', '123456'),
('rabiamaqsood@nu.edu.pk', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `id` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `class_id` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `password`, `class_id`) VALUES
('f128035@nu.edu.pk', 'xyz', '14D');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
CREATE TABLE `vendor` (
  `V_CODE` int(11) NOT NULL,
  `V_NAME` varchar(35) NOT NULL,
  `V_CONTACT` varchar(25) NOT NULL,
  `V_AREACODE` char(3) NOT NULL,
  `V_PHONE` char(8) NOT NULL,
  `V_STATE` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`student_id`,`assignment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`V_CODE`),
  ADD UNIQUE KEY `V_CODE` (`V_CODE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`assignment_id`) REFERENCES `assignment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
