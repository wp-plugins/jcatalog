<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Main_Googlekey_picklist extends WPicklist {
function create() {


	$mainCredentialsC = WClass::get( 'main.credentials' );

	$mainCredentialsC->picklistFromType( $this, 'googleapi' );



	return true;



}}