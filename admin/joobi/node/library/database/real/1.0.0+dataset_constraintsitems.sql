CREATE TABLE IF NOT EXISTS `#__dataset_constraintsitems` (
  `ctid` mediumint(5) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `sort` tinyint(4) NOT NULL DEFAULT '0',
  `dbcid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`dbcid`,`ctid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;