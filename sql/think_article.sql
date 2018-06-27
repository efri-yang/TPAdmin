-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-06-27 02:37:35
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
-- 表的结构 `think_article`
--

CREATE TABLE `think_article` (
  `id` int(11) UNSIGNED NOT NULL,
  `classifyid` int(11) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `keyword` char(30) NOT NULL DEFAULT '',
  `description` char(255) NOT NULL DEFAULT '',
  `coverimg` char(120) DEFAULT '',
  `content` longtext NOT NULL,
  `author` char(30) DEFAULT '',
  `tags` varchar(30) DEFAULT '',
  `tagid` varchar(30) DEFAULT '',
  `iscomment` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `clicks` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_article`
--

INSERT INTO `think_article` (`id`, `classifyid`, `title`, `keyword`, `description`, `coverimg`, `content`, `author`, `tags`, `tagid`, `iscomment`, `create_time`, `update_time`, `clicks`) VALUES
(1, 2, '国内文章01', '关键字', '描述', '/Upload/image/ueditor/20180626/e3d8501e0b5180fcc6566e7eface94e3.jpg', '<p>国内文章01</p><p>国内文章01</p><p>国内文章01</p><p>国内文章01</p><p>国内文章01</p><p>国内文章01</p><p>国内文章01</p><p>国内文章01</p><p><img src=\\\"/Upload/image/ueditor/20180626/1530002888.jpg\\\" title=\\\"1530002888.jpg\\\" alt=\\\"750x300banner.jpg\\\"/></p>', '作者', '娱乐', '1', 1, 1530002891, 0, 0),
(2, 3, '福建新闻01', '', '', '/Upload/image/ueditor/20180626/2a85a12be10870b869f58b63f604d27c.jpg', '<p>福建新闻01</p><p>福建新闻01</p><p>福建新闻01</p><p>福建新闻01</p><p>福建新闻01</p><p>福建新闻01</p><p>福建新闻01</p><p>福建新闻01</p><p><img src=\\\"/Upload/image/ueditor/20180626/1530002888.jpg\\\" title=\\\"1530002888.jpg\\\" alt=\\\"750x300banner.jpg\\\"/></p>', '', '娱乐,体育', '1,2', 1, 1530003350, 0, 0),
(3, 5, '福州新闻01', '', '', '/Upload/image/ueditor/20180626/be15ba840abe0ca4219c368176d41b06.jpg', '<p>福州新闻01</p><p>福州新闻01</p><p>福州新闻01</p><p>福州新闻01</p><p>福州新闻01</p><p>福州新闻01</p><p><img src=\\\"/Upload/image/ueditor/20180626/1530002888.jpg\\\" title=\\\"1530002888.jpg\\\" alt=\\\"750x300banner.jpg\\\"/></p>', '', '娱乐,体育,网购,科技', '1,2,3,4', 1, 1530003436, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_article`
--
ALTER TABLE `think_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classifyid` (`classifyid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `think_article`
--
ALTER TABLE `think_article`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 限制导出的表
--

--
-- 限制表 `think_article`
--
ALTER TABLE `think_article`
  ADD CONSTRAINT `think_article_ibfk_1` FOREIGN KEY (`classifyid`) REFERENCES `think_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
