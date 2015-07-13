CREATE TABLE IF NOT EXISTS `#__captcha_node` (
  `cptid` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `password` char(255) NOT NULL,
  `addon` int(11) NOT NULL DEFAULT '0',
  `crypt` char(10) NOT NULL,
  `used` int(11) NOT NULL DEFAULT '0',
  `image` varchar(40) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`cptid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;