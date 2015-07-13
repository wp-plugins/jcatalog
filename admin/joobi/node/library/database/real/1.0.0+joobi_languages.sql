CREATE TABLE IF NOT EXISTS `#__joobi_languages` (
  `lgid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(10)  NOT NULL,
  `name` varchar(100)  NOT NULL,
  `main` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `real` varchar(100)  NOT NULL,
  `premium` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rtl` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `availsite` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `availadmin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `localeconv` text  NOT NULL,
  `locale` varchar(255)  NOT NULL,
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `automatic` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lgid`),
  UNIQUE KEY `UK_languages_code` (`code`),
  KEY `IX_languages_main_publish_availadmin_availsite` (`main`,`publish`,`availadmin`,`availsite`)
) ENGINE=InnoDB    /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;