<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












WView::includeElement( 'form.textarea' );
class WForm_Corephpedit extends WForm_textarea {



	function create() {

		$this->element->editor = 'phpedit';

		if ( !empty($this->element->filef) ) {
			$contentFileType = $this->element->filef;
		} elseif ( !empty($this->element->typec) ) {
			$contentFileType=$this->element->typec;
		} else {
			$mess = Wmessage::get();
			$mess->codeE( 'Could not find any name of design addon defined in your phpedit type form element in order to display it.' );
			return false;
		}
			WLoadFile( 'design.system.class', JOOBI_DS_NODE );
			$addon = WAddon::get( 'design.' . $contentFileType );

		if (!$addon) return false;

		$content = $addon->load();

				$this->element->nicedit = null;

		if ( $content ) {

			$this->value = $content[1];
			parent::create();

						preg_match_all( '#^.*$#m', $content[0], $split );
			$line=count( $split[0] );

			foreach( $content as $index => $value ) {
				$value=htmlentities( $value, null, JOOBI_CHARSET );
				$value = str_replace( array("\r\n","\r","\n"), '<br/>', $value );
				$content[$index] = $value;
			}
						$this->content = $this->content . '<br/>' . $content[0] . '<br/>' . $content[2];
		} else {
			parent::create();
			$line = 0;
		}



		return true;

	}





}


