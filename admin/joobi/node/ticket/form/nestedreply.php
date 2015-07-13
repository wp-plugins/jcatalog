<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WView::includeElement( 'form.layout' );
class Ticket_CoreNestedreply_form extends WForm_layout {


	function create() {



		$status = parent::create();

		if ( !$status ) $this->content = WText::t('1339527673WLQ');

		

		return true;

		

	}}