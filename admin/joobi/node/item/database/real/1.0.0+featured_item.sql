CREATE TABLE IF NOT EXISTS `#__featured_item` (
  `pid` int(10) unsigned NOT NULL,
  `ftdid` smallint(5) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  `category_item` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `catalog_carrousel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `catalog_item` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`,`ftdid`),
  KEY `PK_item_featured_ordering_status_expiration` (`ordering`,`status`,`expiration`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;