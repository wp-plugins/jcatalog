CREATE TABLE IF NOT EXISTS `#__topic_task_comment` (
  `commentid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description_comment` text NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `author` int(10) unsigned NOT NULL DEFAULT '0',
  `taskid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL,
  `checktaskid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`commentid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;