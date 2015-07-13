CREATE TABLE IF NOT EXISTS `#__role_joomlacategories` (
  `id` int(11) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `introrolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `comment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`rolid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;