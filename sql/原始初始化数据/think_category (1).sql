-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-07-05 02:12:43
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
(1, 0, '未分类', ' ', '', 'SEO标题', 'SEO关键字', 'SEO描述', 100000),
(2, 0, '国内新闻', '', '', '', '', '', 100),
(3, 2, '福建新闻', '', '', '', '', '', 100),
(4, 2, '浙江新闻', '', '', '', '', '', 100),
(5, 3, '福州新闻', '', '', '', '', '', 100),
(6, 3, '漳州新闻', '', '', '', '', '', 100),
(7, 0, '国际新闻', '', '', '', '', '', 100),
(8, 7, '美国新闻', '', '', '', '', '', 100),
(9, 7, '法国新闻', '', '', '', '', '', 100),
(10, 0, '测试分类1', '测试分类1-描述', '/Upload/image/ueditor/20180702/efe22bd00c8ff5cfba806d65251141f2.png', 'seo标题', 'seo关键字', 'seo描述', 100),
(12, 10, '测试分类1-2', '测试分类1-2-描述', '/Upload/image/ueditor/20180702/f42843109ec7418eae3607f004acbd87.png', 'SEO标题', 'SEO关键字', 'SEO描述', 100);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
