CREATE TABLE IF NOT EXISTS `#__rule_node` (
  `ruleid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cdtid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `description` text,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `action` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `private` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ruleid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;