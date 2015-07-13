CREATE TABLE IF NOT EXISTS `#__emanager_handled` (
  `email` varchar(250) NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `total` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`email`,`type`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;