<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_category_controller extends WController {

	private $catid = null;





	function category() {


		$this->catid = WGlobals::getEID();



		if ( empty($this->catid) ) {
			$this->catid = 1;
			WGlobals::setEID( 1 );
		}
		WGlobals::setSession( 'pageLocation', 'lastPageItem', APIPage::cmsGetItemId() );
		WGlobals::setSession( 'pageLocation', 'lastPage', 'controller=catalog&task=category&eid='. $this->catid );

		return true;


	}





	protected function beforeDisplay() {

				$this->_hits();

		return true;

	}




	private function _hits() {

		if ( empty($this->catid) ) return false;

		$isRegistered = WUser::isRegistered();
		if ( $isRegistered ) $viewerUID = WUser::get('uid');
		else $viewerUID = 0;

				$alreadyCounted = WGlobals::getSession( 'counter', 'categoryUserCount-'.$viewerUID .'-' . $this->catid, 0 );
		if ( !empty($alreadyCounted) ) return true;

		$authorUID = $this->layout->getValue( 'author', 'item.category' );
		$uidUID = $this->layout->getValue( 'uid', 'item.category' );

				if ( $viewerUID != $authorUID && $viewerUID  != $uidUID ) {				$productM = WModel::get( 'item.category' );
			$productM->whereE( 'catid', $this->catid );
			$productM->updatePlus( 'hits', 1 );
			$productM->update();

			WGlobals::setSession( 'counter', 'categoryUserCount-'.$viewerUID .'-' . $this->catid, '1' );

						if ( $isRegistered ) {
								$itemWallC = WClass::get( 'item.wall' );
				if ( $itemWallC->available() ) {

					$content = '';
					$image = '';
					$imageFile = $this->layout->getValue( 'filid');
					if ( !empty($imageFile) ) {
						$this->element = new stdClass;
						$this->element->imageWidth = 90;
						$this->element->imageHeight = 90;
												$filesMediaC = WClass::get( 'files.media' );
						$image = $filesMediaC->renderHTML( $imageFile, $this->element );
					}
					$description = $this->layout->getValue( 'description' );
					if ( !empty($description) ) {
						$emailHelperC = WClass::get( 'email.conversion' );
						$content .= $emailHelperC->smartHTMLSize( $description, 150, false, false, false, true );
					}
					$extraLink = '';
					if ( WExtension::exist( 'affiliate.node') ) {
						$affiliateHelperC = WClass::get( 'affiliate.helper', null, 'class', false );
						$extraLink = $affiliateHelperC->addAffilateToLink();
					}
					$post = new stdClass;
					$pageID = APIPage::cmsGetItemId();
					$link = WPage::routeURL( 'controller=catalog&task=category&eid=' . $this->catid . $extraLink, 'home', false, false, $pageID );
					$CATEGORY_NAME = '<a href="' . $link . '">' . $this->layout->getValue( 'name', 'item.categorytrans' ) . '</a>';

					$post->callingFunction = 'wallcategoryviews';
					$post->eid = $this->catid;
					$post->model = 'item.category';
					$post->node = 'catalog.node';
					$post->context = 'item.category';
					$post->image = $image;
					$post->link = $link;
					$post->content = $content;
					$post->title = str_replace(array('$CATEGORY_NAME'), array($CATEGORY_NAME),WText::t('1338493593SACR'));
					$post->titleTR = WText::translateNone( '{tag:actor} visited category ' . $CATEGORY_NAME . '{multiple} {count} times{/multiple}.' );
					$post->titleVAR = '$CATEGORY_NAME';

					$itemWallC->postWall( $post );

				}
			}
		}

		return true;

	}
}