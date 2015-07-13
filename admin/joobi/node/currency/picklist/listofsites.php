<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Currency_Listofsites_picklist extends WPicklist {




function create()

{

	static $exchangeM=null;

	if ( empty($exchangeM) ) $exchangeM = WModel::get( 'currency.exchangesite' );

	$exchangeM->whereE( 'publish', 1 );

	$exchangeLink = $exchangeM->load( 'ol', array('url', 'name') );

	

	if ( !empty($exchangeLink) ) foreach( $exchangeLink as $urls ) $this->addElement( $urls->url, $urls->name );

	return true;

}













}