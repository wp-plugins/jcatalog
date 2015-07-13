CREATE TABLE IF NOT EXISTS `#__translation_reference` (
  `wid` mediumint(8) unsigned NOT NULL,
  `load` tinyint(4) NOT NULL DEFAULT '0',
  `imac` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`,`imac`)
) ENGINE=MyISAM  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;