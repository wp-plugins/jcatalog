<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Apps_refreshalllicense_controller extends WController {


function refreshalllicense(){



	$extensionInfosC=WClass::get( 'apps.infos' );
	$result=$extensionInfosC->refreshalllicense( true );

	if( $result ) $this->userS('1251905717NHWW');
	else $this->userW('1251959063BNBJ');


	return true;

}
}