<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Wishlist_my_items_add_controller extends WController {

	private $eid = 0;
	private $wishListType = 0; 	private $wishListTypeHundreded = 0; 
	private $name = '';	
		private $introduction = '';
		private $description = '';
		private $filid = '';

function add() {


	$this->eid = WGlobals::get( 'socialEID', '', null, 'int' );
	$this->wishListType = WGlobals::get( 'favoriteType', '', null, 'int' );




	if ( !empty($this->eid) && !empty($this->wishListType) ) {


		$uid = WUser::get('uid');

		
		$wishlistM = WModel::get( 'wishlist' );

		$wishlistM->whereE( 'authoruid', $uid );

		$wishlistM->whereE( 'type', $this->wishListType );
		$wlid = $wishlistM->load( 'lr', 'wlid' );


				if ( empty($wlid) ) {
			$wishlistCreateC = WClass::get( 'wishlist.create' );
			$wlid = $wishlistCreateC->newList( $uid, $this->wishListType );
			if ( empty($wlid) ) $this->_createButton();		}
				$tempType = $this->wishListType % 100;
		$this->wishListTypeHundreded = $this->wishListType - $tempType;

				$wishlistProductsM = WModel::get( 'wishlist.items' );

		$typeOfTag = '';
		switch( $this->wishListTypeHundreded ) {
			case 100:					$typeOfTag = 'category';
				$wishlistProductsM->setVal( 'catid', $this->eid );
				$categoryO = $this->_getItemName( 'item.category', 'catid' );
				$this->name = $categoryO->name;
				$this->description = $categoryO->description;
				$this->filid = $categoryO->filid;
				break;
			case 200:					$typeOfTag = 'vendor';
				$wishlistProductsM->setVal( 'vendid', $this->eid );
				$vendorC = WClass::get( 'vendor.helper', null, 'class', false );
				$this->name = $vendorC->getVendor( $this->eid, 'name' );
				$this->description = $vendorC->getVendor( $this->eid, 'description' );
				$this->filid = $vendorC->getVendor( $this->eid, 'filid' );
				break;
			default:				case 0:
				$typeOfTag = 'item';
				$itemO = $this->_getItemName( 'item', 'pid' );
				$this->name = $itemO->name;
				$this->description = $itemO->description;
				$this->introduction = $itemO->introduction;
				$itemHelperC = WClass::get( 'item.helper' );
				$this->filid = $itemHelperC->getDefaultImageID( $this->eid );
				$wishlistProductsM->setVal( 'pid', $this->eid );
				break;
		}
				$wishlistProductsM->setVal( 'name', $this->name );
		$wishlistProductsM->setVal( 'wlid', $wlid );
		$wishlistProductsM->setVal( 'created', time() );
		$wishlistProductsM->setVal( 'publish', 1 );
		$status = $wishlistProductsM->insertIgnore();

		if ( $status ) {


						if ( in_array( $tempType, array( 40, 45 ) ) ) {
								$otherOne = ( ( $tempType == 45 ) ? 40 : 45 ) + $this->wishListTypeHundreded;

				$wishlistM->whereE( 'authoruid', $uid );
				$wishlistM->whereE( 'type', $otherOne );
				$otherWLID = $wishlistM->load( 'lr', 'wlid' );

				if ( !empty($otherWLID) ) {
					switch( $this->wishListTypeHundreded ) {
						case 100:								$typeOfTag = 'category';
							$wishlistProductsM->whereE( 'catid', $this->eid );
							break;
						case 200:								$typeOfTag = 'vendor';
							$wishlistProductsM->whereE( 'vendid', $this->eid );
							break;
						default:							case 0:
							$typeOfTag = 'item';
							$wishlistProductsM->whereE( 'pid', $this->eid );
							break;
					}										$wishlistProductsM->whereE( 'wlid', $otherWLID );
					$wishlistProductsM->delete();
				}
			}
			if ( !defined('PCATALOG_NODE_WISHLISTMESSAGE') ) WPref::get( 'catalog.node' );
			$wishlistMessage = PCATALOG_NODE_WISHLISTMESSAGE;
			if ( $wishlistMessage ) {
				$message = WMessage::get();
				$text = WText::t('1307794857RUJT');
				$wishlistP = WView::picklist( 'wishlist_type' );
				$wishlistObj = $wishlistP->displayOne( $this->wishListType );

				$link = WPage::routeURL( 'controller=wishlist-my-items&eid='. $wlid . '&titleheader='. $wishlistObj->content );
				$MYLIST = ' <a href="'.$link.'">' .$text. '</a>';
				$message->userS('1307794857RUJU',array('$MYLIST'=>$MYLIST));
			}
			$this->_publishWall();

		}


	}


	$this->_createButton();

	return true;


}






	private function _createButton() {


		$extreaType = WGlobals::get( 'favoriteExtraType', '', null, 'int' );
		$count = WGlobals::get( 'count', '', null, 'int' );
		$totalCount = $count + 1;

		$catalogShowproductC = WClass::get( 'catalog.showsocial' );
		$HTML = $catalogShowproductC->createButton( $this->eid, $this->wishListType, $totalCount, $extreaType, true );

		$message = WMessage::get();
		$message->cleanBuffer( 'Library_Progress_class' );

										echo $HTML;
				exit();


	}


	private function _publishWall() {

				$itemWallC = WClass::get( 'item.wall' );

		if ( $itemWallC->available() ) {

			$content = '';

			$extraLink = '';
			if ( WExtension::exist( 'affiliate.node') ) {
				$affiliateHelperC = WClass::get( 'affiliate.helper', null, 'class', false );
				$extraLink = $affiliateHelperC->addAffilateToLink();
			}
			$post = new stdClass;
			$pageID = APIPage::cmsGetItemId();
			switch( $this->wishListTypeHundreded ) {
				case 100:						$link = WPage::routeURL('controller=catalog&task=category&eid='.$this->eid . $extraLink, 'home', false, false, $pageID );
					$CATEGORY_NAME = '<a href="'. $link .'">'. $this->name .'</a>';
					$post->model = 'item.category';
					break;
				case 200:						$link = WPage::routeURL('controller=vendors&task=home&eid='.$this->eid . $extraLink, 'home', false, false, $pageID );
					$VENDOR_NAME = '<a href="'. $link .'">'. $this->name .'</a>';
					$post->model = 'vendors';
					break;
				default:					case 0:
					$link = WPage::routeURL('controller=catalog&task=show&eid='.$this->eid . $extraLink, 'home', false, false, $pageID );
					$ITEM_NAME = '<a href="'. $link .'">'. $this->name .'</a>';
					$post->model = 'item';
					break;
			}
			$callingFunction = 'walllist';
			switch( $this->wishListType ) {
				case 10:
					$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338493475RYON'));
					$callingFunction = 'wallitemwatch';
					$post->titleTR = WText::translateNone( '{tag:actor} watches item '.$ITEM_NAME.'.' );
					$post->titleVAR = '$ITEM_NAME';
					break;
				case 20:
					$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338493475RYOO'));
					$callingFunction = 'wallitemfavorite';
					$post->titleTR = WText::translateNone( '{tag:actor} favorites item '.$ITEM_NAME.'.' );
					$post->titleVAR = '$ITEM_NAME';
					break;
				case 30:
					$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338493475RYOP'));
					$callingFunction = 'wallitemwish';
					$post->titleTR = WText::translateNone( '{tag:actor} wishes to get item '.$ITEM_NAME.'.' );
					$post->titleVAR = '$ITEM_NAME';
					break;
				case 40:
					$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338493475RYOQ'));
					$callingFunction = 'wallitemlikedislike';
					$post->titleTR = WText::translateNone( '{tag:actor} likes item '.$ITEM_NAME.'.' );
					$post->titleVAR = '$ITEM_NAME';
					break;
				case 45:
					$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338493475RYOR'));
					$callingFunction = 'wallitemlikedislike';
					$post->titleTR = WText::translateNone( '{tag:actor} dislikes item '.$ITEM_NAME.'.' );
					$post->titleVAR = '$ITEM_NAME';
					break;

				case 110:
					$post->title = str_replace(array('$CATEGORY_NAME'), array($CATEGORY_NAME),WText::t('1338493475RYOS'));
					$callingFunction = 'wallcategorywatch';
					$post->titleTR = WText::translateNone( '{tag:actor} watches category '.$CATEGORY_NAME.'.' );
					$post->titleVAR = '$CATEGORY_NAME';
					break;
				case 120:
					$post->title = str_replace(array('$CATEGORY_NAME'), array($CATEGORY_NAME),WText::t('1338493475RYOT'));
					$callingFunction = 'wallcategoryfavorite';
					$post->titleTR = WText::translateNone( '{tag:actor} favorites category '.$CATEGORY_NAME.'.' );
					$post->titleVAR = '$CATEGORY_NAME';
					break;
				case 140:
					$post->title = str_replace(array('$CATEGORY_NAME'), array($CATEGORY_NAME),WText::t('1338493475RYOU'));
					$callingFunction = 'wallcategorylikedislike';
					$post->titleTR = WText::translateNone( '{tag:actor} likes category '.$CATEGORY_NAME.'.' );
					$post->titleVAR = '$CATEGORY_NAME';
					break;
				case 145:
					$post->title = str_replace(array('$CATEGORY_NAME'), array($CATEGORY_NAME),WText::t('1338493475RYOV'));
					$callingFunction = 'wallcategorylikedislike';
					$post->titleTR = WText::translateNone( '{tag:actor} dislikes category '.$CATEGORY_NAME.'.' );
					$post->titleVAR = '$CATEGORY_NAME';
					break;

				case 210:
					$post->title = str_replace(array('$VENDOR_NAME'), array($VENDOR_NAME),WText::t('1338493475RYOW'));
					$callingFunction = 'wallvendorwatch';
					$post->titleTR = WText::translateNone( '{tag:actor} watches vendor '.$VENDOR_NAME.'.' );
					$post->titleVAR = '$VENDOR_NAME';
					break;
				case 220:
					$post->title = str_replace(array('$VENDOR_NAME'), array($VENDOR_NAME),WText::t('1338493475RYOX'));
					$callingFunction = 'wallvendorfavorite';
					$post->titleTR = WText::translateNone( '{tag:actor} favorites vendor '.$VENDOR_NAME.'.' );
					$post->titleVAR = '$VENDOR_NAME';
					break;
				case 240:
					$post->title = str_replace(array('$VENDOR_NAME'), array($VENDOR_NAME),WText::t('1338493475RYOY'));
					$callingFunction = 'wallvendorlikedislike';
					$post->titleTR = WText::translateNone( '{tag:actor} likes vendor '.$VENDOR_NAME.'.' );
					$post->titleVAR = '$VENDOR_NAME';
					break;
				case 245:
					$post->title = str_replace(array('$VENDOR_NAME'), array($VENDOR_NAME),WText::t('1338493475RYOZ'));
					$callingFunction = 'wallvendorlikedislike';
					$post->titleTR = WText::translateNone( '{tag:actor} dislikes vendor '.$VENDOR_NAME.'.' );
					$post->titleVAR = '$VENDOR_NAME';
					break;
					default:
					$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338493475RYPA'));
					$post->titleTR = WText::translateNone( '{tag:actor} tagged item '.$ITEM_NAME.'.' );
					$post->titleVAR = '$ITEM_NAME';
					break;
			}
			$image = '';
			$imageFile = $this->filid;
			if ( !empty($imageFile) ) {
				$this->element = new stdClass;
				$this->element->imageWidth = 90;
				$this->element->imageHeight = 90;
								$filesMediaC = WClass::get( 'files.media' );
				$image = $filesMediaC->renderHTML( $imageFile, $this->element );
			}
			if ( !empty($this->introduction) ) {
				$emailHelperC = WClass::get( 'email.conversion' );
				$content .= $emailHelperC->smartHTMLSize( $this->introduction, 150, false, false, false, true );
			} elseif ( !empty($this->description) ) {
				$emailHelperC = WClass::get( 'email.conversion' );
				$content .= $emailHelperC->smartHTMLSize( $this->description, 150, false, false, false, true );
			}
			$post->eid = $this->eid;
			$post->callingFunction = $callingFunction;
			$post->image = $image;
			$post->content = $content;
			$post->node = 'wishlist.node';
			$post->link = $link;

			$itemWallC->postWall( $post );

		}
	}

	private function _getItemName($name,$pk) {

		$itemM = WModel::get( $name );
		$itemM->makeLJ( $name . 'trans', $pk );
		$itemM->whereE( $pk, $this->eid );
		$itemM->whereLanguage();
		if ( $name=='item' ) $itemM->select( 'introduction', 1 );
		$itemM->select( array( 'name', 'description' ), 1 );
		return $itemM->load( 'o', array( 'filid', $pk ) );

	}
}