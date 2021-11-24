-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 09, 2021 at 01:16 PM
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
-- Database: `dbbrgy108z12`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin_attmp`
--

DROP TABLE IF EXISTS `tbladmin_attmp`;
CREATE TABLE IF NOT EXISTS `tbladmin_attmp` (
  `attmpNum` int NOT NULL AUTO_INCREMENT,
  `admnUname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attmpStmp` int NOT NULL,
  `attmpIpAdd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`attmpNum`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin_auth`
--

DROP TABLE IF EXISTS `tbladmin_auth`;
CREATE TABLE IF NOT EXISTS `tbladmin_auth` (
  `admnUname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admnEmail` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admnPword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admnGString` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admnPwordChng` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbladmin_auth`
--

INSERT INTO `tbladmin_auth` (`admnUname`, `admnEmail`, `admnPword`, `admnGString`, `admnPwordChng`) VALUES
('kgwd2014', 'kgwd2014@gmail.com', '3325d52a3c7e3fc7aeacfb1116a6868be430288682f31ca7f6284e70f3537a48', 'TbUIsMGmZHNtOril3nKE', 'undefined'),
('kptan2014', 'kptan2014@yahoo.com', 'cc2732aa70a4cd2eeb494884b7a8e1ac3b0eb5bd68158c06e222ef4747ff075f', '2Q0rMbeDPPpcgX0XqZyb', 'undefined'),
('brgysec2017', 'brgysec2017@hotmail.com', '1de235f246d3d89a1a1eed0241a05593dc165954242ce5ae559060d0db9d6d2f', 'A5KYRJMEqRCcvIFUPofb', 'undefined');

-- --------------------------------------------------------

--
-- Table structure for table `tblannouncements`
--

DROP TABLE IF EXISTS `tblannouncements`;
CREATE TABLE IF NOT EXISTS `tblannouncements` (
  `anncmntId` int NOT NULL,
  `anncmntMsg` varchar(6400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anncmntHasPic` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anncmntHasFile` varchar(264) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anncmntFname` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`anncmntId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblblotterreport`
--

DROP TABLE IF EXISTS `tblblotterreport`;
CREATE TABLE IF NOT EXISTS `tblblotterreport` (
  `blotterId` int NOT NULL,
  `blotterStatus` int NOT NULL DEFAULT '1',
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctzn` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCrime` date NOT NULL,
  `incident` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `susFname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `susLname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `susAlias` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `susSuffix` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `susAge` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `susSex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `susHnum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `susStreet` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userIp` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sysTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcovidinfo`
--

DROP TABLE IF EXISTS `tblcovidinfo`;
CREATE TABLE IF NOT EXISTS `tblcovidinfo` (
  `infoId` int NOT NULL,
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `covType` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `covStatus` int DEFAULT '1',
  `contact` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctznshp` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNum` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateAd` date DEFAULT NULL,
  `dateDis` date DEFAULT NULL,
  `dateStart` date DEFAULT NULL,
  `dateEnd` date DEFAULT NULL,
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`infoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbldonation`
--

DROP TABLE IF EXISTS `tbldonation`;
CREATE TABLE IF NOT EXISTS `tbldonation` (
  `donationId` int NOT NULL,
  `position` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mInitial` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNumber` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pCode` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donType` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donDate` date DEFAULT NULL,
  `goodType` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `transDate` date DEFAULT NULL,
  `payType` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payAmmnt` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hasFile` tinyint(1) NOT NULL,
  `userIp` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`donationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblhealthupdates`
--

DROP TABLE IF EXISTS `tblhealthupdates`;
CREATE TABLE IF NOT EXISTS `tblhealthupdates` (
  `updateId` int NOT NULL,
  `updateMsg` varchar(6400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updateHasPic` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updateHasFile` varchar(264) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updateFname` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`updateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblresident`
--

DROP TABLE IF EXISTS `tblresident`;
CREATE TABLE IF NOT EXISTS `tblresident` (
  `resUname` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resFname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resMname` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resLname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resSuffix` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resCivStat` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resCitiznshp` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resBdate` date NOT NULL,
  `resSex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resHouseNum` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resStName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resContact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resEmail` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resFbName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resVoter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`resUname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblresident_attmp`
--

DROP TABLE IF EXISTS `tblresident_attmp`;
CREATE TABLE IF NOT EXISTS `tblresident_attmp` (
  `attmpNum` int NOT NULL AUTO_INCREMENT,
  `resUname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attmpStmp` int NOT NULL,
  `attmpIpAdd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`attmpNum`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblresident_auth`
--

DROP TABLE IF EXISTS `tblresident_auth`;
CREATE TABLE IF NOT EXISTS `tblresident_auth` (
  `resUname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resEmail` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resContact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resPword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resGString` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resPwordChng` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT 'undefined',
  `resValid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`resUname`) USING BTREE,
  UNIQUE KEY `resEmail` (`resEmail`),
  UNIQUE KEY `resContact` (`resContact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
