<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Catalog_Download_class {






	public function downloadFile($pid) {

				$logFirst = WPref::load( 'PBASKET_NODE_LOGINBEFORECHECKOUT' );
		if ( $logFirst ) {
						if ( ! WUser::isRegistered() ) {
								$usersCredentialC = WUser::credential();
				$usersCredentialC->goLogin();
			}		}

				if ( WExtension::exist( 'subscription.node' ) ) {

			$subscriptionCheckC = WObject::get( 'subscription.check' );
			$subscriptionCheckC->restriction( 'download_count', $pid );

			if ( !$subscriptionCheckC->getStatus() ) {
				$message = WMessage::get();
				$message->userW('1329161759BGNY');
				WPages::redirect( 'previous' );
			}
		}
				$itemC = WClass::get('item.access');
		$downloadText = WText::t('1240388999GQSW');
		$hasAccess = $itemC->checkItemAccess( $pid, $downloadText );
		if ( !$hasAccess ) return false;

		$itemDownloadsM = WModel::get('item.downloads');
		$itemDownloadsM->whereE('pid', $pid );
		$filidA = $itemDownloadsM->load( 'lra', 'filid' );

		if ( !empty($filidA) ) {

			$itemM = WModel::get('item');
						$itemM->whereE( 'pid', $pid );
			$itemM->updatePlus( 'nbsold', 1 );
			$itemM->update();

						$itemM->whereE( 'pid', $pid );
			$itemM->where( 'stock', '>', 0 );
			$itemM->updatePlus( 'stock', -1 );
			$itemM->update();
			$uid = WUser::get('uid');
			$downloadM = WModel::get('download.members');
			$downloadM->setVal( 'pid', $pid );
			$downloadM->setVal( 'uid', $uid );
			$downloadM->setVal( 'created', time() );
			$downloadM->insert();

			$nbDownloads = count($filidA);
			if ( $nbDownloads > 1 ) {
				$myKey = WTools::randomString( 100, false );
				WGlobals::setSession( 'order', 'secretKey', md5( $myKey . JOOBI_SITE_TOKEN . $pid ) );

								WPages::redirect('controller=item&task=downloads&bfrhead=0&eid='.$pid . '&secretkey=' . $myKey );

			}
			$filid = $filidA[0];

			$fileDownloadC = WClass::get( 'files.download' );
			$fileDownloadC->getFile( $filid, false );
			WPages::redirect( 'previous' );

		}

		return true;


	}


}