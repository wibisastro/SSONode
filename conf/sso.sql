-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2017 at 04:00 AM
-- Server version: 5.5.54-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bappeda_sso`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
`account_id` mediumint(7) unsigned NOT NULL,
  `sso_id` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `pass` char(64) NOT NULL DEFAULT '',
  `fullname` char(32) NOT NULL DEFAULT '',
  `gender` enum('laki-laki','perempuan','') NOT NULL,
  `birthday` date NOT NULL,
  `nik` char(32) NOT NULL DEFAULT '',
  `email` char(64) NOT NULL DEFAULT '',
  `email2` char(48) NOT NULL DEFAULT '',
  `phone` char(16) NOT NULL DEFAULT '',
  `counter` mediumint(7) unsigned NOT NULL DEFAULT '0',
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
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apicall`
--

CREATE TABLE IF NOT EXISTS `apicall` (
`apicall_id` mediumint(7) unsigned NOT NULL,
  `status` enum('open','closed','invalid','inactive','ilegal','error') NOT NULL DEFAULT 'open',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `server` char(32) NOT NULL DEFAULT '',
  `client` char(32) NOT NULL DEFAULT '',
  `req` char(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bio`
--

CREATE TABLE IF NOT EXISTS `bio` (
`bio_id` int(9) NOT NULL,
  `account_id` mediumint(7) unsigned NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `case`
--

CREATE TABLE IF NOT EXISTS `case` (
  `case_id` int(9) unsigned NOT NULL,
  `privilege_id` int(9) unsigned NOT NULL,
  `member_id` int(9) unsigned NOT NULL,
  `account_id` mediumint(7) unsigned NOT NULL,
  `apikey_id` mediumint(7) unsigned NOT NULL,
  `case` char(16) NOT NULL,
  `admin` mediumint(7) unsigned NOT NULL COMMENT 'account_id',
  `date_inserted` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
`member_id` int(9) unsigned NOT NULL,
  `account_id` mediumint(7) unsigned NOT NULL,
  `apikey_id` smallint(7) unsigned NOT NULL,
  `counter` mediumint(7) unsigned NOT NULL,
  `webmaster` enum('0','1') NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `last_modified` datetime NOT NULL,
  `modifier` mediumint(7) unsigned NOT NULL COMMENT 'account_id',
  `date_inserted` datetime NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `passsync`
--

CREATE TABLE IF NOT EXISTS `passsync` (
`passsync_id` int(9) unsigned NOT NULL,
  `account_id` mediumint(7) unsigned NOT NULL,
  `apikey` char(32) NOT NULL,
  `domain` char(32) NOT NULL,
  `app` char(16) NOT NULL,
  `counter` smallint(5) NOT NULL,
  `status` enum('enabled','disabled') NOT NULL,
  `inserted_date` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pass_history`
--

CREATE TABLE IF NOT EXISTS `pass_history` (
`pass_history_id` bigint(11) unsigned NOT NULL,
  `account_id` int(9) unsigned NOT NULL,
  `newpass` char(64) NOT NULL,
  `oldpass` char(64) NOT NULL,
  `date_inserted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pass_request`
--

CREATE TABLE IF NOT EXISTS `pass_request` (
`pass_request_id` mediumint(7) unsigned NOT NULL,
  `account_id` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `email` char(32) NOT NULL DEFAULT '',
  `status` enum('request','confirmed') NOT NULL DEFAULT 'request',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE IF NOT EXISTS `privilege` (
`privilege_id` int(9) unsigned NOT NULL,
  `member_id` int(9) unsigned NOT NULL,
  `account_id` mediumint(7) unsigned NOT NULL,
  `apikey_id` mediumint(7) unsigned NOT NULL,
  `controller` char(128) NOT NULL,
  `admin` mediumint(7) unsigned NOT NULL COMMENT 'account_id',
  `date_inserted` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
`session_id` int(9) unsigned NOT NULL,
  `session` char(32) NOT NULL,
  `account_id` mediumint(7) unsigned NOT NULL,
  `apikey_id` mediumint(7) unsigned NOT NULL,
  `client` char(32) NOT NULL,
  `fullname` char(64) NOT NULL,
  `email` char(64) NOT NULL,
  `facebook` char(32) NOT NULL,
  `date_inserted` datetime NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `counter` smallint(5) unsigned NOT NULL,
  `photourl` char(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2296 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
 ADD PRIMARY KEY (`account_id`), ADD UNIQUE KEY `email` (`email`), ADD KEY `sso_id` (`sso_id`);

--
-- Indexes for table `apicall`
--
ALTER TABLE `apicall`
 ADD PRIMARY KEY (`apicall_id`);

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
-- Indexes for table `passsync`
--
ALTER TABLE `passsync`
 ADD PRIMARY KEY (`passsync_id`);

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
 ADD PRIMARY KEY (`session_id`), ADD KEY `session` (`session`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
MODIFY `account_id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `apicall`
--
ALTER TABLE `apicall`
MODIFY `apicall_id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `bio`
--
ALTER TABLE `bio`
MODIFY `bio_id` int(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
MODIFY `member_id` int(9) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `passsync`
--
ALTER TABLE `passsync`
MODIFY `passsync_id` int(9) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `pass_history`
--
ALTER TABLE `pass_history`
MODIFY `pass_history_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pass_request`
--
ALTER TABLE `pass_request`
MODIFY `pass_request_id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
MODIFY `privilege_id` int(9) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
MODIFY `session_id` int(9) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2296;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
