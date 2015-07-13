<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');










class Files_Fancyupload_class extends WClasses{





    function check() {


    	$fancyFileUpload = WPref::load( 'PLIBRARY_NODE_FANCYUPLOAD' );

    	if ( !empty($fancyFileUpload) ) {
    		$browser = WPage::browser( 'namekey' );
    		if ( 'msie' == $browser ) {
    			$version = WPage::browser( 'version' );
    			if ( version_compare( $version, '10.0', '<' ) ) $fancyFileUpload = false;
    		}    	}
    	return $fancyFileUpload;

	}
}