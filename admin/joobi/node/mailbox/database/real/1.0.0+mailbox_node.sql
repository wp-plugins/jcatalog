CREATE TABLE IF NOT EXISTS `#__mailbox_node` (
  `inbid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(250) NOT NULL,
  `server` varchar(250) NOT NULL,
  `username` varchar(255) NOT NULL,
  `addon` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `name` varchar(250) NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `params` text,
  PRIMARY KEY (`inbid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;