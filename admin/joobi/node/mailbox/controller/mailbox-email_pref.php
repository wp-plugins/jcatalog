<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Mailbox_email_pref_controller extends WController {








	function pref() {



		$wid = WGlobals::get( 'wid', 0, '', 'int' );

		if ( !$wid ) {

			return false;

		}

		$namekey = WExtension::get( $wid, 'namekey' );
		if ( $namekey == 'newzletter.newzletterbounce.mailbox' ) {
			WPages::redirect( 'controller=mailbox-email&task=newzletterpref' );
		}
		return false;

	}
}