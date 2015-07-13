<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Space_edit_controller extends WController {
function edit() {



	$eid = WGlobals::getEID();



	$spaceM = WModel::get( 'space' );

	$spaceM->whereE( 'wsid', $eid );

	$spaceM->whereE( 'core', 1 );

	$exist = $spaceM->exist();

	

	if ( $exist ) {

		$this->userW('1407204294PFVM');

		WPages::redirect( 'controller=space' );

	}


	return parent::edit();

 

}}