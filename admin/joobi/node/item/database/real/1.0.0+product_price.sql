CREATE TABLE IF NOT EXISTS `#__product_price` (
  `priceid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(3) NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `vendid` int(10) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`priceid`),
  UNIQUE KEY `UK_namekey_product_price` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;