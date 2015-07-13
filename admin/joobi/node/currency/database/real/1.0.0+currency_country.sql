CREATE TABLE IF NOT EXISTS `#__currency_country` (
  `curid` int(10) unsigned NOT NULL,
  `ctyid` int(10) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`curid`,`ctyid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;