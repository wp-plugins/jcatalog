CREATE TABLE IF NOT EXISTS `#__currency_node` (
  `curid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `code` char(255) NOT NULL,
  `number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `symbol` varchar(8) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cents` varchar(20) NOT NULL,
  `basic` smallint(5) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `rate` decimal(10,6) NOT NULL DEFAULT '1.000000',
  `accepted` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`curid`),
  UNIQUE KEY `UK_code` (`code`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;