-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-06-27 18:05:28
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
-- 表的结构 `think_auth_rules`
--

CREATE TABLE `think_auth_rules` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `menu_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '关联菜单id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限规则表';

--
-- 转存表中的数据 `think_auth_rules`
--

INSERT INTO `think_auth_rules` (`id`, `name`, `title`, `type`, `status`, `condition`, `menu_id`) VALUES
(1, 'admin/index/index', '后台首页', 1, 1, '', 1),
(2, '', '系统管理', 1, 1, '', 2),
(3, 'admin/admin_user/index', '用户管理', 1, 1, '', 3),
(4, 'admin/admin_user/add', '添加用户', 1, 1, '', 4),
(5, 'admin/admin_user/edit', '修改用户', 1, 1, '', 5),
(6, 'admin/admin_user/del', '删除用户', 1, 1, '', 6),
(7, 'admin/role/index', '角色管理', 1, 1, '', 7),
(8, 'admin/role/add', '添加角色', 1, 1, '', 8),
(9, 'admin/role/edit', '修改角色', 1, 1, '', 9),
(10, 'admin/role/del', '删除角色', 1, 1, '', 10),
(11, 'admin/role/access', '授权管理', 1, 1, '', 11),
(12, 'admin/admin_menu/index', '菜单管理', 1, 1, '', 12),
(13, 'admin/admin_menu/add', '添加菜单', 1, 1, '', 13),
(14, 'admin/admin_menu/edit', '修改菜单', 1, 1, '', 14),
(15, 'admin/admin_menu/del', '删除菜单', 1, 1, '', 15),
(16, 'admin/logs', '日志管理', 1, 1, '', 16),
(17, 'admin/logs/handler', '操作日志', 1, 1, '', 17),
(18, 'admin/logs/sys', '系统日志', 1, 1, '', 18),
(19, 'admin/sysconfig/index', '系统设置', 1, 1, '', 19),
(20, 'admin/sysconfig/add', '添加设置', 1, 1, '', 20),
(21, 'admin/sysconfig/edit', '编辑设置', 1, 1, '', 21),
(22, 'admin/sysconfig/del', '删除设置', 1, 1, '', 22),
(23, 'admin/admin_user/profile', '个人资料', 1, 1, '', 23),
(28, 'admin/article/index', '文章管理', 1, 1, '', 28),
(71, 'admin/article/del', '删除文章', 1, 1, '', 40),
(60, 'admin/article/add', '添加文章', 1, 1, '', 29),
(62, 'admin/article/articlelist', '文章列表', 1, 1, '', 31),
(65, 'admin/article/edit', '编辑文章', 1, 1, '', 34),
(66, 'admin/classify/index', '分类管理', 1, 1, '', 35),
(67, 'admin/classify/categorylist', '分类列表', 1, 1, '', 36),
(68, 'admin/classify/add', '添加分类', 1, 1, '', 37),
(69, 'admin/classify/del', '删除分类', 1, 1, '', 38),
(70, 'admin/classify/edit', '编辑分类', 1, 1, '', 39);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_auth_rules`
--
ALTER TABLE `think_auth_rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `think_auth_rules`
--
ALTER TABLE `think_auth_rules`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
