<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Theme_System_plugin extends WPlugin {


	function onAfterInitialise(){

		WGlobals::set( 'pluginThemeSystem', true, 'global' );

	}

	function onAfterRender(){

				if( JOOBI_FRAMEWORK_TYPE !='joomla' ) return true;

						
				$boostrapKin=WGlobals::get( 'themeCustomSkin', '', 'global' );
		if( empty($boostrapKin)) return true;

		$buffer=JResponse::getBody();

		
						$app=JFactory::getApplication();
		$template=$app->getTemplate();

		$existingTemplate=JOOBI_SITE_PATH . 'templates/' . $template . '/css/bootstrap.css';

		$count=0;
		$buffer=str_replace( $existingTemplate, $boostrapKin, $buffer, $count );

				if( empty( $count )){
			$addCSS='<link rel="stylesheet" href="' . $boostrapKin . '" type="text/css" />';
			$buffer=str_replace( '</head>', $addCSS . '</head>', $buffer );
		}
		JResponse::setBody( $buffer );

		return true;

	}
}