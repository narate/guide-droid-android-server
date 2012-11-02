-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2012 at 11:41 AM
-- Server version: 5.0.51a-3ubuntu5.8
-- PHP Version: 5.2.4-2ubuntu5.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `navigator`
--

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `LOCATION_ID` int(10) NOT NULL auto_increment,
  `LOCATION_CATE_ID` int(3) NOT NULL,
  `LOCATION_NAME` varchar(32) collate utf8_unicode_ci NOT NULL,
  `LATITUDE` text collate utf8_unicode_ci NOT NULL,
  `LONGITUDE` text collate utf8_unicode_ci NOT NULL,
  `DESCRIPTION` varchar(140) collate utf8_unicode_ci NOT NULL,
  `OWNER_NAME` text collate utf8_unicode_ci NOT NULL,
  `DATE_CREATE` date NOT NULL,
  PRIMARY KEY  (`LOCATION_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=79 ;

-- --------------------------------------------------------

--
-- Table structure for table `location_cate`
--

CREATE TABLE IF NOT EXISTS `location_cate` (
  `LOCATION_CATE_ID` int(3) NOT NULL auto_increment,
  `LOCATION_CATE_NAME` varchar(40) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`LOCATION_CATE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE IF NOT EXISTS `owner` (
  `OWNER_ID` int(3) NOT NULL,
  `OWNER_NAME` varchar(40) collate utf8_unicode_ci NOT NULL,
  `OWNER_PWD` text collate utf8_unicode_ci NOT NULL,
  `OWNER_LEVEL` varchar(1) collate utf8_unicode_ci NOT NULL default '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `PHOTO_ID` int(8) NOT NULL auto_increment,
  `LOCATION_ID` int(10) NOT NULL,
  `LOCATION_CATE_ID` int(3) NOT NULL,
  `PHOTO_NAME` text collate utf8_unicode_ci NOT NULL,
  `OWNER_NAME` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`PHOTO_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=211 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `USER_ID` varchar(32) collate utf8_unicode_ci default NULL,
  `USER_NAME` varchar(32) collate utf8_unicode_ci default NULL,
  `USER_USERNAME` varchar(32) collate utf8_unicode_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
