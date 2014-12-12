-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2014 at 05:11 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_members`
--

CREATE TABLE IF NOT EXISTS `db_members` (
`member_id` int(11) unsigned NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='database for members';

-- --------------------------------------------------------

--
-- Table structure for table `db_posts`
--

CREATE TABLE IF NOT EXISTS `db_posts` (
`post_id` int(11) unsigned NOT NULL,
  `post_title` varchar(255) DEFAULT NULL,
  `post_desc` text,
  `post_cont` text,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='database for posts';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_members`
--
ALTER TABLE `db_members`
 ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `db_posts`
--
ALTER TABLE `db_posts`
 ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `db_members`
--
ALTER TABLE `db_members`
MODIFY `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `db_posts`
--
ALTER TABLE `db_posts`
MODIFY `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
