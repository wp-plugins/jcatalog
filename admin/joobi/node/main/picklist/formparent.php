<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Formparent_picklist extends WPicklist {

	function create() {


		$yid = $this->getValue( 'yid' );

		$designLayoutTypeT = WType::get( 'design.layoutype' );
		$acceptedTypeA = $designLayoutTypeT->allNames();


		$mainFormM = WModel::get( 'main.viewform' );
		$mainFormM->makeLJ( 'main.viewformtrans', 'fid' );
		$mainFormM->whereLanguage();
		$mainFormM->select( 'fid' );

		$mainFormM->select( 'name', 1 );
		$mainFormM->whereE( 'yid', $yid );
		$mainFormM->whereIn( 'type', $acceptedTypeA );
		$mainFormM->orderBy( 'ordering', 'ASC' );
		$allParentA = $mainFormM->load( 'ol' );

		$this->addElement( 0, 'Top' );
		if ( !empty($allParentA) ) {
			foreach( $allParentA as $oneParent ) {
				$this->addElement( $oneParent->fid, $oneParent->name );
			}		}

		return true;



	}}