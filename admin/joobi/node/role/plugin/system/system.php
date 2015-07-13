<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Role_System_plugin extends WPlugin {

function onAfterRoute(){

	if( JOOBI_FRAMEWORK_TYPE !='joomla' ) return;
	
	$functionName='onAfterRoute' . JOOBI_FRAMEWORK;
	if( method_exists( $this, $functionName )){
		return $this->$functionName();
	}else{
		return $this->onAfterRoutejoomla16();
	}
}




function onAfterRoutejoomla16(){

	if( JOOBI_FRAMEWORK_TYPE !='joomla' ) return;

	 if( !WExtension::exist( 'subscription.node' )) return;

	
	$option=WGlobals::getApp();

		$roleSectionsM=WModel::get( 'joomla.extensions' );
	$roleSectionsM->makeLJ( 'role.components', 'extension_id', 'id' );
	$roleSectionsM->whereE( 'element', $option, 0 );

	$roleSectionsM->select( array( 'rolid', 'site', 'admin' ), 1 );
	$result=$roleSectionsM->load( 'o' );

	if( !empty($result)){			
				if( WRoles::isAdmin()){
			if( empty($result->admin)) return;
		}else{
			if( empty($result->site)) return;
		}
		$rolid=WUser::roles();

		if( !in_array( $result->rolid, $rolid )){
			
			$message=WMessage::get();
			$message->userW('1206732348RCNT');

			$redirect=WPref::load( 'PSUBSCRIPTION_NODE_COMPREDIRECTLINK' );

			if( true){
								$url=(!empty($redirect))? $redirect : WPage::routeURL( 'controller=subscription&task=possible&rolid='. $result->rolid, '', false, false, true, 'jsubscription' );
			}else{
								$url=WPage::routeURL( 'controller=subscription&task=invalid', '', false, false, true, 'jsubscription' );
			}			WPages::redirect( ltrim( $url, '/' ));

		}
	}

}
}