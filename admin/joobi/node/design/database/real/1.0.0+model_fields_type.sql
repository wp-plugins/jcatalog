CREATE TABLE IF NOT EXISTS `#__model_fields_type` (
  `fdid` int(10) unsigned NOT NULL,
  `typeid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`fdid`,`typeid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;