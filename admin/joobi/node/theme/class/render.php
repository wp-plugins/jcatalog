<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Theme_Render_class extends WClasses {

	static private $_preferencesO=null;


	function __construct(){

				$params=WThemeHTML::$themeParams;
		if( !empty( $params )){
			self::$_preferencesO=new stdClass;
			self::$_preferencesO->params=$params;
			WTools::getParams( self::$_preferencesO );
		}
		if( empty( self::$_preferencesO )){
						self::$_preferencesO=WObject::get( 'theme.preferences' );

		}
	}






	public function newObject($data=null){
		$className=get_class( $this ) . 'Object';
		if( class_exists($className)) return new $className;
		else return new stdClass;
	}





	protected function value($property){

		if( is_string($property)){
			$property=str_replace( '.', '_', $property );
			if( isset( self::$_preferencesO->$property )) return self::$_preferencesO->$property;
		}elseif( is_array($property)){
			$returnA=array();
			foreach( $property as $oneP){
				$onePDOT=str_replace( '.', '_', $oneP );
				if( isset( self::$_preferencesO->$onePDOT )) $returnA[$oneP]=self::$_preferencesO->$onePDOT;
				else $returnA[$oneP]=null;
			}			return $returnA;
		}
		return null;
	}






	protected function overwriteThemePreferences($themeCustomO){

		if( empty($themeCustomO)) return false;
		foreach( $themeCustomO as $key=> $value){
			self::$_preferencesO->$key=$value;
		}
	}
}