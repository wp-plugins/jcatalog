CREATE TABLE IF NOT EXISTS `#__ticket_replytrans` (
  `tkrid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tkrid`,`lgid`),
  FULLTEXT KEY `IX_ticket_replytrans_description` (`description`)
) ENGINE=MyISAM  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;