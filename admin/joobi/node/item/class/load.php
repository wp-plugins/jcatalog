<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




 class Item_Load_class extends WClasses {

 	private $_paidItem = null;	 	private $_haveAuction = false; 	
 	private $unpublishedItem = false;	
 	private $_itemAccessC = null;
 	private $_myNewImageO = null;

 	private $_IamAvendor = false;
 	private $_vendid = null;

 	 	private $_advSeachableA = array();

 	private $_myLGID = null;

 	private static $_translationAsID = 0;

 	private static $_leftJoinCategroryOnlyOnce = true;

 	private static $_nb = 0;	










































	public function get(&$pO) {


				if ( empty( $pO ) ) return false;
		if ( WGlobals::checkCandy( 50, true ) ) $pO->showNoRating = true;

		self::$_translationAsID = 0;
		self::$_nb++;

		if ( !empty($pO->type) && is_numeric( $pO->type ) ) {
						$itemTypeC = WClass::get( 'item.type' );
			$itemDesignation = $itemTypeC->loadData( $pO->type, 'designation' );
		} else {
			$itemDesignation = ( !empty($pO->type) ? $pO->type : '' );
		}
				$this->_paidItem = ( empty( $itemDesignation ) || in_array( $itemDesignation, array( 'product', 'subscription', 'auction' ) ) ) ? true : false;

		$this->_myLGID = ( !empty($pO->lgid) ) ? $pO->lgid : null;


		if ( !empty($pO->countOnly) ) {
			$pO->totalCount = (string)$this->_countItems( $pO );
			return array();
		}
				if ( !empty( $pO->smartCategory ) && empty($pO->category) ) {
			$pO->category = WGlobals::get( 'catid' );
			if ( empty($pO->category) ) {
				$controller = WGlobals::get( 'controller');
				$task = WGlobals::get( 'task');
				if ( $controller=='catalog' && $task=='category' ) {
					$pO->category = WGlobals::get( 'eid' );
				}			}		}
		if ( !empty( $pO->getadvsearch ) ) {
									$catalogAdvFilterC = WClass::get( 'catalog.advfilter' );
			$this->_advSeachableA = $catalogAdvFilterC->getItemFitlers();
		}
				if ( !empty( $pO->pagination ) ) {
			if ( empty( $pO->yid ) ) {
				$limit = !empty( $pO->nb ) ? $pO->nb : 0;
				$limitstart = 0;

			} else {
				$yid = $pO->yid;
				$catID = !empty($pO->category) ? $pO->category : 0;
				$maxLimit = !empty($pO->nb) ? $pO->nb : 4;
				$limit = WGlobals::getUserState( "wiev-$yid-limit", 'limit'.$yid, $maxLimit, 'int' );
				$pageNumber = WGlobals::get( 'pagenb'.$yid, 0 );
				if ( !empty($pageNumber) ) {
					$maxItems = WGlobals::get( 'total'.$yid, 0 );
					if ( $maxItems > $pageNumber * $limit ) {
						$limitstart = ($pageNumber-1) * $limit;
					}				}
				if ( empty($limitstart) ) $limitstart = WGlobals::getUserState( "wiev-$yid-limitstart", 'limitstart'.$yid, 0, 'int' );
								$previousTOtal = WGlobals::getUserState( "wiev-$yid-total", 'total'.$yid, 0, 'int' );

				if ( $previousTOtal < 1 ) {
									$pO->totalCount = $this->_countItems( $pO );
					WGlobals::set( "wiev-$yid-total", $pO->totalCount, 'session' );
				} else {
					$pO->totalCount = $previousTOtal;
				}			}		} else {
			$limit = !empty( $pO->nb ) ? $pO->nb : 0;
			$limitstart = 0;
		}

				if ( !is_numeric($limit) ) $limit = 10;
		if ( $limit > 500 ) $limit = 50;


						
				if ( empty($pO->curid) ) {
			$pO->curid = WUser::get('curid');
		}
		$typeFromprodtypid = 0;
		if ( empty($limit) ) {
			$limit = ( !empty( $pO->layoutNbColumn ) && $pO->layoutNbColumn > 1 ) ? 3 * $pO->layoutNbColumn : 5;
			$limit = 5;
		}				if ( !empty($pO->type) ) {
			$productT = WType::get( 'item.designation' );
			$type = strtolower( $productT->getValue( strtolower($pO->type), false ) );
		} else {
			if ( !empty( $pO->prodtypid ) ) {
				if ( !isset($itemTypeC) ) $itemTypeC = WClass::get('item.type');
				if ( is_numeric($pO->prodtypid) ) $typeFromprodtypid = $itemTypeC->loadData( $pO->prodtypid, 'type' );
				else {
										$itemTypeT = WType::get( 'item.designation' );
					$typeFromprodtypid = strtolower( $itemTypeT->getValue( $pO->prodtypid, false ) );
				}			}			$type = 0;			}

		if ( !empty( $pO->relatedPID ) ) {				$productM = WModel::get( 'item.related' );
			$productM->makeLJ( 'item', 'relpid', 'pid', 0, 1 );
			$productM->whereE( 'pid', $pO->relatedPID, 0 );
			$productM->groupBy( 'relpid', 0 );
			$asIDProduct = 1;

									if ( WExtension::exist( 'auction.node' ) && $this->_paidItem && ( !empty( $pO->showBid ) || !empty($pO->showcountdown) ) && (empty($type) || $type== 11) && ( empty( $pO->prodtypid ) || (!empty($typeFromprodtypid) && $typeFromprodtypid ==11 ) ) ) {
				$this->_haveAuction = true;

				$productM->makeLJ( 'auction.bids', 'pid', 'pid', 1, 2 );					$productM->makeLJ( 'auction.infos', 'pid', 'pid', 1, 3 );					$productM->openBracket(1);
				$productM->where( 'publish', '!=', '-1', 2 );
				$productM->operator( 'OR' );
				$productM->isNULL( 'publish', true, 2 );
				$productM->closeBracket(1);
				$productM->select( 'currentbid', 2 );
				$productM->select( 'biddingend', 3 );
				$asBIdding = 3;
				$productM->select( 'startingbid', 3 );
				$productM->select( 'curid', 2, 'bidcurid' );
				$productM->groupBy( 'pid' );
				$asIDProduct = 1;
				$asID = 3;
				$asTransID = 3;

			}
		} elseif ( !empty( $pO->bundlePID ) ) {				$productM = WModel::get( 'item.bundle' );
			$productM->makeLJ( 'item', 'ref_pid', 'pid', 0, 1 );
			$productM->whereE( 'pid', $pO->bundlePID, 0 );
			$productM->groupBy( 'ref_pid', 0 );
			$asIDProduct = 1;
		} elseif ( !empty( $pO->sorting ) && $pO->sorting == 'justsold' ) {				$productM = WModel::get( 'order.items' );
			$productM->makeLJ( 'order', 'oid', 'oid', 0, 1 );
			$productM->makeLJ( 'item', 'pid', 'pid', 0, 2 );
			$productM->orderBy( 'modified', 'DESC', 1 );
			$productM->groupBy( 'pid', 0 );
			$productM->whereE( 'ostatusid', 20, 1 ); 			$pO->dontShowFree = true;				$asIDProduct = 2;
		} elseif ( !empty( $pO->sorting ) && ( $pO->sorting == 'recentlyviewed' || $pO->sorting == 'mytopviewed' ) ) {							$productM = WModel::get( 'item.viewed' );
			$productM->groupBy( 'pid' );
			$productM->makeLJ( 'item', 'pid', 'pid', 0, 1 );
			$logUID = WUser::get( 'uid' );
			if ( !empty( $logUID ) ) {
				$productM->whereE( 'uid', $logUID );
			} else {
				$productM->whereE( 'cookieid', WGlobals::getCookieUser() );
			}			$asIDProduct = 1;
		} elseif ( WExtension::exist( 'auction.node' ) 		&& $this->_paidItem
		&& ( !empty( $pO->showBid ) || !empty($pO->showcountdown) || ( !empty($pO->sorting) && 'endingsoon' == $pO->sorting ) )
		&& ( empty($type) || $type== 11 )
		&& ( empty( $pO->prodtypid ) || (!empty($typeFromprodtypid) && $typeFromprodtypid ==11 ) ) ) {

			$productM = WModel::get( 'auction' );
			$this->_haveAuction = true;
			$productM->makeLJ( 'auction.bids', 'pid', 'pid' );
			$productM->makeLJ( 'auction.infos', 'pid', 'pid', 0, 2 );				$productM->openBracket(1);
			$productM->where( 'publish', '!=', '-1', 1 );
			$productM->operator( 'OR' );
			$productM->isNULL( 'publish', true, 1 );
			$productM->closeBracket(1);

			$productM->select( 'currentbid', 1 );
			$productM->select( 'biddingend', 2 );
			$asBIdding = 2;
			$productM->select( 'startingbid', 2 );
			$productM->select( 'curid', 1, 'bidcurid');
			$productM->groupBy( 'pid' );
			$asIDProduct = 0;
			$asID = 2;
			$asTransID = 4;
		} else {
			$productM = WModel::get( 'item' );
			$productM->groupBy( 'pid', 0 );
			$asIDProduct = 0;
			$asID = 1;
		}
		if ( !isset($asID) ) $asID = $asIDProduct;


					$productM->select( 'price', $asIDProduct );
		$productM->select( 'curid', $asIDProduct );
		$productM->select( 'filid', $asIDProduct );
					$productM->select( 'rolid', $asIDProduct );

				$productM->select( array( 'location', 'longitude', 'latitude' ), $asIDProduct );

		$productM->select( array('pid', 'namekey', 'prodtypid','comment','stock', 'electronic', 'target','targettotal','vendid','featured', 'created', 'params', 'rolid_buy', 'modified', 'created' ), $asIDProduct );
		$productM->select( array('publish', 'blocked', 'availableend', 'availablestart', 'publishend', 'publishstart'), $asIDProduct );

		if ( $this->_paidItem )  $productM->select( array('discountrate', 'discountvalue' ), $asIDProduct );
		if ( !empty($pO->showPreview) ) $productM->select( 'previewid', $asIDProduct );

		if ( empty($pO->showNoRating) ) $productM->select( array( 'score', 'votes' ) , $asIDProduct );
		if ( !empty($pO->showReview) ) $productM->select( 'nbreviews', $asIDProduct );
		if ( !empty($pO->showViews) ) $productM->select( 'hits', $asIDProduct );


				$roleHelper = WRole::get();
		$storeManagerRole = WRole::hasRole( 'storemanager' );

			if ( !$storeManagerRole ) {

				$this->_checkIfIAMaVendor();

				if ( $this->_IamAvendor ) $productM->openBracket( 2 );
								$productM->where( 'publishstart', '<=', time(), $asIDProduct );
				$productM->where( 'publishend', '=', 0, $asIDProduct, null, 1, 0, 0  );
				$productM->where( 'publishend', '>=', time(), $asIDProduct, null, 0, 1, 1  );

				$productM->whereE( 'publish', 1, $asIDProduct );
				$productM->whereE( 'blocked', 0, $asIDProduct );
				if ( $this->_IamAvendor ) {
					$productM->closeBracket( 1 );
					$productM->whereE( 'vendid', $this->_vendid, $asIDProduct, null, 0, 1, 1 );
				}
			} else {
				$this->unpublishedItem = true;
			}
			$productM->checkAccess( $asIDProduct );


						if (!isset($asTransID) ) $asTransID = $asIDProduct+1;
			$translationAsID = $this->_setLanguageQuery( $productM, $pO, $asIDProduct, $asID );
			if ( empty($pO->showNoName) ) $productM->select( 'name', $translationAsID );																	if ( !empty( $pO->showIntro ) ) $productM->select( 'introduction', $translationAsID );													if ( !empty( $pO->showDesc ) ) $productM->select( 'description', $translationAsID );												

						$this->_extraFieldSearch( $productM, $pO, $typeFromprodtypid, $asIDProduct, $asID );


			$asID++;
			if ( empty($pO->showNoImage) ) {
				$asID++;
				$productM->makeLJ( 'item.images', 'pid', 'pid', $asIDProduct, $asID );
				$productM->whereOn( 'premium', '=', '1', $asID );
				$productM->select( 'filid', $asID, 'imageFilid' );
				$asID++;
				$productM->makeLJ( 'files', 'filid', 'filid', $asID-1, $asID );
				$productM->select( 'thumbnail', $asID );
				$productM->select( 'name', $asID, 'imageName' );
				$productM->select( 'type', $asID, 'imageType' );
				$productM->select( 'storage', $asID, 'imageStorage' );
				$productM->select( 'filid', $asID, 'imageFileID' );
				$productM->select( 'folder', $asID, 'imageFolder' );
				$productM->select( 'path', $asID, 'imagePath' );
				$productM->select( 'width', $asID, 'originWidth' );
				$productM->select( 'height', $asID, 'originHeight' );
				$productM->select( 'twidth', $asID, 'thumbWidth' );
				$productM->select( 'theight', $asID, 'thumbHeight' );
			}
						$asID++;
			$productM->makeLJ( 'item.type', 'prodtypid', 'prodtypid', $asIDProduct, $asID );				$productM->select( 'type', $asID );
			if ( !empty($pO->prodtypid) ) {
				if ( is_numeric($pO->prodtypid) ) $productM->whereE( 'prodtypid', $pO->prodtypid, $asIDProduct );
				else {
										if ( !isset($itemTypeC) ) $itemTypeC = WClass::get('item.type');
					$typeA = $itemTypeC->loadAllTypesFromDesignation( $pO->prodtypid );
					if (!empty($typeA) ) $productM->whereIn( 'prodtypid', $typeA, $asIDProduct );
				}
			} elseif ( !empty($pO->itemType) ) {
				if ( is_numeric($pO->itemType) ) $productM->whereE( 'prodtypid', $pO->itemType, $asIDProduct );
				else $productM->whereE( 'namekey', trim($pO->itemType), $asID );
			} elseif ( !empty($pO->type) ) {					if ( !empty($type) ) {
					$productM->whereE( 'type', $type, $asID );										}			}

							if ( !empty($pO->dontShowFree) && $this->_paidItem ) {

								$auctionExist = WExtension::exist( 'auction.node' );
				if ( $auctionExist ) {
															$isAuction = false;
					$hasDefinedType = false;
					if ( !empty( $pO->type ) && 'auction'==$pO->type ) {
						$isAuction = true;
						$hasDefinedType = true;
					} elseif ( !empty($pO->prodtypid) || !empty($pO->itemType) ) {						if ( !isset($itemTypeC) ) $itemTypeC = WClass::get('item.type');

						if ( is_numeric($pO->prodtypid) ) $newType = $itemTypeC->loadData( ( !empty($pO->prodtypid) ? $pO->prodtypid : $pO->itemType ), 'type'  );
						else $newType = $pO->prodtypid;

						if ( !empty( $newType ) && 'auction'==$newType ) $isAuction = true;
						$hasDefinedType = true;
					}
					if ( !$isAuction ) {
						$productPricetypeC = WClass::get( 'product.pricetype', null, 'class', false );
						if ( ! empty($productPricetypeC) ) $freePriceIDA = $productPricetypeC->getPriceTypeID( 'free' );

						if ( !empty( $freePriceIDA ) ) {
							if ( $hasDefinedType ) {
								$productM->whereIn( 'priceid', $freePriceIDA, $asIDProduct, true );	
							} else {																	$productM->whereIn( 'priceid', $freePriceIDA, $asIDProduct, true, 1, 0, 0 );
								$productM->where( 'price', '=', '0', $asIDProduct, null, 1, 0, 1 );
								$productM->whereE( 'type', 11, $asID, null, 0, 2, 0 );								}						}
					}					
				} else {
					$productPricetypeC = WClass::get( 'product.pricetype', null, 'class', false );
					if ( ! empty($productPricetypeC) ) $freePriceIDA = $productPricetypeC->getPriceTypeID( 'free' );
					if ( !empty( $freePriceIDA ) ) $productM->whereIn( 'priceid', $freePriceIDA, $asIDProduct, true );
				}
			}
						if ( $this->_paidItem && !empty($pO->addCart) ) {

								$asID++;
				$productM->makeLJ( 'item.options', 'pid', 'pid', $asIDProduct, $asID );					$productM->select( 'opid', $asID, 'options' );
			}

									if ( ( !empty($pO->showVendor) || !empty($pO->vendor) ) && WExtension::exist( 'vendors.node' ) ) {	
				$asID++;
				$vendorasID = $asID;
				$productM->makeLJ( 'vendor', 'vendid', 'vendid', $asIDProduct, $asID );
				$productM->select( 'uid', $asID, 'vendoruid' );

								if ( empty($pO->editable) ) $productM->whereE( 'publish', 1, $asID );

				if ( !empty($pO->showVendor) ) {
					$productM->makeLJ( 'vendortrans', 'vendid', 'vendid', $asID, $asID+1 );
					$asID++;
					$vendorasTransID = $asID;
					$productM->whereLanguage( $vendorasTransID, $this->_myLGID );
					$productM->select( 'name', $vendorasTransID, 'vendorName' );
				}

				if ( !empty($pO->vendor) ) {

					$allowSyndicate = WPref::load( 'PCATALOG_NODE_ALLOWSYNDICATION' );
					if ( $allowSyndicate ) {
						$productM->openBracket();
					}
					if ( is_numeric( $pO->vendor ) ) {
						$productM->whereE( 'vendid', $pO->vendor );
					} else {
						$productM->whereE( 'namekey', $pO->vendor, $asID );
					}					if ( $allowSyndicate ) {
						$asID++;
						$productM->operator( 'OR' );
						$productM->makeLJ( 'item.syndication', 'pid', 'pid', $asIDProduct, $asID );						$productM->whereE( 'vendid', $pO->vendor, $asID );
						$productM->closeBracket();
						$productM->select( 'ownervendid', $asID, 'syndicateVendid' );
					}
				}
			}
						if ( empty($limit) ) $limit = 500;
			if ( !empty($pO->prodids) ) $pO->id = $pO->prodids;

			$arrayID = array();
			if ( !empty($pO->id) ) {
								if ( strpos( $pO->id, ',' ) > 0 ) {
					$pO->id = str_replace( ' ', '', $pO->id );
					$arrayID = explode( ',', $pO->id );

					if ( !empty($arrayID) ) {
												$whereInIDs = array();
						$whereNOTInIDs = array();
						$whereInNamekeys = array();
						$whereNOTInNamekeys = array();
						foreach( $arrayID as $oneID ) {
							if ( is_numeric($oneID) ) {
								if ( $oneID >= 0 ) {
									$whereInIDs[] = $oneID;
								} else {
									$whereNOTInIDs[] = $oneID;
								}							} else {
								if ( substr( $oneID, 0, 1) == '-' ) {
																		$whereNOTInNamekeys[] = substr( $oneID, 1 );
								} else {
									$whereInNamekeys[] = $oneID;
								}							}						}
						if ( !empty($whereInIDs) ) {
							if ( empty($whereInNamekeys) ) $productM->whereIn( 'pid', $whereInIDs, $asIDProduct );
							else {
																$productM->whereIn( 'pid', $whereInIDs, $asIDProduct, false, 1, 0, 0 );
								$productM->whereIn( 'namekey', $whereInNamekeys, $asIDProduct, false, 0, 1, 1 );
							}						} elseif ( !empty($whereInNamekeys) ) $productM->whereIn( 'namekey', $whereInNamekeys, $asIDProduct );

						if ( !empty($whereNOTInIDs) ) {
							if ( empty($whereNOTInNamekeys) ) $productM->whereIn( 'pid', $whereNOTInIDs, $asIDProduct );
							else {

																$productM->whereIn( 'pid', $whereNOTInIDs, $asIDProduct, true );									$productM->whereIn( 'namekey', $whereNOTInNamekeys, $asIDProduct, true );	
							}						} elseif ( !empty($whereNOTInNamekeys) ) $productM->whereIn( 'namekey', $whereNOTInNamekeys, $asIDProduct );

						$limitCount = count($whereInIDs) + count($whereInNamekeys);
						if ( empty($limitCount) ) $limitCount = $limit;
						$productM->setLimit( $limitCount, $limitstart );
						$limit = $limitCount;
					}				} else {

					if ( is_numeric($pO->id) ) {
						$productM->whereE( 'pid', $pO->id, $asIDProduct );
					} else {
						$productM->whereE( 'namekey', $pO->id, $asIDProduct );
					}					$limit = 1;
					$productM->setLimit( 1 );
				}			} else {
				$productM->setLimit( $limit, $limitstart );
			}
			$haveCrossTableITemCat = false;
			self::$_leftJoinCategroryOnlyOnce = true;
						if ( !empty( $pO->category ) && is_numeric($pO->category) ) {
								if ( !empty($pO->showSubCategory) ) {
										$productCategoryM = WModel::get( 'item.category' );
					$allSubCategoriesA = $productCategoryM->getChildNode( $pO->category, true );
					if ( empty($allSubCategoriesA) ) $allSubCategoriesA = array( $pO->category );

					$haveCrossTableITemCat = $this->_leftJoinCategory( $productM, $asID, $asIDProduct );
					$categoryModelID = $asID;
					$productM->whereIn( 'catid', $allSubCategoriesA, $asID );

				} else {
					$haveCrossTableITemCat = $this->_leftJoinCategory( $productM, $asID, $asIDProduct );
					$categoryModelID = $asID;
					$productM->whereE( 'catid', $pO->category, $asID );
				}			}
						if ( !empty( $pO->showMainCategory ) ) {
				$haveCrossTableITemCat = $this->_leftJoinCategory( $productM, $asID, $asIDProduct );
				$categoryModelID = $asID;
				$productM->whereOn( 'premium', '=', 1, $asID ); 				$productM->select( 'catid', $asID, 'categoryID' );
				$productM->makeLJ( 'item.categorytrans', 'catid', 'catid', $asID, $asID+1 );
				$asID++;
				$productM->whereLanguage( $asID );
				$productM->select( 'name', $asID, 'categoryName' );
			}

						if ( !empty($pO->radius) && $pO->radius>0 ) {
				static $addressDistanceC = null;
				if ( !isset($addressDistanceC) ) $addressDistanceC = WClass::get( 'address.distance' );
				if ( !empty( $pO->location ) ) {
					$geoCode = $addressDistanceC->getMixMaxLongLatFromLocationRadius( $pO->location, $pO->radius );
				} elseif ( !empty($pO->longitude) && $pO->longitude !=0 && !empty($pO->latitude) && $pO->latitude !=0 ) {
					$geoCode = $addressDistanceC->getMixMaxLongLatFromCoordinateRadius( $pO->longitude, $pO->latitude, $pO->radius );
				}
				if ( !empty($geoCode) ) {
										$radiusDegree = (int)$pO->radius;
					$productM->select( array( 'longitude', 'latitude', 'location' ), $asIDProduct );
					$productM->where( 'longitude', '<=', $geoCode->maxCoordinate->longitude, $asIDProduct );
					$productM->where( 'longitude', '>=', $geoCode->minCoordinate->longitude, $asIDProduct );
					$productM->where( 'latitude', '<=', $geoCode->maxCoordinate->latitude, $asIDProduct );
					$productM->where( 'latitude', '>=', $geoCode->minCoordinate->latitude, $asIDProduct );
				}
			}
						if ( !empty( $this->_advSeachableA ) ) {
				WLoadFile( 'output.doc.document', JOOBI_DS_NODE );
				$sidItem = WModel::get( 'item', 'sid' );
				$sidItemTrans = WModel::get( 'itemtrans', 'sid' );

				foreach( $this->_advSeachableA as $oneSearch ) {
					$columnInstance = Output_Doc_Document::loadListingElement( $oneSearch );

					if ( in_array( $oneSearch->modelID , array( $sidItem, $sidItemTrans ) ) ) {
						$oneSearch->asi = ( $oneSearch->translation ? $translationAsID : $asIDProduct );
					} elseif ( 'product.option' == $oneSearch->type ) {
						$oneSearch->map = 'groupkey';
						if ( empty($optionValueasID) ) {
							$asID++;
							$optionValueasID = $asID;
							$productM->makeLJ( 'product.poptions', 'pid', 'pid', $asIDProduct, $optionValueasID );
							$asID++;
							$productM->makeLJ( 'product.option', 'opid', 'opid', $optionValueasID, $optionValueasID+1 );
							$asID++;
							$productM->makeLJ( 'product.optionvalues', 'opid', 'opid', $optionValueasID+1, $optionValueasID+2 );
							$optionValueasID = $optionValueasID+2;
						}						$oneSearch->asi = $optionValueasID;
					} else {
						if ( empty($vendorasID) ) {
							$asID++;
							$vendorasID = $asID;
							$productM->makeLJ( 'vendor', 'vendid', 'vendid', $asIDProduct, $vendorasID );
						}
						if ( $oneSearch->translation && empty($vendorasTransID) ) {
							$asID++;
							$vendorasTransID = $asID;
							$productM->makeLJ( 'vendortrans', 'vendid', 'vendid', $vendorasID, $vendorasTransID );
							$productM->whereLanguage( $vendorasTransID, $this->_myLGID );
						}						$oneSearch->asi = ( $oneSearch->translation ? $vendorasTransID : $vendorasID );
					}					$columnInstance->searchQuery( $productM, $oneSearch, $oneSearch->value, 'AND' );
				}			}

			if ( !isset($pO->sorting) ) $pO->sorting = '';

						$hasPromotion = WPref::load('PITEM_NODE_PROMOTIONUSE' );
			if ( $hasPromotion ) {
				if ( !empty( $pO->widgetSlug ) ) {
										
					$columnUsed = $pO->widgetSlug;
					if ( isset($pO->widgetID) ) $columnUsed .= $pO->widgetID;

					$columnExists = $this->_columnFeaturedExist( $columnUsed );

					if ( !empty($columnExists) ) {
						$productM->orderBy( 'featured', 'DESC', $asIDProduct );
						$asID++;
						$productM->makeLJ( 'item.featureditem', 'pid', 'pid', $asIDProduct, $asID );
						$featuredItemID = $asID;
						$productM->makeLJ( 'item.featured', 'ftdid', 'ftdid', $asID, $asID+1 );
						$productM->orderBy( $columnUsed, 'DESC', $asID );
						$productM->orderBy( 'ordering', 'ASC', $asID+1 );
						$paid = WPref::load( 'PITEM_NODE_PROMOTIONPAID' ) && WExtension::exist( 'subscription.node' );
						if ( $paid ) {
							$productM->openBracket( 2 );
							$productM->whereE( 'status', 9, $featuredItemID );
							$productM->where( 'expiration', '>', time(), $featuredItemID );
							$productM->closeBracket();
							$productM->operator( 'OR' );
							$productM->isNull( 'pid', true, $featuredItemID );
							$productM->closeBracket();
						}						$productM->orderBy( 'expiration', 'ASC', $featuredItemID );
						$asID++;
						$hasFeatured = true;
					}				} else {

						}			}

			switch( $pO->sorting ) {

				case 'featured':
					
						$productM->whereE( 'featured', 1, $asIDProduct );
						$productM->orderBy( 'created', 'DESC', $asIDProduct );

					break;

				case 'sold':											$productM->orderBy( 'nbsold', 'DESC', $asIDProduct );
					$productM->orderBy( 'created', 'DESC', $asIDProduct );
					break;

				case 'hits':											$productM->orderBy( 'hits', 'DESC', $asIDProduct );
					$productM->orderBy( 'created', 'DESC', $asIDProduct );
					break;

				case 'reviews':											$productM->orderBy( 'nbreviews', 'DESC', $asIDProduct );
					$productM->orderBy( 'created', 'DESC', $asIDProduct );
					break;

				case 'rated':
										$sortCalcul = $productM->setCalcul( 'score', '/', 'votes', $asIDProduct, $asIDProduct );
					$productM->orderBy( $sortCalcul, 'DESC', $asIDProduct );
					$productM->orderBy( 'created', 'DESC', $asIDProduct );
					break;

				case 'highprice':
										$productM->orderBy( 'price', 'DESC', $asIDProduct );
					$productM->orderBy( 'created', 'DESC', $asIDProduct );
					break;
				case 'lowprice':
										$productM->orderBy( 'price', 'asc', $asIDProduct );
					$productM->orderBy( 'created', 'DESC', $asIDProduct );
					break;

				case 'alphabetic':
										$productM->orderBy( 'name', 'asc', $translationAsID );
					$productM->orderBy( 'created', 'DESC', $asIDProduct );
					break;

				case 'reversealphabetic':
										$productM->orderBy( 'name', 'DESC', $translationAsID );
					$productM->orderBy( 'created', 'DESC', $asIDProduct );
					break;

				case 'oldest':
										$productM->orderBy( 'created', 'asc', $asIDProduct );
					break;

				case 'ordering':
					if ( $haveCrossTableITemCat ) {
						$productM->orderBy( 'ordering', 'asc', $categoryModelID );
					} else {
						$productM->orderBy( 'created', 'DESC', $asIDProduct );
					}					break;

				case 'recentlyviewed':						$productM->orderBy( 'created', 'DESC' );
					break;

				case 'mytopviewed':						$productM->orderBy( 'total', 'DESC' );
					$productM->orderBy( 'created', 'DESC' );
					break;

				case 'recentlyupdated':
					$productM->orderBy( 'modified', 'DESC', $asIDProduct );
					break;

				case 'availabledate':						$productM->orderBy( 'availablestart', 'DESC', $asIDProduct );
					break;

				case 'endingsoon':
					if ( !empty($asBIdding) ) {
						$productM->where( 'biddingend', '>', time(), $asBIdding );
						$productM->orderBy( 'biddingend', 'ASC', $asBIdding );
						$productM->whereE( 'publish', 1, $asIDProduct );
					} else {
						$productM->orderBy( 'availableend', 'ASC', $asIDProduct );
					}					break;

				case 'random':
					$productM->orderBy( 'random', 'RAND', $asIDProduct );
					break;

				case 'latest': 				case 'newest': 				default :											$productM->orderBy( 'created', 'DESC', $asIDProduct );
										break;

			}
			if ( $this->_paidItem ) {
								$asID++;
				$productM->makeLJ( 'item.price', 'priceid', 'priceid', $asIDProduct, $asID );
				$productM->select( 'type', $asID, 'pricetype' );
			}
			
			$this->_extraFieldLoad( $productM, $pO, $typeFromprodtypid, $asIDProduct, $asID, false );

			$allItemsA = $productM->load( 'ol' );

			if ( empty($allItemsA) ) return $allItemsA;

						if ( $pO->sorting == 'ordering' && !empty($arrayID) && !empty($allItemsA) && !$haveCrossTableITemCat ) {
				$newResultsA = array();
				$namekeyResultA = array();
				foreach( $allItemsA as $oneResult ) {
					$newResultsA[$oneResult->pid] = $oneResult;
					$namekeyResultA[$oneResult->namekey] = $oneResult->pid;
				}
				$allItemsInfoA = array();
				$i=0;
				foreach( $arrayID as $eachID ) {

					$eachID = trim($eachID);
					if ( !empty($newResultsA[$eachID]) ) {
						$i++;
						$allItemsInfoA[] = $newResultsA[$eachID];
					} elseif ( !empty($namekeyResultA[$eachID]) ) {
						$i++;
						$allItemsInfoA[] = $newResultsA[$namekeyResultA[$eachID]];
					}
					if ( !empty($limit) && $limit == $i ) break;					}
			} else {
				$allItemsInfoA = $allItemsA;
			}

		
		if ( ( WPref::load('PITEM_NODE_PROMOTIONUSE') || !empty($hasFeatured) ) && !empty($pO->widgetSlug) ) {

			$columnUsed = $pO->widgetSlug;
			if ( isset($pO->widgetID) ) $columnUsed .= $pO->widgetID;

			$columnExists = $this->_columnFeaturedExist( $columnUsed );
			if ( $columnExists ) {
				$listOfPIDA = array();
				foreach( $allItemsInfoA as $oneP ) $listOfPIDA[] = $oneP->pid;

				$itemFeatureditemM = WModel::get( 'item.featureditem' );
				$itemFeatureditemM->makeLJ( 'item.featured', 'ftdid' );
				$itemFeatureditemM->makeLJ( 'item.featuredtrans', 'ftdid', 'ftdid', 1, 2 );
				$itemFeatureditemM->whereLanguage( 2 );
				$itemFeatureditemM->checkAccess( 1 );
				$itemFeatureditemM->whereE( 'publish', 1, 1 );
				$itemFeatureditemM->whereE( $columnUsed, 1 );
				$itemFeatureditemM->select( array( 'badge', 'badgecolor', 'background', 'cssstyle', 'badgeposition', 'cssclass', 'bordercolor', 'ordering', 'ftdid' ), 1 );
				$itemFeatureditemM->select( 'badgename', 2 );
				$itemFeatureditemM->select( 'pid', 0 );
				$itemFeatureditemM->whereIn( 'pid', $listOfPIDA );
					$itemFeatureditemM->orderBy( 'ordering', 'ASC', 1 );
				$itemFeatureditemM->orderBy( 'credits', 'DESC', 1 );
								$featuredA = $itemFeatureditemM->load( 'ol' );
				$sortedFeaturedA = array();
				if ( !empty($featuredA) ) foreach( $featuredA as $oneFeature ) if ( !isset($sortedFeaturedA[$oneFeature->pid]) ) $sortedFeaturedA[$oneFeature->pid] = $oneFeature;
				if ( !empty($allItemsInfoA) ) {
					$newItemsA = array();
					foreach( $allItemsInfoA as $key => $oneItem ) {

						if ( !empty($sortedFeaturedA[$oneItem->pid]) ) {
							$style = '';
														if ( !empty($sortedFeaturedA[$oneItem->pid]->bordercolor) ) {
								$oneItem->borderColor = $sortedFeaturedA[$oneItem->pid]->bordercolor;
								$oneItem->borderShow = true;
							}
														if ( !empty($sortedFeaturedA[$oneItem->pid]->background) ) {
								$style .= 'background: none repeat scroll 0% 0% ' . $sortedFeaturedA[$oneItem->pid]->background . ';';

							}							if ( !empty($sortedFeaturedA[$oneItem->pid]->cssstyle) ) {
								$style .= $sortedFeaturedA[$oneItem->pid]->cssstyle;
							}							if ( !empty( $style ) ) $oneItem->style = $style;

							if ( !empty( $sortedFeaturedA[$oneItem->pid]->cssclass ) ) {
								$oneItem->classSuffix = ( empty( $oneItem->classSuffix ) ? ' ' : ' ' . $oneItem->classSuffix );
								$oneItem->classSuffix .= $sortedFeaturedA[$oneItem->pid]->cssclass;
							}
							if ( !empty( $sortedFeaturedA[$oneItem->pid]->badge ) ) {
								$newBadge = new stdClass;
								$newBadge->style = $sortedFeaturedA[$oneItem->pid]->badge;
								$newBadge->badgeColor = 'badge' . ( !empty($sortedFeaturedA[$oneItem->pid]->badgecolor) ? $sortedFeaturedA[$oneItem->pid]->badgecolor : 'success' );
								$newBadge->badgePosition = ( !empty($sortedFeaturedA[$oneItem->pid]->badgeposition) ? $sortedFeaturedA[$oneItem->pid]->badgeposition : 'top-right' );
								$newBadge->badgeName = ( !empty($sortedFeaturedA[$oneItem->pid]->badgename) ? $sortedFeaturedA[$oneItem->pid]->badgename : WText::t('1405139915GGBP') );
								$oneItem->badge = $newBadge;
							}
														$oneItem->featured = false;

						}
						$newItemsA[] = $oneItem;

					}
					$allItemsInfoA = $newItemsA;
					WPage::addCSSFile( 'node/catalog/css/badge.css' );

				}
			}
		}

				if ( !empty($pO->mouseOver) && strpos( $pO->mouseOver, 'secondimage' ) !== false ) {

						$pidA = array();
			foreach( $allItemsInfoA as $oneP ) {
				$pidA[] = $oneP->pid;
			}

						$itemImagesM = WModel::get( 'item.images' );
			$itemImagesM->makeLJ( 'files', 'filid', 'filid', 0, 1 );
			$itemImagesM->whereIn( 'pid', $pidA );
			$itemImagesM->where( 'premium', '!=', '1' );
			$itemImagesM->select( 'pid' );
			$itemImagesM->select( 'filid', 1, 'imageFilid' );
			$itemImagesM->select( 'thumbnail', 1 );
			$itemImagesM->select( 'name', 1, 'imageName' );
			$itemImagesM->select( 'type', 1, 'imageType' );
			$itemImagesM->select( 'storage', 1, 'imageStorage' );
			$itemImagesM->select( 'filid', 1, 'imageFileID' );
			$itemImagesM->select( 'folder', 1, 'imageFolder' );
			$itemImagesM->select( 'path', 1, 'imagePath' );
			$itemImagesM->select( 'width', 1, 'originWidth' );
			$itemImagesM->select( 'height', 1, 'originHeight' );
			$itemImagesM->select( 'twidth', 1, 'thumbWidth' );
			$itemImagesM->select( 'theight', 1, 'thumbHeight' );
			$itemImagesM->orderBy( 'ordering' );
			$allImagesA = $itemImagesM->load( 'ol' );

			if ( !empty($allImagesA) ) {
				$imgA = array();
				foreach( $allImagesA as $oneP ) {
					$imgA[$oneP->pid] = $oneP;
				}
				foreach( $allItemsInfoA as $key => $oneP ) {
					if ( !empty( $imgA[$oneP->pid] ) ) {
						$allItemsInfoA[$key]->secondImage = $imgA[$oneP->pid];
					}				}
			}
		}
		return $allItemsInfoA;

	}











	function extraProcess(&$productA,&$extraObj,$nb=5) {
		static $catid = null;
		static $itemTypeC = null;

				if ( empty( $extraObj ) || empty( $productA ) ) return false;

		if ( !empty($extraObj->mouseOver) ) {
			$putputThemeC = WClass::get( 'output.theme' );				$putputThemeC->mouseOverParams( $extraObj );
		}
				
				if ( !isset($catid) ) {
			$taskURL = WGlobals::get( 'task' );
			$controllerURL = WGlobals::get( 'controller' );
			if ( $taskURL=='category' && $controllerURL=='catalog') {
				$catid = WGlobals::getEID();
			}		}		$extraLink = ( !empty($catid) ) ? '&catid='. $catid : '';

				$pageID = ( !empty( $extraObj->pageID ) ) ? $extraObj->pageID : true;

				$coordinatesA = array();
		$productDesignationT = WType::get( 'item.designation' );

		foreach( $productA as $myKey => $product ) {

						$itemTypeName = $productDesignationT->getName( $product->type );

			if ( !empty($itemTypeName) ) $this->_paidItemSpecific = ( in_array( $itemTypeName, array( 'product', 'subscription', 'auction', 'classified' ) ) ? true : false );
			else $this->_paidItemSpecific = $this->_paidItem;

						if ( WGlobals::checkCandy(50) ) {
				$whoCanView = $product->rolid;
				if ( empty( $whoCanView ) || $whoCanView == 1 ) {
										$itemTypeC = WClass::get( 'item.type' );
					$whoCanView = $itemTypeC->loadData( $product->prodtypid, 'rolid' );
					if ( empty($whoCanView) || $whoCanView == 1 ) {
						if ( !defined('PITEM_NODE_CAN_VIEW_ITEM') )
						$whoCanView = WPref::load( 'PITEM_NODE_CAN_VIEW_ITEM' );						}				}
				if ( !empty($whoCanView) ) {
					if ( !isset($this->_itemAccessC) ) $this->_itemAccessC = WClass::get( 'item.access' );
					$hasRole = $this->_itemAccessC->haveAccess( $whoCanView );
				} else $hasRole = true;

				if ( !$hasRole ) {
										unset( $productA[$myKey]);
					continue;
				}
			}

			if ( !empty($product->params) ) WTools::getParams( $product, 'params' );
						if ( !empty( $product->syndicateVendid ) && !empty( $extraObj->vendor ) ) $extraLink .= '&syndid=' . $extraObj->vendor;
			$product->pageLink = WPage::routeURL('controller=catalog&task=show&eid='.$product->pid . $extraLink, 'home', false, false, $pageID );

			if ( !empty($product->vendid) ) {
				$product->vendorLink = WPage::linkHome('controller=vendors&task=home&eid='.$product->vendid );
				$product->vendorBy = WText::t('1213117657LKZK');
			}
									if ( !empty( $extraObj->share ) && !empty($product->name) ) {
				$shareTypeA = explode( ',', $extraObj->share );

				if ( !empty($shareTypeA) ) {
					$catalogShowSocialC = WClass::get('catalog.showsocial');
					if ( !isset($product->link) ) $product->link = new stdClass;

										$product->share = true;

					$extraHTML = '';
					foreach( $shareTypeA as $oneShare ) {

						switch( trim($oneShare) ) {
							case 'facebook':
								$product->linkFacebook = $catalogShowSocialC->displayFacebook( $product );
								break;
							case 'twitter':
							case 'addthis':
								$product->linkTwitter = $catalogShowSocialC->displayTwitter( $product );
								break;
							case 'sharethis':									break;
							case 'google':
							case 'google+1':
							case 'buzz':
								$product->linkGoogle = $catalogShowSocialC->displayGoogle( $product );									$product->linkGooglePlus1 = $product->linkGoogle;									break;
							case 'print':
																$linkPrint = 'controller=catalog&task=show&eid=' . $product->pid . '&printpage=1&hidecomment=1' . URL_NO_FRAMEWORK;									$product->linkPrint = WPage::routeURL( $linkPrint, 'home', 'popup', false, false, null, true );
								break;
							case 'email':
								break;
							case 'favorite':
								$product->linkFavorite = $catalogShowSocialC->displayFavorite( $product->pid );
								break;
							case 'wish':
								$product->linkWish = $catalogShowSocialC->displayWish( $product->pid );
								break;
							case 'watch':
								$product->linkWatch = $catalogShowSocialC->displayWatch( $product->pid );
								break;
							case 'like':
								$product->linkLike = $catalogShowSocialC->displayLike( $product->pid );
								break;
							case 'share':
								$product->linkShare = $catalogShowSocialC->displayShare( $product->pid );
								break;
						}

					}
				}
			}
						if ( !empty($product->imageFilid) && !empty( $product->imageName ) ) {

																				$useThumnailsPath = false;
				if ( !empty($extraObj->nb) && $extraObj->nb > 1 && $product->thumbnail ) {
					if ( !empty($extraObj->imageWidth) && !empty($extraObj->imageHeight) && ( $extraObj->imageWidth > $product->thumbWidth || $extraObj->imageHeight > $product->thumbHeight ) ) {
						$useThumnailsPath = false;
					} else {
						$useThumnailsPath = true;
					}				}
								$filePath = ( !empty( $product->imagePath ) ) ? $product->imagePath : 'images/products';

				if ( !isset($this->_myNewImageO) ) $this->_myNewImageO = WObject::get( 'files.file' );
				$this->_myNewImageO->name = $product->imageName;
				$this->_myNewImageO->type = $product->imageType;
				$this->_myNewImageO->basePath = JOOBI_URL_MEDIA;
				$this->_myNewImageO->folder = ( empty($product->imageFolder) ? 'media' : $product->imageFolder );
				$this->_myNewImageO->path = $filePath;
				$this->_myNewImageO->fileID = $product->imageFileID;
				$this->_myNewImageO->thumbnail = false;
				$this->_myNewImageO->storage = $product->imageStorage;
				$product->imagePath = $this->_myNewImageO->fileURL();

				$this->_myNewImageO->thumbnail = $useThumnailsPath;
				$product->thumbnailPath = $this->_myNewImageO->fileURL();

								if ( !empty($product->secondImage) ) {

																									$useThumnailsPath = false;
					if ( !empty($extraObj->nb) && $extraObj->nb > 1 && $product->secondImage->thumbnail ) {
						if ( !empty($extraObj->imageWidth) && !empty($extraObj->imageHeight) && ( $extraObj->imageWidth > $product->secondImage->thumbWidth || $extraObj->imageHeight > $product->secondImage->thumbHeight ) ) {
							$useThumnailsPath = false;
						} else {
							$useThumnailsPath = true;
						}					}
										$filePath = ( !empty( $product->secondImage->imagePath ) ) ? $product->secondImage->imagePath : 'images/products';

					$this->_myNewImageO->name = $product->secondImage->imageName;
					$this->_myNewImageO->type = $product->secondImage->imageType;
					$this->_myNewImageO->basePath = JOOBI_URL_MEDIA;
					$this->_myNewImageO->folder = ( empty($product->secondImage->imageFolder) ? 'media' : $product->secondImage->imageFolder );
					$this->_myNewImageO->path = $filePath;
					$this->_myNewImageO->fileID = $product->secondImage->imageFileID;
					$this->_myNewImageO->thumbnail = false;
					$this->_myNewImageO->storage = $product->secondImage->imageStorage;
					$product->secondImage->imagePath = $this->_myNewImageO->fileURL();

					$this->_myNewImageO->thumbnail = $useThumnailsPath;
					$product->secondImage->thumbnailPath = $this->_myNewImageO->fileURL();

				}


			} elseif ( empty($extraObj->showNoImage) ) {									$product->thumbnailPath = JOOBI_URL_MEDIA . 'images/products/productx.png';
				$product->imagePath = JOOBI_URL_MEDIA . 'images/products/productx.png';

				if ( ( !empty($product->filid) ) && (!empty( $extraObj->showExtensionImage )) ) {

						$filesM=WModel::get( 'files' );
						$filesM->select( 'type');
						$filesM->whereE( 'filid', $product->filid );
						$fileType = $filesM->load('lr');

						if ( !empty($fileType) ) {
							$filesMediaC = WClass::get( 'files.media' );
							$iconImg = $filesMediaC->iconImages( $fileType );

							$product->thumbnailPath = $iconImg;
							$product->imagePath = $iconImg;
						}
				}
				$product->originWidth = 180;
				$product->originHeight = 180;

			}
						$product->imageLinked = true;


					if ( empty( $product->rolidviewprice ) || $product->rolidviewprice == 1 ) {
												if (!isset($itemTypeC)) $itemTypeC = WClass::get( 'item.type' );
						$rolidviewprice = $itemTypeC->loadData( $product->prodtypid, 'rolidviewprice' );
						if ( empty($rolidviewprice) || $rolidviewprice == 1 ) {
							$rolidviewprice = WPref::load('PPRODUCT_NODE_ROLIDVIEWPRICE');							}					} else {
						$rolidviewprice = $product->rolidviewprice;
					}
					if ( !empty($rolidviewprice) ) {
						if ( !isset($this->_itemAccessC) ) $this->_itemAccessC = WClass::get( 'item.access' );
						$hasRole = $this->_itemAccessC->haveAccess( $rolidviewprice );
					}
					else $hasRole = true;

					$product->hasRoleViewPrice = $hasRole;


			if ( !empty( $extraObj->showPrice ) ) {

								if ( !empty($product->price) && $product->price == 0 ) {
					if (!isset($itemTypeC)) $itemTypeC = WClass::get( 'item.type' );
					$itemTypeNAME = $itemTypeC->loadData( $product->prodtypid, 'designation' );
					$showPriceInfo = ( $itemTypeNAME != 'item' ) ? true : false;
				} else {
					$showPriceInfo = true;
				}
								if ( $product->type == 16 ) {
					$product->pricetype = 10;
				}
																if ( !empty($product->pricetype) && $showPriceInfo && $product->type < 100 && !in_array( $product->pricetype, array( 40, 50, 250 ) ) ) {

					if ( $hasRole ) {

						$myGroupPrice = true;												if ( $product->pricetype == 17 ) {
							$shoppersPricesC = WClass::get( 'shoppers.prices', null, 'class', false );
							if ( !empty($shoppersPricesC) ) {
								$myGroupPrice = $shoppersPricesC->getPrice( $product->pid, $product->vendid );
								if ( $myGroupPrice !==false ) $product->price = $myGroupPrice;
								else $product->noPriceFound = true;
							}						}
						if ( $myGroupPrice ) {
														if ( !empty( $extraObj->curid ) ) {
								if ( empty( $product->price ) || $product->price <= 0 ) {
									if ( $product->type != 11 ) $product->convertedPrice = WText::t('1206961944PEUR');
								} else {
									$product->convertedPrice = $this->_formatPrice( $product->price, $product, $extraObj->curid );
								}							}
							if ( ( !empty($product->discountrate) && $product->discountrate > 0 )  || ( !empty($product->discountvalue) && $product->discountvalue > 0 )  ) {
								$price = $product->price;
								if ( $product->discountrate > 0 ) {
									$price = $price * ( 100 - $product->discountrate ) / 100;
								}								if ( $product->discountvalue > 0 ) {
									$price = $price - $product->discountvalue;
									if ( $price < 0 ) $price = 0;
								}								$product->convertedSalePrice = $this->_formatPrice( $price, $product, $extraObj->curid );
								$orignalPrice = $this->_formatPrice( $product->price, $product, $extraObj->curid );
								$product->convertedPrice = '<span class="productOnSaleOld">' . $orignalPrice . '</span> <span class="productOnSaleNew">' . $product->convertedSalePrice . '</span>';

																if ( WPref::load( 'PCATALOG_NODE_ONSALEUSE' ) ) {										WPage::addCSSFile( 'node/catalog/css/badge.css' );
									$product->onSale = WText::t('1405139918JIDN');
								}
							} else {
								$product->convertedSalePrice = '';
							}
						}
					}
				}
			}
			if ( !empty($product->convertedHighestBid) ) {
				$product->convertedHighestBid = $this->_formatPrice( $product->highestBid, $product, $extraObj->curid );
			}

			$this->_processItemInformation( $product, $extraObj );

						if ( $product->longitude > -180 && $product->longitude < 180 && $product->latitude > -180 && $product->latitude < 180) {
								$newCoordiante = new stdClass;
				$newCoordiante->name = $product->name;
				$newCoordiante->location = $product->location;
				$newCoordiante->longitude = $product->longitude;
				$newCoordiante->latitude = $product->latitude;

								$itemTypeName = $productDesignationT->getName( $product->type );
				$newCoordiante->icon = JOOBI_URL_MEDIA . 'itemtype/thumbnails/' . $itemTypeName . 'typex.png';

				$coordinatesA[] = $newCoordiante;
			}
		}
				WGlobals::set( 'itemsCoordinatesA', $coordinatesA, 'global' );


				if ( !empty($extraObj->showAll) ) {
			$text = WText::t('1308888696DFOB');
			$extraParams = '';
			if ( !empty($extraObj->prodtypid) && is_numeric($extraObj->prodtypid) ) $extraParams .= '&prodtypid='.$extraObj->prodtypid;
			if ( !empty($extraObj->type) ) $extraParams .= '&type='.$extraObj->type;
			if ( !empty($extraObj->category) ) $extraParams .= '&category='.$extraObj->category;
			if ( !empty($extraObj->sorting) ) $extraParams .= '&choicesorting='.$extraObj->sorting;
			if ( !empty($extraObj->vendor) ) $extraParams .= '&vendor='.$extraObj->vendor;
			$link = WPage::routeURL( 'controller=catalog-items'.$extraParams , 'home' );

			$objButtonO = WPage::newBluePrint( 'prefcatalog' );
			$objButtonO->type = 'buttonViewAllInCatalogPage'; 				$objButtonO->link = $link;
			$objButtonO->text = $text;
			$objButtonO->id = 'viewAllBtn' . self::$_nb;
			$extraObj->showAllLink = WPage::renderBluePrint( 'prefcatalog', $objButtonO );

		}
	}







	private function _processItemInformation(&$product,$tagParams) {
		static $emailHelperC = null;
		$product->cart = '';


		if ( !empty( $tagParams->showcountdown ) ) {
			if ( $product->type == 11 ) {					$time = $product->biddingend;
			} elseif ( $product->type == 16 ) {					$time = $product->availableend;
			} else {
				$time = 0;
			}
			if ( !empty($time) ) {
				if ( $time < time() ) {
					if ( $product->type == 11 ) {							$product->countDown = WText::t('1413839109PZWI');
					} elseif ( $product->type == 7 ) {							$product->countDown = WText::t('1414171282KDHZ');
					} elseif ( $product->type == 16 ) {							$product->countDown = WText::t('1414170944SSLV');
					}				} else {
					$mainDateCountDown = WClass::get( 'main.date' );
					$product->countDown = $mainDateCountDown->countDown( $time ) . ' <div class="cntdwnText">' . WText::t('1412376037SHQJ') . ' </div>';
				}			}		}

		static $deliveryType = null;
		if ( !isset($deliveryType) ) {
			$deliveryType = WPref::load('PPRODUCT_NODE_DELIVERYTYPE');			}
		if ( ( empty( $deliveryType ) || $deliveryType != 1 ) && ( empty( $this->electronic ) || $this->electronic != 1 )  ) {
			if ( $product->stock == -1 ) $product->stockText = WText::t('1303523079JFAY');
			else $product->stockText = $product->stock . WText::t('1303523079JFAZ');
		} else {
			$product->stockText = '';
		}
				if ( !empty($product->name) && !empty($tagParams->nlimit) && is_numeric($tagParams->nlimit) ) {
			$nlimit = $tagParams->nlimit; 			if ( strlen($product->name) > $nlimit ) {
				if ( empty($emailHelperC) ) $emailHelperC = WClass::get( 'email.conversion' );
				$product->name = $emailHelperC->smartHTMLSize( $product->name, $nlimit, true, false, false, false );
			}
		}
		if ( !empty($product->introduction) && !empty($tagParams->climit ) && is_numeric($tagParams->climit) ) {
			$climit = $tagParams->climit; 
			if ( strlen($product->introduction) > $climit ) {

				if ( empty($emailHelperC) ) $emailHelperC = WClass::get( 'email.conversion' );
				$product->introduction = $emailHelperC->smartHTMLSize( $product->introduction, $climit, true, false, true );

			}
			$introLenght = strlen( $product->introduction );
		} else {
			$introLenght = 0;
		}
		if ( !empty($product->description) && !empty($tagParams->climit ) && is_numeric($tagParams->climit) ) {
			$newLimit = $tagParams->climit - $introLenght; 
			if ( $newLimit > 0 && strlen($product->description) > $newLimit ) {

				if ( empty($emailHelperC) ) $emailHelperC = WClass::get( 'email.conversion' );
				$product->description = $emailHelperC->smartHTMLSize( $product->description, $newLimit, true, false, true );

			}
		}
				if ( !empty($product->options) ) {
			$product->addCartLink = $product->pageLink;
		} else {
			if ( $this->_checkLoginRequired() ) {
				$product->addCartLink = WPage::link( 'controller=users&task=login' );
			} else {
				$itemId = WPage::getSpecificItemId( 'basket' );
				$product->addCartLink = WPage::routeURL( 'controller=basket&task=addbasket&eid=' . $product->pid, 'home', false, false, $itemId );
			}
		}
		$freeDownload = false;
				$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );
		if ( !empty($product->filid) && $integrate ) {
			if ( WExtension::exist( 'subscription.node' ) ) {
				$subscriptionCheckC = WObject::get( 'subscription.check' );
				$subscriptionCheckC->dontDeductCredits();
				$subscriptionCheckC->restriction( 'product_free' );

				if ( $subscriptionCheckC->restrictionExist() && $subscriptionCheckC->getStatus( false ) ) {
										$freeDownload = true;
									}			}		}
		$freeDowloadPruct = WPref::load( 'PPRODUCT_NODE_NOCHECKOUTDL' );
				if ( !$freeDownload && $freeDowloadPruct && !empty($product->pricetype) ) {
			if ( ( in_array( $product->pricetype, array( 10, 17 ) ) && 0 == $product->price ) || 250 == $product->pricetype ) {
				$freeDownload = true;
			}		}
		if ( $product->type == 141 || ( $freeDownload && $product->type == 1 ) ) {										$product->downloadLink = WPage::routeURL('controller=catalog&task=download&bfrhead=1&eid='.$product->pid, 'home' );
						$text = WText::t('1206961905BHAV');
			$noStock = WText::t('1323735798QGJI');
			$link = $product->downloadLink;

		} else {

									if ( $product->type == 11 ) {					$text = WText::t('1307949273HPWX');
				$noStock = WText::t('1318245798SKGL');
				$link = $product->pageLink;
			} elseif ( $product->type == 5 ) {					$text = WText::t('1220872966GYHA');
				$noStock = WText::t('1318245798SKGM');
				$link = $product->addCartLink;
			} elseif ( $product->type == 16 ) {									$text = '';
				$noStock = '';
				$link = '';
			} else {					if ( !empty($product->pricetype) ) {

										switch( $product->pricetype ) {
						case 20:								$text = ( $this->_checkLoginRequired() ? WText::t('1306322992BCSH') : WText::t('1301973197AJAW') );
							$link = $product->pageLink;
							break;
						case 50:// for contact us
							$text = ( $this->_checkLoginRequired() ? WText::t('1307002983EBLA') : WText::t('1206732392OZUV') );
							$link = $product->pageLink;
							break;
						case 40:								$text = ( $this->_checkLoginRequired() ? WText::t('1380030186EWBG') : WText::t('1298350960NBMB') );
							$link = $product->buynowlink;
							break;
						case 17:							case 10:							default:
							$text = ( $this->_checkLoginRequired() ? WText::t('1306322993GCMQ') : WText::t('1263480669ALUN') );
							$link = $product->addCartLink;
							break;

					}
					if ( $this->_checkLoginRequired() ) $link = WPage::link( 'controller=users&task=login' );
					$noStock = WText::t('1318245798SKGL');

				}			}
		}
				if ( $this->_paidItemSpecific && !empty($tagParams->addCart) && !empty($link) && empty($product->noPriceFound) ) {
						if ( $product->stock == 0 && ( empty( $deliveryType ) || $deliveryType != 1 ) && ( empty( $this->electronic ) || $this->electronic != 1 ) ) {							$product->cart = '<b>'.$noStock.'</b>';
			}else {
				$hasRole = false;
												if (  !empty($product->hasRoleViewPrice) || $product->type == 141 ) {						if ( empty( $product->rolid_buy ) || $product->rolid_buy == 1 ) {
												if ( !isset($itemTypeC) ) $itemTypeC = WClass::get( 'item.type' );
						$rolid_buy = $itemTypeC->loadData( $product->prodtypid, 'rolid_buy' );

						if ( empty($rolid_buy) || $rolid_buy == 1 ) {
							$rolid_buy = WPref::load( 'PPRODUCT_NODE_ROLID_BUY' );
						}					} else {
						$rolid_buy = $product->rolid_buy;
					}
					if ( !empty($rolid_buy) ) {
						if ( !isset($this->_itemAccessC) ) $itemAccessC = WClass::get( 'item.access' );
						$hasRole = $this->_itemAccessC->haveAccess( $rolid_buy );
					} else $hasRole = true;

				} else {
					$hasRole = false;
				}
				if ( !$hasRole ) { 					$register = WRole::getRole( 'registered' );

					if ( $product->rolid_buy == $register ) {
				 		$product->cart = '<b>'.WText::t('1318408618AVCB').'</b>';							 }else {
					 	$product->cart = '';
					 }
				} else {
					$objButtonO = WPage::newBluePrint( 'prefcatalog' );
					$objButtonO->type = 'buttonAddToCartInCatalogPage';
					$objButtonO->id = 'addCart' . self::$_nb . '_' . $product->pid;
					$objButtonO->text = $text;
					$objButtonO->link = $link;
					$objButtonO->classes = 'btnAddCart';
					$product->cart = WPage::renderBluePrint( 'prefcatalog', $objButtonO );
				}			}
		}
				if ( $this->_haveAuction && $product->type == 11 ) {

				if ( !empty($product->currentbid) ) {
					$product->highestBid = $this->_formatPrice( $product->currentbid, $product, $product->bidcurid );
				} else {
					if ( !empty( $product->startingbid ) && $product->startingbid > 0 ) {
						$product->highestBid = $this->_formatPrice( $product->startingbid, $product, $product->bidcurid );
					} else {
						if ( WPref::load( 'PAUCTION_NODE_NOBIDDISPLAY' ) ) {
							$product->highestBid = WText::t('1325800238PHUN');
						} else {
							$product->highestBid = WTools::format( 0, 'money' );
						}
					}				}
			if ( empty($link) ) $link = $product->pageLink;
			if ( !empty($tagParams->buyNow) && !empty($link) && empty($product->noPriceFound) ) {

				$buttonO = WPage::newBluePrint( 'prefcatalog' );
				$buttonO->type = 'buttonAddToCartInCatalogPage';
				$buttonO->text = WText::t('1298350960NBMB');
				$buttonO->link = $link;
				if ( !empty($product->convertedPrice) ) $product->convertedPrice .= WPage::renderBluePrint( 'prefcatalog', $buttonO );
				else $product->convertedPrice = WPage::renderBluePrint( 'prefcatalog', $buttonO );

			}		}

				if ( empty($tagParams->showNoName) ) $product->linkName = '<a href="'. $product->pageLink .'">'.$product->name.'</a>';
		else $product->linkName = '';
				if ( $this->unpublishedItem ) {
			if ( $product->publish <= 0 || $product->publishstart > time()				 || ( $product->publishend != 0 && $product->publishend < time() ) ) {
				$product->linkName .= '<span class="unpublishedItem"> '  . WText::t('1242282416HAQR') .'</span>';
			}			if ( $product->blocked >= 1  ) $product->linkName .= '<span class="blockedItem"> '  . WText::t('1337906253JAEU') .'</span>';
		}
									if ( empty($tagParams->showNoRating) ) {					static $ratingC = null;
				if ( !isset($ratingC) ) $ratingC = WClass::get('output.rating');
				$ratingC->rating = ( !empty($product->votes) ) ? $product->score / $product->votes : 0;
				$ratingC->type = 0;					$form = null;
				$product->rating = $ratingC->createHTMLRating( $form, true );				}
			if ( !empty($tagParams->showReview) ) {

				$objButtonO = WPage::newBluePrint( 'prefcatalog' );
				$objButtonO->type = 'buttonReviewInCatalogPage';
				$objButtonO->link = $product->pageLink.'#comment';

								if ( empty($product->nbreviews) ) {
					$objButtonO->text = WText::t('1307375391NFZQ');
				} else {
					if ( $product->nbreviews==1 ) $objButtonO->text = WText::t('1304253943KWEJ') . ' <span class="badge">' . $product->nbreviews . '</span>';
					else $objButtonO->text = WText::t('1257243218GPNH') . ' <span class="badge">' . $product->nbreviews . '</span>';

				}
				$product->nbReviews = WPage::renderBluePrint( 'prefcatalog', $objButtonO );

			}

		if ( !empty($tagParams->showQuestion) ) {
						$catalogItemPageC = WClass::get( 'catalog.itempage' );
			$product->askQuestionLink = $catalogItemPageC->askQuestion( $product->vendid );
		}
		if ( !empty($product->targettotal) ) {

			 $progressO = WPage::newBluePrint( 'progressbar' );
			$progressO->targetTotal = $product->targettotal;
			$progressO->target = $product->target;
			$product->progressBar = WPage::renderBluePrint( 'progressbar', $progressO );

		}

				if ( !empty($tagParams->showQuantity) && !empty($tagParams->showPrice) ) {

			if ( $product->hasRoleViewPrice ) {
				$controller=null;
				$controller->controller='catalog';
				$controller->task='pricequantity';
				$controller->yid = 'catalog_price_quantity';
				$controller->wid = WExtension::get( 'catalog', 'wid');
				$params = new stdClass;
				$params->_eid = $product->pid;

				$form = WView::getHTML( 'catalog_price_quantity' , $controller, $params );
				$viewHTML = $form->make();

				$product->quantity = $viewHTML;

			}
		}
				if ( !empty($product->previewid) ) {

						$filesMediaC = WClass::get( 'files.media' );
						$previewElement = new stdClass;
    		if ( !empty( $tagParams->imageWidth ) ) $previewElement->imageWidth = $tagParams->imageWidth;
    		if ( !empty( $tagParams->imageHeight ) ) $previewElement->imageHeight = $tagParams->imageHeight;
    		if ( !empty($product->pageLink) ) $previewElement->link = $product->pageLink;
			$product->preview = $filesMediaC->renderHTML( $product->previewid, $previewElement ); 			$product->previewType = ucfirst( $filesMediaC->fileType );
			$product->mediaID = $filesMediaC->getMediaID( $product->previewid );
			$product->playerType = $filesMediaC->getPlayerType();

		}
				if ( !empty($tagParams->showReadMore) && empty($tagParams->showDesc) ) {
			$objButtonO = WPage::newBluePrint( 'prefcatalog' );
			$objButtonO->type = 'buttonDetailsInCatalogPage';
			$objButtonO->text = WText::t('1206961936HCWR');
			$objButtonO->link = $product->pageLink;
			$product->readMoreLink = WPage::renderBluePrint( 'prefcatalog', $objButtonO );
		}
				if ( WPref::load( 'PCATALOG_NODE_NEWITEMUSE' ) ) {
			$product->newItem = ( ($product->created + PCATALOG_NODE_NEWPERIOD * 86400 ) >= time() ) ? WText::t('1206732361LXFD') : '';
			WPage::addCSSFile( 'node/catalog/css/badge.css' );
		}
				if ( WPref::load( 'PCATALOG_NODE_FEATUREDUSE' ) ) {
			if ( $product->featured ) {
				$product->featured = WText::t('1405139915GGBP');
				WPage::addCSSFile( 'node/catalog/css/badge.css' );
			}		} else {
			$product->featured = false;
		}

		if ( !empty($tagParams->editable) ) {
			if ( $this->_canEditItem( $product->vendid ) ) {
				$editArea = WPref::load( 'PCATALOG_NODE_EDITITEMLOCATION' );
				$product->editButton = WText::t('1206732361LXFE');
				$product->deleteButton = WText::t('1206732372QTKL');
				$extraSpace = ( $editArea != 'both' ) ? '&space=' . $editArea : '';

					$product->editButtonLink = WPage::routeURL( 'controller=item&task=edit&eid=' . $product->pid, 'home', 'popup', false, false, null, true );

				$product->deleteButtonLink = WPage::routeURL( 'controller=item&task=deleteall&eid=' . $product->pid . '&returnback=true' . $extraSpace, 'home' );				}
		}

				if ( !empty($product->categoryName) ) {
			$linkCat = WPage::routeURL( 'controller=catalog&task=category&eid=' . $product->categoryID, 'home' );
			$product->categoryName = WText::t('1206732411EGQO') . ': <a href="' . $linkCat . '">' . $product->categoryName . '</a>';
		}
		if ( !empty($tagParams->borderShow) ) $product->borderShow = true;
		if ( empty($product->borderColor) ) $product->borderColor = ( !empty($tagParams->borderColor) ? $tagParams->borderColor : 'default' );


				if ( !empty($product->syndicateVendid) ) {
						$vendorHelperC = WClass::get( 'vendor.helper' );
			$vendorInfo = $vendorHelperC->getVendor( $product->syndicateVendid );
			$product->syndicateVendorName = ' ' . WText::t('1217326499HUVQ') . ' <a href="' . WPages::link( 'controller=vendors&task=home&eid=' . $product->syndicateVendid ) . '">' . $vendorInfo->name . '</a>';
		}

	}





	function setHeader() {

		$header = new stdClass;
		$header->name = WText::t('1206732392OZVB');
		$header->price = WText::t('1206961911NYAN');
		$header->photo = WText::t('1303968056PMZJ');
		$header->description = WText::t('1206732392OZVG');
		$header->rating = WText::t('1246243851IGLH');
		$header->vendorBy = WText::t('1213117657LKZK');

		return $header;

	}








	protected function _formatPrice($price,&$product,$curid) {
		static $productTaxC = null;
		if ( !isset( $productTaxC ) ) $productTaxC = WObject::get( 'product.tax' );

		static $basketHelperC=null;
		if ( empty($basketHelperC) ) $basketHelperC = WClass::get('basket.helper',null,'class',false);

		if ( !empty($basketHelperC) ) $productTaxC->setVendorID( $basketHelperC->getVendorID( $product->vendid ) );
		else return '';

		if ( !empty($productTaxC) ) return $productTaxC->formatPriceWithTax( $price, $product, $curid );
		else return '';

	}












	private function _extraFieldLoad(&$productM,&$pO,$typeFromprodtypid,$asIDProduct,$asID,$hasTranslation=true) {

		$designModelfieldsC = WClass::get( 'design.modelfields' );
		$allColumnsA = $SearchableFieldsA = $designModelfieldsC->getAllFields( 'item' );
		if ( !empty($allColumnsA) ) {
			$productM->select( $allColumnsA, $asIDProduct );
		}
	}





	private function _extraFieldSearch(&$productM,&$pO,$typeFromprodtypid,$asIDProduct,$asID,$hasTranslation=true) {

		if ( empty($pO->search) ) return false;

		$seachedTewrmsA = array();
		$outputHelperC = WClass::get( 'output.helper' );
		$seachedTermsA = $outputHelperC->convertSearchTerms( $pO->search );

		if ( !empty($seachedTermsA) ) {
			if ( !$hasTranslation ) {
				$translationAsID = $this->_setLanguageQuery( $productM, $pO, $asIDProduct, $asID );
			} else {
				$translationAsID = $asID+1;
			}			$productM->whereSearch( array('name', 'introduction', 'description' ), $seachedTermsA, $translationAsID );

			if ( !empty( $typeFromprodtypid ) ) {
				$itemTypeT = WType::get( 'item.designation' );
				$designationName = $itemTypeT->getName( $typeFromprodtypid );
				$designationNameTrans = $designationName . 'trans';
			} else {
				$designationName = true;
				$designationNameTrans = true;
			}
						$designModelfieldsC = WClass::get( 'design.modelfields' );
			$SearchableFieldsA = $designModelfieldsC->getAllSearchableFields( 'item', $designationName );
			if ( !empty($SearchableFieldsA) ) {
				$productM->whereSearch( $SearchableFieldsA, $seachedTermsA, $asIDProduct );
			}
						$SearchableFieldsA = $designModelfieldsC->getAllSearchableFields( 'itemtrans', $designationNameTrans );
			if ( !empty($SearchableFieldsA) ) {
				$productM->whereSearch( $SearchableFieldsA, $seachedTermsA, $translationAsID );
			}
		} else {
			$pO->search = false;
		}
	}









	private function _setLanguageQuery(&$productM,$pO,$asIDProduct,$asID) {

		if ( !empty( self::$_translationAsID ) ) return self::$_translationAsID;

		self::$_translationAsID = $asID+1;							$productM->makeLJ( 'itemtrans', 'pid', 'pid', $asIDProduct, self::$_translationAsID );			$productM->whereLanguage( self::$_translationAsID, $this->_myLGID );												
		return self::$_translationAsID;

	}








	private function _leftJoinCategory(&$productM,&$asID,$asIDProduct) {

		if ( self::$_leftJoinCategroryOnlyOnce ) {
			$asID++;
			$productM->makeLJ( 'item.categoryitem', 'pid', 'pid', $asIDProduct, $asID );	
			self::$_leftJoinCategroryOnlyOnce = false;
		}
		return true;
	}






	private function _canEditItem($vendid) {
		static $myVendid = null;
		static $isStoreManager = null;

		if ( empty($vendid) ) return false;

		if ( !isset($isStoreManager) ) {
			$roleHelper = WRole::get();
			$isStoreManager = WRole::hasRole( 'storemanager' );
		}
		if ( $isStoreManager ) return true;


		if ( !isset($myVendid) ) {
			$roleHelper = WRole::get();
			$myVendid = 0;
			if ( WRole::hasRole( 'vendor' ) ) {
				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
				$uid = WUser::get('uid');
				$myVendid = $vendorHelperC->getVendorID( $uid );
			}
		}
		return ( $myVendid == $vendid ) ? true : false;
		return $canEdit;

	}




	private function _countItems($pO) {

		$countColumn = 'pid';
		$useCount = true;
		$typeFromprodtypid = 0;

				if ( !empty($pO->type) ) {
			$productT = WType::get( 'item.designation' );
			$type = strtolower( $productT->getValue( strtolower($pO->type), false ) );
		} else {
			if ( !empty( $pO->prodtypid ) ) {
				if ( !isset($itemTypeC) ) $itemTypeC = WClass::get('item.type');
				if ( is_numeric($pO->prodtypid) ) $typeFromprodtypid = $itemTypeC->loadData( $pO->prodtypid, 'type'  );
			}			$type = 0;			}
				if ( !empty( $pO->relatedPID ) ) {	
			$productM = WModel::get( 'item.related' );
			$productM->makeLJ( 'item', 'relpid', 'pid', 0, 1 );
			$productM->whereE( 'pid', $pO->relatedPID, 0 );
			$countColumn = 'relpid';
			$countColumnAs = 0;
			$productM->groupBy( 'relpid', 0 );
			$asIDProduct = 1;

		} elseif ( !empty( $pO->bundlePID ) ) {	
			$productM = WModel::get( 'item.bundle' );
			$productM->makeLJ( 'item', 'ref_pid', 'pid', 0, 1 );
			$productM->whereE( 'pid', $pO->bundlePID, 0 );
			$productM->groupBy( 'ref_pid', 0 );
			$countColumnAs = 0;
			$asIDProduct = 1;
		} elseif ( !empty( $pO->sorting ) && $pO->sorting == 'justsold' ) {	
			$productM = WModel::get( 'order.items' );
			$productM->makeLJ( 'order', 'oid', 'oid', 0, 1 );
			$productM->makeLJ( 'item', 'pid', 'pid', 0, 2 );
			$productM->whereE( 'ostatusid', 20, 1 ); 			$countColumnAs = 2;
			$asIDProduct = 2;
			$pO->dontShowFree = true;				$useCount = false;
		} elseif ( !empty( $pO->sorting ) && ( $pO->sorting == 'recentlyviewed' || $pO->sorting == 'mytopviewed' ) ) {							$productM = WModel::get( 'item.viewed' );
			$productM->groupBy( 'pid' );
			$productM->makeLJ( 'item', 'pid', 'pid', 0, 1 );
			$logUID = WUser::get( 'uid' );
			if ( !empty( $logUID ) ) {
				$productM->whereE( 'uid', $logUID );
			} else {
				$productM->whereE( 'cookieid', WGlobals::getCookieUser() );
			}			$asIDProduct = 1;

		} elseif ( WExtension::exist( 'auction.node' ) && $this->_paidItem && ( !empty( $pO->showBid ) || !empty($pO->showcountdown) ) && (empty($type) || $type== 11) && ( empty( $pO->prodtypid ) || (!empty($typeFromprodtypid) && $typeFromprodtypid ==11 ) ) ) {

			$productM = WModel::get( 'auction' );
			$productM->makeLJ( 'auction.bids', 'pid', 'pid' );
			$productM->openBracket(1);
			$productM->where( 'publish', '!=', '-1', 1 );
			$productM->operator( 'OR' );
			$productM->isNULL( 'publish', true, 1 );
			$productM->closeBracket(1);
			$asIDProduct = 0;
			$asID = 1;
		} else {
			$productM = WModel::get( 'item' );
			$asIDProduct = 0;
		}
		if ( !isset( $asID) ) $asID = $asIDProduct;
		if ( !isset($countColumnAs) ) $countColumnAs = $asIDProduct;
		if ($useCount) $productM->select( $countColumn, $countColumnAs, 'total', 'count');
		else $productM->select( $countColumn, $countColumnAs );

		if ( !empty($pO->prodtypid) ) {
			if ( is_numeric($pO->prodtypid) ) {
				$productM->whereE( 'prodtypid', $pO->prodtypid, $asIDProduct );
			} else {
								if ( !isset($itemTypeC) ) $itemTypeC = WClass::get('item.type');
				$typeA = $itemTypeC->loadAllTypesFromDesignation( $pO->prodtypid );
				if (!empty($typeA) ) $productM->whereIn( 'prodtypid', $typeA, $asIDProduct );
			}
		} elseif ( !empty($pO->itemType) ) {
			if ( is_numeric($pO->itemType) ) $productM->whereE( 'prodtypid', $pO->itemType, $asID );
			else {
				$asID++;
				$productM->makeLJ( 'item.type', 'prodtypid', 'prodtypid', $asIDProduct, $asID );					$productM->whereE( 'namekey', trim($pO->itemType), $asID );
			}		} elseif ( !empty($pO->type) ) {				$productT = WType::get( 'item.designation' );
			$type = $productT->getValue( $pO->type, false );
			if ( !empty($type) ) {
				$asID++;
				$productM->makeLJ( 'item.type', 'prodtypid', 'prodtypid', $asIDProduct, $asID );					$productM->whereE( 'type', $type, $asID );									}		}
				
		if ( ( !empty($pO->vendor) ) && WExtension::exist( 'vendors.node' ) ) {
			$asID++;
			$vendorasID = $asID;

			$productM->makeLJ( 'vendor', 'vendid', 'vendid', $asIDProduct, $asID );							if ( empty($pO->editable) ) $productM->whereE( 'publish', 1, $asID );

			if ( !empty($pO->vendor) ) {

				$allowSyndicate = WPref::load( 'PCATALOG_NODE_ALLOWSYNDICATION' );
				if ( $allowSyndicate ) {
					$productM->openBracket();
				}
				if ( is_numeric( $pO->vendor ) ) {
					$productM->whereE( 'vendid', $pO->vendor );
				} else {
					$productM->whereE( 'namekey', $pO->vendor, $asID );
				}
				if ( $allowSyndicate ) {
					$asID++;
					$productM->operator( 'OR' );
					$productM->makeLJ( 'item.syndication', 'pid', 'pid', $asIDProduct, $asID );					$productM->whereE( 'vendid', $pO->vendor, $asID );
					$productM->closeBracket();
				}
			}

		}

				if ( !empty( $pO->category ) && is_numeric($pO->category) ) {

			if ( !empty($pO->showSubCategory) ) {
								$productCategoryM = WModel::get( 'item.category' );
				$allSubCategoriesA = $productCategoryM->getChildNode( $pO->category, true );

				if ( !empty($allSubCategoriesA) ) {
					$asID++;
					$productM->makeLJ( 'item.categoryitem', 'pid', 'pid', $asIDProduct, $asID );						$productM->whereIn( 'catid', $allSubCategoriesA, $asID );
				}
			} else {
				$asID++;
				$productM->makeLJ( 'item.categoryitem', 'pid', 'pid', $asIDProduct, $asID );					$productM->whereE( 'catid', $pO->category, $asID );

			}
		}
		
			if ( !empty($pO->dontShowFree) && $this->_paidItem ) {
				$asID++;
				$productM->makeLJ( 'item.type', 'prodtypid', 'prodtypid', $asIDProduct, $asID );	
								$auctionExist = WExtension::exist( 'auction.node' );
				if ( $auctionExist ) {
															$isAuction = false;
					$hasDefinedType = false;
					if ( !empty( $pO->type ) && 'auction'==$pO->type ) {
						$isAuction = true;
						$hasDefinedType = true;
					} elseif ( !empty($pO->prodtypid) || !empty($pO->itemType) ) {						if ( !isset($itemTypeC) ) $itemTypeC = WClass::get('item.type');

						if ( is_numeric($pO->prodtypid) ) $newType = $itemTypeC->loadData( ( !empty($pO->prodtypid) ? $pO->prodtypid : $pO->itemType ), 'type'  );
						else $newType = $pO->prodtypid;

						if ( !empty( $newType ) && 'auction'==$newType ) $isAuction = true;
						$hasDefinedType = true;
					}
					if ( !$isAuction ) {
						$productPricetypeC = WClass::get( 'product.pricetype', null, 'class', false );
						if ( ! empty($productPricetypeC) ) $freePriceIDA = $productPricetypeC->getPriceTypeID( 'free' );

						if ( !empty( $freePriceIDA ) ) {
							if ( $hasDefinedType ) {
								$productM->whereIn( 'priceid', $freePriceIDA, $asIDProduct, true );	
							} else {																	$productM->whereIn( 'priceid', $freePriceIDA, $asIDProduct, true, 1, 0, 0 );
								$productM->where( 'price', '=', '0', $asIDProduct, null, 1, 0, 1 );
								$productM->whereE( 'type', 11, $asID, null, 0, 2, 0 );								}						}
					}					
				} else {
					$productPricetypeC = WClass::get( 'product.pricetype', null, 'class', false );
					if ( ! empty($productPricetypeC) ) $freePriceIDA = $productPricetypeC->getPriceTypeID( 'free' );
					if ( !empty( $freePriceIDA ) ) $productM->whereIn( 'priceid', $freePriceIDA, $asIDProduct, true );
				}
			}



				if ( WUser::isRegistered() ) $this->_checkIfIAMaVendor();
		if ( $this->_IamAvendor ) $productM->openBracket( 2 );
				$productM->where( 'publishstart', '<=', time(), $asIDProduct );
		$productM->where( 'publishend', '=', 0, $asIDProduct, null, 1, 0, 0  );
		$productM->where( 'publishend', '>=', time(), $asIDProduct, null, 0, 1, 1  );

		if ( empty($pO->editable) ) {			$productM->whereE( 'publish', 1, $asIDProduct );
			$productM->whereE( 'blocked', 0, $asIDProduct );
		}		if ( $this->_IamAvendor ) {
			$productM->closeBracket( 1 );
			$productM->whereE( 'vendid', $this->_vendid, $asIDProduct, null, 0, 1, 1 );
		}
		$productM->checkAccess( $asIDProduct );

				if ( !empty($pO->radius) && $pO->radius>0 ) {
			static $addressDistanceC = null;
			if ( !isset($addressDistanceC) ) $addressDistanceC = WClass::get( 'address.distance' );
			if ( !empty( $pO->location ) ) {
				$geoCode = $addressDistanceC->getMixMaxLongLatFromLocationRadius( $pO->location, $pO->radius );
			} elseif ( !empty($pO->longitude) && $pO->longitude !=0 && !empty($pO->latitude) && $pO->latitude !=0 ) {
				$geoCode = $addressDistanceC->getMixMaxLongLatFromCoordinateRadius( $pO->longitude, $pO->latitude, $pO->radius );
			}
			if ( !empty($geoCode) ) {
								$radiusDegree = (int)$pO->radius;
				$productM->select( array( 'longitude', 'latitude', 'location' ), $asIDProduct );
				$productM->where( 'longitude', '<=', $geoCode->maxCoordinate->longitude, $asIDProduct );
				$productM->where( 'longitude', '>=', $geoCode->minCoordinate->longitude, $asIDProduct );
				$productM->where( 'latitude', '<=', $geoCode->maxCoordinate->latitude, $asIDProduct );
				$productM->where( 'latitude', '>=', $geoCode->minCoordinate->latitude, $asIDProduct );
			}
		}

		if ( !empty( $pO->getadvsearch ) ) {
									$catalogAdvFilterC = WClass::get( 'catalog.advfilter' );
			$this->_advSeachableA = $catalogAdvFilterC->getItemFitlers();
		}

			if ( !empty( $this->_advSeachableA ) ) {
				WLoadFile( 'output.doc.document', JOOBI_DS_NODE );
				$sidItem = WModel::get( 'item', 'sid' );
				$sidItemTrans = WModel::get( 'itemtrans', 'sid' );
				foreach( $this->_advSeachableA as $oneSearch ) {
					$columnInstance = Output_Doc_Document::loadListingElement( $oneSearch );
					if ( in_array( $oneSearch->modelID , array( $sidItem, $sidItemTrans ) ) ) {
						if ( $oneSearch->translation && empty($translationAsID) ) {
							$asID++;
							$translationAsID = $asID;
							$productM->makeLJ( 'itemtrans', 'pid', 'pid', $asIDProduct, $translationAsID );								$productM->whereLanguage( $translationAsID, $this->_myLGID );																			$oneSearch->asi = $translationAsID;
						} else {
							$oneSearch->asi = ( $oneSearch->translation ? $translationAsID : $asIDProduct );
						}					} elseif ( 'product.option' == $oneSearch->type ) {
						$oneSearch->map = 'groupkey';
						if ( empty($optionValueasID) ) {
							$asID++;
							$optionValueasID = $asID;
							$productM->makeLJ( 'product.poptions', 'pid', 'pid', $asIDProduct, $optionValueasID );
							$asID++;
							$productM->makeLJ( 'product.option', 'opid', 'opid', $optionValueasID, $optionValueasID+1 );
							$asID++;
							$productM->makeLJ( 'product.optionvalues', 'opid', 'opid', $optionValueasID+1, $optionValueasID+2 );
							$optionValueasID = $optionValueasID+2;
						}						$oneSearch->asi = $optionValueasID;

					} else {

						if ( empty($vendorasID) ) {
							$asID++;
							$vendorasID = $asID;
							$productM->makeLJ( 'vendor', 'vendid', 'vendid', $asIDProduct, $vendorasID );
						}
						if ( $oneSearch->translation && empty($vendorasTransID) ) {
							$productM->makeLJ( 'vendortrans', 'vendid', 'vendid', $vendorasID, $asID+1 );
							$asID++;
							$productM->whereLanguage( $asID, $this->_myLGID );
							$vendorasTransID = $asID;
						}						$oneSearch->asi = ( $oneSearch->translation ? $vendorasTransID : $vendorasID );
					}					$columnInstance->searchQuery( $productM, $oneSearch, $oneSearch->value, 'AND' );
				}			}


				$this->_extraFieldSearch( $productM, $pO, $typeFromprodtypid, $asIDProduct, $asID, false );


		if ( $useCount ) {
			$coutnTotal = $productM->load( 'lr' );
		} else {				$productM->setLimit( 5000 );			$loadResultCount = $productM->load( 'lra' );
			$coutnTotal = count($loadResultCount);
		}
				self::$_translationAsID = 0;

		return $coutnTotal;

	}






	private function _columnFeaturedExist($column) {
		static $existA = array();

		if ( !isset( $existA[$column] ) ) {
			$itemFeaturedM = WModel::get( 'item.featureditem' );
			$existA[$column] = $itemFeaturedM->columnExists( $column );
		}
		return $existA[$column];

	}





	private function _checkIfIAMaVendor() {

		$this->_IamAvendor = false;
		$this->unpublishedItem = false;
				if ( WExtension::exist( 'vendors.node' ) ) {
						$roleHelper = WRole::get();
			if ( WRole::hasRole( 'vendor' ) ) {
				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
				$uid = WUser::get('uid');
				$this->_vendid = $vendorHelperC->getVendorID( $uid );
				if ( !empty($this->_vendid) ) {
					$this->_IamAvendor = true;
					$this->unpublishedItem = true;
				}			}
		}
	}






private function _checkLoginRequired() {

	$login = false;
	if ( WPref::load( 'PBASKET_NODE_LOGINBEFORECHECKOUT' ) ) {
				$login = ! WUser::isRegistered();
	}
	return $login;

}

}