-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-06-28 06:16:27
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
-- 表的结构 `think_auth_user`
--

CREATE TABLE `think_auth_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `phone` varchar(11) NOT NULL DEFAULT '',
  `sex` enum('男','女','保密') NOT NULL DEFAULT '保密',
  `avatar` varchar(255) NOT NULL DEFAULT 'avatar.png',
  `occupation` varchar(30) NOT NULL DEFAULT '',
  `birthday` date DEFAULT NULL,
  `qq` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(11) UNSIGNED NOT NULL,
  `delete_time` int(11) UNSIGNED DEFAULT NULL,
  `reg_ip` bigint(20) NOT NULL DEFAULT '0',
  `last_login_time` int(10) NOT NULL DEFAULT '0',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0',
  `status` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `think_auth_user`
--

INSERT INTO `think_auth_user` (`id`, `username`, `password`, `email`, `phone`, `sex`, `avatar`, `occupation`, `birthday`, `qq`, `create_time`, `update_time`, `delete_time`, `reg_ip`, `last_login_time`, `last_login_ip`, `status`) VALUES
(1, 'admin', '96e79218965eb72c92a549dd5a330112', '1@qq.com', '13850502055', '女', '20180307\\659df534877d5cccf83fc367495d5001.jpg', '', '2017-03-24', '', 0, 0, NULL, 0, 0, 0, 1),
(2, '普通管理员', '96e79218965eb72c92a549dd5a330112', '2@qq.com', '13850502055', '保密', 'avatar.png', '', '0000-00-00', '', 0, 0, NULL, 0, 0, 0, 1),
(3, '用户1', '96e79218965eb72c92a549dd5a330112', 'pt1@qq.com', '13850502055', '保密', 'avatar.png', '', NULL, '', 0, 0, NULL, 0, 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_auth_user`
--
ALTER TABLE `think_auth_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `think_auth_user`
--
ALTER TABLE `think_auth_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
