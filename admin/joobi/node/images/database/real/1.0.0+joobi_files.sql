CREATE TABLE IF NOT EXISTS `#__joobi_files` (
  `filid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(254) NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `md5` varchar(40) NOT NULL DEFAULT '',
  `secure` tinyint(4) NOT NULL DEFAULT '0',
  `thumbnail` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `width` smallint(6) NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `twidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `theight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `mime` varchar(40) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `alias` varchar(255) NOT NULL,
  `vendid` int(10) unsigned NOT NULL DEFAULT '1',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `storage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `folder` varchar(254) NOT NULL,
  PRIMARY KEY (`filid`),
  UNIQUE KEY `UK_joobi_files_name_type_path` (`path`(70),`type`(5),`name`(250))
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;