-- phpMyAdmin SQL Dump
-- version 4.6.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 18, 2017 at 06:27 PM
-- Server version: 5.5.53-0+deb8u1
-- PHP Version: 5.6.27-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bappenas_sso`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` mediumint(7) UNSIGNED NOT NULL,
  `sso_id` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `pass` char(64) NOT NULL DEFAULT '',
  `fullname` char(32) NOT NULL DEFAULT '',
  `gender` enum('laki-laki','perempuan','') NOT NULL,
  `birthday` date NOT NULL,
  `nik` char(32) NOT NULL DEFAULT '',
  `email` char(64) NOT NULL DEFAULT '',
  `email2` char(48) NOT NULL DEFAULT '',
  `phone` char(16) NOT NULL DEFAULT '',
  `counter` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `status` enum('pending','active','suspended') NOT NULL DEFAULT 'pending',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modify` datetime NOT NULL,
  `modifier` int(11) NOT NULL COMMENT 'account_id',
  `date_inserted` date NOT NULL DEFAULT '0000-00-00',
  `facebook` char(32) NOT NULL,
  `simultaneous` enum('0','1') NOT NULL DEFAULT '1',
  `failed` int(1) NOT NULL DEFAULT '0',
  `attempted_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `imposed_pass` enum('0','1') NOT NULL DEFAULT '0',
  `twostep` enum('inactive','disabled','once','always') NOT NULL DEFAULT 'inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bio`
--

CREATE TABLE `bio` (
  `bio_id` int(9) NOT NULL,
  `account_id` mediumint(7) UNSIGNED NOT NULL,
  `idno` char(32) NOT NULL,
  `source` enum('facebook','dpt','ektp','linkedin','npwp') NOT NULL,
  `link` char(128) NOT NULL,
  `name` char(128) NOT NULL,
  `gender` enum('laki-laki','perempuan') NOT NULL,
  `birthday` date NOT NULL,
  `religion` enum('islam','kristen','hindu','budha','konghucu') NOT NULL,
  `timezone` tinyint(2) NOT NULL,
  `relationship` char(32) NOT NULL,
  `bloodtype` enum('O','A','B','AB') NOT NULL,
  `photourl` char(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `case`
--

CREATE TABLE `case` (
  `case_id` int(9) UNSIGNED NOT NULL,
  `privilege_id` int(9) UNSIGNED NOT NULL,
  `member_id` int(9) UNSIGNED NOT NULL,
  `account_id` mediumint(7) UNSIGNED NOT NULL,
  `apikey_id` mediumint(7) UNSIGNED NOT NULL,
  `case` char(16) NOT NULL,
  `admin` mediumint(7) UNSIGNED NOT NULL COMMENT 'account_id',
  `date_inserted` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(9) UNSIGNED NOT NULL,
  `account_id` mediumint(7) UNSIGNED NOT NULL,
  `apikey_id` smallint(7) UNSIGNED NOT NULL,
  `counter` mediumint(7) UNSIGNED NOT NULL,
  `webmaster` enum('0','1') NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `last_modified` datetime NOT NULL,
  `modifier` mediumint(7) UNSIGNED NOT NULL COMMENT 'account_id',
  `date_inserted` datetime NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pass_history`
--

CREATE TABLE `pass_history` (
  `pass_history_id` bigint(11) UNSIGNED NOT NULL,
  `account_id` int(9) UNSIGNED NOT NULL,
  `newpass` char(64) NOT NULL,
  `oldpass` char(64) NOT NULL,
  `date_inserted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pass_request`
--

CREATE TABLE `pass_request` (
  `pass_request_id` mediumint(7) UNSIGNED NOT NULL,
  `account_id` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `email` char(32) NOT NULL DEFAULT '',
  `status` enum('request','confirmed') NOT NULL DEFAULT 'request',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `privilege_id` int(9) UNSIGNED NOT NULL,
  `member_id` int(9) UNSIGNED NOT NULL,
  `account_id` mediumint(7) UNSIGNED NOT NULL,
  `apikey_id` mediumint(7) UNSIGNED NOT NULL,
  `controller` char(128) NOT NULL,
  `admin` mediumint(7) UNSIGNED NOT NULL COMMENT 'account_id',
  `date_inserted` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_id` int(9) UNSIGNED NOT NULL,
  `session` char(32) NOT NULL,
  `account_id` mediumint(7) UNSIGNED NOT NULL,
  `apikey_id` mediumint(7) UNSIGNED NOT NULL,
  `client` char(32) NOT NULL,
  `fullname` char(64) NOT NULL,
  `email` char(64) NOT NULL,
  `facebook` char(32) NOT NULL,
  `date_inserted` datetime NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `counter` smallint(5) UNSIGNED NOT NULL,
  `photourl` char(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `sso_id` (`sso_id`);

--
-- Indexes for table `bio`
--
ALTER TABLE `bio`
  ADD PRIMARY KEY (`bio_id`);

--
-- Indexes for table `case`
--
ALTER TABLE `case`
  ADD PRIMARY KEY (`case_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `pass_history`
--
ALTER TABLE `pass_history`
  ADD PRIMARY KEY (`pass_history_id`);

--
-- Indexes for table `pass_request`
--
ALTER TABLE `pass_request`
  ADD PRIMARY KEY (`pass_request_id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`privilege_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `session` (`session`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` mediumint(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
--
-- AUTO_INCREMENT for table `bio`
--
ALTER TABLE `bio`
  MODIFY `bio_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pass_history`
--
ALTER TABLE `pass_history`
  MODIFY `pass_history_id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pass_request`
--
ALTER TABLE `pass_request`
  MODIFY `pass_request_id` mediumint(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `privilege_id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `session_id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2109;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
