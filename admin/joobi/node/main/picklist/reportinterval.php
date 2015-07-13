<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Reportinterval_picklist extends WPicklist {

	function create() {



		$this->addElement( 7 , WText::t('1256627134RCAT') );

		$this->addElement( 15 , WText::t('1256627134RCAU') );

		$this->addElement( 23 , WText::t('1256627134RCAV') );

		$this->addElement( 33 , WText::t('1256627135RQMT') );



		return true;



	}
}