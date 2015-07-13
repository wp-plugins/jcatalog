<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_edit_item_view extends Output_Forms_class {
protected $_modelName = null;


	protected $_vendid = 0;



	protected $_prodtypid = 0;











protected function prepareView() {

	
	
	
	$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );



	
	if ( $integrate && WExtension::exist( 'subscription.node' ) ) {

		$subscriptionCatalogrestrictionC = WClass::get( 'subscription.catalogrestriction' );

		$subscriptionCatalogrestrictionC->itemCreate( true );

	}
	


	
	$this->_modelName = $this->_model->getModelNamekey();



	if ( WRoles::isNotAdmin( 'storemanager' ) ) {

		
		WPref::load( 'PITEM_NODE_VENDORLAYOUTALLOW' );

		if ( !PITEM_NODE_VENDORLAYOUTALLOW ) $this->removeElements( $this->_modelName . '_edit_item_layout_tab' );

		if ( !PITEM_NODE_VENDORPICTURESALLOW ) $this->removeElements( array( $this->_modelName . '_edit_item_pictures_tab' ) );	


		
		if ( PITEM_NODE_AUTOCREATEPREVIEW ) $this->removeElements( array( $this->_modelName . '_edit_item_preview_upload' ) );



		if ( !PITEM_NODE_VENDORATTRIBUTESALLOW ) $this->removeElements( array( $this->_modelName . '_edit_item_attributes_tab' ) );

		if ( !PITEM_NODE_VENDORPUBLISHINGALLOW ) {

			$this->removeElements( $this->_modelName . '_edit_item_publish', false );

			$this->removeElements( $this->_modelName . '_edit_item_publishing_tab' );

		} else {

			$this->removeElements( $this->_modelName . '_edit_item_publish_general', false );

		}


		if ( ! PITEM_NODE_VENDORLOCATIONALLOW || ! PITEM_NODE_MAPSERVICES ) $this->removeElements( array( $this->_modelName . '_edit_item_location_tab' ) );

		if ( PITEM_NODE_DWLURLONLY ) {
			WGlobals::set( 'mediaUploadOnlyURL_' . $this->_modelName . '_edit_item_media_upload', true, 'global' );			}		if ( PITEM_NODE_PRWURLONLY ) {
			WGlobals::set( 'mediaUploadOnlyURL_' . $this->_modelName . '_edit_item_preview_upload', true, 'global' );			}

	} else {

		if ( ! PITEM_NODE_MAPSERVICES ) $this->removeElements( array( $this->_modelName . '_edit_item_location_tab' ) );

		$this->removeElements( $this->_modelName . '_edit_item_publish_general', false );

	}

		WGlobals::set( 'mediaUploadFileType_' . $this->_modelName . '_edit_item_preview_upload', 'files_type_preview', 'global' );



	
	
	$this->_prodtypid = $this->getValue( 'prodtypid', $this->_modelName );


	if ( !empty( $this->_prodtypid ) ) {

		$productTypeC = WClass::get( 'item.type' );

		$type = $productTypeC->loadData( $this->_prodtypid, 'type' );

	} else {

		$type = null;

	}




	
	WGlobals::set( 'itemtype', $type, 'global' );



	
	$this->_vendid = $this->getValue( 'vendid', $this->_modelName );

	WGlobals::set( 'vendorid', $this->_vendid, 'global' );



	$task = WGlobals::get( 'task' );

	$eid = WGlobals::getEID();	


	
	$this->_definePolicies();



	
	$this->_defineSyndicateResellers();





	
	WGlobals::set( 'maxFileUpload-' . $this->_modelName . '_edit_item_image_upload', PITEM_NODE_IMGMAXSIZE, 'global' );

	WGlobals::set( 'maxFileUpload-' . $this->_modelName . '_edit_item_media_upload', PITEM_NODE_DWLDMAXSIZE, 'global' );

	WGlobals::set( 'maxFileUpload-' . $this->_modelName . '_edit_item_preview_upload', PITEM_NODE_PRWMAXSIZE, 'global' );	

			$filesFancyuploadC = WClass::get( 'files.fancyupload' );
	if ( $filesFancyuploadC->check() ) {
		$this->removeElements( $this->_modelName . '_edit_item_image_button' );
	}

	$imagenbmax = WPref::load( 'PITEM_NODE_IMAGENBMAX' );

	if ( !empty($imagenbmax) ) {

		$itemC = WClass::get('item.helper');

		$count = $itemC->countImages( $eid );

		if ( $count >= $imagenbmax ) {

			$this->removeElements( array( $this->_modelName . '_edit_item_image_upload', $this->_modelName . '_edit_item_image_button' ) );

		}
	}



		if ( ! WPref::load( 'PITEM_NODE_PROMOMESSAGE' ) ) {
		$this->removeElements( array( $this->_modelName . '_edit_item_' . $this->_modelName . 'trans_promo' ) );
	}


	
	$this->_createItemMap();


	if ( WRoles::isAdmin( 'storemanager' ) ) return true;





	





	$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );

	if ( $integrate ) {



		
		if ( WExtension::exist( 'subscription.node' ) ) {





			$subscriptionCheckC = WObject::get( 'subscription.check' );
			$subscriptionCheckC->dontDeductCredits();
			$paramsO = new stdClass;
			$paramsO->strictly = false;
			$paramsO->pid = $eid;


			$subscriptionO = $subscriptionCheckC->restriction( 'item_image_upload', $eid, $paramsO );



			if ( !$subscriptionCheckC->getStatus( false ) ) {

				$this->removeElements( $this->_modelName . '_edit_item_image_upload', $this->_modelName . '_edit_item_image_button' );					$link = WPage::link( 'controller=subscription' );

				$SUBSCRIBE_LINK = '<a href="'.  $link .'">' . WText::t('1329161820RPTN') .'</a>';

				$this->userN('1337805430DVTX',array('$SUBSCRIBE_LINK'=>$SUBSCRIBE_LINK));

			}


		}


	}




	









	return true;



}












	private function _createItemMap() {



		
		WGlobals::set( 'mapShowStreetView', false );

		$location = $this->getValue('location');



		$mapServices = WPref::load( 'PITEM_NODE_MAPSERVICES' );

		if ( empty($mapServices) ) {

			$location = '';

			$this->removeElements( array( $this->_modelName . '_edit_item_location_tab', $this->_modelName . '_edit_item_' . $this->_modelName . '_location') );

		}


		if ( empty($location) ) {	
			$this->removeElements( $this->_modelName . '_edit_item_' . $this->_modelName . '_map' );

		}


	}












	private function _definePolicies() {



		
		if ( WRoles::isAdmin( 'storemanager' ) ) return true;


		

		$allowPolicies = WPref::load( 'PVENDORS_NODE_ALLOWTERMS' );

		if ( $allowPolicies == 12 || $allowPolicies == 1 ) $allowPolicies = 1;

		elseif ( $allowPolicies == 5 ) {

			
			$itemTypeC = WClass::get('item.type');

			$itemTypeInfoO = $itemTypeC->loadData( $this->_prodtypid );

			
			if ( empty($itemTypeInfoO->allowpolicies) ) {

				$allowPolicies = 0;

			} elseif ( $itemTypeInfoO->allowpolicies==23 ) {

				$vendorHelperC = WClass::get( 'vendor.helper' );

				$allowPolicies = $vendorHelperC->getVendor( $this->_vendid, 'allowpolicies' );

			} elseif ( $itemTypeInfoO->allowpolicies==12 || $itemTypeInfoO->allowpolicies==1 ) {

				$allowPolicies = 1;

			} else $allowPolicies = 0;

		} elseif ( $allowPolicies == 23 && $this->_vendid ) {

			
			$vendorHelperC = WClass::get( 'vendor.helper' );

			$allowPolicies = $vendorHelperC->getVendor( $this->_vendid, 'allowpolicies' );

		} else $allowPolicies = 0;



		if ( empty($allowPolicies) ) $this->removeElements( array( $this->_modelName . '_edit_item_policies_fieldset' ) );

		
		





















	}












	private function _defineSyndicateResellers() {



		$vendorsExits = WExtension::exist( 'vendors.node' );






		
		$allowSyndicate = WPref::load( 'PCATALOG_NODE_ALLOWSYNDICATION' );

		if ( $allowSyndicate == 12 ) $allowSyndicate = 1;

		elseif ( $allowSyndicate == 5 ) {

			
			$itemTypeC = WClass::get('item.type');

			$itemTypeInfoO = $itemTypeC->loadData( $this->_prodtypid );

			
			if ( empty($itemTypeInfoO->allowsyndication) ) {

				$allowSyndicate = 0;

			} elseif ( $itemTypeInfoO->allowsyndication==23 ) {

				$vendorHelperC = WClass::get( 'vendor.helper' );

				$allowSyndicate = $vendorHelperC->getVendor( $this->_vendid, 'allowsyndication' );

			} elseif ( $itemTypeInfoO->allowsyndication==12 ) {

				$allowSyndicate = 1;

			} else $allowSyndicate = 0;

		} elseif ( $allowSyndicate == 23 && $this->_vendid ) {

			
			$vendorHelperC = WClass::get( 'vendor.helper' );

			$allowSyndicate = $vendorHelperC->getVendor( $this->_vendid, 'allowsyndication' );

		} else $allowSyndicate = 0;



		$allowResellers = PCATALOG_NODE_ALLOWRESELLERS;

		if ( $allowResellers == 12 ) $allowResellers = 1;

		elseif ( $allowResellers == 5 ) {

			
			$itemTypeC = WClass::get('item.type');

			$itemTypeInfoO = $itemTypeC->loadData( $this->_prodtypid );

			
			if ( empty($itemTypeInfoO->allowresellers) ) {

				$allowResellers = 0;

			} elseif ( $itemTypeInfoO->allowresellers==23 ) {

				$vendorHelperC = WClass::get( 'vendor.helper' );

				$allowResellers = $vendorHelperC->getVendor( $this->_vendid, 'allowresellers' );

			} elseif ( $itemTypeInfoO->allowresellers==12 ) {

				$allowResellers = 1;

			} else $allowResellers = 0;



		} elseif ( $allowResellers == 23 && $this->_vendid ) {

			
			$vendorHelperC = WClass::get( 'vendor.helper' );

			$allowResellers = $vendorHelperC->getVendor( $this->_vendid, 'allowresellers' );

		} else $allowResellers = 0;





		if ( empty($allowSyndicate) || !$vendorsExits ) {

			$this->removeElements( array( $this->_modelName . '_edit_item_allowsyndication' ) );

		}


		if ( empty($allowResellers) || !$vendorsExits ) {

			$this->removeElements( array( $this->_modelName . '_edit_item_allowresellers', $this->_modelName . '_edit_item_reseller_discount', $this->_modelName . '_edit_item_reselller_markup' ) );

			if ( empty($allowSyndicate) || !$vendorsExits ) $this->removeElements( array( $this->_modelName . '_edit_item_syndicate_fieldset' ) );

		}




	}
}