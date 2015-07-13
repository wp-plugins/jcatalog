<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Apps_Applicationwid_picklist extends WPicklist {












function create(){



	$sql=WModel::get( 'apps' );

	$sql->select('name');

	$sql->whereE( 'publish' , 1 );

	$sql->whereE( 'type' , 1 );

	
	$sql->orderBy('name');

	$sql->select('wid');
	$sql->setLimit( 500 );

	$components=$sql->load('ol');

	if( !empty($components)){



		foreach($components as $component)  {

			$this->addElement( $component->wid , $component->name );

		}


	}


}}