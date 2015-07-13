<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_uninstall_controller extends WController {


	function uninstall(){



		$eid=WGlobals::getEID();

		if( empty($eid)) $eid=WGlobals::get( 'wid' );

		if( empty($eid)) return true;



		$appsM=WModel::get( 'apps' );

		$appsM->whereE( 'wid', $eid );

		$appsM->setVal( 'publish', 0 );

		$appsM->update();



		


		return true;



	}}