CREATE TABLE IF NOT EXISTS `#__action_node` (
  `actid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(255) NOT NULL,
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `folder` varchar(30) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `filter` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `before` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`actid`),
  UNIQUE KEY `UK_action_node_namekey` (`namekey`),
  KEY `IX_action_node_wid_publish` (`wid`,`publish`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;