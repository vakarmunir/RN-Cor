-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Dec 04, 2012 at 07:15 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `rednet`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_adminmenumanager_config`
-- 

DROP TABLE IF EXISTS `jom_adminmenumanager_config`;
CREATE TABLE IF NOT EXISTS `jom_adminmenumanager_config` (
  `id` varchar(255) NOT NULL,
  `config` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_adminmenumanager_config`
-- 

INSERT INTO `jom_adminmenumanager_config` VALUES ('amm', '{"level_sort":"ordering","version_checker":"true","based_on":"group","super_user_sees_all":"true","default_access_group":"1","default_access_level":"1","access_enabled":"1"}');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_adminmenumanager_map`
-- 

DROP TABLE IF EXISTS `jom_adminmenumanager_map`;
CREATE TABLE IF NOT EXISTS `jom_adminmenumanager_map` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `level_title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_adminmenumanager_map`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_adminmenumanager_menuitems`
-- 

DROP TABLE IF EXISTS `jom_adminmenumanager_menuitems`;
CREATE TABLE IF NOT EXISTS `jom_adminmenumanager_menuitems` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `menu` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `published` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `ordertotal` int(11) NOT NULL,
  `accessgroup` int(11) NOT NULL,
  `accesslevel` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `target` int(1) NOT NULL,
  `width` int(4) NOT NULL default '800',
  `height` int(4) NOT NULL default '600',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `jom_adminmenumanager_menuitems`
-- 

INSERT INTO `jom_adminmenumanager_menuitems` VALUES (1, 'Menu Manager', 'templates/bluestork/images/menu/icon-16-menumgr.png', 1, 'index.php?option=com_menus&view=menus', 1, 0, 1, 2, 3, 6, 0, 0, 0, 800, 600);
INSERT INTO `jom_adminmenumanager_menuitems` VALUES (2, 'Article Manager', 'templates/bluestork/images/menu/icon-16-article.png', 1, 'index.php?option=com_content', 1, 0, 1, 1, 1, 6, 0, 0, 0, 800, 600);
INSERT INTO `jom_adminmenumanager_menuitems` VALUES (3, 'Add New Article', 'templates/bluestork/images/menu/icon-16-newarticle.png', 1, 'index.php?option=com_content&view=article&layout=edit', 1, 2, 2, 1, 2, 6, 0, 0, 0, 800, 600);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_adminmenumanager_menus`
-- 

DROP TABLE IF EXISTS `jom_adminmenumanager_menus`;
CREATE TABLE IF NOT EXISTS `jom_adminmenumanager_menus` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(150) NOT NULL,
  `description` varchar(150) NOT NULL,
  `ordering` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jom_adminmenumanager_menus`
-- 

INSERT INTO `jom_adminmenumanager_menus` VALUES (1, 'default', '', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_assets`
-- 

DROP TABLE IF EXISTS `jom_assets`;
CREATE TABLE IF NOT EXISTS `jom_assets` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL default '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL default '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL default '0' COMMENT 'Nested set rgt.',
  `level` int(10) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_asset_name` (`name`),
  KEY `idx_lft_rgt` (`lft`,`rgt`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- 
-- Dumping data for table `jom_assets`
-- 

INSERT INTO `jom_assets` VALUES (1, 0, 1, 73, 0, 'root.1', 'Root Asset', '{"core.login.site":{"6":1,"2":1},"core.login.admin":{"6":1},"core.login.offline":{"6":1},"core.admin":{"8":1},"core.manage":{"7":1},"core.create":{"6":1,"3":1},"core.delete":{"6":1},"core.edit":{"6":1,"4":1},"core.edit.state":{"6":1,"5":1},"core.edit.own":{"6":1,"3":1}}');
INSERT INTO `jom_assets` VALUES (2, 1, 1, 2, 1, 'com_admin', 'com_admin', '{}');
INSERT INTO `jom_assets` VALUES (3, 1, 3, 6, 1, 'com_banners', 'com_banners', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (4, 1, 7, 8, 1, 'com_cache', 'com_cache', '{"core.admin":{"7":1},"core.manage":{"7":1}}');
INSERT INTO `jom_assets` VALUES (5, 1, 9, 10, 1, 'com_checkin', 'com_checkin', '{"core.admin":{"7":1},"core.manage":{"7":1}}');
INSERT INTO `jom_assets` VALUES (6, 1, 11, 12, 1, 'com_config', 'com_config', '{}');
INSERT INTO `jom_assets` VALUES (7, 1, 13, 16, 1, 'com_contact', 'com_contact', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}');
INSERT INTO `jom_assets` VALUES (8, 1, 17, 20, 1, 'com_content', 'com_content', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":[],"core.edit":{"4":1},"core.edit.state":{"5":1},"core.edit.own":[]}');
INSERT INTO `jom_assets` VALUES (9, 1, 21, 22, 1, 'com_cpanel', 'com_cpanel', '{}');
INSERT INTO `jom_assets` VALUES (10, 1, 23, 24, 1, 'com_installer', 'com_installer', '{"core.admin":[],"core.manage":{"7":0},"core.delete":{"7":0},"core.edit.state":{"7":0}}');
INSERT INTO `jom_assets` VALUES (11, 1, 25, 26, 1, 'com_languages', 'com_languages', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (12, 1, 27, 28, 1, 'com_login', 'com_login', '{}');
INSERT INTO `jom_assets` VALUES (13, 1, 29, 30, 1, 'com_mailto', 'com_mailto', '{}');
INSERT INTO `jom_assets` VALUES (14, 1, 31, 32, 1, 'com_massmail', 'com_massmail', '{}');
INSERT INTO `jom_assets` VALUES (15, 1, 33, 34, 1, 'com_media', 'com_media', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":{"5":1}}');
INSERT INTO `jom_assets` VALUES (16, 1, 35, 36, 1, 'com_menus', 'com_menus', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (17, 1, 37, 38, 1, 'com_messages', 'com_messages', '{"core.admin":{"7":1},"core.manage":{"7":1}}');
INSERT INTO `jom_assets` VALUES (18, 1, 39, 40, 1, 'com_modules', 'com_modules', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (19, 1, 41, 44, 1, 'com_newsfeeds', 'com_newsfeeds', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}');
INSERT INTO `jom_assets` VALUES (20, 1, 45, 46, 1, 'com_plugins', 'com_plugins', '{"core.admin":{"7":1},"core.manage":[],"core.edit":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (21, 1, 47, 48, 1, 'com_redirect', 'com_redirect', '{"core.admin":{"7":1},"core.manage":[]}');
INSERT INTO `jom_assets` VALUES (22, 1, 49, 50, 1, 'com_search', 'com_search', '{"core.admin":{"7":1},"core.manage":{"6":1}}');
INSERT INTO `jom_assets` VALUES (23, 1, 51, 52, 1, 'com_templates', 'com_templates', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (24, 1, 53, 56, 1, 'com_users', 'com_users', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (25, 1, 57, 60, 1, 'com_weblinks', 'com_weblinks', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":[],"core.edit":{"4":1},"core.edit.state":{"5":1},"core.edit.own":[]}');
INSERT INTO `jom_assets` VALUES (26, 1, 61, 62, 1, 'com_wrapper', 'com_wrapper', '{}');
INSERT INTO `jom_assets` VALUES (27, 8, 18, 19, 2, 'com_content.category.2', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}');
INSERT INTO `jom_assets` VALUES (28, 3, 4, 5, 2, 'com_banners.category.3', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (29, 7, 14, 15, 2, 'com_contact.category.4', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}');
INSERT INTO `jom_assets` VALUES (30, 19, 42, 43, 2, 'com_newsfeeds.category.5', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}');
INSERT INTO `jom_assets` VALUES (31, 25, 58, 59, 2, 'com_weblinks.category.6', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}');
INSERT INTO `jom_assets` VALUES (32, 24, 54, 55, 1, 'com_users.notes.category.7', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (33, 1, 63, 64, 1, 'com_finder', 'com_finder', '{"core.admin":{"7":1},"core.manage":{"6":1}}');
INSERT INTO `jom_assets` VALUES (34, 1, 65, 66, 1, 'com_joomlaupdate', 'com_joomlaupdate', '{"core.admin":[],"core.manage":[],"core.delete":[],"core.edit.state":[]}');
INSERT INTO `jom_assets` VALUES (35, 1, 67, 68, 1, 'com_jacc', 'jacc', '{}');
INSERT INTO `jom_assets` VALUES (38, 1, 71, 72, 1, 'com_rednet', 'rednet', '{}');
INSERT INTO `jom_assets` VALUES (37, 1, 69, 70, 1, 'com_frontenduseraccess', 'com_frontenduseraccess', '{}');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_associations`
-- 

DROP TABLE IF EXISTS `jom_associations`;
CREATE TABLE IF NOT EXISTS `jom_associations` (
  `id` varchar(50) NOT NULL COMMENT 'A reference to the associated item.',
  `context` varchar(50) NOT NULL COMMENT 'The context of the associated item.',
  `key` char(32) NOT NULL COMMENT 'The key for the association computed from an md5 on associated ids.',
  PRIMARY KEY  (`context`,`id`),
  KEY `idx_key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_associations`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_banners`
-- 

DROP TABLE IF EXISTS `jom_banners`;
CREATE TABLE IF NOT EXISTS `jom_banners` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `clickurl` varchar(200) NOT NULL default '',
  `state` tinyint(3) NOT NULL default '0',
  `catid` int(10) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `custombannercode` varchar(2048) NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `params` text NOT NULL,
  `own_prefix` tinyint(1) NOT NULL default '0',
  `metakey_prefix` varchar(255) NOT NULL default '',
  `purchase_type` tinyint(4) NOT NULL default '-1',
  `track_clicks` tinyint(4) NOT NULL default '-1',
  `track_impressions` tinyint(4) NOT NULL default '-1',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `reset` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `language` char(7) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_banners`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_banner_clients`
-- 

DROP TABLE IF EXISTS `jom_banner_clients`;
CREATE TABLE IF NOT EXISTS `jom_banner_clients` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `metakey` text NOT NULL,
  `own_prefix` tinyint(4) NOT NULL default '0',
  `metakey_prefix` varchar(255) NOT NULL default '',
  `purchase_type` tinyint(4) NOT NULL default '-1',
  `track_clicks` tinyint(4) NOT NULL default '-1',
  `track_impressions` tinyint(4) NOT NULL default '-1',
  PRIMARY KEY  (`id`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_banner_clients`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_banner_tracks`
-- 

DROP TABLE IF EXISTS `jom_banner_tracks`;
CREATE TABLE IF NOT EXISTS `jom_banner_tracks` (
  `track_date` datetime NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`track_date`,`track_type`,`banner_id`),
  KEY `idx_track_date` (`track_date`),
  KEY `idx_track_type` (`track_type`),
  KEY `idx_banner_id` (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_banner_tracks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_categories`
-- 

DROP TABLE IF EXISTS `jom_categories`;
CREATE TABLE IF NOT EXISTS `jom_categories` (
  `id` int(11) NOT NULL auto_increment,
  `asset_id` int(10) unsigned NOT NULL default '0' COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) unsigned NOT NULL default '0',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `level` int(10) unsigned NOT NULL default '0',
  `path` varchar(255) NOT NULL default '',
  `extension` varchar(50) NOT NULL default '',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `description` mediumtext NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `access` int(10) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  `metadesc` varchar(1024) NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL default '0',
  `created_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL default '0',
  `modified_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL default '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `jom_categories`
-- 

INSERT INTO `jom_categories` VALUES (1, 0, 0, 0, 13, 0, '', 'system', 'ROOT', 0x726f6f74, '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '2009-10-18 16:07:09', 0, '0000-00-00 00:00:00', 0, '*');
INSERT INTO `jom_categories` VALUES (2, 27, 1, 1, 2, 1, 'uncategorised', 'com_content', 'Uncategorised', 0x756e63617465676f7269736564, '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:26:37', 0, '0000-00-00 00:00:00', 0, '*');
INSERT INTO `jom_categories` VALUES (3, 28, 1, 3, 4, 1, 'uncategorised', 'com_banners', 'Uncategorised', 0x756e63617465676f7269736564, '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":"","foobar":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:27:35', 0, '0000-00-00 00:00:00', 0, '*');
INSERT INTO `jom_categories` VALUES (4, 29, 1, 5, 6, 1, 'uncategorised', 'com_contact', 'Uncategorised', 0x756e63617465676f7269736564, '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:27:57', 0, '0000-00-00 00:00:00', 0, '*');
INSERT INTO `jom_categories` VALUES (5, 30, 1, 7, 8, 1, 'uncategorised', 'com_newsfeeds', 'Uncategorised', 0x756e63617465676f7269736564, '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:28:15', 0, '0000-00-00 00:00:00', 0, '*');
INSERT INTO `jom_categories` VALUES (6, 31, 1, 9, 10, 1, 'uncategorised', 'com_weblinks', 'Uncategorised', 0x756e63617465676f7269736564, '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:28:33', 0, '0000-00-00 00:00:00', 0, '*');
INSERT INTO `jom_categories` VALUES (7, 32, 1, 11, 12, 1, 'uncategorised', 'com_users.notes', 'Uncategorised', 0x756e63617465676f7269736564, '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:28:33', 0, '0000-00-00 00:00:00', 0, '*');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_contact_details`
-- 

DROP TABLE IF EXISTS `jom_contact_details`;
CREATE TABLE IF NOT EXISTS `jom_contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `con_position` varchar(255) default NULL,
  `address` text,
  `suburb` varchar(100) default NULL,
  `state` varchar(100) default NULL,
  `country` varchar(100) default NULL,
  `postcode` varchar(100) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `misc` mediumtext,
  `image` varchar(255) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(255) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` int(10) unsigned NOT NULL default '0',
  `mobile` varchar(255) NOT NULL default '',
  `webpage` varchar(255) NOT NULL default '',
  `sortname1` varchar(255) NOT NULL,
  `sortname2` varchar(255) NOT NULL,
  `sortname3` varchar(255) NOT NULL,
  `language` char(7) NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Set if article is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_contact_details`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_content`
-- 

DROP TABLE IF EXISTS `jom_content`;
CREATE TABLE IF NOT EXISTS `jom_content` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `asset_id` int(10) unsigned NOT NULL default '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `title_alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '' COMMENT 'Deprecated in Joomla! 3.0',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(10) unsigned NOT NULL default '0',
  `mask` int(10) unsigned NOT NULL default '0',
  `catid` int(10) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` varchar(5120) NOT NULL,
  `version` int(10) unsigned NOT NULL default '1',
  `parentid` int(10) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Set if article is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_content`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_content_frontpage`
-- 

DROP TABLE IF EXISTS `jom_content_frontpage`;
CREATE TABLE IF NOT EXISTS `jom_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_content_frontpage`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_content_rating`
-- 

DROP TABLE IF EXISTS `jom_content_rating`;
CREATE TABLE IF NOT EXISTS `jom_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(10) unsigned NOT NULL default '0',
  `rating_count` int(10) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_content_rating`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_core_log_searches`
-- 

DROP TABLE IF EXISTS `jom_core_log_searches`;
CREATE TABLE IF NOT EXISTS `jom_core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_core_log_searches`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_days_status`
-- 

DROP TABLE IF EXISTS `jom_days_status`;
CREATE TABLE IF NOT EXISTS `jom_days_status` (
  `id` int(11) NOT NULL auto_increment,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `jom_days_status`
-- 

INSERT INTO `jom_days_status` VALUES (1, '2012-11-29', 'open');
INSERT INTO `jom_days_status` VALUES (2, '2012-11-28', 'closed');
INSERT INTO `jom_days_status` VALUES (3, '2012-11-21', 'closed');
INSERT INTO `jom_days_status` VALUES (4, '2012-11-19', 'open');
INSERT INTO `jom_days_status` VALUES (5, '2012-11-12', 'hold');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_extensions`
-- 

DROP TABLE IF EXISTS `jom_extensions`;
CREATE TABLE IF NOT EXISTS `jom_extensions` (
  `extension_id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `element` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `client_id` tinyint(3) NOT NULL,
  `enabled` tinyint(3) NOT NULL default '1',
  `access` int(10) unsigned NOT NULL default '1',
  `protected` tinyint(3) NOT NULL default '0',
  `manifest_cache` text NOT NULL,
  `params` text NOT NULL,
  `custom_data` text NOT NULL,
  `system_data` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) default '0',
  `state` int(11) default '0',
  PRIMARY KEY  (`extension_id`),
  KEY `element_clientid` (`element`,`client_id`),
  KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  KEY `extension` (`type`,`element`,`folder`,`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10012 ;

-- 
-- Dumping data for table `jom_extensions`
-- 

INSERT INTO `jom_extensions` VALUES (1, 'com_mailto', 'component', 'com_mailto', '', 0, 1, 1, 1, '{"legacy":false,"name":"com_mailto","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MAILTO_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (2, 'com_wrapper', 'component', 'com_wrapper', '', 0, 1, 1, 1, '{"legacy":false,"name":"com_wrapper","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_WRAPPER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (3, 'com_admin', 'component', 'com_admin', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_admin","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_ADMIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (4, 'com_banners', 'component', 'com_banners', '', 1, 1, 1, 0, '{"legacy":false,"name":"com_banners","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_BANNERS_XML_DESCRIPTION","group":""}', '{"purchase_type":"3","track_impressions":"0","track_clicks":"0","metakey_prefix":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (5, 'com_cache', 'component', 'com_cache', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_cache","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CACHE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (6, 'com_categories', 'component', 'com_categories', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_categories","type":"component","creationDate":"December 2007","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CATEGORIES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (7, 'com_checkin', 'component', 'com_checkin', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_checkin","type":"component","creationDate":"Unknown","author":"Joomla! Project","copyright":"(C) 2005 - 2008 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CHECKIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (8, 'com_contact', 'component', 'com_contact', '', 1, 1, 1, 0, '{"legacy":false,"name":"com_contact","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CONTACT_XML_DESCRIPTION","group":""}', '{"show_contact_category":"hide","show_contact_list":"0","presentation_style":"sliders","show_name":"1","show_position":"1","show_email":"0","show_street_address":"1","show_suburb":"1","show_state":"1","show_postcode":"1","show_country":"1","show_telephone":"1","show_mobile":"1","show_fax":"1","show_webpage":"1","show_misc":"1","show_image":"1","image":"","allow_vcard":"0","show_articles":"0","show_profile":"0","show_links":"0","linka_name":"","linkb_name":"","linkc_name":"","linkd_name":"","linke_name":"","contact_icons":"0","icon_address":"","icon_email":"","icon_telephone":"","icon_mobile":"","icon_fax":"","icon_misc":"","show_headings":"1","show_position_headings":"1","show_email_headings":"0","show_telephone_headings":"1","show_mobile_headings":"0","show_fax_headings":"0","allow_vcard_headings":"0","show_suburb_headings":"1","show_state_headings":"1","show_country_headings":"1","show_email_form":"1","show_email_copy":"1","banned_email":"","banned_subject":"","banned_text":"","validate_session":"1","custom_reply":"0","redirect":"","show_category_crumb":"0","metakey":"","metadesc":"","robots":"","author":"","rights":"","xreference":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (9, 'com_cpanel', 'component', 'com_cpanel', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_cpanel","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CPANEL_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (10, 'com_installer', 'component', 'com_installer', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_installer","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_INSTALLER_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (11, 'com_languages', 'component', 'com_languages', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_languages","type":"component","creationDate":"2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_LANGUAGES_XML_DESCRIPTION","group":""}', '{"administrator":"en-GB","site":"en-GB"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (12, 'com_login', 'component', 'com_login', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_login","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_LOGIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (13, 'com_media', 'component', 'com_media', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_media","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MEDIA_XML_DESCRIPTION","group":""}', '{"upload_extensions":"bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS","upload_maxsize":"10","file_path":"images","image_path":"images","restrict_uploads":"1","allowed_media_usergroup":"3","check_mime":"1","image_extensions":"bmp,gif,jpg,png","ignore_extensions":"","upload_mime":"image\\/jpeg,image\\/gif,image\\/png,image\\/bmp,application\\/x-shockwave-flash,application\\/msword,application\\/excel,application\\/pdf,application\\/powerpoint,text\\/plain,application\\/x-zip","upload_mime_illegal":"text\\/html","enable_flash":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (14, 'com_menus', 'component', 'com_menus', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_menus","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MENUS_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (15, 'com_messages', 'component', 'com_messages', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_messages","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MESSAGES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (16, 'com_modules', 'component', 'com_modules', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_modules","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MODULES_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (17, 'com_newsfeeds', 'component', 'com_newsfeeds', '', 1, 1, 1, 0, '{"legacy":false,"name":"com_newsfeeds","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_NEWSFEEDS_XML_DESCRIPTION","group":""}', '{"show_feed_image":"1","show_feed_description":"1","show_item_description":"1","feed_word_count":"0","show_headings":"1","show_name":"1","show_articles":"0","show_link":"1","show_description":"1","show_description_image":"1","display_num":"","show_pagination_limit":"1","show_pagination":"1","show_pagination_results":"1","show_cat_items":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (18, 'com_plugins', 'component', 'com_plugins', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_plugins","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_PLUGINS_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (19, 'com_search', 'component', 'com_search', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_search","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_SEARCH_XML_DESCRIPTION","group":""}', '{"enabled":"0","show_date":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (20, 'com_templates', 'component', 'com_templates', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_templates","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_TEMPLATES_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (21, 'com_weblinks', 'component', 'com_weblinks', '', 1, 1, 1, 0, '{"legacy":false,"name":"com_weblinks","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_WEBLINKS_XML_DESCRIPTION","group":""}', '{"show_comp_description":"1","comp_description":"","show_link_hits":"1","show_link_description":"1","show_other_cats":"0","show_headings":"0","show_numbers":"0","show_report":"1","count_clicks":"1","target":"0","link_icons":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (22, 'com_content', 'component', 'com_content', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_content","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CONTENT_XML_DESCRIPTION","group":""}', '{"article_layout":"_:default","show_title":"1","link_titles":"1","show_intro":"1","show_category":"1","link_category":"1","show_parent_category":"0","link_parent_category":"0","show_author":"1","link_author":"0","show_create_date":"0","show_modify_date":"0","show_publish_date":"1","show_item_navigation":"1","show_vote":"0","show_readmore":"1","show_readmore_title":"1","readmore_limit":"100","show_icons":"1","show_print_icon":"1","show_email_icon":"1","show_hits":"1","show_noauth":"0","show_publishing_options":"1","show_article_options":"1","show_urls_images_frontend":"0","show_urls_images_backend":"1","targeta":0,"targetb":0,"targetc":0,"float_intro":"left","float_fulltext":"left","category_layout":"_:blog","show_category_title":"0","show_description":"0","show_description_image":"0","maxLevel":"1","show_empty_categories":"0","show_no_articles":"1","show_subcat_desc":"1","show_cat_num_articles":"0","show_base_description":"1","maxLevelcat":"-1","show_empty_categories_cat":"0","show_subcat_desc_cat":"1","show_cat_num_articles_cat":"1","num_leading_articles":"1","num_intro_articles":"4","num_columns":"2","num_links":"4","multi_column_order":"0","show_subcategory_content":"0","show_pagination_limit":"1","filter_field":"hide","show_headings":"1","list_show_date":"0","date_format":"","list_show_hits":"1","list_show_author":"1","orderby_pri":"order","orderby_sec":"rdate","order_date":"published","show_pagination":"2","show_pagination_results":"1","show_feed_link":"1","feed_summary":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (23, 'com_config', 'component', 'com_config', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_config","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CONFIG_XML_DESCRIPTION","group":""}', '{"filters":{"1":{"filter_type":"NH","filter_tags":"","filter_attributes":""},"6":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"7":{"filter_type":"NONE","filter_tags":"","filter_attributes":""},"2":{"filter_type":"NH","filter_tags":"","filter_attributes":""},"3":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"4":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"5":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"8":{"filter_type":"NONE","filter_tags":"","filter_attributes":""}}}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (10008, 'plg_authentication_jmapmyldap', 'plugin', 'jmapmyldap', 'authentication', 0, 0, 1, 0, '{"legacy":false,"name":"plg_authentication_jmapmyldap","type":"plugin","creationDate":"June 2011","author":"Shaun Maunder","copyright":"Copyright (C) 2011 Shaun Maunder. All rights reserved.","authorEmail":"shaun@shmanic.com","authorUrl":"www.shmanic.com","version":"1.0.6","description":"PLG_JMAPMYLDAP_XML_DESCRIPTION","group":""}', '{"use_ldapV3":"0","negotiate_tls":"0","follow_referrals":"0","port":"389","use_search":"0","ldap_uid":"uid","ldap_fullname":"fullName","ldap_email":"mail"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (24, 'com_redirect', 'component', 'com_redirect', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_redirect","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_REDIRECT_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (25, 'com_users', 'component', 'com_users', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_users","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_USERS_XML_DESCRIPTION","group":""}', '{"allowUserRegistration":"1","new_usertype":"2","useractivation":"1","frontend_userparams":"1","mailSubjectPrefix":"","mailBodySuffix":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (27, 'com_finder', 'component', 'com_finder', '', 1, 1, 0, 0, '{"legacy":false,"name":"com_finder","type":"component","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_FINDER_XML_DESCRIPTION","group":""}', '{"show_description":"1","description_length":255,"allow_empty_query":"0","show_url":"1","show_advanced":"1","expand_advanced":"0","show_date_filters":"0","highlight_terms":"1","opensearch_name":"","opensearch_description":"","batch_size":"50","memory_table_limit":30000,"title_multiplier":"1.7","text_multiplier":"0.7","meta_multiplier":"1.2","path_multiplier":"2.0","misc_multiplier":"0.3","stemmer":"snowball"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (28, 'com_joomlaupdate', 'component', 'com_joomlaupdate', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_joomlaupdate","type":"component","creationDate":"February 2012","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_JOOMLAUPDATE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (100, 'PHPMailer', 'library', 'phpmailer', '', 0, 1, 1, 1, '{"legacy":false,"name":"PHPMailer","type":"library","creationDate":"2001","author":"PHPMailer","copyright":"(c) 2001-2003, Brent R. Matzelle, (c) 2004-2009, Andy Prevost. All Rights Reserved., (c) 2010-2011, Jim Jagielski. All Rights Reserved.","authorEmail":"jimjag@gmail.com","authorUrl":"https:\\/\\/code.google.com\\/a\\/apache-extras.org\\/p\\/phpmailer\\/","version":"5.2","description":"LIB_PHPMAILER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (101, 'SimplePie', 'library', 'simplepie', '', 0, 1, 1, 1, '{"legacy":false,"name":"SimplePie","type":"library","creationDate":"2004","author":"SimplePie","copyright":"Copyright (c) 2004-2009, Ryan Parman and Geoffrey Sneddon","authorEmail":"","authorUrl":"http:\\/\\/simplepie.org\\/","version":"1.2","description":"LIB_SIMPLEPIE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (102, 'phputf8', 'library', 'phputf8', '', 0, 1, 1, 1, '{"legacy":false,"name":"phputf8","type":"library","creationDate":"2006","author":"Harry Fuecks","copyright":"Copyright various authors","authorEmail":"hfuecks@gmail.com","authorUrl":"http:\\/\\/sourceforge.net\\/projects\\/phputf8","version":"0.5","description":"LIB_PHPUTF8_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (103, 'Joomla! Platform', 'library', 'joomla', '', 0, 1, 1, 1, '{"legacy":false,"name":"Joomla! Platform","type":"library","creationDate":"2008","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"http:\\/\\/www.joomla.org","version":"11.4","description":"LIB_JOOMLA_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (200, 'mod_articles_archive', 'module', 'mod_articles_archive', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_articles_archive","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters.\\n\\t\\tAll rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_ARTICLES_ARCHIVE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (201, 'mod_articles_latest', 'module', 'mod_articles_latest', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_articles_latest","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LATEST_NEWS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (202, 'mod_articles_popular', 'module', 'mod_articles_popular', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_articles_popular","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_POPULAR_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (203, 'mod_banners', 'module', 'mod_banners', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_banners","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_BANNERS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (204, 'mod_breadcrumbs', 'module', 'mod_breadcrumbs', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_breadcrumbs","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_BREADCRUMBS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (205, 'mod_custom', 'module', 'mod_custom', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_custom","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_CUSTOM_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (206, 'mod_feed', 'module', 'mod_feed', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_feed","type":"module","creationDate":"July 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_FEED_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (207, 'mod_footer', 'module', 'mod_footer', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_footer","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_FOOTER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (208, 'mod_login', 'module', 'mod_login', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_login","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LOGIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (209, 'mod_menu', 'module', 'mod_menu', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_menu","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_MENU_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (210, 'mod_articles_news', 'module', 'mod_articles_news', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_articles_news","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_ARTICLES_NEWS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (211, 'mod_random_image', 'module', 'mod_random_image', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_random_image","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_RANDOM_IMAGE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (212, 'mod_related_items', 'module', 'mod_related_items', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_related_items","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_RELATED_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (213, 'mod_search', 'module', 'mod_search', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_search","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_SEARCH_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (214, 'mod_stats', 'module', 'mod_stats', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_stats","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_STATS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (215, 'mod_syndicate', 'module', 'mod_syndicate', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_syndicate","type":"module","creationDate":"May 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_SYNDICATE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (216, 'mod_users_latest', 'module', 'mod_users_latest', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_users_latest","type":"module","creationDate":"December 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_USERS_LATEST_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (217, 'mod_weblinks', 'module', 'mod_weblinks', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_weblinks","type":"module","creationDate":"July 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_WEBLINKS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (218, 'mod_whosonline', 'module', 'mod_whosonline', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_whosonline","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_WHOSONLINE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (219, 'mod_wrapper', 'module', 'mod_wrapper', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_wrapper","type":"module","creationDate":"October 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_WRAPPER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (220, 'mod_articles_category', 'module', 'mod_articles_category', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_articles_category","type":"module","creationDate":"February 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_ARTICLES_CATEGORY_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (221, 'mod_articles_categories', 'module', 'mod_articles_categories', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_articles_categories","type":"module","creationDate":"February 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_ARTICLES_CATEGORIES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (222, 'mod_languages', 'module', 'mod_languages', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_languages","type":"module","creationDate":"February 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LANGUAGES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (223, 'mod_finder', 'module', 'mod_finder', '', 0, 1, 0, 0, '{"legacy":false,"name":"mod_finder","type":"module","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_FINDER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (300, 'mod_custom', 'module', 'mod_custom', '', 1, 1, 1, 1, '{"legacy":false,"name":"mod_custom","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_CUSTOM_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (301, 'mod_feed', 'module', 'mod_feed', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_feed","type":"module","creationDate":"July 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_FEED_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (302, 'mod_latest', 'module', 'mod_latest', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_latest","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LATEST_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (303, 'mod_logged', 'module', 'mod_logged', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_logged","type":"module","creationDate":"January 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LOGGED_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (304, 'mod_login', 'module', 'mod_login', '', 1, 1, 1, 1, '{"legacy":false,"name":"mod_login","type":"module","creationDate":"March 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LOGIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (305, 'mod_menu', 'module', 'mod_menu', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_menu","type":"module","creationDate":"March 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_MENU_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (307, 'mod_popular', 'module', 'mod_popular', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_popular","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_POPULAR_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (308, 'mod_quickicon', 'module', 'mod_quickicon', '', 1, 1, 1, 1, '{"legacy":false,"name":"mod_quickicon","type":"module","creationDate":"Nov 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_QUICKICON_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (309, 'mod_status', 'module', 'mod_status', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_status","type":"module","creationDate":"Feb 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_STATUS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (310, 'mod_submenu', 'module', 'mod_submenu', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_submenu","type":"module","creationDate":"Feb 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_SUBMENU_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (311, 'mod_title', 'module', 'mod_title', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_title","type":"module","creationDate":"Nov 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_TITLE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (312, 'mod_toolbar', 'module', 'mod_toolbar', '', 1, 1, 1, 1, '{"legacy":false,"name":"mod_toolbar","type":"module","creationDate":"Nov 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_TOOLBAR_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (313, 'mod_multilangstatus', 'module', 'mod_multilangstatus', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_multilangstatus","type":"module","creationDate":"September 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_MULTILANGSTATUS_XML_DESCRIPTION","group":""}', '{"cache":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (314, 'mod_version', 'module', 'mod_version', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_version","type":"module","creationDate":"January 2012","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_VERSION_XML_DESCRIPTION","group":""}', '{"format":"short","product":"1","cache":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (400, 'plg_authentication_gmail', 'plugin', 'gmail', 'authentication', 0, 0, 1, 0, '{"legacy":false,"name":"plg_authentication_gmail","type":"plugin","creationDate":"February 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_GMAIL_XML_DESCRIPTION","group":""}', '{"applysuffix":"0","suffix":"","verifypeer":"1","user_blacklist":""}', '', '', 0, '0000-00-00 00:00:00', 1, 0);
INSERT INTO `jom_extensions` VALUES (401, 'plg_authentication_joomla', 'plugin', 'joomla', 'authentication', 0, 1, 1, 1, '{"legacy":false,"name":"plg_authentication_joomla","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_AUTH_JOOMLA_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (402, 'plg_authentication_ldap', 'plugin', 'ldap', 'authentication', 0, 0, 1, 0, '{"legacy":false,"name":"plg_authentication_ldap","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_LDAP_XML_DESCRIPTION","group":""}', '{"host":"","port":"389","use_ldapV3":"0","negotiate_tls":"0","no_referrals":"0","auth_method":"bind","base_dn":"","search_string":"","users_dn":"","username":"admin","password":"bobby7","ldap_fullname":"fullName","ldap_email":"mail","ldap_uid":"uid"}', '', '', 0, '0000-00-00 00:00:00', 3, 0);
INSERT INTO `jom_extensions` VALUES (404, 'plg_content_emailcloak', 'plugin', 'emailcloak', 'content', 0, 1, 1, 0, '{"legacy":false,"name":"plg_content_emailcloak","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CONTENT_EMAILCLOAK_XML_DESCRIPTION","group":""}', '{"mode":"1"}', '', '', 0, '0000-00-00 00:00:00', 1, 0);
INSERT INTO `jom_extensions` VALUES (405, 'plg_content_geshi', 'plugin', 'geshi', 'content', 0, 0, 1, 0, '{"legacy":false,"name":"plg_content_geshi","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"","authorUrl":"qbnz.com\\/highlighter","version":"2.5.0","description":"PLG_CONTENT_GESHI_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 2, 0);
INSERT INTO `jom_extensions` VALUES (406, 'plg_content_loadmodule', 'plugin', 'loadmodule', 'content', 0, 1, 1, 0, '{"legacy":false,"name":"plg_content_loadmodule","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_LOADMODULE_XML_DESCRIPTION","group":""}', '{"style":"xhtml"}', '', '', 0, '2011-09-18 15:22:50', 0, 0);
INSERT INTO `jom_extensions` VALUES (407, 'plg_content_pagebreak', 'plugin', 'pagebreak', 'content', 0, 1, 1, 1, '{"legacy":false,"name":"plg_content_pagebreak","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CONTENT_PAGEBREAK_XML_DESCRIPTION","group":""}', '{"title":"1","multipage_toc":"1","showall":"1"}', '', '', 0, '0000-00-00 00:00:00', 4, 0);
INSERT INTO `jom_extensions` VALUES (408, 'plg_content_pagenavigation', 'plugin', 'pagenavigation', 'content', 0, 1, 1, 1, '{"legacy":false,"name":"plg_content_pagenavigation","type":"plugin","creationDate":"January 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_PAGENAVIGATION_XML_DESCRIPTION","group":""}', '{"position":"1"}', '', '', 0, '0000-00-00 00:00:00', 5, 0);
INSERT INTO `jom_extensions` VALUES (409, 'plg_content_vote', 'plugin', 'vote', 'content', 0, 1, 1, 1, '{"legacy":false,"name":"plg_content_vote","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_VOTE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 6, 0);
INSERT INTO `jom_extensions` VALUES (410, 'plg_editors_codemirror', 'plugin', 'codemirror', 'editors', 0, 1, 1, 1, '{"legacy":false,"name":"plg_editors_codemirror","type":"plugin","creationDate":"28 March 2011","author":"Marijn Haverbeke","copyright":"","authorEmail":"N\\/A","authorUrl":"","version":"1.0","description":"PLG_CODEMIRROR_XML_DESCRIPTION","group":""}', '{"linenumbers":"0","tabmode":"indent"}', '', '', 0, '0000-00-00 00:00:00', 1, 0);
INSERT INTO `jom_extensions` VALUES (411, 'plg_editors_none', 'plugin', 'none', 'editors', 0, 1, 1, 1, '{"legacy":false,"name":"plg_editors_none","type":"plugin","creationDate":"August 2004","author":"Unknown","copyright":"","authorEmail":"N\\/A","authorUrl":"","version":"2.5.0","description":"PLG_NONE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 2, 0);
INSERT INTO `jom_extensions` VALUES (412, 'plg_editors_tinymce', 'plugin', 'tinymce', 'editors', 0, 1, 1, 1, '{"legacy":false,"name":"plg_editors_tinymce","type":"plugin","creationDate":"2005-2012","author":"Moxiecode Systems AB","copyright":"Moxiecode Systems AB","authorEmail":"N\\/A","authorUrl":"tinymce.moxiecode.com\\/","version":"3.5.2","description":"PLG_TINY_XML_DESCRIPTION","group":""}', '{"mode":"1","skin":"0","entity_encoding":"raw","lang_mode":"0","lang_code":"en","text_direction":"ltr","content_css":"1","content_css_custom":"","relative_urls":"1","newlines":"0","invalid_elements":"script,applet,iframe","extended_elements":"","toolbar":"top","toolbar_align":"left","html_height":"550","html_width":"750","resizing":"true","resize_horizontal":"false","element_path":"1","fonts":"1","paste":"1","searchreplace":"1","insertdate":"1","format_date":"%Y-%m-%d","inserttime":"1","format_time":"%H:%M:%S","colors":"1","table":"1","smilies":"1","media":"1","hr":"1","directionality":"1","fullscreen":"1","style":"1","layer":"1","xhtmlxtras":"1","visualchars":"1","nonbreaking":"1","template":"1","blockquote":"1","wordcount":"1","advimage":"1","advlink":"1","advlist":"1","autosave":"1","contextmenu":"1","inlinepopups":"1","custom_plugin":"","custom_button":""}', '', '', 0, '0000-00-00 00:00:00', 3, 0);
INSERT INTO `jom_extensions` VALUES (413, 'plg_editors-xtd_article', 'plugin', 'article', 'editors-xtd', 0, 1, 1, 1, '{"legacy":false,"name":"plg_editors-xtd_article","type":"plugin","creationDate":"October 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_ARTICLE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 1, 0);
INSERT INTO `jom_extensions` VALUES (414, 'plg_editors-xtd_image', 'plugin', 'image', 'editors-xtd', 0, 1, 1, 0, '{"legacy":false,"name":"plg_editors-xtd_image","type":"plugin","creationDate":"August 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_IMAGE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 2, 0);
INSERT INTO `jom_extensions` VALUES (415, 'plg_editors-xtd_pagebreak', 'plugin', 'pagebreak', 'editors-xtd', 0, 1, 1, 0, '{"legacy":false,"name":"plg_editors-xtd_pagebreak","type":"plugin","creationDate":"August 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_EDITORSXTD_PAGEBREAK_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 3, 0);
INSERT INTO `jom_extensions` VALUES (416, 'plg_editors-xtd_readmore', 'plugin', 'readmore', 'editors-xtd', 0, 1, 1, 0, '{"legacy":false,"name":"plg_editors-xtd_readmore","type":"plugin","creationDate":"March 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_READMORE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 4, 0);
INSERT INTO `jom_extensions` VALUES (417, 'plg_search_categories', 'plugin', 'categories', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_categories","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_CATEGORIES_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (418, 'plg_search_contacts', 'plugin', 'contacts', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_contacts","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_CONTACTS_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (419, 'plg_search_content', 'plugin', 'content', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_content","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_CONTENT_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (420, 'plg_search_newsfeeds', 'plugin', 'newsfeeds', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_newsfeeds","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_NEWSFEEDS_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (421, 'plg_search_weblinks', 'plugin', 'weblinks', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_weblinks","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_WEBLINKS_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (422, 'plg_system_languagefilter', 'plugin', 'languagefilter', 'system', 0, 0, 1, 1, '{"legacy":false,"name":"plg_system_languagefilter","type":"plugin","creationDate":"July 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SYSTEM_LANGUAGEFILTER_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 1, 0);
INSERT INTO `jom_extensions` VALUES (423, 'plg_system_p3p', 'plugin', 'p3p', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_p3p","type":"plugin","creationDate":"September 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_P3P_XML_DESCRIPTION","group":""}', '{"headers":"NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"}', '', '', 0, '0000-00-00 00:00:00', 2, 0);
INSERT INTO `jom_extensions` VALUES (424, 'plg_system_cache', 'plugin', 'cache', 'system', 0, 0, 1, 1, '{"legacy":false,"name":"plg_system_cache","type":"plugin","creationDate":"February 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CACHE_XML_DESCRIPTION","group":""}', '{"browsercache":"0","cachetime":"15"}', '', '', 0, '0000-00-00 00:00:00', 9, 0);
INSERT INTO `jom_extensions` VALUES (425, 'plg_system_debug', 'plugin', 'debug', 'system', 0, 1, 1, 0, '{"legacy":false,"name":"plg_system_debug","type":"plugin","creationDate":"December 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_DEBUG_XML_DESCRIPTION","group":""}', '{"profile":"1","queries":"1","memory":"1","language_files":"1","language_strings":"1","strip-first":"1","strip-prefix":"","strip-suffix":""}', '', '', 0, '0000-00-00 00:00:00', 4, 0);
INSERT INTO `jom_extensions` VALUES (426, 'plg_system_log', 'plugin', 'log', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_log","type":"plugin","creationDate":"April 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_LOG_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 5, 0);
INSERT INTO `jom_extensions` VALUES (427, 'plg_system_redirect', 'plugin', 'redirect', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_redirect","type":"plugin","creationDate":"April 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_REDIRECT_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 6, 0);
INSERT INTO `jom_extensions` VALUES (428, 'plg_system_remember', 'plugin', 'remember', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_remember","type":"plugin","creationDate":"April 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_REMEMBER_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 7, 0);
INSERT INTO `jom_extensions` VALUES (429, 'plg_system_sef', 'plugin', 'sef', 'system', 0, 1, 1, 0, '{"legacy":false,"name":"plg_system_sef","type":"plugin","creationDate":"December 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEF_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 8, 0);
INSERT INTO `jom_extensions` VALUES (430, 'plg_system_logout', 'plugin', 'logout', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_logout","type":"plugin","creationDate":"April 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SYSTEM_LOGOUT_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 3, 0);
INSERT INTO `jom_extensions` VALUES (431, 'plg_user_contactcreator', 'plugin', 'contactcreator', 'user', 0, 0, 1, 1, '{"legacy":false,"name":"plg_user_contactcreator","type":"plugin","creationDate":"August 2009","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CONTACTCREATOR_XML_DESCRIPTION","group":""}', '{"autowebpage":"","category":"34","autopublish":"0"}', '', '', 0, '0000-00-00 00:00:00', 1, 0);
INSERT INTO `jom_extensions` VALUES (432, 'plg_user_joomla', 'plugin', 'joomla', 'user', 0, 1, 1, 0, '{"legacy":false,"name":"plg_user_joomla","type":"plugin","creationDate":"December 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2009 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_USER_JOOMLA_XML_DESCRIPTION","group":""}', '{"autoregister":"1"}', '', '', 0, '0000-00-00 00:00:00', 2, 0);
INSERT INTO `jom_extensions` VALUES (433, 'plg_user_profile', 'plugin', 'profile', 'user', 0, 0, 1, 1, '{"legacy":false,"name":"plg_user_profile","type":"plugin","creationDate":"January 2008","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_USER_PROFILE_XML_DESCRIPTION","group":""}', '{"register-require_address1":"1","register-require_address2":"1","register-require_city":"1","register-require_region":"1","register-require_country":"1","register-require_postal_code":"1","register-require_phone":"1","register-require_website":"1","register-require_favoritebook":"1","register-require_aboutme":"1","register-require_tos":"1","register-require_dob":"1","profile-require_address1":"1","profile-require_address2":"1","profile-require_city":"1","profile-require_region":"1","profile-require_country":"1","profile-require_postal_code":"1","profile-require_phone":"1","profile-require_website":"1","profile-require_favoritebook":"1","profile-require_aboutme":"1","profile-require_tos":"1","profile-require_dob":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (434, 'plg_extension_joomla', 'plugin', 'joomla', 'extension', 0, 1, 1, 1, '{"legacy":false,"name":"plg_extension_joomla","type":"plugin","creationDate":"May 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_EXTENSION_JOOMLA_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 1, 0);
INSERT INTO `jom_extensions` VALUES (435, 'plg_content_joomla', 'plugin', 'joomla', 'content', 0, 1, 1, 0, '{"legacy":false,"name":"plg_content_joomla","type":"plugin","creationDate":"November 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CONTENT_JOOMLA_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (436, 'plg_system_languagecode', 'plugin', 'languagecode', 'system', 0, 0, 1, 0, '{"legacy":false,"name":"plg_system_languagecode","type":"plugin","creationDate":"November 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SYSTEM_LANGUAGECODE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 10, 0);
INSERT INTO `jom_extensions` VALUES (437, 'plg_quickicon_joomlaupdate', 'plugin', 'joomlaupdate', 'quickicon', 0, 1, 1, 1, '{"legacy":false,"name":"plg_quickicon_joomlaupdate","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_QUICKICON_JOOMLAUPDATE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (438, 'plg_quickicon_extensionupdate', 'plugin', 'extensionupdate', 'quickicon', 0, 1, 1, 1, '{"legacy":false,"name":"plg_quickicon_extensionupdate","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_QUICKICON_EXTENSIONUPDATE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (439, 'plg_captcha_recaptcha', 'plugin', 'recaptcha', 'captcha', 0, 1, 1, 0, '{"legacy":false,"name":"plg_captcha_recaptcha","type":"plugin","creationDate":"December 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CAPTCHA_RECAPTCHA_XML_DESCRIPTION","group":""}', '{"public_key":"","private_key":"","theme":"clean"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (440, 'plg_system_highlight', 'plugin', 'highlight', 'system', 0, 1, 1, 0, '{"legacy":false,"name":"plg_system_highlight","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SYSTEM_HIGHLIGHT_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 7, 0);
INSERT INTO `jom_extensions` VALUES (441, 'plg_content_finder', 'plugin', 'finder', 'content', 0, 0, 1, 0, '{"legacy":false,"name":"plg_content_finder","type":"plugin","creationDate":"December 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CONTENT_FINDER_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (442, 'plg_finder_categories', 'plugin', 'categories', 'finder', 0, 1, 1, 0, '{"legacy":false,"name":"plg_finder_categories","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_FINDER_CATEGORIES_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 1, 0);
INSERT INTO `jom_extensions` VALUES (443, 'plg_finder_contacts', 'plugin', 'contacts', 'finder', 0, 1, 1, 0, '{"legacy":false,"name":"plg_finder_contacts","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_FINDER_CONTACTS_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 2, 0);
INSERT INTO `jom_extensions` VALUES (444, 'plg_finder_content', 'plugin', 'content', 'finder', 0, 1, 1, 0, '{"legacy":false,"name":"plg_finder_content","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_FINDER_CONTENT_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 3, 0);
INSERT INTO `jom_extensions` VALUES (445, 'plg_finder_newsfeeds', 'plugin', 'newsfeeds', 'finder', 0, 1, 1, 0, '{"legacy":false,"name":"plg_finder_newsfeeds","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_FINDER_NEWSFEEDS_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 4, 0);
INSERT INTO `jom_extensions` VALUES (446, 'plg_finder_weblinks', 'plugin', 'weblinks', 'finder', 0, 1, 1, 0, '{"legacy":false,"name":"plg_finder_weblinks","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_FINDER_WEBLINKS_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 5, 0);
INSERT INTO `jom_extensions` VALUES (500, 'atomic', 'template', 'atomic', '', 0, 1, 1, 0, '{"legacy":false,"name":"atomic","type":"template","creationDate":"10\\/10\\/09","author":"Ron Severdia","copyright":"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.","authorEmail":"contact@kontentdesign.com","authorUrl":"http:\\/\\/www.kontentdesign.com","version":"2.5.0","description":"TPL_ATOMIC_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (502, 'bluestork', 'template', 'bluestork', '', 1, 1, 1, 0, '{"legacy":false,"name":"bluestork","type":"template","creationDate":"07\\/02\\/09","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"TPL_BLUESTORK_XML_DESCRIPTION","group":""}', '{"useRoundedCorners":"1","showSiteName":"0","textBig":"0","highContrast":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (503, 'beez_20', 'template', 'beez_20', '', 0, 1, 1, 0, '{"legacy":false,"name":"beez_20","type":"template","creationDate":"25 November 2009","author":"Angie Radtke","copyright":"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.","authorEmail":"a.radtke@derauftritt.de","authorUrl":"http:\\/\\/www.der-auftritt.de","version":"2.5.0","description":"TPL_BEEZ2_XML_DESCRIPTION","group":""}', '{"wrapperSmall":"53","wrapperLarge":"72","sitetitle":"","sitedescription":"","navposition":"center","templatecolor":"nature"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (504, 'hathor', 'template', 'hathor', '', 1, 1, 1, 0, '{"legacy":false,"name":"hathor","type":"template","creationDate":"May 2010","author":"Andrea Tarr","copyright":"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.","authorEmail":"hathor@tarrconsulting.com","authorUrl":"http:\\/\\/www.tarrconsulting.com","version":"2.5.0","description":"TPL_HATHOR_XML_DESCRIPTION","group":""}', '{"showSiteName":"0","colourChoice":"0","boldText":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (505, 'beez5', 'template', 'beez5', '', 0, 1, 1, 0, '{"legacy":false,"name":"beez5","type":"template","creationDate":"21 May 2010","author":"Angie Radtke","copyright":"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.","authorEmail":"a.radtke@derauftritt.de","authorUrl":"http:\\/\\/www.der-auftritt.de","version":"2.5.0","description":"TPL_BEEZ5_XML_DESCRIPTION","group":""}', '{"wrapperSmall":"53","wrapperLarge":"72","sitetitle":"","sitedescription":"","navposition":"center","html5":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (600, 'English (United Kingdom)', 'language', 'en-GB', '', 0, 1, 1, 1, '{"legacy":false,"name":"English (United Kingdom)","type":"language","creationDate":"2008-03-15","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.5","description":"en-GB site language","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (601, 'English (United Kingdom)', 'language', 'en-GB', '', 1, 1, 1, 1, '{"legacy":false,"name":"English (United Kingdom)","type":"language","creationDate":"2008-03-15","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.5","description":"en-GB administrator language","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (700, 'files_joomla', 'file', 'joomla', '', 0, 1, 1, 1, '{"legacy":false,"name":"files_joomla","type":"file","creationDate":"June 2012","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.6","description":"FILES_JOOMLA_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (800, 'PKG_JOOMLA', 'package', 'pkg_joomla', '', 0, 1, 1, 1, '{"legacy":false,"name":"PKG_JOOMLA","type":"package","creationDate":"2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"http:\\/\\/www.joomla.org","version":"2.5.0","description":"PKG_JOOMLA_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (10000, 'jacc', 'component', 'com_jacc', '', 1, 1, 0, 0, '{"legacy":true,"name":"Jacc","type":"component","creationDate":"2011-07-13","author":"Michael Liebler","copyright":"Copyright (C) 2010 mliebler Open Source Matters. All rights\\n\\t\\treserved.","authorEmail":"michael-liebler@janguo.de","authorUrl":"http:\\/\\/www..janguo.de","version":"1.1.4","description":"Just another component creator","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (10007, 'rednet', 'component', 'com_rednet', '', 1, 1, 0, 0, '{"legacy":true,"name":"Rednet","type":"component","creationDate":"2012-08-24","author":"Unknown","copyright":"Copyright (C) 2012  Open Source Matters. All rights reserved.","authorEmail":"","authorUrl":"","version":"1.0","description":"The Red-Net component. Developed by Turnkey Solutions.","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (10002, 'System - Component Content Control', 'plugin', 'comcontrol', 'system', 0, 1, 1, 0, '{"legacy":false,"name":"System - Component Content Control","type":"plugin","creationDate":"Feb 23 2012","author":"Roger Noar","copyright":"Copyright (C) 2012 Roger Noar. All rights reserved.","authorEmail":"webmaster@rayonics.com","authorUrl":"www.rayonics.com","version":"1.61","description":"\\n\\tComponent Content Control V1.61 - For Joomla 1.6, 1.7 and 2.5 websites. Do not use with Joomla 1.5 websites.\\n\\tThis plugin allows you to specify the pages of particular components that are visible to guests\\n\\tversus those pages that require the user to login first.\\n\\tTo use this extension, be sure to first set the components that you wish to control to ''public'' in the component''s administration page.\\n\\tThen enter the parameters here so that Component Content Control will control whether the component pages are public vs private.\\n\\tFor components where you want most of the pages to be public, but have some private pages (requires login) -\\n\\tput those component names in the Mostly Public Components parameter.\\n\\tThe component name is the part of the url that comes after ''\\/index.php?option='' . For example, for MyBlog, it is ''com_myblog'' .\\n\\tIf you have an SEF component installed, you may want to temporarily disable it so that you can see the component name in the url for the page.\\n\\tYou can enter several component names, just leave a space between them.\\n\\tThen enter the ''Private Tags'' (url fragments) for the Mostly Public component pages that you want to make private - for example: article&id=1&Itemid=53 or blogger=Roger  etc.\\n\\tYou can enter several tags, just leave a space between them. This is case-sensitive, so be sure capital letters are correct!\\n\\tFor components where you want most of the pages to be private (require login), but have some public pages -\\n\\tput those component names in the Mostly Private Components parameter.\\n\\tYou can enter several component names, just leave a space between them.\\n\\tThen enter the ''Public Tags'' (url fragments) for the Mostly Private component pages that you want to make public.\\n\\tYou can use both the Mostly Public and Mostly Private parameters - of course, do not enter the same component name in both the Mostly Public\\n\\tand Mostly Private parameters.\\n\\t","group":""}', '{"com_name1":"","com_substring1":"","com_name2":"","com_substring2":"","com_message":"","com_redirect_url":"","com_debug":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (10003, 'com_frontenduseraccess', 'component', 'com_frontenduseraccess', '', 1, 1, 0, 0, '{"legacy":false,"name":"COM_FRONTENDUSERACCESS","type":"component","creationDate":"June 2012","author":"Carsten Engel","copyright":"Copyright 2008-2012 (C) Carsten Engel - Engelweb. All rights reserved.","authorEmail":"","authorUrl":"www.pages-and-items.com","version":"4.1.6","description":"COM_FRONTENDUSERACCESS_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (10004, 'System - Frontend User Access', 'plugin', 'frontenduseraccess', 'system', 0, 1, 1, 0, '{"legacy":false,"name":"System - Frontend User Access","type":"plugin","creationDate":"febuari 2011","author":"Carsten Engel","copyright":"Copyright (C) 2011 Carsten Engel, pages-and-items","authorEmail":"-","authorUrl":"www.pages-and-items.com","version":"4.0.0","description":"Enforces various access restrictions as set in component Frontend-User-Access. Don''t forget to ENABLE this plugin. Make sure this plugin is first in the plugin order of the system plugins.","group":""}', '', '', '', 0, '0000-00-00 00:00:00', -29000, 0);
INSERT INTO `jom_extensions` VALUES (10005, 'User - Frontend User Access', 'plugin', 'frontenduseraccess', 'user', 0, 1, 1, 0, '{"legacy":false,"name":"User - Frontend User Access","type":"plugin","creationDate":"febuari 2011","author":"Carsten Engel","copyright":"Copyright 2011 (C) Carsten Engel - Engelweb. All rights reserved.","authorEmail":"-","authorUrl":"www.pages-and-items.com","version":"4.0.0","description":"Sets the default Frontend-User-Access usergroup for new users, and redirects users on login from the frontend, as set in the Frontend-User-Access configuration.","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `jom_extensions` VALUES (10006, 'templatename', 'template', 'templatename', '', 0, 1, 1, 0, '{"legacy":false,"name":"templatename","type":"template","creationDate":"xxxx-xx-xx","author":"your name","copyright":"Copyright \\u00a9 xxxx example.com","authorEmail":"your.name@example.com","authorUrl":"http:\\/\\/www.example.com","version":"1.2.0","description":" \\n\\t\\t<h1>templatename<\\/h1>\\n\\t\\t<p><img src=\\"..\\/templates\\/templatename\\/template_preview.png\\" \\/><\\/p>\\n\\t\\t<h2>Module positions<\\/h2>\\n\\t\\t<ol>\\n\\t\\t\\t<li>debug<\\/li>\\n\\t\\t<\\/ol>\\n\\t\\t<p>Created by <a href=\\"http:\\/\\/www.example.com\\" target=\\"_blank\\">your name | example.com<\\/a>.<\\/p>\\n\\t","group":""}', '{"modernizr":"1","bootstrap":"0","pie":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_filters`
-- 

DROP TABLE IF EXISTS `jom_finder_filters`;
CREATE TABLE IF NOT EXISTS `jom_finder_filters` (
  `filter_id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL default '1',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  `created_by_alias` varchar(255) NOT NULL,
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `map_count` int(10) unsigned NOT NULL default '0',
  `data` text NOT NULL,
  `params` mediumtext,
  PRIMARY KEY  (`filter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_finder_filters`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links`
-- 

DROP TABLE IF EXISTS `jom_finder_links`;
CREATE TABLE IF NOT EXISTS `jom_finder_links` (
  `link_id` int(10) unsigned NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `title` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `indexdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `md5sum` varchar(32) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  `state` int(5) default '1',
  `access` int(5) default '0',
  `language` varchar(8) NOT NULL,
  `publish_start_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_end_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `list_price` double unsigned NOT NULL default '0',
  `sale_price` double unsigned NOT NULL default '0',
  `type_id` int(11) NOT NULL,
  `object` mediumblob NOT NULL,
  PRIMARY KEY  (`link_id`),
  KEY `idx_type` (`type_id`),
  KEY `idx_title` (`title`),
  KEY `idx_md5` (`md5sum`),
  KEY `idx_url` (`url`(75)),
  KEY `idx_published_list` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`list_price`),
  KEY `idx_published_sale` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`sale_price`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_finder_links`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms0`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms0`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms0` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms0`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms1`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms1`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms1` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms1`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms2`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms2`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms2` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms2`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms3`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms3`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms3` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms3`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms4`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms4`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms4` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms4`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms5`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms5`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms5` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms5`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms6`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms6`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms6` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms6`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms7`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms7`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms7` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms7`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms8`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms8`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms8` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms8`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_terms9`
-- 

DROP TABLE IF EXISTS `jom_finder_links_terms9`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_terms9` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_terms9`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_termsa`
-- 

DROP TABLE IF EXISTS `jom_finder_links_termsa`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_termsa` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_termsa`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_termsb`
-- 

DROP TABLE IF EXISTS `jom_finder_links_termsb`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_termsb` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_termsb`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_termsc`
-- 

DROP TABLE IF EXISTS `jom_finder_links_termsc`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_termsc` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_termsc`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_termsd`
-- 

DROP TABLE IF EXISTS `jom_finder_links_termsd`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_termsd` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_termsd`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_termse`
-- 

DROP TABLE IF EXISTS `jom_finder_links_termse`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_termse` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_termse`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_links_termsf`
-- 

DROP TABLE IF EXISTS `jom_finder_links_termsf`;
CREATE TABLE IF NOT EXISTS `jom_finder_links_termsf` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_links_termsf`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_taxonomy`
-- 

DROP TABLE IF EXISTS `jom_finder_taxonomy`;
CREATE TABLE IF NOT EXISTS `jom_finder_taxonomy` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `state` tinyint(1) unsigned NOT NULL default '1',
  `access` tinyint(1) unsigned NOT NULL default '0',
  `ordering` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `state` (`state`),
  KEY `ordering` (`ordering`),
  KEY `access` (`access`),
  KEY `idx_parent_published` (`parent_id`,`state`,`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jom_finder_taxonomy`
-- 

INSERT INTO `jom_finder_taxonomy` VALUES (1, 0, 'ROOT', 0, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_taxonomy_map`
-- 

DROP TABLE IF EXISTS `jom_finder_taxonomy_map`;
CREATE TABLE IF NOT EXISTS `jom_finder_taxonomy_map` (
  `link_id` int(10) unsigned NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`node_id`),
  KEY `link_id` (`link_id`),
  KEY `node_id` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_taxonomy_map`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_terms`
-- 

DROP TABLE IF EXISTS `jom_finder_terms`;
CREATE TABLE IF NOT EXISTS `jom_finder_terms` (
  `term_id` int(10) unsigned NOT NULL auto_increment,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL default '0',
  `phrase` tinyint(1) unsigned NOT NULL default '0',
  `weight` float unsigned NOT NULL default '0',
  `soundex` varchar(75) NOT NULL,
  `links` int(10) NOT NULL default '0',
  PRIMARY KEY  (`term_id`),
  UNIQUE KEY `idx_term` (`term`),
  KEY `idx_term_phrase` (`term`,`phrase`),
  KEY `idx_stem_phrase` (`stem`,`phrase`),
  KEY `idx_soundex_phrase` (`soundex`,`phrase`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_finder_terms`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_terms_common`
-- 

DROP TABLE IF EXISTS `jom_finder_terms_common`;
CREATE TABLE IF NOT EXISTS `jom_finder_terms_common` (
  `term` varchar(75) NOT NULL,
  `language` varchar(3) NOT NULL,
  KEY `idx_word_lang` (`term`,`language`),
  KEY `idx_lang` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_terms_common`
-- 

INSERT INTO `jom_finder_terms_common` VALUES ('a', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('about', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('after', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('ago', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('all', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('am', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('an', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('and', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('ani', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('any', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('are', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('aren''t', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('as', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('at', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('be', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('but', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('by', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('for', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('from', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('get', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('go', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('how', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('if', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('in', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('into', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('is', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('isn''t', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('it', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('its', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('me', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('more', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('most', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('must', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('my', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('new', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('no', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('none', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('not', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('noth', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('nothing', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('of', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('off', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('often', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('old', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('on', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('onc', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('once', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('onli', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('only', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('or', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('other', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('our', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('ours', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('out', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('over', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('page', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('she', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('should', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('small', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('so', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('some', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('than', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('thank', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('that', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('the', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('their', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('theirs', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('them', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('then', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('there', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('these', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('they', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('this', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('those', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('thus', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('time', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('times', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('to', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('too', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('true', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('under', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('until', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('up', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('upon', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('use', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('user', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('users', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('veri', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('version', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('very', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('via', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('want', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('was', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('way', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('were', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('what', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('when', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('where', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('whi', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('which', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('who', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('whom', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('whose', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('why', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('wide', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('will', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('with', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('within', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('without', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('would', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('yes', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('yet', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('you', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('your', 'en');
INSERT INTO `jom_finder_terms_common` VALUES ('yours', 'en');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_tokens`
-- 

DROP TABLE IF EXISTS `jom_finder_tokens`;
CREATE TABLE IF NOT EXISTS `jom_finder_tokens` (
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL default '0',
  `phrase` tinyint(1) unsigned NOT NULL default '0',
  `weight` float unsigned NOT NULL default '1',
  `context` tinyint(1) unsigned NOT NULL default '2',
  KEY `idx_word` (`term`),
  KEY `idx_context` (`context`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_tokens`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_tokens_aggregate`
-- 

DROP TABLE IF EXISTS `jom_finder_tokens_aggregate`;
CREATE TABLE IF NOT EXISTS `jom_finder_tokens_aggregate` (
  `term_id` int(10) unsigned NOT NULL,
  `map_suffix` char(1) NOT NULL,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL default '0',
  `phrase` tinyint(1) unsigned NOT NULL default '0',
  `term_weight` float unsigned NOT NULL,
  `context` tinyint(1) unsigned NOT NULL default '2',
  `context_weight` float unsigned NOT NULL,
  `total_weight` float unsigned NOT NULL,
  KEY `token` (`term`),
  KEY `keyword_id` (`term_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_finder_tokens_aggregate`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_finder_types`
-- 

DROP TABLE IF EXISTS `jom_finder_types`;
CREATE TABLE IF NOT EXISTS `jom_finder_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `mime` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_finder_types`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_categories`
-- 

DROP TABLE IF EXISTS `jom_fua_categories`;
CREATE TABLE IF NOT EXISTS `jom_fua_categories` (
  `id` int(11) NOT NULL auto_increment,
  `category_groupid` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_fua_categories`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_components`
-- 

DROP TABLE IF EXISTS `jom_fua_components`;
CREATE TABLE IF NOT EXISTS `jom_fua_components` (
  `id` int(11) NOT NULL auto_increment,
  `component_groupid` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

-- 
-- Dumping data for table `jom_fua_components`
-- 

INSERT INTO `jom_fua_components` VALUES (17, 'com_content__10');
INSERT INTO `jom_fua_components` VALUES (16, 'com_rednet__11');
INSERT INTO `jom_fua_components` VALUES (18, 'com_users__9');
INSERT INTO `jom_fua_components` VALUES (19, 'com_users__10');
INSERT INTO `jom_fua_components` VALUES (20, 'com_login__11');
INSERT INTO `jom_fua_components` VALUES (21, 'com_login__12');
INSERT INTO `jom_fua_components` VALUES (22, 'com_login__9');
INSERT INTO `jom_fua_components` VALUES (23, 'com_login__10');
INSERT INTO `jom_fua_components` VALUES (24, 'com_users__11');
INSERT INTO `jom_fua_components` VALUES (25, 'com_users__12');
INSERT INTO `jom_fua_components` VALUES (26, 'com_content__11');
INSERT INTO `jom_fua_components` VALUES (27, 'com_content__12');
INSERT INTO `jom_fua_components` VALUES (28, 'com_content__9');
INSERT INTO `jom_fua_components` VALUES (29, 'com_plugins__11');
INSERT INTO `jom_fua_components` VALUES (30, 'com_plugins__12');
INSERT INTO `jom_fua_components` VALUES (31, 'com_plugins__9');
INSERT INTO `jom_fua_components` VALUES (32, 'com_plugins__10');
INSERT INTO `jom_fua_components` VALUES (33, 'com_redirect__11');
INSERT INTO `jom_fua_components` VALUES (34, 'com_redirect__12');
INSERT INTO `jom_fua_components` VALUES (35, 'com_redirect__9');
INSERT INTO `jom_fua_components` VALUES (36, 'com_redirect__10');
INSERT INTO `jom_fua_components` VALUES (37, 'com_templates__11');
INSERT INTO `jom_fua_components` VALUES (38, 'com_templates__12');
INSERT INTO `jom_fua_components` VALUES (39, 'com_templates__9');
INSERT INTO `jom_fua_components` VALUES (40, 'com_templates__10');
INSERT INTO `jom_fua_components` VALUES (43, 'com_login__13');
INSERT INTO `jom_fua_components` VALUES (44, 'com_plugins__13');
INSERT INTO `jom_fua_components` VALUES (45, 'com_templates__13');
INSERT INTO `jom_fua_components` VALUES (46, 'com_users__13');
INSERT INTO `jom_fua_components` VALUES (47, 'com_content__13');
INSERT INTO `jom_fua_components` VALUES (48, 'com_rednet__12');
INSERT INTO `jom_fua_components` VALUES (49, 'com_rednet__13');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_config`
-- 

DROP TABLE IF EXISTS `jom_fua_config`;
CREATE TABLE IF NOT EXISTS `jom_fua_config` (
  `id` varchar(255) NOT NULL,
  `config` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_fua_config`
-- 

INSERT INTO `jom_fua_config` VALUES ('fua', 'default_usergroup=\r\nredirecting_enabled=true\r\nredirect_url=\r\nitems_active=\r\nitems_reverse_access=\r\nitems_multigroup_access_requirement=one_group\r\nitems_message_type=only_text\r\nno_item_access_full_url=index.php\r\nmessage_no_item_access_full=you have no permission to view this page\r\nmessage_no_item_access=\r\ntruncate_article_title=80\r\ncategories_active=\r\ncategory_reverse_access=\r\ncategory_multigroup_access_requirement=one_group\r\nmodules_active=true\r\nmodules_reverse_access=\r\nmodules_multigroup_access_requirement=one_group\r\nuse_componentaccess=true\r\ncomponent_reverse_access=\r\ncomponent_multigroup_access_requirement=one_group\r\ncomponents_message_type=redirect\r\nmessage_no_component_access=you have no permission to view this page\r\nno_component_access_url=./\r\nuse_menuaccess=\r\nmenu_reverse_access=\r\nmenu_multigroup_access_requirement=one_group\r\nmenuaccess_message_type=only_text\r\nmessage_no_menu_access=you have no permission to view this page\r\nno_menu_access_url=index.php\r\nenable_from_select_to_group=\r\nfrom_select_to_group=\r\nfua_enabled=1\r\nenable_from_select_to_group_update=\r\nfrom_select_to_group_update=\r\nversion_checker=true\r\ncontent_access_together=every_group\r\nparts_active=\r\nparts_reverse_access=\r\nparts_multigroup_access_requirement=one_group\r\nparts_not_active=as_access\r\nmod_menu_override=\r\n');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_items`
-- 

DROP TABLE IF EXISTS `jom_fua_items`;
CREATE TABLE IF NOT EXISTS `jom_fua_items` (
  `id` int(11) NOT NULL auto_increment,
  `itemid_groupid` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_fua_items`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_menuaccess`
-- 

DROP TABLE IF EXISTS `jom_fua_menuaccess`;
CREATE TABLE IF NOT EXISTS `jom_fua_menuaccess` (
  `id` int(11) NOT NULL auto_increment,
  `menuid_groupid` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_fua_menuaccess`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_modules_two`
-- 

DROP TABLE IF EXISTS `jom_fua_modules_two`;
CREATE TABLE IF NOT EXISTS `jom_fua_modules_two` (
  `id` int(11) NOT NULL auto_increment,
  `module_groupid` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_fua_modules_two`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_parts`
-- 

DROP TABLE IF EXISTS `jom_fua_parts`;
CREATE TABLE IF NOT EXISTS `jom_fua_parts` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `description` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_fua_parts`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_partsaccess`
-- 

DROP TABLE IF EXISTS `jom_fua_partsaccess`;
CREATE TABLE IF NOT EXISTS `jom_fua_partsaccess` (
  `id` int(11) NOT NULL auto_increment,
  `part_group` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_fua_partsaccess`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_usergroups`
-- 

DROP TABLE IF EXISTS `jom_fua_usergroups`;
CREATE TABLE IF NOT EXISTS `jom_fua_usergroups` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `url` tinytext NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- 
-- Dumping data for table `jom_fua_usergroups`
-- 

INSERT INTO `jom_fua_usergroups` VALUES (9, 'logged in', 'all logged in users who have not been assigned to any usergroup', '', 0);
INSERT INTO `jom_fua_usergroups` VALUES (10, 'not logged in', 'all users whom are not logged in', '', 0);
INSERT INTO `jom_fua_usergroups` VALUES (11, 'admin', 'user with admin role have access to main parts of site.', 'index.php/component/rednet/ordersoncalendar', 0);
INSERT INTO `jom_fua_usergroups` VALUES (12, 'crew_office', 'user with crew office role login....', 'index.php/component/rednet/ordersoncalendar', 0);
INSERT INTO `jom_fua_usergroups` VALUES (13, 'loader', 'the loader users of system', 'index.php/component/rednet/ordersoncalendar', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_fua_userindex`
-- 

DROP TABLE IF EXISTS `jom_fua_userindex`;
CREATE TABLE IF NOT EXISTS `jom_fua_userindex` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `group_id` varchar(5120) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=193 ;

-- 
-- Dumping data for table `jom_fua_userindex`
-- 

INSERT INTO `jom_fua_userindex` VALUES (2, 411, '"12"');
INSERT INTO `jom_fua_userindex` VALUES (3, 412, '"13"');
INSERT INTO `jom_fua_userindex` VALUES (21, 436, '"11"');
INSERT INTO `jom_fua_userindex` VALUES (192, 495, '"13"');
INSERT INTO `jom_fua_userindex` VALUES (177, 496, '"13"');
INSERT INTO `jom_fua_userindex` VALUES (188, 497, '"13"');
INSERT INTO `jom_fua_userindex` VALUES (59, 474, '"11"');
INSERT INTO `jom_fua_userindex` VALUES (186, 498, '"13"');
INSERT INTO `jom_fua_userindex` VALUES (190, 500, '"11"');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_jacc`
-- 

DROP TABLE IF EXISTS `jom_jacc`;
CREATE TABLE IF NOT EXISTS `jom_jacc` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `tables` text NOT NULL,
  `description` text NOT NULL,
  `use` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jom_jacc`
-- 

INSERT INTO `jom_jacc` VALUES (1, 'com_rednet', '1.0', '["#__orders","#__ordertype","#__resourcesmap","#__testpages","#__user_availabilitycalendar","#__vehicles_fleet","#__worker_role","#__workers"]', 'The Red-Net component. Developed by Turnkey Solutions.', 2, '2012-08-24 13:18:17', 1, '{"uses_categories":"0","export":"www"}', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_jacc_modules`
-- 

DROP TABLE IF EXISTS `jom_jacc_modules`;
CREATE TABLE IF NOT EXISTS `jom_jacc_modules` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `use` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_jacc_modules`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_jacc_packages`
-- 

DROP TABLE IF EXISTS `jom_jacc_packages`;
CREATE TABLE IF NOT EXISTS `jom_jacc_packages` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `packagerurl` varchar(150) NOT NULL,
  `updateurl` varchar(150) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_jacc_packages`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_jacc_plugins`
-- 

DROP TABLE IF EXISTS `jom_jacc_plugins`;
CREATE TABLE IF NOT EXISTS `jom_jacc_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `folder` varchar(45) NOT NULL,
  `use` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_jacc_plugins`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_jacc_templates`
-- 

DROP TABLE IF EXISTS `jom_jacc_templates`;
CREATE TABLE IF NOT EXISTS `jom_jacc_templates` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `use` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_jacc_templates`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_languages`
-- 

DROP TABLE IF EXISTS `jom_languages`;
CREATE TABLE IF NOT EXISTS `jom_languages` (
  `lang_id` int(11) unsigned NOT NULL auto_increment,
  `lang_code` char(7) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_native` varchar(50) NOT NULL,
  `sef` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `sitename` varchar(1024) NOT NULL default '',
  `published` int(11) NOT NULL default '0',
  `access` int(10) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`),
  UNIQUE KEY `idx_image` (`image`),
  UNIQUE KEY `idx_langcode` (`lang_code`),
  KEY `idx_access` (`access`),
  KEY `idx_ordering` (`ordering`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jom_languages`
-- 

INSERT INTO `jom_languages` VALUES (1, 'en-GB', 'English (UK)', 'English (UK)', 'en', 'en', '', '', '', '', 1, 0, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_menu`
-- 

DROP TABLE IF EXISTS `jom_menu`;
CREATE TABLE IF NOT EXISTS `jom_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(24) NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) NOT NULL default '',
  `path` varchar(1024) NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint(4) NOT NULL default '0' COMMENT 'The published state of the menu link.',
  `parent_id` int(10) unsigned NOT NULL default '1' COMMENT 'The parent menu item in the menu tree.',
  `level` int(10) unsigned NOT NULL default '0' COMMENT 'The relative level in the tree.',
  `component_id` int(10) unsigned NOT NULL default '0' COMMENT 'FK to #__extensions.id',
  `ordering` int(11) NOT NULL default '0' COMMENT 'The relative ordering of the menu item in the tree.',
  `checked_out` int(10) unsigned NOT NULL default '0' COMMENT 'FK to #__users.id',
  `checked_out_time` timestamp NOT NULL default '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint(4) NOT NULL default '0' COMMENT 'The click behaviour of the link.',
  `access` int(10) unsigned NOT NULL default '0' COMMENT 'The access level required to view the menu item.',
  `img` varchar(255) NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL default '0',
  `params` text NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL default '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL default '0' COMMENT 'Nested set rgt.',
  `home` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) NOT NULL default '',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_client_id_parent_id_alias_language` (`client_id`,`parent_id`,`alias`,`language`),
  KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  KEY `idx_menutype` (`menutype`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_path` (`path`(333)),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=139 ;

-- 
-- Dumping data for table `jom_menu`
-- 

INSERT INTO `jom_menu` VALUES (1, '', 'Menu_Item_Root', 0x726f6f74, '', '', '', '', 1, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 0, '', 0, '', 0, 89, 0, '*', 0);
INSERT INTO `jom_menu` VALUES (2, 'menu', 'com_banners', 0x42616e6e657273, '', 'Banners', 'index.php?option=com_banners', 'component', 0, 1, 1, 4, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners', 0, '', 1, 10, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (3, 'menu', 'com_banners', 0x42616e6e657273, '', 'Banners/Banners', 'index.php?option=com_banners', 'component', 0, 2, 2, 4, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners', 0, '', 2, 3, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (4, 'menu', 'com_banners_categories', 0x43617465676f72696573, '', 'Banners/Categories', 'index.php?option=com_categories&extension=com_banners', 'component', 0, 2, 2, 6, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners-cat', 0, '', 4, 5, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (5, 'menu', 'com_banners_clients', 0x436c69656e7473, '', 'Banners/Clients', 'index.php?option=com_banners&view=clients', 'component', 0, 2, 2, 4, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners-clients', 0, '', 6, 7, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (6, 'menu', 'com_banners_tracks', 0x547261636b73, '', 'Banners/Tracks', 'index.php?option=com_banners&view=tracks', 'component', 0, 2, 2, 4, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners-tracks', 0, '', 8, 9, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (7, 'menu', 'com_contact', 0x436f6e7461637473, '', 'Contacts', 'index.php?option=com_contact', 'component', 0, 1, 1, 8, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:contact', 0, '', 11, 16, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (8, 'menu', 'com_contact', 0x436f6e7461637473, '', 'Contacts/Contacts', 'index.php?option=com_contact', 'component', 0, 7, 2, 8, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:contact', 0, '', 12, 13, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (9, 'menu', 'com_contact_categories', 0x43617465676f72696573, '', 'Contacts/Categories', 'index.php?option=com_categories&extension=com_contact', 'component', 0, 7, 2, 6, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:contact-cat', 0, '', 14, 15, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (10, 'menu', 'com_messages', 0x4d6573736167696e67, '', 'Messaging', 'index.php?option=com_messages', 'component', 0, 1, 1, 15, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:messages', 0, '', 17, 22, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (11, 'menu', 'com_messages_add', 0x4e65772050726976617465204d657373616765, '', 'Messaging/New Private Message', 'index.php?option=com_messages&task=message.add', 'component', 0, 10, 2, 15, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:messages-add', 0, '', 18, 19, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (12, 'menu', 'com_messages_read', 0x526561642050726976617465204d657373616765, '', 'Messaging/Read Private Message', 'index.php?option=com_messages', 'component', 0, 10, 2, 15, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:messages-read', 0, '', 20, 21, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (13, 'menu', 'com_newsfeeds', 0x4e657773204665656473, '', 'News Feeds', 'index.php?option=com_newsfeeds', 'component', 0, 1, 1, 17, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:newsfeeds', 0, '', 23, 28, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (14, 'menu', 'com_newsfeeds_feeds', 0x4665656473, '', 'News Feeds/Feeds', 'index.php?option=com_newsfeeds', 'component', 0, 13, 2, 17, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:newsfeeds', 0, '', 24, 25, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (15, 'menu', 'com_newsfeeds_categories', 0x43617465676f72696573, '', 'News Feeds/Categories', 'index.php?option=com_categories&extension=com_newsfeeds', 'component', 0, 13, 2, 6, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:newsfeeds-cat', 0, '', 26, 27, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (16, 'menu', 'com_redirect', 0x5265646972656374, '', 'Redirect', 'index.php?option=com_redirect', 'component', 0, 1, 1, 24, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:redirect', 0, '', 43, 44, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (17, 'menu', 'com_search', 0x426173696320536561726368, '', 'Basic Search', 'index.php?option=com_search', 'component', 0, 1, 1, 19, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:search', 0, '', 33, 34, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (18, 'menu', 'com_weblinks', 0x5765626c696e6b73, '', 'Weblinks', 'index.php?option=com_weblinks', 'component', 0, 1, 1, 21, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:weblinks', 0, '', 35, 40, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (19, 'menu', 'com_weblinks_links', 0x4c696e6b73, '', 'Weblinks/Links', 'index.php?option=com_weblinks', 'component', 0, 18, 2, 21, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:weblinks', 0, '', 36, 37, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (20, 'menu', 'com_weblinks_categories', 0x43617465676f72696573, '', 'Weblinks/Categories', 'index.php?option=com_categories&extension=com_weblinks', 'component', 0, 18, 2, 6, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:weblinks-cat', 0, '', 38, 39, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (21, 'menu', 'com_finder', 0x536d61727420536561726368, '', 'Smart Search', 'index.php?option=com_finder', 'component', 0, 1, 1, 27, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:finder', 0, '', 31, 32, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (22, 'menu', 'com_joomlaupdate', 0x4a6f6f6d6c612120557064617465, '', 'Joomla! Update', 'index.php?option=com_joomlaupdate', 'component', 0, 1, 1, 28, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:joomlaupdate', 0, '', 41, 42, 0, '*', 1);
INSERT INTO `jom_menu` VALUES (101, 'mainmenu', 'Home', 0x686f6d65, '', 'home', 'index.php?option=com_content&view=featured', 'component', 1, 1, 1, 22, 0, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"featured_categories":[""],"num_leading_articles":"1","num_intro_articles":"3","num_columns":"3","num_links":"0","orderby_pri":"","orderby_sec":"front","order_date":"","multi_column_order":"1","show_pagination":"2","show_pagination_results":"1","show_noauth":"","article-allow_ratings":"","article-allow_comments":"","show_feed_link":"1","feed_summary":"","show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_readmore":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","show_page_heading":1,"page_title":"","page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 29, 30, 1, '*', 0);
INSERT INTO `jom_menu` VALUES (102, 'main', 'Jacc', 0x6a616363, '', 'jacc', 'index.php?option=com_jacc', 'component', 0, 1, 1, 10000, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 45, 58, 0, '', 1);
INSERT INTO `jom_menu` VALUES (103, 'main', 'Components', 0x636f6d706f6e656e7473, '', 'jacc/components', 'index.php?option=com_jacc&view=jacc', 'component', 0, 102, 2, 10000, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 46, 47, 0, '', 1);
INSERT INTO `jom_menu` VALUES (104, 'main', 'Modules', 0x6d6f64756c6573, '', 'jacc/modules', 'index.php?option=com_jacc&view=modules', 'component', 0, 102, 2, 10000, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 48, 49, 0, '', 1);
INSERT INTO `jom_menu` VALUES (105, 'main', 'Plugins', 0x706c7567696e73, '', 'jacc/plugins', 'index.php?option=com_jacc&view=plugins', 'component', 0, 102, 2, 10000, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 50, 51, 0, '', 1);
INSERT INTO `jom_menu` VALUES (106, 'main', 'Templates', 0x74656d706c61746573, '', 'jacc/templates', 'index.php?option=com_jacc&view=templates', 'component', 0, 102, 2, 10000, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 52, 53, 0, '', 1);
INSERT INTO `jom_menu` VALUES (107, 'main', 'Packages', 0x7061636b61676573, '', 'jacc/packages', 'index.php?option=com_jacc&view=packages', 'component', 0, 102, 2, 10000, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 54, 55, 0, '', 1);
INSERT INTO `jom_menu` VALUES (108, 'main', 'Howto', 0x686f77746f, '', 'jacc/howto', 'index.php?option=com_jacc&view=howto', 'component', 0, 102, 2, 10000, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 56, 57, 0, '', 1);
INSERT INTO `jom_menu` VALUES (137, 'main', 'Workers', 0x776f726b657273, '', 'rednet/workers', 'index.php?option=com_rednet&view=workers', 'component', 0, 135, 2, 10007, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 84, 85, 0, '', 1);
INSERT INTO `jom_menu` VALUES (138, 'main', 'Testvc', 0x746573747663, '', 'rednet/testvc', 'index.php?option=com_rednet&view=testvc', 'component', 0, 135, 2, 10007, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 86, 87, 0, '', 1);
INSERT INTO `jom_menu` VALUES (112, 'main', 'COM_FRONTENDUSERACCESS', 0x636f6d2d66726f6e74656e6475736572616363657373, '', 'com-frontenduseraccess', 'index.php?option=com_frontenduseraccess', 'component', 0, 1, 1, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'components/com_frontenduseraccess/images/icon.gif', 0, '', 59, 80, 0, '', 1);
INSERT INTO `jom_menu` VALUES (113, 'main', 'COM_FRONTENDUSERACCESS_CONFIG', 0x636f6d2d66726f6e74656e64757365726163636573732d636f6e666967, '', 'com-frontenduseraccess/com-frontenduseraccess-config', 'index.php?option=com_frontenduseraccess&view=config', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:config', 0, '', 60, 61, 0, '', 1);
INSERT INTO `jom_menu` VALUES (114, 'main', 'COM_FRONTENDUSERACCESS_USERGROUPS', 0x636f6d2d66726f6e74656e64757365726163636573732d7573657267726f757073, '', 'com-frontenduseraccess/com-frontenduseraccess-usergroups', 'index.php?option=com_frontenduseraccess&view=usergroups', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:groups', 0, '', 62, 63, 0, '', 1);
INSERT INTO `jom_menu` VALUES (115, 'main', 'COM_FRONTENDUSERACCESS_USERS', 0x636f6d2d66726f6e74656e64757365726163636573732d7573657273, '', 'com-frontenduseraccess/com-frontenduseraccess-users', 'index.php?option=com_frontenduseraccess&view=users', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:user', 0, '', 64, 65, 0, '', 1);
INSERT INTO `jom_menu` VALUES (116, 'main', 'COM_FRONTENDUSERACCESS_ITEM_ACCESS', 0x636f6d2d66726f6e74656e64757365726163636573732d6974656d2d616363657373, '', 'com-frontenduseraccess/com-frontenduseraccess-item-access', 'index.php?option=com_frontenduseraccess&view=items', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:article', 0, '', 66, 67, 0, '', 1);
INSERT INTO `jom_menu` VALUES (117, 'main', 'COM_FRONTENDUSERACCESS_CATEGORY_ACCESS', 0x636f6d2d66726f6e74656e64757365726163636573732d63617465676f72792d616363657373, '', 'com-frontenduseraccess/com-frontenduseraccess-category-access', 'index.php?option=com_frontenduseraccess&view=categories', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:category', 0, '', 68, 69, 0, '', 1);
INSERT INTO `jom_menu` VALUES (118, 'main', 'COM_FRONTENDUSERACCESS_MODULE_ACCESS', 0x636f6d2d66726f6e74656e64757365726163636573732d6d6f64756c652d616363657373, '', 'com-frontenduseraccess/com-frontenduseraccess-module-access', 'index.php?option=com_frontenduseraccess&view=modules', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:module', 0, '', 70, 71, 0, '', 1);
INSERT INTO `jom_menu` VALUES (119, 'main', 'COM_FRONTENDUSERACCESS_COMPONENT_ACCESS', 0x636f6d2d66726f6e74656e64757365726163636573732d636f6d706f6e656e742d616363657373, '', 'com-frontenduseraccess/com-frontenduseraccess-component-access', 'index.php?option=com_frontenduseraccess&view=components', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:menumgr', 0, '', 72, 73, 0, '', 1);
INSERT INTO `jom_menu` VALUES (120, 'main', 'COM_FRONTENDUSERACCESS_MENU_ACCESS', 0x636f6d2d66726f6e74656e64757365726163636573732d6d656e752d616363657373, '', 'com-frontenduseraccess/com-frontenduseraccess-menu-access', 'index.php?option=com_frontenduseraccess&view=menuaccess', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:menu', 0, '', 74, 75, 0, '', 1);
INSERT INTO `jom_menu` VALUES (121, 'main', 'COM_FRONTENDUSERACCESS_PART_ACCESS', 0x636f6d2d66726f6e74656e64757365726163636573732d706172742d616363657373, '', 'com-frontenduseraccess/com-frontenduseraccess-part-access', 'index.php?option=com_frontenduseraccess&view=parts', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:help-jrd', 0, '', 76, 77, 0, '', 1);
INSERT INTO `jom_menu` VALUES (122, 'main', 'COM_FRONTENDUSERACCESS_SUPPORT', 0x636f6d2d66726f6e74656e64757365726163636573732d737570706f7274, '', 'com-frontenduseraccess/com-frontenduseraccess-support', 'index.php?option=com_frontenduseraccess&view=support', 'component', 0, 112, 2, 10003, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:info', 0, '', 78, 79, 0, '', 1);
INSERT INTO `jom_menu` VALUES (136, 'main', 'Role', 0x726f6c65, '', 'rednet/role', 'index.php?option=com_rednet&view=role', 'component', 0, 135, 2, 10007, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 82, 83, 0, '', 1);
INSERT INTO `jom_menu` VALUES (135, 'main', 'Rednet', 0x7265646e6574, '', 'rednet', 'index.php?option=com_rednet', 'component', 0, 1, 1, 10007, 0, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '', 81, 88, 0, '', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_menu_types`
-- 

DROP TABLE IF EXISTS `jom_menu_types`;
CREATE TABLE IF NOT EXISTS `jom_menu_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `menutype` varchar(24) NOT NULL,
  `title` varchar(48) NOT NULL,
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `jom_menu_types`
-- 

INSERT INTO `jom_menu_types` VALUES (1, 'mainmenu', 'Main Menu', 'The main menu for the site');
INSERT INTO `jom_menu_types` VALUES (5, 'main', 'Red Net', 'main red net menu');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_messages`
-- 

DROP TABLE IF EXISTS `jom_messages`;
CREATE TABLE IF NOT EXISTS `jom_messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` tinyint(3) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL default '0',
  `priority` tinyint(1) unsigned NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_messages`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_messages_cfg`
-- 

DROP TABLE IF EXISTS `jom_messages_cfg`;
CREATE TABLE IF NOT EXISTS `jom_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_messages_cfg`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_modules`
-- 

DROP TABLE IF EXISTS `jom_modules`;
CREATE TABLE IF NOT EXISTS `jom_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(50) NOT NULL default '',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `access` int(10) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `client_id` tinyint(4) NOT NULL default '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;

-- 
-- Dumping data for table `jom_modules`
-- 

INSERT INTO `jom_modules` VALUES (1, 'Main Menu', '', '', 1, 'position-7', 409, '2012-08-29 12:13:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 1, 1, '{"menutype":"mainmenu","startLevel":"0","endLevel":"0","showAllChildren":"0","tag_id":"","class_sfx":"","window_open":"","layout":"","moduleclass_sfx":"_menu","cache":"1","cache_time":"900","cachemode":"itemid"}', 0, '*');
INSERT INTO `jom_modules` VALUES (2, 'Login', '', '', 1, 'login', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_login', 1, 1, '', 1, '*');
INSERT INTO `jom_modules` VALUES (3, 'Popular Articles', '', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_popular', 3, 1, '{"count":"5","catid":"","user_id":"0","layout":"_:default","moduleclass_sfx":"","cache":"0","automatic_title":"1"}', 1, '*');
INSERT INTO `jom_modules` VALUES (4, 'Recently Added Articles', '', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_latest', 3, 1, '{"count":"5","ordering":"c_dsc","catid":"","user_id":"0","layout":"_:default","moduleclass_sfx":"","cache":"0","automatic_title":"1"}', 1, '*');
INSERT INTO `jom_modules` VALUES (8, 'Toolbar', '', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_toolbar', 3, 1, '', 1, '*');
INSERT INTO `jom_modules` VALUES (9, 'Quick Icons', '', '', 1, 'icon', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_quickicon', 3, 1, '', 1, '*');
INSERT INTO `jom_modules` VALUES (10, 'Logged-in Users', '', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_logged', 3, 1, '{"count":"5","name":"1","layout":"_:default","moduleclass_sfx":"","cache":"0","automatic_title":"1"}', 1, '*');
INSERT INTO `jom_modules` VALUES (12, 'Admin Menu', '', '', 1, 'menu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 3, 1, '{"layout":"","moduleclass_sfx":"","shownew":"1","showhelp":"1","cache":"0"}', 1, '*');
INSERT INTO `jom_modules` VALUES (13, 'Admin Submenu', '', '', 1, 'submenu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_submenu', 3, 1, '', 1, '*');
INSERT INTO `jom_modules` VALUES (14, 'User Status', '', '', 2, 'status', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_status', 3, 1, '', 1, '*');
INSERT INTO `jom_modules` VALUES (15, 'Title', '', '', 1, 'title', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_title', 3, 1, '', 1, '*');
INSERT INTO `jom_modules` VALUES (16, 'Login Form', '', '', 7, 'position-7', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_login', 1, 1, '{"greeting":"1","name":"0"}', 0, '*');
INSERT INTO `jom_modules` VALUES (17, 'Breadcrumbs', '', '', 1, 'position-2', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_breadcrumbs', 1, 1, '{"moduleclass_sfx":"","showHome":"1","homeText":"Home","showComponent":"1","separator":"","cache":"1","cache_time":"900","cachemode":"itemid"}', 0, '*');
INSERT INTO `jom_modules` VALUES (79, 'Multilanguage status', '', '', 1, 'status', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_multilangstatus', 3, 1, '{"layout":"_:default","moduleclass_sfx":"","cache":"0"}', 1, '*');
INSERT INTO `jom_modules` VALUES (86, 'Joomla Version', '', '', 1, 'footer', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_version', 3, 1, '{"format":"short","product":"1","layout":"_:default","moduleclass_sfx":"","cache":"0"}', 1, '*');
INSERT INTO `jom_modules` VALUES (87, 'test module', '', '<p>this is text of test module</p>', 0, 'atomic-sidebar', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', -2, 'mod_custom', 1, 0, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*');
INSERT INTO `jom_modules` VALUES (88, 'rednet login', '', '', 0, 'atomic-login-position', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_login', 1, 0, '{"pretext":"","posttext":"","login":"","logout":"","greeting":"1","name":"0","usesecure":"0","layout":"_:default","moduleclass_sfx":"","cache":"0"}', 0, '*');
INSERT INTO `jom_modules` VALUES (89, 'Administrator Menu', '', '<div class="arrowlistmenu">\r\n<h3 class="menuheader"><a href="index.php/component/rednet/ordersoncalendar">View Orders</a></h3>\r\n<div> </div>\r\n<h3 class="menuheader"><a href="index.php/component/rednet/orderslist">Order List</a></h3>\r\n<div> </div>\r\n<h3 class="menuheader"><a href="index.php/component/rednet/dailyorderslist">Schedule Resources</a></h3>\r\n<div> </div>\r\n<h3 class="menuheader expandable">Manage Workers</h3>\r\n<ul class="categoryitems">\r\n<li><a href="index.php?option=com_rednet&amp;task=add_worker&amp;view=workers">Add Worker</a></li>\r\n<li><a href="index.php?option=com_rednet&amp;view=workerslist">View/Edit/Delete Worker(s)</a></li>\r\n</ul>\r\n<h3 class="menuheader expandable"><a href="http://www.google.com">Manage Vehicles</a></h3>\r\n<ul class="categoryitems">\r\n<li><a href="index.php?option=com_rednet&amp;task=add_worker&amp;view=workers">Add Worker</a></li>\r\n<li><a href="index.php?option=com_rednet&amp;view=workerslist">View/Edit/Delete Worker(s)</a></li>\r\n</ul>\r\n<div class="div_spacer"> </div>\r\n<h3 class="menuheader expandable">Manage Trip Reports</h3>\r\n<ul class="categoryitems">\r\n<li><a href="#">Enter Trip Report</a></li>\r\n<li><a href="#">Review Trip Report</a></li>\r\n</ul>\r\n<h3 class="menuheader"><a href="index.php/component/rednet/availabilitycalendar?task=availability">Update Availability</a></h3>\r\n<div> </div>\r\n<h3 class="menuheader"><a href="index.php/component/rednet/workers?task=update_personal_info">Update Personal Information</a></h3>\r\n<div> </div>\r\n</div>', 1, 'admin-menu-position', 409, '2012-12-03 10:28:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 2, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*');
INSERT INTO `jom_modules` VALUES (90, 'Loader Menu', '', '<div class="arrowlistmenu">\r\n<h3 class="menuheader"><a href="index.php/component/rednet/ordersoncalendar">Home</a></h3>\r\n<div> </div>\r\n<h3 class="menuheader"><a href="index.php/component/rednet/availabilitycalendar?task=availability">Update Availability</a></h3>\r\n<div> </div>\r\n<h3 class="menuheader">Reports</h3>\r\n<div> </div>\r\n<h3 class="menuheader"><a href="index.php?option=com_rednet&amp;task=update_personal_info&amp;view=workers">Update personal information</a></h3>\r\n<div> </div>\r\n</div>', 1, 'loader-menu-position', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 2, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*');
INSERT INTO `jom_modules` VALUES (91, 'Crew Office Menu', '', '<div class="arrowlistmenu">\r\n<h3 class="menuheader">View Orders</h3>\r\n<div> </div>\r\n<h3 class="menuheader expandable">Manage Trip Reports</h3>\r\n<ul class="categoryitems">\r\n<li><a href="#">Enter Trip Report</a></li>\r\n</ul>\r\n<h3 class="menuheader">Update Availability</h3>\r\n<div> </div>\r\n<h3 class="menuheader">Reports</h3>\r\n<div> </div>\r\n<h3 class="menuheader">Update Personal Information</h3>\r\n<div> </div>\r\n<h3 class="menuheader"><a href="index.php/component/users/?view=reset">Change Password</a></h3>\r\n<div> </div>\r\n</div>', 1, 'crewoffice-menu-position', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 2, 0, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*');
INSERT INTO `jom_modules` VALUES (93, 'Red Net Menu', '', '', 0, 'menu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', -2, 'mod_menu', 1, 1, '{"layout":"_:default","moduleclass_sfx":"","shownew":"1","showhelp":"1","forum_url":"","cache":"0"}', 1, '*');
INSERT INTO `jom_modules` VALUES (94, 'Red Net Menu', '', '<p><a href="index.php?option=com_rednet&amp;view=role">Manage Roles</a> | <a href="index.php?option=com_rednet&amp;view=ordertype">Manage Order Types</a></p>', 1, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"prepare_content":"1","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900"}', 1, '*');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_modules_menu`
-- 

DROP TABLE IF EXISTS `jom_modules_menu`;
CREATE TABLE IF NOT EXISTS `jom_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_modules_menu`
-- 

INSERT INTO `jom_modules_menu` VALUES (1, 0);
INSERT INTO `jom_modules_menu` VALUES (2, 0);
INSERT INTO `jom_modules_menu` VALUES (3, 0);
INSERT INTO `jom_modules_menu` VALUES (4, 0);
INSERT INTO `jom_modules_menu` VALUES (6, 0);
INSERT INTO `jom_modules_menu` VALUES (7, 0);
INSERT INTO `jom_modules_menu` VALUES (8, 0);
INSERT INTO `jom_modules_menu` VALUES (9, 0);
INSERT INTO `jom_modules_menu` VALUES (10, 0);
INSERT INTO `jom_modules_menu` VALUES (12, 0);
INSERT INTO `jom_modules_menu` VALUES (13, 0);
INSERT INTO `jom_modules_menu` VALUES (14, 0);
INSERT INTO `jom_modules_menu` VALUES (15, 0);
INSERT INTO `jom_modules_menu` VALUES (16, 0);
INSERT INTO `jom_modules_menu` VALUES (17, 0);
INSERT INTO `jom_modules_menu` VALUES (79, 0);
INSERT INTO `jom_modules_menu` VALUES (86, 0);
INSERT INTO `jom_modules_menu` VALUES (87, 0);
INSERT INTO `jom_modules_menu` VALUES (88, 0);
INSERT INTO `jom_modules_menu` VALUES (89, 0);
INSERT INTO `jom_modules_menu` VALUES (90, 0);
INSERT INTO `jom_modules_menu` VALUES (91, 0);
INSERT INTO `jom_modules_menu` VALUES (93, 0);
INSERT INTO `jom_modules_menu` VALUES (94, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_newsfeeds`
-- 

DROP TABLE IF EXISTS `jom_newsfeeds`;
CREATE TABLE IF NOT EXISTS `jom_newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `link` varchar(200) NOT NULL default '',
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(10) unsigned NOT NULL default '1',
  `cache_time` int(10) unsigned NOT NULL default '3600',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `rtl` tinyint(4) NOT NULL default '0',
  `access` int(10) unsigned NOT NULL default '0',
  `language` char(7) NOT NULL default '',
  `params` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_newsfeeds`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_orders`
-- 

DROP TABLE IF EXISTS `jom_orders`;
CREATE TABLE IF NOT EXISTS `jom_orders` (
  `id` int(11) NOT NULL auto_increment,
  `order_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_order` date NOT NULL,
  `type_order` varchar(255) NOT NULL,
  `type_if_other` varchar(255) NOT NULL,
  `no_of_men` varchar(255) NOT NULL,
  `no_of_trucks` varchar(255) NOT NULL,
  `truck_requirments` varchar(255) NOT NULL,
  `out_of_town` varchar(255) NOT NULL,
  `departure_time` time NOT NULL,
  `deposite` float NOT NULL,
  `is_addon` int(11) NOT NULL,
  `addon_time` time NOT NULL,
  `instruction_file` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  `parent_order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

-- 
-- Dumping data for table `jom_orders`
-- 

INSERT INTO `jom_orders` VALUES (40, 'order no', 'order name', '2012-10-14', 'fmi_move', '', '2', '3', '5', 'no', '07:30:00', 555, 0, '00:00:00', '10162012122058.csv', 474, '2012-10-16', '2012-10-19', 0);
INSERT INTO `jom_orders` VALUES (41, 'p order no', 'p order name', '2012-10-11', 'move', '', '2', '4', '3', 'no', '14:15:00', 55, 0, '00:00:00', '10172012153631.csv', 474, '2012-10-17', '2012-10-19', 0);
INSERT INTO `jom_orders` VALUES (42, 'ch order no', 'ch name', '2012-11-12', 'pack', '', '1', '4', '9', 'yes', '16:45:00', 0, 0, '00:00:00', '10172012153732.csv', 474, '2012-10-17', '2012-11-17', 41);
INSERT INTO `jom_orders` VALUES (43, 'o.no', 'o.name', '2012-09-30', 'move', '', '2', '5', '99', 'no', '07:30:00', 0, 0, '00:00:00', '10302012123650.csv', 474, '2012-10-30', '2012-10-30', 0);
INSERT INTO `jom_orders` VALUES (44, 'a', 'b', '2012-10-09', 'move_fmi', '', '2', '4', '99', 'no', '07:30:00', 0, 0, '00:00:00', '', 474, '2012-10-30', '2012-10-30', 0);
INSERT INTO `jom_orders` VALUES (45, 'adon', 'adon-name', '2012-08-09', 'move_fmi', '', '2', '4', '99', 'no', '07:30:00', 0, 0, '00:00:00', '', 474, '2012-10-30', '2012-10-30', 44);
INSERT INTO `jom_orders` VALUES (46, 'asd', 'asd', '2012-12-12', 'move', '', '4', '6', '33', 'no', '07:30:00', 0, 0, '00:00:00', '', 474, '2012-10-30', '0000-00-00', 0);
INSERT INTO `jom_orders` VALUES (47, 'woeru', 'asdfj', '2012-12-12', 'wbe', '', '4', '6', '44', 'no', '07:30:00', 0, 1, '07:30:00', '', 474, '2012-10-30', '0000-00-00', 46);
INSERT INTO `jom_orders` VALUES (48, 'asdfj', 'sdafhk', '2012-12-12', 'move', '', '3', '5', '44', 'no', '07:30:00', 0, 0, '00:00:00', '', 474, '2012-10-30', '0000-00-00', 0);
INSERT INTO `jom_orders` VALUES (49, 'ad-on asf', 'sdflk', '2012-12-12', 'move_fmi', '', '3', '5', '34', 'no', '07:30:00', 0, 0, '00:00:00', '', 474, '2012-10-30', '2012-10-30', 48);
INSERT INTO `jom_orders` VALUES (50, 'asd', 'asd', '2012-02-03', 'move', '', '2', '5', '43', 'no', '07:30:00', 0, 0, '00:00:00', '', 474, '2012-10-30', '0000-00-00', 0);
INSERT INTO `jom_orders` VALUES (39, 'kaka order', 'kaka name', '2012-10-11', 'others', 'kaka other', '5', '7', '44', 'yes', '05:00:00', 99, 0, '00:00:00', '10062012140706.csv', 484, '2012-10-06', '2012-10-11', 0);
INSERT INTO `jom_orders` VALUES (55, 'pLala', 'pLala', '2012-11-19', 'commercial', '', '2', '5', '33', 'no', '07:30:00', 0, 0, '00:00:00', '', 474, '2012-10-31', '2012-11-19', 0);
INSERT INTO `jom_orders` VALUES (56, 'cLala', 'cLala', '2012-11-19', 'others', 'asdf', '2', '5', '66', 'no', '07:30:00', 0, 1, '00:00:00', '', 474, '2012-10-31', '2012-11-19', 55);
INSERT INTO `jom_orders` VALUES (57, 'pXorder', 'pXorder', '2012-11-12', 'fmi_move', '', '2', '5', '99', 'no', '07:30:00', 0, 0, '00:00:00', '11122012194208.csv', 474, '2012-10-31', '2012-11-19', 0);
INSERT INTO `jom_orders` VALUES (58, 'chXorder', 'chXorder', '2012-11-12', 'pack', '', '2', '5', '55', 'no', '07:30:00', 0, 1, '00:00:00', '', 474, '2012-10-31', '2012-11-19', 57);
INSERT INTO `jom_orders` VALUES (59, 'meP', 'me order', '2012-11-13', 'move', '', '1', '2', '3', 'no', '02:15:00', 0, 0, '00:00:00', '', 474, '2012-11-13', '0000-00-00', 0);
INSERT INTO `jom_orders` VALUES (60, 'mmP', 'mm order', '2012-11-13', 'fmi_move', '', '1', '2', '3', 'no', '02:30:00', 0, 0, '00:00:00', '', 474, '2012-11-13', '0000-00-00', 0);
INSERT INTO `jom_orders` VALUES (61, 'asOrder', 'asOrderName', '2012-11-13', 'move', '', '11', '22', '33', 'no', '02:15:00', 0, 0, '00:00:00', '', 474, '2012-11-13', '0000-00-00', 0);
INSERT INTO `jom_orders` VALUES (62, 'asOrder', 'asOrderName', '2012-11-13', 'move', '', '11', '22', '33', 'no', '14:15:00', 0, 0, '00:00:00', '', 474, '2012-11-13', '0000-00-00', 0);
INSERT INTO `jom_orders` VALUES (63, 'WP-Order', 'WP-Order', '2012-11-19', 'move_fmi', '', '1', '2', '2', 'yes', '14:45:00', 0, 0, '00:00:00', '11202012151058.csv', 474, '2012-11-19', '2012-11-21', 0);
INSERT INTO `jom_orders` VALUES (64, 'WC-Order', 'WC-Order', '2012-11-19', 'pack', '', '1', '2', '2', 'no', '14:45:00', 0, 1, '00:00:00', '11202012151132.csv', 474, '2012-11-19', '2012-11-21', 63);
INSERT INTO `jom_orders` VALUES (65, 'asd', 'asdf', '2012-11-19', 'move', '', '2', '3', '2', 'no', '07:30:00', 0, 0, '00:00:00', '', 474, '2012-11-20', '0000-00-00', 0);
INSERT INTO `jom_orders` VALUES (68, 'AP-Order', 'AP Order Name', '2012-12-02', 'move_fmi', '', '3', '4', '5', 'yes', '02:15:00', 0, 0, '00:00:00', '', 474, '2012-12-02', '2012-12-02', 0);
INSERT INTO `jom_orders` VALUES (67, 'WP-Order1', 'abc**', '2015-02-02', 'pack', '', '11', '22', '33', 'yes', '07:45:00', 0, 0, '00:00:00', '', 474, '2012-11-21', '2012-11-21', 0);
INSERT INTO `jom_orders` VALUES (69, 'AC-Order', 'AC Order Name', '2012-12-02', 'move_fmi', '', '3', '4', '5', 'no', '02:15:00', 0, 1, '00:00:00', '', 474, '2012-12-02', '2012-12-02', 68);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_ordertype`
-- 

DROP TABLE IF EXISTS `jom_ordertype`;
CREATE TABLE IF NOT EXISTS `jom_ordertype` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `jom_ordertype`
-- 

INSERT INTO `jom_ordertype` VALUES (1, 'Move', 'move');
INSERT INTO `jom_ordertype` VALUES (2, 'MOVE/FMI', 'move_fmi');
INSERT INTO `jom_ordertype` VALUES (3, 'FMI/MOVE', 'fmi_move');
INSERT INTO `jom_ordertype` VALUES (4, 'FMI', 'fmi');
INSERT INTO `jom_ordertype` VALUES (5, 'Pack', 'pack');
INSERT INTO `jom_ordertype` VALUES (7, 'Commercial', 'commercial');
INSERT INTO `jom_ordertype` VALUES (8, 'Delivery', 'delivery');
INSERT INTO `jom_ordertype` VALUES (9, 'Others', 'others');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_overrider`
-- 

DROP TABLE IF EXISTS `jom_overrider`;
CREATE TABLE IF NOT EXISTS `jom_overrider` (
  `id` int(10) NOT NULL auto_increment COMMENT 'Primary Key',
  `constant` varchar(255) NOT NULL,
  `string` text NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_overrider`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_redirect_links`
-- 

DROP TABLE IF EXISTS `jom_redirect_links`;
CREATE TABLE IF NOT EXISTS `jom_redirect_links` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `old_url` varchar(255) NOT NULL,
  `new_url` varchar(255) NOT NULL,
  `referer` varchar(150) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `hits` int(10) unsigned NOT NULL default '0',
  `published` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_link_old` (`old_url`),
  KEY `idx_link_modifed` (`modified_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `jom_redirect_links`
-- 

INSERT INTO `jom_redirect_links` VALUES (1, 'http://localhost/rednet/index.php/component/user/login', '', '', '', 1, 0, '2012-08-26 09:40:44', '0000-00-00 00:00:00');
INSERT INTO `jom_redirect_links` VALUES (2, 'http://localhost/rednet/index.php?option=com_rednet&task=add_worker&view=workers', '', '', '', 1, 0, '2012-08-30 04:17:55', '0000-00-00 00:00:00');
INSERT INTO `jom_redirect_links` VALUES (3, 'http://localhost/rednet/index.php?option=com_rednet_task=add_worker_submit', '', 'http://localhost/rednet/index.php?option=com_rednet&task=add_worker&view=workers', '', 2, 0, '2012-08-30 11:27:07', '0000-00-00 00:00:00');
INSERT INTO `jom_redirect_links` VALUES (4, 'http://localhost/rednet/index.php?option=com_rednet_task&task=add_worker_submit', '', 'http://localhost/rednet/index.php?option=com_rednet&task=add_worker&view=workers', '', 1, 0, '2012-08-30 11:27:45', '0000-00-00 00:00:00');
INSERT INTO `jom_redirect_links` VALUES (5, 'http://localhost/rednet/index.php/component/loader/', '', '', '', 1, 0, '2012-09-06 10:01:16', '0000-00-00 00:00:00');
INSERT INTO `jom_redirect_links` VALUES (6, 'http://localhost/rednet/index.php/component/workers', '', '', '', 1, 0, '2012-09-10 09:19:33', '0000-00-00 00:00:00');
INSERT INTO `jom_redirect_links` VALUES (7, 'http://localhost/rednet/index.php/component/fleet/?view=fleet', '', '', '', 1, 0, '2012-09-10 09:20:01', '0000-00-00 00:00:00');
INSERT INTO `jom_redirect_links` VALUES (8, 'http://localhost/rednet/index.php/component/fleet/?view=fleetd', '', '', '', 1, 0, '2012-09-10 09:20:06', '0000-00-00 00:00:00');
INSERT INTO `jom_redirect_links` VALUES (9, 'http://localhost/rednet/index.php/component/fleet/1?view=fleet', '', '', '', 1, 0, '2012-09-10 09:20:14', '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_resourcesmap`
-- 

DROP TABLE IF EXISTS `jom_resourcesmap`;
CREATE TABLE IF NOT EXISTS `jom_resourcesmap` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `truck` varchar(255) NOT NULL,
  `truck_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  `worker_role` varchar(255) NOT NULL,
  `is_dispatched` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=366 ;

-- 
-- Dumping data for table `jom_resourcesmap`
-- 

INSERT INTO `jom_resourcesmap` VALUES (292, 64, 497, '', '', 'A', '2012-11-30', 'Crew Chief', NULL);
INSERT INTO `jom_resourcesmap` VALUES (294, 64, 0, '12', 'fleet', '', '2012-11-30', '', NULL);
INSERT INTO `jom_resourcesmap` VALUES (290, 64, 497, '', '', 'A', '2012-11-30', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (284, 64, 495, '', '', 'A', '2012-11-30', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (291, 63, 497, '', '', 'A', '2012-11-30', 'Crew Chief', NULL);
INSERT INTO `jom_resourcesmap` VALUES (282, 64, 497, '', '', 'A', '2012-11-30', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (273, 64, 0, '16', 'fleet', '', '2012-11-27', '', NULL);
INSERT INTO `jom_resourcesmap` VALUES (272, 64, 0, '10', 'fleet', '', '2012-11-27', '', NULL);
INSERT INTO `jom_resourcesmap` VALUES (271, 63, 0, '16', 'fleet', '', '2012-11-27', '', NULL);
INSERT INTO `jom_resourcesmap` VALUES (278, 64, 495, '', '', 'A', '2012-11-28', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (268, 64, 0, '14', 'fleet', '', '2012-11-27', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (280, 64, 495, '', '', 'A', '2012-11-30', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (267, 64, 495, '', '', 'A', '2012-11-27', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (299, 63, 495, '', '', 'A', '2012-11-30', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (288, 64, 495, '', '', 'A', '2012-11-30', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (300, 64, 495, '', '', 'A', '2012-11-30', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (296, 64, 495, '', '', 'A', '2012-11-30', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (358, 68, 496, '', '', 'A', '2012-12-03', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (301, 63, 0, '18', 'fleet', '', '2012-11-30', '', NULL);
INSERT INTO `jom_resourcesmap` VALUES (302, 64, 0, '18', 'fleet', '', '2012-11-30', '', NULL);
INSERT INTO `jom_resourcesmap` VALUES (357, 69, 495, '', '', 'A', '2012-12-03', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (356, 68, 495, '', '', 'CD', '2012-12-03', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (359, 68, 0, '20', 'fleet', '', '2012-12-03', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (360, 68, 0, '6', 'rental', '', '2012-12-03', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (361, 69, 496, '', '', 'A', '2012-12-03', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (362, 69, 0, '20', 'fleet', '', '2012-12-03', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (363, 69, 0, '6', 'rental', '', '2012-12-03', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (364, 68, 497, '', '', 'A', '2012-12-03', 'Loader', NULL);
INSERT INTO `jom_resourcesmap` VALUES (365, 69, 497, '', '', 'A', '2012-12-03', 'Loader', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_schemas`
-- 

DROP TABLE IF EXISTS `jom_schemas`;
CREATE TABLE IF NOT EXISTS `jom_schemas` (
  `extension_id` int(11) NOT NULL,
  `version_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`extension_id`,`version_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_schemas`
-- 

INSERT INTO `jom_schemas` VALUES (700, '2.5.6');
INSERT INTO `jom_schemas` VALUES (10000, '20110727');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_session`
-- 

DROP TABLE IF EXISTS `jom_session`;
CREATE TABLE IF NOT EXISTS `jom_session` (
  `session_id` varchar(200) NOT NULL default '',
  `client_id` tinyint(3) unsigned NOT NULL default '0',
  `guest` tinyint(4) unsigned default '1',
  `time` varchar(14) default '',
  `data` mediumtext,
  `userid` int(11) default '0',
  `username` varchar(150) default '',
  `usertype` varchar(50) default '',
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_session`
-- 

INSERT INTO `jom_session` VALUES ('0c625e07a47042e62e83a97ecd8fc8e8', 0, 0, '1354630456', '__default|a:8:{s:15:"session.counter";i:96;s:19:"session.timer.start";i:1354625539;s:18:"session.timer.last";i:1354630454;s:17:"session.timer.now";i:1354630455;s:22:"session.client.browser";s:65:"Mozilla/5.0 (Windows NT 6.1; rv:16.0) Gecko/20100101 Firefox/16.0";s:8:"registry";O:9:"JRegistry":1:{s:7:"\0*\0data";O:8:"stdClass":3:{s:5:"users";O:8:"stdClass":1:{s:5:"login";O:8:"stdClass":1:{s:4:"form";O:8:"stdClass":2:{s:4:"data";a:0:{}s:6:"return";s:39:"index.php?option=com_users&view=profile";}}}s:22:"com_frontenduseraccess";O:8:"stdClass":1:{s:12:"redirect_url";s:0:"";}s:10:"com_rednet";O:8:"stdClass":1:{s:16:"ordersoncalendar";O:8:"stdClass":2:{s:8:"ordercol";N;s:10:"limitstart";s:10:"1353783600";}}}}s:4:"user";O:5:"JUser":25:{s:9:"\0*\0isRoot";b:0;s:2:"id";s:3:"495";s:4:"name";s:5:"bhola";s:8:"username";s:15:"bhola@gmail.com";s:5:"email";s:15:"bhola@gmail.com";s:8:"password";s:32:"e3723584d56ac2000e98553fd9ad1eca";s:14:"password_clear";s:0:"";s:8:"usertype";s:0:"";s:5:"block";s:1:"0";s:9:"sendEmail";s:1:"0";s:12:"registerDate";s:19:"2012-10-28 00:00:00";s:13:"lastvisitDate";s:19:"2012-12-03 12:46:53";s:10:"activation";s:0:"";s:6:"params";s:0:"";s:6:"groups";a:1:{i:2;s:1:"2";}s:5:"guest";i:0;s:13:"lastResetTime";s:19:"0000-00-00 00:00:00";s:10:"resetCount";s:1:"0";s:10:"\0*\0_params";O:9:"JRegistry":1:{s:7:"\0*\0data";O:8:"stdClass":0:{}}s:14:"\0*\0_authGroups";a:2:{i:0;i:1;i:1;i:2;}s:14:"\0*\0_authLevels";a:3:{i:0;i:1;i:1;i:1;i:2;i:2;}s:15:"\0*\0_authActions";N;s:12:"\0*\0_errorMsg";N;s:10:"\0*\0_errors";a:0:{}s:3:"aid";i:0;}s:13:"session.token";s:32:"413aa43cbbd70237b7766db3eef6c8fa";}', 495, 'bhola@gmail.com', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_template_styles`
-- 

DROP TABLE IF EXISTS `jom_template_styles`;
CREATE TABLE IF NOT EXISTS `jom_template_styles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `template` varchar(50) NOT NULL default '',
  `client_id` tinyint(1) unsigned NOT NULL default '0',
  `home` char(7) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_template` (`template`),
  KEY `idx_home` (`home`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `jom_template_styles`
-- 

INSERT INTO `jom_template_styles` VALUES (2, 'bluestork', 1, '1', 'Bluestork - Default', '{"useRoundedCorners":"1","showSiteName":"0"}');
INSERT INTO `jom_template_styles` VALUES (3, 'atomic', 0, '1', 'Atomic - Default', '{}');
INSERT INTO `jom_template_styles` VALUES (4, 'beez_20', 0, '0', 'Beez2 - Default', '{"wrapperSmall":"53","wrapperLarge":"72","logo":"images\\/joomla_black.gif","sitetitle":"Joomla!","sitedescription":"Open Source Content Management","navposition":"left","templatecolor":"personal","html5":"0"}');
INSERT INTO `jom_template_styles` VALUES (5, 'hathor', 1, '0', 'Hathor - Default', '{"showSiteName":"0","colourChoice":"","boldText":"0"}');
INSERT INTO `jom_template_styles` VALUES (6, 'beez5', 0, '0', 'Beez5 - Default', '{"wrapperSmall":"53","wrapperLarge":"72","logo":"images\\/sampledata\\/fruitshop\\/fruits.gif","sitetitle":"Joomla!","sitedescription":"Open Source Content Management","navposition":"left","html5":"0"}');
INSERT INTO `jom_template_styles` VALUES (7, 'templatename', 0, '0', 'templatename - Default', '{"modernizr":"1","bootstrap":"0","pie":"1"}');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_testpages`
-- 

DROP TABLE IF EXISTS `jom_testpages`;
CREATE TABLE IF NOT EXISTS `jom_testpages` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- 
-- Dumping data for table `jom_testpages`
-- 

INSERT INTO `jom_testpages` VALUES (27, 'second page', 'in-active');
INSERT INTO `jom_testpages` VALUES (26, 'first page', 'active');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_updates`
-- 

DROP TABLE IF EXISTS `jom_updates`;
CREATE TABLE IF NOT EXISTS `jom_updates` (
  `update_id` int(11) NOT NULL auto_increment,
  `update_site_id` int(11) default '0',
  `extension_id` int(11) default '0',
  `categoryid` int(11) default '0',
  `name` varchar(100) default '',
  `description` text NOT NULL,
  `element` varchar(100) default '',
  `type` varchar(20) default '',
  `folder` varchar(20) default '',
  `client_id` tinyint(3) default '0',
  `version` varchar(10) default '',
  `data` text NOT NULL,
  `detailsurl` text NOT NULL,
  `infourl` text NOT NULL,
  PRIMARY KEY  (`update_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Available Updates' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_updates`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_update_categories`
-- 

DROP TABLE IF EXISTS `jom_update_categories`;
CREATE TABLE IF NOT EXISTS `jom_update_categories` (
  `categoryid` int(11) NOT NULL auto_increment,
  `name` varchar(20) default '',
  `description` text NOT NULL,
  `parent` int(11) default '0',
  `updatesite` int(11) default '0',
  PRIMARY KEY  (`categoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Update Categories' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_update_categories`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_update_sites`
-- 

DROP TABLE IF EXISTS `jom_update_sites`;
CREATE TABLE IF NOT EXISTS `jom_update_sites` (
  `update_site_id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default '',
  `type` varchar(20) default '',
  `location` text NOT NULL,
  `enabled` int(11) default '0',
  `last_check_timestamp` bigint(20) default '0',
  PRIMARY KEY  (`update_site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Update Sites' AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `jom_update_sites`
-- 

INSERT INTO `jom_update_sites` VALUES (1, 'Joomla Core', 'collection', 'http://update.joomla.org/core/list.xml', 0, 1345973643);
INSERT INTO `jom_update_sites` VALUES (2, 'Joomla Extension Directory', 'collection', 'http://update.joomla.org/jed/list.xml', 0, 1345973643);
INSERT INTO `jom_update_sites` VALUES (3, 'Jacc Update Site', 'extension', 'http://janguo.de/jacc/update/jacc-update.xml', 0, 1345973643);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_update_sites_extensions`
-- 

DROP TABLE IF EXISTS `jom_update_sites_extensions`;
CREATE TABLE IF NOT EXISTS `jom_update_sites_extensions` (
  `update_site_id` int(11) NOT NULL default '0',
  `extension_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`update_site_id`,`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Links extensions to update sites';

-- 
-- Dumping data for table `jom_update_sites_extensions`
-- 

INSERT INTO `jom_update_sites_extensions` VALUES (1, 700);
INSERT INTO `jom_update_sites_extensions` VALUES (2, 700);
INSERT INTO `jom_update_sites_extensions` VALUES (3, 10000);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_usergroups`
-- 

DROP TABLE IF EXISTS `jom_usergroups`;
CREATE TABLE IF NOT EXISTS `jom_usergroups` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Primary Key',
  `parent_id` int(10) unsigned NOT NULL default '0' COMMENT 'Adjacency List Reference Id',
  `lft` int(11) NOT NULL default '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL default '0' COMMENT 'Nested set rgt.',
  `title` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_usergroup_parent_title_lookup` (`parent_id`,`title`),
  KEY `idx_usergroup_title_lookup` (`title`),
  KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  KEY `idx_usergroup_nested_set_lookup` USING BTREE (`lft`,`rgt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `jom_usergroups`
-- 

INSERT INTO `jom_usergroups` VALUES (1, 0, 1, 20, 'Public');
INSERT INTO `jom_usergroups` VALUES (2, 1, 6, 17, 'Registered');
INSERT INTO `jom_usergroups` VALUES (3, 2, 7, 14, 'Author');
INSERT INTO `jom_usergroups` VALUES (4, 3, 8, 11, 'Editor');
INSERT INTO `jom_usergroups` VALUES (5, 4, 9, 10, 'Publisher');
INSERT INTO `jom_usergroups` VALUES (6, 1, 2, 5, 'Manager');
INSERT INTO `jom_usergroups` VALUES (7, 6, 3, 4, 'Administrator');
INSERT INTO `jom_usergroups` VALUES (8, 1, 18, 19, 'Super Users');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_users`
-- 

DROP TABLE IF EXISTS `jom_users`;
CREATE TABLE IF NOT EXISTS `jom_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `username` varchar(150) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  `lastResetTime` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int(11) NOT NULL default '0' COMMENT 'Count of password resets since lastResetTime',
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=501 ;

-- 
-- Dumping data for table `jom_users`
-- 

INSERT INTO `jom_users` VALUES (409, 'Super User', 'admin', 'rednet@gmail.com', 'e5aa8fcf0952314240f35d8f032141bb:kEO91rXHzpU5J6gBxF1NZb64NyXVJ9t5', 'deprecated', 0, 1, '2012-08-24 06:39:55', '2012-12-03 10:24:47', '0', '', '0000-00-00 00:00:00', 0);
INSERT INTO `jom_users` VALUES (497, 'waqar', 'waqarmuneer@gmail.com', 'waqarmuneer@gmail.com', '89954f55f4d482f141126b17eefe33a9', '', 0, 0, '2012-10-28 00:00:00', '2012-12-02 09:30:36', '', '', '0000-00-00 00:00:00', 0);
INSERT INTO `jom_users` VALUES (411, 'waqar crew', 'waqarcrew', 'waqarmuneer@yahoo.com', 'd0521cd9285297aa7c95f52d204d309c:q0pZZ2peLHPKDkAwYo7raV8Rfq3SowzK', '', 0, 0, '2012-08-25 06:24:57', '2012-08-29 12:19:10', '', '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":"Asia\\/Karachi"}', '0000-00-00 00:00:00', 0);
INSERT INTO `jom_users` VALUES (412, 'user loader', 'userloader', 'userloader@gmail.com', 'b039a3d22efe94025b2261c74eb1673b:btSm6prgJMS3D9dyIrWjKH0PmVrOyPRk', '', 0, 0, '2012-08-28 08:23:54', '2012-09-04 12:30:45', '', '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}', '0000-00-00 00:00:00', 0);
INSERT INTO `jom_users` VALUES (495, 'bhola', 'bhola@gmail.com', 'bhola@gmail.com', 'e3723584d56ac2000e98553fd9ad1eca', '', 0, 0, '2012-10-28 00:00:00', '2012-12-04 12:52:24', '', '', '0000-00-00 00:00:00', 0);
INSERT INTO `jom_users` VALUES (496, 'lala', 'lala@gmail.com', 'lala@gmail.com', '2e3817293fc275dbee74bd71ce6eb056', '', 0, 0, '2012-10-28 00:00:00', '2012-11-18 12:11:43', '', '', '0000-00-00 00:00:00', 0);
INSERT INTO `jom_users` VALUES (474, 'waqar', 'myadmin', 'myadmin@ff.com', 'e5aa8fcf0952314240f35d8f032141bb:kEO91rXHzpU5J6gBxF1NZb64NyXVJ9t5', '', 0, 0, '2012-09-07 08:57:50', '2012-12-03 12:47:03', '', '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}', '0000-00-00 00:00:00', 0);
INSERT INTO `jom_users` VALUES (498, 'fname', 'mp@gmail.com', 'mp@gmail.com', '1f2dfa567dcf95833eddf7aec167fec7', '', 0, 0, '2012-11-23 00:00:00', '2012-11-23 07:22:45', '', '', '0000-00-00 00:00:00', 0);
INSERT INTO `jom_users` VALUES (500, 'waqar', 'wwaqar@gmail.com', 'wwaqar@gmail.com', '93e9ed6116a4d5fb5ab35a4cd49f3fba', '', 0, 0, '2012-12-01 00:00:00', '2012-12-01 00:00:00', '', '', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_user_availabilitycalendar`
-- 

DROP TABLE IF EXISTS `jom_user_availabilitycalendar`;
CREATE TABLE IF NOT EXISTS `jom_user_availabilitycalendar` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `availability_date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5003 ;

-- 
-- Dumping data for table `jom_user_availabilitycalendar`
-- 

INSERT INTO `jom_user_availabilitycalendar` VALUES (4804, 495, '2013-05-27');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4803, 495, '2013-05-20');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4802, 495, '2013-05-13');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4801, 495, '2013-05-06');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4800, 495, '2013-04-29');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4799, 495, '2013-04-22');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4798, 495, '2013-04-15');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4797, 495, '2013-04-08');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4796, 495, '2013-04-01');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4795, 495, '2013-03-25');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4794, 495, '2013-03-18');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4793, 495, '2013-03-11');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4792, 495, '2013-03-04');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4791, 495, '2013-02-25');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4790, 495, '2013-02-18');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4789, 495, '2013-02-11');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4788, 495, '2013-02-04');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4787, 495, '2013-01-28');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4786, 495, '2013-01-21');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4785, 495, '2013-01-14');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4784, 495, '2013-01-07');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4783, 495, '2012-12-31');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4782, 495, '2012-12-24');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4781, 495, '2012-12-17');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4780, 495, '2012-12-10');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4779, 495, '2012-12-03');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4778, 495, '2012-11-26');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4950, 497, '2012-11-12');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4776, 495, '2012-11-12');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4775, 495, '2012-11-05');
INSERT INTO `jom_user_availabilitycalendar` VALUES (5002, 497, '2012-12-06');
INSERT INTO `jom_user_availabilitycalendar` VALUES (5000, 496, '2012-12-20');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4995, 495, '2012-12-16');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4997, 495, '2012-12-09');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4999, 474, '2012-12-13');
INSERT INTO `jom_user_availabilitycalendar` VALUES (5001, 474, '2012-12-02');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4949, 495, '2012-11-12');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4944, 497, '2013-10-17');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4943, 497, '2013-11-30');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4942, 497, '2013-11-23');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4941, 497, '2013-11-16');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4940, 497, '2013-11-09');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4939, 497, '2013-11-02');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4938, 497, '2013-10-26');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4937, 497, '2013-10-19');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4936, 497, '2013-10-12');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4935, 497, '2013-10-05');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4934, 497, '2013-09-28');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4933, 497, '2013-09-21');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4932, 497, '2013-09-14');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4931, 497, '2013-09-07');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4930, 497, '2013-08-31');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4929, 497, '2013-08-24');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4928, 497, '2013-08-17');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4927, 497, '2013-08-10');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4926, 497, '2013-08-03');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4925, 497, '2013-07-27');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4924, 497, '2013-07-20');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4923, 497, '2013-07-13');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4922, 497, '2013-07-06');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4921, 497, '2013-06-29');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4920, 497, '2013-06-22');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4919, 497, '2013-06-15');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4918, 497, '2013-06-08');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4917, 497, '2013-06-01');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4916, 497, '2013-05-25');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4915, 497, '2013-05-18');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4914, 497, '2013-05-11');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4913, 497, '2013-05-04');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4912, 497, '2013-04-27');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4911, 497, '2013-04-20');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4910, 497, '2013-04-13');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4909, 497, '2013-04-06');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4908, 497, '2013-03-30');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4907, 497, '2013-03-23');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4906, 497, '2013-03-16');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4905, 497, '2013-03-09');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4904, 497, '2013-03-02');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4903, 497, '2013-02-23');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4902, 497, '2013-02-16');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4901, 497, '2013-02-09');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4900, 497, '2013-02-02');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4899, 497, '2013-01-26');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4898, 497, '2013-01-19');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4897, 497, '2013-01-12');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4896, 497, '2013-01-05');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4895, 497, '2012-12-29');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4894, 497, '2012-12-22');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4893, 497, '2012-12-15');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4892, 497, '2012-12-08');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4891, 497, '2012-12-01');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4890, 497, '2012-11-24');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4889, 497, '2012-11-17');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4888, 497, '2012-11-10');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4887, 497, '2012-11-03');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4830, 495, '2013-11-25');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4829, 495, '2013-11-18');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4828, 495, '2013-11-11');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4827, 495, '2013-11-04');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4826, 495, '2013-10-28');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4825, 495, '2013-10-21');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4824, 495, '2013-10-14');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4823, 495, '2013-10-07');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4822, 495, '2013-09-30');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4821, 495, '2013-09-23');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4820, 495, '2013-09-16');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4819, 495, '2013-09-09');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4818, 495, '2013-09-02');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4817, 495, '2013-08-26');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4816, 495, '2013-08-19');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4815, 495, '2013-08-12');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4814, 495, '2013-08-05');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4813, 495, '2013-07-29');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4812, 495, '2013-07-22');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4811, 495, '2013-07-15');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4810, 495, '2013-07-08');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4809, 495, '2013-07-01');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4808, 495, '2013-06-24');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4807, 495, '2013-06-17');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4806, 495, '2013-06-10');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4805, 495, '2013-06-03');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4878, 495, '2013-10-03');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4877, 495, '2013-09-26');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4876, 495, '2013-09-19');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4875, 495, '2013-09-12');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4874, 495, '2013-09-05');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4873, 495, '2013-08-29');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4872, 495, '2013-08-22');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4871, 495, '2013-08-15');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4870, 495, '2013-08-08');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4869, 495, '2013-08-01');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4868, 495, '2013-07-25');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4867, 495, '2013-07-18');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4866, 495, '2013-07-11');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4865, 495, '2013-07-04');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4864, 495, '2013-06-27');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4863, 495, '2013-06-20');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4862, 495, '2013-06-13');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4861, 495, '2013-06-06');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4860, 495, '2013-05-30');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4859, 495, '2013-05-23');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4858, 495, '2013-05-16');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4857, 495, '2013-05-09');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4856, 495, '2013-05-02');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4855, 495, '2013-04-25');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4854, 495, '2013-04-18');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4853, 495, '2013-04-11');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4852, 495, '2013-04-04');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4851, 495, '2013-03-28');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4850, 495, '2013-03-21');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4849, 495, '2013-03-14');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4848, 495, '2013-03-07');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4847, 495, '2013-02-28');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4846, 495, '2013-02-21');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4845, 495, '2013-02-14');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4844, 495, '2013-02-07');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4843, 495, '2013-01-31');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4842, 495, '2013-01-24');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4841, 495, '2013-01-17');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4840, 495, '2013-01-10');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4839, 495, '2013-01-03');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4838, 495, '2012-12-27');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4837, 495, '2012-12-20');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4836, 495, '2012-12-13');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4835, 495, '2012-12-06');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4834, 495, '2012-11-29');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4833, 495, '2012-11-22');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4832, 495, '2012-11-15');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4831, 495, '2012-11-08');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4883, 495, '2013-11-07');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4884, 495, '2013-11-14');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4885, 495, '2013-11-21');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4886, 495, '2013-11-28');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4879, 495, '2013-10-10');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4880, 495, '2013-10-17');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4881, 495, '2013-10-24');
INSERT INTO `jom_user_availabilitycalendar` VALUES (4882, 495, '2013-10-31');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_user_availability_of_days`
-- 

DROP TABLE IF EXISTS `jom_user_availability_of_days`;
CREATE TABLE IF NOT EXISTS `jom_user_availability_of_days` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `day` varchar(255) NOT NULL,
  `month` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=612 ;

-- 
-- Dumping data for table `jom_user_availability_of_days`
-- 

INSERT INTO `jom_user_availability_of_days` VALUES (611, 497, 'sat', 11, '2012-11-20');
INSERT INTO `jom_user_availability_of_days` VALUES (609, 495, 'mon', 11, '2012-11-20');
INSERT INTO `jom_user_availability_of_days` VALUES (610, 495, 'thur', 11, '2012-11-20');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_user_notes`
-- 

DROP TABLE IF EXISTS `jom_user_notes`;
CREATE TABLE IF NOT EXISTS `jom_user_notes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `catid` int(10) unsigned NOT NULL default '0',
  `subject` varchar(100) NOT NULL default '',
  `body` text NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL default '0',
  `created_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL,
  `modified_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `review_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_category_id` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_user_notes`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_user_profiles`
-- 

DROP TABLE IF EXISTS `jom_user_profiles`;
CREATE TABLE IF NOT EXISTS `jom_user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Simple user profile storage table';

-- 
-- Dumping data for table `jom_user_profiles`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_user_usergroup_map`
-- 

DROP TABLE IF EXISTS `jom_user_usergroup_map`;
CREATE TABLE IF NOT EXISTS `jom_user_usergroup_map` (
  `user_id` int(10) unsigned NOT NULL default '0' COMMENT 'Foreign Key to #__users.id',
  `group_id` int(10) unsigned NOT NULL default '0' COMMENT 'Foreign Key to #__usergroups.id',
  PRIMARY KEY  (`user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jom_user_usergroup_map`
-- 

INSERT INTO `jom_user_usergroup_map` VALUES (409, 8);
INSERT INTO `jom_user_usergroup_map` VALUES (411, 2);
INSERT INTO `jom_user_usergroup_map` VALUES (412, 2);
INSERT INTO `jom_user_usergroup_map` VALUES (436, 2);
INSERT INTO `jom_user_usergroup_map` VALUES (474, 2);
INSERT INTO `jom_user_usergroup_map` VALUES (495, 2);
INSERT INTO `jom_user_usergroup_map` VALUES (496, 2);
INSERT INTO `jom_user_usergroup_map` VALUES (497, 2);
INSERT INTO `jom_user_usergroup_map` VALUES (498, 2);
INSERT INTO `jom_user_usergroup_map` VALUES (500, 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_vehicles_fleet`
-- 

DROP TABLE IF EXISTS `jom_vehicles_fleet`;
CREATE TABLE IF NOT EXISTS `jom_vehicles_fleet` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `out_of_service` varchar(255) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- 
-- Dumping data for table `jom_vehicles_fleet`
-- 

INSERT INTO `jom_vehicles_fleet` VALUES (14, 'asf', 'sdf', '0', '1970-01-01', '1970-01-01', '2012-09-17', '2012-09-17', 474, 474);
INSERT INTO `jom_vehicles_fleet` VALUES (13, 'a', 'b', '0', '1970-01-01', '1970-01-01', '2012-09-17', '2012-09-17', 474, 0);
INSERT INTO `jom_vehicles_fleet` VALUES (10, 'fname', 'tname', '1', '2012-05-15', '2012-09-19', '2012-09-11', '2012-09-12', 488, 474);
INSERT INTO `jom_vehicles_fleet` VALUES (15, 'a', 'dfsf', '1', '2012-06-02', '2012-07-08', '2012-09-17', '2012-09-17', 474, 0);
INSERT INTO `jom_vehicles_fleet` VALUES (12, 'ff', 'tt', '1', '2012-12-31', '2012-06-07', '2012-09-17', '2012-09-17', 474, 0);
INSERT INTO `jom_vehicles_fleet` VALUES (16, 'f1', 'f2', '0', '1970-01-01', '1970-01-01', '2012-09-17', '2012-09-17', 474, 0);
INSERT INTO `jom_vehicles_fleet` VALUES (17, 'aa', 'bb', '0', '1970-01-01', '1970-01-01', '2012-09-18', '2012-09-18', 474, 0);
INSERT INTO `jom_vehicles_fleet` VALUES (18, '5''3''''', '67', '0', '1970-01-01', '1970-01-01', '2012-09-18', '2012-09-18', 474, 474);
INSERT INTO `jom_vehicles_fleet` VALUES (20, 'x''', 'y', '1', '2012-11-20', '2012-11-20', '2012-09-18', '2012-12-01', 474, 474);
INSERT INTO `jom_vehicles_fleet` VALUES (21, 'c"', 'c', '0', '1970-01-01', '1970-01-01', '2012-09-18', '2012-09-18', 474, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_vehicles_rental`
-- 

DROP TABLE IF EXISTS `jom_vehicles_rental`;
CREATE TABLE IF NOT EXISTS `jom_vehicles_rental` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `out_of_service` varchar(255) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `jom_vehicles_rental`
-- 

INSERT INTO `jom_vehicles_rental` VALUES (5, 'r1', 'r2', '1', '1970-01-11', '1970-11-01', '2012-09-17', '2012-09-17', 474, 474);
INSERT INTO `jom_vehicles_rental` VALUES (4, 'A Rnetal Name', 'A Rental Type', '0', '2012-12-20', '2012-12-20', '2012-09-12', '2012-12-01', 474, 474);
INSERT INTO `jom_vehicles_rental` VALUES (6, 'r''a', 'r', '1', '2012-12-05', '2012-12-10', '2012-09-17', '2012-12-01', 474, 474);
INSERT INTO `jom_vehicles_rental` VALUES (7, '1''2"', '3''4"', '0', '1970-01-01', '1970-01-01', '2012-09-18', '2012-09-18', 474, 0);
INSERT INTO `jom_vehicles_rental` VALUES (8, 'name', 'new type', '0', '2012-02-03', '2011-10-31', '2012-10-31', '2012-10-31', 474, 474);
INSERT INTO `jom_vehicles_rental` VALUES (9, 'xname', 'xtype', '0', '1970-01-01', '1970-01-01', '2012-10-31', '2012-10-31', 474, 474);

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_viewlevels`
-- 

DROP TABLE IF EXISTS `jom_viewlevels`;
CREATE TABLE IF NOT EXISTS `jom_viewlevels` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Primary Key',
  `title` varchar(100) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_assetgroup_title_lookup` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `jom_viewlevels`
-- 

INSERT INTO `jom_viewlevels` VALUES (1, 'Public', 0, '[1]');
INSERT INTO `jom_viewlevels` VALUES (2, 'Registered', 1, '[6,2,8]');
INSERT INTO `jom_viewlevels` VALUES (3, 'Special', 2, '[6,3,8]');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_weblinks`
-- 

DROP TABLE IF EXISTS `jom_weblinks`;
CREATE TABLE IF NOT EXISTS `jom_weblinks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `state` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `access` int(11) NOT NULL default '1',
  `params` text NOT NULL,
  `language` char(7) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Set if link is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jom_weblinks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jom_workers`
-- 

DROP TABLE IF EXISTS `jom_workers`;
CREATE TABLE IF NOT EXISTS `jom_workers` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `s_n` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `start_date` datetime NOT NULL,
  `dl_no` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cell` varchar(255) NOT NULL,
  `home` varchar(255) NOT NULL,
  `shirt_size` varchar(255) NOT NULL,
  `pant_leg` varchar(255) NOT NULL,
  `waist` varchar(255) NOT NULL,
  `receive_update_by` varchar(255) NOT NULL,
  `desired_shift` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_date` datetime NOT NULL,
  `active_status` int(11) NOT NULL,
  `verified_status` int(11) NOT NULL,
  `verification_code` varchar(255) NOT NULL,
  `initial` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=139 ;

-- 
-- Dumping data for table `jom_workers`
-- 

INSERT INTO `jom_workers` VALUES (135, 497, 'waqar', 'muneer', 'asdf', '2012-04-04', '2012-05-05 00:00:00', 'as', 'G', '1', 'waqarmuneer@gmail.com', '03336181248', '03336181249', 'S', '32', '30', '', '33', 'waqar', '2012-10-28 00:00:00', 'waqar', '2012-12-01 00:00:00', 0, 1, '01a271ee74ce52b9b920301f5331b8ca', 'wqr');
INSERT INTO `jom_workers` VALUES (133, 495, 'bhola', 'bhola g', 'sn', '2012-04-04', '2012-05-05 00:00:00', 'as', 'G', '1', 'bhola@gmail.com', '2222', '34', 'M', '30', '30', '', '33', 'waqar', '2012-10-28 00:00:00', 'waqar', '2012-12-02 00:00:00', 0, 1, 'ba743704f3021ade909c36df95a69056', '');
INSERT INTO `jom_workers` VALUES (134, 496, 'lala', 'lala g', 'asdf', '2012-04-04', '2012-05-05 00:00:00', 'as', 'G', '1', 'lala@gmail.com', '2222', '34', 'M', '30', '30', '', '33', 'waqar', '2012-10-28 00:00:00', 'waqar', '2012-10-29 00:00:00', 0, 1, '4397c5515cf51c347aab3977486ce081', 'lala');
INSERT INTO `jom_workers` VALUES (136, 498, 'fname', 'lname', 'sn', '1999-02-03', '2012-01-03 00:00:00', 'dl', 'G', '1', 'mp@gmail.com', '1111', '2222', 'M', '32', '32', '', '22', 'waqar', '2012-11-23 00:00:00', 'waqar', '2012-11-23 00:00:00', 0, 1, 'b36c6ce956792e87ed6d39d84591a2b3', 'initial');
INSERT INTO `jom_workers` VALUES (138, 500, 'waqar', 'mm', 'sdf', '1999-02-03', '2012-02-03 00:00:00', 'dl', 'G', '1', 'wwaqar@gmail.com', '033361812488', '033361812499', 'M', '34', '32', '', 'asf', 'waqar', '2012-12-01 00:00:00', 'waqar', '2012-12-01 00:00:00', 0, 0, '0bd88e88781af90950d325e537c8d8fc', 'sdf');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_worker_role`
-- 

DROP TABLE IF EXISTS `jom_worker_role`;
CREATE TABLE IF NOT EXISTS `jom_worker_role` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- 
-- Dumping data for table `jom_worker_role`
-- 

INSERT INTO `jom_worker_role` VALUES (1, 'admin', 'primary');
INSERT INTO `jom_worker_role` VALUES (2, 'cc', 'primary');
INSERT INTO `jom_worker_role` VALUES (3, 'cct', 'primary');
INSERT INTO `jom_worker_role` VALUES (4, 'acc', 'primary');
INSERT INTO `jom_worker_role` VALUES (5, 'acc-g', 'primary');
INSERT INTO `jom_worker_role` VALUES (6, 'drv-z', 'primary');
INSERT INTO `jom_worker_role` VALUES (7, 'drv-g', 'primary');
INSERT INTO `jom_worker_role` VALUES (8, 'ldr-p', 'primary');
INSERT INTO `jom_worker_role` VALUES (9, 'ldr-f', 'primary');
INSERT INTO `jom_worker_role` VALUES (10, 'admin', 'secondary');
INSERT INTO `jom_worker_role` VALUES (12, 'cc', 'secondary');
INSERT INTO `jom_worker_role` VALUES (13, 'cct', 'secondary');
INSERT INTO `jom_worker_role` VALUES (14, 'acc', 'secondary');
INSERT INTO `jom_worker_role` VALUES (15, 'acc-g', 'secondary');
INSERT INTO `jom_worker_role` VALUES (16, 'drv-z', 'secondary');
INSERT INTO `jom_worker_role` VALUES (17, 'drv-g', 'secondary');
INSERT INTO `jom_worker_role` VALUES (18, 'ldr-p', 'secondary');
INSERT INTO `jom_worker_role` VALUES (19, 'ldr-f', 'secondary');
INSERT INTO `jom_worker_role` VALUES (20, 'admin', 'additional');
INSERT INTO `jom_worker_role` VALUES (21, 'cc', 'additional');
INSERT INTO `jom_worker_role` VALUES (23, 'cct', 'additional');
INSERT INTO `jom_worker_role` VALUES (24, 'acc', 'additional');
INSERT INTO `jom_worker_role` VALUES (25, 'acc-g', 'additional');
INSERT INTO `jom_worker_role` VALUES (26, 'drv-z', 'additional');
INSERT INTO `jom_worker_role` VALUES (27, 'drv-g', 'additional');
INSERT INTO `jom_worker_role` VALUES (28, 'ldr-p', 'additional');
INSERT INTO `jom_worker_role` VALUES (29, 'ldr-f', 'additional');
INSERT INTO `jom_worker_role` VALUES (30, 'packer', 'primary');
INSERT INTO `jom_worker_role` VALUES (31, 'packer', 'secondary');
INSERT INTO `jom_worker_role` VALUES (32, 'packer', 'additional');

-- --------------------------------------------------------

-- 
-- Table structure for table `jom_worker_role_index`
-- 

DROP TABLE IF EXISTS `jom_worker_role_index`;
CREATE TABLE IF NOT EXISTS `jom_worker_role_index` (
  `id` int(11) NOT NULL auto_increment,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wage_hr` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=572 ;

-- 
-- Dumping data for table `jom_worker_role_index`
-- 

INSERT INTO `jom_worker_role_index` VALUES (21, 12, 0, '555');
INSERT INTO `jom_worker_role_index` VALUES (20, 11, 0, '55');
INSERT INTO `jom_worker_role_index` VALUES (19, 3, 0, '5');
INSERT INTO `jom_worker_role_index` VALUES (526, 0, 496, '');
INSERT INTO `jom_worker_role_index` VALUES (524, 6, 496, '77');
INSERT INTO `jom_worker_role_index` VALUES (525, 19, 496, '22');
INSERT INTO `jom_worker_role_index` VALUES (571, 0, 495, '');
INSERT INTO `jom_worker_role_index` VALUES (570, 31, 495, '55');
INSERT INTO `jom_worker_role_index` VALUES (569, 8, 495, '22');
INSERT INTO `jom_worker_role_index` VALUES (559, 27, 497, '44');
INSERT INTO `jom_worker_role_index` VALUES (558, 19, 497, '65');
INSERT INTO `jom_worker_role_index` VALUES (557, 3, 497, '22');
INSERT INTO `jom_worker_role_index` VALUES (551, 3, 498, '22');
INSERT INTO `jom_worker_role_index` VALUES (552, 0, 498, '');
INSERT INTO `jom_worker_role_index` VALUES (553, 0, 498, '');
INSERT INTO `jom_worker_role_index` VALUES (565, 0, 500, '');
INSERT INTO `jom_worker_role_index` VALUES (564, 0, 500, '');
INSERT INTO `jom_worker_role_index` VALUES (563, 1, 500, '23');
