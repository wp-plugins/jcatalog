CREATE TABLE IF NOT EXISTS `#__extension_dependency` (
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ref_wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wid`,`ref_wid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;