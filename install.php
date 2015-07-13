<?php
defined('ABSPATH') or die( 'J....' );
/**
* @link joobi.co
* @copyright Copyright (C) 2007-2015 Joobi Limited All rights reserved.
* This file is released under the GPL v3
*/
if ( ( defined('ABSPATH') ) && !defined('JOOBI_SECURE') ) define( 'JOOBI_SECURE', true );

class install_joobi {

	public $cmsName = ''; // joomla , wordpress , drupal
	public $htdocsPath = '';
	public $joobi = 'joobi';//folder name of the joobi folder
	public $appName ="";
	public $redirectURL = ""; // URL to which the installation process should redirect to on completion
	public $redirectToAppDashboard = false;
	public $playSoundOnCompletion = false;
	private $distribServer ="";
	private $licenseURL = "";


	public static $configurationA = array();

	private static $languagesUsed = array();//get the dictionary files for JOOBI_MAIN_APP
	//public $newInstall = true;

	private $_useCMSmethods = true; // whether to use cms functions or php functions , should ideally come from configuration files , temporary hard coding
	private $_joobiFolderExists = false;
	private $_nodesListPackageTXTA = array();
	private $_newNodesListFolderA = array();
	private $_cmsLogFolder = "joobiInstallLogs";
	private $_errLogFileName = "joobi-errors.log";
	private $_infoLogFileName = "joobi-info.log";
	private $_errLogFilePath = "";
	private $_infoLogFilePath = "";
	private $_joobiInfoLogsPath = "logs/offline_install_info.log";
	private $_joobiErrLogsPath = "logs/offline_install_err.log";
	private $_joobiLogs = false;
	private $_joobiTarGzSourcePath = "";
	private $_joobiFolderDestinationPath = "";
	private $_libPackagesPath = "";
	private $_libPackagesPathPP = "";
	private $_deleteLogs = false;
	private $_timeLimit = 200 ;// in seconds
	private $_memoryLimit = "128M";
	private $_dataSQLFilePath = "";
	private $_alterSQLFilePath = "";
	private $_tableSQLFilePath = "";
	private $_uninstallSQLFilePath = "";
	private $_joobiUninstallSQLPath = "";
	private $_joobiFolderFilesA = array(  'entry.php','config.php','index.php','discover.php','lib_packages.txt');

	private $_recordLogs = true;

/**
	 * Sets the public variables required for joobi installation
	 */
	public function setCMS( $cmsName="",$appName="" ) {

		$this->cmsName = $cmsName;
		$lcCMSName = strtolower($cmsName);
		$lcAppName = strtolower($appName);

		$this->joobi = 'joobi';
		$this->appName = $appName;

		if($lcCMSName == 'wordpress')
		{
			$this->htdocsPath = get_home_path();
			$this->redirectURL = '';
		}
		else if($lcCMSName == 'joomla')
		{
			$this->htdocsPath = JPATH_ROOT. DIRECTORY_SEPARATOR;
			$this->redirectURL = 'index.php?option=com_'.$lcAppName.'&controller='.$lcAppName;
		}

	}//endfct


/**
	 * Sets the distribution server url
	 */
	public function setDistribServer($distribServer="") {
		$this->_joobiInfoLog( "Set distrib site : " . $distribServer );
		$this->distribServer = $distribServer;
	}//endfct


	/**
	 * Sets the license url
	 */
	public function setLicense($licenseURL="")
	{
		$this->licenseURL = $licenseURL;
	}


	/**
	 * Sets the redirect flag to yes and also the url
	 */
	public function setRedirect($url="")
	{
		$this->redirectToAppDashboard = true;
		$this->redirectURL = $url;

	}//endfct


	/**
	 * sets sound on completion flag to yes
	 */
	public function setSound()
	{
        $this->playSoundOnCompletion = true;

	}//endfct

	public function installJoobi() {

		// --- Step 1 - setup the environment with constants and local variables
		if ( !$this->_beforeInstallation() ) return false ;

		// --- Step 2 - move code and run sql
		if(!$this->_settingUp()) return false;

		// --- Step 3 - run custom install
		if(!$this->_postProcessing()) return false;

		return true;
	}


/**
	 * Deleting CODE folders and DATABASE tables
	 */
	public function deleteJoobi() {

		try {

			$this->_firstDefines();

			// define the constants
			$this->_defineConstants();
			$this->_defineLocals();
			$this->_usefullInitialInfo();

			$this->_joobiInfoLog("_deleteJoobi()");

			// get instaling app details
//			$this->_getAppDetails();

			if(empty($this->appName)) throw new Exception("appName is empty");


			$this->_deleteLogs = true;

			// remove temporary files if any
			if($this->_removeTempFiles()) $this->_joobiUserMessage("joobi logs removed") ;

		}//trycatch block
		catch (fileException $e) { $this->_joobiUserMessage("Joobi Deletion Stopped ! <br>".$e->getMessage()); $this->_joobiErrorLog("_deleteJoobi() : ".$e->getMessage()); $this->_joobiInfoLog("_deleteJoobi() : --- File Exception Trace---");  $this->_joobiInfoLog("_deleteJoobi() : ".$e->getTraceAsString());  return false ; }
		catch (databaseException $e) { $this->_joobiUserMessage("Joobi Deletion Stopped ! <br>".$e->getMessage()); $this->_joobiErrorLog("_deleteJoobi() : ".$e->getMessage());   $this->_joobiInfoLog("_deleteJoobi() : --- Database Exception Trace---");  $this->_joobiInfoLog("_deleteJoobi() : ".$e->getTraceAsString());  return true ; }
		catch (outsideCallException $e) { $this->_joobiUserMessage("Joobi Deletion Stopped ! <br> Please Contact Joobi Support with the following <br>".$e->getMessage());$this->_joobiInfoLog("_deleteJoobi() : --- Outside Call Exception Trace---");  $this->_joobiInfoLog("_deleteJoobi() : ".$e->getTraceAsString()); return false ; }
		catch (Exception $e) { $this->_joobiUserMessage("Joobi Deletion Stopped ! <br>".$e->getMessage()); $this->_joobiErrorLog("_deleteJoobi() : ".$e->getMessage());   $this->_joobiInfoLog("_deleteJoobi() : --- Exception Trace---");  $this->_joobiInfoLog("_deleteJoobi() : ".$e->getTraceAsString());  return false ; }

		return true;

	}//endfct


	/**
	 * All activities to be done before the actual installation
	 */

	private function _beforeInstallation ()
	{
		ob_start();

		try {

			$this->_firstDefines();

			// create log folder
			$this->_createLogFolder();

			// check if all public params are set
			$this->_checkPublicParams();

			// define the constants
			$this->_defineConstants();
			$this->_defineLocals();
			$this->_usefullInitialInfo();

			// incerease processing power a bit
			$this->_improvePerformance();

			// get the imports
			$this->_importFiles();

		}// try catch block
		catch (fileException $e) { $this->_joobiUserMessage("Looks like Joobi encountered some errors while installation! <br> Please Contact Joobi Support with the following <br>".$e->getMessage()); $this->_joobiErrorLog("_beforeInstallation() : ".$e->getMessage()); $this->_joobiInfoLog("_beforeInstallation() : --- File Exception Trace---");  $this->_joobiInfoLog("_beforeInstallation() : ".$e->getTraceAsString());  return false ; }
		catch (Exception $e) { $this->_joobiUserMessage("Looks like Joobi encountered some errors while installation! <br> Please Contact Joobi Support with the following <br>".$e->getMessage()); $this->_joobiErrorLog("_beforeInstallation() : ".$e->getMessage());   $this->_joobiInfoLog("_beforeInstallation() : --- Exception Trace---");  $this->_joobiInfoLog("_beforeInstallation() : ".$e->getTraceAsString());  return false ; }

		return true;

	} //endfct



/**
	 * The actual install of CODE and DATABASE
	 */
	private function _settingUp() {

		try {

			$this->_joobiInfoLog("_settingUp()");

			//check for existing joobi installation
			$this->_joobiFolderExists = $this->_checkExistingJoobi();

			$this->_joobiInfoLog("Joobi Folder Exists (1 for Yes , empty for No) : ".$this->_joobiFolderExists);

			//loop through joobi folders or extract joobi folder
			if ( $this->_joobiFolderExists ) $this->_scanFolder();
			else $this->_extractAndMoveJoobi( $this->_joobiFolderDestinationPath );

			//run the querries
			$this->_runSQL();

		}//trycatch block
		catch (fileException $e) { $this->_joobiUserMessage("Looks like Joobi encountered some errors while installation! <br> Please Contact Joobi Support with the following <br>".$e->getMessage()); $this->_joobiErrorLog("_settingUp() : ".$e->getMessage()); $this->_joobiInfoLog("_settingUp() : --- File Exception Trace---");  $this->_joobiInfoLog("_settingUp() : ".$e->getTraceAsString());  return false ; }
		catch (databaseException $e) { $this->_joobiErrorLog("_settingUp() : ".$e->getMessage());   $this->_joobiInfoLog("_settingUp() : --- Database Exception Trace---");  $this->_joobiInfoLog("_settingUp() : ".$e->getTraceAsString());  return true ; }
		catch (outsideCallException $e) { $this->_joobiUserMessage("Looks like Joobi encountered some errors while installation! <br> Please Contact Joobi Support with the following <br>".$e->getMessage()); $this->_joobiErrorLog("_settingUp() : ".$e->getMessage());   $this->_joobiInfoLog("_settingUp() : --- Outside Call Exception Trace---");  $this->_joobiInfoLog("_settingUp() : ".$e->getTraceAsString()); return false ; }
		catch (Exception $e) { $this->_joobiUserMessage("Looks like Joobi encountered some errors while installation! <br> Please Contact Joobi Support with the following <br>".$e->getMessage()); $this->_joobiErrorLog("_settingUp() : ".$e->getMessage());   $this->_joobiInfoLog("_settingUp() : --- Exception Trace---");  $this->_joobiInfoLog("_settingUp() : ".$e->getTraceAsString());  return false ; }

		return true;

	}//endfct


/**
	 * Things to do when Code and Database installation is done successfully
	 */
	private function _postProcessing() {

			try {

				$this->_joobiInfoLog("_postProcessing()");

				// define and include files before entering joobi code
				$this->_prepareForJoobi();

				// create the app menus
				//$this->_createMenus();

				// run through the install files that are present in the nodes that have been installed
				$this->_nodeInstallFunctions();

				// update some config params
				$this->_updatePreferences();

				$this->_resetUser();

				// update the version number and creation time for the app since its omportant wrt demo license
				if (empty($this->appName))  throw new Exception("_appName is empty");

				$appID = WExtension::get( $this->appName.'.application', 'wid' );
				$this->_updateVersionAndTime($appID);

				$this->_MainAppPatch($appID);

				// remove temporary files if any
				//$this->_removeTempFiles();

				// refresh apps for JOOBI_MAIN_APP
				$this->_refreshApps();

				// clear cache
				$this->_clearCache();

				// move the logs to joobi logs folder
				$this->_moveLogsToJoobi();

				// play completion sound
				if ($this->playSoundOnCompletion) $this->_completionSound();

				// redirect to a specified url
				if($this->redirectToAppDashboard) $this->_redirectToURL();

			}//trycatch block

			catch (fileException $e) { $this->_joobiUserMessage("Looks like Joobi encountered some errors while installation! <br> Please Contact Joobi Support with the following <br>".$e->getMessage()); $this->_joobiErrorLog("_postProcessing() : ".$e->getMessage()); $this->_joobiInfoLog("_postProcessing() : --- File Exception Trace---");  $this->_joobiInfoLog("_postProcessing() : ".$e->getTraceAsString());  return false ; }
			catch (outsideCallException $e) { $this->_joobiUserMessage("Looks like Joobi encountered some errors while installation! <br> Please Contact Joobi Support with the following <br>".$e->getMessage()); $this->_joobiErrorLog("_postProcessing() : ".$e->getMessage());   $this->_joobiInfoLog("_postProcessing() : --- Outside CallException Trace---");  $this->_joobiInfoLog("_postProcessing() : ".$e->getTraceAsString());  return false ; }
			catch (Exception $e) { $this->_joobiUserMessage("Looks like Joobi encountered some errors while installation! <br> Please Contact Joobi Support with the following <br>".$e->getMessage()); $this->_joobiErrorLog("_postProcessing() : ".$e->getMessage());   $this->_joobiInfoLog("_postProcessing() : --- Exception Trace---");  $this->_joobiInfoLog("_postProcessing() : ".$e->getTraceAsString());  return false ; }

			return true;

		}//endfct


	/**
	 * Patch up all work related to JOOBI_MAIN_APP application
	 */
	private function _MainAppPatch($appID) {
		try {

			$this->_joobiInfoLog("_MainAppPatch()");

			$mainAppID = WExtension::get ( JOOBI_MAIN_APP . '.application', 'wid' );
			if ( ! empty( $mainAppID ) && ($appID != $mainAppID) ) $this->_updateVersionAndTime ( $mainAppID );


			// this to make sure we don not publish JOOBI_MAIN_APP when we install say a app like jlinks only on a fresh install
			// joomla specific
			if ( $this->cmsName == 'joomla') {

				$extensionsJoomlaM = WModel::get ( 'joomla.extensions' );
				$extensionsJoomlaM->whereE ( 'element', 'com_' . JOOBI_MAIN_APP );
				$extensionsJoomlaM->whereE ( 'type', 'component' );

				$extensionId = $extensionsJoomlaM->load ( 'lr', 'extension_id' );

				// if JOOBI_MAIN_APP is not present in joomla table , it means it has not been installed previous to this innstallation pf app XYZ
				if ( empty( $extensionId ) && ! empty ( $mainAppID ) && ( $appID != $mainAppID) ) {
					$appsM = WModel::get ( 'apps' );
					$appsM->setVal( 'publish', 0 );
					$appsM->setVal( 'modified', time() );
					$appsM->whereE( 'wid', $mainAppID );
					$appsM->update();
				}//endif

			} else if( $this->cmsName == 'wordpress' ) {
				// TODO;

			}


		} catch ( Exception $e ) {
			throw new Exception ( "JOOBI_MAIN_APP patching has some issue" );
		}//trycatch
	}//endfct


		/**
		 * Improves the script performace as the processing after upload of zip package may take some more time
		 */

		private function _improvePerformance()
		{
			try {


			$this->_joobiInfoLog("_improvePerformance()");

			// on slow servers the package upload and processing by cms itself consumes 30 seconds
			// the default php configuration allows script to run for a max of 30 seconds only
			// thus we improve the settings

			if (empty($this->_timeLimit))  throw new Exception("_timeLimit is empty");
			if (empty( $this->_memoryLimit))  throw new Exception("_memoryLimit is empty");

			@set_time_limit($this->_timeLimit);
			@ini_set("memory_limit", $this->_memoryLimit);
			@ini_set('max_execution_time', $this->_timeLimit );

			} catch ( Exception $e ) {

				throw new Exception("Could not increase performance");

			}

		}//endfct


		/**
		 * Import some files whose methods will be needed later
		 */

		private function _importFiles()
		{
			try {


			$this->_joobiInfoLog("_importFiles()");

			if($this->cmsName == 'joomla')
			{
				$this->_joobiInfoLog("importing joomla library files");

				jimport('joomla.filesystem.folder');
				jimport( 'joomla.filesystem.archive' );
				jimport('joomla.filesystem.file');

			}
			else if($this->cmsName == 'wordpress')
			{
				$this->_joobiInfoLog("importing wordpress library files");
				// TODO;

			}

			} catch ( Exception $e ) {

				throw new Exception("Failed importing files");

			}

		}//endfct

	/**
	 * create a log temp log folder
	 */
	private function _createLogFolder() {
		try {

			if (! file_exists ( $this->htdocsPath . 'tmp' . DS . $this->_cmsLogFolder ) ) {
				mkdir ( $this->htdocsPath . 'tmp' . DS . $this->_cmsLogFolder, 0777, true );
			}
		} catch ( Exception $e ) {

			throw new Exception ( "Problem while creating log folder" );
		}
	}//endfct



/**
	 * create a log temp log folder
	 */
	private function _checkPublicParams() {

		$this->_joobiInfoLog ( "_checkPublicParams()" );

		if ( empty($this->cmsName) ) throw new Exception("cmsName is empty");
		if ( empty($this->htdocsPath) ) throw new Exception("htdocsPath is empty");
		if ( empty($this->joobi)) throw new Exception("joobi is empty");
		if ( empty($this->distribServer) ) throw new Exception("distribServer is empty");
		if ( empty($this->licenseURL) ) throw new Exception("licenseURL is empty");
		if ( empty($this->appName) ) throw new Exception("appName is empty");
		if ( $this->redirectToAppDashboard && empty($this->redirectURL) ) throw new Exception("redirectURL is empty");

	}//endfct



/**
	 * Initial definations
	 */
	private function _firstDefines() {

		// CANNOT PUT TRY CATCH HERE SINCE WE ARE JUST DEFINING THE LOCATION OF THE LOIGS

		if ( ! defined( 'DS' )) define( 'DS', DIRECTORY_SEPARATOR );

		$this->_errLogFilePath = 'tmp' . DS . $this->_cmsLogFolder . DS . $this->_errLogFileName;
		$this->_infoLogFilePath = 'tmp' . DS . $this->_cmsLogFolder . DS . $this->_infoLogFileName;

		if ( file_exists( dirname( __FILE__ ) . DS . 'tar.php' ) ) require_once( dirname( __FILE__ ) . DS . 'tar.php' );

	}//endfct


	/**
	 * need to define contsants that are used in joobi folder code
	 */
	private function _defineConstants() {

		try {

			$this->_joobiInfoLog ( "_defineConstants()" );

			if (! defined( 'JOOBI_DS_ROOT' ))
				define( 'JOOBI_DS_ROOT', $this->htdocsPath );

			define( 'JOOBI_DS_INSTALLFOLDER', dirname( __FILE__ ) . DS );
			if (! defined( 'JOOBI_FOLDER' ))
				define( 'JOOBI_FOLDER', $this->joobi );

			if (! defined( 'JOOBI_DS_ROOT' ))
				throw new Exception ( 'The Root folder is not defined ' );

			if (! defined( 'JOOBI_DS_NODE' ))
				define( 'JOOBI_DS_NODE', JOOBI_DS_ROOT . JOOBI_FOLDER . DS . 'node' . DS );
			if (! defined( 'JOOBI_LIB_CORE' ))
				define( 'JOOBI_LIB_CORE', JOOBI_DS_NODE . 'library' . DS ); // where library is located for the present version
			define( 'JOOBI_INSTALLING', 1 );


		} catch ( Exception $e ) {
			throw new Exception ( "Problem while defining constants" );
		}
	}//endfct

	/**
	 * define the local variables
	 */
	private function _defineLocals() {

		try {

			$this->_joobiInfoLog ( "_defineLocals()" );
			$this->_joobiTarGzSourcePath = dirname( __FILE__ ) . DS . 'admin' . DS . 'joobi.tar.gz';
			$this->_joobiTarSourcePath = dirname( __FILE__ ) . DS . 'admin' . DS . 'joobi.tar';
			$this->_joobiFolderTemporary = dirname( __FILE__ ) . DS . 'joobi';
			$this->_dataSQLFilePath = dirname( __FILE__ ) . DS . 'admin' . DS . 'data.sql';
			$this->_alterSQLFilePath = dirname( __FILE__ ) . DS . 'admin' . DS . 'alter.sql';
			$this->_tableSQLFilePath = dirname( __FILE__ ) . DS . 'admin' . DS . 'tables.sql';
			$this->_uninstallSQLFilePath = dirname( __FILE__ ) . DS . 'admin' . DS . 'uninstall.sql';
			$this->_joobiFolderDestinationPath = $this->htdocsPath . 'joobi';
			$this->_libPackagesPath = $this->_joobiFolderTemporary . DS . 'lib_packages.txt';
			$this->_libPackagesPathPP = JOOBI_DS_ROOT . $this->joobi . DS . 'lib_packages.txt';
			$this->_joobiUninstallSQLPath = JOOBI_DS_ROOT . $this->joobi . DS . 'uninstall.sql';
		} catch ( Exception $e ) {
			throw new Exception ( "Problem while defining locals" );
		}

	}//endfct


/**
	 * record some usefull info in the logs
	 */
	private function _usefullInitialInfo() {

		try {

			$this->_joobiInfoLog ( "_usefullInitialInfo()" );
			$this->_joobiInfoLog ( "---- START OF NEW INFO LOGS ----" );
			$this->_joobiInfoLog ( "PHP ver : " . PHP_VERSION );
			$this->_joobiInfoLog ( "_joobiTarGzSourcePath : " . $this->_joobiTarGzSourcePath );
			$this->_joobiInfoLog ( "_joobiFolderTemporary : " . $this->_joobiFolderTemporary );
			$this->_joobiInfoLog ( "_joobiFolderDestinationPath : " . $this->_joobiFolderDestinationPath );
			$this->_joobiInfoLog ( "_libPackagesPath : " . $this->_libPackagesPath );
			$this->_joobiInfoLog ( "htdocsPath : " . $this->htdocsPath );
			$this->_joobiInfoLog ( "appName : " . $this->appName );
			$this->_joobiInfoLog ( "cmsName : " . $this->cmsName );
		} catch ( Exception $e ) {
			throw new Exception ( "Problem while recording usefull info" );
		}
	}//endfct


		/**
		 * check if we have a previous joobi folder present
		 */

		private function _checkExistingJoobi()
		{
			$this->_joobiInfoLog("_checkExistingJoobi()");

			if(empty($this->_joobiFolderDestinationPath)) throw new Exception("_joobiFolderDestinationPath is empty");

			if ( !file_exists($this->_joobiFolderDestinationPath ) && !is_dir($this->_joobiFolderDestinationPath) ) return false;
			else return true;

		}//endfct



		/**
		 * tells whether a folder exists or not
		 */

		private function _folderExists($folderPath="")
		{
			try{

				if(!empty($folderPath))
				{
					if ( !file_exists($folderPath ) && !is_dir($folderPath) ) return false;
					else return true ;

				}
				else throw new Exception("folderPath is empty");

			}//try catch
			catch (Exception $e) { throw new outsideCallException("_folderExists() : Something went wrong during checking whether the folder exists");  }//trycatch block ends

		}//endfct



/**
		 * loop throught the existing folder and see what is to be updated
		 */
		private function _scanFolder() {

			$this->_joobiInfoLog("_scanFolder()");
			if( empty($this->_joobiFolderTemporary) ) throw new Exception("_joobiFolderTemporary is empty");

			try {

					$this->_extractAndMoveJoobi( $this->_joobiFolderTemporary );

					$nodePath = $this->_joobiFolderTemporary. DS . 'node';

					$allNodeA = $this->_readFolder($nodePath);

					foreach( $allNodeA as $foldr ) {

						if(!$this->_folderExists($this->htdocsPath .  'joobi' . DS . 'node' . DS . $foldr)){
							$this->_newNodesListFolderA[$foldr] = $foldr;

							$this->_moveFileorFolder( $nodePath . DS . $foldr, $this->htdocsPath . 'joobi' . DS . 'node' . DS . $foldr );
							$this->_joobiInfoLog("moved :".$foldr);
						}//endif
						else
						{

							if ( !file_exists($this->htdocsPath . 'joobi' . DS . 'node' . DS . $foldr) ) rmdir($this->htdocsPath . 'joobi' . DS . 'node' . DS . $foldr);
							$this->_moveFileorFolder( $nodePath . DS . $foldr, $this->htdocsPath . 'joobi' . DS . 'node' . DS . $foldr );
							$this->_joobiInfoLog("deleted and moved :".$foldr);
						}
					}//endforeach

					$incPath = $this->_joobiFolderTemporary . DS . 'inc';

					$allIncA = $this->_readFolder($incPath);
					foreach( $allIncA as $foldr ) {
						if ( !$this->_folderExists( $this->htdocsPath .  'joobi' . DS . 'inc' . DS . $foldr ) ) {
							$this->_moveFileorFolder( $incPath . DS . $foldr, $this->htdocsPath .  'joobi' . DS . 'inc' . DS . $foldr );
							$this->_joobiInfoLog("moved :".$foldr);
						}//endif
						else {
							if ( !file_exists($this->htdocsPath . 'joobi' . DS . 'inc' . DS . $foldr) ) rmdir( $this->htdocsPath . 'joobi' . DS . 'inc' . DS . $foldr );
							$this->_moveFileorFolder( $incPath . DS . $foldr, $this->htdocsPath . 'joobi' . DS . 'inc' . DS . $foldr );
							$this->_joobiInfoLog("deleted and moved :".$foldr);
						}
					}//endforeach

					if(!empty($this->_joobiFolderFilesA))
					{
						$destinationFIlePath = "";
						foreach( $this->_joobiFolderFilesA as $fileName )
						{
							if(file_exists($this->_joobiFolderTemporary.DS.$fileName))
							{
								unlink($this->_joobiFolderDestinationPath.DS.$fileName);
								$this->_moveFileorFolder($this->_joobiFolderTemporary.DS.$fileName,$this->_joobiFolderDestinationPath.DS.$fileName);
								$this->_joobiInfoLog("overwritten : ".$fileName);
							} // if exists check
						} // for each loop
					}// if empty check

	        }//try ends
	        catch (Exception $e) { throw new outsideCallException( "4. _scanFolder() : Something went wrong during moving code, here is the error message : " . $e->getMessage());  }//trycatch block ends


		}//endfct



/**
	 * move folder and first delele src folder if exists
	 */
		private function _moveFileorFolder($folderSrcPath="",$folderDstPath="")
		{

			try
			{
				if(!empty($folderSrcPath) && !empty($folderDstPath) )
				{
					// this function requires php version 5.3.1 and above to work on Windows
					if ( file_exists($folderSrcPath) && ! file_exists($folderDstPath) ) @rename( $folderSrcPath, $folderDstPath );
				}
				else throw new Exception("folderSrcPath or folderDstPath is empty");

			}
			catch (Exception $e) { throw new outsideCallException("_moveFileorFolder() : Something went wrong during moving the folders");  }//trycatch block ends

		}//endfct

		/**
		 * read only the folder in the given path and put them in an array
		 */
		private function _readFolder($folderPath="")
		{

			$this->_joobiInfoLog("_readFolder()");

			try {

			  if(!empty($folderPath))
			  {
				$folderNameA = array();

				if ($handle = opendir($folderPath))
				{

					while (false !== ($folderName = readdir($handle))) {
						if (strpos($folderName, '.') !== FALSE) ;//echo 'Found it';
						else  $folderNameA[] = $folderName;
					}

					closedir($handle);
				}

				return $folderNameA ;
			  }
			  else throw new Exception("folderPath is empty");


			}//trycatch
			catch (Exception $e) { throw new outsideCallException("_readFolder() : Something went wrong during reading the folders");  }//trycatch block ends

		}//endfct


/**
		 * extract and move the code to form joobi folder
		 */
		private function _extractAndMoveJoobi( $destinationPath="" ) {

			$this->_joobiInfoLog("_extractAndMoveJoobi()");

			if ( ! file_exists( $this->_joobiTarGzSourcePath ) ) {
				rename( dirname( __FILE__ ) . DS . 'admin' . DS . 'joobi', $destinationPath );
				$this->_joobiInfoLog( "no untar, moved joobi folder" );
				return true;
			}//endif


			if ( empty($this->_joobiTarGzSourcePath) ) throw new Exception( "_joobiTarGzSourcePath is empty" );
			if ( empty($this->_joobiTarSourcePath) ) throw new Exception( "_joobiTarSourcePath is empty" );
			if ( empty($destinationPath) ) throw new Exception( "destinationPath is empty" );

			try {

				if ( PHP_VERSION > '5.3' && class_exists( 'PharData' ) ) {

					try{
                         $this->_usePhar( $destinationPath );
					}
					catch (Exception $e) {

						$this->_joobiInfoLog("...Problem while extracting using Phar : ".$e->getMessage());
						$this->_joobiInfoLog("...trying with CMS extracter");

						$this->_useCMSExtraction( $destinationPath );

						// -------- THERE IS SOME ISSUE WITH ARCHIVE TAR WHICH WE NEED TO INVESTIGATE AND THEN UNCOMMENT

						//$this->_joobiInfoLog("...trying with Archive Tar");
						//$this->useArchiveTar();
					}//endtry

				} else if( $this->cmsName == 'wordpress' ) {

					$this->_joobiInfoLog( "1. using wordpress function for extracting joobi folder" );

//					$fileS = WGet::file();
//					if ( !empty($fileS) ) {
//						if ( ! $fileS->extract( $this->_joobiTarGzSourcePath, $destinationPath ) ) throw new fileException( "failed extracting code from " . $this->_joobiTarGzSourcePath . " to " . $destinationPath . " failed");
//					} else throw new Exception("2. Need to use Wordpress API functions");

				}//endif
			}//try
			catch (Exception $e) { throw new Exception( "3. _extractAndMoveJoobi() : Problem while extracting " . $e->getMessage() );  }

			//since we have extracted the fiel we should remvoe it now
//			$fileS = WGet::file();
//			$fileS->delete( $this->_joobiTarGzSourcePath );
			 @unlink( $this->_joobiTarGzSourcePath );

		}//endfct


/**
		 * extraction using Phar
		 */
		private function _usePhar( $destinationPath ) {

			$this->_joobiInfoLog("using PharData for extracting joobi folder");
			$this->_joobiInfoLog("step1");

			$p = new PharData($this->_joobiTarGzSourcePath);
			$p->decompress(); // creates /path/to/my.tar

			$this->_joobiInfoLog("step2");

			// unarchive from the tar
			$phar = new PharData($this->_joobiTarSourcePath);
			if(!$phar->extractTo($destinationPath)) throw new Exception("Joobi folder extraction failed using Phar");

		}//endfct


/**
		 * extraction using Phar
		 */
		private function useArchiveTar( $destinationPath ) {

			$this->_joobiInfoLog("using Archive_Tar for extracting joobi folder");

			if ( ! class_exists('Archive_Tar') ) return false;

			$tar_object = new Archive_Tar($this->_joobiTarGzSourcePath,'gz');
			if ( !$tar_object->extract($destinationPath) )  throw new Exception( "Joobi folder extraction failed using Archive_Tar" );

		}//endfct


/**
		 * extraction using CMS
		 */
		private function _useCMSExtraction( $destinationPath ) {

			if ( $this->cmsName == 'joomla' ) {

				$this->_joobiInfoLog("using joomla function for extracting joobi folder");
				// extract and move at the same time to root
				if(!JArchive::extract($this->_joobiTarGzSourcePath ,  $destinationPath )) throw new Exception("moving code from ".$destinationPath." to ".$this->_joobiTarGzSourcePath." failed");

			} elseif( $this->cmsName == 'wordpress' ) {
//				if ( !JArchive::extract($this->_joobiTarGzSourcePath ,  $destinationPath ) ) throw new Exception("moving code from ".$destinationPath." to ".$this->_joobiTarGzSourcePath." failed");
//				$this->_joobiInfoLog("using wordpress function for extracting joobi folder");
//				throw new Exception("Need to use Wordpress API functions");

				$this->_joobiInfoLog( "2. using wordpress function for extracting joobi folder" );

				$fileS = WGet::file();
				if ( !empty($fileS) ) {
					if ( ! $fileS->extract( $this->_joobiTarGzSourcePath, $destinationPath ) ) throw new fileException( "failed extracting code from " . $this->_joobiTarGzSourcePath . " to " . $destinationPath . " failed");
				} else throw new Exception("2. Need to use Wordpress API functions");


			}//endif
		}//endfct

		/**
		 * Fire the database with create tables and insert data queries
		 */

		private function _runSQL()
		{
			$this->_joobiInfoLog("_runSQL()");

			$this->_createTables();

			$this->_alterTables();

			$this->_insertData();

		}//endfct


		/**
		 * load the create table and subsequent alter statements and then fire the file
		 */

		private function _createTables()
		{
			$this->_joobiInfoLog("_createTables()");
			$this->_checkFile($this->_tableSQLFilePath);

			$table = file_get_contents( $this->_tableSQLFilePath );

			if($this->cmsName == 'joomla')
			{
				// In joomla this is handled through if create table sql is mentioned in the manifest xml
				$tableWithPrefix = $table ;
				$this->_joobiInfoLog("... in joomla");
			}
            else if($this->cmsName == 'wordpress')
            {
 			   global $wpdb;

 			   $dbPrefix = $wpdb->prefix ;

 			   $this->_joobiInfoLog("_createTables() ".$dbPrefix);

 			   $tableWithPrefix = str_replace("#__",$dbPrefix,$table);
            }

            $array =  $this->_splitSql( $tableWithPrefix, ';', null, true );

//            foreach($array as $query){
//            	$this->_joobiErrorLog($query);
//            }

            $this->_importQueries( $array);


		}//endfct


		/**
		 * load the create table and subsequent alter statements and then fire the file
		 */

		private function _alterTables()
		{
			$this->_joobiInfoLog("_alterTables()");
			$this->_checkFile($this->_alterSQLFilePath);

			// if have a foreach here because if one alter query fails we want to procedd to the next one
			// alter does not have an ignore in it
			$alter = file_get_contents( $this->_alterSQLFilePath );

			if($this->cmsName == 'joomla')
			{
				$alterWithPrefix = $alter;
			}
			else if($this->cmsName == 'wordpress')
			{
				global $wpdb;

				$dbPrefix = $wpdb->prefix ;

				$this->_joobiInfoLog("_alterTables() ".$dbPrefix);

				$alterWithPrefix = str_replace("#__",$dbPrefix,$alter);
			}

			$alterA = $this->_splitSql( $alterWithPrefix, ';', null, true );

			if(!empty($alterA))
			{
				foreach($alterA as $sqlString)
				{
					$this->_importQueries($sqlString);
				}

			}

			//$this->_importQueries( $this->_splitSql( $alter, ';', null, true ) );
		}//endfct



		/**
		 * insert the data
		 */

		private function _insertData()
		{
			// In joomla this can be als handled through if insert data  sql is mentioned in the manifest xml
			// But since we are going to run alter table scripts through php we have to run insert data script through php too
			// once we use SP we can put back data sql in manifest and remove code below

			$this->_joobiInfoLog("_insertData()");
			$this->_checkFile($this->_dataSQLFilePath);

			$data = file_get_contents( $this->_dataSQLFilePath );

			if($this->cmsName == 'joomla')
			{
				$dataWithPrefix = $data;
			}
			else if($this->cmsName == 'wordpress')
			{
				global $wpdb;

				$dbPrefix = $wpdb->prefix ;

				$this->_joobiInfoLog("_insertData() ".$dbPrefix);

				$dataWithPrefix = str_replace("#__",$dbPrefix,$data);
			}

			$this->_importQueries( $this->_splitSql( $dataWithPrefix, ';', null, true ) );

		}//endfct






		/**
		 * prepare to enter joobi code
		 */

		private function _prepareForJoobi() {

			$this->_joobiInfoLog("_prepareForJoobi()");

			if( !defined( 'JOOBI_DS_ROOT' ) )  throw new Exception("JOOBI_DS_ROOT is not defined");


			try {


				if( !defined( 'JOOBI_FRAMEWORK' ) ) {
					require( JOOBI_DS_ROOT. $this->joobi .DS. 'discover.php' );
					WDiscoverEntry::discover();
				}//endif

				//if we still did not found, we raise an exception
				if( !defined( 'JOOBI_FRAMEWORK' ) )  throw new Exception("JOOBI_FRAMEWORK is not defined");


				if( !class_exists( 'APIPage' ) ){
					$apiFramework = JOOBI_DS_ROOT. $this->joobi .'/node/api/addon/'. JOOBI_FRAMEWORK . DS . JOOBI_FRAMEWORK . '.php';
					if($this->_checkFile($apiFramework,false)) require_once($apiFramework);

				}//endif

				$libraryDefine = JOOBI_DS_ROOT. $this->joobi .'/node/library/' . 'define.php' ;
				if($this->_checkFile($libraryDefine,false)) require_once($libraryDefine );

				if( !defined( 'PLIBRARY_NODE_CACHING' ) ) define( 'PLIBRARY_NODE_CACHING', 0 );


			}// try catch
			catch (Exception $e) { throw new Exception("Could not prepare joobi for post processing");  }


			$this->_joobiLogs = true;

		}//endfct


/**
	 * get the custom node functions
	 */
	private function _nodeInstallFunctions() {

		try{
			$this->_joobiInfoLog("_nodeInstallFunctions()");

			$installClass = JOOBI_DS_ROOT . $this->joobi .DS.'node' . DS . 'install' . DS . 'class' . DS . 'install.php';

			if ( $this->_checkFile( $installClass, false ) ) {

				include_once( $installClass );

				if ( !defined( 'JOOBI_DB_TYPE' ) ) define( 'JOOBI_DB_TYPE', 'mysqli' );

				$this->_joobiInfoLog( "before _getPackageListArray()" );
				$this->_getPackageListArray();
				$this->_joobiInfoLog( "after _getPackageListArray() :" );
				$this->_runCustomInstall();
				$this->_joobiInfoLog( "after _runCustomInstall() :" );
			} else {
				$this->_joobiInfoLog("Since there was no install node in the package we skip running custom install functions");
			}//endif

		} catch ( Exception $e ) {
			throw new Exception ( "Problem in _nodeInstallFunctions. " . $e->getMessage() );
		}//endtry

	}//endfct



		/**
		 * read the package list txt
		 */

		private function _getPackageListArray() {

			$this->_joobiInfoLog("_getPackageListArray()");

			if(!$this->_checkFile($this->_libPackagesPathPP,false)) return true;

			$libPackageListA = file($this->_libPackagesPathPP, FILE_IGNORE_NEW_LINES);


			if ( !empty($libPackageListA) ) {
				foreach($libPackageListA as $packageNames) {

					// logic to extract node name from .txt file which contains install_node_4161.tar.gz
					$pos = strrpos($packageNames, "_");

					$sub = substr($packageNames,0,$pos);

					// we need to only run custom install for node folder
					if (strpos($sub, 'node') !== false || strpos($sub, 'application') !== false ) {

						$pos = strrpos($sub, "_");
						$subShort = substr($sub,0,$pos);

						$this->_nodesListPackageTXTA[$subShort] = $sub;
					}//endif

				}//endforeach

			} else throw new Exception( "libPackageListA is empty" );

		}//endfct


/**
	 * run through the custom node functions
	 */
	private function _runCustomInstall() {

		$this->_joobiInfoLog( "1. _runCustomInstall()" );
		$nameOfNode = "";

		if( !empty($this->_nodesListPackageTXTA) ) {

			try{

				foreach( $this->_nodesListPackageTXTA as $nodeName => $completeName ) {
					$this->_joobiInfoLog( "2. _runCustomInstall() : " . $completeName );
					$customObj = new stdClass;

					$nameOfNode = $nodeName;

					$nodeInstallC = WInstall::get( $completeName );

					if ( !empty($nodeInstallC) ) {

						//special processing for install
						if ( $nodeName == 'install' ) {
							$nodeInstallC::generateFirstDefines();
							$nodeInstallC::loadLib();
						}//endif

						$customObj->newInstall = $this->_decideNewInstall( $nameOfNode );

						$this->_joobiInfoLog("calling install function for node :" . $nodeName . " with newInstall flag :" . $customObj->newInstall );

						if( method_exists( $nodeInstallC, 'install') ) $nodeInstallC->install( $customObj );
						if( method_exists( $nodeInstallC, 'addExtensions') ) $nodeInstallC->addExtensions();

					}// if nodeInstallC

				} // foreach

			} // try
			catch (Exception $e) {
				throw new Exception("_runCustomInstall() : Something went wrong in the joobi call for ".$nameOfNode." node custom install function");
			}//trycatch block ends

		} // if loop empty check

	}//endfct



		/**
		 * we will create the menus and submenus the joobi way
		 */

		private function _createMenus() {

			try{


			$this->_joobiInfoLog("_createMenus()");

			$addon = WAddon::get( 'install.'.JOOBI_FRAMEWORK );

			$lcAppName = strtolower($this->appName);

			if($this->cmsName == 'joomla')
			{
				$this->_joobiInfoLog("insoide if loop of _createMenus()");
				$addon->setExtensionInfo($lcAppName.'.application');
				$addon->refreshMenus($lcAppName);
			}

			} catch ( Exception $e ) {
				throw new Exception ( "Problem while crearting menus" );
			}



		}//endfct



/**
	 * update the preferences
	 */
	private function _updatePreferences() {

		try {
		$this->_joobiInfoLog("_updatePreferences()");

		if ( class_exists( 'WPref' ) ) {

			$this->_joobiInfoLog( "updating preferences... : " . $this->distribServer );
			$this->_joobiInfoLog( "updating preferences... : " . $this->licenseURL );
			$pref = WPref::get( 'install.node', false, false );
			$pref->updatePref( 'distrib_website', $this->distribServer );
			$pref->updatePref( 'license', $this->licenseURL );

		}//endif

		} catch ( Exception $e ) {
			throw new Exception ( "Problem while updating preferences" );
		}

	}//endfct




		/**
		 * reseting the usr in session
		 */

		private function _resetUser()
		{
			try {
			$this->_joobiInfoLog("_resetUser()");

			$uid = WUser::get( 'uid' );
			if ( empty($uid) ) {
				//reload the user
				WUser::get( null, 'reset' );
				$usersSessionC = WUser::session();
				$usersSessionC->resetUser();
			}//endif
			} catch ( Exception $e ) {
				throw new Exception ( "Problem while resetting user" );
			}

		}//endfct






		/**
		 * update the version and time in extensions_node table , this decides the licensing
		 */

		private function _updateVersionAndTime($appID=0) {

			try{
			$this->_joobiInfoLog("_updateVersionAndTime()");

			if (!isset($appID)) throw new Exception('Could not retirive wid also known as the application id for '.$this->appName.' application installation');

			$this->_joobiInfoLog("appID : ".$appID);
			//$this->_joobiInfoLog("_appVersion : ".$this->_appVersion);

			$appsM = WModel::get( 'apps' );
			$appsM->setVal( 'publish', 1 );
			//	$appsM->setVal( 'version', $this->_appVersion );
			//	$appsM->setVal( 'lversion', $this->_appVersion );
			$appsM->setVal( 'modified', time() );
			$appsM->setVal( 'created',time() );
			$appsM->whereE( 'wid',$appID );
			$appsM->update();
			} catch ( Exception $e ) {
				throw new Exception ( "Problem while updating version and time" );
			}

		}//endfct


		/**
		 * remove the logs and other unecc files if any
		 */

		private function _removeTempFiles() {

			$this->_joobiInfoLog("_removeTempFiles()");
			if (empty($this->_errLogFilePath))  throw new Exception("_errLogFilePath is empty");
			if (empty($this->_infoLogFilePath))  throw new Exception("_infoLogFilePath is empty");
			if(!defined('JOOBI_DS_ROOT') ) throw new Exception("JOOBI_DS_ROOT is not defined");

			if($this->_deleteLogs) unlink(JOOBI_DS_ROOT.$this->_errLogFilePath);
			if($this->_deleteLogs) unlink(JOOBI_DS_ROOT.$this->_infoLogFilePath);
			unlink($this->_libPackagesPathPP);

			return true;
		}//endfct



/**
	 * To populate list of apps when we install the new JOOBI_MAIN_APP
	 */
	private function _refreshApps() {

		$this->_joobiInfoLog("_refreshApps()");

		try{

			$refresh = WClass::get( 'apps.refresh' );
			$refresh->getDataAndRefresh();

		}
		catch (Exception $e) { throw new Exception ( "Problem while refreshing the apps" );  }//trycatch block ends


	}//endfct



/**
	 * move the logs to joobi logs folder
	 */
	private function _moveLogsToJoobi() {

		$this->_joobiInfoLog("_moveLogsToJoobi()");

		try{

			$this->_joobiInfoLog( "END OF INSTALLATION" );
			$this->_joobiInfoLog("Logs successfully moved");
			$this->_moveFileorFolder(JOOBI_DS_ROOT.$this->_errLogFilePath,JOOBI_DS_USER.$this->_joobiErrLogsPath);
			$this->_moveFileorFolder(JOOBI_DS_ROOT.$this->_infoLogFilePath,JOOBI_DS_USER.$this->_joobiInfoLogsPath);

			$this->_recordLogs = false;

			$this->_joobiInfoLog("Logs successfully moved");

		} catch (Exception $e) {
			throw new Exception ( "Problem while moving the logs to joobi" );
		}//endtry catch block ends


	}//endfct




		/**
		 * clearing the cache
		 */

		private function _clearCache() {

			$this->_joobiInfoLog("_clearCache()");

			try{

				$ext=WCache::get();
				$ext->resetCache();
			}
			catch (Exception $e) {throw new Exception ( "Problem while clearing the cache" ); }//trycatch block ends


			$this->_joobiInfoLog("Done with reseting Cache....");

		}//endfct



		/**
		 * play a sound on completion
		 */

		private function _completionSound() {

			$this->_joobiInfoLog("_completionSound()");

			try{

				$browser = WPage::browser( 'namekey' );
				$extension = ( $browser=='safari' || $browser=='msie' ) ? 'mp3' : 'ogg';
				$URLBeep = WPref::load( 'PLIBRARY_NODE_CDNSERVER' ) . '/joobi/user/media/sounds/finish.' . $extension;

				echo '<audio autoplay="true" src="' . $URLBeep . '" preload="auto" autobuffer></audio>';
			}
			catch (Exception $e) {throw new Exception ( "Problem while playing music" );}//trycatch block ends

			$this->_joobiInfoLog("Time for some music ....");

		}//endfct


		/**
		 * redirect to some specified url on completion
		 */

		private function _redirectToURL() {

			$this->_joobiInfoLog("_redirectToURL()");

			try {

				$lcAppName = strtolower($this->appName);

				if(empty($this->redirectURL)) $this->redirectURL = 'index.php?option=com_'.$lcAppName.'&controller='.$lcAppName;

				echo "<script>document.location.href='".$this->redirectURL."';</script>\n";
			}
			catch (Exception $e) {throw new Exception ( "Problem whileredirecting to url:".$this->redirectURL ); }//trycatch block ends

			$this->_joobiInfoLog("Now redirecting ....");

		}//endfct




/**
	 * This will report the error
	 */
	private function _joobiErrorLog($msg="") {

		if ( ! $this->_recordLogs || empty($msg) || empty($this->htdocsPath) || empty($this->_errLogFilePath) ) return false;

		try{

			//if(!defined('JOOBI_DS_ROOT') ) throw new Exception("JOOBI_DS_ROOT is not defined hence could write to the log file <br> The actuall error message was :".$msg);
			if(empty($this->_errLogFilePath)) throw new Exception("_errLogFilePath is empty hence could write to the log file <br> The actuall error message was :".$msg);

			//if($this->_joobiLogs) WMessage::log( $msg, $this->appName.'installation-errors' );
			error_log("\n <br> ".$msg , 3, $this->htdocsPath . $this->_errLogFilePath );
		}
		catch (Exception $e)
		{
			$this->_joobiUserMessage($e->getMessage());
		}

	}//endfct


/**
	 * This will log usefull info for debugging
	 */
	private function _joobiInfoLog($msg="") {

		if ( ! $this->_recordLogs || empty($msg) || empty($this->htdocsPath) || empty($this->_errLogFilePath) ) return false;

		try{

			//if(!defined('JOOBI_DS_ROOT') ) throw new Exception("JOOBI_DS_ROOT is not defined hence could write to the log file <br> The actuall info message was :".$msg);
			if ( empty($this->_infoLogFilePath) ) throw new Exception("_infoLogFilePath is empty hence could write to the log file <br> The actuall info message was :".$msg);

			//if($this->_joobiLogs) WMessage::log( $msg, $this->appName.'installation-info' );
			error_log( "\n <br> ".$msg, 3, $this->htdocsPath . $this->_infoLogFilePath );

		} catch( Exception $e ) {
			$this->_joobiUserMessage( $e->getMessage() );
		}//endtry

	}//endfct


		/**
		 * This will show message to user on screen
		 */

		private function _joobiUserMessage($msg="") {
			// currently just showing a plain echo
			// TODO : need to improve the show

			if($this->cmsName == 'joomla')
			{
				echo "<br> ".$msg;
			}
			else if($this->cmsName == 'wordpress')
			{
				echo "<div class='updated'><p>".$msg."</p></div>";
			}

		}//endfct



		/**
		 * check file for exceptions before reading or including
		 */

		private function _checkFile($filePath="",$throwErr=true) {

			if ( empty($filePath) )  throw new Exception("filePath is empty");
			elseif (!file_exists($filePath)) { if($throwErr) throw new fileException("file does not exist at ".$filePath); else return false;}
			elseif (!is_readable($filePath)) { if($throwErr) throw new fileException("file is not readable at ".$filePath); else return false;}

			return true;

		}




/**
 * decided and confirm whether the newInstall flag should be set to true or false
 */
		private function _decideNewInstall($nameOfNode) {

			$newInstall = false;


			if( ! $this->_joobiFolderExists ) return true;

$this->_joobiInfoLog( "4. _runCustomInstall() : " . $nameOfNode );

			// determing new install through folder check
			if ( !empty($this->_newNodesListFolderA) )
			{
				if( array_key_exists( $nameOfNode, $this->_newNodesListFolderA) ) $newInstall = true;
			}

			// confirming new install through database entry
			// 		if($newInstall)
				// 		{
			// 			if(WExtension::exist( $nameOfNode.'.node' ))
				// 			{
			// 				$newInstall = false ;
			// 				$this->_joobiInfoLog("newInstall confirmation failed for node : ".$nameOfNode);
			// 			}
			// 		}

			return $newInstall;

	}





	private function _importQueries( $array ) {	// , $prefix

		//$this->_joobiInfoLog("_importQueries()");

		try {

			   if($this->cmsName == 'joomla')
			   {
			      $db = JFactory::getDbo();

			      if (is_array($array) && count($array)>0){


				   foreach($array as $query){
					$query = trim($query);
					if ( !empty($query) ){
						$db->setQuery( $query );
						$db->query();
					}//endif
				   }//endroreach

			      }//endif
			      else {

				   $query = trim($array);
				   if ( !empty($query) ){
					$db->setQuery( $query );
					$db->query();
				   }//endif
			     }
		      } // if loop for cms check
		      else if($this->cmsName == 'wordpress')
		      {
		      	global $wpdb;
		      	//$results = $wpdb->get_results( 'SELECT * FROM wp_options WHERE option_id = 1', OBJECT );


		      	if (is_array($array) && count($array)>0){


		      		foreach($array as $query){
		      			$query = trim($query);
		      			if ( !empty($query) ){
		      				$wpdb->query( $query );
		      			}//endif
		      		}//endroreach

		      	}//endif
		      	else {

		      		$query = trim($array);
		      		if ( !empty($query) ){
		      			$wpdb->query( $query );
		      		}//endif
		      	}

		      } // if else loop for cms check

		}//try catch
		catch (Exception $e) { $this->_joobiErrorLog("Error in _importQueries() . Here is the error...<br>".$e->getMessage()); return false ;  }//trycatch block ends

		return true;


	}//endfct


	private function _splitSql( $content, $limit=';', $avoid=null, $comments=true ) {

		$this->_joobiInfoLog("_splitSql()");

		if ($content === false) return false;

		if ($avoid == null) $avoid = array('"','`',"'");
		$array = array();

		//clean the content
		//	if ($comments) $content = preg_replace(array('`^[ \t]*#.*$`m', '`^[ \t]*--.*$`m'),'', trim($content) );

		$len = strlen($content);
		$h=0;//start of the query
		$stack = 0;
		$stringuse='';
		for($i=0;$i<$len;$i++)
		{
			switch($stack)
			{
				//in a query
				case 0:
					switch($content[$i])
					{
						//end of a query
						case $limit:
							//store the query in the array
							$array[]=trim(substr($content,$h,$i+1-$h));
							//update the query start pointer
							$h=$i+1;
						default:
							//start of a string
							if (in_array($content[$i],$avoid)) {
								$stack++;
								$stringuse = $content[$i];
							}
							break;
					}
					break;
					//in a string
				case 1:
					if ($content[$i] == $stringuse && $content[$i-1]!="\\")
					{
						//it's the end of the string
						$stack--;
					}
				default:
					break;
			}
		}
		return $array;
	}//endfct


/**
 * We donot install if underlying CMS version is less than a specific number
 */
//	private function _getAppDetails() {
//
//		$this->_joobiInfoLog( "_getAppDetails()" );
//
//		if ( $this->_cmsName == 'joomla' ) {
//			// TODO : Check for isset or property exists
//
//			$this->_appVersion = $this->_parentClass->get( "manifest" )->version;
//			$this->_appName = $this->_parentClass->get( "manifest" )->name;
//			$this->_joobiInfoLog("_appVersion : ".$this->_appVersion);
//			$this->_joobiInfoLog("_appName : ".$this->_appName);
//		}//endif
//
//	}//endfct


}//endclass


class fileException extends Exception{}
class databaseException extends Exception{}
class outsideCallException extends Exception{}