<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Widget_picklist extends WPicklist {
function create() {



	if ( $this->onlyOneValue() ) {

		$appsM = WModel::get( 'main.widgettype' );

		$appsM->makeLJ( 'main.widgettypetrans' );

		$appsM->whereLanguage();

		$appsM->select( 'name', 1 );

		$appsM->whereE( 'wgtypeid', $this->defaultValue );


		$appsM->checkAccess();
		$appsM->rememberQuery();

		$oneWidget = $appsM->load( 'o', 'wgtypeid' );

		if ( !empty($oneWidget) ) $this->addElement( $oneWidget->wgtypeid, $oneWidget->name );

		return true;

	}




	$appsM = WModel::get( 'main.widgettype' );

	$appsM->makeLJ( 'main.widgettypetrans' );

	$appsM->whereLanguage();

	$appsM->select( 'name', 1 );

	$appsM->whereE( 'publish', 1 );

	$appsM->checkAccess();

	$appsM->orderBy( 'groupid' );

	$appsM->orderBy( 'name', 'ASC', 1 );

	$allWdigetsA = $appsM->load( 'ol', array( 'wgtypeid', 'groupid' ) );



	$this->addElement( 0, '-' . WText::t('1379039266OOHC') .  '-'  );





	if ( !empty( $allWdigetsA ) ) {



		$widgetGroupP = WView::picklist( 'main_widget_group' );

		$currentGRoup = 0;

		foreach( $allWdigetsA as $oneWidget ) {



			if ( $oneWidget->groupid > 100 ) continue;



			if ( $currentGRoup != $oneWidget->groupid ) {
				$nameType = $widgetGroupP->getName( $oneWidget->groupid );
				if ( !empty($nameType) ) {
					$this->addElement( '--' . $oneWidget->groupid , '--' . $nameType );
				}
				$currentGRoup = $oneWidget->groupid;

			}
			$this->addElement( $oneWidget->wgtypeid, $oneWidget->name );



		}


	}


	return true;



}}