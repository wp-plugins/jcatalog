<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_Ticket_types_picklist extends WPicklist {
function create() {



	

	$ticketTypeM = WModel::get( 'ticket.type' );


	$ticketTypeM->makeLJ( 'ticket.typetrans', 'tktypeid' );

	$ticketTypeM->whereLanguage();

	$ticketTypeM->select( 'name', 1 );

	$ticketTypeM->whereE( 'publish', 1 );

	$ticketTypeM->checkAccess();

	$ticketTypeM->orderBy( 'ordering' );

	$allTypesA = $ticketTypeM->load( 'ol', 'tktypeid' );

	

	if ( empty($allTypesA) ) return false;

	

	$this->addElement( 0, ' - ' . WText::t('1361919650QJLB') . ' - ' );

	

		$defaultText = '';

		foreach( $allTypesA as $productType ) {

			$productTypeID = $productType->tktypeid;

			$productTypeName = $productType->name;


			

			
			$this->addElement( $productTypeID, $productTypeName );

		}




	return true;



}}