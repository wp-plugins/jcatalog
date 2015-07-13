CREATE TABLE IF NOT EXISTS `#__currency_conversion_history` (
  `curhisid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `curid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `curid_ref` smallint(5) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `exchange` decimal(12,6) unsigned NOT NULL DEFAULT '0.000000',
  `alias` varchar(255) NOT NULL,
  `exsiteid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`curhisid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;