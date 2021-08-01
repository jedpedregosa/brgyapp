-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 01, 2021 at 05:41 PM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rtuappsysdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment`
--

DROP TABLE IF EXISTS `tbl_appointment`;
CREATE TABLE IF NOT EXISTS `tbl_appointment` (
  `app_num` int NOT NULL AUTO_INCREMENT,
  `app_id` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sched_id` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_branch` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_purpose` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_is_done` tinyint(1) DEFAULT '0',
  `app_done_date` date DEFAULT NULL,
  PRIMARY KEY (`app_id`),
  UNIQUE KEY `app_num` (`app_num`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment_auth`
--

DROP TABLE IF EXISTS `tbl_appointment_auth`;
CREATE TABLE IF NOT EXISTS `tbl_appointment_auth` (
  `app_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_key` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_data`
--

DROP TABLE IF EXISTS `tbl_employee_data`;
CREATE TABLE IF NOT EXISTS `tbl_employee_data` (
  `vstor_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_num` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`vstor_id`),
  UNIQUE KEY `employee_num` (`employee_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guest_data`
--

DROP TABLE IF EXISTS `tbl_guest_data`;
CREATE TABLE IF NOT EXISTS `tbl_guest_data` (
  `vstor_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `government_id` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`vstor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_office`
--

DROP TABLE IF EXISTS `tbl_office`;
CREATE TABLE IF NOT EXISTS `tbl_office` (
  `office_num` int NOT NULL AUTO_INCREMENT,
  `office_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_hasAdmin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`office_id`),
  KEY `office_num` (`office_num`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_office`
--

INSERT INTO `tbl_office` (`office_num`, `office_id`, `office_name`, `office_desc`, `office_branch`, `office_hasAdmin`) VALUES
(1, 'RTU-O01', 'Curriculum and Instructional Resources Development Center', '', 'Pasig Campus', 0),
(2, 'RTU-O02', 'Alumni Relations and Placement Office', '', 'Pasig Campus', 0),
(3, 'RTU-O03', 'Disaster Risk Protection Office', '', 'Pasig Campus', 0),
(4, 'RTU-O04', 'University Data Protection Office', '', 'Pasig Campus', 0),
(5, 'RTU-O05', 'Student Records and Admission Center', '', 'Boni Campus', 0),
(6, 'RTU-O06', 'Scholarship and Grant Office', '', 'Boni Campus', 0),
(7, 'RTU-O07', 'Graduate School', '', 'Boni Campus', 0),
(8, 'RTU-O08', 'Human Resource Development Center', '', 'Boni Campus', 0),
(9, 'RTU-O09', 'College of Engineering, Architecture and Technology', '', 'Boni Campus', 0),
(10, 'RTU-O10', 'Guidance Services Center', '', 'Boni Campus', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_office_admin`
--

DROP TABLE IF EXISTS `tbl_office_admin`;
CREATE TABLE IF NOT EXISTS `tbl_office_admin` (
  `oadmn_num` int NOT NULL AUTO_INCREMENT,
  `oadmn_id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oadmn_lname` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oadmn_fname` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oadmn_email` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oadmn_contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`oadmn_id`),
  UNIQUE KEY `oadmn_num` (`oadmn_num`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_office_adm_auth`
--

DROP TABLE IF EXISTS `tbl_office_adm_auth`;
CREATE TABLE IF NOT EXISTS `tbl_office_adm_auth` (
  `oadmn_id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oadmn_pass` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oadmn_gen_string` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oadmn_date_crtd` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oadmn_pass_chng` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'not defined',
  PRIMARY KEY (`oadmn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

DROP TABLE IF EXISTS `tbl_schedule`;
CREATE TABLE IF NOT EXISTS `tbl_schedule` (
  `sched_num` int NOT NULL AUTO_INCREMENT,
  `sched_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmslot_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sched_date` date NOT NULL,
  `sched_total_visitor` int DEFAULT '0',
  `sched_is_available` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`sched_id`),
  KEY `sched_num` (`sched_num`)
) ENGINE=InnoDB AUTO_INCREMENT=428 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_schedule`
--

INSERT INTO `tbl_schedule` (`sched_num`, `sched_id`, `tmslot_id`, `office_id`, `sched_date`, `sched_total_visitor`, `sched_is_available`) VALUES
(378, '2107260101', 'TMSLOT-01', 'RTU-O01', '2021-07-26', 0, 0),
(379, '2107260102', 'TMSLOT-02', 'RTU-O01', '2021-07-26', 0, 0),
(380, '2107260103', 'TMSLOT-03', 'RTU-O01', '2021-07-26', 0, 0),
(381, '2107260104', 'TMSLOT-04', 'RTU-O01', '2021-07-26', 0, 0),
(382, '2107260105', 'TMSLOT-05', 'RTU-O01', '2021-07-26', 0, 0),
(383, '2107260106', 'TMSLOT-06', 'RTU-O01', '2021-07-26', 0, 0),
(384, '2107260107', 'TMSLOT-07', 'RTU-O01', '2021-07-26', 0, 0),
(385, '2107260108', 'TMSLOT-08', 'RTU-O01', '2021-07-26', 0, 0),
(386, '2107260109', 'TMSLOT-09', 'RTU-O01', '2021-07-26', 0, 0),
(387, '2107260110', 'TMSLOT-10', 'RTU-O01', '2021-07-26', 0, 0),
(388, '2107260111', 'TMSLOT-11', 'RTU-O01', '2021-07-26', 0, 0),
(389, '2107260112', 'TMSLOT-12', 'RTU-O01', '2021-07-26', 0, 0),
(390, '2107260113', 'TMSLOT-13', 'RTU-O01', '2021-07-26', 0, 0),
(391, '2107260114', 'TMSLOT-14', 'RTU-O01', '2021-07-26', 0, 0),
(392, '2107260115', 'TMSLOT-15', 'RTU-O01', '2021-07-26', 0, 0),
(358, '2107260501', 'TMSLOT-01', 'RTU-O05', '2021-07-26', 3, 1),
(394, '2107280101', 'TMSLOT-01', 'RTU-O01', '2021-07-28', 0, 0),
(395, '2107280102', 'TMSLOT-02', 'RTU-O01', '2021-07-28', 0, 0),
(396, '2107280103', 'TMSLOT-03', 'RTU-O01', '2021-07-28', 0, 0),
(397, '2107280104', 'TMSLOT-04', 'RTU-O01', '2021-07-28', 0, 0),
(398, '2107280105', 'TMSLOT-05', 'RTU-O01', '2021-07-28', 0, 0),
(399, '2107280106', 'TMSLOT-06', 'RTU-O01', '2021-07-28', 0, 0),
(400, '2107280107', 'TMSLOT-07', 'RTU-O01', '2021-07-28', 0, 0),
(401, '2107280108', 'TMSLOT-08', 'RTU-O01', '2021-07-28', 0, 0),
(402, '2107280109', 'TMSLOT-09', 'RTU-O01', '2021-07-28', 0, 0),
(403, '2107280110', 'TMSLOT-10', 'RTU-O01', '2021-07-28', 0, 0),
(404, '2107280111', 'TMSLOT-11', 'RTU-O01', '2021-07-28', 0, 0),
(405, '2107280112', 'TMSLOT-12', 'RTU-O01', '2021-07-28', 0, 0),
(406, '2107280113', 'TMSLOT-13', 'RTU-O01', '2021-07-28', 0, 0),
(407, '2107280114', 'TMSLOT-14', 'RTU-O01', '2021-07-28', 0, 0),
(408, '2107280115', 'TMSLOT-15', 'RTU-O01', '2021-07-28', 0, 0),
(411, '2107300101', 'TMSLOT-01', 'RTU-O01', '2021-07-30', 0, 0),
(412, '2107300102', 'TMSLOT-02', 'RTU-O01', '2021-07-30', 0, 0),
(413, '2107300103', 'TMSLOT-03', 'RTU-O01', '2021-07-30', 0, 0),
(414, '2107300104', 'TMSLOT-04', 'RTU-O01', '2021-07-30', 0, 0),
(415, '2107300105', 'TMSLOT-05', 'RTU-O01', '2021-07-30', 0, 0),
(416, '2107300106', 'TMSLOT-06', 'RTU-O01', '2021-07-30', 0, 0),
(417, '2107300107', 'TMSLOT-07', 'RTU-O01', '2021-07-30', 0, 0),
(418, '2107300108', 'TMSLOT-08', 'RTU-O01', '2021-07-30', 0, 0),
(419, '2107300109', 'TMSLOT-09', 'RTU-O01', '2021-07-30', 0, 0),
(420, '2107300110', 'TMSLOT-10', 'RTU-O01', '2021-07-30', 0, 0),
(421, '2107300111', 'TMSLOT-11', 'RTU-O01', '2021-07-30', 0, 0),
(422, '2107300112', 'TMSLOT-12', 'RTU-O01', '2021-07-30', 0, 0),
(423, '2107300113', 'TMSLOT-13', 'RTU-O01', '2021-07-30', 0, 0),
(424, '2107300114', 'TMSLOT-14', 'RTU-O01', '2021-07-30', 0, 0),
(425, '2107300115', 'TMSLOT-15', 'RTU-O01', '2021-07-30', 0, 0),
(426, '2108020101', 'TMSLOT-01', 'RTU-O01', '2021-08-02', 2, 1),
(427, '2108040102', 'TMSLOT-02', 'RTU-O01', '2021-08-04', 1, 1),
(374, '2108110101', 'TMSLOT-01', 'RTU-O01', '2021-08-11', 5, 0),
(375, '2108110102', 'TMSLOT-02', 'RTU-O01', '2021-08-11', 5, 0),
(377, '2108110103', 'TMSLOT-03', 'RTU-O01', '2021-08-11', 5, 0),
(393, '2108110104', 'TMSLOT-04', 'RTU-O01', '2021-08-11', 5, 0),
(410, '2108110105', 'TMSLOT-05', 'RTU-O01', '2021-08-11', 4, 1),
(409, '2108110108', 'TMSLOT-08', 'RTU-O01', '2021-08-11', 1, 1),
(225, '2108110109', 'TMSLOT-09', 'RTU-O01', '2021-08-11', 5, 0),
(225, '2108110110', 'TMSLOT-010', 'RTU-O01', '2021-08-11', 5, 0),
(225, '2108110111', 'TMSLOT-011', 'RTU-O01', '2021-08-11', 5, 0),
(225, '2108110112', 'TMSLOT-012', 'RTU-O01', '2021-08-11', 5, 0),
(227, '2108110113', 'TMSLOT-013', 'RTU-O01', '2021-08-11', 5, 0),
(227, '2108110114', 'TMSLOT-014', 'RTU-O01', '2021-08-11', 5, 0),
(227, '2108110115', 'TMSLOT-015', 'RTU-O01', '2021-08-11', 5, 0),
(228, '2108190114', 'TMSLOT-14', 'RTU-O01', '2021-08-19', 1, 1),
(13, '2108190304', 'TMSLOT-04', 'RTU-O03', '2021-08-19', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_data`
--

DROP TABLE IF EXISTS `tbl_student_data`;
CREATE TABLE IF NOT EXISTS `tbl_student_data` (
  `vstor_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_num` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`vstor_id`),
  UNIQUE KEY `student_num` (`student_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_timeslot`
--

DROP TABLE IF EXISTS `tbl_timeslot`;
CREATE TABLE IF NOT EXISTS `tbl_timeslot` (
  `tmslot_num` int NOT NULL AUTO_INCREMENT,
  `tmslot_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmslot_start` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmslot_end` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`tmslot_num`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_timeslot`
--

INSERT INTO `tbl_timeslot` (`tmslot_num`, `tmslot_id`, `tmslot_start`, `tmslot_end`) VALUES
(1, 'TMSLOT-01', '8:00 AM', '8:30 AM'),
(2, 'TMSLOT-02', '8:30 AM', '9:00 AM'),
(3, 'TMSLOT-03', '9:00 AM', '9:30 AM'),
(4, 'TMSLOT-04', '9:30 AM', '10:00 AM'),
(5, 'TMSLOT-05', '10:00 AM', '10:30 AM'),
(6, 'TMSLOT-06', '10:30 AM', '11:00 AM'),
(7, 'TMSLOT-07', '11:00 AM', '11:30 AM'),
(8, 'TMSLOT-08', '11:30 AM', '12:00 PM'),
(9, 'TMSLOT-09', '12:00 PM', '12:30 PM'),
(10, 'TMSLOT-10', '12:30 PM', '1:00 PM'),
(11, 'TMSLOT-11', '1:00 PM', '1:30 PM'),
(12, 'TMSLOT-12', '1:30 PM', '2:00 PM'),
(13, 'TMSLOT-13', '2:00 PM', '2:30 PM'),
(14, 'TMSLOT-14', '2:30 PM', '3:00 PM'),
(15, 'TMSLOT-15', '3:00 PM', '3:30 PM');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visitor`
--

DROP TABLE IF EXISTS `tbl_visitor`;
CREATE TABLE IF NOT EXISTS `tbl_visitor` (
  `vstor_num` int NOT NULL AUTO_INCREMENT,
  `vstor_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_lname` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_fname` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_contact` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_email` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_hasApp` tinyint(1) DEFAULT '0' COMMENT 'If Visitor has an ongoing appointment.',
  PRIMARY KEY (`vstor_num`) USING BTREE,
  UNIQUE KEY `vstor_id` (`vstor_id`),
  UNIQUE KEY `vstor_email` (`vstor_email`)
) ENGINE=MyISAM AUTO_INCREMENT=287 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
