/* CONDITIONCOLUMN||product_node||site_id */ ALTER TABLE `#__product_node`  ADD `site_id` VARCHAR ( 254 )  NOT NULL ;
/* CONDITIONCOLUMN||productcat_node||site_id */ ALTER TABLE `#__productcat_node`  ADD `site_id` VARCHAR ( 255 )  NOT NULL ;
/* CONDITIONCOLUMN||productcat_node||numpidsub */ ALTER TABLE `#__productcat_node`  ADD `numpidsub` INT UNSIGNED  DEFAULT '0' NOT NULL ;
/* CONDITIONCOLUMN||product_type||payid */ ALTER TABLE `#__product_type`  ADD `payid` SMALLINT UNSIGNED  DEFAULT '0' NOT NULL ;
DELETE FROM `#__item_viewed` WHERE `uid` = 0; 
ALTER TABLE `#__item_viewed` DROP INDEX `UK_item_viewed_sessionid_modified`, ADD INDEX `IX_item_viewed_cookieid_pid` (`cookieid`, `pid`) COMMENT '';
ALTER TABLE `#__item_viewed` DROP INDEX `UK_item_viewed_uid_modified`, ADD INDEX `IX_item_viewed_uid_pid` (`uid`, `pid`) COMMENT '';

/* CONDITIONCOLUMN||layout_node||custom */ ALTER TABLE `#__layout_node`  ADD `custom` TINYINT UNSIGNED  DEFAULT '0' NOT NULL ;
/* CONDITIONCOLUMN||message_queue||link */ ALTER TABLE `#__message_queue`  ADD `link` VARCHAR ( 254 )  NOT NULL ;
ALTER TABLE `#__message_queue`  CHANGE `read` `isread` TINYINT UNSIGNED  DEFAULT '0' NOT NULL ;
/* CONDITIONCOLUMN||eguillage_node||custom */ ALTER TABLE `#__eguillage_node`  ADD `custom` TINYINT UNSIGNED  DEFAULT '0' NOT NULL ;
/* CONDITIONCOLUMN||filters_node||requirednode */ ALTER TABLE `#__filters_node`  ADD `requirednode` VARCHAR ( 100 )  NOT NULL ;