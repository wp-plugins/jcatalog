<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Files_Storage_picklist extends WPicklist {
function create() {




	$mainCredentialsC = WClass::get( 'main.credentials' );
	$mainCredentialsC->picklistFromCategory( $this, 3, array( 'local' => WText::t('1349726930JFTH') ) );







	return true;



}}