<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Apps_Applicationsupport_picklist extends WPicklist {










function create(){



	$sql=WModel::get( 'apps' );


	$sql->select('name');

	$sql->whereE( 'publish' , 1 );

	$sql->whereE( 'type' , 1 );


	



	$sql->orderBy('name');

	$sql->select('namekey');



	$sql->setLimit( 500 );

	$components=$sql->load();



	$types=WType::get( 'apps.level' );



	if( !empty($components)){



		foreach($components as $component)  {





















			$this->addElement( $component->namekey , $component->name ); 
		}


	}


}}