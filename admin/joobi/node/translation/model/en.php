<?php 

* @link joobi.co
* @license GNU GPLv3 */



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