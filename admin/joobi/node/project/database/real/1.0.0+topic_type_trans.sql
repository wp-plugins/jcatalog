CREATE TABLE IF NOT EXISTS `#__topic_type_trans` (
  `typeid` smallint(5) unsigned NOT NULL,
  `lgid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  PRIMARY KEY (`typeid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;