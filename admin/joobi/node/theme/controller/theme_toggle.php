<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Theme_toggle_controller extends WController {


	function toggle(){



		$eid=WGlobals::getEID();



		$property=$this->getToggleValue( 'map' );




		if( $property=='premium'){



			$themeC=WClass::get( 'theme.helper' );

			$themeC->unPremium( $eid );

			$themeC->setPremium( $eid );



			$cache=WCache::get();

	
			
	
			$cache->resetCache();



		}


		parent::toggle();



		return true;



	}}