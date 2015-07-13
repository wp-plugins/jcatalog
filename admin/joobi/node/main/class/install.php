<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




 class Main_Install_class extends WClasses {







 	public function insertExtension($namekey,$name,$widParent) {


 		$appsM = WModel::get( 'apps' );
 		$appsM->whereE( 'namekey', $namekey );
 		$wid = $appsM->load( 'lr', 'wid' );

 		if ( !empty($wid) ) return $wid;

 		if ( is_int($widParent) ) $widParent = WExtension::get( $widParent, 'namekey' );

 		$parentFolder = WExtension::get( $widParent, 'folder' );

 		 		$namekeyA = explode( '.', $namekey );	
 		$foldersT = WType::get( 'apps.typefolder' );
 		$type = $foldersT->getValue( $namekeyA[2] );

 		$appsM->namekey = $namekey;
 		$appsM->name = $name;
 		$appsM->type = $type;
 		$appsM->folder = $namekeyA[0];
 		$appsM->destination = 'node|' . $parentFolder . '|' . $namekeyA[2];	 		$appsM->core = 1;
 		$appsM->publish = 1;
 		$appsM->certify = 1;
 		$appsM->reload = 1;
 		 		$appsM->returnId();
 		$appsM->insertIgnore();

 		if ( !empty($appsM->wid) ) return $appsM->wid;
 		return false;

 	}
}
