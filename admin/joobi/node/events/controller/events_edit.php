<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Events_edit_controller extends WController {

	function edit(){



		$eid=WGlobals::getEID();



		$core=WModel::getElementData( 'events', $eid, 'core' );
		$custom=WModel::getElementData( 'events', $eid, 'custom' );



		if( !empty($core) && empty($custom)) $this->setView( 'events_form_core' );



		return true;



	}
}