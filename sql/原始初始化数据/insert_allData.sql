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
(9, 7, '法国新闻', '', '', '', '', '', 100);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



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
(3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_auth_group_access`
--
ALTER TABLE `think_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------

--
-- 表的结构 `think_auth_group`
--

CREATE TABLE `think_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_auth_group`
--

INSERT INTO `think_auth_group` (`id`, `title`, `description`, `status`, `rules`) VALUES
(1, '普通管理员', '', 1, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,28,29,31,34,33'),
(2, '普通管理员', '', 1, '1,2,12,13,14,15,23,28,29,31,34,40,35,36,37,38,39'),
(3, '用户', '', 1, '1,2,23,28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_auth_group`
--
ALTER TABLE `think_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `think_auth_group`
--
ALTER TABLE `think_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;





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
(24, 'admin/classify/index', '分类管理', 1, 1, '', 24),
(25, 'admin/classify/categorylist', '分类列表', 1, 1, '', 25),
(26, 'admin/classify/add', '添加分类', 1, 1, '', 26),
(27, 'admin/classify/del', '删除分类', 1, 1, '', 27),
(28, 'admin/classify/edit', '编辑分类', 1, 1, '', 28),
(29, 'admin/article/index', '文章管理', 1, 1, '', 29),
(30, 'admin/article/articlelist', '文章列表', 1, 1, '', 30),
(31, 'admin/article/del', '删除文章', 1, 1, '', 31),
(32, 'admin/article/add', '添加文章', 1, 1, '', 32),
(33, 'admin/article/edit', '编辑文章', 1, 1, '', 33);

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
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


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




-- --------------------------------------------------------

--
-- 表的结构 `think_tag`
--

CREATE TABLE `think_tag` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` char(20) NOT NULL DEFAULT '',
  `num` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_tag`
--

INSERT INTO `think_tag` (`id`, `name`, `num`) VALUES
(1, '娱乐', 0),
(2, '体育', 0),
(3, '网购', 0),
(4, '科技', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_tag`
--
ALTER TABLE `think_tag`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `think_tag`
--
ALTER TABLE `think_tag`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;





