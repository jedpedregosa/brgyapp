-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 24, 2021 at 12:37 PM
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

DROP TABLE IF EXISTS `tblAdmin_attmp`;
CREATE TABLE IF NOT EXISTS `tblAdmin_attmp` (
  `attmpNum` int NOT NULL AUTO_INCREMENT,
  `admnUname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attmpStmp` int NOT NULL,
  `attmpIpAdd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`attmpNum`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin_auth`
--

DROP TABLE IF EXISTS `tblAdmin_auth`;
CREATE TABLE IF NOT EXISTS `tblAdmin_auth` (
  `admnUname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admnEmail` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admnPword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admnGString` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admnPwordChng` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`admnUname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbladmin_auth`
--

INSERT INTO `tblAdmin_auth` (`admnUname`, `admnEmail`, `admnPword`, `admnGString`, `admnPwordChng`) VALUES
('brgysec2017', 'brgysec2017@hotmail.com', 'cc2732aa70a4cd2eeb494884b7a8e1ac3b0eb5bd68158c06e222ef4747ff075f', '2Q0rMbeDPPpcgX0XqZyb', 'undefined'),
('kgwd2014', 'kgwd2014@gmail.com', '8017ca126af2152ef1e2de5f6f91ebc12763983a543d56d235b6619b4f925b5b', 'ITV04i!2f*$l81ZYV6*8', '1636952493'),
('kptan2014', 'kptan2014@yahoo.com', 'cc2732aa70a4cd2eeb494884b7a8e1ac3b0eb5bd68158c06e222ef4747ff075f', '2Q0rMbeDPPpcgX0XqZyb', 'undefined');

-- --------------------------------------------------------

--
-- Table structure for table `tblannouncements`
--

DROP TABLE IF EXISTS `tblAnnouncements`;
CREATE TABLE IF NOT EXISTS `tblAnnouncements` (
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

DROP TABLE IF EXISTS `tblBlotterReport`;
CREATE TABLE IF NOT EXISTS `tblBlotterReport` (
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
-- Table structure for table `tblburialrequest`
--

DROP TABLE IF EXISTS `tblBurialRequest`;
CREATE TABLE IF NOT EXISTS `tblBurialRequest` (
  `id` int NOT NULL,
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sffx` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civStat` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctznshp` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bDate` date NOT NULL,
  `sex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fbName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voter` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dFname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dMname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dLname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dSffx` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dAge` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dSex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dBdate` date NOT NULL,
  `dDdate` date NOT NULL,
  `dBurDate` date NOT NULL,
  `dRemark` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rStatus` int NOT NULL DEFAULT '0',
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblclearance`
--

DROP TABLE IF EXISTS `tblClearance`;
CREATE TABLE IF NOT EXISTS `tblClearance` (
  `id` int NOT NULL,
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sffx` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civStat` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctznshp` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bDate` date NOT NULL,
  `sex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNum` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fbName` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voter` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cStatus` int NOT NULL DEFAULT '0',
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcovidinfo`
--

DROP TABLE IF EXISTS `tblCovidInfo`;
CREATE TABLE IF NOT EXISTS `tblCovidInfo` (
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
  `symptoms` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hospital` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastPlace` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastContact` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`infoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbldonation`
--

DROP TABLE IF EXISTS `tblDonation`;
CREATE TABLE IF NOT EXISTS `tblDonation` (
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
-- Table structure for table `tblempform`
--

DROP TABLE IF EXISTS `tblEmpForm`;
CREATE TABLE IF NOT EXISTS `tblEmpForm` (
  `id` int NOT NULL,
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sffx` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civStat` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctznshp` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bDate` date NOT NULL,
  `sex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fbName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voter` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rStatus` int NOT NULL DEFAULT '0',
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblhealthupdates`
--

DROP TABLE IF EXISTS `tblHealthUpdates`;
CREATE TABLE IF NOT EXISTS `tblHealthUpdates` (
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
-- Table structure for table `tblidrequest`
--

DROP TABLE IF EXISTS `tblIdRequest`;
CREATE TABLE IF NOT EXISTS `tblIdRequest` (
  `id` int NOT NULL,
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sffx` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civStat` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctznshp` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bDate` date NOT NULL,
  `sex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fbName` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voter` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bPlace` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idNum` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voterId` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nContact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nAddress` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rStatus` int NOT NULL DEFAULT '0',
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblindigency`
--

DROP TABLE IF EXISTS `tblIndigency`;
CREATE TABLE IF NOT EXISTS `tblIndigency` (
  `id` int NOT NULL,
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sffx` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civStat` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctznshp` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bDate` date NOT NULL,
  `sex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fbName` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voter` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rStatus` int NOT NULL DEFAULT '0',
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblofficial`
--

DROP TABLE IF EXISTS `tblOfficial`;
CREATE TABLE IF NOT EXISTS `tblOfficial` (
  `id` int NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblresident`
--

DROP TABLE IF EXISTS `tblResident`;
CREATE TABLE IF NOT EXISTS `tblResident` (
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

DROP TABLE IF EXISTS `tblResident_attmp`;
CREATE TABLE IF NOT EXISTS `tblResident_attmp` (
  `attmpNum` int NOT NULL AUTO_INCREMENT,
  `resUname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attmpStmp` int NOT NULL,
  `attmpIpAdd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`attmpNum`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblresident_auth`
--

DROP TABLE IF EXISTS `tblResident_auth`;
CREATE TABLE IF NOT EXISTS `tblResident_auth` (
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

-- --------------------------------------------------------

--
-- Table structure for table `tblresproof`
--

DROP TABLE IF EXISTS `tblResProof`;
CREATE TABLE IF NOT EXISTS `tblResProof` (
  `id` int NOT NULL,
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sffx` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civStat` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctznshp` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bDate` date NOT NULL,
  `sex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fbName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voter` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rStatus` int NOT NULL DEFAULT '0',
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblresproof`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbltravelrequest`
--

DROP TABLE IF EXISTS `tblTravelRequest`;
CREATE TABLE IF NOT EXISTS `tblTravelRequest` (
  `id` int NOT NULL,
  `fName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sffx` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civStat` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctznshp` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bDate` date NOT NULL,
  `sex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hNum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fbName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voter` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dFname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dMname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dLname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dSffx` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dSex` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passenger` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dHadd` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dBrgy` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dZone` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dCity` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dPlate` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dType` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rStatus` int NOT NULL DEFAULT '0',
  `sysTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
