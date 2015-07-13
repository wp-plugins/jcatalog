<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');







class Apps_Infos_class extends WClasses {


public function refreshalllicense($showMessage){

	$message=WMessage::get();

	$appsInfoC=WClass::get( 'apps.info' );
		$data=new stdClass;
	$data->url=$appsInfoC->myURL();
	$data->ip=WGlobals::get( 'SERVER_ADDR', '', 'server' );			$data->domain=WPref::load( 'PAPPS_NODE_DOMAIN' );
	$data->encoder=0;

		$netcom=WNetcom::get();
	$returned=$netcom->send( WPref::load('PAPPS_NODE_REQUEST'), 'license', 'refreshall', $data, false );

						
	if( empty($returned) || is_string($returned) || ( is_object($returned) && $returned->status===false)){

		$errorMessage=( !empty($returned->errorMessage)) ? $returned->errorMessage : '';
				switch( $errorMessage){
			case 'emptyParam':
				if( $showMessage) $message->userW('1251905717NHWT');
				return true;
				break;
			case 'unknowSite':
								if( $showMessage) $message->userW('1251905717NHWU');
				return true;
				break;
			case 'noLicenses':
								if( $showMessage) $message->userW('1251912852OWAG');
				return true;
				break;
			default:
				if( $showMessage) $message->userW('1298350280PMMA');
				WMessage::log( 'Error not defined reponse' , 'error-api_-key' );
				WMessage::log( $returned , 'error-api_-key' );
				WMessage::log( 'Sent data:' , 'error-api_-key' );
				WMessage::log( $data , 'error-api_-key' );
				break;
		}	}
	$result=true;
	if( !empty($returned)){
		if( is_array($returned)){
			if( !empty($returned)){
				foreach( $result as $oneR){
					$myR=$this->_installEach( $oneR );
					if( !$myR ) $result=false;
				}			}		}else{
			$result=$this->_installEach( $returned );
		}	}
	return $result;

}







	private function _installEach($returned){
		static $domain=null;
		$appsInfoC=WClass::get( 'apps.info' );

				if( !isset($domain) && ( $returned->domain !=WPref::load( 'PAPPS_NODE_DOMAIN' ) && in_array($returned->domain, array(31, 43, 56)) )){				$prefM=WPref::get('apps.node' );
			$prefM->updatePref( 'domain', $returned->domain );
			$domain=$returned->domain;
		}
				
		$result=true;
				if( !empty($returned->good)){
			foreach( $returned->good as $oneLic){
				if( empty($oneLic)) continue;
								$status=$appsInfoC->installSweet( $oneLic, true );
				if( !$status ) $result=false;
			}		}
		return $result;
	}
}
