<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Translation_En_model extends WModel {


	function editValidate(){



		
		$this->auto=2;



		return true;



	}




	function extraValidate(){


		$namekey=WModel::get( $this->sid, 'namekey' );
		$namekeyA=explode( '.', $namekey );



		
		$translationPopulateC=WClass::get( 'translation.populate' );
		$translationPopulateC->updateTranslation( $this->imac, $this->text, $namekeyA[1] );



		return true;



	}
}