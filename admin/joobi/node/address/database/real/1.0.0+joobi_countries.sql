CREATE TABLE IF NOT EXISTS `#__joobi_countries` (
  `ctyid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `isocode2` char(2) NOT NULL,
  `namekey` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  `isocode3` char(3) NOT NULL,
  `numcode` smallint(6) NOT NULL DEFAULT '0',
  `timezone` smallint(6) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '1',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ctyid`),
  UNIQUE KEY `UK_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;