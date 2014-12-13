-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2014 at 05:25 PM
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
-- Table structure for table `db_comments`
--

CREATE TABLE IF NOT EXISTS `db_comments` (
`comment_id` int(11) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `db_comments`
--

INSERT INTO `db_comments` (`comment_id`, `post_id`, `name`, `email`, `content`) VALUES
(1, 1, 'gosho', 'durabura@durabura.durabura', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).'),
(2, 1, 'asdsad', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');

-- --------------------------------------------------------

--
-- Table structure for table `db_members`
--

CREATE TABLE IF NOT EXISTS `db_members` (
`member_id` int(11) unsigned NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='database for members';

--
-- Dumping data for table `db_members`
--

INSERT INTO `db_members` (`member_id`, `username`, `password`, `email`) VALUES
(1, 'paris', '$2y$10$Bskml7Jvtxf4Ia9MveoN2e0nWnkCf8cf1qLROnmVY6uTPn0fQRbyu', 'team_paris@paris.paris');

-- --------------------------------------------------------

--
-- Table structure for table `db_posts`
--

CREATE TABLE IF NOT EXISTS `db_posts` (
`post_id` int(11) unsigned NOT NULL,
  `post_title` varchar(255) DEFAULT NULL,
  `post_desc` text,
  `post_cont` text,
  `post_date` datetime DEFAULT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_visits` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='database for posts';

--
-- Dumping data for table `db_posts`
--

INSERT INTO `db_posts` (`post_id`, `post_title`, `post_desc`, `post_cont`, `post_date`, `post_tags`, `post_visits`) VALUES
(1, 'Lorem Ipsum', '<p>What is Lorem Ipsum</p>', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<div class="rc">\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n</div>', '2014-12-13 16:22:22', '', 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_comments`
--
ALTER TABLE `db_comments`
 ADD PRIMARY KEY (`comment_id`);

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
-- AUTO_INCREMENT for table `db_comments`
--
ALTER TABLE `db_comments`
MODIFY `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `db_members`
--
ALTER TABLE `db_members`
MODIFY `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `db_posts`
--
ALTER TABLE `db_posts`
MODIFY `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
