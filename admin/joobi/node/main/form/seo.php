<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WForm_Coreseo extends WForms_default {




	function create() {

		switch( $this->element->map ) {
			case 'seotitle':
			case 'name':
				if ( empty($this->value) ) {
					$value = $this->getValue('name');
				} else {
					$value = $this->value;
				}				$emailHelperC = WClass::get( 'email.conversion' );
				$value = $emailHelperC->smartHTMLSize( $value, 100, true, false, false, true );
				APIPage::setTitle( $value );
				WGlobals::set( 'titleheader', $value );
				break;
			case 'seokeywords':
				if ( empty($this->value) ) return false;
				APIPage::setMetaTag( 'keywords', $this->value );
				break;
			case 'seodescription':
			case 'introduction':
			case 'description':
				if ( empty($this->value) ) {
					$value = $this->getValue('introduction');
					if ( empty($value) ) $value = $this->getValue('description');
				} else {
					$value = $this->value;
				}
				$emailHelperC = WClass::get( 'email.conversion' );
				$value = $emailHelperC->smartHTMLSize( $value, 150, true, false, false, true );
				APIPage::setDescription( $value );
				break;
			default:
			break;
		}
		return false;

	}





	function show() {
		return $this->create();
	}


}

