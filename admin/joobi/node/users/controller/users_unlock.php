<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_unlock_controller extends WController {
	function unlock(){



		$eid=WGlobals::getEID( true );

		$userLockC=WClass::get( 'users.api' );

		$status=$userLockC->blockUser( 0, $eid );



		$TOTAL=count( $eid );

		if( $TOTAL > 1 ) $this->userS('1401465958GTFM',array('$TOTAL'=>$TOTAL));

		else {

			$this->userS('1401465958GTFN');

		}


		return $status;



	}}