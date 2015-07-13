CREATE TABLE IF NOT EXISTS `#__emanager_mailbox` (
  `wid` mediumint(8) unsigned NOT NULL,
  `inbid` smallint(5) unsigned NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '99',
  PRIMARY KEY (`inbid`,`wid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;