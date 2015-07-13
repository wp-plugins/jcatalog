CREATE TABLE IF NOT EXISTS `#__product_downloads` (
  `pid` int(10) unsigned NOT NULL,
  `filid` int(10) unsigned NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`,`filid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;