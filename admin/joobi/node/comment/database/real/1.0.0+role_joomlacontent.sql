CREATE TABLE IF NOT EXISTS `#__role_joomlacontent` (
  `id` int(11) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `introrolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `comment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rating_sum` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rating_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`rolid`,`comment`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;