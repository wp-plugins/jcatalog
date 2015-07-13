CREATE TABLE IF NOT EXISTS `#__ticket_typetrans` (
  `tktypeid` smallint(5) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `auto` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`tktypeid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;