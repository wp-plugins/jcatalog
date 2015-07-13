CREATE TABLE IF NOT EXISTS `#__project_extension` (
  `pjid` smallint(5) unsigned NOT NULL,
  `wid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`pjid`,`wid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;