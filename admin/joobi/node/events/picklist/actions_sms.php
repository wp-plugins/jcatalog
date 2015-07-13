<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Events_Actions_sms_picklist extends WPicklist {
function create(){





	$smsM=WModel::get( 'email' );

	$smsM->whereE( 'template', 9 );

	$smsM->whereE( 'publish', 1 );

	$smsM->orderBy( 'alias' );

	$allSmsA=$smsM->load( 'ol', array( 'mgid', 'alias' ));

	

	if( empty( $allSmsA )) return false;



	$this->addElement( 0, '- ' . WText::t('1408411565AGZI') . '-' );



	foreach( $allSmsA as $itemList){

		$this->addElement( $itemList->lsid, $itemList->alias );

	}


	return true;



}}