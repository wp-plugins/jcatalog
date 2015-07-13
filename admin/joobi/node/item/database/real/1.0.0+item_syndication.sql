CREATE TABLE IF NOT EXISTS `#__item_syndication` (
  `pid` int(10) unsigned NOT NULL,
  `vendid` int(10) unsigned NOT NULL,
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `ownervendid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`,`vendid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;