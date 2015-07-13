CREATE TABLE IF NOT EXISTS `#__scheduler_processes` (
  `pcsid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pcsid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;