CREATE TABLE IF NOT EXISTS `#__orders_products` (
  `ordpid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oid` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(150) NOT NULL,
  `price` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `quantity` decimal(12,2) unsigned NOT NULL DEFAULT '1.00',
  `tax` decimal(14,4) unsigned NOT NULL DEFAULT '0.0000',
  `discount` decimal(15,2) unsigned NOT NULL DEFAULT '0.00',
  `unitprice` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `baseprice` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `unitpriceref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `priceref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `discountref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `bundle` smallint(5) unsigned NOT NULL DEFAULT '0',
  `curid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `vendid` int(10) unsigned NOT NULL DEFAULT '1',
  `curidref` int(10) unsigned NOT NULL DEFAULT '0',
  `basepriceref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `pricetype` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `useraffle` tinyint(4) NOT NULL DEFAULT '0',
  `recurring` tinyint(4) NOT NULL DEFAULT '0',
  `weight` decimal(10,4) unsigned NOT NULL DEFAULT '0.0000',
  `unitid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `subtotal` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `subtotalref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `prodtypid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `taxref` decimal(14,4) unsigned NOT NULL DEFAULT '0.0000',
  `priceid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `resellerid` int(10) unsigned NOT NULL DEFAULT '0',
  `bookingfee` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `bookingfeeref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`ordpid`),
  KEY `IX_orders_products_oid` (`oid`),
  KEY `IX_orders_products_pid` (`pid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;