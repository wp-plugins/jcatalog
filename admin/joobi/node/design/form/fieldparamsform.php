<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.layout' );
class Design_Fieldparamsform_form extends WForm_layout {

	function create() {



		
		$designFieldsC = WClass::get( 'design.fields' );

		$namekey = $designFieldsC->load( $this->getValue( 'fieldid' ), 'form' );


		$mainDirectEditC = WClass::get( 'main.directedit' );

		$exist = $mainDirectEditC->getParamsView( $namekey, 'form' );



		if ($exist) {

			$this->viewID = $exist;

			return parent::create();

		} else {

			return false;

		}


		return true;



	}
}