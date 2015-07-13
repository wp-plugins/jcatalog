<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Countries_Listpublishedstates_picklist extends WPicklist {




function create() {



	static $states=null;

	if ( empty($states) ) {

		static $statesM=null;

		if ( empty($statesM) ) $statesM = WModel::get( 'countries.states' );



		$statesM->makeLJ( 'countries', 'ctyid' );

		$statesM->whereE( 'publish', 1 );

		$statesM->orderBy( 'ordering', 'ASC', 1 );


		$statesM->select(  'ctyid', 1 );
		$statesM->select( 'name', 1, 'countryName' );
		$statesM->orderBy( 'ordering' );

		$states = $statesM->load( 'ol', array( 'stateid', 'name' ) );

	}


	$defaultSatesA = WGlobals::get( 'countriesStatesSelected', array(), 'global' );

	if ( !empty($defaultSatesA) ) $this->setDefault( $defaultSatesA, true );



	if ( !empty($states) ) {

		$firstLetter = null;

		foreach( $states as $state ) {

			$stateID = $state->stateid;

			$stateName = $state->name;










						if ( $firstLetter != $state->ctyid ) {
				$firstLetter = $state->ctyid;
				$this->addElement( -1, '-- '. $state->countryName );
			}



			
			$this->addElement( $stateID, $stateName );

		}


		return true;

	} else return false;



}}