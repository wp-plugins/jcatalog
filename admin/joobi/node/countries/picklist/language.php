<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Countries_Language_picklist extends WPicklist {


function create() {



	$lanagugesM = WModel::get( 'library.languages');
	if ( $this->onlyOneValue() ) {

		if ( !empty($this->defaultValue) ) {
			$lanagugesM->rememberQuery();
			$lanagugesM->whereE( 'lgid', $this->defaultValue );
			$langName = $lanagugesM->load( 'lr', 'name' );
		}
		if ( !empty( $langName ) ) {
			$this->addElement( $this->defaultValue, $langName );
			return true;
		} else {
			$this->addElement( 0, WText::t('1359546778AIBN') );
			return true;
		}
	}


	$lanagugesM->orderBy( 'name', 'ASC' );


	$ctryList=$lanagugesM->load( 'ol', array('lgid','name') );



	$this->addElement(0, '- ' . WText::t('1359546778AIBO') . ' -' );



	if ( !empty($ctryList) ) {

		foreach($ctryList as $oneLine) $this->addElement($oneLine->lgid,$oneLine->name);

	}


	return true;


}
}