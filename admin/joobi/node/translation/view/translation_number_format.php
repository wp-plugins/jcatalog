<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Translation_Translation_number_format_view extends Output_Forms_class {

	function prepareView(){



		$localeconv=$this->getValue( 'localeconv' );


		$localeconvO=unserialize( $localeconv );



		if( empty($localeconvO)){

			$message=WMessage::get();

			$message->adminE( 'This language cannot be edited, please contact support!' );

			WPages::redirect( 'controller=translation' );

		}


		foreach( $localeconvO as $oneKey=> $onePAram){

			if( !is_array($onePAram))	$this->setValue( $oneKey, $onePAram );

		}




		return true;



	}}