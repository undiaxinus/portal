-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 06:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentportal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `Profile` varchar(100) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `idnumber` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `Profile`, `usertype`, `idnumber`) VALUES
(1, 'Admin', '', 'Admin', 'admin', 'admin', 'admin_avatar.png', 'ADMIN', '');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course`, `major`, `year`) VALUES
(1, 'Bachelor of Science in Information System', '', '2nd year'),
(7, 'Bachelor of Science in Tourism Management', 'fdsfdgrgs', '3rd year');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` int(11) NOT NULL,
  `teacher_number` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `mi` varchar(2) NOT NULL,
  `picture` varchar(50) NOT NULL,
  `first_grading` double NOT NULL,
  `second_grading` double NOT NULL,
  `third_grading` double NOT NULL,
  `fourth_grading` double NOT NULL,
  `final_grade` double NOT NULL,
  `remarks` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `teacher_number`, `firstname`, `lastname`, `mi`, `picture`, `first_grading`, `second_grading`, `third_grading`, `fourth_grading`, `final_grade`, `remarks`) VALUES
(1, 2, 'harry', 'den', 'A', '7qMiwNx.jpg', 70, 75, 65, 73, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `Prof` varchar(255) NOT NULL,
  `Code` varchar(255) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Timein` varchar(255) NOT NULL,
  `Day` varchar(255) NOT NULL,
  `Course` varchar(255) NOT NULL,
  `Major` varchar(255) NOT NULL,
  `Timeout` varchar(255) NOT NULL,
  `Year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `Prof`, `Code`, `Subject`, `Timein`, `Day`, `Course`, `Major`, `Timeout`, `Year`) VALUES
(7, 'kha', '13:20', 'financial management', '00:20', 'Tuesday', 'Bachelor of Science in Information System', '', '13:20', '2nd year'),
(8, 'qeq', 'sd', 'english', '13:23', 'Friday', 'Bachelor of Science in Information System', '', '03:29', '2nd year'),
(9, 'JD', '17:48', 'Math', '13:41', 'Friday', 'Bachelor of Science in Tourism Management', 'fdsfdgrgs', '17:48', '3rd year');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `student_id`, `address`, `picture`, `year`, `course`, `major`) VALUES
(4, 'cla', '12134-54342', 'san andress', 'images/_34b0e20b-cb80-45eb-90ee-80da6905cdc7.jpg', '1st year', 'BSCS', ''),
(5, 'Angelo', '6789-4234', 'san andress', 'images/_1ea8633c-19bc-4184-b73b-e7a5607bfa65-removebg-preview.png', '2nd year', 'Bachelor of Science in Information System', ''),
(6, 'Angelo John', '6789-4234', 'san andress', 'images/Capture13.PNG', '2nd year', 'BSTM', ''),
(8, 'ferl', '111222-2024', 'harani sa SL', 'images/picsbm.jpg', '3rd year', 'Bachelor of Science in Information System', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_records`
--

CREATE TABLE `student_records` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `preliminary` varchar(255) NOT NULL,
  `midterm` varchar(255) NOT NULL,
  `prefinals` varchar(255) NOT NULL,
  `finals` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_records`
--

INSERT INTO `student_records` (`id`, `student_id`, `year`, `semester`, `preliminary`, `midterm`, `prefinals`, `finals`, `code`, `subject`) VALUES
(1, '6789-4234', '1st year', '1st semester', '90', '89', '87', '98', 'DGHVS', 'App Development'),
(2, '6789-4234', '1st year', '2nd semester', '90', '89', '76', '80', 'JGHT', 'Math'),
(3, '6789-4234', '1st year', '1st semester', '78', '89', '76', '80', '45', 'filipino'),
(4, '6789-4234', '1st year', '1st semester', '78', '89', '76', '80', 'bfgd', 'english'),
(5, '6789-4234', '2nd year', '1st semester', '89', '09', '89', '89', 'ladkf', 'RTC'),
(6, '12345', '1st year', '1st semester', '87', '100', '80', '87', '234', 'filipino');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_records`
--
ALTER TABLE `student_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_records`
--
ALTER TABLE `student_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
