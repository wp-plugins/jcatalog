CREATE TABLE IF NOT EXISTS `#__mailing_type` (
  `mgtypeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `designation` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`mgtypeid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;