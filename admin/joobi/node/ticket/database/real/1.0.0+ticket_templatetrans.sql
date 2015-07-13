CREATE TABLE IF NOT EXISTS `#__ticket_templatetrans` (
  `lgid` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `tktid` int(10) unsigned NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tktid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;