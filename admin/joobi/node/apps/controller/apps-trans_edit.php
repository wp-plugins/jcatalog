<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_trans_edit_controller extends WController {

	function edit(){
		
		$lgid=WGlobals::get( 'trlgid' );  
		$trucs=WGlobals::get( 'trucs' );


		$trucs['x']['trlgid']=$lgid;
		WGlobals::set( 'trucs', $trucs );
		
		return true;
		
	}	
}