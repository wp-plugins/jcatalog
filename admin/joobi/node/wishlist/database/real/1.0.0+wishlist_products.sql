CREATE TABLE IF NOT EXISTS `#__wishlist_products` (
  `pid` int(10) unsigned NOT NULL,
  `wlid` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `vendid` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(254) NOT NULL,
  PRIMARY KEY (`wlid`,`pid`,`vendid`,`catid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;