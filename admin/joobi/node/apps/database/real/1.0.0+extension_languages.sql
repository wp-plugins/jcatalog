CREATE TABLE IF NOT EXISTS `#__extension_languages` (
  `wid` mediumint(8) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL,
  `available` tinyint(4) NOT NULL DEFAULT '0',
  `translation` tinyint(4) NOT NULL DEFAULT '1',
  `completed` double(5,2) unsigned NOT NULL DEFAULT '0.00',
  `automatic` double(5,2) unsigned NOT NULL DEFAULT '0.00',
  `totalimac` int(10) unsigned NOT NULL DEFAULT '0',
  `manual` double(5,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`wid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;