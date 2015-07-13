<?php
/*
Plugin Name: jCatalog
Plugin URI: http://joobi.co?l=home_jcatalog.application
Description: An application to organize and list items, products, images, videos, etc...
Author: Joobi
Author URI: http://joobi.co
Version: 1.10.8
*/

/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


if((defined('ABSPATH')) && !defined('JOOBI_SECURE')) define('JOOBI_SECURE',true);
defined('JOOBI_SECURE') or define( 'JOOBI_SECURE', true );

register_activation_hook( __FILE__, 'jcatalog_activate' );
register_deactivation_hook( __FILE__, 'jcatalog_deactivate' );

add_action( 'admin_init', 'install_jcatalog' );
add_action( 'template_redirect', 'joobiIsPopUp' );

if(!empty( $_POST['page'])) $_GET['page']=$_POST['page'];

function jcatalog_pluginActionLinks_WP($links) {
	return WApplication_wp4::renderFunction( 'install',  'pluginActionLinks', array( 'jcatalog', $links ) );
}function jcatalog_installNotice_WP() {
    ob_start();
	$html = WApplication_wp4::renderFunction( 'install',  'installNotice', 'jcatalog' );
    ob_end_clean();
    echo $html;
}function jcatalog_activate() {
	add_option( 'jcatalogActivated_Plugin', 'jcatalog' );
}function jcatalog_deactivate() {
	add_option( 'jcatalogDeActivated_Plugin', 'jcatalog' );
}function install_jcatalog() {

	if ( is_admin() ) {

		if ( get_option( 'jcatalogActivated_Plugin' ) == 'jcatalog' ) {

			delete_option( 'jcatalogActivated_Plugin' );

	        	        include( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'install.php' );
	        if ( class_exists( 'install_joobi' ) ) {
				$joobiInstaller = new install_joobi ;
				$joobiInstaller->setCMS('wordpress','jcatalog');
				$joobiInstaller->setDistribServer('http://joobiserver.com/w/wp/p21');
				$joobiInstaller->setLicense('http://register.joobi.co');
								$joobiInstaller->installJoobi();
	        }
			WApplication_wp4::renderFunction("install","install",'jcatalog');

		} elseif ( get_option( 'jcatalogDeActivated_Plugin' ) == 'jcatalog' ) {
			delete_option( 'jcatalogDeActivated_Plugin' );
			WApplication_wp4::renderFunction("install","uninstall",'jcatalog');
		}
	}
}
$joobiEntryPoint = __FILE__ ;
$status = @include(ABSPATH  . 'joobi'.DIRECTORY_SEPARATOR.'entry.php');
