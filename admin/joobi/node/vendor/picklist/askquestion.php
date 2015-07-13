<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Vendor_Askquestion_picklist extends WPicklist {


function create() {



	
	$mypicklist = array();



	
	$mypicklist['internalmessage'] = WText::t('1307082967ACFT');



	
	$jtickets = WApplication::isEnabled( 'jtickets', true );

	if (!empty($jtickets)) $mypicklist['jtickets'] = WText::t('1307082967ACFU');



	
	if ( !defined('PUSERS_NODE_FRAMEWORK_FE') ) WPref::get( 'users.node', false, true, false );

	$jomSocial = WApplication::isEnabled( 'community', true );

	if (PUSERS_NODE_FRAMEWORK_FE == 'jomsocial' || $jomSocial ) {

		$mypicklist['jomsocialmessage'] = WText::t('1307002909NVUE');

	}




	
	$mypicklist['emailmessage'] = WText::t('1307082967ACFV');





	foreach( $mypicklist as $key => $value ) {

		$this->addElement( $key, $value );

	}


	return true;


}}