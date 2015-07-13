CREATE TABLE IF NOT EXISTS `#__wishlist_node` (
  `wlid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(250) NOT NULL,
  `type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `authoruid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `private` tinyint(4) NOT NULL DEFAULT '1',
  `mode` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wlid`),
  UNIQUE KEY `UK_wishlist_node_namekey` (`namekey`),
  UNIQUE KEY `UK_wishlist_node_type_authoruid` (`authoruid`,`type`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;