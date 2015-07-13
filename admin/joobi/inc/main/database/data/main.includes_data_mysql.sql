/*Export of the extension main.includes*/

SET @pk_5_1867 = ( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='main.includes' LIMIT 1 );
UPDATE `#__extension_node`  SET `publish`='1',`folder`='main',`wid`=@pk_5_1867,`params`='',`status`='1',`type`='175',`name`='Main Includes',`destination`='inc',`parent`='0',`trans`='0',`certify`='1',`namekey`='main.includes',`version`='1185',`lversion`='1185',`pref`='1',`install`='',`core`='1',`showconfig`='1',`framework`='0' WHERE  `namekey`='main.includes';
INSERT IGNORE INTO `#__extension_node` (`publish`,`folder`,`wid`,`params`,`status`,`type`,`name`,`destination`,`parent`,`trans`,`certify`,`namekey`,`version`,`lversion`,`pref`,`install`,`core`,`showconfig`,`framework`) VALUES ('1','main',@pk_5_1867,'','1','175','Main Includes','inc','0','0','1','main.includes','1185','1185','1','','1','1','0');

REPLACE INTO `#__extension_info` (`wid`,`author`,`documentation`,`images`,`flash`,`support`,`forum`,`homeurl`,`feedback`,`userversion`,`userlversion`,`beta`,`keyword`) VALUES (( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='main.includes' LIMIT 1),'','','','','','','','','','','0','');