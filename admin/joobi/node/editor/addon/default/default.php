<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Editor_Default_addon extends Editor_Get_class {






	function getContent($fieldName) {

				$content = WGlobals::get( $fieldName, '', 'POST' );			$emailHelperC = WClass::get( 'email.conversion' );
  		if ( !empty($emailHelperC) ) $content = $emailHelperC->HTMLtoText( $content, true, false );

		return $content;

	}

}