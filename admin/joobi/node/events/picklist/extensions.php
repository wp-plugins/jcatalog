<?php 

* @link joobi.co
* @license GNU GPLv3 */




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