CREATE TABLE IF NOT EXISTS `#__role_node` (
  `rolid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lft` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rgt` smallint(5) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `joomla` smallint(5) unsigned NOT NULL DEFAULT '0',
  `j16` int(10) unsigned NOT NULL DEFAULT '1',
  `namekey` varchar(50) NOT NULL DEFAULT '',
  `color` varchar(20) NOT NULL DEFAULT 'black',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `depth` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rolid`),
  UNIQUE KEY `UK_role_node_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;