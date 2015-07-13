CREATE TABLE IF NOT EXISTS `#__productcat_trans` (
  `lgid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `seotitle` varchar(255) NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  PRIMARY KEY (`lgid`,`catid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;