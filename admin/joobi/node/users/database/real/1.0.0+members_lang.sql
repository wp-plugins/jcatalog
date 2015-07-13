CREATE TABLE IF NOT EXISTS `#__members_lang` (
  `uid` int(10) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;