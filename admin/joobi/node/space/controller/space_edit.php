<?php 

* @link joobi.co
* @license GNU GPLv3 */



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