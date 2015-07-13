CREATE TABLE IF NOT EXISTS `#__product_poptions` (
  `opid` mediumint(8) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '5',
  PRIMARY KEY (`pid`,`opid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;