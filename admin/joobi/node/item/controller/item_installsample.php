<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_installsample_controller extends WController {
function installsample($newInstall=false) {

	$message = WMessage::get();

	$existProductSamples = WExtension::exist( 'productsamples.node' );

	if ( $existProductSamples ){
		$productInstall = WClass::get( 'productsamples.install' );

		$exitjMarket = WExtension::exist( 'jmarket.application' );
		if ( $exitjMarket ) {
			$productInstall->installSampleData('market' );
		} else {
			$exitjStore = WExtension::exist( 'jstore.application' );
			if ( $exitjStore ) {
				$productInstall->installSampleData('store' );
			}		}
		$exitjAuction = WExtension::exist( 'jauction.application' );
		if ( $exitjAuction ) {
			$productInstall->installSampleData('auction' );
		}
		$exitjSubscription = WExtension::exist( 'jsubscription.application' );
		if ( $exitjSubscription ) {
			$productInstall->installSampleData('subscription' );
		}	}
	$existjDloads = WExtension::exist( 'jdownloads.application' );
		if ( $existjDloads ) {
			$productInstall = WClass::get( 'download.sampledata' );
			$productInstall->copyProductSamplesImages();
			$productInstall->sampleCategories();
			$productInstall->sampleDownloads();
		}
	$message->userS('1305797891RVTV');

return true;

}}