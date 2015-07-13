CREATE TABLE IF NOT EXISTS `#__featured_trans` (
  `ftdid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '0',
  `badgename` varchar(100) NOT NULL,
  PRIMARY KEY (`ftdid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;