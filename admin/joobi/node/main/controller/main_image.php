<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_image_controller extends WController {

	function image() {


		$path = WGlobals::get( 'path' );

		$data = json_decode( base64_decode($path) );
		if ( !empty($data->node) && !empty($data->fct) ) {
			$class = WClass::get( $data->node . '.netcom', null, 'class', false );
			if ( !empty($class) ) {
				$fct = $data->fct;
				if ( method_exists( $class, $fct ) ) $class->$fct( $data );
			}		}
				if ( !defined('JOOBI_URL_THEME_JOOBI') ) WView::definePath();

				ob_end_clean();
		$filename = JOOBI_DS_THEME_JOOBI . 'images' . DS . 'blank.png';
		$handle = fopen( $filename, 'r' );
		$contents = fread( $handle, sprintf( "%u", filesize($filename) ) );
		fclose( $handle );
		header( "Content-type: image/png" );

				echo $contents;
		exit();


		return false;



	}
}