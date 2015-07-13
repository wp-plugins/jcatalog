CREATE TABLE IF NOT EXISTS `#__dataset_constraints` (
  `ctid` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `dbtid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(255) NOT NULL,
  PRIMARY KEY (`ctid`),
  UNIQUE KEY `UK_dataset_constraints_namekey` (`namekey`),
  KEY `IX_dataset_constraints_dbtid_type` (`dbtid`,`type`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;