<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Design_Design_modelfields_listing_view extends Output_Listings_class {
function prepareView() {



	$sid = WForm::getPrev( 'sid' );

	if ( empty($sid) ) {

		WPages::redirect( 'controller=design-model' );

	}


	return true;



}}