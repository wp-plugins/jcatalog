<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





class WController extends WObj {

	var $ctrid=null;
	var $namekey=null;
	public $task=null;
	var $act=null;
	var $yid=null;							var $wid=null;							var $sid=null;							var $you=null;


	protected $layout=null;						
		public $_eid=null;						
	var $_model=null;

	var $noLayout=false; 		

	private $_displayView=true;	
	var $viewNamekey='';			var $viewOutput='html';		var $viewParams=null;		

	private $_skipMessage=false; 		
	private $_getlastId=false;

	var $status=false;

	public $checkSecureForm=true;		
	var $triggerObject=null;		
	var $numberOfTagIterationBeforeDisplay=0;	
	var $trigger=null;




	public $toggleO=null;


		private $_controllerSaveOrder=true;

	private $_checkOwnerShip=true;

	public $saveauto=false;

	private static $_newTask=null;

	private static $_firstCrtl=true;





	private static $WMessageLog=array();

	









	function __construct(){
		static $onlyOnce=false;
				WController::_cleanTask();

		if( $onlyOnce ) return true;
		$onlyOnce=true;


		if( 'wordpress'==JOOBI_FRAMEWORK_TYPE){

			$getFRomSession=WGlobals::getSession( 'autoLogin', 'formInfo', '' );

			if( !empty($getFRomSession)){
				$getInfo=unserialize( $getFRomSession );
				if( !empty($getInfo)){

					foreach( $getInfo as $k=> $v){
						WGlobals::set( $k, $v );
					}
				}				WGlobals::setSession( 'autoLogin', 'formInfo', null );
			}
		}














				WTools::updateToken();



		$cronType=WPref::load( 'PLIBRARY_NODE_CRON' );
		$cronNext=WPref::load( 'PLIBRARY_NODE_NEXTCRON' );
				if( WRoles::isAdmin( 'manager' ) && $cronNext > time() && $cronType >=5 && WExtension::exist('scheduler.node')){
			$schedulerCheckingC=WClass::get( 'scheduler.checking' );
			$schedulerCheckingC->lateTask();
		}

				$historySavedA=WGlobals::getSession( 'historyRedirect', 'trucs', null );
		if( !empty($historySavedA)){
			$getrucA=WGlobals::get( 'trucs', array(), '', 'array' );
			if( empty($getrucA)) WGlobals::set( 'trucs', $historySavedA );
			WGlobals::setSession( 'historyRedirect', 'trucs', array());
		}

	}





	public static function &get($path=null,$return='objectfile',$params=null,$showMessage=true){
		static $newClassA=array();

						
		$task='';
		if( empty($path)) $path=WGlobals::get( 'controller' );
		if( empty($path)){
						$none=null;
			return $none;
		}
		if( !is_numeric($path)){
			$task=WController::_cleanTask();
			$ftast=explode( '.', $task );
			if( isset($ftast[1])) $task=$ftast[0];

			
		}
		$saveauto=false;
				if( 'advsearch'==$task && 'output' !=$path){
			$path='output';
			WGlobals::set( 'controller', $path );
		}
		$defaultTaskA=array( 'wizard', 'help', 'welcome' );
		if( in_array( $task, $defaultTaskA )){

			$tempdata=new stdClass;
			$tempdata->task=$task;
			$tempdata->namekey='output.' . $task;
			$tempdata->rolid=1;
			$tempdata->app='output';
			$tempdata->path=0;
			$tempdata->level=0;
			$tempdata->wid=WExtension::get( 'output.node', 'wid' );

		}elseif( $task=='saveauto'){
						$saveauto=true;
			$task='save';
			$tempdata=WController::ooController( $path, $task, false, $showMessage );
		}else{
			$tempdata=WController::ooController( $path, $task, false, $showMessage );
		}
		if( empty($tempdata)){
			$tmp=null;
			return $tmp;
		}else{
									$roleC=WRole::get();
			$myRoleA=$roleC->getUserRoles();

		}

				if( empty($task) && !empty($tempdata->task)) WGlobals::set( 'task', $tempdata->task );

				WText::load( $tempdata->wid );
						WPref::get( $tempdata->wid );


		$user=WUser::get();

				if( isset( $tempdata->superOverride )){
			$roleToCheck=$tempdata->superolid;
		}else{				$roleToCheck=$tempdata->rolid;
		}
		if( empty($roleToCheck)) $roleToCheck=1;
		if( empty($myRoleA) || !is_array($myRoleA) || !in_array( $roleToCheck, $myRoleA)){

			if( $user->uid==0){ 				$usersCredentialC=WUser::credential();
				$usersCredentialC->goLogin();

				
				
			}else{					if( $showMessage){
					$message=WMessage::get();
					$message->userW('1380026000CYDM');
					WMessage::log( 'Controller: the access to this page is restricted.' );
					WMessage::log( $tempdata );
					WMessage::log( $roleToCheck );
					WMessage::log( $myRoleA );
				}			}
			$null1=null;
			return $null1;

		}
		
		if( $tempdata->level > 0 && WGlobals::getCandy() < $tempdata->level){
						$levelType=WType::get( 'apps.level' );
			$LEVEL=$levelType->getName( $tempdata->level );

			if( $showMessage){
								$message=WMessage::get();
				$message->userW('1298350414EEEY',array('$LEVEL'=>$LEVEL));
				$message->userW('1298350414EEEZ');
			}			if( WRoles::isAdmin( 'manager' )){
WMessage::log( 'Does not have at least Manager access', 'problem-user-access' );
				WPage::redirects( 'controller=apps' );
			}else{
				$null1=null;
				return $null1;
			}		}

		$keyList=array( 'ctrid', 'app', 'wid', 'task', 'yid', 'path', 'ref_ctrid', 'reff_ctrid', 'level', 'rolid','trigger', 'namekey', 'checkowner', 'checkadminowner' ); 				if( in_array( $return , $keyList )){
			return $tempdata->$return;
		}
		if( $return=='data' ) return $tempdata;

		$nameKEY=WExtension::get( $tempdata->wid, 'namekey' );
		WGlobals::set( 'extensionID', $tempdata->wid, 'global', true );
		WGlobals::set( 'extensionKEY', $nameKEY, 'global', true );

				$mypos=strpos( $tempdata->app, '.' );
		if( $mypos===false){
			$functionName=$tempdata->app;
		}else{
			$functionName=substr( $tempdata->app, 0, $mypos );
		}

				if( !empty( $tempdata->pnamekey )){

						WController::get( $tempdata->pnamekey );

			$pnamekey=str_replace( '.1', '', $tempdata->pnamekey );

			if( empty($tempdata->path)){
				$className=ucfirst( str_replace( array( '.', '-' ), '_', $tempdata->app )) . '_' . ucfirst( str_replace( array( '.', '-' ), '_', $tempdata->task  )) . '_controller';

				if( !class_exists( $className )){
					$extClassNameA=explode( '.', $pnamekey );
					$extClassName=ucfirst( str_replace( '-', '_', $extClassNameA[0] )) . '_' . ucfirst( str_replace( array( '.', '-' ), '_', $extClassNameA[1]  )) . '_controller';
					$extendedClass='class ' . $className . ' extends ' . $extClassName . '{}';
					eval( $extendedClass );
				}
			}		}
		$newClass=null;
				if( $tempdata->path){

			$myFuntion=WExtension::get( $tempdata->wid, 'folder' );

			$myFile2=str_replace( '.', '_', $tempdata->app  ) . '_' . $tempdata->task;


			if( !empty($tempdata->custom)) $base=JOOBI_DS_USER . 'node' . DS;
			else $base=JOOBI_DS_NODE;

			$exists=WLoadFile( $myFuntion . '.controller.' . $myFile2, $base );

			$className=str_replace( '-', '_', $myFile2  )  . '_controller';

			if( !$exists){
								$message=WMessage::get();
				$message->codeE( 'The following file does not exist for the controller: ' . $myFuntion . '.controller.' . $myFile2 );
			}
			if( class_exists( $className )){
				$newClass=new $className;
			}else{
				$message=WMessage::get();
				$message->codeE( 'The following class does not exist for the controller: ' . $className );
				$newClass=new WController( '', $params, $tempdata->wid );			}		}else{
			if( !empty($className) && class_exists( $className )){
				$newClass=new $className;
			}else{
				$newClass=new WController( '', $params, $tempdata->wid );			}
		}
				foreach( $tempdata as $key=> $val){
			$newClass->$key=$val;
		}
		$newClass->controller=$newClass->app;
		$newClass->saveauto=$saveauto;

		$newClassA[$path]=$newClass;

		return $newClass;

	}





	function make(){

		$isPopUp=WGlobals::get( 'is_popup', false, 'global' );
		if( ! $isPopUp){

			$shortName=WApplication::name( 'short' );
			$showJApps=false;
			if( JOOBI_MAIN_APP==$shortName){
								$count=WPref::load( 'P' . strtoupper(JOOBI_MAIN_APP) . '_APPLICATION_COUNTWELCOME' );
				if( $count < 1){
					$appP=WPref::get( JOOBI_MAIN_APP . '.application' );
					$appP->updatePref( 'countwelcome', 1 );
				}else{
					$showJApps=true;
				}			}
						if(( JOOBI_MAIN_APP !=$shortName || $showJApps ) && WExtension::exist( $shortName . '.application' )){

								
					




				$task=WGlobals::get( 'task' );
				$alreadySetup=WGlobals::getSession( 'installApp', $shortName, false );
								if( ! $alreadySetup && WRoles::isAdmin( 'manager' ) && 'setup' !=WGlobals::get( 'task' ) && ! WPref::load( 'P' . strtoupper( $shortName ) . '_APPLICATION_INSTALLED' )){
										$exist=WController::get( $shortName . '.setup', null, null, false );

										WGlobals::setSession( 'installApp', $shortName, true );

										if( $exist){
						$url=WPage::routeURL( 'controller=' . $shortName . '&task=setup', 'smart', 'default', false, true, $shortName );
						WPages::redirect( $url );
					}
				}

								$control=WGlobals::get( 'controller' );
				if( WRoles::isAdmin( 'manager' )
				&& ! $control !=$shortName
				&& ! in_array( WGlobals::get( 'task' ), array( 'setup', 'welcome', 'preferences', 'dashboard', 'home', 'installpage', 'installnow', 'show', 'applypref', 'savepref', 'cancel', 'save', 'apply' ))
				){

					static $onlyOnce=true;
					$welcomePage=WPref::load( 'P' . strtoupper( $shortName ) . '_APPLICATION_WELCOME' );
					if( $onlyOnce && empty($welcomePage)){
						$onlyOnce=false;


																		$appPref=WPref::get( $shortName . '.application' );
						$appPref->updateUserPref( 'welcome', 1 );
						WPages::redirect( 'controller=' . $control . '&task=welcome' );
					}				}			}
		}

				$this->_eid=WGlobals::getEID( true );

		if( !isset($this->sid)){
			$myTrucs=WGlobals::get( 'trucs' );

			$this->sid=( !empty($myTrucs['s']['mid']) ? $myTrucs['s']['mid'] : 0 );
		}
		$formTask=strtolower( WGlobals::get( 'task', '', null, 'string' ));

						if( WGlobals::get('wajx')
		|| JOOBI_FRAMEWORK=='netcom'
		){

			
			$this->task=$formTask;

			$task=$this->task;
						if( 'toggle'==$task ) $this->_loadToggleInfo();

			if( method_exists( $this, $task)){
				$status=$this->$task();
												if( is_string($status)) return $status;

							}else{
				$resultStatus=$this->display();
				return $resultStatus;
			}			return;

		}else{
									if( 'toggle'==$formTask ) $this->_loadToggleInfo();
		}
				WGlobals::set( 'wz_page_tile', true, 'global' );
		$this->status=$this->create();
				$alreadyHTML=WGlobals::get( 'alreadyHTML' , false, 'global' );	
				if( !empty($alreadyHTML)){
			return $alreadyHTML;
		}elseif( $this->status===false){
			$this->content='';
			return $this->display();
		}elseif( ! $this->_displayView){				return $this->display();
		}
			if( !empty($this->viewNamekey) || !empty($this->yid)){

				$yid=( !empty($this->viewNamekey)) ? $this->viewNamekey : $this->yid;
				$this->_redirect( $yid );

				
			}else{

												WGlobals::set( 'task', '' );

				if( !empty($this->viewNamekey)){
					$yidRedir=$this->viewNamekey;
				}else{
					$yidRedir=WController::get( $this->controller, 'yid' );
				}
				if( empty($yidRedir)){
						$controller=$this->controller;
						$mess=WMessage::get();
						$mess->codeE( 'The controller ' . $controller . ' does not have view defined!' );
					return false;
				}				$this->layout=WView::get( $yidRedir ); 				if( !is_object($this->layout) || empty($this->layout)){
						$controller=$this->controller;
						$mess=WMessage::get();
						$mess->codeE( 'Could not get the layout ' . $yidRedir . ' for the controller '. $controller );
					return false;
				}				$this->content='';
								if( !empty($this->viewHTMLBefore)) $this->content .=$this->viewHTMLBefore;

				$this->content .=$this->layout->make();
				if( !empty($this->viewHTMLAfter)) $this->content .=$this->viewHTMLAfter;


				return $this->display();

			}
				$this->beforeDisplay();

		return $this->display();

	}





	function create(){

				if( self::$_firstCrtl){
			self::$_firstCrtl=false;
			$this->task=strtolower( WGlobals::get( 'task', '', null, 'string'));


		}
				$task=str_replace( '-', '_', $this->task );
				if( method_exists( $this, $task )){	
						if( $this->_checkOwnerShip && !$this->checkOwnership()) return false;

			$this->status=$this->$task();

						if( $this->saveauto ) exit;


			if( $this->trigger > 1){					if( !isset($this->triggerObject)){
					$myModel=isset($this->model) ? $this->model : $this->_model;
					$this->setTrigger( $myModel );
				}				WController::trigger( $this->controller, $task, $this->triggerObject, $this->status );
			}
		}else{

			if( $this->path){
								$this->status=false;
			}else{
				$this->status=true;
			}
		}

		return $this->status;

	}





	function setTrigger(&$obj){
		$this->triggerObject=&$obj;
	}









	public static function trigger($trigger,$action,&$params,$status=null){
		static $onlyOnce=array();	
		$action=strtolower($action);
		$trigger=strtolower($trigger);
		if( isset($onlyOnce[$trigger.$action])) return;
		$onlyOnce[$trigger.$action]=true;

		$tempdata=WController::ooController( $trigger, $action, true );
				if( !empty($tempdata) && $tempdata->trigger >=10){
			$triggerC=WClass::get( 'library.trigger' );
			$triggerC->actions( $tempdata, $params, $status );
		}
	}




	public function edit(){

		if( $this->_eid > 0){
			WGlobals::set( 'eid', $this->_eid );
		}
		$eid=WGlobals::getEID( true );

		if( empty( $eid )){
		  $task=WGlobals::get( 'task' );
		  if( $task!='preferences'){  		  			$message=WMessage::get();
			WText::t('1301400596BMSM');
            $message->historyE('1301400596BMSM');
            return false;
		  }		}
		return true;

	}






	protected function dontCheckOwnership(){
		$this->_checkOwnerShip=false;
	}





	protected function checkOwnership($showMesssage=true){

				if( empty($this->_eid) || empty($this->_eid[0])){
			return true;
		}
		if(( WRoles::isNotAdmin( 'storemanager' ) && !empty($this->checkowner)) || !empty( $this->checkadminowner )){

			$getNodeFolder=WExtension::get( $this->wid, 'folder' );
			
			$classOwnershipC=WClass::get( $getNodeFolder . '.ownership', null, 'class', false );
			if( !empty($classOwnershipC)){

					if( $classOwnershipC->isOwner( $this->_eid )){
						return true;
					}else{

						if( $showMesssage){
							$this->userE('1375910823SPLE');
						}
						return false;

					}
			}else{

				$message=WMessage::get();
				$message->codeE( 'The Ownership class does not exist for the node : ' . $getNodeFolder );
				return false;

			}
		}
		return true;

	}




	public function add(){

		WGlobals::setEID( 0 );
		$this->_eid=0;

	}




	public function back(){
		WPages::redirect( 'previous' );
	}






	public function presave($skipRedirect=false){

		$this->save();
		$eid=$this->getElement();
		WGlobals::setEID( $eid );
		if( !$skipRedirect){
			$controller=WGlobals::get( 'controller' );
			WPages::redirect( 'controller='. $controller . '&task=edit&eid='. $eid );
		}
		return true;

	}




	public function donepref(){
		return $this->savepref();
	}




	public function savepref(){

				$savePrefC=$this->_createFileInstance( 'save_preferences' );
		$status=$savePrefC->savepref( $this );

				$extensionHelperC=WCache::get();
		$extensionHelperC->resetCache( 'Menus' );
		return $status;

	}




	public function applypref(){
		$this->savepref();
		WPages::redirect( 'controller=' . $this->app . '&task=preferences' );
	}













	function loadpref(){
		WLoadFile( 'save_preferences', JOOBI_LIB_CORE . 'controller' .  DS );
		$savePrefC=new WPreferences_Save;
		return $savePrefC->loadpref( $this );
	}




	public function preferences(){
		$this->edit();
	}




	public function show(){
		 $eid=WGlobals::getEID();

		 if( empty( $eid )){
			$message=WMessage::get();
            $message->userE('1250777180DFSL');
            return false;
		}
		$this->editItem=false;
		$this->_eid=$eid;
		$this->numberOfTagIterationBeforeDisplay=2;


		$this->noLayout=true;

	}





	public function returnId(){
		$this->_getlastId=true;
	}






	public function done(){
		return $this->save();
	}





	public function save(){

				if( !empty($this->_eid) && ! $this->checkOwnership())  return false;

		$savePrefC=$this->_createFileInstance( 'save' );
		$status=$savePrefC->save( $this, $this->_getlastId );

				$controller=WGlobals::get( 'controller' );

				WGlobals::set( 'trucs', null );
		$tempdata=WController::ooController( $controller, '' );
		if( !empty($tempdata)) WGlobals::set( 'task', $tempdata->task );

		return $status;

	}






	function getTruc($anotherArray=array()){
		$savePrefC=$this->_createFileInstance( 'save' );
		return $savePrefC->getTruc( $this, $anotherArray );
	}

	protected function getUploadedFiles(){
		$savePrefC=$this->_createFileInstance( 'save' );
		return $savePrefC->getUploadedFiles();
	}








	public static function getFormValue($property,$model='x',$default=null,$notInTrucs=false){
		static $trucs=array();

		$trucs=WGlobals::get( 'trucs', null, 'post', 'array' );

		if( !isset($default)) $default=WForm::getPrev( $property, $model );	
		if( $model=='x'){
			return ( isset($trucs[$model][$property])) ? $trucs[$model][$property] : $default;
		}else{
			if( !is_numeric($model)) $model=WModel::get( $model, 'sid' );
			if( $notInTrucs){
				$reqeustData=WGlobals::get( null, null, 'post', 'array' );
				$map=$property . '_' . $model;
				return ( isset($reqeustData[$map])) ? $reqeustData[$map] : $default;
			}else{
				return ( isset($trucs[$model][$property])) ? $trucs[$model][$property] : $default;
			}
		}
	}







	public static function setFormValue($property,$model,$value){

		$trucs=WGlobals::get( 'trucs', null, 'post', 'array' );
		if( !is_numeric($model) && 'x' !=$model ) $model=WModel::get( $model, 'sid' );
		if( empty( $model ) || empty($property)) return false;
		$trucs[$model][$property]=$value;
		WGlobals::set( 'trucs', $trucs, 'POST' );

	}

	


	public function apply(){

				if( !empty($this->_eid) && !$this->checkOwnership())  return false;

		$this->returnId();
		$status=$this->save();
		$this->_showListing=false;

		WGlobals::set( 'trucs', null );

				if( empty( $this->_eid )) return $status;
		WView::form( null, true );

		WGlobals::setEID( $this->_eid );
		$this->edit();

		return $status;

	}




	public function core(){

		$eids=WGlobals::getEID( true );

				if( !$this->checkOwnership()) return false;

		if( !empty($eids)){
			$model=WModel::get($this->sid);
			$model->whereIn( $model->getPK() ,$eids);
			$model->setVal( 'core', $model->setCalcul( 1,'-', 'core' , null, 0 ));
			$model->update();
		}
				$this->task='listing';
		return true;

	}




	public function publish(){

				if( !$this->checkOwnership()) return false;

		$eids=WGlobals::getEID( true );
		if( !empty($eids)){
			$model=WModel::get($this->sid);
			$model->whereIn( $model->getPK(),$eids);
			$model->setVal('publish',$model->setCalcul(1,'-','publish',null,0));
			$model->update();
		}				$this->task='listing';
		return true;
	}



	public function copy(){

				if( !$this->checkOwnership()) return false;

		$savePrefC=$this->_createFileInstance( 'save' );
		$status=$savePrefC->copy( $this );
				$this->task='listing';
		return $status;
	}




	public function copyall(){

				if( !$this->checkOwnership()) return false;

		$savePrefC=$this->_createFileInstance( 'save' );
		$status=$savePrefC->copyall( $this );
				$this->task='listing';
		return $status;
	}





	public function deleteall(){

				if( !$this->checkOwnership()) return false;

		$savePrefC=$this->_createFileInstance( 'save' );
		$status=$savePrefC->deleteall( $this );
				$this->task='listing';
		return $status;
	}






	public function delete(){

				if( !$this->checkOwnership()) return false;

		$savePrefC=$this->_createFileInstance( 'save' );
		$status=$savePrefC->delete( $this );
				$this->task='listing';

		return $status;

	}




	public function toggle(){

		$this-> _loadToggleInfo();
		WLoadFile( 'toggle', JOOBI_LIB_CORE . 'controller' .  DS );
		$toggleClass=new WController_Toggle;
		$toggleClass->toggle( $this );
				$this->task='listing';
		return true;
	}









	function customToggle($value,$eid,$prevID){
		WLoadFile( 'toggle', JOOBI_LIB_CORE . 'controller' .  DS );
		$toggleClass=new WController_Toggle;
		$toggleClass->customToggle( $value, $eid, $prevID );
		return true;
	}



	public function order(){

		$this-> _loadToggleInfo();
						
		$action=$this->getToggleValue( 'action' );
		$sidToOrder=$this->getToggleValue( 'model' );
		if( empty($sidToOrder)) $sidToOrder=$this->sid;
		switch( $action){
			case 'all':					$status=$this->saveorder();
				$this->showM(  $status, 'order' ,1 ,$sidToOrder );						break;
			case 'up':					WLoadFile( 'saveorder', JOOBI_LIB_CORE . 'controller' .  DS );
				$orderClass=new WController_Saveorder;
				$status=$orderClass->reOrder( -1 , $sidToOrder );
				break;
			case 'down':					WLoadFile( 'saveorder', JOOBI_LIB_CORE . 'controller' .  DS );
				$orderClass=new WController_Saveorder;
				$status=$orderClass->reOrder( 1 , $sidToOrder );
				break;
			default:
				break;
		}
						WGlobals::setEID( 0 );

				$this->task='listing';
		return true;

	}







	public function saveorder(){

		if( !isset($this->_order)) $this->_order 	=WGlobals::get( 'order', array(), 'post', 'array' ); 
		
		if(empty($this->_order)){
			return false;
		}
		$this-> _loadToggleInfo();

		$crossTableSorting=!empty($this->taskvar[2]) ? $this->taskvar[2] : false;

		if( empty($this->_eid) || !is_array($this->_eid)){
						$trucsInfo=WGlobals::get( 'trucs' );
			$mapBis=$trucsInfo['s']['pkey'];				$sidBis=$this->getToggleValue( 'model' );
			$this->_eid=WGlobals::get( $mapBis . '_' . $sidBis );

			if( empty($this->_eid) || !is_array($this->_eid)){
				return false;

			}		}
		$sidToOrder=$this->getToggleValue( 'model' );
		if( empty($sidToOrder)) $sidToOrder=$this->sid;

		foreach( $this->_order as $id=> $order){
			if(!empty($this->_eid[$id])) $valuesToOrder[ $this->_eid[$id] ]=$order;
		}
		if( !empty($this->_groupingValue)) $groupingValue=$this->_groupingValue;
		else {
			$groupingValue='';
		}		WLoadFile( 'saveorder', JOOBI_LIB_CORE . 'controller' .  DS );
		$orderClass=new WController_Saveorder;
		$orderClass->saveorder( $valuesToOrder, $sidToOrder, $groupingValue, $crossTableSorting );

				$this->task='listing';

		return true;

	}





	function cancel(){
				$this->task='listing';
		return true;
	}



	function listing(){
		return true;
	}







	protected function beforeDisplay(){
		return true;
	}




	function rss(){

				$this->task='rss';
		return true;
	}



	function csv(){

		$savePrefC=$this->_createFileInstance( 'csv' );
		$status=$savePrefC->csv( $this );
				$this->task='csv';

		return $status;
	}



	function pdf(){

		$savePrefC=$this->_createFileInstance( 'pdf' );
		$status=$savePrefC->pdf( $this );
				$this->task='pdf';

		return $status;
	}



	function dashboard(){

		$layout=WView::get( WApplication::name( 'short' ) . '_dashboard' );			if( empty($layout)) return false;
		return true;

	}






	function autocheck(){

				$sid=WGlobals::get('sid');
		$map=WGlobals::get('map');
		$value=WGlobals::get('value');
		$custom=WGlobals::get('custom');
		$eid=WGlobals::getEID();
		$exist='';
		if( !empty($sid) && !empty($map) && !empty($value)){
						$model=( is_numeric($sid)) ? WModel::get( $sid, 'namekey' ) : $sid;
			$myModel=WModel::get( $model );
			$myModel->whereE( $map, $value );
			if( !empty($eid) && empty($custom)) $myModel->where( $myModel->getPK(), '!=', $eid );
			$exist=$myModel->exist();
		}
		echo $exist;
		exit();

	}




	public function display(){



		

				$pageT=WPage::theme( 'main' );
		if( !defined('JOOBI_URL_THEME_JOOBI')){
			WView::definePath();
		}
								WPage::addCSSFile( 'css/style.css' );

		$h='';


		$isPopUp=WGlobals::get( 'is_popup', false, 'global' );

				if( IS_ADMIN){

						$reserved=array( 'add', 'edit', 'apply', 'preferences' );

			$hideMenu=WGlobals::get( 'hidemainmenu', 0 );
						if( !in_array( $this->task, $reserved ) && !$hideMenu && !$isPopUp){
				$pageT->setContent( 'tabs', $this->_createSubMenu());
			}else{
				WGlobals::set( 'hidemainmenu', 1 );				}		}else{

			$feYID=WGlobals::get( 'fe-horizontal-menu-yid', '', 'global' );
			if( !empty($feYID) && !$isPopUp){
				$expolodedFEyid=explode( '-', $feYID );
				$pageT->setContent( 'tabs', $this->_createFEHorizontalMenu( $expolodedFEyid[0] ));
			}
		}
				$pageT->setContent( 'viewBodyClass', ( !empty($this->layout->viewClass) ? ' ' . implode( ' ', $this->layout->viewClass ) : '' ));

				$pageT->setContent( 'information', $this->_infoMessage());

				if( !empty($this->layout->wname)){
			$wizardO=new stdClass;
			$wizardO->wname=$this->layout->wname;
			$wizardO->wdescription=$this->layout->wdescription;
			$wizardO->showWizard=$this->layout->wizard;
			$pageT->setContent( 'wizard', WPage::renderBluePrint( 'wizard', $wizardO ));
		}

		$debugTrace=WGlobals::get( 'debugTraces', '', 'global' );
		if( !empty($debugTrace)){
			$pageT->setContent('debugTrace', $debugTrace );
			WGlobals::set( 'debugTraces', '', 'global', true );						}

		if( ! IS_ADMIN && WRole::hasRole( 'admin' ) && JOOBI_APP_DEVICE_TYPE=='bw'){
			$setupHelp=WPref::load( 'PMAIN_NODE_SHOWCONFIG' );
			if( !empty($setupHelp)){
				$mainConfigC=WClass::get( 'main.confighelper', null, 'class', false );
				if( !empty( $mainConfigC )){
					$pageT->setContent( 'configHelper', $mainConfigC->renderConfig());
					$pageT->setContent( 'configHelperTitle', WText::t('1416665748MZJC'));
				}
			}		}
		if( JOOBI_APP_DEVICE_TYPE=='bw' && WRole::hasRole( 'admin' )){
			$setupHelp=WPref::load( 'PMAIN_NODE_SHOWVIEWSDETAILS' );
			if( !empty($setupHelp)){
				if( !empty($mainConfigC)) $mainConfigC=WClass::get( 'main.confighelper', null, 'class', false );
				if( !empty( $mainConfigC )){
					$pageT->setContent( 'viewDetails', $mainConfigC->renderViewDetails());
					$pageT->setContent( 'viewDetailsTitle', WText::t('1416904418KIYP'));
				}
			}		}
				if( !empty($this->content)) $pageT->setContent( 'application', $this->content );

		if( IS_ADMIN){
			$pageT->type=2;
		}else{
			$outputSpaceC=WClass::get( 'output.space' );
			$spaceO=$outputSpaceC->findSpace();
			$pageT->type=$spaceO->themeType;
		}
		$pageT->file='index.php';

				
		$numberOfTagIterationBeforeDisplay=0;
		$h .=$pageT->display( array(), null, $this->numberOfTagIterationBeforeDisplay );

				$bottomMenu=WGlobals::get( 'menuBottomLayout', null, 'global' );
		if( isset($bottomMenu)) $h .=$bottomMenu;

		$b=WGlobals::get( 'addFooter', null, 'global', 'html' );
		if( isset($b)){
			$h .=$b;
		}
				$h .=$this->_createPe(); 
						WPage::declareJS();

		return $h;

	}






	protected function setView($viewNamekey){
		if( !empty($viewNamekey)) $this->viewNamekey=$viewNamekey;
	}





	protected function getElement($property=''){
		if( empty($property)){
						$property=$this->_model->getPK();
		}		return isset( $this->_model->$property ) ? $this->_model->$property : null;

	}



	protected function skipMessage($status=true){
		$this->_skipMessage=$status;
	}





	public function getToggleValue($property){

		if( isset($this->_toggleO->$property)) return $this->_toggleO->$property;
		else {
			return null;
		}
	}





	private function _loadToggleInfo(){

		$this->_toggleO=new stdClass;
		$this->_toggleO->model=WGlobals::get( 'zsid' );
		$this->_toggleO->map=WGlobals::get( 'zmap' );
		$this->_toggleO->value=WGlobals::get( 'zval' );
		$this->_toggleO->field=WGlobals::get( 'zfld' );
		$this->_toggleO->action=WGlobals::get( 'zact' );
		$this->_toggleO->secure=WGlobals::get( 'zsc' );

	}





	private function _createSubMenu(){

		$option=WApplication::name( 'short' );

		$caching=WPref::load( 'PLIBRARY_NODE_CACHING' );
		$getModel=true;


		if( $caching > 5){
						$langToUse=WUser::get('lgid');
			$chachingKey=$option . $langToUse . '-' . WUser::get( 'uid' );
			$cache=WCache::get();
			$cachedSubMenu=$cache->get( 'subzMenu'. $chachingKey, 'Menus' );
			if( !empty($cachedSubMenu)) $getModel=false;
			WGlobals::set( 'horizontal-menu', true, 'global' );
		}
		if( $getModel){

			$controller=new stdClass;
			$controller->ctrid=$this->ctrid;
			if( isset($this->controller)) $controller->controller=$this->controller;
			$controller->task=$this->task;
			if( isset($this->path)) $controller->path=$this->path;
			$controller->wid=$this->wid;
			if( isset($this->mine)) $controller->mine=$this->mine;

						if( IS_ADMIN && 'wordpress'==JOOBI_FRAMEWORK_TYPE && 'jvendor'==$option){
				$backEndMenu='vendors_node_horizontalmenu_fe';
			}else{
				$backEndMenu=$option . '_main';
			}
			$layout=WView::getHTML( $backEndMenu, $controller );	
			if( !isset($layout->yid)) return '';
			$layout->subtype=115;
			$HTML=$layout->make();

			if( $caching > 5){
				$cache->set( 'subzMenu' . $chachingKey, $HTML, 'Menus' );
				$cache->set( 'subzMenuCSS' . $chachingKey, WGlobals::get('horizontal-menu', false, 'joobi'), 'Menus' );
			}
		}else{

			
			if( $caching > 5){
				$cachedSubMenuCSS=$cache->get( 'subzMenuCSS' . $chachingKey, 'Menus' );
				WPage::addCSSScript( $cachedSubMenuCSS );
				$HTML=$cachedSubMenu;
			}else{
				WPage::addCSSScript( WGlobals::get('horizontal-menu', false, 'joobi'));
			}		}
		return $HTML;

	}






	private function _createFEHorizontalMenu($feYID){

		
		$controller=new stdClass;
		$controller->ctrid=$this->ctrid;
		if( isset($this->controller)) $controller->controller=$this->controller;
		$controller->task=$this->task;
		if( isset($this->path)) $controller->path=$this->path;
		$controller->wid=$this->wid;
		if( isset($this->mine)) $controller->mine=$this->mine;
		$layout=WView::getHTML( $feYID, $controller );
		if( !isset($layout->yid)) return '';
		$layout->subtype=115;
		$HTML=$layout->make();	

		return $HTML;

	}





	protected function dontDisplayView($display=false){
		$this->_displayView=$display;
	}









	function showM($status,$type,$NUMBER=1,$sid=0,$modelName=null){

		$message=WMessage::get();

				if( !$this->_skipMessage && isset($this->_model) && method_exists( $this->_model, 'loadSkip' )){
			$this->_skipMessage=$this->_model->loadSkip();
		}		if( $this->_skipMessage===true ) return $status;

		if( empty($sid) && !empty($this->_model->_infos)){
			$sid=$this->_model->getModelID();
		}
						$stringToDisplay=$this->_loadMessage( $type, $sid, $status, $NUMBER, $modelName );
		if( is_string($this->_skipMessage)) $stringToDisplay .=$this->_skipMessage;

		if($status) $message->setS( $stringToDisplay, false );
		else $message->setE( $stringToDisplay, false );

		return $message->M( $status );

	}





	function getModel(){
		return $this->_model;
	}







public static function ooController($controller,$task='',$trigger=false,$showMessage=true){

	$caching=WPref::load( 'PLIBRARY_NODE_CACHING' );
	$caching=( $caching > 5 ) ? 'cache' : 'static';

	if( is_numeric($controller)){
		$namekey=$controller;
	}else{
		if( strpos( $controller, '.' )){
		    $namekey=$controller;
		}else{
		    $namekey=$controller . '.' . $task . ( WRoles::isAdmin( 'manager' ) ? '.1' : '' );
		}
	}
		$tempdata=WCache::getObject( $namekey, 'Controller', $caching, true );		if( empty($tempdata)) $tempdata=WCache::getObject( $namekey, 'Controller', 'static', true );

	if( empty($tempdata)){

		if( $showMessage){
			$message=WMessage::get();
			if( empty($controller)) $mess='The controller is empty, so check if you passed a correct controller or check your url' ;
			else $mess='The controller was not found for the following name: ' . $controller . (( !empty($task)) ? ' and task: '.$task : '' ) .' .  Check that you have a controller defined!';

			if( WRoles::isAdmin( 'manager' )){
				$message->userE( $mess );
			}else{
				$message->codeE( $mess, null, false );
			}		}
		if( ! $trigger){
						$controllerM=WModel::get( 'library.controller' );
			$controllerM->whereE( 'namekey', $namekey );
			$rolid=$controllerM->load( 'lr', 'rolid' );

			if( $showMessage){
				if( !empty($rolid)){
					$ROLENAME=WRole::get( $rolid, 'name' );
					$message->userW('1416904418KIYQ',array('$ROLENAME'=>$ROLENAME));
				}else{
					$message->userW('1206732348RCNP');
				}
			}
		}
		return null;
	}
			if( !empty($tempdata->superolid)){
		if( $tempdata->override==9){				$tempdata->superOverride=true;
		}elseif( $tempdata->override==9){
			$tempdata->superOverride=false;
		}else{						$roleC=WRole::get();
	        $roleCompR=$roleC->compareRole( $tempdata->rolid, $tempdata->superolid );
			if( $roleCompR===true || $roleCompR===false){
								$tempdata->superOverride=false;
			}else{
								$tempdata->superOverride=true;
			}		}
	}

	return $tempdata;

}





	public function wizard(){

								$preferences=WPref::get( 'library.node' );
		$preferences->updateUserPref( 'wizard', ! WPref::load( 'PLIBRARY_NODE_WIZARD' ));

		exit();

	}




	public function help(){
		exit();
	}





	public function welcome(){

		$this->dontDisplayView();

		$mainWelcomeC=WClass::get( 'library.welcome' );
		$this->content=$mainWelcomeC->welcome();

		return true;

	}





	public function setup(){

		$shortName=WApplication::name( 'short' );
		$prefO=WPref::get( $shortName . '.application' );
		$prefO->updatePref( 'installed', 1 );

	}




	function check(){

		$model=WModel::get( $this->sid );

		$autoCheck=WClass::get( $this->controller . '.autocheck' );
		if( empty($autoCheck)) return false;

		if( $model->multiplePK()) return false;				$status=true;

		if( !empty($this->_eid)){

			foreach( $this->_eid as $k=>$eid){
				if( $eid>0){
					$autoCheck->run( $eid );
				}else{
																															$allIDS=$model->load('lra', $model->getPK());

					$status=$this->_checkOne( $allIDS );

				}			}
		}else{
			
						$total=$model->total();	
												if( $total<1000){
				$allIDS=$model->load('lra', $model->getPK());

				$status=$this->_checkOne( $allIDS );

			}else{
				$message=WMessage::get();
				$message->codeE( 'There is too many elements to be checked at once.' );
				$message->codeW( 'No element have been checked!' );
			}
		}
		$exteC=WCache::get();
		$exteC->resetCache();

		$this->showM(  $status, 'check', 1, $this->sid );
		return true;

	}

	public function getControllerSaveOrder(){
		return $this->_controllerSaveOrder;
	}
	public function setControllerSaveOrder($order=false){
		$this->_controllerSaveOrder=$order;
	}





	public static function resetTask(){
		self::$_newTask=null;
		self::$_firstCrtl=true;
	}





	public static function resetAllRequest(){
		$rA=array();
		$rA['controller']='';
		$rA['task']='';
		$rA['trucs']=array();
		foreach( $rA as $p=> $v ) WGlobals::set( $p, $v );
	}




	private static function _cleanTask(){

		if( isset(self::$_newTask)) return self::$_newTask;

				$task=WGlobals::get( 'task', '', null, 'string' );
		self::$_newTask=$task;

		$taskA=explode( '&', $task );
		if( count($taskA) > 1){
			self::$_newTask=array_shift($taskA);
			WGlobals::set( 'task', self::$_newTask );

			if( !empty( $taskA )){
				foreach( $taskA as $oneVar){
					$splitA=explode( '=', $oneVar );
					if( count($splitA) > 1){

						WGlobals::set( $splitA[0], $splitA[1] );
					}				}			}		}
				if( 'user.logout'==self::$_newTask ) self::$_newTask='';
		return self::$_newTask;

	}









	private function _loadMessage($type,$sid,$status,$NUMBER,$ELEMENT=''){

		if( !empty($sid)){
									$model=WModel::get($sid,'object');
			$modelName=$model->getTranslatedName();

						$ELEMENT=ucwords( $modelName );
		}else{
			$ELEMENT='';
		}

				$moreElements=$NUMBER > 1 ? true : false;

						switch( $type){
			case 'delete' :
				if($status){
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZFP'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZFQ'));
					}
				}else{
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZFR'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZFS'));
					}
				}
				break;

			case 'save' :
				if($status){
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1298350415EJMQ'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1298350415EJMR'));
					}
				}else{
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZFV'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZFW'));
					}
				}
				break;
			case 'update' :
				if($status){
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1298350415EJMS'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1298350415EJMT'));
					}
				}else{
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZFZ'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZGA'));
					}
				}
				break;
			case 'order' :
				if($status){
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1298350415EJMU'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1298350415EJMV'));
					}
				}else{
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZGD'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZGE'));
					}
				}
				break;
			case 'create' :
				if($status){
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1298350415EJMW'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1298350415EJMX'));
					}
				}else{
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZGH'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZGI'));
					}
				}
				break;
			case 'savedefault' :
				if($status){
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1298350415EJMY'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1298350415EJMZ'));
					}
				}else{
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZGL'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZGM'));
					}
				}
				break;
			case 'checkin' :
				if($status){
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1298350415EJNA'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1298350415EJNB'));
					}
				}else{
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZGP'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZGQ'));
					}
				}
				break;
			case 'copy' :
				if($status){
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1298350415EJNC'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1298350415EJND'));
					}
				}else{
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZGT'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZGU'));
					}
				}
				break;
			case 'check' :
				if($status){
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1298350415EJNE'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1298350415EJNF'));
					}
				}else{
					if($moreElements){
						return str_replace(array('$NUMBER','$ELEMENT'), array($NUMBER,$ELEMENT),WText::t('1242010181DZGP'));
					}else{
						return str_replace(array('$ELEMENT'), array($ELEMENT),WText::t('1242010181DZGQ'));
					}
				}
				break;
		}				if($status) return WText::t('1235462003CNHC');
		return WText::t('1206732345BHSJ');
	}







	private function _createFileInstance($localtion='save'){
		static $instance=array();
		if( !isset( $instance[$localtion] )){
			WLoadFile( $localtion, JOOBI_LIB_CORE . 'controller' .  DS );
			$className='WController_' . $localtion;
			$instance[$localtion]=new $className;
		}
		return $instance[$localtion];

	}





	private function _infoMessage(){

		$optionL=WApplication::name( 'short' );
		$myStatus=isset($_SESSION['extInfo'][$optionL]['licence']) ? $_SESSION['extInfo'][$optionL]['licence'] : '' ;
		$message='';
		switch ($myStatus){
			case'noyet':					$message='You have not yet installed your license.  Follow this link if you want to do so';
				break;
			case'askfor':					$message='With Plus or PRO version you will get much more benefits.  Click here to learn more!';
				break;
		}
	}





	private function _redirect($yid){
		

				
		unset( $this->sid );
    	$this->layout=WView::get( $yid, $this->viewOutput, $this->viewParams );

    	if( !empty($this->layout)) $this->content=$this->layout->make();



		return true;
	}













	private function _createPe(){

		if( WGlobals::get( 'is_popup', true, 'global' )) return '';

		$foterHTML='';
		
				if( WRoles::isAdmin( 'storemanager' )){
			$show='link';			}else{
			$s=WGlobals::getSugar();
			if( $s==201){
				$show=false;
			}elseif( $s==101){
				$show='link';
			}else{
				$show='banner';
			}
		}
		if( $show=='link' || $show=='banner'){

			$application=WApplication::name('short');
			$wid=WExtension::get( $application.'.application', 'wid' );

			if( !empty($application)){
				if( isset($_SESSION['extInfo'][$application]['name'] )){
					$extInfo=$_SESSION['extInfo'][$application]['name'];
				}else{

					if( !empty($wid)){
												$extM=WModel::get( 'install.appsinfo' );
						$extM->whereE( 'wid', $wid );
						$extInfo=$extM->load( 'o', array( 'homeurl', 'keyword' ));

						if( !empty( $extInfo )){
							$extInfo->name=WExtension::get( $wid, 'name' );
							$_SESSION['extInfo'][$application]['name']=$extInfo;
						}
					}
				}			}
			if( empty($extInfo)){
				$extInfo=new stdClass;
				$extInfo->name='Joobi Application';
			}
			if( !defined('JOOBI_URL_JOOBI_IMAGES')) WView::definePath();
			$a='<br /><p class="copyright">' . str_replace( ' Core', '', $extInfo->name );				$a .=' <a href="http://www.joobi.co" target="_blank">Joomla'.' '.'extensions</a>';

			if( !empty($extInfo->keyword) && !empty($extInfo->homeurl)){
				$a .=' ' . WTExt::translate('for'). ' <a href="'.$extInfo->homeurl.'" target="_blank">' . $extInfo->keyword . '</a>';
			}
			$a .=' powered' . ' by ';
			$logoImg=WPage::addImage( JOOBI_FOLDER . '/in'.'c/l'.'ib/ima'.'ges/lo'.'go.p'.'ng', 'home' );
			$a .='<img src="' . $logoImg . '">';
			$a .='Joobi.</p>';

			
			$html=new WDiv( $a );
			$html->clear=true;
			$html->align='center';
			$foterHTML='<div class="clearfix clr"></div>' . $html->make();

		}
		if( $show=='banner'){

			$foterHTML .='<center><a href="http://www.joobi.co" target="_blank">';
			$foterHTML .='<img alt="Joobi" src="' . WPref::load( 'PLIBRARY_NODE_CDNSERVER' ) . '/'.'joobi'.'/'.'user'.'/'.'media'.'/'.'b.g'.'if">';
			$foterHTML .='<img alt="Joobi" src="' . WPref::load( 'PLIBRARY_NODE_CDNSERVER' ) . '/'.'joobi'.'/'.'user'.'/'.'media'.'/'.'c.p'.'ng">';
			$foterHTML .='</a></center>';

		}
		return $foterHTML;

	}







	private function _checkOne($allIDS){

		$autoCheck=WClass::get( $this->controller.'.autocheck');
		$status=true;
		foreach( $allIDS as $k=> $sid){
			if( !$autoCheck->run( $sid )){
				$status=false;
				break;
			}		}
		return $status;

	}









	public function getSQL($cKey,$showMessage=true){

		$task='';
		if( is_numeric($cKey)){
			$controller=$cKey;
		}else{
			$cKeyA=explode( '.', $cKey );
			$isAdmin=array_pop($cKeyA);
			if( is_numeric($isAdmin)){
				$task=array_pop($cKeyA);
			}else{
				$task=$isAdmin;
			}			$controller=implode( '.', $cKeyA );
		}

		$tempdata=null;
		if( is_numeric($controller)){
						$tempdata=WController::getSQLFromDB( $controller );			}else{
						$tempdata=WController::getSQLFromDB( $controller, $task );				if( empty($tempdata) || !empty($tempdata->reload)){
								if( !is_numeric($cKey)){
					$reload=WController::checkExistFileForInserting( $controller, $task );						$tempdata=WController::getSQLFromDB( $controller, $task );						if( !empty($tempdata)){																			$controllerM=WModel::get( 'library.controller', 'object' );
						$controllerM->whereE( 'app', $controller );
						$controllerM->openBracket();
						$controllerM->whereE( 'task', $task );
						$controllerM->operator( 'OR' );
						$controllerM->whereE( 'premium', 1 );
						$controllerM->closeBracket();
						$controllerM->setVal( 'reload', 0 );
						$controllerM->update();
					}
				}			}
		}
		return $tempdata;

	}







	private static function getSQLFromDB($controller,$task=''){

		$controllerM=WModel::get( 'library.controller','object' );
		
		if( is_numeric($controller)){
						$controllerM->whereE( 'ctrid', $controller );
		}else{
						$controllerM->whereE( 'app', $controller );
			if( empty($task)) $controllerM->whereE( 'premium', 1 );				else $controllerM->whereE( 'task', $task );
		}
		if( WRoles::isAdmin( 'manager' )){
						$controllerM->orderBy( 'admin', 'DESC' );
		}else{
			$controllerM->whereE( 'admin', 0 );
		}
		$controllerM->whereE( 'publish', 1 );

		
				
				$controllerM->select( '*' );

		$tempdata=$controllerM->load( 'o' );

		if( empty($tempdata)){
			if( !empty(self::$WMessageLog)) WMessage::log( self::$WMessageLog, 'error_controller' );
		}else{
			$tempdata->id=!empty($tempdata->ctrid) ? $tempdata->ctrid : 0;
		}
		return $tempdata;

	}








	private static function checkExistFileForInserting($controller,$task){

		self::$WMessageLog=array();

		static $readingFileC=null;


				if( ! empty($task) &&  strpos($task, "&") !==false){
			$tasksArr=explode("&", $task);
			$task=$tasksArr[0];
		}

		$explodeControllerA=explode( '-', $controller );
		if( empty($explodeControllerA[1])){
			$explodeControllerA=explode( '.', $controller );
		}

		$fileC=WGet::file();

		$allFilesToLoadA=array();
				$allFilesToLoadA[]='1.'. $controller . '.1';
		$allFilesToLoadA[]='1.'. $controller;
		$allFilesToLoadA[]='0.'. $controller . '.' . $task . '.1';
		$allFilesToLoadA[]='0.'. $controller . '.' . $task;

		foreach( $allFilesToLoadA as $oneFileName){
			$file=JOOBI_DS_NODE .$explodeControllerA[0] . DS.'database' . DS . 'data' . DS . 'controller' . DS . $oneFileName . '.cca';
			if( $fileC->exist( $file )){
				WController::insertingFile( $file );				}
		}
		return true;

	}









	private static function insertingFile($file){

		$fileC=WGet::file();

		if( ! $fileC->exist( $file )){
									$fileDetailsArr=explode(".", $oneFile);
			array_splice($fileDetailsArr, count($fileDetailsArr)-1);
			$fileDetailsArr=implode('.', $fileDetailsArr);
			$file=JOOBI_DS_NODE .$explodeControllerA[0] . DS.'database' . DS . 'data'.DS. 'controller' . DS . $fileDetailsArr . '.cca';
			if( ! $fileC->exist( $file )){
				self::$WMessageLog['controller file doesnot exist ']=$file;
				self::$WMessageLog['return 5']="false";
				return false;
			}
		}
				if( !isset($readingFileC)) $readingFileC=WClass::get( 'library.readingfile' );
		$phpObjectFromFile=$readingFileC->createPhpObjectFromFile( $file );

		if( !empty($phpObjectFromFile)){
			
			$insertIntoDBFromFile=$readingFileC->doInstallationIntoDb( $phpObjectFromFile, 'controller' );

						if( $insertIntoDBFromFile && Library_Readingfile_class::$isFinishSuccessfull){
								$readingFileC->insertIntoPopulateTable();
								$readingFileC->deleteFile( $file );
			}else{
											}
		}
		return true;

	}

}