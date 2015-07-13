<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Translation_element_changelanguage_controller extends WController {

	function changelanguage(){





		$sid=$this->getFormValue( 'sid' );








		$eid=$this->getFormValue( 'eid' );

		if( is_array($eid)) $eid=$eid[0];



		$type=$this->getFormValue( 'type' );


		$map=$this->getFormValue( 'map' );



		$eidmap=$this->getFormValue( 'eidmap' );



		$lgid=$this->getFormValue( 'lgid' );


		WPages::redirect( 'controller=translation-element&task=edit&eid=' . $eid . '&eidmap=' . $eidmap . '&type=' . $type . '&lgid=' . $lgid . '&map=' . $map . '&sid=' . $sid );



		return true;



	}
}