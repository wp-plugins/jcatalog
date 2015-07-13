/*Export of the extension editor.node*/

DELETE FROM `#__translation_en` WHERE `auto` = 1 AND `imac` IN ('1237260381RHQN','1378320294IHEE','1378320294IHEF','1384345472OOFE' );
DELETE `#__translation_reference`.* FROM `#__extension_node` LEFT JOIN `#__translation_reference` ON `#__translation_reference`.`wid` = `#__extension_node`.`wid` WHERE `#__extension_node`.`namekey` IN ('editor.node') ;
SET @pk_5_731 = ( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='editor.node' LIMIT 1 );
UPDATE `#__extension_node`  SET `publish`='1',`folder`='editor',`wid`=@pk_5_731,`params`='',`status`='1',`type`='150',`name`='Editors',`destination`='node',`parent`='0',`trans`='1',`certify`='0',`namekey`='editor.node',`version`='4189',`lversion`='4189',`pref`='0',`install`='',`core`='1',`showconfig`='1',`framework`='0' WHERE  `namekey`='editor.node';
INSERT IGNORE INTO `#__extension_node` (`publish`,`folder`,`wid`,`params`,`status`,`type`,`name`,`destination`,`parent`,`trans`,`certify`,`namekey`,`version`,`lversion`,`pref`,`install`,`core`,`showconfig`,`framework`) VALUES ('1','editor',@pk_5_731,'','1','150','Editors','node','0','1','0','editor.node','4189','4189','0','','1','1','0');

SET @rolid_0 = (1);
SET @pk_549_5 = ( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='extension.node' LIMIT 1 );
REPLACE INTO `#__dataset_tables` (`name`,`namekey`,`dbtid`,`prefix`,`version`,`rolid`,`level`,`type`,`pkey`,`suffix`,`group`,`domain`,`export`,`exportdelete`,`noaudit`,`engine`) VALUES ('extension_node','extension.node',@pk_549_5,'','1.0.0',@rolid_0,'0','1','wid','node','extension','9','2','0','1','7');
SET @pk_621_5 = ( SELECT `sid` FROM `#__model_node`  WHERE `namekey`='extension' LIMIT 1 );
UPDATE `#__model_node`  SET `sid`=@pk_621_5,`dbtid`=( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='extension.node' LIMIT 1),`path`='1',`namekey`='extension',`folder`='extension',`rolid`=@rolid_0,`level`='0',`publish`='1',`extended`='0',`checkval`='0',`params`='ordrg=1\ngrpmap=core',`alias`='',`prefix`='extension',`fields`='0',`trash`='0',`core`='1',`faicon`='fa-mobile',`pnamekey`='' WHERE  `namekey`='extension';
INSERT IGNORE INTO `#__model_node` (`sid`,`dbtid`,`path`,`namekey`,`folder`,`rolid`,`level`,`publish`,`extended`,`checkval`,`params`,`alias`,`prefix`,`fields`,`trash`,`core`,`faicon`,`pnamekey`) VALUES (@pk_621_5,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='extension.node' LIMIT 1),'1','extension','extension',@rolid_0,'0','1','0','0','ordrg=1\ngrpmap=core','','extension','0','0','1','fa-mobile','');

SET @wid_1 = ( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='editor.node' LIMIT 1);
INSERT IGNORE INTO `#__translation_en` (`text`,`auto`,`imac`) VALUES ('Text Only','1','1237260381RHQN');
INSERT IGNORE INTO `#__translation_en` (`text`,`auto`,`imac`) VALUES ('NiceEdit','1','1378320294IHEE'),('Framework Editors','1','1378320294IHEF'),('CK Editor','1','1384345472OOFE');
INSERT IGNORE INTO `#__translation_reference` (`wid`,`load`,`imac`) VALUES (@wid_1,'1','1237260381RHQN');
INSERT IGNORE INTO `#__translation_reference` (`wid`,`load`,`imac`) VALUES (@wid_1,'1','1378320294IHEE'),(@wid_1,'1','1378320294IHEF'),(@wid_1,'1','1384345472OOFE');
REPLACE INTO `#__extension_info` (`wid`,`author`,`documentation`,`images`,`flash`,`support`,`forum`,`homeurl`,`feedback`,`userversion`,`userlversion`,`beta`,`keyword`) VALUES ((@wid_1),'','','','','','','','','','','0','');