<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreLast_module extends WModule {
function create() {


	
        


	$ticketM = null;



	if (!isset($ticketM)) {

		$ticketM = WModel::get( 'ticket' );

	}


	




	
	switch ( $this->showcategorytitle ) {

		
		case 0:	$defcaption = WText::t('1206732372QTKJ');

			WGlobals::setCookie( 'cat_notitle', 1 );  
			break;



		
		case 1: $defcaption = WText::t('1206732372QTKI');

			WGlobals::setCookie( 'cat_notitle', 0 );

			break;



		default: $defcaption = '';

			 break;

	}


	
	switch ( $this->showcategory ) {	
		
		case 0:	$defcaption = WText::t('1206732372QTKJ');


			break;



		
		case 1: $defcaption = WText::t('1206732372QTKI');


			break;



		default: $defcaption = '';

			 break;

	}


	
	switch ( $this->showelapsedtimetitle ) {	
		
		case 0:	$defcaption = WText::t('1206732372QTKJ');

			WGlobals::setCookie( 'time_notitle', 1 );  
			break;



		
		case 1: $defcaption = WText::t('1206732372QTKI');

			WGlobals::setCookie( 'time_notitle', 0 );

			break;



		default: $defcaption = '';

			 break;

	}




	
	switch ( $this->showelapsedtime ) {	
		
		case 0:	$defcaption = WText::t('1206732372QTKJ');


			break;



		
		case 1: $defcaption = WText::t('1206732372QTKI');


			break;



		default: $defcaption = '';

			 break;

	}


	$numdisplay = $this->numdisplay;

	if ( empty($numdisplay) ) $numdisplay = 5;


	
	WGlobals::set( 'numdisplay', $numdisplay, 'global' );	


	$params = new stdClass;

	$params->maxitem = $numdisplay;			
	$controller->wid = WExtension::get( 'ticket.ticketmodule.module','wid' );

	$view = WView::get( 'ticket_last_tickets', 'html', $params, $controller );		


	$this->content = $view->make();



	return true;

}}