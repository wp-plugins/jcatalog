<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');





class Email_Helper_class extends WClasses {













	public function loadMGID($namekey){



		if( empty( $namekey )) return false;



		$mailM=WModel::get( 'email' );

		$mailM->whereE( 'namekey', $namekey );

		return $mailM->load( 'lr', 'mgid' );



	}


}
