<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Users_Currency_picklist extends WPicklist {
function create(){



	$this->addElement( 0, WText::t('1206732410ICCJ'));

	

	$currencyM=WModel::get( 'currency' );

	$currencyM->whereE( 'publish', 1 );

	$currencyM->orderBy( 'ordering' );

	$currencyM->setLimit( 500 );

	$currenciesA=$currencyM->load( 'ol', array( 'curid', 'title', 'code', 'symbol'));





	if( !empty($currenciesA)){

		foreach( $currenciesA as $currencies){

			$this->addElement( $currencies->curid, $currencies->title . ' ('. $currencies->symbol .')' );

		}
	}
	

}}