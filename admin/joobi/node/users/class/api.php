<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_Api_class extends WClasses {






	public function blockUser($block=1,$uid=null){

		$resetCurrent=false;
		if( empty($uid)){
			$uid=WUser::get( 'uid' );
			$resetCurrent=true;
		}
		if( empty($uid)) return false;

		if( !is_array($uid)) $uid=array( $uid );

				$usersM=WModel::get( 'users' );
		$usersM->whereIn( 'uid', $uid );
		$usersM->setVal( 'blocked', $block );
		$usersM->update();


		$usersAddon=WAddon::get( 'api.'. JOOBI_FRAMEWORK . '.user' );
		$usersAddon->blockUser( $block, $uid );


		$sessionM=WModel::get( 'library.session' );
		$sessionM->whereIn( 'uid', $uid );
		$sessionM->deleteAll();

		if( $resetCurrent){
						WUser::get( null, 'reset' );
			$usersSessionC=WUser::session();
			$usersSessionC->resetUser();
		}
	}
}