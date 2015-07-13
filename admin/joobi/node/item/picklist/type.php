<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Item_Type_picklist extends WPicklist {
function create() {



	
	$prodTypeT = WType::get( 'item.designation' );

	if ( $this->onlyOneValue() ) {

		$this->addElement( $this->defaultValue, $prodTypeT->getName($this->defaultValue) );

	} else {

		$allPossibleTypeA = $prodTypeT->getList( false );

		
		foreach( $allPossibleTypeA as $key => $type ) {

			$nodeName = strtolower( $type );

			if ( $nodeName != 'product' ) {

				$exist = WExtension::get( $nodeName, 'folder', null, null, false );

			} else {

				$exist = true;

			}
			if ( !empty($exist) ) {

				$this->addElement( $key , $type );

			}
		}


	}


	return true;



}}