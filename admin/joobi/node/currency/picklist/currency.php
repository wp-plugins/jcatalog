<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Currency_Currency_picklist extends WPicklist {


function create() {



	$sql = WModel::get( 'currency');



	
	$displayby = WGlobals::get( 'currency-displayby', true, 'global'  );

	$format = WGlobals::get( 'currency-format', true, 'global'  );



	switch ( $displayby )

	{

		case 1: $sql->whereE('accepted', 1);

			break;

		default : $sql->whereE('publish', 1);

			break;

	}


	$curNames = $sql->load('ol', array( 'curid', 'title', 'symbol', 'code' ) );



	if ( !empty($curNames) )  {

		if ( !empty( $curNames ) )  {

			switch ( $format ) {

				case 1 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, $curName->title .' ('. $curName->symbol .') ' );

					break;

				case 2 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, $curName->title .' ('. $curName->symbol .') ('. $curName->code .') ' );

					break;

				case 3 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, $curName->title .' ('. $curName->code .') ' );

					break;

				case 4 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, $curName->title .' ('. $curName->code .') ('. $curName->symbol .') ' );

					break;

				case 5 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, $curName->code );

					break;

				case 6 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, $curName->code .' ('. $curName->symbol .') ' );

					break;

				case 7 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, ' ('. $curName->code .') ('. $curName->symbol .') '. $curName->title );

					break;

				case 8 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, ' ('. $curName->code .') '. $curName->title );

					break;

				case 9 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, ' ('. $curName->code .') '. $curName->title .' ('. $curName->symbol .') ' );

					break;

				case 10 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, $curName->symbol );

					break;

				case 11 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, ' ('. $curName->symbol .') '. $curName->title );

					break;

				case 12 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, ' ('. $curName->symbol .') '. $curName->title  .' ('. $curName->code .') ' );

					break;

				case 13 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, ' ('. $curName->symbol .') '. $curName->code );

					break;

				case 14 : foreach( $curNames as $curName ) $this->addElement( $curName->curid, '('. $curName->symbol .') ('. $curName->code  .') '. $curName->title );

					break;

				default : foreach( $curNames as $curName ) $this->addElement( $curName->curid, $curName->title );

					break;

			}
		}
	}


}}