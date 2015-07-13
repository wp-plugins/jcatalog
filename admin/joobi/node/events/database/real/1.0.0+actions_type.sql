CREATE TABLE IF NOT EXISTS `#__actions_type` (
  `acttyid` smallint(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`acttyid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;