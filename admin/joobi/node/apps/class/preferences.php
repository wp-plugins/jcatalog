<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Apps_Preferences_class extends WClasses {







    public function updatePreferences($wid,$folder){


				$line="\n";
		$fileS=WGet::file();

				$prefModel=WTable::get( 'joobi_preferences', 'main_userdata', 'wid,namekey' );
		$prefModel->select( array( 'namekey', 'text', 'premium', 'rolid' ));
		$prefModel->whereE( 'wid', $wid );
		$prefModel->where( 'text', '!=' , 'premium', 0, 0 );
		$prefModel->setLimit( 1000 );
		$allPrefA=$prefModel->load( 'ol' );

		if( !empty($allPrefA)){

			$localtion=JOOBI_DS_USER . 'node' . DS . $folder . DS . 'preferences.php';

			$site='';
			foreach( $allPrefA as $onePref){

				if( is_numeric($onePref->text)){						if( empty($onePref->text)) $onePref->text=0;
					$site .='public $' . $onePref->namekey . '=' . $onePref->text . ';';
				}else{
					$site .='public $' . $onePref->namekey . "='" . addslashes($onePref->text) . "';";
				}				$site .=$line;
			}
						$file="<?php defined('JOOBI_SECURE') or die('J....');" . $line;
			$file .='class Site_' . $folder . '_preferences extends Default_' . $folder . '_preferences {' . $line;
			$file .=$site;
			$file .='}';

			$fileS->write( $localtion, $file );


						
		}
    	return false;


	}










	 private function _loadConfigOLD($userPref=true,$force=false){			static $prefixLoaded=array();

		if( empty($this->_compPrefixID) || empty($this->_compNamekey)) return false;

		$caching=0;
		$getModel=true;

				$JoobiUser=WGlobals::getSession( 'JoobiUser' );
				if( !empty( $JoobiUser ) && $userPref ) $uid=WUser::get( 'uid' );
		else $uid=0;


		$prefixLoaded[$this->_compPrefixID]=true;

		if( $getModel){

			if( $userPref){
				$prefSess=new stdClass;
				$usersM=WTable::get( 'joobi_preferences_users', 'main_userdata', 'wid,namekey,uid' );
				$usersM->select( array( 'namekey', 'text' ));
				$usersM->whereE( 'wid', $this->_compPrefixID );
				$usersM->whereE( 'uid', $uid );
				$usersM->setLimit( 1000 );
				$oneJSTUDIOConf=$usersM->load( 'ol' );



				$removeArray=array();
				if( !empty($oneJSTUDIOConf)){
					foreach( $oneJSTUDIOConf as $line){
						$key=$this->_compNamekey.'_'.$line->namekey;
						$prefSess->$key=$line->text;
						$removeArray[]=$line->namekey;
					}				}
			}elseif( empty($prefSess)){
				$prefSess=new stdClass;
			}
			if( empty($this->_prefModel)) return false;
			$this->_prefModel->resetAll();
			$this->_prefModel->select( array( 'namekey', 'text' ));

			if( !empty($removeArray)) $this->_prefModel->whereIn( 'namekey', $removeArray, 0, true );
			$this->_prefModel->whereE( 'wid', $this->_compPrefixID );

			$this->_prefModel->setLimit( 5000 );

			$oneConf=$this->_prefModel->load( 'ol' );


			if( !empty($oneConf)){
				foreach( $oneConf as $oneConfVal){
					$key=$this->_compNamekey . '_' . $oneConfVal->namekey;
					if( !isset($prefSess->$key)){
						$prefSess->$key=$oneConfVal->text;
					}
				}			}
			if( $caching > 5){
				$cache->set( $this->_compPrefixID . '-_-' . $uid, $prefSess, 'Preference' );
			}
		}

		return $prefSess;



   }


}