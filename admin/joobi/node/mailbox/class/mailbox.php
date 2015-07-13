<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_Mailbox_class extends WClasses {
	






	private $_connector;

	




	public $report = true;


	





	public $deleteMessage = false;

	



	private $_reports = array();


	



	public $finishProcessing = false;








	public function initialize($mailbox) {

		$addonType = explode( '.', $mailbox->addon );
		WLoadFile( 'mailbox.addon.class', JOOBI_DS_NODE );
		$this->_connector = WAddon::get( 'mailbox.'.$addonType[0] );

		if ( !method_exists($this->_connector,'connect') ) {
			if ($this->report){
				$message = WMessage::get();
				$ADDON = $mailbox->addon;
				$message->codeE('Can not load the mailbox addon '.$ADDON);
			}			return false;
		}
				if ( !empty($addonType[1]) ) $this->_connector->subtype = $addonType[1];

				$this->_connector->report = $this->report;
				$this->_connector->addProperties($mailbox);
				WTools::getParams( $this->_connector, 'params' );

		if ( method_exists($this->_connector,'initialize') ) {
						if ( !$this->_connector->initialize() ) return false;
		}
		if (!$this->_connector->connect() ) {
			if ($this->report){
				$message = WMessage::get();
				$NAME = $mailbox->name;
				$message->userE('1418159587ECXG',array('$NAME'=>$NAME));
				$errors = $this->_connector->getErrors();
				if (!empty($errors)){
					foreach($errors as $error){
						$message->userE($error);
					}
				}
			}
			return false;
		}

				$this->_connector->addInformation( 'type', 1 );

		return true;

	}

	public function getSubject(){
		return $this->_connector->getSubject();
	}

	public function getBody($forceText=false){
		return $this->_connector->getBody($forceText);
	}

	public function isHTML(){
		return $this->_connector->isHTML();
	}





	public function setDeleteMSG(){
		$this->deleteMessage = true;

	}






	public function getMessage(){
		return $this->_connector->getMessage();
	}

	public function getNumberOfMessages(){
		return $this->_connector->getNumberOfMessages();
	}








	public function addInformation($name,$info){
		$this->_connector->addInformation( $name, $info );
	}







	public function getInformation($name='',$default='') {

		return $this->_connector->getInformation( $name, $default );

	}
	





	public function setType($type=1) {
		return $this->_connector->addInformation( 'type', $type );
	}

	


	public function stopWidgetsProcessing() {
		$this->finishProcessing = true;
	}

	




	public function process() {
		return true;
	}


	




	public function checkUsage(){
		return true;
	}

	



	public function checkAllMessages(){
		$this->_connector->checkAllMessages();
	}

	



	public function addReport($report){
		if (empty($report)) return;
		if (is_array($report)) $this->_reports = array_merge($this->_reports,$report);
		else $this->_reports[] = (string) $report;
	}






	public function getReports(){
		return $this->_reports;
	}




	public function &getConnector() {
		$connector =& $this->_connector;
		return $connector;
	}




	public function setConnector(&$connector) {
		$this->_connector =& $connector;
	}
}