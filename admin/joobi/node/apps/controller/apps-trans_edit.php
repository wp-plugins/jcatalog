<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Apps_trans_edit_controller extends WController {

	function edit(){
		
		$lgid=WGlobals::get( 'trlgid' );  
		$trucs=WGlobals::get( 'trucs' );


		$trucs['x']['trlgid']=$lgid;
		WGlobals::set( 'trucs', $trucs );
		
		return true;
		
	}	
}