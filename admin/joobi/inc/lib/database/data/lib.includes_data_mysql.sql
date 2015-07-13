/*Export of the extension lib.includes*/

SET @pk_5_1868 = ( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='lib.includes' LIMIT 1 );
UPDATE `#__extension_node`  SET `publish`='1',`folder`='lib',`wid`=@pk_5_1868,`params`='',`status`='1',`type`='175',`name`='Library Includes',`destination`='inc',`parent`='0',`trans`='0',`certify`='1',`namekey`='lib.includes',`version`='1302',`lversion`='1302',`pref`='0',`install`='',`core`='1',`showconfig`='1',`framework`='0' WHERE  `namekey`='lib.includes';
INSERT IGNORE INTO `#__extension_node` (`publish`,`folder`,`wid`,`params`,`status`,`type`,`name`,`destination`,`parent`,`trans`,`certify`,`namekey`,`version`,`lversion`,`pref`,`install`,`core`,`showconfig`,`framework`) VALUES ('1','lib',@pk_5_1868,'','1','175','Library Includes','inc','0','0','1','lib.includes','1302','1302','0','','1','1','0');

REPLACE INTO `#__extension_info` (`wid`,`author`,`documentation`,`images`,`flash`,`support`,`forum`,`homeurl`,`feedback`,`userversion`,`userlversion`,`beta`,`keyword`) VALUES (( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='lib.includes' LIMIT 1),'','','','','','','','','','','0','');