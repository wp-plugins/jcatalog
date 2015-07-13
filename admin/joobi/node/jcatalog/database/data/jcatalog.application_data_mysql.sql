/*Export of the extension jcatalog.application*/

DELETE FROM `#__translation_en` WHERE `auto` = 1 AND `imac` IN ('1242282450QJAT','1233642085PNTA','1234340112SMFU','1206732392OZVB','1206732411EGRU','1206961936HCWM','1206732392OZVG','1206961869IGND','1392733055LQQF','1392733055LQQG','1304525968YBL','1227581071SHQP','1227581071SHQQ','1234340112SMFS','1305886469JEXB','1206961997BSZK','1206732411EGQQ','1220793707SOED','1206732392OZUQ','1213183509OYOB','1227580898LIDX','1213200727TEHT','1213200727TEHQ','1213200727TEHR','1213200727TEHS','1211811516QTED','1228709730AUQK','1211811516QTEF','1310010343GRLB','1206732366OVME','1206732391QBUR','1206732392OZUP','1355852601LJIH','1234467597SEXU','1352928514KXRI','1308889035NJVP','1327537101FMKV','1378476214NEGH','1327537106OHBX','1302182265RUTI','1215603991PHUU','1347896707AYYK','1356733772QJIA','1206961854HENY','1206961868QEYE','1206961868QEYF','1206961868QEYD','1209559180DARX','1242282438KRJW','1206732392OZUS','1220793710GXYB','1298888291HSWK','1340666912COKC','1253200893CXZC','1242178310INQS','1349965800JJHP','1352928514KXRJ','1349965800JJHV','1350509126KYBK','1350509126KYBL','1350509126KYBM','1420549827AUWZ','1212573195QGYY','1378305380MWPI','1357949004HJGQ','1357949004HJGR','1378476214NEGI','1305797897EXPB','1235618035ANFT','1425349403QAPQ' );
DELETE `#__dataset_columns`.* FROM `#__dataset_tables` LEFT JOIN `#__dataset_columns` ON `#__dataset_columns`.`dbtid` = `#__dataset_tables`.`dbtid` WHERE `#__dataset_tables`.`namekey` IN ('layout.multiformstrans','layout.mlinkstrans','layout.trans','eguillage.trans') AND `#__dataset_columns`.`namekey` NOT IN ('481yid','481lgid','481name','481description','482fid','482lgid','482name','482description','485mid','485lgid','485name','481wname','481wdescription','714ctrid','714lgid','name714','description714','description485','auto481','fromlgid481','auto482','fromlgid482','auto485','fromlgid485','auto714','fromlgid714','message485') AND `#__dataset_columns`.`core` = 1  ;
DELETE `#__translation_reference`.* FROM `#__extension_node` LEFT JOIN `#__translation_reference` ON `#__translation_reference`.`wid` = `#__extension_node`.`wid` WHERE `#__extension_node`.`namekey` IN ('jcatalog.application') ;
SET @rolid_0 = (1);
SET @pk_549_482 = ( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.multiformstrans' LIMIT 1 );
SET @pk_549_652 = ( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='vendor.node' LIMIT 1 );
SET @pk_549_989 = ( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='vendor.trans' LIMIT 1 );
SET @pk_549_306 = ( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='product.node' LIMIT 1 );
SET @pk_549_485 = ( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.mlinkstrans' LIMIT 1 );
SET @pk_549_481 = ( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.trans' LIMIT 1 );
SET @pk_549_714 = ( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='eguillage.trans' LIMIT 1 );
REPLACE INTO `#__dataset_tables` (`name`,`namekey`,`dbtid`,`prefix`,`version`,`rolid`,`level`,`type`,`pkey`,`suffix`,`group`,`domain`,`export`,`exportdelete`,`noaudit`,`engine`) VALUES ('layout_multiformstrans','layout.multiformstrans',@pk_549_482,'','1.0.0',@rolid_0,'0','20','fid,lgid','multiformstrans','layout','9','0','0','1','7');
REPLACE INTO `#__dataset_tables` (`name`,`namekey`,`dbtid`,`prefix`,`version`,`rolid`,`level`,`type`,`pkey`,`suffix`,`group`,`domain`,`export`,`exportdelete`,`noaudit`,`engine`) VALUES ('vendor_node','vendor.node',@pk_549_652,'','',@rolid_0,'0','1','vendid','node','vendor','51','1','0','0','7'),('vendor_trans','vendor.trans',@pk_549_989,'','',@rolid_0,'0','20','vendid,lgid','','','51','2','0','0','7'),('product_node','product.node',@pk_549_306,'','1.0.0',@rolid_0,'0','1','pid','node','product','51','2','0','0','7'),('layout_mlinkstrans','layout.mlinkstrans',@pk_549_485,'','1.0.0',@rolid_0,'0','20','mid,lgid','mlinkstrans','layout','9','0','0','1','7'),('layout_trans','layout.trans',@pk_549_481,'','1.0.0',@rolid_0,'0','20','yid,lgid','trans','layout','9','0','0','1','7'),('eguillage_trans','eguillage.trans',@pk_549_714,'','',@rolid_0,'0','20','ctrid,lgid','trans','eguillage','9','0','0','1','7');
SET @pk_616_3412 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='482name' LIMIT 1 );
SET @pk_616_3413 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='482description' LIMIT 1 );
SET @pk_616_3419 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='485name' LIMIT 1 );
SET @pk_616_6797 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='description485' LIMIT 1 );
SET @pk_616_10823 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='message485' LIMIT 1 );
SET @pk_616_3408 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='481name' LIMIT 1 );
SET @pk_616_5579 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='481wname' LIMIT 1 );
SET @pk_616_5580 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='481wdescription' LIMIT 1 );
SET @pk_616_6794 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='name714' LIMIT 1 );
SET @pk_616_6795 = ( SELECT `dbcid` FROM `#__dataset_columns`  WHERE `namekey`='description714' LIMIT 1 );
REPLACE INTO `#__dataset_columns` (`dbcid`,`dbtid`,`name`,`pkey`,`checkval`,`type`,`attributes`,`mandatory`,`default`,`ordering`,`level`,`rolid`,`extra`,`size`,`export`,`namekey`,`core`,`columntype`,`noaudit`) VALUES (@pk_616_3412,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.multiformstrans' LIMIT 1),'name','0','0','14','0','1','','3','1',@rolid_0,'0','255','1','482name','1','0','0');
REPLACE INTO `#__dataset_columns` (`dbcid`,`dbtid`,`name`,`pkey`,`checkval`,`type`,`attributes`,`mandatory`,`default`,`ordering`,`level`,`rolid`,`extra`,`size`,`export`,`namekey`,`core`,`columntype`,`noaudit`) VALUES (@pk_616_3413,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.multiformstrans' LIMIT 1),'description','0','0','16','0','1','','4','1',@rolid_0,'0','0','1','482description','1','0','0'),(@pk_616_3419,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.mlinkstrans' LIMIT 1),'name','0','0','14','0','1','','3','1',@rolid_0,'0','255','1','485name','1','0','0'),(@pk_616_6797,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.mlinkstrans' LIMIT 1),'description','0','1','16','0','1','','4','0','0','0','0','1','description485','1','0','0'),(@pk_616_10823,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.mlinkstrans' LIMIT 1),'message','0','1','16','0','1','','5','0','0','0','0','1','message485','1','0','0'),(@pk_616_3408,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.trans' LIMIT 1),'name','0','0','14','0','1','','3','1',@rolid_0,'0','255','1','481name','1','0','0'),(@pk_616_5579,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.trans' LIMIT 1),'wname','0','0','14','0','1','','5','1',@rolid_0,'0','255','1','481wname','1','0','0'),(@pk_616_5580,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='layout.trans' LIMIT 1),'wdescription','0','0','16','0','1','','6','1',@rolid_0,'0','0','1','481wdescription','1','0','0'),(@pk_616_6794,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='eguillage.trans' LIMIT 1),'name','0','1','14','0','1','','3','0','0','0','255','1','name714','1','0','0'),(@pk_616_6795,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='eguillage.trans' LIMIT 1),'description','0','1','16','0','1','','4','0','0','0','0','1','description714','1','0','0');
SET @pk_5_774 = ( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='jcatalog.application' LIMIT 1 );
UPDATE `#__extension_node`  SET `publish`='1',`folder`='jcatalog',`wid`=@pk_5_774,`params`='',`status`='1',`type`='1',`name`='jCatalog',`destination`='node',`parent`='0',`trans`='1',`certify`='1',`namekey`='jcatalog.application',`version`='900',`lversion`='900',`pref`='1',`install`='',`core`='1',`showconfig`='1',`framework`='0' WHERE  `namekey`='jcatalog.application';
INSERT IGNORE INTO `#__extension_node` (`publish`,`folder`,`wid`,`params`,`status`,`type`,`name`,`destination`,`parent`,`trans`,`certify`,`namekey`,`version`,`lversion`,`pref`,`install`,`core`,`showconfig`,`framework`) VALUES ('1','jcatalog',@pk_5_774,'','1','1','jCatalog','node','0','1','1','jcatalog.application','900','900','1','','1','1','0');

SET @pk_621_644 = ( SELECT `sid` FROM `#__model_node`  WHERE `namekey`='vendor' LIMIT 1 );
SET @pk_621_1134 = ( SELECT `sid` FROM `#__model_node`  WHERE `namekey`='vendortrans' LIMIT 1 );
SET @pk_621_1091 = ( SELECT `sid` FROM `#__model_node`  WHERE `namekey`='item' LIMIT 1 );
UPDATE `#__model_node`  SET `sid`=@pk_621_644,`dbtid`=( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='vendor.node' LIMIT 1),`path`='1',`namekey`='vendor',`folder`='vendor',`rolid`=@rolid_0,`level`='0',`publish`='1',`extended`='0',`checkval`='0',`params`='autofld=1',`alias`='',`prefix`='vendor',`fields`='0',`trash`='0',`core`='1',`faicon`='fa-user-md',`pnamekey`='' WHERE  `namekey`='vendor';
INSERT IGNORE INTO `#__model_node` (`sid`,`dbtid`,`path`,`namekey`,`folder`,`rolid`,`level`,`publish`,`extended`,`checkval`,`params`,`alias`,`prefix`,`fields`,`trash`,`core`,`faicon`,`pnamekey`) VALUES (@pk_621_644,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='vendor.node' LIMIT 1),'1','vendor','vendor',@rolid_0,'0','1','0','0','autofld=1','','vendor','0','0','1','fa-user-md','');
UPDATE `#__model_node`  SET `sid`=@pk_621_1134,`dbtid`=( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='vendor.trans' LIMIT 1),`path`='0',`namekey`='vendortrans',`folder`='vendor',`rolid`=@rolid_0,`level`='0',`publish`='1',`extended`='0',`checkval`='0',`params`='autofld=1\nmainmodel=vendor',`alias`='',`prefix`='vendor',`fields`='0',`trash`='0',`core`='1',`faicon`='fa-user-md',`pnamekey`='' WHERE  `namekey`='vendortrans';
INSERT IGNORE INTO `#__model_node` (`sid`,`dbtid`,`path`,`namekey`,`folder`,`rolid`,`level`,`publish`,`extended`,`checkval`,`params`,`alias`,`prefix`,`fields`,`trash`,`core`,`faicon`,`pnamekey`) VALUES (@pk_621_1134,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='vendor.trans' LIMIT 1),'0','vendortrans','vendor',@rolid_0,'0','1','0','0','autofld=1\nmainmodel=vendor','','vendor','0','0','1','fa-user-md','');
UPDATE `#__model_node`  SET `sid`=@pk_621_1091,`dbtid`=( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='product.node' LIMIT 1),`path`='1',`namekey`='item',`folder`='item',`rolid`=@rolid_0,`level`='0',`publish`='1',`extended`='0',`checkval`='0',`params`='ordrg=1\ngrpmap=catid\ngrptable=item.categoryitem\ncachedata=1\nautofld=1\ncategorymodel=item.category',`alias`='',`prefix`='item',`fields`='1',`trash`='0',`core`='1',`faicon`='fa-bookmark',`pnamekey`='' WHERE  `namekey`='item';
INSERT IGNORE INTO `#__model_node` (`sid`,`dbtid`,`path`,`namekey`,`folder`,`rolid`,`level`,`publish`,`extended`,`checkval`,`params`,`alias`,`prefix`,`fields`,`trash`,`core`,`faicon`,`pnamekey`) VALUES (@pk_621_1091,( SELECT `dbtid` FROM `#__dataset_tables`  WHERE `namekey`='product.node' LIMIT 1),'1','item','item',@rolid_0,'0','1','0','0','ordrg=1\ngrpmap=catid\ngrptable=item.categoryitem\ncachedata=1\nautofld=1\ncategorymodel=item.category','','item','1','0','1','fa-bookmark','');

SET @wid_1 = ( SELECT `wid` FROM `#__extension_node`  WHERE `namekey`='jcatalog.application' LIMIT 1);
SET @sid_2 = ( SELECT `sid` FROM `#__model_node`  WHERE `namekey`='vendor' LIMIT 1);
SET @rolid_3 = (13);
SET @rolid_4 = (8);
SET @rolid_5 = (7);
SET @rolid_6 = (21);
SET @yid_7 = ( SELECT `yid` FROM `#__layout_node`  WHERE `namekey`='jcatalog_install_setup' LIMIT 1);
SET @yid_8 = ( SELECT `yid` FROM `#__layout_node`  WHERE `namekey`='jcatalog_dashboard' LIMIT 1);
SET @ref_yid_9 = ( SELECT `yid` FROM `#__layout_node`  WHERE `namekey`='jcatalog_dashboard_menu' LIMIT 1);
SET @p_1_0 = ( SELECT  A.`fid`  FROM `#__layout_multiforms`  AS A  WHERE  A.`namekey` ='jcatalog_dashboard_row_1' LIMIT 1);
UPDATE `#__layout_multiforms` SET `parent`=@p_1_0 WHERE `namekey` IN ('jcatalog_dashboard_icon') LIMIT 1;
SET @p_1_1 = ( SELECT  A.`fid`  FROM `#__layout_multiforms`  AS A  WHERE  A.`namekey` ='jcatalog_dashboard_row_2' LIMIT 1);
UPDATE `#__layout_multiforms` SET `parent`=@p_1_1 WHERE `namekey` IN ('jcatalog_dashboard_items') LIMIT 1;
SET @p_1_2 = ( SELECT  A.`fid`  FROM `#__layout_multiforms`  AS A  WHERE  A.`namekey` ='2dmhdgz727' LIMIT 1);
UPDATE `#__layout_multiforms` SET `parent`=@p_1_2 WHERE `namekey` IN ('2dmhdgz728','2dmhdgz729','2dmhdgz72a','2dmhdgz72b') LIMIT 4;
SET @yid_10 = ( SELECT `yid` FROM `#__layout_node`  WHERE `namekey`='jcatalog_main' LIMIT 1);
SET @yid_11 = ( SELECT `yid` FROM `#__layout_node`  WHERE `namekey`='jcatalog_main_fe' LIMIT 1);
SET @p_9_0 = ( SELECT  A.`mid`  FROM `#__layout_mlinks`  AS A  WHERE  A.`namekey` ='jcatalog_main_design_japps' LIMIT 1);
UPDATE `#__layout_mlinks` SET `parent`=@p_9_0 WHERE `namekey` IN ('jcatalog_main_views_japps','jcatalog_main_theme_japps','jcatalog_main_email_japps','jcatalog_main_models_japps') LIMIT 4;
SET @p_9_1 = ( SELECT  A.`mid`  FROM `#__layout_mlinks`  AS A  WHERE  A.`namekey` ='jcatalog_main_views_japps' LIMIT 1);
UPDATE `#__layout_mlinks` SET `parent`=@p_9_1 WHERE `namekey` IN ('jcatalog_main_views_listings_japps','jcatalog_main_views_forms_japps','jcatalog_main_views_menus_japps','jcatalog_main_picklist_japps') LIMIT 4;
SET @p_9_2 = ( SELECT  A.`mid`  FROM `#__layout_mlinks`  AS A  WHERE  A.`namekey` ='jcatalog_main_tools_japps' LIMIT 1);
UPDATE `#__layout_mlinks` SET `parent`=@p_9_2 WHERE `namekey` IN ('jcatalog_main_apps-trans_japps','jcatalog_main_language_japps','jcatalog_main_scheduler_japps','jcatalog_main_credentials_japps','jcatalog_main_apps-logs_japps','jcatalog_main_main-cache_japps','jcatalog_main_apps_japps','jcatalog_main_preferences_japps') LIMIT 8;
SET @p_9_3 = ( SELECT  A.`mid`  FROM `#__layout_mlinks`  AS A  WHERE  A.`namekey` ='jcatalog_main_support' LIMIT 1);
UPDATE `#__layout_mlinks` SET `parent`=@p_9_3 WHERE `namekey` IN ('jcatalog_main_ask_questions','jcatalog_main_documentation','jcatalog_main_video_tutorials','jcatalog_main_forum','jcatalog_main_update') LIMIT 5;
SET @p_9_4 = ( SELECT  A.`mid`  FROM `#__layout_mlinks`  AS A  WHERE  A.`namekey` ='jcatalog_main_product' LIMIT 1);
UPDATE `#__layout_mlinks` SET `parent`=@p_9_4 WHERE `namekey` IN ('jcatalog_main_item-type','jcatalog_main_fields','jcatalog_main_item-terms','jcatalog_main_feedback','jcatalog_main_promotion') LIMIT 5;
SET @p_9_5 = ( SELECT  A.`mid`  FROM `#__layout_mlinks`  AS A  WHERE  A.`namekey` ='jcatalog_main_apps-widgets' LIMIT 1);
UPDATE `#__layout_mlinks` SET `parent`=@p_9_5 WHERE `namekey` IN ('jcatalog_main_themes','jcatalog_main_email') LIMIT 2;
INSERT IGNORE INTO `#__translation_en` (`text`,`auto`,`imac`) VALUES ('Next','1','1206732366OVME');
INSERT IGNORE INTO `#__translation_en` (`text`,`auto`,`imac`) VALUES ('Wizard','1','1206732391QBUR'),('Help','1','1206732392OZUP'),('Preferences','1','1206732392OZUQ'),('Languages','1','1206732392OZUS'),('Name','1','1206732392OZVB'),('Description','1','1206732392OZVG'),('Categories','1','1206732411EGQQ'),('Email','1','1206732411EGRU'),('Views','1','1206961854HENY'),('Menus','1','1206961868QEYD'),('Listings','1','1206961868QEYE'),('Forms','1','1206961868QEYF'),('hidden','1','1206961869IGND'),('Image','1','1206961936HCWM'),('Catalog','1','1206961997BSZK'),('Pick-lists','1','1209559180DARX'),('Tools','1','1211811516QTED'),('Themes','1','1211811516QTEF'),('Dashboard','1','1212573195QGYY'),('Support','1','1213183509OYOB'),('Documentation','1','1213200727TEHQ'),('Video Tutorials','1','1213200727TEHR'),('Forum','1','1213200727TEHS'),('Ask Questions','1','1213200727TEHT'),('Promotion','1','1215603991PHUU'),('Types','1','1220793707SOED'),('Translations','1','1220793710GXYB'),('Update','1','1227580898LIDX'),('Your/Company\'s name<br>','1','1227581071SHQP'),('Necessary for the payment service<br>','1','1227581071SHQQ'),('Emails','1','1228709730AUQK'),('Items','1','1233642085PNTA'),('Your site\'s or company\'s image<br>','1','1234340112SMFS'),('Vendor Setup','1','1234340112SMFU'),('Feedback','1','1234467597SEXU'),('Please follow those simple steps to finish your installation of your market place:<br><ol><li>Create a menu item in the front-end to access the Home Page of the marketplace.</li><li>Define the default currency of the store.</li><li>Enter a store name and email.</li><li>Default payment method is Paypal but you can change it the list of payments.<br></li><li>Finally create items.<br></li></ol>','1','1235618035ANFT'),('Cache','1','1242178310INQS'),('System','1','1242282438KRJW'),('Icons','1','1242282450QJAT'),('Logs','1','1253200893CXZC'),('Scheduled Tasks','1','1298888291HSWK'),('My Lists','1','1302182265RUTI'),('','1','1304525968YBL'),('Market Installation Setup','1','1305797897EXPB'),('Description of the Main Vendor store<br>','1','1305886469JEXB'),('List of all Items','1','1308889035NJVP'),('Terms','1','1310010343GRLB'),('List of all Categories','1','1327537101FMKV'),('Display one Category','1','1327537106OHBX'),('Credentials','1','1340666912COKC'),('Design','1','1347896707AYYK'),('This link to the catalog or homepage of the store.<br>','1','1349965800JJHP'),('List all items in the store.<br>','1','1349965800JJHV'),('List all the categories of the store. Specify a eid and you can view all the sub-categories of a category.<br>eid is the category ID.','1','1350509126KYBK'),('Display one product. Specify the eid, the ID of the product.','1','1350509126KYBL'),('Display one category of the store. Specify a eid to define which category to view.<br>eid is the category ID.','1','1350509126KYBM'),('Catalog per Type','1','1352928514KXRI'),('Specify a type. It could be either the item type ID or it can be the designation ( eg: item, product, auction, etc... )<br>','1','1352928514KXRJ'),('Fields','1','1355852601LJIH'),('Models & Fields','1','1356733772QJIA'),('jCatalog Dashboard','1','1357949004HJGQ'),('jCatalog Setup','1','1357949004HJGR'),('jCatalog','1','1378305380MWPI'),('Display One Item','1','1378476214NEGH'),('jCatalog FE Menu','1','1378476214NEGI'),('Row 1','1','1392733055LQQF'),('Row 2','1','1392733055LQQG'),('User menu. The users can edit their list or add a new one.<br>','1','1420549827AUWZ'),('You do not have access to this page!','1','1425349403QAPQ');
INSERT IGNORE INTO `#__translation_reference` (`wid`,`load`,`imac`) VALUES (@wid_1,'0','1425349403QAPQ');
REPLACE INTO `#__extension_info` (`wid`,`author`,`documentation`,`images`,`flash`,`support`,`forum`,`homeurl`,`feedback`,`userversion`,`userlversion`,`beta`,`keyword`) VALUES ((@wid_1),'','','','','','','','','1.10.7.2','1.10.7.2','0','');