CREATE TABLE IF NOT EXISTS `#__rule_condition` (
  `cdtid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(254) NOT NULL,
  `fromemail` varchar(150) DEFAULT NULL,
  `toemail` varchar(150) DEFAULT NULL,
  `wordswithin` varchar(254) DEFAULT NULL,
  `wordsnotin` varchar(254) DEFAULT NULL,
  `condition` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `datefrom` int(10) unsigned NOT NULL DEFAULT '0',
  `dateto` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cdtid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;