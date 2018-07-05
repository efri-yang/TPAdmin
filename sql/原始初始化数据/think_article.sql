-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-07-04 11:00:18
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
  `classifyid` int(11) UNSIGNED ,
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
(1, 10, '测试分类1——文章1', '', '', '/Upload/image/ueditor/20180702/df61953440bbd745b955468d406486cb.png', '<p>测试分类1——文章1</p><p>测试分类1——文章1</p><p>测试分类1——文章1</p><p>测试分类1——文章1</p><p>测试分类1——文章1</p><p>测试分类1——文章1</p>', '', '娱乐', '1', 1, 1530538783, 1530692177, 0),
(2, 11, '测试分类文1-1——文章1', '', '', '', '<p>测试分类文1-1——文章1</p><p>测试分类文1-1——文章1</p><p>测试分类文1-1——文章1</p><p>测试分类文1-1——文章1</p>', '', '娱乐', '1', 1, 1530539823, 1530548459, 0),
(3, 13, '测试分类文1-1-1——文章1', '', '', '', '<p>测试分类文1-1-1——文章1</p><p>测试分类文1-1-1——文章1</p><p>测试分类文1-1-1——文章1</p><p>测试分类文1-1-1——文章1</p><p>测试分类文1-1-1——文章1</p>', '', '娱乐', '1', 1, 1530539853, 1530548442, 0),
(4, 12, '测试分类文1-2——文章1', '', '', '', '<p>测试分类文1-2——文章1</p><p>测试分类文1-2——文章1</p><p>测试分类文1-2——文章1</p><p>测试分类文1-2——文章1</p><p>测试分类文1-2——文章1</p><p>测试分类文1-2——文章1</p>', '', '娱乐,体育', '1,2', 1, 1530539967, 1530692799, 0);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 限制导出的表
--

--
-- 限制表 `think_article`
--
ALTER TABLE `think_article`
  ADD CONSTRAINT `think_article_ibfk_1` FOREIGN KEY (`classifyid`) REFERENCES `think_category` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
