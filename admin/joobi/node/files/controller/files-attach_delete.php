<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Files_attach_delete_controller extends WController {
function delete() {



	$status = parent::delete();

	

	$pid= WGlobals::get('pid');

	$map= WGlobals::get('map');

	$model = WGlobals::get('model');

	

	if ( $status ) {

		$message = WMessage::get();

		$message->userS('1369749799PPLZ');

	}


	WPages::redirect( 'controller=files-attach&task=listing&pid='.$pid .'&map='.$map .'&model='.$model ) ;

	

	return true;



}}