<?php 

* @link joobi.co
* @license GNU GPLv3 */


WView::includeElement( 'form.layout' );
class Ticket_CoreNestedreply_form extends WForm_layout {


	function create() {



		$status = parent::create();

		if ( !$status ) $this->content = WText::t('1339527673WLQ');

		

		return true;

		

	}}