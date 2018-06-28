-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-06-28 04:54:19
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
-- 表的结构 `think_admin_menus`
--

CREATE TABLE `think_admin_menus` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '菜单id',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级id',
  `is_show` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否显示',
  `title` varchar(50) NOT NULL COMMENT '菜单名称',
  `url` varchar(100) NOT NULL COMMENT '模块/控制器/方法',
  `param` varchar(100) NOT NULL DEFAULT '',
  `icon` varchar(50) NOT NULL DEFAULT 'fa-circle-o' COMMENT '菜单图标',
  `log_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0不记录日志，1get，2post，3put，4delete，先这些啦',
  `sort_id` smallint(5) UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序id',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态：1默认正常，2禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

--
-- 转存表中的数据 `think_admin_menus`
--

INSERT INTO `think_admin_menus` (`id`, `pid`, `is_show`, `title`, `url`, `param`, `icon`, `log_type`, `sort_id`, `create_time`, `update_time`, `status`) VALUES
(1, 0, 1, '后台首页', 'admin/index/index', '', 'fa-circle-o', 0, 9999, 0, 0, 1),
(2, 0, 1, '系统管理', '', '', '', 0, 950, 0, 0, 1),
(3, 2, 1, '用户管理', 'admin/admin_user/index', '', '', 0, 1, 0, 0, 1),
(4, 3, 0, '添加用户', 'admin/admin_user/add', '', '', 0, 1, 0, 0, 1),
(5, 3, 0, '修改用户', 'admin/admin_user/edit', '', '', 0, 1, 0, 0, 1),
(6, 3, 0, '删除用户', 'admin/admin_user/del', '', '', 0, 1, 0, 0, 1),
(7, 2, 1, '角色管理', 'admin/role/index', '', '', 0, 1, 0, 0, 1),
(8, 7, 0, '添加角色', 'admin/role/add', '', '', 0, 1, 0, 0, 1),
(9, 7, 0, '修改角色', 'admin/role/edit', '', '', 0, 1, 0, 0, 1),
(10, 7, 0, '删除角色', 'admin/role/del', '', '', 0, 1, 0, 0, 1),
(11, 7, 0, '授权管理', 'admin/role/access', '', '', 0, 1, 0, 0, 1),
(12, 2, 1, '菜单管理', 'admin/admin_menu/index', '', '', 0, 1, 0, 0, 1),
(13, 12, 0, '添加菜单', 'admin/admin_menu/add', '', '', 0, 1, 0, 0, 1),
(14, 12, 0, '修改菜单', 'admin/admin_menu/edit', '', '', 0, 1, 0, 0, 1),
(15, 12, 0, '删除菜单', 'admin/admin_menu/del', '', '', 0, 1, 0, 0, 1),
(16, 2, 1, '日志管理', 'admin/logs', '', '', 0, 1, 0, 0, 1),
(17, 16, 1, '操作日志', 'admin/logs/handler', '', '', 0, 1, 0, 0, 1),
(18, 16, 1, '系统日志', 'admin/logs/sys', '', '', 0, 1, 0, 0, 1),
(19, 2, 1, '系统设置', 'admin/sysconfig/index', '', '', 0, 1, 0, 0, 1),
(20, 19, 0, '添加设置', 'admin/sysconfig/add', '', '', 0, 1, 0, 0, 1),
(21, 19, 0, '编辑设置', 'admin/sysconfig/edit', '', '', 0, 1, 0, 0, 1),
(22, 19, 0, '删除设置', 'admin/sysconfig/del', '', '', 0, 1, 0, 0, 1),
(23, 2, 1, '个人资料', 'admin/admin_user/profile', '', '', 0, 1, 0, 0, 1),

(24, 0, 1, '分类管理', 'admin/classify/index', '', 'xx', 0, 900, 0, 0, 1),
(25, 24, 1, '分类列表', 'admin/classify/categorylist', '', 'icon-xx', 0, 1, 0, 0, 1),
(26, 24, 1, '添加分类', 'admin/classify/add', '', 'icon-add', 0, 1, 0, 0, 1),
(27, 24, 0, '删除分类', 'admin/classify/del', '', 'icon-del', 0, 1, 0, 0, 1),
(28, 24, 0, '编辑分类', 'admin/classify/edit', '', 'icon-edit', 0, 1, 0, 0, 1),

(29, 0, 1, '文章管理', 'admin/article/index', '', 'lanmu', 0, 1, 0, 0, 1),
(30, 29, 0, '删除文章', 'admin/article/del', '', 'icon-del', 0, 1, 0, 0, 1),
(31, 29, 1, '添加文章', 'admin/article/add', '', 'add', 0, 1, 0, 0, 1),
(32, 29, 1, '文章列表', 'admin/article/articlelist', '', 'xxxx', 0, 1, 0, 0, 1),
(33, 29, 0, '编辑文章', 'admin/article/edit', '', 'xx', 0, 1, 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_admin_menus`
--
ALTER TABLE `think_admin_menus`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `think_admin_menus`
--
ALTER TABLE `think_admin_menus`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单id', AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
