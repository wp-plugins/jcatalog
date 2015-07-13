<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_show_controller extends WController {

	private $pid = null;



function show() {



	$this->pid = WGlobals::getEID();

		$profileKey = WGlobals::get( 'profilekey' );

		WGlobals::setSession( 'subscription', 'topupprofileid', $profileKey );



	
	if ( empty($this->pid) ) {

		$message = WMessage::get();

		$message->userW('1298350952HBRP');

		WPages::redirect( 'controller=catalog' );

	}
		$itemM = WModel::get( 'item' );
	$itemM->whereE( 'pid', $this->pid );
	$itemM->checkAccess();
	$itemInfoO = $itemM->load( 'o', array( 'publish', 'blocked', 'vendid', 'publishstart', 'publishend', 'rolid', 'prodtypid' ) );
	if ( empty($itemInfoO) ) return false;

		if ( WGlobals::checkCandy(50) ) {
		$whoCanView = $itemInfoO->rolid;
		if ( empty( $whoCanView ) || $whoCanView == 1 ) {
						$itemTypeC = WClass::get( 'item.type' );
			$whoCanView = $itemTypeC->loadData( $itemInfoO->prodtypid, 'rolid' );
			if ( empty($whoCanView) || $whoCanView == 1 ) {
				$whoCanView = WPref::load( 'PITEM_NODE_CAN_VIEW_ITEM' );
			}		}
		if ( !empty($whoCanView) ) {
			$itemAccessC = WClass::get( 'item.access' );
			$hasRole = $itemAccessC->haveAccess( $whoCanView );
		} else $hasRole = true;

		if ( !$hasRole ) {
			$message = WMessage::get();
			$message->userW('1329167048IDAO');
			WPages::redirect( 'controller=catalog' );
			return false;
		}
	}

	if ( empty( $itemInfoO->publish ) || !empty($itemInfoO->blocked )
	 || ( !empty($itemInfoO->publishstart) && $itemInfoO->publishstart > time() )
	 || ( !empty($itemInfoO->publishend) && $itemInfoO->publishend < time() ) ) {
		$restrictAccess = false;

		$message = WMessage::get();
		$uid = WUser::get('uid');
		if ( empty($uid) ) $restrictAccess = true;

				$roleHelper = WRole::get();
		$storeManagerRole = WRole::hasRole( 'storemanager' );
		$IAMaVendor = false;

		if ( !$storeManagerRole ) {	
			$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
			$vendid = $vendorHelperC->getVendorID( $uid );
			if ( !empty($itemInfoO->vendid) && $vendid != $itemInfoO->vendid ) $restrictAccess = true;
			$IAMaVendor = true;
		}
		if ( $restrictAccess ) {
			$message->userW('1329167048IDAO');
			return false;

		} else {
						if ( empty( $itemInfoO->publish ) ) $message->userN('1329167048IDAP');
			elseif ( !empty($itemInfoO->blocked ) ) $message->userN('1329167048IDAQ');
			elseif ( !empty($itemInfoO->publishstart) && $itemInfoO->publishstart > time() ) $message->userN('1329167048IDAR');
			elseif ( !empty($itemInfoO->publishend) && $itemInfoO->publishend < time() ) $message->userN('1329167048IDAS');

			if ( $IAMaVendor ) $message->userW('1329167048IDAT');
			else  $message->userW('1329167048IDAU');
		}
	}


		$itemLoadC = WClass::get( 'item.type' );
	$productDegination = $itemLoadC->loadTypeBasedOnPID( $this->pid, 'type' );

	WGlobals::setSession( 'pageLocation', 'lastPageItem', APIPage::cmsGetItemId() );
	WGlobals::setSession( 'pageLocation', 'lastPage', 'controller=catalog&task=show&eid='. $this->pid );




	
	switch ( $productDegination ) {

		case '1':				$this->setView( 'product_page_item' );
			break;
		case '7':				$this->setView( 'voucher_page_item' );

			break;
		case '5':				$this->setView( 'subscription_page_item' );
			break;

		case '11':				$this->setView( 'auction_page_item' );

			break;

		case '16':				$this->setView( 'classified_page_item' );
			break;
		case '17':	

			break;
		case '141':				$this->setView( 'download_page_item' );
			break;

		case '100':			case '101':			case '121':				$this->setView( 'item_page_item' );
			break;
		case '117':				$this->setView( 'documentation_page_item' );
			break;

		default:
			$this->userW('1298350856KAZP');

			$this->adminE( 'The item type is not defined! Item Designation: ' . $productDegination . ' Item ID (pid): '. $this->pid );
			WPages::redirect( 'controller=catalog' );

			break;

	}

		WGlobals::set( 'breadcrumbsCAtegoryLink', 'controller=catalog&task=category', 'global' );


	return parent::show();


}






	protected function beforeDisplay() {

				$this->_hits();

		return true;
	}









	private function _hits() {

		if ( empty($this->pid) ) return false;


		$isRegistered = WUser::isRegistered();

		if ( $isRegistered ) $viewerUID = WUser::get('uid');
		else $viewerUID = 0;

				$alreadyCounted = WGlobals::getSession( 'counter', 'itemUserCount-'.$viewerUID .'-' . $this->pid, 0 );
		if ( !empty($alreadyCounted) ) return true;

		$authorUID = $this->layout->getValue( 'author' );
		$uidUID = $this->layout->getValue( 'uid' );

		
		if ( $viewerUID != $authorUID && $viewerUID != $uidUID ) {	
			$productM = WModel::get( 'item' );
			$productM->whereE( 'pid', $this->pid );

			$productM->updatePlus( 'hits', 1 );

			$productM->update();

			WGlobals::setSession( 'counter', 'itemUserCount-'.$viewerUID .'-' . $this->pid, '1' );

						if ( $isRegistered ) {
								$itemWallC = WClass::get( 'item.wall' );
				if ( $itemWallC->available() ) {

					$extraLink = '';
					if ( WExtension::exist( 'affiliate.node') ) {
						$affiliateHelperC = WClass::get( 'affiliate.helper', null, 'class', false );
						$extraLink = $affiliateHelperC->addAffilateToLink();
					}
					$pageID = APIPage::cmsGetItemId();
					$link = WPage::routeURL( 'controller=catalog&task=show&eid=' . $this->pid . $extraLink, 'home', false, false, $pageID );
					$ITEM_NAME = '<a href="'. $link .'">'.$this->layout->getValue( 'name' ).'</a>';

					$content = '';
					$image = '';
					$imageFile = WGlobals::get( 'image-show-filid', 0 );
					if ( !empty($imageFile) ) {
						$this->element = new stdClass;
						$this->element->imageWidth = 90;
						$this->element->imageHeight = 90;
												$filesMediaC = WClass::get( 'files.media' );
						$image = $filesMediaC->renderHTML( $imageFile, $this->element );

					}
					$intriduction = $this->layout->getValue( 'introduction' );
					if ( !empty($intriduction) ) {
						$emailHelperC = WClass::get( 'email.conversion' );
						$content .= $emailHelperC->smartHTMLSize( $intriduction, 150, false, false, false, true );
					} else {
						$description = $this->layout->getValue( 'description' );
						if ( !empty($description) ) {
							$emailHelperC = WClass::get( 'email.conversion' );
							$content .= $emailHelperC->smartHTMLSize( $description, 150, false, false, false, true );
						}					}
					$post = new stdClass;
					$post->callingFunction = 'wallitemviews';
					$post->eid = $this->pid;
					$post->model = 'item';
					$post->node = 'catalog.node';
					$post->context = 'item';
					$post->image = $image;
					$post->link = $link;
					$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338493594RCKG'));
					$post->content = $content;
					$post->titleTR = WText::translateNone( '{tag:actor} visited item ' . $ITEM_NAME . '{multiple} {count} times{/multiple}.' );
					$post->titleVAR = '$ITEM_NAME';

					$itemWallC->postWall( $post );

				}
			}

		}


		return true;


	}


}