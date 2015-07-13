CREATE TABLE IF NOT EXISTS `#__layout_mlinkstrans` (
  `mid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  PRIMARY KEY (`mid`,`lgid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;