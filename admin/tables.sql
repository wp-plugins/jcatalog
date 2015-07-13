CREATE TABLE IF NOT EXISTS `#__address_node` (
  `adid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `address3` varchar(100) NOT NULL,
  `city` varchar(40) NOT NULL,
  `state` varchar(40) NOT NULL,
  `zipcode` varchar(25) NOT NULL,
  `ctyid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(150) NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL DEFAULT 'default',
  `stateid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `vendid` int(10) unsigned NOT NULL DEFAULT '0',
  `premium` tinyint(4) NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `business` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `phone` varchar(20) NOT NULL,
  `params` text NOT NULL,
  `latitude` double(12,8) NOT NULL DEFAULT '222.00000000',
  `longitude` double(12,8) NOT NULL DEFAULT '222.00000000',
  `location` varchar(255) NOT NULL,
  `found` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lastcheck` int(10) unsigned NOT NULL DEFAULT '0',
  `mapservice` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `usercreate` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`adid`),
  KEY `IX_address_node_location` (`location`),
  KEY `IX_address_node_uid` (`uid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__joobi_countries` (
  `ctyid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `isocode2` char(2) NOT NULL,
  `namekey` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  `isocode3` char(3) NOT NULL,
  `numcode` smallint(6) NOT NULL DEFAULT '0',
  `timezone` smallint(6) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '1',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ctyid`),
  UNIQUE KEY `UK_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__country_language` (
  `ctyid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `url` varchar(64) NOT NULL,
  PRIMARY KEY (`ctyid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__joobi_states` (
  `stateid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `namekey` varchar(64) NOT NULL,
  `code2` char(2) DEFAULT NULL,
  `code3` char(3) DEFAULT NULL,
  `publish` tinyint(2) unsigned DEFAULT '1',
  `ctyid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`stateid`),
  UNIQUE KEY `UK_code3_ctryid` (`code3`,`ctyid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__currency_country` (
  `curid` int(10) unsigned NOT NULL,
  `ctyid` int(10) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`curid`,`ctyid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__currency_conversion_history` (
  `curhisid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `curid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `curid_ref` smallint(5) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `exchange` decimal(12,6) unsigned NOT NULL DEFAULT '0.000000',
  `alias` varchar(255) NOT NULL,
  `exsiteid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`curhisid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__currency_node` (
  `curid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `code` char(255) NOT NULL,
  `number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `symbol` varchar(8) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cents` varchar(20) NOT NULL,
  `basic` smallint(5) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `rate` decimal(10,6) NOT NULL DEFAULT '1.000000',
  `accepted` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`curid`),
  UNIQUE KEY `UK_code` (`code`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__currency_echangesites` (
  `exsiteid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `website` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`exsiteid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__currency_conversion` (
  `curid` tinyint(3) unsigned NOT NULL,
  `curid_ref` smallint(5) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `exchange` decimal(12,6) unsigned NOT NULL DEFAULT '0.000000',
  `rate` decimal(12,6) unsigned NOT NULL DEFAULT '0.000000',
  `fee` decimal(4,2) unsigned NOT NULL DEFAULT '0.00',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `accepted` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`curid`,`curid_ref`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__project_node` (
  `pjid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(100) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lft` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rgt` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '7',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '99',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `startdate` int(10) unsigned NOT NULL DEFAULT '0',
  `enddate` int(10) unsigned NOT NULL DEFAULT '0',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `author` int(10) unsigned NOT NULL DEFAULT '0',
  `estimatedtime` int(10) unsigned NOT NULL DEFAULT '0',
  `depth` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `frontend` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ltkid` int(10) unsigned NOT NULL DEFAULT '0',
  `tickets` smallint(5) unsigned NOT NULL DEFAULT '0',
  `oncreation` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `onreplies` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `toassigned` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sendcopy` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`pjid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_trans` (
  `tkid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tkid`,`lgid`),
  FULLTEXT KEY `IX_ticket_trans_name` (`name`),
  FULLTEXT KEY `IX_ticket_trans_description` (`description`)
) ENGINE=MyISAM  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_reply` (
  `tkrid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `authoruid` int(10) unsigned NOT NULL DEFAULT '0',
  `tkid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `timeresp` int(10) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `timing` smallint(5) unsigned NOT NULL DEFAULT '0',
  `wordcount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `charcount` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `score` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `comment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip` double unsigned DEFAULT '0',
  PRIMARY KEY (`tkrid`),
  KEY `IX_ticket_reply_created` (`created`),
  KEY `IX_ticket_node_tkid` (`tkid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_replytrans` (
  `tkrid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tkrid`,`lgid`),
  FULLTEXT KEY `IX_ticket_replytrans_description` (`description`)
) ENGINE=MyISAM  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_node` (
  `tkid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tktypeid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '20',
  `deadline` int(10) unsigned NOT NULL DEFAULT '4200000003',
  `assigned` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(100) NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `authoruid` int(10) unsigned NOT NULL DEFAULT '0',
  `stid` int(10) unsigned NOT NULL DEFAULT '0',
  `pjid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `private` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `resptime` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `assignuid` int(10) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `replies` smallint(5) unsigned NOT NULL DEFAULT '0',
  `timing` smallint(5) unsigned NOT NULL DEFAULT '0',
  `wordcount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `charcount` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `elapsed` int(10) unsigned NOT NULL DEFAULT '0',
  `sticky` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lock` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `score` int(10) unsigned NOT NULL DEFAULT '0',
  `votes` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `etid` int(10) unsigned NOT NULL DEFAULT '0',
  `useful` int(10) unsigned NOT NULL DEFAULT '0',
  `usefulclick` int(10) unsigned NOT NULL DEFAULT '0',
  `commenttype` smallint(5) unsigned NOT NULL DEFAULT '0',
  `usefulrate` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` double unsigned DEFAULT '0',
  `comment` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `followup` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `assignbyuid` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `read` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `latereply` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lcid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tkid`),
  KEY `IX_ticket_node_authoruid` (`authoruid`),
  KEY `IX_ticket_node_pjid` (`pjid`),
  KEY `IX_ticket_node_modified` (`modified`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_clickyesno` (
  `clickid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tkid` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` int(10) unsigned DEFAULT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `yesno` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`clickid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__role_joomlasections` (
  `id` int(11) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `introrolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `comment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`rolid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__project_members` (
  `pjid` smallint(5) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `supportlevel` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `role` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `notify` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`pjid`,`uid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__role_joomlacategories` (
  `id` int(11) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `introrolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `comment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`rolid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__members_node` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL,
  `username` varchar(40) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `blocked` tinyint(3) NOT NULL DEFAULT '0',
  `activation` varchar(100) NOT NULL,
  `timezone` smallint(6) NOT NULL DEFAULT '999',
  `confirmed` tinyint(3) NOT NULL DEFAULT '0',
  `registerdate` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `lgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `html` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `registered` tinyint(4) NOT NULL DEFAULT '1',
  `unsub` tinyint(4) NOT NULL DEFAULT '0',
  `login` int(10) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `visibility` tinyint(3) unsigned NOT NULL DEFAULT '231',
  `curid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ip` double unsigned NOT NULL DEFAULT '0',
  `ctyid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(20) NOT NULL,
  `filid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `UK_members_node_email` (`email`),
  UNIQUE KEY `UK_members_node_username` (`username`),
  KEY `IX_members_node_name` (`name`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__role_joomlacontent` (
  `id` int(11) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `introrolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `comment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rating_sum` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rating_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`rolid`,`comment`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__project_trans` (
  `pjid` smallint(5) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pjid`,`lgid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_files` (
  `filid` int(10) unsigned NOT NULL,
  `tkid` int(10) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tkid`,`filid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_reply_files` (
  `filid` int(10) unsigned NOT NULL,
  `tkrid` int(10) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`tkrid`,`filid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_typetrans` (
  `tktypeid` smallint(5) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `auto` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`tktypeid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__site_node` (
  `stid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip` int(10) unsigned DEFAULT NULL,
  `domain` tinyint(3) unsigned NOT NULL DEFAULT '31',
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `alias` varchar(200) NOT NULL,
  PRIMARY KEY (`stid`),
  UNIQUE KEY `IX_site_extension_url` (`url`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_template` (
  `tktid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pjid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `tktypeid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `private` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`tktid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__joobi_files` (
  `filid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(254) NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `md5` varchar(40) NOT NULL DEFAULT '',
  `secure` tinyint(4) NOT NULL DEFAULT '0',
  `thumbnail` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `width` smallint(6) NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `twidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `theight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `mime` varchar(40) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `alias` varchar(255) NOT NULL,
  `vendid` int(10) unsigned NOT NULL DEFAULT '1',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `storage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `folder` varchar(254) NOT NULL,
  PRIMARY KEY (`filid`),
  UNIQUE KEY `UK_joobi_files_name_type_path` (`path`(70),`type`(5),`name`(250))
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__productcat_product` (
  `pid` int(11) NOT NULL,
  `catid` smallint(5) NOT NULL DEFAULT '0',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '99',
  `used` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `premium` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`,`pid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_type` (
  `tktypeid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '9',
  PRIMARY KEY (`tktypeid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_rating` (
  `trid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tkrid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rate` int(10) unsigned NOT NULL DEFAULT '0',
  `supportuid` int(10) unsigned NOT NULL DEFAULT '0',
  `pjid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`trid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__ticket_templatetrans` (
  `lgid` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `tktid` int(10) unsigned NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tktid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_node` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `curid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `availablestart` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `weight` decimal(10,4) unsigned NOT NULL DEFAULT '0.0000',
  `filid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `prodtypid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(150) NOT NULL,
  `stock` mediumint(9) NOT NULL DEFAULT '-1',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `numcat` smallint(5) unsigned NOT NULL DEFAULT '0',
  `publishstart` int(10) unsigned NOT NULL DEFAULT '0',
  `publishend` int(10) unsigned NOT NULL DEFAULT '0',
  `bundle` smallint(5) unsigned NOT NULL DEFAULT '0',
  `comment` tinyint(4) NOT NULL DEFAULT '1',
  `numdiscount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `vendid` int(10) unsigned NOT NULL DEFAULT '1',
  `lsid` varchar(255) NOT NULL DEFAULT '',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `nbreviews` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `votes` int(11) NOT NULL DEFAULT '0',
  `payment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `priceid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `useraffle` tinyint(4) NOT NULL DEFAULT '0',
  `unitid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `nbsold` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `author` int(10) unsigned NOT NULL DEFAULT '0',
  `relnum` smallint(5) unsigned NOT NULL DEFAULT '0',
  `electronic` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `availableend` int(10) unsigned NOT NULL DEFAULT '0',
  `previewid` int(10) unsigned NOT NULL DEFAULT '0',
  `cssclass` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `blocked` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `resell` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `target` int(10) unsigned NOT NULL DEFAULT '0',
  `targettotal` int(10) unsigned NOT NULL DEFAULT '0',
  `adid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid_buy` int(10) unsigned NOT NULL DEFAULT '0',
  `discountrate` double(5,2) unsigned NOT NULL DEFAULT '0.00',
  `discountvalue` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `migid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `migrefid` int(10) unsigned NOT NULL DEFAULT '0',
  `location` varchar(254) NOT NULL,
  `longitude` double(12,8) NOT NULL DEFAULT '222.00000000',
  `latitude` double(12,8) NOT NULL DEFAULT '222.00000000',
  `featuredate` int(10) unsigned NOT NULL DEFAULT '0',
  `color` varchar(100) NOT NULL,
  `length` int(10) unsigned NOT NULL DEFAULT '0',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `UK_product_node_namekey` (`namekey`),
  KEY `IX_product_node_publish_prodtypid` (`publish`,`prodtypid`),
  KEY `IX_product_node_vendid` (`vendid`),
  KEY `IX_product_node_longitute_latitude` (`latitude`,`longitude`),
  KEY `IX_product_node_priceid` (`priceid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__topic_type_trans` (
  `typeid` smallint(5) unsigned NOT NULL,
  `lgid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  PRIMARY KEY (`typeid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__milestone_node` (
  `mileid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deadline` int(10) unsigned NOT NULL DEFAULT '0',
  `startdate` int(10) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`mileid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__milestone_trans` (
  `mileid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mileid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__topic_type` (
  `typeid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(100) NOT NULL,
  `designation` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `premium` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`typeid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__project_extension` (
  `pjid` smallint(5) unsigned NOT NULL,
  `wid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`pjid`,`wid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__project_milestones` (
  `pjid` int(11) unsigned NOT NULL,
  `mileid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pjid`,`mileid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__topic_task_comment` (
  `commentid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description_comment` text NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `author` int(10) unsigned NOT NULL DEFAULT '0',
  `taskid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL,
  `checktaskid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`commentid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__emanager_mailbox` (
  `wid` mediumint(8) unsigned NOT NULL,
  `inbid` smallint(5) unsigned NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '99',
  PRIMARY KEY (`inbid`,`wid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__emanager_handled` (
  `email` varchar(250) NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `total` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`email`,`type`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
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
CREATE TABLE IF NOT EXISTS `#__rule_dictionary` (
  `dctid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `words` varchar(254) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `searchin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dctid`),
  UNIQUE KEY `UK_for_rule_dictionary` (`type`,`searchin`,`words`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailbox_messages` (
  `msgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inbid` int(10) unsigned NOT NULL DEFAULT '0',
  `sender` varchar(255) NOT NULL,
  `header` text,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `box` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `size` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`msgid`),
  KEY `IX_mailbox_messages_inbid` (`inbid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailbox_node` (
  `inbid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(250) NOT NULL,
  `server` varchar(250) NOT NULL,
  `username` varchar(255) NOT NULL,
  `addon` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `name` varchar(250) NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `params` text,
  PRIMARY KEY (`inbid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__rule_node` (
  `ruleid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cdtid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `description` text,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `action` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `private` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ruleid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_bundle` (
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `ref_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `quantity` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`,`ref_pid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_type` (
  `prodtypid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `author` int(10) unsigned NOT NULL DEFAULT '0',
  `vendid` int(10) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `rolid_edit` smallint(5) unsigned NOT NULL DEFAULT '1',
  `searchable` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `filid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`prodtypid`),
  UNIQUE KEY `UK_namekey` (`namekey`),
  KEY `prodtypid` (`prodtypid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_trans` (
  `pid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `name` varchar(150) NOT NULL,
  `introduction` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `seotitle` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  `promo` text NOT NULL,
  PRIMARY KEY (`pid`,`lgid`),
  FULLTEXT KEY `IX_product_trans_name` (`name`),
  FULLTEXT KEY `IX_product_trans_introduction` (`introduction`),
  FULLTEXT KEY `IX_product_trans_description` (`description`)
) ENGINE=MyISAM  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__productcat_type` (
  `catid` int(10) unsigned NOT NULL,
  `prodtypid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`catid`,`prodtypid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__item_syndication` (
  `pid` int(10) unsigned NOT NULL,
  `vendid` int(10) unsigned NOT NULL,
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `ownervendid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`,`vendid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__featured_item` (
  `pid` int(10) unsigned NOT NULL,
  `ftdid` smallint(5) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  `category_item` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `catalog_carrousel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `catalog_item` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`,`ftdid`),
  KEY `PK_item_featured_ordering_status_expiration` (`ordering`,`status`,`expiration`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_price` (
  `priceid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(3) NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `vendid` int(10) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`priceid`),
  UNIQUE KEY `UK_namekey_product_price` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_images` (
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `filid` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `premium` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`,`filid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__productcat_node` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `filid` int(10) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(100) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rgt` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lft` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `author` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `depth` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `numpid` int(10) unsigned NOT NULL DEFAULT '0',
  `vendid` int(10) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `publishstart` int(10) unsigned NOT NULL DEFAULT '0',
  `publishend` int(10) unsigned NOT NULL DEFAULT '0',
  `cssclass` varchar(100) NOT NULL,
  `prodtypid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `layout` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `blocked` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `featured` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`),
  UNIQUE KEY `IX_objectName_cat_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__featured_trans` (
  `ftdid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '0',
  `badgename` varchar(100) NOT NULL,
  PRIMARY KEY (`ftdid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__productcat_category` (
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `catidparent` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`,`catidparent`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__featured_node` (
  `ftdid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `location` varchar(50) NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `badge` varchar(50) NOT NULL,
  `background` varchar(20) NOT NULL,
  `cssstyle` text NOT NULL,
  `credits` double(7,2) NOT NULL DEFAULT '0.00',
  `duration` int(10) unsigned NOT NULL DEFAULT '0',
  `bordercolor` varchar(20) NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  `badgecolor` varchar(20) NOT NULL,
  `cssclass` varchar(50) NOT NULL,
  `badgeposition` varchar(20) NOT NULL,
  PRIMARY KEY (`ftdid`),
  UNIQUE KEY `UK_namekey_jos_featured_node` (`namekey`),
  KEY `ix_featured_node_location` (`location`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_poptions` (
  `opid` mediumint(8) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '5',
  PRIMARY KEY (`pid`,`opid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_downloads` (
  `pid` int(10) unsigned NOT NULL,
  `filid` int(10) unsigned NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`,`filid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_typetrans` (
  `prodtypid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`prodtypid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__item_terms_trans` (
  `termid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  PRIMARY KEY (`termid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__item_terms` (
  `termid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `vendid` int(10) unsigned NOT NULL DEFAULT '0',
  `share` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`termid`),
  UNIQUE KEY `UK_namekey_item_terms` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__item_viewed` (
  `itvwid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `cookieid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `total` smallint(5) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itvwid`),
  UNIQUE KEY `UK_item_viewed_uid_modified` (`uid`,`modified`),
  UNIQUE KEY `UK_item_viewed_sessionid_modified` (`cookieid`,`modified`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;

CREATE TABLE IF NOT EXISTS `#__orders_products` (
  `ordpid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oid` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(150) NOT NULL,
  `price` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `quantity` decimal(12,2) unsigned NOT NULL DEFAULT '1.00',
  `tax` decimal(14,4) unsigned NOT NULL DEFAULT '0.0000',
  `discount` decimal(15,2) unsigned NOT NULL DEFAULT '0.00',
  `unitprice` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `baseprice` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `unitpriceref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `priceref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `discountref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `bundle` smallint(5) unsigned NOT NULL DEFAULT '0',
  `curid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `vendid` int(10) unsigned NOT NULL DEFAULT '1',
  `curidref` int(10) unsigned NOT NULL DEFAULT '0',
  `basepriceref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `pricetype` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `useraffle` tinyint(4) NOT NULL DEFAULT '0',
  `recurring` tinyint(4) NOT NULL DEFAULT '0',
  `weight` decimal(10,4) unsigned NOT NULL DEFAULT '0.0000',
  `unitid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `subtotal` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `subtotalref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `prodtypid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `taxref` decimal(14,4) unsigned NOT NULL DEFAULT '0.0000',
  `priceid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `resellerid` int(10) unsigned NOT NULL DEFAULT '0',
  `bookingfee` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  `bookingfeeref` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`ordpid`),
  KEY `IX_orders_products_oid` (`oid`),
  KEY `IX_orders_products_pid` (`pid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__product_related` (
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `relpid` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`,`relpid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__productcat_trans` (
  `lgid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `seotitle` varchar(255) NOT NULL,
  `seokeywords` varchar(255) NOT NULL,
  `seodescription` varchar(255) NOT NULL,
  PRIMARY KEY (`lgid`,`catid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__conversation_status` (
  `uid` int(10) unsigned NOT NULL,
  `mcid` int(10) unsigned NOT NULL,
  `isread` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `replies` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`mcid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__vendor_trans` (
  `vendid` int(10) unsigned NOT NULL,
  `lgid` int(10) unsigned NOT NULL,
  `name` varchar(254) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vendid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__conversation_node` (
  `mcid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `top` int(10) unsigned NOT NULL DEFAULT '0',
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mcid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__vendor_node` (
  `vendid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(150) NOT NULL,
  `curid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `adid` int(10) unsigned NOT NULL DEFAULT '0',
  `stid` int(10) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(150) NOT NULL,
  `namekey` varchar(50) NOT NULL,
  `filid` int(11) NOT NULL DEFAULT '0',
  `website` varchar(250) NOT NULL,
  `params` text NOT NULL,
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `premium` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` int(10) unsigned NOT NULL DEFAULT '1',
  `affid` int(10) unsigned NOT NULL DEFAULT '0',
  `phone` varchar(30) NOT NULL,
  `contactemail` varchar(64) NOT NULL,
  `paypal` varchar(100) NOT NULL,
  `otheraccount` varchar(64) NOT NULL,
  `nbreviews` int(10) unsigned NOT NULL DEFAULT '0',
  `score` int(10) unsigned NOT NULL DEFAULT '0',
  `votes` int(10) unsigned NOT NULL DEFAULT '0',
  `skypeid` varchar(64) DEFAULT NULL,
  `yahooid` varchar(64) DEFAULT NULL,
  `originctyid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `originstate` varchar(100) NOT NULL,
  `originzipcode` varchar(30) NOT NULL,
  `originaddress` varchar(100) NOT NULL,
  `originaddress2` varchar(100) NOT NULL,
  `origincity` varchar(50) NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `taxnumber` varchar(50) NOT NULL,
  `paypalverified` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '13',
  `longitude` double(12,8) NOT NULL DEFAULT '222.00000000',
  `latitude` double(12,8) NOT NULL DEFAULT '222.00000000',
  `bannerid` int(10) unsigned NOT NULL DEFAULT '0',
  `badge` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vendid`),
  UNIQUE KEY `UK_vendor_node_namekey` (`namekey`),
  UNIQUE KEY `UK_vendor_node_uid` (`uid`),
  KEY `IX_vendor_node_longitute_latitude` (`longitude`,`latitude`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__conversation_to` (
  `uid` int(10) unsigned NOT NULL,
  `mcid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`,`mcid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__wishlist_products` (
  `pid` int(10) unsigned NOT NULL,
  `wlid` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `vendid` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(254) NOT NULL,
  PRIMARY KEY (`wlid`,`pid`,`vendid`,`catid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__wishlist_trans` (
  `wlid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  PRIMARY KEY (`wlid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__wishlist_node` (
  `wlid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(250) NOT NULL,
  `type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `authoruid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `private` tinyint(4) NOT NULL DEFAULT '1',
  `mode` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wlid`),
  UNIQUE KEY `UK_wishlist_node_namekey` (`namekey`),
  UNIQUE KEY `UK_wishlist_node_type_authoruid` (`authoruid`,`type`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__model_node` (
  `sid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `dbtid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `path` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `extended` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `checkval` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(255) NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  `prefix` varchar(50) NOT NULL,
  `suffix` varchar(50) NOT NULL,
  `extstid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fields` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `checkout` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `trash` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `audit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `parentsid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `totalcustom` smallint(5) unsigned NOT NULL DEFAULT '0',
  `reload` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `faicon` varchar(50) NOT NULL,
  `pnamekey` varchar(50) NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `UK_model_node_namekey` (`namekey`),
  KEY `IX_model_node_prefix_level` (`prefix`,`level`),
  KEY `IX_model_node_dbtic` (`dbtid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__layout_listings` (
  `lid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `yid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `map` varchar(30) NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '99',
  `hidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '1',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `search` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `advsearch` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `advordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL,
  `params` text NOT NULL,
  `did` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ref_wid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `namekey` varchar(100) NOT NULL,
  `fdid` int(10) unsigned NOT NULL DEFAULT '0',
  `parentdft` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `xsvisible` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `xshidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `devicevisible` varchar(100) NOT NULL,
  `devicehidden` varchar(100) NOT NULL,
  PRIMARY KEY (`lid`),
  UNIQUE KEY `UK_layout_listings_namekey` (`namekey`),
  KEY `IX_layout_listing_yid_publish_level_rolid_hidden_ordering` (`yid`,`level`,`publish`,`rolid`,`hidden`,`ordering`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__layout_multiformstrans` (
  `fid` mediumint(8) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__fields_trans` (
  `fieldid` int(10) unsigned NOT NULL,
  `lgid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  PRIMARY KEY (`fieldid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__dropset_node` (
  `namekey` varchar(50) NOT NULL,
  `did` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `map` varchar(20) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `outype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `wid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ref_sid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `first_value` int(10) unsigned NOT NULL DEFAULT '0',
  `first_all` tinyint(4) NOT NULL DEFAULT '0',
  `lib_ext` tinyint(4) NOT NULL DEFAULT '0',
  `external` varchar(60) NOT NULL,
  `first_caption` varchar(50) NOT NULL,
  `core` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `mon` tinyint(4) NOT NULL DEFAULT '0',
  `sid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `reload` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `parent` varchar(50) NOT NULL,
  `isparent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `allowothers` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `colorstyle` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`did`),
  UNIQUE KEY `UK_dropset_node_namekey` (`namekey`),
  KEY `IX_dropset_node_wid_publish_level_rolid` (`publish`,`wid`,`level`,`rolid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__dataset_columns` (
  `dbcid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dbtid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `pkey` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `checkval` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `attributes` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mandatory` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `default` varchar(50) NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `extra` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `size` decimal(8,0) NOT NULL DEFAULT '0',
  `export` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `namekey` varchar(50) NOT NULL,
  `core` tinyint(4) NOT NULL DEFAULT '1',
  `columntype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `indexed` tinyint(4) NOT NULL DEFAULT '0',
  `noaudit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dbcid`),
  UNIQUE KEY `UK_dataset_columns` (`namekey`),
  UNIQUE KEY `UK_dataset_columns_dbtid` (`name`,`dbtid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__layout_multiforms` (
  `fid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `yid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `map` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '99',
  `initial` varchar(255) NOT NULL,
  `readonly` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `required` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '1',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `did` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `area` varchar(20) NOT NULL,
  `ref_yid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `frame` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `ref_wid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `namekey` varchar(100) NOT NULL,
  `fdid` int(10) unsigned NOT NULL DEFAULT '0',
  `parentdft` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `checktype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `xsvisible` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `xshidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `devicevisible` varchar(100) NOT NULL,
  `devicehidden` varchar(100) NOT NULL,
  PRIMARY KEY (`fid`),
  UNIQUE KEY `UK_layout_forms_namekey` (`namekey`),
  KEY `IX_layout_multiform_yid_publish_level_rolid_ordering` (`yid`,`publish`,`level`,`rolid`,`ordering`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__dropset_trans` (
  `did` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`did`,`lgid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__model_fields` (
  `fdid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `fieldid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `searchable` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid_edit` smallint(5) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `initialvalue` varchar(255) NOT NULL,
  `column` varchar(100) NOT NULL,
  `required` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '999',
  `updateall` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `dbcid` int(10) unsigned NOT NULL DEFAULT '0',
  `translate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `advsearchable` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fdid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__dropset_valuestrans` (
  `vid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__model_fields_type` (
  `fdid` int(10) unsigned NOT NULL,
  `typeid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`fdid`,`typeid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__model_trans` (
  `sid` smallint(5) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__fields_node` (
  `fieldid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `listing` varchar(250) NOT NULL,
  `form` varchar(250) NOT NULL,
  `real` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` mediumint(8) unsigned NOT NULL DEFAULT '69',
  `category` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `visible` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `translate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fieldid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__model_fieldstrans` (
  `fdid` int(10) unsigned NOT NULL,
  `lgid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  PRIMARY KEY (`fdid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__layout_fields` (
  `yid` int(10) unsigned NOT NULL,
  `fdid` int(10) unsigned NOT NULL,
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`yid`,`fdid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__dropset_values` (
  `vid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `value` varchar(100) NOT NULL,
  `valuetxt` varchar(50) NOT NULL,
  `premium` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(150) NOT NULL DEFAULT '',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `color` varchar(20) NOT NULL,
  `parent` varchar(100) NOT NULL,
  `inputbox` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vid`),
  UNIQUE KEY `UK_dropset_values_did_value` (`did`,`value`),
  UNIQUE KEY `UK_dropset_values_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__layout_listingstrans` (
  `lid` mediumint(8) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__layout_trans` (
  `yid` mediumint(8) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `wname` varchar(255) NOT NULL,
  `wdescription` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`yid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__credentials_node` (
  `crdid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `directory` varchar(255) NOT NULL,
  `username` varchar(200) NOT NULL,
  `passcode` varchar(200) NOT NULL,
  `url` varchar(250) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `ordering` int(10) unsigned NOT NULL DEFAULT '1',
  `crdidtype` smallint(5) unsigned NOT NULL DEFAULT '0',
  `premium` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`crdid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__widgets_type_trans` (
  `wgtypeid` int(10) unsigned NOT NULL,
  `lgid` smallint(5) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  PRIMARY KEY (`wgtypeid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
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
CREATE TABLE IF NOT EXISTS `#__layout_mlinks` (
  `mid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `yid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `icon` varchar(50) NOT NULL,
  `action` varchar(150) NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '99',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '1',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `namekey` varchar(100) NOT NULL,
  `ref_wid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `faicon` varchar(50) NOT NULL,
  `color` varchar(15) NOT NULL,
  `xsvisible` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `xshidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `devicevisible` varchar(100) NOT NULL,
  `devicehidden` varchar(100) NOT NULL,
  PRIMARY KEY (`mid`),
  UNIQUE KEY `UK_layout_menus_namekey` (`namekey`),
  KEY `layout_mlinks_index_yid_publish_level_rolid_ordering` (`yid`,`level`,`publish`,`ordering`,`rolid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__widgets_trans` (
  `widgetid` int(10) unsigned NOT NULL,
  `lgid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  PRIMARY KEY (`widgetid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__layout_node` (
  `yid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(100) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `subtype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `wid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `frontend` tinyint(4) NOT NULL DEFAULT '0',
  `menu` tinyint(4) NOT NULL DEFAULT '1',
  `wizard` tinyint(4) NOT NULL DEFAULT '0',
  `form` tinyint(4) NOT NULL DEFAULT '1',
  `dropdown` tinyint(4) NOT NULL DEFAULT '0',
  `pagination` tinyint(4) NOT NULL DEFAULT '0',
  `filters` tinyint(4) NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `core` tinyint(4) NOT NULL DEFAULT '1',
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `icon` varchar(50) NOT NULL,
  `tmid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `alias` varchar(255) NOT NULL,
  `fields` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `parent` varchar(100) NOT NULL,
  `reload` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `widgets` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `faicon` varchar(50) NOT NULL,
  `useredit` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `pnamekey` varchar(100) NOT NULL,
  PRIMARY KEY (`yid`),
  UNIQUE KEY `UK_layout_node_namekey` (`namekey`),
  KEY `IX_layout_node_wid_type_publish_level_rolid` (`wid`,`publish`,`type`,`level`,`rolid`),
  KEY `IX_layout_node_sid` (`sid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__layout_mlinkstrans` (
  `mid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  PRIMARY KEY (`mid`,`lgid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__widgets_node` (
  `widgetid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `framework_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `framework_id` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `wgtypeid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`widgetid`),
  UNIQUE KEY `UK_widgets_node_namekey` (`namekey`),
  KEY `IX_widgets_node_framework_type_publish_core` (`framework_type`,`publish`,`core`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__message_queue` (
  `mgqid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mgid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '254',
  `expirationdate` int(10) unsigned NOT NULL DEFAULT '0',
  `repetition` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `read` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  PRIMARY KEY (`mgqid`),
  KEY `IX_message_queue_uid_read_create` (`uid`,`read`,`created`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__widgets_type` (
  `wgtypeid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(100) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wgtypeid`),
  UNIQUE KEY `UK_widgets_type_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__credentials_type` (
  `crdidtype` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `category` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`crdidtype`),
  UNIQUE KEY `UK_namekey_jos_credentials_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__scheduler_trans` (
  `schid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `lgid` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`schid`,`lgid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__scheduler_url` (
  `schurlid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `nextdate` int(10) unsigned NOT NULL DEFAULT '0',
  `frequency` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `priority` tinyint(4) NOT NULL DEFAULT '50',
  `attempt` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `lastdate` int(10) unsigned NOT NULL DEFAULT '0',
  `sendreport` tinyint(4) NOT NULL DEFAULT '0',
  `lastreport` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `timeout` tinyint(3) unsigned NOT NULL DEFAULT '50',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `lock` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`schurlid`),
  KEY `IX_scheduler_url_publish_lock_nextdate_priority` (`publish`,`lock`,`nextdate`,`priority`),
  KEY `IX_scheduler_url_uid` (`uid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__scheduler_processes` (
  `pcsid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pcsid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__scheduler_node` (
  `schid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nextdate` int(10) unsigned NOT NULL DEFAULT '0',
  `frequency` int(10) unsigned NOT NULL DEFAULT '0',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lastdate` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `cron` varchar(50) NOT NULL,
  `ptype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(50) NOT NULL,
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `report` text NOT NULL,
  `maxtime` int(10) unsigned NOT NULL DEFAULT '5',
  `maxprocess` smallint(5) unsigned NOT NULL DEFAULT '1',
  `viewname` varchar(50) NOT NULL,
  PRIMARY KEY (`schid`),
  UNIQUE KEY `UK_namekey_jos_scheduler_node` (`namekey`),
  KEY `IX_scheduler_node_wid` (`wid`),
  KEY `IX_scheduler_node_publish_priority_nextdate` (`publish`,`nextdate`,`priority`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailing_node` (
  `mgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid` int(10) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(100) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '101',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `senddate` int(10) unsigned NOT NULL DEFAULT '0',
  `html` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `alias` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tags` text NOT NULL,
  `archive` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '10',
  `attach` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `publishstart` int(10) unsigned NOT NULL DEFAULT '0',
  `publishend` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `sms` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `template` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `format` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `notify` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`mgid`),
  UNIQUE KEY `UK_mailing_node_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailing_type` (
  `mgtypeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `designation` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`mgtypeid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailing_statistics_user` (
  `mgid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `htmlsent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `textsent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `failed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bounced` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `smssent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hitlinks` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `readdate` int(10) unsigned NOT NULL DEFAULT '0',
  `mailerid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mgid`,`uid`,`created`),
  KEY `IX_mailing_statistics_user_created` (`created`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailing_statistics` (
  `mgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `failed` int(10) unsigned NOT NULL DEFAULT '0',
  `total` int(10) unsigned NOT NULL DEFAULT '0',
  `htmlsent` int(10) unsigned NOT NULL DEFAULT '0',
  `textsent` int(10) unsigned NOT NULL DEFAULT '0',
  `htmlread` int(10) unsigned NOT NULL DEFAULT '0',
  `textread` int(10) unsigned NOT NULL DEFAULT '0',
  `hitlinks` int(10) unsigned NOT NULL DEFAULT '0',
  `bounces` int(10) unsigned NOT NULL DEFAULT '0',
  `smssent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mgid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailing_queue` (
  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mgid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `senddate` int(10) unsigned NOT NULL DEFAULT '0',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '100',
  `attempt` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cmpgnid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `lsid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`),
  KEY `IX_mailing_queue_publish_priority_senddate` (`publish`,`priority`,`senddate`),
  KEY `IX_mailing_queue_uid_cmpgnid_lsid` (`uid`,`cmpgnid`,`lsid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailing_type_trans` (
  `mgtypeid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned DEFAULT '2',
  `lgid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mgtypeid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailing_trans` (
  `mgid` int(10) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `ctext` longtext NOT NULL,
  `chtml` longtext NOT NULL,
  `smail` char(100) NOT NULL,
  `sname` char(50) NOT NULL,
  `rmail` varchar(100) NOT NULL,
  `rname` varchar(100) NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `bouncemail` varchar(100) NOT NULL,
  `authorid` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `intro` text NOT NULL,
  `smsmessage` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  PRIMARY KEY (`mgid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__mailer_node` (
  `mailerid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `sendername` varchar(100) NOT NULL,
  `senderemail` varchar(100) NOT NULL,
  `replyname` varchar(100) NOT NULL,
  `replyemail` varchar(100) NOT NULL,
  `bouncebackemail` varchar(100) NOT NULL,
  `embedimages` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `multiplepart` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `encodingformat` varchar(50) NOT NULL,
  `charset` varchar(100) NOT NULL,
  `wordwrapping` int(10) unsigned NOT NULL DEFAULT '0',
  `addnames` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `premium` tinyint(4) NOT NULL DEFAULT '0',
  `designation` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '9',
  `hostname` varchar(254) NOT NULL,
  PRIMARY KEY (`mailerid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_trans` (
  `lgid` tinyint(3) unsigned NOT NULL,
  `wid` mediumint(8) unsigned NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lgid`,`wid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_languages` (
  `wid` mediumint(8) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL,
  `available` tinyint(4) NOT NULL DEFAULT '0',
  `translation` tinyint(4) NOT NULL DEFAULT '1',
  `completed` double(5,2) unsigned NOT NULL DEFAULT '0.00',
  `automatic` double(5,2) unsigned NOT NULL DEFAULT '0.00',
  `totalimac` int(10) unsigned NOT NULL DEFAULT '0',
  `manual` double(5,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`wid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_translation` (
  `wid` int(10) unsigned NOT NULL,
  `lgid` int(10) unsigned NOT NULL,
  `modifiedby` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_node` (
  `wid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(100) NOT NULL,
  `folder` varchar(40) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` smallint(5) unsigned NOT NULL DEFAULT '1',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `destination` varchar(255) NOT NULL,
  `parent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `trans` tinyint(4) NOT NULL DEFAULT '0',
  `certify` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `version` int(10) unsigned NOT NULL DEFAULT '0',
  `lversion` int(10) unsigned NOT NULL DEFAULT '0',
  `pref` tinyint(4) NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `install` text NOT NULL,
  `ordering` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `reload` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `showconfig` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `framework` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wid`),
  UNIQUE KEY `UK_extension_node_namekey` (`namekey`),
  KEY `IX_extension_node_publish` (`publish`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_version` (
  `vsid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid` int(10) unsigned NOT NULL DEFAULT '0',
  `version` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `beta` smallint(5) unsigned NOT NULL DEFAULT '0',
  `filid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `encoding` varchar(100) NOT NULL,
  `changelog` text NOT NULL,
  `final` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sha1` varchar(100) NOT NULL,
  `code` char(32) NOT NULL,
  `marketing` varchar(255) NOT NULL,
  PRIMARY KEY (`vsid`),
  UNIQUE KEY `UK_extension_version_wid_version` (`wid`,`version`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_leveltrans` (
  `lwid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lgid` tinyint(3) unsigned NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lwid`,`lgid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_userinfos` (
  `wid` int(10) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ltype` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `license` varchar(255) NOT NULL,
  `token` varchar(254) NOT NULL,
  `expire` int(10) unsigned NOT NULL DEFAULT '0',
  `maintenance` int(10) unsigned NOT NULL DEFAULT '0',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `subtype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wid`,`level`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_info` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(100) NOT NULL,
  `documentation` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `flash` varchar(255) NOT NULL,
  `support` varchar(255) NOT NULL,
  `forum` varchar(255) NOT NULL,
  `homeurl` varchar(200) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  `userversion` varchar(100) NOT NULL,
  `userlversion` varchar(100) NOT NULL,
  `beta` smallint(5) NOT NULL DEFAULT '0',
  `keyword` varchar(200) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_level` (
  `lwid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `namekey` varchar(50) NOT NULL,
  PRIMARY KEY (`lwid`),
  UNIQUE KEY `UK_extension_level_wid_level` (`wid`,`level`),
  UNIQUE KEY `NamekeyExtensionLevel` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__extension_dependency` (
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ref_wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wid`,`ref_wid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__space_theme` (
  `wsid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `size` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `device` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tmid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wsid`,`size`,`device`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__space_node` (
  `wsid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(50) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `tmid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `menu` varchar(100) NOT NULL,
  `yid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `theme` varchar(50) NOT NULL,
  `controller` varchar(150) NOT NULL,
  `restrictuser` tinyint(4) NOT NULL DEFAULT '0',
  `frameworktheme` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wsid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__space_trans` (
  `lgid` tinyint(4) unsigned NOT NULL,
  `wsid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wsid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__eguillage_roles` (
  `ctrid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `override` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ctrid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__eguillage_trans` (
  `ctrid` int(10) unsigned NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ctrid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__eguillage_node` (
  `ctrid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(100) NOT NULL,
  `app` varchar(100) NOT NULL,
  `task` varchar(100) NOT NULL,
  `premium` tinyint(4) NOT NULL DEFAULT '0',
  `admin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `yid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `path` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '1',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `trigger` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `visible` tinyint(3) unsigned NOT NULL DEFAULT '9',
  `checkowner` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `reload` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `checkadminowner` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pnamekey` varchar(100) NOT NULL,
  PRIMARY KEY (`ctrid`),
  UNIQUE KEY `UK_controller_app_task_admin` (`app`,`task`,`admin`),
  UNIQUE KEY `UK_controller_namekey` (`namekey`),
  KEY `IX_controller_publish_premium_level` (`publish`,`level`,`premium`),
  KEY `IX_controller_node_wid` (`wid`),
  KEY `IX_controller_node_yid` (`yid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__eguillage_action` (
  `ctr_action_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ctrid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `action` varchar(100) NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `namekey` varchar(50) NOT NULL,
  PRIMARY KEY (`ctr_action_id`),
  KEY `IX_eguillage_action_ctrid_publish` (`ctrid`,`publish`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__action_node` (
  `actid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(255) NOT NULL,
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `folder` varchar(30) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `filter` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `before` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`actid`),
  UNIQUE KEY `UK_action_node_namekey` (`namekey`),
  KEY `IX_action_node_wid_publish` (`wid`,`publish`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__actions_type` (
  `acttyid` smallint(10) unsigned NOT NULL AUTO_INCREMENT,
  `namekey` varchar(150) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`acttyid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__dataset_foreign` (
  `fkid` smallint(5) NOT NULL AUTO_INCREMENT,
  `dbtid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ref_dbtid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ondelete` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `feid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ref_feid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(100) NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `map` varchar(50) NOT NULL,
  `map2` varchar(50) NOT NULL,
  `onupdate` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '99',
  PRIMARY KEY (`fkid`),
  UNIQUE KEY `UK_dataset_foreign_feid_dbtid_red_dbtid` (`feid`,`dbtid`,`ref_dbtid`),
  UNIQUE KEY `UK_dataset_foreign_namekey` (`namekey`),
  KEY `IX_dataset_foreign_publish_ref_feid` (`ref_feid`,`publish`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__dataset_tables` (
  `dbtid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dbid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `namekey` varchar(100) NOT NULL,
  `size` decimal(14,0) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `rows` int(10) unsigned NOT NULL DEFAULT '0',
  `rows_average_length` decimal(8,0) unsigned NOT NULL DEFAULT '0',
  `data_length` decimal(14,0) unsigned NOT NULL DEFAULT '0',
  `prefix` varchar(255) NOT NULL,
  `version` varchar(50) NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pkey` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `domain` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `export` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `exportdelete` tinyint(4) NOT NULL DEFAULT '0',
  `noaudit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `engine` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dbtid`),
  UNIQUE KEY `UK_dataset_tables_namekey` (`namekey`),
  UNIQUE KEY `UK_dbid_name` (`dbid`,`name`),
  KEY `IX_dataset_tables_rolid` (`rolid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__layout_dropset` (
  `did` mediumint(8) unsigned NOT NULL,
  `yid` mediumint(8) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`did`,`yid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__filters_node` (
  `flid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `bktbefore` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `map` varchar(20) NOT NULL,
  `condopr` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bktafter` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `logicopr` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `refmap` varchar(30) NOT NULL,
  `ref_sid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `typea` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `typeb` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(50) NOT NULL,
  `name` varchar(40) NOT NULL,
  `yid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `requiresvalue` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`flid`),
  UNIQUE KEY `UK_filters_node_namekey` (`namekey`),
  KEY `IX_filters_node_yid` (`yid`),
  KEY `IX_filters_node_sid` (`sid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__translation_reference` (
  `wid` mediumint(8) unsigned NOT NULL,
  `load` tinyint(4) NOT NULL DEFAULT '0',
  `imac` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`,`imac`)
) ENGINE=MyISAM  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
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
CREATE TABLE IF NOT EXISTS `#__dataset_constraints` (
  `ctid` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `dbtid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `namekey` varchar(255) NOT NULL,
  PRIMARY KEY (`ctid`),
  UNIQUE KEY `UK_dataset_constraints_namekey` (`namekey`),
  KEY `IX_dataset_constraints_dbtid_type` (`dbtid`,`type`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__translation_en` (
  `text` text   NOT NULL,
  `auto` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `imac` varchar(255) NOT NULL,
  `nbchars` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`imac`),
  KEY `ix_translation_en_nbchars` (`nbchars`),
  FULLTEXT KEY `FTXT_translation_en_text` (`text`)
) ENGINE=MyISAM  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__sesion_node` (
  `sessid` varchar(250) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` double unsigned NOT NULL DEFAULT '0',
  `data` longtext,
  `framework` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sessid`(64)),
  KEY `IX_sesion_node_uid` (`uid`),
  KEY `IX_sesion_node_modified` (`modified`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__dataset_constraintsitems` (
  `ctid` mediumint(5) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `sort` tinyint(4) NOT NULL DEFAULT '0',
  `dbcid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`dbcid`,`ctid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__engine_languages` (
  `englgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `engid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `lgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ref_lgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`englgid`),
  UNIQUE KEY `UK_translation_engine_lgid_ref_lgid` (`engid`,`lgid`,`ref_lgid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__translation_populate` (
  `dbcid` int(10) unsigned NOT NULL,
  `eid` int(10) unsigned NOT NULL,
  `imac` varchar(50) NOT NULL,
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dbcid`,`eid`),
  KEY `IK_translation_populate_wid` (`wid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__role_node` (
  `rolid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lft` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rgt` smallint(5) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `joomla` smallint(5) unsigned NOT NULL DEFAULT '0',
  `j16` int(10) unsigned NOT NULL DEFAULT '1',
  `namekey` varchar(50) NOT NULL DEFAULT '',
  `color` varchar(20) NOT NULL DEFAULT 'black',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `depth` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rolid`),
  UNIQUE KEY `UK_role_node_namekey` (`namekey`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__role_trans` (
  `rolid` smallint(5) unsigned NOT NULL,
  `lgid` smallint(5) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rolid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__role_members` (
  `rolid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`,`rolid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__theme_node` (
  `tmid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `namekey` varchar(255) NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '1',
  `premium` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `core` tinyint(3) NOT NULL DEFAULT '0',
  `wid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(255) NOT NULL,
  `filid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `availability` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `folder` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `rolid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(5) unsigned NOT NULL DEFAULT '999',
  `framework` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tmid`),
  UNIQUE KEY `UK_theme_node_namekey` (`namekey`),
  KEY `IK_theme_node_type_publish_core_premium` (`type`,`publish`,`core`,`premium`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__theme_trans` (
  `tmid` smallint(6) NOT NULL,
  `lgid` tinyint(4) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auto` tinyint(4) NOT NULL DEFAULT '1',
  `fromlgid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tmid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__members_details` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `suffix` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `vendid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `skypeid` varchar(50) NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `linkedin` varchar(100) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `signature` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB   /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;
CREATE TABLE IF NOT EXISTS `#__members_lang` (
  `uid` int(10) unsigned NOT NULL,
  `lgid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `ordering` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`lgid`)
) ENGINE=InnoDB  /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;