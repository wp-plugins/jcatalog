<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_credentials_edit_controller extends WController {

	function edit() {

		$eid= WGlobals::getEID();

		$mainCredentialsC = WClass::get( 'main.credentials' );

		$typeName = $mainCredentialsC->getTypeName( $eid );


		if ( $typeName === false ) return parent::edit();



		$view = 'main_credential_form_' . $typeName;

		$viewName = WView::get( $view, 'namekey', null, null, false );

		if ( empty($viewName) ) {
			$viewName = 'main_credential_form_default';
		}

		$this->setView( $viewName );



		return parent::edit();



	}
}