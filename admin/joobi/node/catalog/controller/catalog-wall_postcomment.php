<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_wall_postcomment_controller extends WController {

function postcomment() {


	$itemWallC = WClass::get( 'item.wall' );

	if ( $itemWallC->available() ) {


		$eid = WController::getFormValue( 'pid' );
		$item = WController::getFormValue( 'item' );
		$pageid = WController::getFormValue( 'pageid' );
		$type = WController::getFormValue( 'type' );
		$comment = WController::getFormValue( 'comment' );


		$message = WMessage::get();

		$extraLink = '';
		if ( WExtension::exist( 'affiliate.node') ) {
			$affiliateHelperC = WClass::get( 'affiliate.helper', null, 'class', false );
			$extraLink = $affiliateHelperC->addAffilateToLink();
		}
		if ( !empty($comment) ) {
			$post = new stdClass;

			switch( $type ) {
				case 250:
					$link = WPage::routeURL('controller=vendors&task=home&eid='.$eid . $extraLink, 'home', 'default', false, $pageid );
					$VENDOR_NAME = '<a href="'. $link .'">'.$item.'</a>';
					$post->title = str_replace(array('$VENDOR_NAME'), array($VENDOR_NAME),WText::t('1338493593SACO'));
					$callFctType = 'vendor';
					$post->model = 'vendors';
					$post->titleTR = WText::translateNone( '{tag:actor} posted the following comment about vendor ' . $VENDOR_NAME . '{multiple} {count} times{/multiple}.' );
					$post->titleVAR = '$VENDOR_NAME';

					break;
				case 150:
					$link = WPage::routeURL('controller=catalog&task=category&eid='.$eid . $extraLink, 'home', 'default', false, $pageid );
					$CATEGORY_NAME = '<a href="'. $link .'">'.$item.'</a>';
					$post->title = str_replace(array('$CATEGORY_NAME'), array($CATEGORY_NAME),WText::t('1338493593SACP'));
					$callFctType = 'category';
					$post->model = 'item.category';
					$post->titleTR = WText::translateNone( '{tag:actor} posted the following comment about category ' . $CATEGORY_NAME . '{multiple} {count} times{/multiple}.' );
					$post->titleVAR = '$CATEGORY_NAME';
					break;
				case 50:
				default:
					$link = WPage::routeURL('controller=catalog&task=show&eid='.$eid . $extraLink, 'home', 'default', false, $pageid );
					$ITEM_NAME = '<a href="'. $link .'">'.$item.'</a>';
					$post->title = str_replace(array('$ITEM_NAME'), array($ITEM_NAME),WText::t('1338493593SACQ'));
					$callFctType = 'item';
					$post->model = 'item';
					$post->titleTR = WText::translateNone( '{tag:actor} posted the following comment about item ' . $ITEM_NAME . '{multiple} {count} times{/multiple}.' );
					$post->titleVAR = '$ITEM_NAME';
					break;
			}
			$post->eid = $eid;
			$post->node = 'catalog.node';
			$post->context = $post->model;
			$post->link = $link;
			$post->description = $comment;
			$post->callingFunction = 'wall' . $callFctType . 'sharewall';
			$post->eid = $eid;
			$itemWallC->postWall( $post );

			$message->userS('1337142833PRBG');

		} else {
			$message->userE('1337142833PRBH');
		}
	}

	return true;



}
}