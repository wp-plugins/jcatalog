CREATE TABLE IF NOT EXISTS `#__extension_userinfos` (
  `wid` int(10) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ltype` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `license` varchar(255) NOT NULL,
  `token` varchar(254) NOT NULL,
  `expire` int(10) unsigned NOT NULL DEFAULT '0',
  `maintenance` int(10) unsigned NOT NULL DEFAULT '0',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `subtype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wid`,`level`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;