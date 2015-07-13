<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CorePriority_listing extends WListings_default{






function create() {



	$res='';



	static $droplist = null;

	if ( empty( $droplist ) ) $droplist = WType::get( 'ticket.priority' );

	

	switch (  $this->value ) {

		case 10:

			$res='<span style="color:blue">'.$droplist->getName( $this->value ).'</span>';

			break;

		case 20:

			$res='<span style="color:green">'.$droplist->getName( $this->value ).'</span>';

			break;

		case 30:

			$res='<span style="color:orange">'.$droplist->getName( $this->value ).'</span>';

			break;

		case 40:

			$res='<span style="color:red">'.$droplist->getName( $this->value ).'</span>';

			break;

		default:

			$res='<span style="color:magenta">'.$droplist->getName( $this->value ).'</span>';		

			break;		

	}
	

	$this->content = $res;

	

	return true;

	

}}