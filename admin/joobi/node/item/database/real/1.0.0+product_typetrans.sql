CREATE TABLE IF NOT EXISTS `#__product_typetrans` (
  `prodtypid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`prodtypid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;