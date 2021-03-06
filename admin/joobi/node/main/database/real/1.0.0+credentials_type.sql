CREATE TABLE IF NOT EXISTS `#__credentials_type` (
  `crdidtype` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `category` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`crdidtype`),
  UNIQUE KEY `UK_namekey_jos_credentials_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;