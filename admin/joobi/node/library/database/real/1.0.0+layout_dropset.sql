CREATE TABLE IF NOT EXISTS `#__layout_dropset` (
  `did` mediumint(8) unsigned NOT NULL,
  `yid` mediumint(8) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`did`,`yid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;