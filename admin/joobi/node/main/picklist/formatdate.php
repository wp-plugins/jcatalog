<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Formatdate_picklist extends WPicklist {








	function create() {



		


		$this->addElement( '', '' );
		$numberDate = 9;

		for ($index = 0; $index <= $numberDate; $index++) {


			$mydate = WTools::dateFormat( $index );

			if ( $mydate ) {

				$this->addElement( $index, WApplication::date( $mydate ) );

			}
		}

		for ($index = 0; $index < $numberDate; $index++) {

			$mydate = WTools::dateFormat( $index, true );



			if ( $mydate ) {

				$this->addElement( $index, WApplication::date( $mydate ) );

			}
		}



		$this->addElement( '73', WTools::durationToString( time()-5000, true ) .' (elapsed)' );	
		$this->addElement( '77', WTools::durationToString() .' ('.WText::t('1360289390KMBD').')' );	
		$this->addElement( '79', WText::t('1360289390KMBE') );	

	}

}