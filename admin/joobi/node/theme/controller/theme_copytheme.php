<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Theme_copytheme_controller extends WController {


function copytheme(){


	$tmid=WGlobals::getEID( true );

	$message=WMessage::get();

	$trucs=WGlobals::get('boxchecked');



	$modelId=WModel::get('theme', 'sid');

	$selectedThemes=WGlobals::get('tmid_'.$modelId);



	if(!empty($selectedThemes)){

		if(sizeof($selectedThemes) > 1)

			$message->userN('1309502072SWIE');

	}


	$inListing=WGlobals::get('listing', 0);



	if(!empty($inListing)){

		WGlobals::set('listing', $inListing, 'session');

	}


	$this->viewNamekey='theme_clone';



	return true;



}}