<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Events_Extensions_picklist extends WPicklist {








function create(){



	$sql=WModel::get( 'apps' );


	$sql->select( array('name','type','wid')) ;

	$sql->whereE( 'publish' , 1 );



	
	$sql->whereE( 'type', 150 );

	

	$sql->orderBy('name');

	$sql->setLimit( 10000 );

	

	$components=$sql->load('ol');



	if( !empty($components)){



		foreach( $components as $component )  {



			$this->addElement( $component->wid , $component->name );



		}


	}


}}