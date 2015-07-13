<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');














class myPreferences extends WModel {

	var $_ignore=false;				var $_usersPref=false;		
	private $_prefModel=null;

	private static $loaded=array();




	function __construct(){

	}











	function isLoaded($variable){
		$constant=strtoupper( 'P' . $this->_compNamekey . '_' . $variable );
		if( defined($constant)){
			return $constant;
		}		return false;
	}







	function getPref($variable,$default=''){

		$name=$this->isLoaded($variable);
		if( $name){
			return Wpref::load( $name );
		}		return $default;
	}





	function setup($prefix=''){
		if( empty($prefix)) return false;
		if( is_numeric($prefix)){
			$this->_compPrefixID=$prefix;
			$this->_compNamekey=str_replace( '.', '_', WExtension::get( $prefix, 'namekey' ));
		}else{
			$this->_compNamekey=$prefix;
			$this->_compPrefixID=WExtension::get( $prefix, 'wid' );
		}		return true;
	}










	 public function loadConfig($userPref=true,$force=false,&$newWay){
	 	if( empty($this->_compPrefixID) || empty($this->_compNamekey)) return false;
	 	if( ! $force && ! empty( self::$loaded[$this->_compPrefixID] )) return false;
	 	self::$loaded[$this->_compPrefixID]=true;

	 	$JoobiUser=WGlobals::getSession( 'JoobiUser' );

				if( !empty( $JoobiUser ) && $userPref){
			$uid=( !empty($JoobiUser->uid) ? $JoobiUser->uid : 0 );
		} else $uid=0;

		$noYetPref=false;
		$folder=WExtension::get( $this->_compPrefixID, 'folder' );

				if( class_exists( 'Default_' . $folder . '_preferences' )){
			return false;
		}
				$localtion=JOOBI_DS_NODE . $folder . DS . 'preferences.php';

		if( @file_exists($localtion)){
			include($localtion);

			$newWay=$this->_compNamekey;

		}else{
			$newWay=false;
			$defaultClas='class Default_' . $folder . '_preferences {} class Role_' . $folder . '_preferences {}';
			eval($defaultClas);
		}
				$localtion=JOOBI_DS_USER . 'node' . DS . $folder . DS . 'preferences.php';

		if( @file_exists($localtion)){
			include($localtion);
		}else{

									$mdlExist=WModel::modelExist( 'library.preferences' );
			if( ! $mdlExist
			){

				$siteClass='class Site_' . $folder . '_preferences extends Default_' . $folder . '_preferences {}';
				eval($siteClass);

			}else{
				$usersM=WModel::get( 'library.preferences' );
				$usersM->select( array( 'namekey', 'text', 'premium' ));
				$usersM->whereE( 'wid', $this->_compPrefixID );
				$usersM->setLimit( 2000 );
				$oneJSTUDIOConfA=$usersM->load( 'ol' );
				$pref=WPref::get( $this->_compPrefixID, false, false );
				if( !empty($oneJSTUDIOConfA)){

					foreach( $oneJSTUDIOConfA as $oneOldPref){
						if( $oneOldPref->text !=$oneOldPref->premium){
							$pref->updatePref( $oneOldPref->namekey, $oneOldPref->text );
						}					}				}else{
										$pref->updatePref( 'dummuy', 0 );
				}
				$localtion=JOOBI_DS_USER . 'node' . DS . $folder . DS . 'preferences.php';

				if( @file_exists($localtion)){
							include($localtion);
				}else{

					$siteClass='class Site_' . $folder . '_preferences extends Default_' . $folder . '_preferences {}';
					eval($siteClass);

				}
			}
		}
	 		 	$needUserClass=false;
		if( $uid > 0){
			$username=WUser::get( 'username', $uid );
						$localtion=JOOBI_DS_USERS . $username . DS . 'node' . DS . $folder . DS . 'preferences.php';
			if( @file_exists($localtion)){
				include($localtion);
			}else{
				$needUserClass=true;
			}		}else{
			$needUserClass=true;
		}
		if( $needUserClass){
			$userClass='class User_' . $folder . '_preferences extends Site_' . $folder . '_preferences {}';
			eval($userClass);
		}

		$className='User_' . $folder . '_preferences';

		if( class_exists($className)){

						$prefInst=new $className;

			return $prefInst;

		}

	 }







	 private function _loadConfigOLD($userPref=true,$force=false){			static $prefixLoaded=array();

		if( empty($this->_compPrefixID) || empty($this->_compNamekey)) return false;

		$caching=( defined('PLIBRARY_NODE_CACHING') ? PLIBRARY_NODE_CACHING : 1 );
		$getModel=true;

				$JoobiUser=WGlobals::getSession( 'JoobiUser' );
				if( !empty( $JoobiUser ) && $userPref ) $uid=WUser::get( 'uid' );
		else $uid=0;

		if( $caching > 5){

			$cache=WCache::get( JOOBI_SESSION_LIFETIME );	
						if( $userPref){
				if( !isset($_SESSION['jPreference']['uid']) || $_SESSION['jPreference']['uid'] !=$uid){
															$_SESSION['jPreference']['uid']=$uid;
				}
			}
						$prefSess=$cache->get( $this->_compPrefixID . '-_-' . $uid, 'Preference' );

			if( !empty($prefSess))  $getModel=false;

		}
		if( ! $force && ! empty( $prefixLoaded[$this->_compPrefixID] )) return false;

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
						if( defined('JOOBI_INSTALLING')){
				if( !isset($prefModel)) $prefModel=WTable::get( 'joobi_preferences', 'main_userdata', 'wid,namekey' );
			}else{
				if( !isset($prefModel)) $prefModel=WModel::get( 'library.preferences' );
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

















	 public function updatePref($key,$val,$users=false,$keyName='text'){

	 	if( empty($this->_compPrefixID) || empty($this->_compNamekey)) return false;


		$preferenceName='P' . strtoupper( str_replace( '.', '_', $this->_compNamekey ) . '_' . $key );

				WPref::load( $preferenceName );

		WPref::$prefA[$preferenceName]=$val;


		if( $this->_makeAudit){
			static $securityAuditA=null;
			if( !isset($securityAuditA)) $securityAuditA=WClass::get( 'security.audit', null, 'class', false );
			if( !empty($securityAuditA)){
				$myPremium=( $keyName=='text' ? false : true );
				$securityAuditA->preferenceUpdate( $this->_compPrefixID, $key, $val, false, false );
			}		}
				$folder=WExtension::get( $this->_compPrefixID, 'folder' );
		$defaultClass='Default_' . $folder . '_preferences';
		$classExist=false;
		if( !class_exists($defaultClass)){	
						return $this->_updatePrefOLD( $key, $val, $users, $keyName );

		}else{
						$localtion=JOOBI_DS_USER . 'node' . DS . $folder . DS . 'preferences.php';
						$access='Role_' . $folder . '_preferences';
			if( ! class_exists($access)){
				return false;
			}			$accessInst=new $access;
			if( isset($accessInst->$key)){
								if( ! WRole::hasRole($accessInst->$key)){
					return false;
				}			}						if( 'premium'==$keyName){
				return false;
			}
									$userClass='Site_' . $folder . '_preferences extends Default_' . $folder . '_preferences';
			$updateClass='SiteUpdate_' . $folder . '_preferences';

			if( !class_exists($updateClass)){
				if( @file_exists($localtion)){
					$content=file_get_contents( $localtion );
					$content=str_replace( $userClass, $updateClass, $content );
					$content=str_replace( array( "defined('JOOBI_SECURE') or die('J....');", "<?php" ), '', $content );

					eval( $content );
				}
			}
			$siteInst=&self::_getUpdateInstance( $updateClass );
			$siteInst->$key=$val;

						$site='';
			$line="\n";
			foreach( $siteInst as $k=> $v){
				if( is_numeric($v)){						if( empty($v)) $v=0;
					$site .='public $' . $k . '=' . $v . ';';
				}else{
					$site .='public $' . $k . "='" . addslashes($v) . "';";
				}				$site .=$line;
			}
			$file="<?php defined('JOOBI_SECURE') or die('J....');" . $line;
			$file .='class Site_' . $folder . '_preferences extends Default_' . $folder . '_preferences {' . $line;
			$file .=$site;
			$file .='}';	
			$fileS=WGet::file();
			$fileS->write( $localtion, $file, 'overwrite' );

		}
		return true;

   }

















	 private function _updatePrefOLD($key,$val,$users=false,$keyName='text'){

	 	if( empty($this->_compPrefixID) || empty($this->_compNamekey)) return false;

	 	$cache=WCache::get();
		$uid=WUser::get( 'uid' );
		if( empty($uid)) $uid=0;
		$cache->resetCache( 'Preference', $this->_compPrefixID .'-_-' . $uid );

		$preferenceName='P' . strtoupper( str_replace( '.', '_', $this->_compNamekey ) . '_' . $key );

		unset( WPref::$prefA[$preferenceName] );

				if( defined('JOOBI_INSTALLING')){
			if( !isset($prefModel)) $prefModel=WTable::get( 'joobi_preferences', 'main_userdata', 'wid,namekey' );
		}else{
			if( !isset($prefModel)) $prefModel=WModel::get( 'library.preferences' );
		}

		if( empty($this->_prefModel)) return false;

		if( $this->_makeAudit){
			static $securityAuditA=null;
			if( !isset($securityAuditA)) $securityAuditA=WClass::get( 'security.audit', null, 'class', false );
			if( !empty($securityAuditA)){
				$myPremium=( $keyName=='text' ? false : true );
				$securityAuditA->preferenceUpdate( $this->_compPrefixID, $key, $val, false, false );
			}		}
		$this->_prefModel->resetAll();
		$this->_prefModel->whereE( 'wid', $this->_compPrefixID );
		$this->_prefModel->whereE( 'namekey', $key );
		if( !defined('JOOBI_INSTALLING')) $this->_prefModel->checkAccess();
		$this->_prefModel->setVal( $keyName, $val );
		if( $users ) $this->_prefModel->setVal( 'users', true );
		$status=$this->_prefModel->update();

				if( $this->_prefModel->affectedRows() < 1){
			$this->_prefModel->setVal( 'wid', $this->_compPrefixID );
			$this->_prefModel->setVal( 'namekey', $key );
			$this->_prefModel->setVal( $keyName, $val);
												$this->_prefModel->setIgnore();
			$this->_prefModel->setLimit(1);
			if( $users ) $this->_prefModel->setVal( 'users', true );
			$status=$this->_prefModel->insert();
		}
		return $status;

   }








	 public function updateDefaultPref($key,$val,$users=false){
		return $this->updatePref( $key, $val, $users, 'premium' );
   }







	public function updateUserPref($key,$val,$uid=null){

		if( empty($this->_compPrefixID) || empty($this->_compNamekey)) return false;

		if( !isset($uid)) $uid=WUser::get( 'uid' );
				if( empty($uid)) return false;


		

		if( $this->_makeAudit){
			static $securityAuditA=null;
			if( !isset($securityAuditA)) $securityAuditA=WClass::get( 'security.audit', null, 'class', false );
			if( !empty($securityAuditA)) $securityAuditA->preferenceUpdate( $this->_compPrefixID, $key, $val, true, false );
		}

		$preferenceName='P' . strtoupper( str_replace( '.', '_', $this->_compNamekey ) . '_' . $key );
				WPref::load( $preferenceName );

		WPref::$prefA[$preferenceName]=$val;

		$folder=WExtension::get( $this->_compPrefixID, 'folder' );
				$access='Role_' . $folder . '_preferences';
		$accessInst=new $access;
		if( isset($accessInst->$key)){
						if( ! WRole::hasRole($accessInst->$key, $uid )) return false;
		}

		$username=WUser::get( 'username', $uid );
		$localtion=JOOBI_DS_USERS . $username . DS . 'node' . DS . $folder . DS . 'preferences.php';
		$fileS=WGet::file();

				$userClass='User_' . $folder . '_preferences extends Site_' . $folder . '_preferences';
		$updateClass='UserUpdate_' . $folder . '_preferences';

		if( !class_exists($updateClass)){
			if( @file_exists($localtion)){
				$content=file_get_contents( $localtion );
				$content=str_replace( $userClass, $updateClass, $content );
				$content=str_replace( array( "defined('JOOBI_SECURE') or die('J....');", "<?php" ), '', $content );	
				eval( $content );
			}		}

		$siteInst=&self::_getUpdateInstance( $updateClass );
		$siteInst->$key=$val;

				$site='';
		$line="\n";
		foreach( $siteInst as $k=> $v){
			if( is_numeric($v)){					if( empty($v)) $v=0;
				$site .='public $' . $k . '=' . $v . ';';
			}else{
				$site .='public $' . $k . "='" . addslashes($v) . "';";
			}			$site .=$line;
		}
		$file='<?php defined(\'JOOBI_SECURE\') or die(\'J....\');' . $line;
		$file .='class User_' . $folder . '_preferences extends Site_' . $folder . '_preferences {' . $line;
		$file .=$site;
		$file .='}';	
		$fileS->write( $localtion, $file, 'overwrite' );




	}






	private static function &_getUpdateInstance($class){
		static $instA=array();

		if( !isset($instA[$class])){
			if( !class_exists($class)){
				$classDef='class ' . $class . ' {}';
				eval($classDef);
			}			$instA[$class]=new $class;
		}
		return $instA[$class];

	}
}






 class WTranslation {







	public static function load($wid='1',$load=1){
		static $loadedLang=array();



		$usedLanguage=WGlobals::getSession( 'JoobiUser', 'lgid' );
		
		$key=$wid. '-' . $load . '-' . $usedLanguage;

		if( !isset($loadedLang[$key])){

			$loadedLang[$key]=true;

			$caching=( defined('PLIBRARY_NODE_CACHING') ? PLIBRARY_NODE_CACHING : 1 );
			$caching=( $caching > 4 ) ? 'cache' : 'static';

									
						$vocabulary=WCache::getObject( $wid. '-' . $load . '-' . $usedLanguage, 'Translation', $caching, false, true );



			if( !empty($vocabulary) && $vocabulary !==true){
				foreach( $vocabulary as $key=> $val){
					if( empty($val->imac)) continue;
															if( empty($val->text)) $val->text=@$val->textref;

					$constName=$val->imac;
					WText::$vocab[$constName]=$val->text;

				}			}
		}

	}







	public function getSQL($passedParam,$showMessage=true){
		static $code=array();

			$explodeMeA=explode( '-', $passedParam );
			$wid=	$explodeMeA[0];
			$load=$explodeMeA[1];
			$lgid=$explodeMeA[2];

			$modelTR=WTable::get( 'translation_reference', 'main_translation' );				$modelTR->whereE( 'load', $load );
			if( $load!=2 ) $modelTR->whereE( 'wid', $wid );

			$modelTR->makeLJ( 'translation_en', 'main_translation', 'imac', 'imac' );
			$modelTR->select( 'imac', 1 );

						if( !isset($code[$lgid])){
				$helloLang=WLanguage::get( $lgid, 'code' );
				$code[$lgid]=strtolower( trim($helloLang));
			}

									

			$modelExit=false;
						if( !empty($code[$lgid]) && $code[$lgid] !='en'){

				$tableExistM=WTable::get( 'translation_' . $code[$lgid], 'main_translation' );
				$modelExit=$tableExistM->tableExist();

			}

			if( $modelExit){
				$code[$lgid]=substr( $code[$lgid], 0, 2 );
				$modelTR->makeLJ( 'translation_' . $code[$lgid], 'main_translation', 'imac', 'imac' );
				$modelTR->select( 'text', 2);
				$modelTR->select( 'text', 1,'textref');
			}else{
				$modelTR->select( 'text', 1 );
			}
			$modelTR->setLimit( 2000 );
			$vocabulary=$modelTR->load('ol');
			if( empty($vocabulary)) $vocabulary=true;


		return $vocabulary;

	}
}