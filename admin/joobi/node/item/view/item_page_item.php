<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_page_item_view extends Output_Forms_class {
protected $_catalogItemPageC = null;



	protected $pid = null;



	protected $itemTypeInfoO = null;



	protected $vendid = 0;	


	protected $pageParams = null;









	protected function prepareView() {



		
		$adid = $this->getValue( 'adid' );

		$this->vendid = $this->getValue('vendid');



		$this->_catalogItemPageC = WClass::get( 'catalog.itempage' );


				$this->pid = WGlobals::getEID();
		if ( empty( $this->pid ) ) $this->pid = $this->getValue( 'pid' );

		$itemLoadC = WClass::get( 'item.type' );
		$this->itemTypeInfoO = $itemLoadC->loadTypeBasedOnPID( $this->pid );
		$this->customItemType();


				$this->pageParams = $this->_catalogItemPageC->setupItemInformation( $this, $this->itemTypeInfoO, true );



		
		
		$pageID = $this->getValue( 'pageprdpgid' );

		if ( empty($pageID) && !empty($this->itemTypeInfoO->pageprdpgid) ) $pageID = $this->itemTypeInfoO->pageprdpgid;	
		if ( !empty($pageID) ) $this->_catalogItemPageC->handlePageID( $pageID, $this->pid );



		
		$this->bctrail = WPref::load( 'PCATALOG_NODE_BREADCRUMBS' );



		$printPage = WGlobals::get( 'printpage' );








		$checkFeedback = ( WGlobals::checkCandy(50,true) ? false : true );

		
		WGlobals::set( 'itemAllowReview', ( $this->pageParams->allowReview && $checkFeedback ), 'global' );



		if ( $this->pageParams->showAskQuestion ) $this->setValue( 'askQuestionLink', $this->_catalogItemPageC->askQuestion( $this->vendid ) );



		
		$this->_catalogItemPageC->getTerms( $this->itemTypeInfoO, $this );



		
		$this->_communProcessing();



		
		
		$itemName = $this->getValue( 'name' );



		
		
		$availableStartDate = $this->getValue( 'availablestart' );

		$availableEndDate = $this->getValue( 'availableend' );



		
		
		
		
		if ( !empty( $availableEndDate ) && ( time() > $availableEndDate ) ) $isAvailable = 'expired';

		else {

			if ( time() > $availableStartDate ) $isAvailable = 'avail';

			else $isAvailable = 'unavail';

		}

		WGlobals::set( 'productAvailable', $isAvailable, 'global' );


		$this->_modelName = $this->_model->getModelNamekey();


		
		$this->setValue( 'feedback', $checkFeedback );

		if ( !$checkFeedback ) {

			
			$this->removeElements( $this->_modelName . '_page_item_' . $this->_modelName . '_comment', $this->_modelName . '_page_item_vendor_rating', $this->_modelName . '_page_item_' . $this->_modelName . '_nbreviews', $this->_modelName . '_page_item_comment_total' );

		}




		if ( !WExtension::exist( 'vendors.node' ) ) {
			$this->removeElements( array( $this->_modelName . '_page_item_vendor_rating', $this->_modelName . '_page_item_' . $this->_modelName . '_vendid' ) );

		}




		if ( $this->getValue( 'showprint' ) ) {

			
			$link = 'controller=catalog&task=show&eid='. $this->pid .'&printpage=1&hidecomment=1' . URL_NO_FRAMEWORK;	
			$printLink = WPage::routeURL( $link, 'home', 'popup', false, false, null, true );

			$this->setValue( 'showPrintButton', $printLink );



			
			
			if ( $printPage ) WPage::addJSScript( 'window.print();' );



		}


				$pageParams = WGlobals::get( 'itemPageMain', '', 'global' );
		if ( empty( $pageParams->showDesc ) ) {
			$this->removeElements( $this->_modelName . '_page_item_' . $this->_modelName . 'trans_description' );
		}


		
		$this->_showRelatedItems();

				$this->_createItemMap();



				$syndid = WGlobals::get( 'syndid' );
		if ( !empty($syndid) ) {
			$vendorHelperC = WClass::get('vendor.helper' );
			$vendorName = $vendorHelperC->getVendor( $syndid, 'name' );
			$link = WPages::link( 'controller=vendors&task=home&eid=' . $syndid );
			$linkHTML =  '&nbsp;' . WText::t('1217326499HUVQ') .  '&nbsp;<a href="' . $link . '">' . $vendorName . '</a>';
			$this->setValue( 'syndicateVendor', $linkHTML );
		}

				$this->_recentlyViewed();


		return true;


	}






	private function _recentlyViewed() {
		static $lasttimeA = array();

		if ( ! WPref::load( 'PITEM_NODE_RECENTLYVIEWED' ) ) return false;

		$logUID = WUser::get( 'uid' );
		$cookieID = WGlobals::getCookieUser();
		$time = time();

		if ( !empty( $logUID ) ) {
			$key = $logUID . '_' . $time;
		} else {
			$key = $cookieID . '_' . $time;
		}		if ( isset($lasttimeA[$key]) ) return true;
		$lasttimeA[$key] = $time;


		$itemViewedM = WModel::get( 'item.viewed' );
		$itemViewedM->whereE( 'pid', $this->pid );

		if ( !empty( $logUID ) ) {
			$itemViewedM->whereE( 'uid', $logUID );
		} else {
			$itemViewedM->whereE( 'cookieid', $cookieID );
		}		$itvwid = $itemViewedM->load( 'lr', 'itvwid' );


		if ( empty($itvwid) ) {
			$itemViewedM->setVal( 'pid', $this->pid );
			$itemViewedM->setVal( 'created', $time );
			$itemViewedM->setVal( 'modified', $time );
			$itemViewedM->setVal( 'cookieid', $cookieID );
			$itemViewedM->setVal( 'total', 1 );
			if ( !empty( $logUID ) ) {
				$itemViewedM->setVal( 'uid', $logUID );
			}			$itemViewedM->insertIgnore();
		} else {

			if ( !empty( $logUID ) ) {
				$itemViewedM->setVal( 'cookieid', $cookieID );
			} else {
				$itemViewedM->whereE( 'cookieid', $cookieID );
			}
						$itemViewedM->whereE( 'itvwid', $itvwid );
			$itemViewedM->setVal( 'modified', $time );
			$itemViewedM->updatePlus( 'total', 1 );
			$itemViewedM->update();

		}

	}






	protected function prepareTheme() {

		$mainCredentialsC = WClass::get( 'main.credentials' );
		$appID = $mainCredentialsC->loadFromType( 'facebook', 'username' );
		if ( !empty($appID) ) {
						WPage::setMetaTag( 'og:title', $this->getValue( 'name' ) );
			WPage::setMetaTag( 'og:image', WGlobals::get( 'imageURL' ) );
			WPage::setMetaTag( 'og:type', strtolower( $this->itemTypeInfoO->name ) );				WPage::setMetaTag( 'og:url', JOOBI_SITE . WPage::routeURL( 'controller=catalog&task=show&eid=' . $this->pid, JOOBI_SITE, 'home' ) );
		}

		$mediaType = WGlobals::get( 'media-type-show-view' );
		$this->setValue( 'previewType', ucfirst($mediaType) );

				WPage::addCSSFile( 'node/catalog/css/style.css' );


				$catalogShowproductC = WClass::get( 'catalog.showsocial' );
		if ( !$catalogShowproductC->shareDisplay( $this, $this->pid, $this->getValue( 'name' ), $this->pageParams, 'item', $this->getValue( 'hits' ) ) ) return false;

		return true;

	}






	private function _createItemMap() {

		if ( empty($this->pageParams->showMap) ) {
			$this->removeElements( $this->_modelName . '_page_item_map' );
			$this->removeElements( $this->_modelName . '_page_item_' . $this->_modelName . '_location' );
			return false;
		} else {
						WGlobals::set( 'mapWidth', ( empty($this->pageParams->showMapWidth) ? 600 : $this->pageParams->showMapWidth ) );
			WGlobals::set( 'mapHeight', ( empty($this->pageParams->showMapHeight) ? 400 : $this->pageParams->showMapHeight ) );
			WGlobals::set( 'mapShowStreetView', ( empty($this->pageParams->showMapStreet) ? false : $this->pageParams->showMapStreet ) );
			WGlobals::set( 'mapStreetHeight', 300 );
		}
	}










	protected function _showRelatedItems() {



		$nbRelated = $this->getValue( 'relnum' );

		if ( empty( $nbRelated ) ) return false;



		$relatedPID = WGlobals::getEID();

		if ( empty($relatedPID) ) return false;



		$itemPrmsO = WGlobals::get( 'itemPageRelated', null, 'global' );


		
		if ( !$itemPrmsO->prditems ) return false;



		WGlobals::set( 'itmRelatedtitle', $itemPrmsO->prdtitle, 'global' );



		if ( !empty($itemPrmsO->prdtitle) ) $this->setValue( 'itemRelatedTitle', WText::t('1298350960NBLZ') );

		$this->setValue( 'itemRelated', $this->_catalogItemPageC->showRelatedItems( $itemPrmsO, $relatedPID, $this->firstFormName ) );

		$this->setValue( 'itemsRelatedPagination', $this->_catalogItemPageC->paginationRelatedItems() );



	}




	











	protected function _communProcessing() {


				if ( WPref::load( 'PCATALOG_NODE_NEWITEMUSE' ) ) {
			$createdDateAdjusted = $this->getValue('created') + PCATALOG_NODE_NEWPERIOD * 86400;
			if ( $createdDateAdjusted >= time() ) {
				$this->setValue( 'newItem', true );
				$this->setValue( 'newItemText', WText::t('1206732361LXFD') );
				WPage::addCSSFile( 'node/catalog/css/badge.css' );
			}		}

				if ( WPref::load( 'PCATALOG_NODE_FEATUREDUSE' ) ) {
			$this->setValue( 'featuredText', WText::t('1405139915GGBP') );
			WPage::addCSSFile( 'node/catalog/css/badge.css' );
		} else {
						$this->setValue( 'featured', false );
		}



		
		$this->_processList();



		
		if ( PCATALOG_NODE_EDITITEMCATALOG ) {



			$showEditDeleteButton = false;

			
			$roleHelper = WRole::get();

			$showEditDeleteButton = WRole::hasRole( 'storemanager' );





			if ( !$showEditDeleteButton ) {

				
				
				$roleHelper = WRole::get();

				if ( WRole::hasRole( 'vendor' ) ) {

					$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

					$uid = WUser::get('uid');

					$vendid = $vendorHelperC->getVendorID( $uid );

				}


				if ( !empty($vendid) ) {

					$ItemVendID = $this->getValue( 'vendid' );

					
					if ( $ItemVendID == $vendid ) {

						$showEditDeleteButton = true;

					}
				}
			}


			if ( $showEditDeleteButton ) {

				$itemDesignationT = WType::get( 'item.designation' );
				$designation = $itemDesignationT->getName( $this->itemTypeInfoO->type );


				$editArea = WPref::load( 'PCATALOG_NODE_EDITITEMLOCATION' );

				$this->setValue( 'editButton', WText::t('1337879810ASDU') );

				$this->setValue( 'deleteButton', WText::t('1206732372QTKL') );

				$extraSpace = ( $editArea != 'both' ) ? '&space=' . $editArea : '';




					$myLink = WPage::routeURL( 'controller=' . $designation . '&task=edit&eid=' . $this->pid, 'home', 'popup', false, false, null, true );




				$this->setValue( 'editButtonLink', $myLink );



				$myLink = WPage::routeURL( 'controller=item&task=deleteall&eid=' . $this->pid . '&returnback=true' . $extraSpace, 'home' );	
				$this->setValue( 'deleteButtonLink', $myLink );



			}


		}


	}
















	protected function _processList() {



		
		if ( empty( $this->pid ) ) return false;



		$wishlistGetcountC = WClass::get( 'wishlist.getcount' );

		$typeA = $wishlistGetcountC->countItemTypes( $this->pid, 'item' );



		foreach( $typeA as $name => $value ) {

			$this->setValue( $name, $value );

		}


		return true;



	}












	protected function customItemType() {

	}
}