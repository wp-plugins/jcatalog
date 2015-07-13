CREATE TABLE IF NOT EXISTS `#__site_node` (
  `stid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip` int(10) unsigned DEFAULT NULL,
  `domain` tinyint(3) unsigned NOT NULL DEFAULT '31',
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `alias` varchar(200) NOT NULL,
  PRIMARY KEY (`stid`),
  UNIQUE KEY `IX_site_extension_url` (`url`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;