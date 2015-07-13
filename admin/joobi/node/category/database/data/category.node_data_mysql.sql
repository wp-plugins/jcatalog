/*Export of the extension category.node*/

DELETE FROM `#__translation_en` WHERE `auto` = 1 AND `imac` IN ('1213020899EZVY','1220361707FSCI','1235560364LCKV','1406069322OHER' );
DELETE `#__translation_reference`.* FROM `#__extension_node` LEFT JOIN `#__translation_reference` ON `#__translation_reference`.`wid` = `#__extension_node`.`wid` WHERE `#__extension_node`.`namekey` IN ('category.node') ;
SET @pk_5_171 = ( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='category.node' LIMIT 1 );
UPDATE `#__extension_node`  SET `publish`='1',`folder`='category',`wid`=@pk_5_171,`params`='',`status`='1',`type`='150',`name`='Category',`destination`='node',`parent`='0',`trans`='1',`certify`='1',`namekey`='category.node',`version`='4292',`lversion`='4292',`pref`='0',`install`='',`core`='1',`showconfig`='1',`framework`='0' WHERE  `namekey`='category.node';
INSERT IGNORE INTO `#__extension_node` (`publish`,`folder`,`wid`,`params`,`status`,`type`,`name`,`destination`,`parent`,`trans`,`certify`,`namekey`,`version`,`lversion`,`pref`,`install`,`core`,`showconfig`,`framework`) VALUES ('1','category',@pk_5_171,'','1','150','Category','node','0','1','1','category.node','4292','4292','0','','1','1','0');

SET @rolid_0 = (1);
SET @pk_549_310 = ( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='productcat.node' LIMIT 1 );
REPLACE INTO `#__dataset_tables` (`name`,`namekey`,`dbtid`,`prefix`,`version`,`rolid`,`level`,`type`,`pkey`,`suffix`,`group`,`domain`,`export`,`exportdelete`,`noaudit`,`engine`) VALUES ('productcat_node','productcat.node',@pk_549_310,'','1.0.0',@rolid_0,'0','40','catid','node','productcat','51','2','0','0','7');
SET @pk_621_310 = ( SELECT `sid` FROM `#__model_node`  WHERE `namekey`='product.category' LIMIT 1 );
UPDATE `#__model_node`  SET `sid`=@pk_621_310,`dbtid`=( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='productcat.node' LIMIT 1),`path`='1',`namekey`='product.category',`folder`='product.category',`rolid`=@rolid_0,`level`='0',`publish`='1',`extended`='0',`checkval`='0',`params`='ordrg=1\ngrpmap=parent\nprtname=product.categorytrans\nautofld=1',`alias`='',`prefix`='productcat',`fields`='0',`trash`='0',`core`='1',`faicon`='fa-folder-open',`pnamekey`='' WHERE  `namekey`='product.category';
INSERT IGNORE INTO `#__model_node` (`sid`,`dbtid`,`path`,`namekey`,`folder`,`rolid`,`level`,`publish`,`extended`,`checkval`,`params`,`alias`,`prefix`,`fields`,`trash`,`core`,`faicon`,`pnamekey`) VALUES (@pk_621_310,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='productcat.node' LIMIT 1),'1','product.category','product.category',@rolid_0,'0','1','0','0','ordrg=1\ngrpmap=parent\nprtname=product.categorytrans\nautofld=1','','productcat','0','0','1','fa-folder-open','');

SET @wid_1 = ( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='category.node' LIMIT 1);
INSERT IGNORE INTO `#__translation_en` (`text`,`auto`,`imac`) VALUES ('It is not permitted to put a category as its own parent.','1','1213020899EZVY');
INSERT IGNORE INTO `#__translation_en` (`text`,`auto`,`imac`) VALUES ('The parent can not be one of the child of this category','1','1220361707FSCI'),('This $NAME is not empty... All sub-elements were added to the parent $NAME.','1','1235560364LCKV'),('The parent of the category could not be found!','1','1406069322OHER');
INSERT IGNORE INTO `#__translation_reference` (`wid`,`load`,`imac`) VALUES (@wid_1,'0','1213020899EZVY');
INSERT IGNORE INTO `#__translation_reference` (`wid`,`load`,`imac`) VALUES (@wid_1,'0','1220361707FSCI'),(@wid_1,'0','1235560364LCKV'),(@wid_1,'0','1406069322OHER');