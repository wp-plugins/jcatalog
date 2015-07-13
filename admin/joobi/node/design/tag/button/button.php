<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');













































 class Design_Button_tag {













	public function process($object) {



		$tagsA = array();

		foreach( $object as $tag => $parameters ) {



			if ( empty($parameters) ) continue;



			$iconO = WPage::newBluePrint( 'button' );

			foreach( $iconO as $key => $oneP ) {

				if ( isset( $parameters->$key ) ) {

					$iconO->$key = $parameters->$key;

				}
			}


			$tagsA[$tag] = WPage::renderBluePrint( 'button', $iconO );



		}


		return $tagsA;



	}




}