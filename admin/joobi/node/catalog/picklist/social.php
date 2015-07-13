<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Catalog_Social_picklist extends WPicklist {

	function create() {

		$this->addElement( '' , WText::t('1206732410ICCJ') );

		$socialA = array();

		if ( 'joomla' == JOOBI_FRAMEWORK_TYPE ) {
			$exist = WApplication::isEnabled( 'community', true );
			if ( $exist ) {
				$jomsocial = new stdClass;
				$jomsocial->option = 'joomla.jomsocial';
				$jomsocial->label = 'JomSocial';
				$jomsocial->extension = 'com_community';
				$socialA[] = $jomsocial;
			}			$exist = WApplication::isEnabled( 'easysocial', true );
			if ( $exist ) {
				$jomsocial = new stdClass;
				$jomsocial->option = 'joomla.easysocial';
				$jomsocial->label = 'EasySocial';
				$jomsocial->extension = 'com_easysocial';
				$socialA[] = $jomsocial;
			}		}
		foreach( $socialA as $community) {
						$this->addElement( $community->option , $community->label );
		}

				return true;

	}
}