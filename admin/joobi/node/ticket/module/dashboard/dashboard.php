<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












class Ticket_CoreDashboard_module extends WModule {




	public function create() {

		$controller = new stdClass;
		$controller->wid = WExtension::get( 'ticket.node', 'wid' );
		$params = new stdClass;

		$form = WView::getHTML( 'ticket_listing_dashboard' , $controller, $params );
		if ( !empty($form) ) $this->content = '<div>' . $form->make() . '</div>';

	}
}