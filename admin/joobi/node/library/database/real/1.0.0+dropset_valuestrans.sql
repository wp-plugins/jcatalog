CREATE TABLE IF NOT EXISTS `#__dropset_valuestrans` (
  `vid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;