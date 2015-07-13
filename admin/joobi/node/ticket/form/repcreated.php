<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_CoreRepcreated_form extends WForms_default {


function create(){



	$tkrid=WGlobals::getEID( true );



	$model=WModel::get('ticket.reply');

	$model->whereE('tkrid',$tkrid[0]);

	$date=$model->load('lr','created');



	$this->content = WApplication::date( WTools::dateFormat( 'day-date-time' ), $date);

	return true;



}}