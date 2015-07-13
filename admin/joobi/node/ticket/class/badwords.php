<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Ticket_Badwords_class extends WClasses {








	public function checkWords(&$text2Filter) {
		static $badWordslistA = null;
		static $spamWordslistA = null;


		if ( !isset( $badWordslistA ) ) {
						$badWordslistA = explode( ',', WPref::load( 'PTICKET_NODE_SPAMBADWORDS' ) );
			$spamWordslistA = explode( ',', PTICKET_NODE_SPAMWORDS );
		}

		$text2Filter = preg_replace( "/\b(" . implode($badWordslistA,"|") . ")\b/i", '****', $text2Filter );


				$wordsA = array();
		$matches = array();
		$findOneB = preg_match_all( "/\b(" . implode($spamWordslistA,"|") . ")\b/i", $text2Filter, $matches );

		if ( $findOneB ) {
			$wordsA = array_unique($matches[0]);
		}

				if ( $findOneB ) {

			$blockUser = WPref::load( 'PTICKET_NODE_SPAMBLOCK' );
			if ( $blockUser ) {
				$usersAddon = WClass::get( 'users.api' );
				$usersAddon->blockUser();
			}
			$notifyAdmin = WPref::load( 'PTICKET_NODE_SPAMNOTIFY' );
			if ( $notifyAdmin ) {

								$uidA = WUser::getRoleUsers('supportmanager', array( 'uid' ) );
								if ( !empty( $uidA ) ) {
					$mailM = WMail::get();
					$mailParams = new stdClass;
					$mailParams->name = WUser::get( 'name' );
					$mailParams->username = WUser::get( 'username' );
					$mailParams->profileLink = WPage::link( 'controller=users', 'admin' );

					$mailM->setParameters( $mailParams );

					foreach( $uidA as $oneModeratorUID ) {

												$mailM->sendNow( $oneModeratorUID->uid, 'support_manager_badwords_notice' );
					}				}
			}
		}
		return $wordsA;

	}







	public function replaceExternalLinks(&$text2Filter) {

		

	}


}