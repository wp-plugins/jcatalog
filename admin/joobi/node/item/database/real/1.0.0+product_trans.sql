CREATE TABLE IF NOT EXISTS `#__product_trans` (
  `pid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `name` varchar(150) NOT NULL,
  `introduction` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `seotitle` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  `promo` text NOT NULL,
  PRIMARY KEY (`pid`,`lgid`),
  FULLTEXT KEY `IX_product_trans_name` (`name`),
  FULLTEXT KEY `IX_product_trans_introduction` (`introduction`),
  FULLTEXT KEY `IX_product_trans_description` (`description`)
) ENGINE=MyISAM  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;