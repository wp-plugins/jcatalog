CREATE TABLE IF NOT EXISTS `#__ticket_reply_files` (
  `filid` int(10) unsigned NOT NULL,
  `tkrid` int(10) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`tkrid`,`filid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;