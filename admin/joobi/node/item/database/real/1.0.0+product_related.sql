CREATE TABLE IF NOT EXISTS `#__product_related` (
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `relpid` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`,`relpid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;