CREATE TABLE IF NOT EXISTS `#__conversation_to` (
  `uid` int(10) unsigned NOT NULL,
  `mcid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`,`mcid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;