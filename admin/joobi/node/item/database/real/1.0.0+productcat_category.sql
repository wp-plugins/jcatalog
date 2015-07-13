CREATE TABLE IF NOT EXISTS `#__productcat_category` (
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `catidparent` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`,`catidparent`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;