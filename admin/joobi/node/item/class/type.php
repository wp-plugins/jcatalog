<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












WLoadFile( 'main.class.type', JOOBI_DS_NODE );
class Item_Type_class extends Main_Type_class {

	public $typeModelName = 'item.type';
	public $typeModelPK = 'prodtypid';

	public $itemModelName = 'item';
	public $itemModelPK = 'pid';

	public $designationNode = 'item';

	public $cacheFolder = 'TypeItem';








	public function loadTypeBasedOnPID($pid,$return='data') {

				WGlobals::set( 'sharedItemType', 10, 'global' );

		return $this->loadTypeFromID( $pid, $return );

	}

}