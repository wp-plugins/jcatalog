<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Main_Reportinterval_picklist extends WPicklist {

	function create() {



		$this->addElement( 7 , WText::t('1256627134RCAT') );

		$this->addElement( 15 , WText::t('1256627134RCAU') );

		$this->addElement( 23 , WText::t('1256627134RCAV') );

		$this->addElement( 33 , WText::t('1256627135RQMT') );



		return true;



	}
}