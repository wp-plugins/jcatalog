CREATE TABLE IF NOT EXISTS `#__space_theme` (
  `wsid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `size` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `device` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tmid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wsid`,`size`,`device`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;