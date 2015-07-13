CREATE TABLE IF NOT EXISTS `#__project_trans` (
  `pjid` smallint(5) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pjid`,`lgid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;