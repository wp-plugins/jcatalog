CREATE TABLE IF NOT EXISTS `#__layout_fields` (
  `yid` int(10) unsigned NOT NULL,
  `fdid` int(10) unsigned NOT NULL,
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`yid`,`fdid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;