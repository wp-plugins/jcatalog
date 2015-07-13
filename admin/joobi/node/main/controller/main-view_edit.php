<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_view_edit_controller extends WController {

	function edit() {



		
		$mainEditC = WClass::get( 'main.edit' );

		if ( !$mainEditC->checkEditAccess() ) return false;



		$eid = WGlobals::getEID();

		$custom = WModel::getElementData( 'main.view', $eid, 'custom' );

		if ( empty($custom) ) $this->setView( 'main_view_form_core' );

		return parent::edit();



	}
}