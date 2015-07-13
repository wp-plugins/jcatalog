<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Node_model extends WModel {


	public $_fileInfo = array();



	protected $_preferences = array();	










	function __construct() {

















		$previewid= new stdClass;

		$previewid->fileType = 'medias';

		$previewid->folder = 'media';

		$previewid->path = 'products' . DS .'preview';

		$previewid->secure = false;

		$previewid->format = WPref::load( 'PITEM_NODE_PRWFORMAT' );

		$previewid->maxSize = WPref::load( 'PITEM_NODE_PRWMAXSIZE' ) * 1028;



		
		$previewid->thumbnail = 1;	
		$previewid->maxHeight = WPref::load( 'PITEM_NODE_MAXPH' );

		$previewid->maxWidth = WPref::load( 'PITEM_NODE_MAXPW' );

		$previewid->maxTHeight = array( WPref::load( 'PITEM_NODE_SMALLIH' ) );

		$previewid->maxTWidth = array( WPref::load( 'PITEM_NODE_SMALLIW' ) );

		$previewid->watermark = WPref::load( 'PITEM_NODE_WATERMARKITEM' );

		$previewid->storage = WPref::load( 'PITEM_NODE_FILES_METHOD_PREVIEW' );





		$this->_fileInfo = array();


		$this->_fileInfo['previewid'] = $previewid;



		
		parent::__construct( $this->getItemType(), 'node', 'pid' );



	}














	function validate() {



		
		$this->validateDate( 'availablestart' );

		$this->validateDate( 'availableend' );

		$this->validateDate( 'publishstart' );

		$this->validateDate( 'publishend' );



		
		if ( empty($this->alias) ) {

			$name = $this->getChild( $this->getItemType() . 'trans', 'name' );

			if ( !empty($name) ) $this->alias = $name;

		}


		
		if ( empty($this->uid) ) $this->uid = WUser::get( 'uid' );



		
		
		$wfiles = $this->getChild( $this->getItemType() . '.downloads' ,'wfiles' );

		if ( !empty($wfiles) ) {

			$fileVAlue = array_shift( $wfiles['filid'] );

			if ( !empty($fileVAlue->name) && $fileVAlue->error == 0 ) {

				$this->filid = 1;

			}


		}


				$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );
				if ( $integrate && WExtension::exist( 'subscription.node' ) ) {

			$images = $this->getChild( $this->getModelNamekey() . '.images', 'wfiles' );
			if ( !empty($images['filid']) ) {
				$subscriptionCatalogrestrictionC = WClass::get( 'subscription.catalogrestriction' );
				$status = $subscriptionCatalogrestrictionC->imagesUpload( $this->pid, $images['filid'] );
				if ( ! $status ) {
					$this->setChild( $this->getModelNamekey() . '.images', 'wfiles', array( 'filid' => $images['filid'] ) );
				}			}
		}
		return true;



	}











	function editValidate() {


		
		if ( isset($this->publish) && empty( $this->publish ) ) {

			$message = WMessage::get();

			$message->userN('1319164500LUJI');

		}















			
			WPref::load( 'PITEM_NODE_VENDORLAYOUTALLOW' );

			if ( !PITEM_NODE_VENDORLAYOUTALLOW
			|| !PITEM_NODE_VENDORATTRIBUTESALLOW
			|| !PITEM_NODE_VENDORPUBLISHINGALLOW ) {
				$this->_loadCurrentParameters();
			}



		



		$this->_checkLocation( false );



		

 		$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );



 		
 		if ( $integrate && WExtension::exist( 'subscription.node' ) ) {



 			$subscriptionCatalogrestrictionC = WClass::get( 'subscription.catalogrestriction' );



 			
 			if(  !$this->_dbPublishValue() && isset($this->publish) && $this->publish ) $subscriptionCatalogrestrictionC->itemPublished();



 			
 			if(  $this->_dbPublishValue() && isset($this->publish) && !$this->publish ) $subscriptionCatalogrestrictionC->itemUnPublished();

 		}


 		return true;



	}














function addValidate() {



	
	if ( empty($this->vendid) ) {

		$uid = WUser::get( 'uid' );

		$vendorHelperC = WClass::get('vendor.helper' );

		if ( !empty($vendorHelperC) ) $this->vendid = $vendorHelperC->getVendorID( $uid, true );

	}


	
	if ( !empty($this->namekey) ) {



		$thisbis = WModel::get('item');

		$thisbis->whereE('namekey', $this->namekey);

		$results = $thisbis->load('o','pid');



		if ( !empty ($results) ) {

			if (!isset($this->pid) || $results->pid != $this->pid) {

				$OLDNAME = $this->namekey;

				$this->namekey .= $this->genNamekey();



				$NEWNAME = $this->namekey;

				$this->userN('1235983282HERN',array('$OLDNAME'=>$OLDNAME,'$NEWNAME'=>$NEWNAME));

			}
		}


	} else {



		if ( !empty( $this->prodtypid ) ) {

			
			$itemTypeC = WClass::get( 'item.type' );

			$productType = $itemTypeC->loadData( $this->prodtypid, 'type' );



		} else {

			$productType = $this->getItemType();

		}


		$prefix = $productType . '-';

		$this->namekey = $this->genNamekey( '', 149, $prefix );

		$UNIQUENAME = $this->namekey;

		$this->userN('1310010296RFYO',array('$UNIQUENAME'=>$UNIQUENAME));

	}


	
	if ( empty( $this->prodtypid ) ) {



		$productTypeM = WModel::get( 'item.type' );

		$productTypeM->whereE( 'namekey', $this->getItemType() );

		$productTypeM->whereE( 'publish', 1 );


		$productTypeM->orderBy( 'ordering', 'ASC' );

		$productTypeM->orderBy( 'prodtypid', 'ASC' );

		$this->prodtypid = $productTypeM->load('lr', 'prodtypid' );



	}

	

		$processO = new stdClass;

		$processO->related = true;

		$processO->bundle = false;

		$this->setDefaultPreferences( $processO );

		$this->_processDefaultPreferences();






	
	
	if ( WRoles::isAdmin( 'storemanager' ) ) {

		$this->blocked = 0;

	} else {

		
		$uid = WUser::get( 'uid' );

		$roleHelper = WRole::get();

		$superRole = WRole::hasRole( 'storemanager' );

		
		if ( $superRole )  {

			$this->blocked = 0;

		} else {

			$this->blocked = ( ! WPref::load( 'PVENDORS_NODE_PRODNOBLOCK' ) ) ? 1 : 0;

		}
	}


	
	
	if ( !isset( $this->publish ) ) {
		$this->publish = PITEM_NODE_DEFAULTPUBLISH;

	}




	$this->_checkLocation( true );



	
	$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );



	
	if ( $integrate && WExtension::exist( 'subscription.node' ) ) {

		$subscriptionCatalogrestrictionC = WClass::get( 'subscription.catalogrestriction' );

		$subscriptionCatalogrestrictionC->itemCreate( false );

	}
	


	
	if ( isset($this->publish) && $this->publish ) {

		$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );



		
		if ( $integrate && WExtension::exist( 'subscription.node' ) ) {

			$subscriptionCatalogrestrictionC = WClass::get( 'subscription.catalogrestriction' );

			$subscriptionCatalogrestrictionC->itemPublished();

		}
	}


	return true;



}












	function addExtra() {

		


		
		$vendorsApprovalC = WClass::get( 'vendors.approval', null, 'class', false );

		if ( empty($vendorsApprovalC) ) {

			$this->blocked = 0;

			return true;

		}


		
		$this->blocked = $vendorsApprovalC->checkApproval( $this, $this->getItemType(), $this->pid );



		return true;

	}














	function extra() {



		
		$cache = WCache::get();

		$cache->resetCache( 'Menus' );



		$categoryID = $this->getX( 'categoryid' );

		if ( isset($categoryID) ) {

			
			
			$productCategoryM = WModel::get('item.categoryitem');

			$productCategoryM->whereE( 'pid', $this->pid );

			$productCategoryM->whereE( 'catid', $categoryID );

			$productCategoryM->orderBy( 'premium', 'DESC' );

			$categoryOrdering = $productCategoryM->load('o', array('pid','catid','premium') );



			if ( !empty($categoryOrdering) ) {	
				
				if ( empty($categoryOrdering->premium) ) {

					
					$productCategoryM->whereE( 'pid', $this->pid );

					$productCategoryM->setVal( 'premium', '0' );

					$productCategoryM->update();



					
					$productCategoryM->whereE( 'pid', $this->pid );

					$productCategoryM->whereE( 'catid', $categoryID );

					$productCategoryM->setVal( 'premium', 1 );

					$productCategoryM->update();

				}


			} else {	
				
				
				$productCategoryM->whereE( 'pid', $this->pid );

				$productCategoryM->setVal( 'premium', '0' );

				$productCategoryM->update();



				
				$productCategoryM->setVal( 'premium', 1 );

				$productCategoryM->setVal( 'pid', $this->pid );

				$productCategoryM->setVal( 'catid', $categoryID );

				$productCategoryM->insert();



				
				$productM = WModel::get('item');

				$productM->whereE( 'pid', $this->pid );

				$productM->updatePlus( 'numcat' );

				$productM->update();


				if ( isset($this->numcat) ) $this->numcat++;



				





				$categoryC = WClass::get( 'item.category' );
				$categoryC->updateNumberItems( $categoryID, 1 );



			}


		}


		
		$this->_setImagePremium();







		if ( WPref::load('PITEM_NODE_AUTOCREATEPREVIEW') ) {

			$this->_duplicateAttachementToPreview();

		}




		
		$usePormotion = WPref::load( 'PITEM_NODE_PROMOTIONUSE' );

		if ($usePormotion) $this->_processedPromotion();





		
		$itemWallC = WClass::get( 'item.wall' );

		if ( $itemWallC->available() ) {



			$extraLink = '';

			if ( WExtension::exist( 'affiliate.node') ) {

				$affiliateHelperC = WClass::get( 'affiliate.helper', null, 'class', false );

				$extraLink = $affiliateHelperC->addAffilateToLink();

			}


			$post = new stdClass;

			$pageID = APIPage::cmsGetItemId();

			$link = WPage::routeURL('controller=catalog&task=show&eid='.$this->pid . $extraLink, 'home', false, false, $pageID );



			$ITEM_NAME = '<a href="'. $link .'">'.$this->getChild( $this->getItemType() . 'trans' ,'name' ).'</a>';



			if ( $this->_new ) {

				$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338591626DUWE'));
				$post->titleTR = WText::translateNone( '{tag:actor} created a new item '.$ITEM_NAME.'.' );
				$post->titleVAR = '$ITEM_NAME';

				$post->callingFunction = 'wallitemnew';

			} else {

				$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338591626DUWF'));
				$post->titleTR =  WText::translateNone( '{tag:actor} updated item '.$ITEM_NAME.'{multiple} {count} times{/multiple}.' );
				$post->titleVAR = '$ITEM_NAME';

				$post->callingFunction = 'wallitemedit';

			}


			$content = '';



			
			$itemHelperC = WClass::get( 'item.helper' );

			
			$imageFile = $itemHelperC->getDefaultImageID( $this->pid );

			if ( !empty($imageFile) ) {

				$this->element = new stdClass;

				$this->element->imageWidth = 90;

				$this->element->imageHeight = 90;

				
				$filesMediaC = WClass::get( 'files.media' );

				$content .= $filesMediaC->renderHTML( $imageFile, $this->element );

			}


			$intriduction = $this->getChild( $this->getItemType() . 'trans' ,'introduction' );

			if ( !empty($intriduction) ) {

				$emailHelperC = WClass::get( 'email.conversion' );

				$content .= $emailHelperC->smartHTMLSize( $intriduction, 150, false, false, false, true );

			} else {

				$description = $this->getChild( $this->getItemType() . 'trans' ,'description' );

				if ( !empty($description) ) {

					$emailHelperC = WClass::get( 'email.conversion' );

					$content .= $emailHelperC->smartHTMLSize( $description, 150, false, false, false, true );

				}
			}
			$post->eid = $this->pid;

			$post->content = $content;

			$post->model = 'item';
			$post->node = 'item.node';
			$post->link = $link;


			$itemWallC->postWall( $post );



		}




		return true;



	}














	function deleteValidate($pid=0) {

		if ( empty($pid) ) return false;



		
		$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );



		
		if ( $integrate && WExtension::exist( 'subscription.node' ) ) {



			$subscriptionCatalogrestrictionC = WClass::get( 'subscription.catalogrestriction' );



			if($this->_dbPublishValue($pid)) $subscriptionCatalogrestrictionC->itemUnPublished();



		}
		


		
		$categoryM = WModel::get( 'item.category' );


		$categoryM->makeLJ( 'item.categoryitem', 'catid' );

		$categoryM->whereE( 'pid', $pid, 1 );


		$catidA = $categoryM->load( 'lra', 'catid' );

		$categoryC = WClass::get( 'item.category' );
		$categoryC->updateNumberItems( $catidA, -1 );




		return parent::deleteValidate();



	}














	public function copyValidate() {



		
		$itemLoadC = WClass::get( 'item.type' );

		$productDegination = $itemLoadC->loadTypeBasedOnPID( $this->pid, 'type' );

		$productTypeT = WType::get( 'item.designation' );

		$designation = $productTypeT->getName( $productDegination );

		$name = WModel::getElementData( 'item', $this->pid, 'name' );

				$this->setChild( $designation . 'trans' ,'name', $name . ' ' . WText::t('1373216460QKQF') );

		$this->returnId();



		$this->_copiedPID = $this->pid;

		return true;

	}












	public function copyExtra() {



		
		if ( !empty( $this->_copiedPID ) ) {

			
			$itemCategoryitemM = WModel::get( 'item.categoryitem' );

			$itemCategoryitemM->whereE( 'pid', $this->_copiedPID );

			$allCategoriesA = $itemCategoryitemM->load( 'ol' );



			if ( !empty($allCategoriesA) ) {

				foreach( $allCategoriesA as $oneCat ) {

					$itemCategoryitemM->setVal( 'pid', $this->pid );

					$itemCategoryitemM->setVal( 'catid', $oneCat->catid );

					$itemCategoryitemM->setVal( 'ordering', $oneCat->ordering );

					$itemCategoryitemM->setVal( 'used', $oneCat->used );

					$itemCategoryitemM->setVal( 'premium', $oneCat->premium );

					$itemCategoryitemM->insertIgnore();

				}
			}


			
			$itemRelatedM = WModel::get( 'item.related' );

			$itemRelatedM->whereE( 'pid', $this->_copiedPID );

			$allRelatedA = $itemRelatedM->load( 'ol' );



			if ( !empty($allRelatedA) ) {

				foreach( $allRelatedA as $oneRel ) {

					$itemRelatedM->setVal( 'pid', $this->pid );

					$itemRelatedM->setVal( 'relpid', $oneRel->relpid );

					$itemRelatedM->setVal( 'ordering', $oneRel->ordering );

					$itemRelatedM->insertIgnore();

				}
			}


		}


		return true;

	}
















	public function getPossibleTypes() {



		$allFields = WPref::load( 'PDESIGN_NODE_FIELDALLTYPE' );





		$productTypeM = WModel::get( 'item.type' );

		$productTypeM->makeLJ( 'item.typetrans' );

		$productTypeM->whereLanguage();

		$productTypeM->select( 'name', 1 );


		if ( !$allFields ) {

			
			$namekey = $this->getModelNamekey();



			$productTypeT = WType::get( 'item.designation' );

			$designation = $productTypeT->getValue( $namekey, false );



			$productTypeM->whereE( 'type', $designation );



		}


		$productTypeM->whereE( 'publish', 1 );

		$resultA = $productTypeM->load( 'ol', 'prodtypid' );

		$count = count( $resultA );

		if ( $count < 2 ) return false;



		$typeA = array();

		foreach( $resultA as $oneType ) {

			$typeA[$oneType->prodtypid] = $oneType->name;

		}


		return $typeA;

	}












	public function getItemTypeColumn() {

		return 'prodtypid';

	}
















	public function isOwner() {	


		if ( empty($this->pid) ) return false;



		$vendorHelperC = WClass::get( 'vendor.helper' );

		$vendid = $vendorHelperC->getVendorID();



		$itemM = WModel::get( $this->getModelID() );






		if ( is_array($this->pid) ) $itemM->whereIn( $pkey, $this->pid );

		else $itemM->whereE( $pkey, $this->pid );

		$itemM->whereE( 'vendid', $vendid );



		$task = WGlobals::get( 'task' );

		$columnExists = false;

		if ( $task == 'copyall' ) {

			$columnExists = $itemM->columnExists( 'share' );

		}


		if ( $columnExists ) {

			$itemM->openBracket();

			$itemM->whereE( 'vendid', $vendid );

			$itemM->operator( 'OR' );

			$itemM->whereE( 'share', 1 );

			$itemM->closeBracket();

		} else {

			$itemM->whereE( 'vendid', $vendid );

		}


		return $itemM->exist();



	}


















	protected function getItemType() {



		$defaultItemType = $this->getModelNamekey();



		if ( empty($defaultItemType) ) {

			static $defaultItemType = array();

			$parentClass = get_parent_class( $this );

			if ( substr( $parentClass, -6 ) == '_model' ) $className = $parentClass;

			else $className = get_class( $this );



			
			if (empty($defaultItemType[$className]) ) {

				$nameExpA = explode( '_', $className );

				$defaultItemType[$className] = strtolower( $nameExpA[0] );

			}


			return $defaultItemType[$className];



		} else {

			return $defaultItemType;

		}


	}


















	protected function setDefaultPreferences($processO) {



		
		$generalPrefA = array('pageprdshowimage','pageprdshowdefimg','pageprdshowpreview','pageprdshowintro','pageprdshowdesc',

		'pageprdshowrating','pageprdshowreview','pageprdallowreview','pageprdvendor','pageprdvendorating','pageprdaskquestion',

		'termsshowlicense','termsshowrefund','termsrefundallowed','termsshowrefundperiod','requiretermsatcheckout',

		'pageprdshowviews','pageprdshowlike','pageprdshowtweet','pageprdshowbuzz',

		'pageprdprice','pageprdquantity','pageprdstock','pageprdcartbtn',

		'pageprdshowfavorite','pageprdshowwatch','pageprdshowwish','pageprdshowlikedislike','pageprdshowsharewall','pageprdshowprint','pageprdshowemail',

		'pageprdshowmap', 'pageprdshowmapstreet', 'prdavailsort'

		);



		foreach( $generalPrefA as $onePref ) {

			$this->_preferences[$onePref] = 5;	
		}


		
		$this->_preferences['termslicense'] = 'type';

		$this->_preferences['termsrefund'] = 'type';



		$itemSectionPref = array( 'availsort',	
		'items','title','type','sorting','display','nbdisplay',

		'layout','layoutcol','layoutname','showname','showintro','showdesc','climit','nlimit','showpreview',

		'showprice','showfree','addcart','showrating','showvendor','showquestion','share',

		'showimage','imagewidth','imageheight','showcolumn','readmore' );	





		
		$itemTypeC = WClass::get( 'item.type' );

		$itemTypeInfoO = $itemTypeC->loadData( $this->prodtypid );



		if ( !empty($processO->related) ) {



			
			$this->_preferences['prdgeneral'] = 5;
			
			foreach( $itemSectionPref as $sectionElm ) {

				$name = 'prd'.$sectionElm;

				if ( !empty($itemTypeInfoO->$name) ) {

					$this->_preferences[$name] = $itemTypeInfoO->$name;

				} else {

					
					$this->_preferences[$name] = WPref::load( 'PCATALOG_NODE_PRD' . strtoupper($sectionElm) );


				}
			}
		}


		
		if ( !empty($processO->bundle) ) {

			$this->_preferences['bdlgeneral'] = 5;

			foreach( $itemSectionPref as $sectionElm ) {

				$name = 'bdl'.$sectionElm;

				if ( !empty($itemTypeInfoO->$name) ) {

					$this->_preferences[$name] = $itemTypeInfoO->$name;

				} else {

					

					$this->_preferences[$name] = WPref::load( 'PCATALOG_NODE_BDL' . strtoupper($sectionElm) );

				}
			}
		}


	}












	private function _processedPromotion() {



		$promotionA = $this->getX( 'promotion' );


		if ( null === $promotionA ) return true;



		$itemFeatureditemM = WModel::get( 'item.featureditem' );


		
		if ( empty($promotionA) ) {

			$itemFeatureditemM->whereE( 'pid', $this->pid );

			$itemFeatureditemM->delete();

		}


		
		$itemFeatureditemM->whereE( 'pid', $this->pid );

		$existingA = $itemFeatureditemM->load( 'lra', 'ftdid' );

		
		$sortedExistingA = array();

		foreach( $existingA as $oneExist ) $sortedExistingA[$oneExist] = $oneExist;



		
		$itemPormotionC = WClass::get( 'item.promotion' );

		$newValue2InsertA = array();

		foreach( $promotionA as $newValues ) {

			if ( empty($sortedExistingA[$newValues]) ) {

				
				$newValue2InsertA[] = $newValues;

			}
		}
		if ( !empty($newValue2InsertA) ) $itemPormotionC->insertNewPromotion( $this->pid, $newValue2InsertA );



		$sortedNewOneA = array();

		foreach( $promotionA as $oneExist ) $sortedNewOneA[$oneExist] = $oneExist;

		
		foreach( $existingA as $newValues ) {

			if ( empty($sortedNewOneA[$newValues]) ) {

				
				$itemFeatureditemM->whereE( 'pid', $this->pid );

				$itemFeatureditemM->whereE( 'ftdid', $newValues );

				$itemFeatureditemM->delete();

			}
		}


		return true;



	}














	private function _checkLocation($newItem) {



		$PITEM_NODE_MAPSERVICES = PITEM_NODE_MAPSERVICES;

		if ( ! $PITEM_NODE_MAPSERVICES ) return false;



		if ( empty($this->location) && !empty($this->vendid) ) {

			if ( PITEM_NODE_ADRESSAUTO ) {

				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

				
				$this->location = $vendorHelperC->getVendorLocation( $this->vendid );

			} else {

				return false;

			}
		}


		if ( empty( $this->location ) ) return true;



		$location = trim( $this->location );

		if ( strlen($location) < 5 ) {

			$this->location = '';

			return false;

		}


		
		if ( !$newItem || ( empty($this->longitude) || $this->longitude==0 || empty($this->latitude) || $this->latitude==0 ) ) {



			if ( !empty($this->pid) ) {

				
				$itemM = WModel::get( 'item' );

				$itemM->whereE( 'pid', $this->pid );

				$existingAddress = $itemM->load( 'o', array( 'location' ) );

				if ( !empty($existingAddress) ) {

					
					if ( $existingAddress == $location ) return true;

				}
			}
		}


		
		$this->location = $location;
		$addressMapC = WClass::get( 'address.map' );

		$myCoordinatesO = $addressMapC->getCoordinates( $location );

		if ( empty($myCoordinatesO) ) return false;

		$this->longitude = $myCoordinatesO->longitude;

		$this->latitude = $myCoordinatesO->latitude;



		return true;

	}











	private function _loadCurrentParameters() {






		$params = WModel::getElementData( 'item', $this->pid, 'params' );


		$params = trim($params);

		if ( empty($params) ) return false;



		
		$myParamsA = explode( "\n", $params );

		if ( empty($myParamsA) ) return false;



		foreach( $myParamsA as $onePram ) {

			if ( empty($onePram ) ) continue;

			$position = strpos( $onePram, '=' );

			if ($position === false) continue;



			$propertyName = substr( $onePram, 0, $position );

			if ( !isset( $this->p[$propertyName] ) ) $this->p[$propertyName] = trim( substr( $onePram, $position+1 ) );

		}


	}











private function _setImagePremium() {

	static $productImgM = null;



	if ( empty($this->pid) ) return false;



	
	if ( !isset( $productImgM ) ) $productImgM = WModel::get( 'item.images' );

	$productImgM->whereE( 'pid', $this->pid );

	$productImgM->orderBy( 'premium', 'DESC' );

	$prodFilid = $productImgM->load( 'o', array('filid' , 'premium') );



	if ( !empty($prodFilid) ) {

		


		
		if ( empty($prodFilid->premium) ) {

			$productImgM->setVal( 'premium', 1 );

			$productImgM->whereE( 'filid', $prodFilid->filid );

			$productImgM->whereE( 'pid', $this->pid );

			$productImgM->update();

		}
	}


	return true;



}












	private function _processDefaultPreferences() {

		if ( !empty($this->_preferences) ) {

			foreach( $this->_preferences as $onePrefKey => $onePrefVal ) {

				if (!empty($onePrefVal) ) {

					if ( !isset($this->p[$onePrefKey]) ) $this->p[$onePrefKey] = $onePrefVal;

				}
			}
		}
	}














private function _duplicateAttachementToPreview() {



	
	if ( !empty($this->filid) ) {

		


		$sid = $this->getModelID();

		


		if ( empty($filesA['type'][$sid]['filid']) ) return false;



		$filesA = WGlobals::get( 'trucs', null, 'files' );

		$fileType = $filesA['type'][$sid]['filid'];



		
		if ( in_array( $fileType, array( 'image/jpeg', 'image/png', 'image/gif' ) ) ) {

			$filesHelperC = WClass::get( 'files.helper' );

			$newPreviewid = $filesHelperC->copyFile( $this->filid, $this->_fileInfo['previewid'] );



			
			if ( !empty($newPreviewid) ) {

				$updateModelM = WModel::get( 'item' );

				$updateModelM->whereE( 'pid', $this->pid );

				$updateModelM->setVal( 'previewid', $newPreviewid );

				$updateModelM->update();

			}
		}




	}




}
























private function _dbPublishValue($pid=0) {



	$itemM = WModel::get( 'item' );

	$itemM->select('publish');

	if(empty($pid)) $itemM->whereE( 'pid', $this->pid );

	else $itemM->whereE( 'pid', $pid );

	$dbPublishValue = $itemM->load('lr');



	return $dbPublishValue ;





}


















	public function secureTranslation($sid,$eid) {



		$translationC = WClass::get( 'item.translation', null, 'class', false );

		if ( empty($translationC) ) return false;



		
		if ( !$translationC->secureTranslation( $this, $sid, $eid ) ) return false;

		return true;



	}
}