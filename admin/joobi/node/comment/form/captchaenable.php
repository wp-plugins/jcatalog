<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'main.form.captcha' );
class Comment_Captchaenable_form extends WForm_captcha {









function create() {

		$captchatype = WPref::load( 'PUSERS_NODE_USECAPTCHA' );

	if ( $captchatype && WPref::load('PCOMMENT_NODE_CMTCAPTCHA') ) {			
		return parent::create();

	} else {

		return false;

	}
}}