<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Catpublish_filter {
function create() {



if ( WRoles::isAdmin( 'storemanager' ) ) return false;

else return 1;





}
}