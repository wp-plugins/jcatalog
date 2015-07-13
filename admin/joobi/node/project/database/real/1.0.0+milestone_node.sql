CREATE TABLE IF NOT EXISTS `#__milestone_node` (
  `mileid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deadline` int(10) unsigned NOT NULL DEFAULT '0',
  `startdate` int(10) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`mileid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;