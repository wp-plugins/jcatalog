<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Space_Theme_picklist extends WPicklist {


	







	function create() {





		$themeM = WModel::get( 'theme' );


		$themeM->makeLJ( 'themetrans', 'tmid' );

		$themeM->whereLanguage();

		$themeM->whereIn( 'type', array( 50, 1, 3 ) );

		$themeM->whereE( 'publish', 1 );

		$themeM->checkAccess();

		$themeM->select( 'name', 1 );

		$themeM->select( array( 'tmid' , 'namekey' ) );

		$themeM->setLimit(500);

		$themeM->orderBy( 'name', 'ASC', 1 );

		$results = $themeM->load('ol');






		if ( empty($results) ) return false;



		$this->addElement( '', ' -- ' . WText::t('1359430278ARKP') . ' -- ' );



		foreach( $results as $myResult ) {

			$this->addElement( $myResult->namekey , $myResult->name );

		}


		return true;



	}}