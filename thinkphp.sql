-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-03-30 09:18:46
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
  `menu_id` int(11) UNSIGNED NOT NULL COMMENT '菜单id',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级id',
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

INSERT INTO `think_admin_menus` (`menu_id`, `parent_id`, `is_show`, `title`, `url`, `param`, `icon`, `log_type`, `sort_id`, `create_time`, `update_time`, `status`) VALUES
(1, 0, 1, '后台首页', 'admin/index/index', '', '', 0, 1, 0, 0, 1),
(2, 0, 1, '系统管理', 'admin/sys', '', '', 0, 1, 0, 0, 1),
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
(13, 11, 0, '添加菜单', 'admin/admin_menu/add', '', '', 0, 1, 0, 0, 1),
(14, 11, 0, '修改菜单', 'admin/admin_menu/edit', '', '', 0, 1, 0, 0, 1),
(15, 11, 0, '删除菜单', 'admin/admin_menu/del', '', '', 0, 1, 0, 0, 1),
(16, 2, 1, '日志管理', 'admin/logs', '', '', 0, 1, 0, 0, 1),
(17, 15, 1, '操作日志', 'admin/logs/handler', '', '', 0, 1, 0, 0, 1),
(18, 15, 1, '系统日志', 'admin/logs/sys', '', '', 0, 1, 0, 0, 1),
(19, 2, 1, '系统设置', 'admin/sysconfig/index', '', '', 0, 1, 0, 0, 1),
(20, 18, 0, '添加设置', 'admin/sysconfig/add', '', '', 0, 1, 0, 0, 1),
(21, 18, 0, '编辑设置', 'admin/sysconfig/edit', '', '', 0, 1, 0, 0, 1),
(22, 18, 0, '删除设置', 'admin/sysconfig/del', '', '', 0, 1, 0, 0, 1),
(23, 2, 1, '个人资料', 'admin/admin_user/profile', '', '', 0, 1, 0, 0, 1),
(24, 0, 1, '栏目管理', 'admin/column/index', '', '', 0, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `think_auth_group`
--

CREATE TABLE `think_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_auth_group`
--

INSERT INTO `think_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '管理员', 1, '1,2,3,4,5,6,7,8,9,10,11,15,14,17,18,19,20,21,22,23,24'),
(2, '普通管理员', 1, '1,2,7,9,12,13,14,15,23,24'),
(3, '用户', 1, '1,2,23');

-- --------------------------------------------------------

--
-- 表的结构 `think_auth_group_access`
--

CREATE TABLE `think_auth_group_access` (
  `uid` mediumint(8) UNSIGNED NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) UNSIGNED NOT NULL COMMENT '用户组id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

--
-- 转存表中的数据 `think_auth_group_access`
--

INSERT INTO `think_auth_group_access` (`uid`, `group_id`) VALUES
(1, 1),
(2, 2),
(2, 3),
(3, 3);

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
(2, 'admin/sys', '系统管理', 1, 1, '', 2),
(3, 'admin/admin_user/index', '用户管理', 1, 1, '', 3),
(4, 'admin/admin_user/add', '添加用户', 1, 1, '', 4),
(5, 'admin/admin_user/edit', '修改用户', 1, 1, '', 5),
(6, 'admin/admin_user/del', '删除用户', 1, 1, '', 6),
(7, 'admin/role/index', '角色管理', 1, 1, '', 7),
(8, 'admin/role/add', '添加角色', 1, 1, '', 8),
(9, 'admin/role/edit', '修改角色', 1, 1, '', 9),
(10, 'admin/role/del', '删除角色', 1, 1, '', 10),
(11, 'admin/role/access', '授权管理', 1, 1, '', 10),
(12, 'admin/admin_menu/index', '菜单管理', 1, 1, '', 11),
(13, 'admin/admin_menu/add', '添加菜单', 1, 1, '', 12),
(14, 'admin/admin_menu/edit', '修改菜单', 1, 1, '', 13),
(15, 'admin/admin_menu/del', '删除菜单', 1, 1, '', 14),
(16, 'admin/logs', '日志管理', 1, 1, '', 15),
(17, 'admin/logs/handler', '操作日志', 1, 1, '', 16),
(18, 'admin/logs/sys', '系统日志', 1, 1, '', 17),
(19, 'admin/sysconfig/index', '系统设置', 1, 1, '', 18),
(20, 'admin/sysconfig/add', '添加设置', 1, 1, '', 19),
(21, 'admin/sysconfig/edit', '编辑设置', 1, 1, '', 20),
(22, 'admin/sysconfig/del', '删除设置', 1, 1, '', 21),
(23, 'admin/admin_user/profile', '个人资料', 1, 1, '', 22),
(24, 'admin/column/index', '栏目管理', 1, 1, '', 23);

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
  `status` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `think_auth_user`
--

INSERT INTO `think_auth_user` (`id`, `username`, `password`, `email`, `phone`, `sex`, `avatar`, `occupation`, `birthday`, `qq`, `create_time`, `update_time`, `delete_time`, `reg_ip`, `last_login_time`, `last_login_ip`, `status`) VALUES
(1, 'yyh1', '96e79218965eb72c92a549dd5a330112', '1@qq.com', '13850502055', '女', '20180307\\659df534877d5cccf83fc367495d5001.jpg', '', '2017-03-24', '', 0, 0, NULL, 0, 0, 0, 1),
(2, 'yyh', '96e79218965eb72c92a549dd5a330112', '2@qq.com', '13850502055', '保密', 'avatar.png', '', '0000-00-00', '', 0, 0, NULL, 0, 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_admin_menus`
--
ALTER TABLE `think_admin_menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `think_auth_group`
--
ALTER TABLE `think_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `think_auth_group_access`
--
ALTER TABLE `think_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `think_auth_rules`
--
ALTER TABLE `think_auth_rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `think_auth_user`
--
ALTER TABLE `think_auth_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `think_admin_menus`
--
ALTER TABLE `think_admin_menus`
  MODIFY `menu_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单id', AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `think_auth_group`
--
ALTER TABLE `think_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `think_auth_rules`
--
ALTER TABLE `think_auth_rules`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `think_auth_user`
--
ALTER TABLE `think_auth_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
