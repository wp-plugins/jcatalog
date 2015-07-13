<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Translation_Translation_form_lang_view extends Output_Forms_class {
function prepareQuery(){



		$sid=WGlobals::getSession( 'translationSID', 'sid', 0 );



		if( !empty($sid)){

			$this->sid=$sid;

			foreach( $this->elements as $key=> $val){

				if( !empty($this->elements[$key]->sid)) $this->elements[$key]->sid=$sid;

			}


		}




		return true;



	}}