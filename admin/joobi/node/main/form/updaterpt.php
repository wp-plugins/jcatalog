<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Main_CoreUpdaterpt_form extends WForms_default {















	function show() {
		






		$extM = null;
		$extData = array();
		$extM = WModel::get( 'apps' );
		$extM->makeLJ( 'apps.info', 'wid' );
		$extM->select( 'wid', 0 );
		$extM->select( 'userversion', 1 );
		$extM->select( 'lversion', 0 );
		$extM->whereE( 'publish', 1, 0 );
		$extM->whereIn( 'type', array( 1, 350 ), 0 );
		$extM->where( 'userversion', '!=', '', 1 );
		$extData = $extM->load('ol');

				$ctr = 0;
		foreach( $extData as $data ){
			if ( version_compare( $data->userversion, $data->lversion, '<=' ) ) $ctr++;
		}
		$this->content = ( string ) $ctr;

		return true;


	}
}