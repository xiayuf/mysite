-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 �?02 �?12 �?07:13
-- 服务器版本: 5.5.53
-- PHP 版本: 5.6.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `xiayufeng`
--

-- --------------------------------------------------------

--
-- 表的结构 `cate`
--

CREATE TABLE IF NOT EXISTS `cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` int(10) unsigned DEFAULT '0' COMMENT '父级id',
  `title` varchar(60) DEFAULT NULL COMMENT '名称',
  `createtime` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `source`
--

CREATE TABLE IF NOT EXISTS `source` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '名称',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1:图片  2：图集 3：博客 4：视频',
  `photoids` varchar(255) NOT NULL DEFAULT '' COMMENT '图集的图片集合',
  `tag` varchar(100) NOT NULL DEFAULT '' COMMENT '标签',
  `source_url` varchar(255) NOT NULL DEFAULT '' COMMENT '视频资源url',
  `content` text NOT NULL COMMENT '博客内容',
  `author` varchar(50) NOT NULL DEFAULT '' COMMENT '博客作者',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图片图集表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `upload`
--

CREATE TABLE IF NOT EXISTS `upload` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '文件名',
  `dec` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `file` varchar(255) NOT NULL DEFAULT '' COMMENT '文件上传路径',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '大小',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件上传表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT 'åç§°',
  `phone` varchar(20) DEFAULT NULL COMMENT 'è”ç³»æ–¹å¼',
  `level` tinyint(1) unsigned DEFAULT NULL,
  `passwd` varchar(32) DEFAULT NULL COMMENT 'å¯†ç ',
  `closed` tinyint(1) DEFAULT NULL COMMENT 'åˆ é™¤æ ‡è¯†',
  `createtime` int(10) unsigned DEFAULT '0' COMMENT 'åˆ›å»ºæ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
