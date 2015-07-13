CREATE TABLE IF NOT EXISTS `#__country_language` (
  `ctyid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `url` varchar(64) NOT NULL,
  PRIMARY KEY (`ctyid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;