<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_CoreRepmodified_form extends WForms_default {


function create(){



	$this->content = WApplication::date( WTools::dateFormat( 'day-date-time' ), time() );

		return true;



}}