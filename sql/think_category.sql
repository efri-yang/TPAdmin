-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-06-27 02:38:52
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
-- 表的结构 `think_category`
--

CREATE TABLE `think_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `coverimg` char(120) NOT NULL DEFAULT '""',
  `seo_title` varchar(100) NOT NULL,
  `seo_keyword` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `sort_id` float NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_category`
--

INSERT INTO `think_category` (`id`, `pid`, `name`, `description`, `coverimg`, `seo_title`, `seo_keyword`, `seo_description`, `sort_id`) VALUES
(1, 0, '未分类', ' ', '/Upload/image/ueditor/20180626/061386ed31841dd39e81961e80a92fe6.jpg', 'SEO标题', 'SEO关键字', 'SEO描述', 100000),
(2, 0, '国内新闻', '', '/Upload/image/ueditor/20180626/cf9edec1889149c08ce82e8db8320cd9.jpg', '', '', '', 100),
(3, 2, '福建新闻', '', '/Upload/image/ueditor/20180626/93a4b8a5561312b9e2948f79e35bb97e.jpg', '', '', '', 100),
(4, 2, '浙江新闻', '', '/Upload/image/ueditor/20180626/51dbf26f0e0c5ca3015d4ce9b818affb.jpg', '', '', '', 100),
(5, 3, '福州新闻', '', '/Upload/image/ueditor/20180626/64cd5cdd23e8c18823d5e8936f2287f4.jpg', '', '', '', 100),
(6, 3, '漳州新闻', '', '/Upload/image/ueditor/20180626/fad837062125eccbf90a97ec497cd43a.jpg', '', '', '', 100),
(7, 0, '国际新闻', '', '/Upload/image/ueditor/20180626/de4d55a1d9afb6bb2431d1d3a94b8b47.jpg', '', '', '', 100),
(8, 7, '美国新闻', '', '/Upload/image/ueditor/20180626/3a7c9db5d47b94ae4b2fda6751c441ff.jpg', '', '', '', 100),
(9, 7, '法国新闻', '', '/Upload/image/ueditor/20180626/42b1695439e84e1f56987676a0329163.jpg', '', '', '', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_category`
--
ALTER TABLE `think_category`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `think_category`
--
ALTER TABLE `think_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
