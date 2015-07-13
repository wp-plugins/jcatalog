CREATE TABLE IF NOT EXISTS `#__ticket_clickyesno` (
  `clickid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tkid` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` int(10) unsigned DEFAULT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `yesno` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`clickid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;