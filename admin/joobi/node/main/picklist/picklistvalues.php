<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Main_Picklistvalues_picklist extends WPicklist {
	function create() {



	
		$did = WGlobals::get( 'picklistParent', '', 'global' );



		if ( empty($did) ) return false;



		$pickListP = WView::picklist( $did );

		$allValuesA = $pickListP->getValues();



		if ( !empty( $allValuesA ) ) {

			foreach( $allValuesA as $oneKey => $oneValue ) {



				$this->addElement( $oneKey, $oneValue );



			}


		}


		return true;



	}}