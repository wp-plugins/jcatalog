<?php 

* @link joobi.co
* @license GNU GPLv3 */



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