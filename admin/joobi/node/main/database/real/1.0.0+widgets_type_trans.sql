CREATE TABLE IF NOT EXISTS `#__widgets_type_trans` (
  `wgtypeid` int(10) unsigned NOT NULL,
  `lgid` smallint(5) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  PRIMARY KEY (`wgtypeid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;