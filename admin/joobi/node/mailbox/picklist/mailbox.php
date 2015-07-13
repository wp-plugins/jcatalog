<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Mailbox_Mailbox_picklist extends WPicklist {




	function create() {

		$mailboxM = WModel::get( 'mailbox' );
		$mailboxM->rememberQuery( true, 'Mailbox_node' );
		$mailboxM->whereE( 'publish', 1 );
		$mailboxM->setLimit( 500 );
		$mailboxM->orderBy( 'name' );
		$results = $mailboxM->load( 'ol', array('name','inbid') );

		if ( !empty($results) ) {
			foreach( $results as $myResult ) {
				$this->addElement( $myResult->inbid , $myResult->name );
			}		}
		return true;

	}
}