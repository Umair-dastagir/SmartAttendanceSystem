-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2020 at 10:55 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `admin_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_pass`, `admin_name`) VALUES
(1, 'sananadeem740@gmail.com', '$2y$12$iLFbXpMXxz3HExpJmyt5DeBzdX8tew.ZYhXe9Zx6wv3zY/XpJsvJW', 'sana'),
(3, 'umair123@gmail.com', '$2y$12$DNg0omwQWYDf8mznpTBaCulnI7Mcfzspb1PLASGnfipvqdMnFdVYK', 'umair'),
(4, 'nasim123@gmail.com', '$2y$12$DYGs1lvKs0uLkf9FirVxo.w08rj75deDRQinvKhsn5Te.am3hYTGi', 'nasim');

-- --------------------------------------------------------

--
-- Table structure for table `assigned_classes`
--

CREATE TABLE `assigned_classes` (
  `asgn_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `elective` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assigned_classes`
--

INSERT INTO `assigned_classes` (`asgn_id`, `class_id`, `instructor_id`, `course_id`, `elective`) VALUES
(1, 1, 1, 1, 0),
(2, 1, 2, 7, 1),
(3, 4, 3, 3, 1),
(4, 4, 3, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `att_id` int(11) NOT NULL,
  `assigned_id` int(11) NOT NULL,
  `qr_code` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`att_id`, `assigned_id`, `qr_code`, `date`) VALUES
(3, 4, '8U1tDyG1cyaIPBd', '2020-07-03');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_no` varchar(255) NOT NULL,
  `depart_id` int(11) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_no`, `depart_id`, `semester`) VALUES
(1, 'SE-8', 1, 8),
(2, 'SE-5', 1, 5),
(3, 'CS-7', 2, 7),
(4, 'CS-8', 2, 8),
(5, 'EE-2', 7, 2),
(6, 'EE-4', 7, 4),
(7, 'BTECH-5', 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `cred_hours` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_code`, `cred_hours`) VALUES
(1, 'Object Oriented Programming', 'OOP-2345', '2'),
(2, 'English', 'EL-1238', '2'),
(3, 'Operating System', 'OS-0982', '3'),
(4, 'Artificial Intelligence', 'AI-2233', '3'),
(5, 'Psychology', 'PSY-7821', '2'),
(7, 'Math', 'MAT-1234', '1'),
(8, 'Discrete Structures', 'DS-074', '2');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(255) NOT NULL,
  `faculty_id` varchar(255) NOT NULL,
  `chair_person` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`, `faculty_id`, `chair_person`) VALUES
(1, 'Software Engineering', '1', 'chair'),
(2, 'Computer Science', '1', 'Sir Riaz'),
(3, 'Mass Communication', '4', 'chair mass'),
(4, 'BSBA', '2', 'chair person bba'),
(5, 'Architecture', '2', 'archi'),
(6, 'Biotechnology', '5', 'flsi'),
(7, 'Electrical Engineering', '1', 'electrical chair');

-- --------------------------------------------------------

--
-- Table structure for table `electives`
--

CREATE TABLE `electives` (
  `elective_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `assigned_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `electives`
--

INSERT INTO `electives` (`elective_id`, `class_id`, `student_id`, `instructor_id`, `course_id`, `assigned_id`) VALUES
(1, 1, 4, 2, 7, 2),
(2, 1, 6, 2, 7, 2),
(4, 4, 1, 3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `fac_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `fac_name`) VALUES
(1, 'FICT'),
(2, 'FOE'),
(3, 'FMS'),
(4, 'FABS'),
(5, 'FLSI');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `instructor_id` int(11) NOT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `instructor_lname` varchar(255) NOT NULL,
  `instructor_dept` varchar(255) NOT NULL,
  `instructor_position` varchar(255) NOT NULL,
  `instructor_email` varchar(255) NOT NULL,
  `instructor_pass` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`instructor_id`, `instructor_name`, `instructor_lname`, `instructor_dept`, `instructor_position`, `instructor_email`, `instructor_pass`, `is_active`, `created_at`) VALUES
(1, 'ins', '1', '1', 'lecturar', 'ins@gmail.com', '$2y$10$upZuZam6LhMhtDIyVR.WQe62syIwNVM1sKc3O12RNyWaOrNnAUcy.', 1, '2020-06-30 10:22:42'),
(2, 'ins', '2', '2', 'lecturar', 'ins2@gmail.com', '$2y$10$GxCQn4zg1tg9jecC8K.O4OsuZ.Z1j1Q8MP1y6XGOV6Fha45qdT2EG', 1, '2020-06-30 10:23:03'),
(3, 'ins', '3', '6', 'lecturar', 'ins3@gmail.com', '$2y$10$4xnJoIVjPoP2TQxgJohnrOAbR/853eM3/E8N/Al3wKOivqtW51cd2', 1, '2020-06-30 10:23:24'),
(4, 'ins', '4', '7', 'lecturar', 'ins4@gmail.com', 'ins4', 0, '2020-06-30 10:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `cms_id` varchar(255) NOT NULL,
  `student_lastname` varchar(255) NOT NULL,
  `student_email` varchar(255) NOT NULL,
  `student_password` varchar(255) NOT NULL,
  `student_dept` int(11) NOT NULL,
  `student_semester` int(11) NOT NULL,
  `admit_term` varchar(255) NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'false = 0, true = 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `cms_id`, `student_lastname`, `student_email`, `student_password`, `student_dept`, `student_semester`, `admit_term`, `registered_at`, `is_active`) VALUES
(1, 'umair', '34343', 'umair', 'umair@gmail.com', '$2y$10$pYljKhwGedo2hM0qVoobiuLDxiRhdM87BiX9EEC7ee2Vp78fbT7me', 2, 8, 'Fall 2016', '2020-06-30 10:25:53', 1),
(2, 'naseem', '33223', 'khilji', 'naseem@gmail.com', 'naseem', 2, 8, 'Fall 2016', '2020-06-30 10:26:17', 0),
(3, 'urooj', '12345', 'khalid', 'urooj@gmail.com', 'urooj', 2, 8, 'Fall 2016', '2020-06-30 10:45:07', 0),
(4, 'Sana', '35435', 'Nadeem', 'sananadeem740@gmail.com', 'sana', 1, 8, 'Fall 2015', '2020-06-30 10:45:53', 0),
(5, 'hina', '33359', 'rutaba', 'hina@gmail.com', 'hina', 1, 8, 'Fall 2015', '2020-06-30 10:46:12', 0),
(6, 'hira', '33828', 'mgm', 'hira.mgm97@gmail.com', 'hira', 1, 8, 'Fall 2015', '2020-06-30 10:46:46', 0),
(7, 'elec', '33546', 'one', 'elec1@gmail.com', 'elec', 7, 2, 'fall 2019', '2020-06-30 10:48:57', 0),
(8, 'elec', '35765', '2', 'elect2@gmail.com', 'elec2', 7, 2, 'fall 2019', '2020-06-30 10:49:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_enrollment`
--

CREATE TABLE `student_enrollment` (
  `enr_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `enr_course` int(11) NOT NULL,
  `enr_instructor` int(11) NOT NULL,
  `elective` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = not elective, 1 = elective'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stud_attendance`
--

CREATE TABLE `stud_attendance` (
  `sa_id` int(11) NOT NULL,
  `att_id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL,
  `st_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stud_attendance`
--

INSERT INTO `stud_attendance` (`sa_id`, `att_id`, `assign_id`, `st_id`, `status`) VALUES
(1, 3, 4, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `assigned_classes`
--
ALTER TABLE `assigned_classes`
  ADD PRIMARY KEY (`asgn_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`att_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `electives`
--
ALTER TABLE `electives`
  ADD PRIMARY KEY (`elective_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_enrollment`
--
ALTER TABLE `student_enrollment`
  ADD PRIMARY KEY (`enr_id`);

--
-- Indexes for table `stud_attendance`
--
ALTER TABLE `stud_attendance`
  ADD PRIMARY KEY (`sa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assigned_classes`
--
ALTER TABLE `assigned_classes`
  MODIFY `asgn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `att_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `electives`
--
ALTER TABLE `electives`
  MODIFY `elective_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_enrollment`
--
ALTER TABLE `student_enrollment`
  MODIFY `enr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stud_attendance`
--
ALTER TABLE `stud_attendance`
  MODIFY `sa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
