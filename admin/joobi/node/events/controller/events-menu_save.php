<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Events_menu_save_controller extends WController {


function save(){



    $message=WMessage::get();

	$trucs=WGlobals::get('trucs');


	$controllerID=WModel::getID('library.viewmenus');

	$trucs=$trucs[0];

	$menutype=$trucs['x']['menutype'];

	$menuname=$trucs['x']['menuname'];

	$mid=$trucs[$controllerID]['mid'];

	

	$extra=$trucs['x']['extra'];

	$extra=trim( $extra, '&');



	
	if( !empty($menutype) && !empty($menuname)  && !empty($mid)){

		$controllerM=WModel::get('library.viewmenus');

		$controllerM->makeLJ( 'library.view', 'yid' );

		$controllerM->select( 'wid',  1 );

		$controllerM->whereE( 'mid',  $mid );



		$ctrlid=$controllerM->load('o', array('action' ));

		if( !empty($extra)) $ctrlid->action.='&'.$extra;



		$application=WExtension::get( $ctrlid->wid, 'namekey' );

		$application=str_replace( '.application', '', $application );



		WApplication::createMenu( $menuname, $menutype, $ctrlid->action, $application );

        $message->UserS( 'Successfully created menu!');

        return true;



	}else{

       $message->UserE('Front-end menu not created!  Please select a menu on the list.');

       WPages::redirect('controller=extension-events');

	}
	

	return true;



}
}