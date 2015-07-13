CREATE TABLE IF NOT EXISTS `#__mailbox_messages` (
  `msgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inbid` int(10) unsigned NOT NULL DEFAULT '0',
  `sender` varchar(255) NOT NULL,
  `header` text,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `box` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `size` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`msgid`),
  KEY `IX_mailbox_messages_inbid` (`inbid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;