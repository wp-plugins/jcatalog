CREATE TABLE IF NOT EXISTS `#__mailing_queue` (
  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mgid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `senddate` int(10) unsigned NOT NULL DEFAULT '0',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '100',
  `attempt` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cmpgnid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `lsid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`),
  KEY `IX_mailing_queue_publish_priority_senddate` (`publish`,`priority`,`senddate`),
  KEY `IX_mailing_queue_uid_cmpgnid_lsid` (`uid`,`cmpgnid`,`lsid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;