<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Editor_Default_addon extends Editor_Get_class {






	function getContent($fieldName) {

				$content = WGlobals::get( $fieldName, '', 'POST' );			$emailHelperC = WClass::get( 'email.conversion' );
  		if ( !empty($emailHelperC) ) $content = $emailHelperC->HTMLtoText( $content, true, false );

		return $content;

	}

}