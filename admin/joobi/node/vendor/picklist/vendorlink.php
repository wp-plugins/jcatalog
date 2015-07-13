<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Vendor_Vendorlink_picklist extends WPicklist {
	function create() {


				$mypicklist = array();
		$mypicklist[''] = WText::t('1336846878JRIF');

		$mypicklist['vendor'] = WText::t('1336846878JRIG');

				if ( !defined('PUSERS_NODE_FRAMEWORK_FE') ) WPref::get( 'users.node', false, true, false );
		$jomSocial = WApplication::isEnabled( 'community', true );
		if (PUSERS_NODE_FRAMEWORK_FE == 'jomsocial' || $jomSocial ) {
			$mypicklist['jomsocial'] = WText::t('1336846878JRIH');
		}
		foreach( $mypicklist as $key => $value ) {
			$this->addElement( $key, $value );
		}
		return true;


	}}