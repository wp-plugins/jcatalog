CREATE TABLE IF NOT EXISTS `#__ticket_template` (
  `tktid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pjid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `tktypeid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `private` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`tktid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;