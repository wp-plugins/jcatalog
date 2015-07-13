CREATE TABLE IF NOT EXISTS `#__translation_en` (
  `text` text   NOT NULL,
  `auto` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `imac` varchar(255) NOT NULL,
  `nbchars` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`imac`),
  KEY `ix_translation_en_nbchars` (`nbchars`),
  FULLTEXT KEY `FTXT_translation_en_text` (`text`)
) ENGINE=MyISAM  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;