<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_lock_controller extends WController {


	function lock(){



		
		$eid=WGlobals::getEID( true );

		$userLockC=WClass::get( 'users.api' );

		$status=$userLockC->blockUser( 1, $eid );


		$TOTAL=count( $eid );
		if( $TOTAL > 1 ) $this->userS('1401465958GTFO',array('$TOTAL'=>$TOTAL));
		else {
			$this->userS('1401465958GTFP');
		}
		return $status;

	}
}