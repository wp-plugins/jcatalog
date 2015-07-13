<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Design_modelfields_form_view extends Output_Forms_class {
function prepareView() {



	$sid = $this->getValue( 'sid', 'design.modelfields' );



	if ( empty( $sid ) ) {

		$message = WMessage::get();

		$message->userN('1369750869THVV');

		WPages::redirect( 'controller=design-model' );

	}




	return true;



}}