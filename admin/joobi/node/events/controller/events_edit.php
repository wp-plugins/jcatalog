<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Events_edit_controller extends WController {

	function edit(){



		$eid=WGlobals::getEID();



		$core=WModel::getElementData( 'events', $eid, 'core' );
		$custom=WModel::getElementData( 'events', $eid, 'custom' );



		if( !empty($core) && empty($custom)) $this->setView( 'events_form_core' );



		return true;



	}
}