<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Widget_class extends WClasses {


	





    public function getWidgetTypeID($namekey) {
    	static $idA = array();

    	if ( isset( $idA[$namekey] ) ) return $idA[$namekey];

    	$mainWidgetM = WModel::get( 'main.widgettype' );
		$mainWidgetM->whereE( 'namekey', $namekey );
		$wgtypeid = $mainWidgetM->load( 'lr', 'wgtypeid' );

		$idA[$namekey] = $wgtypeid;
		return $wgtypeid;

    }






    public function getWidgetNamekeyFromTypeId($wgtypeid) {
    	static $idA = array();

    	if ( isset( $idA[$wgtypeid] ) ) return $idA[$wgtypeid];

    	$mainWidgetM = WModel::get( 'main.widgettype' );
		$mainWidgetM->whereE( 'wgtypeid', $wgtypeid );
		$namekey = $mainWidgetM->load( 'lr', 'namekey' );

		$idA[$wgtypeid] = $namekey;
		return $namekey;

    }





    public function getWidgetDefaultValue($wgtypeid) {

    	$namekey = $this->getWidgetNamekeyFromTypeId( $wgtypeid );
    	$tagC = WAddon::get( $namekey, null, 'tag' );
		if ( is_object($tagC) && method_exists( $tagC, 'initialValue' ) ) {
			return $tagC->initialValue();
		}
    }



}