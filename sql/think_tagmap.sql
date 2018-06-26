-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-06-19 03:17:51
-- 服务器版本： 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thinkphp`
--

-- --------------------------------------------------------

--
-- 表的结构 `think_tagmap`
--

CREATE TABLE `think_tagmap` (
  `tagid` int(11) UNSIGNED NOT NULL,
  `aid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_tagmap`
--
ALTER TABLE `think_tagmap`
  ADD KEY `tagid` (`tagid`),
  ADD KEY `aid` (`aid`);

--
-- 限制导出的表
--

--
-- 限制表 `think_tagmap`
--
ALTER TABLE `think_tagmap`
  ADD CONSTRAINT `think_tagmap_ibfk_1` FOREIGN KEY (`tagid`) REFERENCES `think_tag` (`id`),
  ADD CONSTRAINT `think_tagmap_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `think_article` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
