CREATE TABLE IF NOT EXISTS `#__eguillage_roles` (
  `ctrid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `override` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ctrid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;