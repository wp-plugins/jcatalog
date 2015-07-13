CREATE TABLE IF NOT EXISTS `#__layout_trans` (
  `yid` mediumint(8) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `wname` varchar(255) NOT NULL,
  `wdescription` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`yid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;