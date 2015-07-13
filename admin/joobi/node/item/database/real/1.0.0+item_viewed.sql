CREATE TABLE IF NOT EXISTS `#__item_viewed` (
  `itvwid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `cookieid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `total` smallint(5) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itvwid`),
  UNIQUE KEY `UK_item_viewed_uid_modified` (`uid`,`modified`),
  UNIQUE KEY `UK_item_viewed_sessionid_modified` (`cookieid`,`modified`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
