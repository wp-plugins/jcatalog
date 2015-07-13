<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class WForm_Corewidget extends WForms_default {

	private static $_i = 0;




	function create() {

		return $this->show();

	}





	function show() {


		if ( empty( $this->element->widgetid ) ) return false;

						$outputwidgetsC = WClass::get( 'output.widgets' );
		$widgetO = $outputwidgetsC->loadWidgetsForView( $this->yid, $this->element->widgetid );

		if ( empty($widgetO) ) return false;


		$widgetParams = WGlobals::get( 'pageWidgetParams', null, 'global' );
		if ( empty( $widgetParams ) ) $widgetParams = new stdClass;
		$widgetParams->widgetid = $widgetO->widgetid;
				if ( !empty($widgetParams->pagination) ) {
			$widgetParams->yid = WGlobals::filter( $this->element->namekey, 'namekey' );
			$widgetParams->yid = str_replace( '.', '_', $widgetParams->yid );
			self::$_i++;
			$widgetParams->yid = $widgetParams->yid . '_' . self::$_i;

			$uniqueNameState = $widgetParams->yid;

		}
		$tagString = $outputwidgetsC->createWidgetString( $widgetO, $widgetParams );
		$outputProcessC = WClass::get('output.process');
		$outputProcessC->replaceTags( $tagString );

		$allWidgetParamsO = $outputProcessC->returnParams( $widgetO->widgetid );

				if ( !empty($widgetParams->pagination) && !empty($allWidgetParamsO->totalCount) ) {
			$startLimit = WGlobals::getUserState("wiev-$uniqueNameState-limitstart", 'limitstart'.$uniqueNameState, 0, 'int' );
			$pagiI = WView::pagination( $uniqueNameState, $allWidgetParamsO->totalCount, $startLimit, $allWidgetParamsO->nb, 0, 'Items', 'home' );
			$pagiI->setFormName( $this->formName );

						WGlobals::set( 'paginationFormElementNav' . $this->element->parent, $pagiI->getListFooter(), 'global' );
						$pagiNow = WText::t('1206732366OVLY') . $pagiI->displayNumber( $this->formName );				WGlobals::set( 'paginationFormElementDisplay' . $this->element->parent, $pagiNow, 'global' );

		}
		$this->content .= $tagString;

		return true;

	}

}