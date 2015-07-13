DELETE FROM `#__item_viewed` WHERE `uid` = 0; 
ALTER TABLE `#__item_viewed` DROP INDEX `UK_item_viewed_sessionid_modified`, ADD INDEX `IX_item_viewed_cookieid_pid` (`cookieid`, `pid`) COMMENT '';
ALTER TABLE `#__item_viewed` DROP INDEX `UK_item_viewed_uid_modified`, ADD INDEX `IX_item_viewed_uid_pid` (`uid`, `pid`) COMMENT '';
