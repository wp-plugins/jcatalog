CREATE TABLE IF NOT EXISTS `#__joobi_states` (
  `stateid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `namekey` varchar(64) NOT NULL,
  `code2` char(2) DEFAULT NULL,
  `code3` char(3) DEFAULT NULL,
  `publish` tinyint(2) unsigned DEFAULT '1',
  `ctyid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`stateid`),
  UNIQUE KEY `UK_code3_ctryid` (`code3`,`ctyid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;