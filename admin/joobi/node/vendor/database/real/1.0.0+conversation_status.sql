CREATE TABLE IF NOT EXISTS `#__conversation_status` (
  `uid` int(10) unsigned NOT NULL,
  `mcid` int(10) unsigned NOT NULL,
  `isread` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `replies` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`mcid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;