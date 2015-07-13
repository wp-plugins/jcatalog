<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');













































 class Design_Icon_tag {













	public function process($object) {



		$tagsA = array();

		foreach( $object as $tag => $parameters ) {



			if ( empty($parameters) ) continue;



			$iconO = WPage::newBluePrint( 'icon' );

			$allMapA = array( 'icon', 'text', 'size', 'color', 'animation' );


			foreach( $allMapA as $oneP ) {

				if ( isset( $parameters->$oneP ) ) {

					$iconO->$oneP = $parameters->$oneP;


				}
			}





			if ( !empty($iconO->animation) ) WPage::renderBluePrint( 'initialize', 'font-awesome-animation' );

			else WPage::renderBluePrint( 'initialize', 'font-awesome' );



			$tagsA[$tag] = WPage::renderBluePrint( 'icon', $iconO );



		}


		return $tagsA;



	}




}