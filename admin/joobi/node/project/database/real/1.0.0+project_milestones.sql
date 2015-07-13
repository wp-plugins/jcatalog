CREATE TABLE IF NOT EXISTS `#__project_milestones` (
  `pjid` int(11) unsigned NOT NULL,
  `mileid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pjid`,`mileid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;