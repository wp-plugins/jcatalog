CREATE TABLE IF NOT EXISTS `#__vendor_trans` (
  `vendid` int(10) unsigned NOT NULL,
  `lgid` int(10) unsigned NOT NULL,
  `name` varchar(254) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vendid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;