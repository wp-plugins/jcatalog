<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Main_Fieldparent_picklist extends WPicklist {
function create() {



	$count = 9;

	$this->addElement( 0, WText::t('1242179646EPJF') );

	for ($i = 1; $i < $count; $i++) {

		$this->addElement( $i, WText::t('1360240327QUAB') . $i );

	}


	return true;

}}