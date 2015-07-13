CREATE TABLE IF NOT EXISTS `#__dataset_foreign` (
  `fkid` smallint(5) NOT NULL AUTO_INCREMENT,
  `dbtid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ref_dbtid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ondelete` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `feid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ref_feid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(100) NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `map` varchar(50) NOT NULL,
  `map2` varchar(50) NOT NULL,
  `onupdate` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '99',
  PRIMARY KEY (`fkid`),
  UNIQUE KEY `UK_dataset_foreign_feid_dbtid_red_dbtid` (`feid`,`dbtid`,`ref_dbtid`),
  UNIQUE KEY `UK_dataset_foreign_namekey` (`namekey`),
  KEY `IX_dataset_foreign_publish_ref_feid` (`ref_feid`,`publish`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;