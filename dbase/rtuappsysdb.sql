-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 11, 2021 at 10:04 PM
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
-- Table structure for table `tbl_appdone_vstr`
--

DROP TABLE IF EXISTS `tbl_appdone_vstr`;
CREATE TABLE IF NOT EXISTS `tbl_appdone_vstr` (
  `app_num` int NOT NULL AUTO_INCREMENT,
  `app_id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_lname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_fname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_idnum` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_contact` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vstor_ip_add` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`app_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `app_sys_time` datetime NOT NULL,
  `app_is_done` tinyint(1) DEFAULT '0',
  `app_done_date` datetime DEFAULT NULL,
  PRIMARY KEY (`app_id`),
  UNIQUE KEY `app_num` (`app_num`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment_auth`
--

DROP TABLE IF EXISTS `tbl_appointment_auth`;
CREATE TABLE IF NOT EXISTS `tbl_appointment_auth` (
  `app_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_key` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_key1` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_key2` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_key` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`app_id`),
  UNIQUE KEY `app_key` (`app_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment_done`
--

DROP TABLE IF EXISTS `tbl_appointment_done`;
CREATE TABLE IF NOT EXISTS `tbl_appointment_done` (
  `app_num` int NOT NULL AUTO_INCREMENT,
  `app_id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_branch` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_date` date NOT NULL,
  `tmslot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_purpose` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_sys_time` datetime NOT NULL,
  `app_done_date` datetime NOT NULL,
  PRIMARY KEY (`app_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_app_wlkin`
--

DROP TABLE IF EXISTS `tbl_app_wlkin`;
CREATE TABLE IF NOT EXISTS `tbl_app_wlkin` (
  `wlkin_num` int NOT NULL AUTO_INCREMENT,
  `office_id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wlkin_date` datetime NOT NULL,
  PRIMARY KEY (`wlkin_num`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `tbl_feedback`
--

DROP TABLE IF EXISTS `tbl_feedback`;
CREATE TABLE IF NOT EXISTS `tbl_feedback` (
  `fback_id` int NOT NULL AUTO_INCREMENT,
  `office_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fback_fname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fback_cat` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fback_contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fback_email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fback_msg` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fback_sys_time` datetime NOT NULL,
  `fback_is_stsfd` tinyint(1) NOT NULL,
  `fback_ip_add` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`fback_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `tbl_office_upld`
--

DROP TABLE IF EXISTS `tbl_office_upld`;
CREATE TABLE IF NOT EXISTS `tbl_office_upld` (
  `upld_id` int NOT NULL AUTO_INCREMENT,
  `oadmn_id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upld_key` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upld_mime` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`upld_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `sched_isClosed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`sched_id`),
  KEY `sched_num` (`sched_num`)
) ENGINE=InnoDB AUTO_INCREMENT=898 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  PRIMARY KEY (`tmslot_num`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_timeslot`
--

INSERT INTO `tbl_timeslot` (`tmslot_num`, `tmslot_id`, `tmslot_start`, `tmslot_end`, `time_start`, `time_end`) VALUES
(1, 'TMSLOT-01', '8:00 AM', '8:30 AM', '08:00:00', '08:30:00'),
(2, 'TMSLOT-02', '8:30 AM', '9:00 AM', '08:30:00', '09:00:00'),
(3, 'TMSLOT-03', '9:00 AM', '9:30 AM', '09:00:00', '09:30:00'),
(4, 'TMSLOT-04', '9:30 AM', '10:00 AM', '09:30:00', '10:00:00'),
(5, 'TMSLOT-05', '10:00 AM', '10:30 AM', '10:00:00', '10:30:00'),
(6, 'TMSLOT-06', '10:30 AM', '11:00 AM', '10:30:00', '11:00:00'),
(7, 'TMSLOT-07', '11:00 AM', '11:30 AM', '11:00:00', '11:30:00'),
(8, 'TMSLOT-08', '11:30 AM', '12:00 PM', '11:30:00', '12:00:00'),
(9, 'TMSLOT-09', '12:00 PM', '12:30 PM', '12:00:00', '12:30:00'),
(10, 'TMSLOT-10', '12:30 PM', '1:00 PM', '12:30:00', '13:00:00'),
(11, 'TMSLOT-11', '1:00 PM', '1:30 PM', '13:00:00', '13:30:00'),
(12, 'TMSLOT-12', '1:30 PM', '2:00 PM', '13:30:00', '14:00:00'),
(13, 'TMSLOT-13', '2:00 PM', '2:30 PM', '14:00:00', '14:30:00'),
(14, 'TMSLOT-14', '2:30 PM', '3:00 PM', '14:30:00', '15:00:00'),
(15, 'TMSLOT-15', '3:00 PM', '3:30 PM', '15:00:00', '15:30:00');

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
  `vstor_ip_add` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`vstor_num`) USING BTREE,
  UNIQUE KEY `vstor_id` (`vstor_id`),
  UNIQUE KEY `vstor_email` (`vstor_email`)
) ENGINE=MyISAM AUTO_INCREMENT=337 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
