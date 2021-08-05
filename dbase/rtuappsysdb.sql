-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 05, 2021 at 08:00 PM
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
  `app_sys_time` datetime NOT NULL,
  `app_is_done` tinyint(1) DEFAULT '0',
  `app_done_date` date DEFAULT NULL,
  PRIMARY KEY (`app_id`),
  UNIQUE KEY `app_num` (`app_num`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `sched_isClosed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`sched_id`),
  KEY `sched_num` (`sched_num`)
) ENGINE=InnoDB AUTO_INCREMENT=837 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_schedule`
--

INSERT INTO `tbl_schedule` (`sched_num`, `sched_id`, `tmslot_id`, `office_id`, `sched_date`, `sched_total_visitor`, `sched_is_available`, `sched_isClosed`) VALUES
(378, '2107260101', 'TMSLOT-01', 'RTU-O01', '2021-07-26', 0, 0, 0),
(379, '2107260102', 'TMSLOT-02', 'RTU-O01', '2021-07-26', 0, 0, 0),
(380, '2107260103', 'TMSLOT-03', 'RTU-O01', '2021-07-26', 0, 0, 0),
(381, '2107260104', 'TMSLOT-04', 'RTU-O01', '2021-07-26', 0, 0, 0),
(382, '2107260105', 'TMSLOT-05', 'RTU-O01', '2021-07-26', 0, 0, 0),
(383, '2107260106', 'TMSLOT-06', 'RTU-O01', '2021-07-26', 0, 0, 0),
(384, '2107260107', 'TMSLOT-07', 'RTU-O01', '2021-07-26', 0, 0, 0),
(385, '2107260108', 'TMSLOT-08', 'RTU-O01', '2021-07-26', 0, 0, 0),
(386, '2107260109', 'TMSLOT-09', 'RTU-O01', '2021-07-26', 0, 0, 0),
(387, '2107260110', 'TMSLOT-10', 'RTU-O01', '2021-07-26', 0, 0, 0),
(388, '2107260111', 'TMSLOT-11', 'RTU-O01', '2021-07-26', 0, 0, 0),
(389, '2107260112', 'TMSLOT-12', 'RTU-O01', '2021-07-26', 0, 0, 0),
(390, '2107260113', 'TMSLOT-13', 'RTU-O01', '2021-07-26', 0, 0, 0),
(391, '2107260114', 'TMSLOT-14', 'RTU-O01', '2021-07-26', 0, 0, 0),
(392, '2107260115', 'TMSLOT-15', 'RTU-O01', '2021-07-26', 0, 0, 0),
(358, '2107260501', 'TMSLOT-01', 'RTU-O05', '2021-07-26', 3, 1, 0),
(394, '2107280101', 'TMSLOT-01', 'RTU-O01', '2021-07-28', 0, 0, 0),
(395, '2107280102', 'TMSLOT-02', 'RTU-O01', '2021-07-28', 0, 0, 0),
(396, '2107280103', 'TMSLOT-03', 'RTU-O01', '2021-07-28', 0, 0, 0),
(397, '2107280104', 'TMSLOT-04', 'RTU-O01', '2021-07-28', 0, 0, 0),
(398, '2107280105', 'TMSLOT-05', 'RTU-O01', '2021-07-28', 0, 0, 0),
(399, '2107280106', 'TMSLOT-06', 'RTU-O01', '2021-07-28', 0, 0, 0),
(400, '2107280107', 'TMSLOT-07', 'RTU-O01', '2021-07-28', 0, 0, 0),
(401, '2107280108', 'TMSLOT-08', 'RTU-O01', '2021-07-28', 0, 0, 0),
(402, '2107280109', 'TMSLOT-09', 'RTU-O01', '2021-07-28', 0, 0, 0),
(403, '2107280110', 'TMSLOT-10', 'RTU-O01', '2021-07-28', 0, 0, 0),
(404, '2107280111', 'TMSLOT-11', 'RTU-O01', '2021-07-28', 0, 0, 0),
(405, '2107280112', 'TMSLOT-12', 'RTU-O01', '2021-07-28', 0, 0, 0),
(406, '2107280113', 'TMSLOT-13', 'RTU-O01', '2021-07-28', 0, 0, 0),
(407, '2107280114', 'TMSLOT-14', 'RTU-O01', '2021-07-28', 0, 0, 0),
(408, '2107280115', 'TMSLOT-15', 'RTU-O01', '2021-07-28', 0, 0, 0),
(411, '2107300101', 'TMSLOT-01', 'RTU-O01', '2021-07-30', 0, 0, 0),
(412, '2107300102', 'TMSLOT-02', 'RTU-O01', '2021-07-30', 0, 0, 0),
(413, '2107300103', 'TMSLOT-03', 'RTU-O01', '2021-07-30', 0, 0, 0),
(414, '2107300104', 'TMSLOT-04', 'RTU-O01', '2021-07-30', 0, 0, 0),
(415, '2107300105', 'TMSLOT-05', 'RTU-O01', '2021-07-30', 0, 0, 0),
(416, '2107300106', 'TMSLOT-06', 'RTU-O01', '2021-07-30', 0, 0, 0),
(417, '2107300107', 'TMSLOT-07', 'RTU-O01', '2021-07-30', 0, 0, 0),
(418, '2107300108', 'TMSLOT-08', 'RTU-O01', '2021-07-30', 0, 0, 0),
(419, '2107300109', 'TMSLOT-09', 'RTU-O01', '2021-07-30', 0, 0, 0),
(420, '2107300110', 'TMSLOT-10', 'RTU-O01', '2021-07-30', 0, 0, 0),
(421, '2107300111', 'TMSLOT-11', 'RTU-O01', '2021-07-30', 0, 0, 0),
(422, '2107300112', 'TMSLOT-12', 'RTU-O01', '2021-07-30', 0, 0, 0),
(423, '2107300113', 'TMSLOT-13', 'RTU-O01', '2021-07-30', 0, 0, 0),
(424, '2107300114', 'TMSLOT-14', 'RTU-O01', '2021-07-30', 0, 0, 0),
(425, '2107300115', 'TMSLOT-15', 'RTU-O01', '2021-07-30', 0, 0, 0),
(426, '2108020101', 'TMSLOT-01', 'RTU-O01', '2021-08-02', 2, 1, 0),
(620, '2108030101', 'TMSLOT-01', 'RTU-O01', '2021-08-03', 0, 0, 0),
(621, '2108030102', 'TMSLOT-02', 'RTU-O01', '2021-08-03', 0, 0, 0),
(622, '2108030103', 'TMSLOT-03', 'RTU-O01', '2021-08-03', 0, 0, 0),
(623, '2108030104', 'TMSLOT-04', 'RTU-O01', '2021-08-03', 0, 0, 0),
(624, '2108030105', 'TMSLOT-05', 'RTU-O01', '2021-08-03', 0, 0, 0),
(625, '2108030106', 'TMSLOT-06', 'RTU-O01', '2021-08-03', 0, 0, 0),
(626, '2108030107', 'TMSLOT-07', 'RTU-O01', '2021-08-03', 0, 0, 0),
(627, '2108030108', 'TMSLOT-08', 'RTU-O01', '2021-08-03', 0, 0, 0),
(628, '2108030109', 'TMSLOT-09', 'RTU-O01', '2021-08-03', 0, 0, 0),
(629, '2108030110', 'TMSLOT-10', 'RTU-O01', '2021-08-03', 0, 0, 0),
(630, '2108030111', 'TMSLOT-11', 'RTU-O01', '2021-08-03', 0, 0, 0),
(631, '2108030112', 'TMSLOT-12', 'RTU-O01', '2021-08-03', 0, 0, 0),
(632, '2108030113', 'TMSLOT-13', 'RTU-O01', '2021-08-03', 0, 0, 0),
(633, '2108030114', 'TMSLOT-14', 'RTU-O01', '2021-08-03', 0, 0, 0),
(634, '2108030115', 'TMSLOT-15', 'RTU-O01', '2021-08-03', 0, 0, 0),
(762, '2108040101', 'TMSLOT-01', 'RTU-O01', '2021-08-04', 0, 0, 0),
(427, '2108040102', 'TMSLOT-02', 'RTU-O01', '2021-08-04', 1, 0, 0),
(763, '2108040103', 'TMSLOT-03', 'RTU-O01', '2021-08-04', 0, 0, 0),
(764, '2108040104', 'TMSLOT-04', 'RTU-O01', '2021-08-04', 0, 0, 0),
(765, '2108040105', 'TMSLOT-05', 'RTU-O01', '2021-08-04', 0, 0, 0),
(766, '2108040106', 'TMSLOT-06', 'RTU-O01', '2021-08-04', 0, 0, 0),
(767, '2108040107', 'TMSLOT-07', 'RTU-O01', '2021-08-04', 0, 0, 0),
(768, '2108040108', 'TMSLOT-08', 'RTU-O01', '2021-08-04', 0, 0, 0),
(769, '2108040109', 'TMSLOT-09', 'RTU-O01', '2021-08-04', 0, 0, 0),
(770, '2108040110', 'TMSLOT-10', 'RTU-O01', '2021-08-04', 0, 0, 0),
(771, '2108040111', 'TMSLOT-11', 'RTU-O01', '2021-08-04', 0, 0, 0),
(772, '2108040112', 'TMSLOT-12', 'RTU-O01', '2021-08-04', 0, 0, 0),
(773, '2108040113', 'TMSLOT-13', 'RTU-O01', '2021-08-04', 0, 0, 0),
(774, '2108040114', 'TMSLOT-14', 'RTU-O01', '2021-08-04', 0, 0, 0),
(775, '2108040115', 'TMSLOT-15', 'RTU-O01', '2021-08-04', 0, 0, 0),
(691, '2108040701', 'TMSLOT-01', 'RTU-O07', '2021-08-04', 0, 0, 1),
(692, '2108040702', 'TMSLOT-02', 'RTU-O07', '2021-08-04', 0, 0, 1),
(693, '2108040703', 'TMSLOT-03', 'RTU-O07', '2021-08-04', 0, 0, 1),
(694, '2108040704', 'TMSLOT-04', 'RTU-O07', '2021-08-04', 0, 0, 1),
(695, '2108040705', 'TMSLOT-05', 'RTU-O07', '2021-08-04', 0, 0, 1),
(696, '2108040706', 'TMSLOT-06', 'RTU-O07', '2021-08-04', 0, 0, 1),
(697, '2108040707', 'TMSLOT-07', 'RTU-O07', '2021-08-04', 0, 0, 1),
(698, '2108040708', 'TMSLOT-08', 'RTU-O07', '2021-08-04', 0, 0, 1),
(699, '2108040709', 'TMSLOT-09', 'RTU-O07', '2021-08-04', 0, 0, 1),
(700, '2108040710', 'TMSLOT-10', 'RTU-O07', '2021-08-04', 0, 0, 1),
(701, '2108040711', 'TMSLOT-11', 'RTU-O07', '2021-08-04', 0, 0, 1),
(702, '2108040712', 'TMSLOT-12', 'RTU-O07', '2021-08-04', 0, 0, 1),
(703, '2108040713', 'TMSLOT-13', 'RTU-O07', '2021-08-04', 0, 0, 1),
(704, '2108040714', 'TMSLOT-14', 'RTU-O07', '2021-08-04', 0, 0, 1),
(705, '2108040715', 'TMSLOT-15', 'RTU-O07', '2021-08-04', 0, 0, 1),
(745, '2108040901', 'TMSLOT-01', 'RTU-O09', '2021-08-04', 0, 0, 1),
(746, '2108040902', 'TMSLOT-02', 'RTU-O09', '2021-08-04', 0, 0, 1),
(747, '2108040903', 'TMSLOT-03', 'RTU-O09', '2021-08-04', 0, 0, 1),
(748, '2108040904', 'TMSLOT-04', 'RTU-O09', '2021-08-04', 0, 0, 1),
(749, '2108040905', 'TMSLOT-05', 'RTU-O09', '2021-08-04', 0, 0, 1),
(750, '2108040906', 'TMSLOT-06', 'RTU-O09', '2021-08-04', 0, 0, 1),
(751, '2108040907', 'TMSLOT-07', 'RTU-O09', '2021-08-04', 0, 0, 1),
(752, '2108040908', 'TMSLOT-08', 'RTU-O09', '2021-08-04', 0, 0, 1),
(753, '2108040909', 'TMSLOT-09', 'RTU-O09', '2021-08-04', 0, 0, 1),
(754, '2108040910', 'TMSLOT-10', 'RTU-O09', '2021-08-04', 0, 0, 1),
(755, '2108040911', 'TMSLOT-11', 'RTU-O09', '2021-08-04', 0, 0, 1),
(756, '2108040912', 'TMSLOT-12', 'RTU-O09', '2021-08-04', 0, 0, 1),
(757, '2108040913', 'TMSLOT-13', 'RTU-O09', '2021-08-04', 0, 0, 1),
(758, '2108040914', 'TMSLOT-14', 'RTU-O09', '2021-08-04', 0, 0, 1),
(759, '2108040915', 'TMSLOT-15', 'RTU-O09', '2021-08-04', 0, 0, 1),
(812, '2108050101', 'TMSLOT-01', 'RTU-O01', '2021-08-05', 0, 0, 0),
(813, '2108050102', 'TMSLOT-02', 'RTU-O01', '2021-08-05', 0, 0, 0),
(814, '2108050103', 'TMSLOT-03', 'RTU-O01', '2021-08-05', 0, 0, 0),
(815, '2108050104', 'TMSLOT-04', 'RTU-O01', '2021-08-05', 0, 0, 0),
(816, '2108050105', 'TMSLOT-05', 'RTU-O01', '2021-08-05', 0, 0, 0),
(817, '2108050106', 'TMSLOT-06', 'RTU-O01', '2021-08-05', 0, 0, 0),
(818, '2108050107', 'TMSLOT-07', 'RTU-O01', '2021-08-05', 0, 0, 0),
(819, '2108050108', 'TMSLOT-08', 'RTU-O01', '2021-08-05', 0, 0, 0),
(820, '2108050109', 'TMSLOT-09', 'RTU-O01', '2021-08-05', 0, 0, 0),
(821, '2108050110', 'TMSLOT-10', 'RTU-O01', '2021-08-05', 0, 0, 0),
(822, '2108050111', 'TMSLOT-11', 'RTU-O01', '2021-08-05', 0, 0, 0),
(823, '2108050112', 'TMSLOT-12', 'RTU-O01', '2021-08-05', 0, 0, 0),
(824, '2108050113', 'TMSLOT-13', 'RTU-O01', '2021-08-05', 0, 0, 0),
(825, '2108050114', 'TMSLOT-14', 'RTU-O01', '2021-08-05', 0, 0, 0),
(826, '2108050115', 'TMSLOT-15', 'RTU-O01', '2021-08-05', 0, 0, 0),
(796, '2108050501', 'TMSLOT-01', 'RTU-O05', '2021-08-05', 0, 0, 0),
(797, '2108050502', 'TMSLOT-02', 'RTU-O05', '2021-08-05', 0, 0, 0),
(798, '2108050503', 'TMSLOT-03', 'RTU-O05', '2021-08-05', 0, 0, 0),
(799, '2108050504', 'TMSLOT-04', 'RTU-O05', '2021-08-05', 0, 0, 0),
(800, '2108050505', 'TMSLOT-05', 'RTU-O05', '2021-08-05', 0, 0, 0),
(801, '2108050506', 'TMSLOT-06', 'RTU-O05', '2021-08-05', 0, 0, 0),
(802, '2108050507', 'TMSLOT-07', 'RTU-O05', '2021-08-05', 0, 0, 0),
(803, '2108050508', 'TMSLOT-08', 'RTU-O05', '2021-08-05', 0, 0, 0),
(804, '2108050509', 'TMSLOT-09', 'RTU-O05', '2021-08-05', 0, 0, 0),
(805, '2108050510', 'TMSLOT-10', 'RTU-O05', '2021-08-05', 0, 0, 0),
(806, '2108050511', 'TMSLOT-11', 'RTU-O05', '2021-08-05', 0, 0, 0),
(807, '2108050512', 'TMSLOT-12', 'RTU-O05', '2021-08-05', 0, 0, 0),
(808, '2108050513', 'TMSLOT-13', 'RTU-O05', '2021-08-05', 0, 0, 0),
(809, '2108050514', 'TMSLOT-14', 'RTU-O05', '2021-08-05', 0, 0, 0),
(810, '2108050515', 'TMSLOT-15', 'RTU-O05', '2021-08-05', 0, 0, 0),
(743, '2108050701', 'TMSLOT-01', 'RTU-O07', '2021-08-05', 0, 0, 1),
(744, '2108050702', 'TMSLOT-02', 'RTU-O07', '2021-08-05', 0, 0, 1),
(706, '2108050703', 'TMSLOT-03', 'RTU-O07', '2021-08-05', 0, 0, 1),
(707, '2108050704', 'TMSLOT-04', 'RTU-O07', '2021-08-05', 0, 0, 1),
(708, '2108050705', 'TMSLOT-05', 'RTU-O07', '2021-08-05', 0, 0, 1),
(709, '2108050706', 'TMSLOT-06', 'RTU-O07', '2021-08-05', 0, 0, 1),
(710, '2108050707', 'TMSLOT-07', 'RTU-O07', '2021-08-05', 0, 0, 1),
(711, '2108050708', 'TMSLOT-08', 'RTU-O07', '2021-08-05', 0, 0, 1),
(712, '2108050709', 'TMSLOT-09', 'RTU-O07', '2021-08-05', 0, 0, 1),
(713, '2108050710', 'TMSLOT-10', 'RTU-O07', '2021-08-05', 0, 0, 1),
(714, '2108050711', 'TMSLOT-11', 'RTU-O07', '2021-08-05', 0, 0, 1),
(715, '2108050712', 'TMSLOT-12', 'RTU-O07', '2021-08-05', 0, 0, 1),
(716, '2108050713', 'TMSLOT-13', 'RTU-O07', '2021-08-05', 0, 0, 1),
(717, '2108050714', 'TMSLOT-14', 'RTU-O07', '2021-08-05', 0, 0, 1),
(718, '2108050715', 'TMSLOT-15', 'RTU-O07', '2021-08-05', 0, 0, 1),
(780, '2108050901', 'TMSLOT-01', 'RTU-O09', '2021-08-05', 1, 0, 0),
(778, '2108050902', 'TMSLOT-02', 'RTU-O09', '2021-08-05', 1, 0, 0),
(781, '2108050903', 'TMSLOT-03', 'RTU-O09', '2021-08-05', 0, 0, 0),
(782, '2108050904', 'TMSLOT-04', 'RTU-O09', '2021-08-05', 0, 0, 0),
(783, '2108050905', 'TMSLOT-05', 'RTU-O09', '2021-08-05', 0, 0, 0),
(784, '2108050906', 'TMSLOT-06', 'RTU-O09', '2021-08-05', 0, 0, 0),
(785, '2108050907', 'TMSLOT-07', 'RTU-O09', '2021-08-05', 0, 0, 0),
(786, '2108050908', 'TMSLOT-08', 'RTU-O09', '2021-08-05', 0, 0, 0),
(787, '2108050909', 'TMSLOT-09', 'RTU-O09', '2021-08-05', 0, 0, 0),
(788, '2108050910', 'TMSLOT-10', 'RTU-O09', '2021-08-05', 0, 0, 0),
(789, '2108050911', 'TMSLOT-11', 'RTU-O09', '2021-08-05', 0, 0, 0),
(790, '2108050912', 'TMSLOT-12', 'RTU-O09', '2021-08-05', 0, 0, 0),
(791, '2108050913', 'TMSLOT-13', 'RTU-O09', '2021-08-05', 0, 0, 0),
(792, '2108050914', 'TMSLOT-14', 'RTU-O09', '2021-08-05', 0, 0, 0),
(793, '2108050915', 'TMSLOT-15', 'RTU-O09', '2021-08-05', 0, 0, 0),
(829, '2108060101', 'TMSLOT-01', 'RTU-O01', '2021-08-06', 2, 1, 0),
(827, '2108060104', 'TMSLOT-04', 'RTU-O01', '2021-08-06', 3, 1, 0),
(828, '2108060501', 'TMSLOT-01', 'RTU-O05', '2021-08-06', 2, 1, 0),
(811, '2108060504', 'TMSLOT-04', 'RTU-O05', '2021-08-06', 2, 1, 0),
(779, '2108060701', 'TMSLOT-01', 'RTU-O07', '2021-08-06', 1, 1, 0),
(794, '2108060901', 'TMSLOT-01', 'RTU-O09', '2021-08-06', 1, 0, 1),
(833, '2108060902', 'TMSLOT-02', 'RTU-O09', '2021-08-06', 3, 1, 0),
(830, '2108090101', 'TMSLOT-01', 'RTU-O01', '2021-08-09', 2, 1, 0),
(835, '2108090105', 'TMSLOT-05', 'RTU-O01', '2021-08-09', 1, 1, 0),
(727, '2108090701', 'TMSLOT-01', 'RTU-O07', '2021-08-09', 0, 0, 1),
(728, '2108090702', 'TMSLOT-02', 'RTU-O07', '2021-08-09', 0, 0, 1),
(729, '2108090703', 'TMSLOT-03', 'RTU-O07', '2021-08-09', 0, 0, 1),
(730, '2108090704', 'TMSLOT-04', 'RTU-O07', '2021-08-09', 0, 0, 1),
(741, '2108090705', 'TMSLOT-05', 'RTU-O07', '2021-08-09', 0, 0, 1),
(742, '2108090706', 'TMSLOT-06', 'RTU-O07', '2021-08-09', 0, 0, 1),
(738, '2108090707', 'TMSLOT-07', 'RTU-O07', '2021-08-09', 0, 0, 1),
(739, '2108090708', 'TMSLOT-08', 'RTU-O07', '2021-08-09', 0, 0, 1),
(740, '2108090709', 'TMSLOT-09', 'RTU-O07', '2021-08-09', 0, 0, 1),
(831, '2108100101', 'TMSLOT-01', 'RTU-O01', '2021-08-10', 1, 1, 0),
(795, '2108100902', 'TMSLOT-02', 'RTU-O09', '2021-08-10', 1, 1, 0),
(374, '2108110101', 'TMSLOT-01', 'RTU-O01', '2021-08-11', 5, 0, 0),
(375, '2108110102', 'TMSLOT-02', 'RTU-O01', '2021-08-11', 5, 0, 0),
(377, '2108110103', 'TMSLOT-03', 'RTU-O01', '2021-08-11', 5, 0, 0),
(393, '2108110104', 'TMSLOT-04', 'RTU-O01', '2021-08-11', 5, 0, 0),
(410, '2108110105', 'TMSLOT-05', 'RTU-O01', '2021-08-11', 4, 1, 0),
(834, '2108110106', 'TMSLOT-06', 'RTU-O01', '2021-08-11', 1, 1, 0),
(409, '2108110108', 'TMSLOT-08', 'RTU-O01', '2021-08-11', 1, 1, 0),
(225, '2108110109', 'TMSLOT-09', 'RTU-O01', '2021-08-11', 5, 0, 0),
(225, '2108110110', 'TMSLOT-010', 'RTU-O01', '2021-08-11', 5, 0, 0),
(225, '2108110111', 'TMSLOT-011', 'RTU-O01', '2021-08-11', 5, 0, 0),
(225, '2108110112', 'TMSLOT-012', 'RTU-O01', '2021-08-11', 5, 0, 0),
(227, '2108110113', 'TMSLOT-013', 'RTU-O01', '2021-08-11', 5, 0, 0),
(227, '2108110114', 'TMSLOT-014', 'RTU-O01', '2021-08-11', 5, 0, 0),
(227, '2108110115', 'TMSLOT-015', 'RTU-O01', '2021-08-11', 5, 0, 0),
(760, '2108120701', 'TMSLOT-01', 'RTU-O07', '2021-08-12', 0, 0, 1),
(761, '2108120702', 'TMSLOT-02', 'RTU-O07', '2021-08-12', 0, 0, 1),
(776, '2108130901', 'TMSLOT-01', 'RTU-O09', '2021-08-13', 1, 1, 0),
(836, '2108160101', 'TMSLOT-01', 'RTU-O01', '2021-08-16', 1, 1, 0),
(832, '2108170504', 'TMSLOT-04', 'RTU-O05', '2021-08-17', 1, 1, 0),
(228, '2108190114', 'TMSLOT-14', 'RTU-O01', '2021-08-19', 1, 1, 0),
(13, '2108190304', 'TMSLOT-04', 'RTU-O03', '2021-08-19', 1, 1, 0),
(689, '2108230711', 'TMSLOT-11', 'RTU-O07', '2021-08-23', 0, 0, 1),
(690, '2108230712', 'TMSLOT-12', 'RTU-O07', '2021-08-23', 0, 0, 1),
(777, '2108250908', 'TMSLOT-08', 'RTU-O09', '2021-08-25', 1, 1, 0),
(719, '2108260701', 'TMSLOT-01', 'RTU-O07', '2021-08-26', 0, 0, 1),
(720, '2108260702', 'TMSLOT-02', 'RTU-O07', '2021-08-26', 0, 0, 1),
(721, '2108260703', 'TMSLOT-03', 'RTU-O07', '2021-08-26', 0, 0, 1),
(722, '2108260704', 'TMSLOT-04', 'RTU-O07', '2021-08-26', 0, 0, 1),
(723, '2108310701', 'TMSLOT-01', 'RTU-O07', '2021-08-31', 0, 0, 1),
(724, '2108310702', 'TMSLOT-02', 'RTU-O07', '2021-08-31', 0, 0, 1),
(725, '2108310703', 'TMSLOT-03', 'RTU-O07', '2021-08-31', 0, 0, 1),
(726, '2108310704', 'TMSLOT-04', 'RTU-O07', '2021-08-31', 0, 0, 1),
(731, '2109060701', 'TMSLOT-01', 'RTU-O07', '2021-09-06', 0, 0, 1),
(732, '2109060702', 'TMSLOT-02', 'RTU-O07', '2021-09-06', 0, 0, 1),
(733, '2109060703', 'TMSLOT-03', 'RTU-O07', '2021-09-06', 0, 0, 1),
(734, '2109060704', 'TMSLOT-04', 'RTU-O07', '2021-09-06', 0, 0, 1),
(735, '2109140701', 'TMSLOT-01', 'RTU-O07', '2021-09-14', 0, 0, 1),
(736, '2109140702', 'TMSLOT-02', 'RTU-O07', '2021-09-14', 0, 0, 1),
(737, '2109140703', 'TMSLOT-03', 'RTU-O07', '2021-09-14', 0, 0, 1);

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
  PRIMARY KEY (`vstor_num`) USING BTREE,
  UNIQUE KEY `vstor_id` (`vstor_id`),
  UNIQUE KEY `vstor_email` (`vstor_email`)
) ENGINE=MyISAM AUTO_INCREMENT=313 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
