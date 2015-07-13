<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');







abstract class WUsers extends WUser {

}

abstract class WRoles extends WRole {









	public static function isAdmin($role=''){

		$mySpace=WGlobals::getSession( 'page', 'space', null );
		$isAdmin=( in_array( $mySpace, array( 'vendors', 'sitevendors' )) ? false : IS_ADMIN );

				if( ! $isAdmin ) return false;
		elseif( empty($role)) return true;
		else {
			$roleC=WRole::get();
			return $roleC->hasRole( $role );
		}
	}









	public static function isNotAdmin($role=''){

		$mySpace=WGlobals::getSession( 'page', 'space', null );
		$isAdmin=( in_array( $mySpace, array( 'vendors', 'sitevendors' )) ? false : IS_ADMIN );

				if( ! $isAdmin ) return true;
		elseif( empty($role)) return false;			else {
			$roleC=WRole::get();
			return ( ! $roleC->hasRole( $role ));			}
	}
}

abstract class WPages extends WPage {












	public static function redirect($url=null,$wPageID=true,$route=true,$code=303,$extraURL=''){
		static $count=0;

				if( ! IS_ADMIN){

			return WPage::redirect( $url, $wPageID, $route, $code, $extraURL );
		}
		$errorCode='WP4: Eror in the redirect';


				$count++;
		if( $count > 3){
			$errorCode='The page is redirecting too many times!';

WMessage::log( ' --- The page is redirecting too many times! : ', 'wp4-debug-redirect' );
WMessage::log( $url , 'wp4-debug-redirect' );
WMessage::log( debugB() , 'wp4-debug-redirect' );


			echo $errorCode;

		}

				if( $url=='previous'){

			static $countPrevious=0;

			$countPrevious++;

									$url=WGlobals::getReturnId();

			if( empty($url)){
				$url=WGlobals::get('HTTP_REFERER','','server','string');

				if(empty($url) || strpos($url,JOOBI_SITE)===false){
					$url=JOOBI_SITE . (( IS_ADMIN ? 'wp-admin' : '' ));				}else{
					$url=str_replace( '&amp;', '&', $url );
				}
			}
			if( empty($url)){
												if( $countPrevious > 1){
										WGlobals::set( 'controller', '' );
					WGlobals::set( 'task', '' );
				}
				self::_launchAgainApplication( $errorCode );

			}else{

								if( ! IS_ADMIN && is_numeric($wPageID)){
					if( strpos( $url, JOOBI_PAGEID_NAME )===false ) $url .='&page_id=' . $wPageID;
				}			}
		}

		$storeMessage=true;
				if( !empty($extraURL)) WGlobals::set( 'extraURL-Joobi', $extraURL, 'global' );

		if( !isset($url)){
			$url=WGlobals::getReturnId();
			$url=WPage::routeURL( $url, '', 'default', $SSL, $wPageID );
		}elseif( $route){
			$url=trim( $url );
						$startURL=substr( $url, 0, 4);
			if( $startURL !='http' && $startURL !='inde'){
				$url=ltrim( $url, '?' );
			}else{
								$storeMessage=false;
			}
		}


		if( !empty($extraURL)){
			$urlExtra=strpos( $url, '?' ) ? '&' : '?';
			$urlExtra .=ltrim( $extraURL, '&' );
			$url .=htmlentities( $urlExtra );			}
				$isPopUp=WGlobals::get( 'is_popup', false, 'global' );

		if( !IS_ADMIN && $isPopUp){
			$url .=URL_NO_FRAMEWORK;				$url .='&isPopUp=true';			}

				$url=str_replace( '&amp;', '&', $url );
		if( strpos( $url, '&' ) !==false){
			$explodedA=explode( '&', $url );
			$explodedNewA=array();
			foreach( $explodedA as $oneS1){
				if( substr( $oneS1, 0, 5 )=='trucs' ) continue;
				$explodedNewA[]=$oneS1;
			}			$url=implode( '&', $explodedNewA );
		}
				$pos=strrpos( $url, '?' );
		if( $pos !==false){
			$url=substr( $url, $pos+1 );
		}
		$explodeURLA=explode( '&', $url );

		if( !empty($explodeURLA)){


						WController::resetAllRequest();

						foreach( $explodeURLA as $onePs){
				$stilEA=explode( '=', $onePs );
				if( !empty($stilEA[0])){
					$value=( !empty($stilEA[1]) ? $stilEA[1] : '' );
					WGlobals::set( $stilEA[0], $value );
				}			}
			self::_launchAgainApplication( $errorCode );

		}

				return false;


	}






	private static function _launchAgainApplication($errorCode){

		WController::resetTask();

				$app=new WApplication_wp4();
		$response=$app->make( 'relaunch', null );	
		if( !empty($response)){
			WGlobals::set( 'alreadyHTML', $response, 'global' );
			return;
		}
	}
}