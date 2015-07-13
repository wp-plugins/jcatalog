/* CONDITIONCOLUMN||product_node||site_id */ ALTER TABLE `#__product_node`  ADD `site_id` VARCHAR ( 254 )  NOT NULL ;

/* CONDITIONCOLUMN||productcat_node||numpidsub */ ALTER TABLE `#__productcat_node`  ADD `numpidsub` INT UNSIGNED  DEFAULT '0' NOT NULL ;


ALTER TABLE `#__item_viewed` DROP INDEX `UK_item_viewed_sessionid_modified`, ADD INDEX `IX_item_viewed_cookieid_pid` (`cookieid`, `pid`) COMMENT '';
ALTER TABLE `#__item_viewed` DROP INDEX `UK_item_viewed_uid_modified`, ADD INDEX `IX_item_viewed_uid_pid` (`uid`, `pid`) COMMENT '';



ALTER TABLE `#__message_queue`  CHANGE `read` `isread` TINYINT UNSIGNED  DEFAULT '0' NOT NULL ;

