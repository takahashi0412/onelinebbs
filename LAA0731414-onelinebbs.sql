-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- ホスト: mysql110.phy.lolipop.jp
-- 生成時間: 2016 年 4 月 21 日 15:50
-- サーバのバージョン: 5.6.23
-- PHP のバージョン: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `LAA0731414-onelinebbs`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'サロゲートキー',
  `accountname` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'アカウント名',
  `password` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'パスワード',
  `available` tinyint(1) NOT NULL COMMENT '論理削除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `accountname` (`accountname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- テーブルのデータをダンプしています `accounts`
--

INSERT INTO `accounts` (`id`, `accountname`, `password`, `available`) VALUES
(1, 'toshi', '8501c7dc6928019b26e69d38c9ef4371d2d3fbb05c02b17fc3...\n', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `bulletinboard`
--

CREATE TABLE IF NOT EXISTS `bulletinboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'サロゲートキー',
  `accountid` int(11) NOT NULL COMMENT 'accounts.id',
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '掲示板タイトル',
  `inserttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '作成時間',
  `available` tinyint(1) NOT NULL COMMENT '論理削除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `bulletinboardcontents`
--

CREATE TABLE IF NOT EXISTS `bulletinboardcontents` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'サロゲートキー',
  `accountid` int(11) NOT NULL COMMENT 'accounts.id',
  `bullentinboardid` int(11) NOT NULL COMMENT 'bullentinboard.id',
  `contributor` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '投稿者',
  `inserttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '投稿日時',
  `contents` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `available` tinyint(1) NOT NULL COMMENT '論理削除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='掲示板への投稿内容を管理' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- テーブルのデータをダンプしています `posts`
--

INSERT INTO `posts` (`id`, `nickname`, `comment`, `created`) VALUES
(3, 'Eriko', '入れた！！', '2016-04-21 14:17:04'),
(4, 'テスト', 'こめのt\r\n', '2016-04-21 15:30:36');

-- --------------------------------------------------------

--
-- テーブルの構造 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'サロゲートキー',
  `accountid` int(11) NOT NULL COMMENT 'accounts.id',
  `rolename` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '権限名',
  `available` tinyint(1) NOT NULL COMMENT '論理削除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
