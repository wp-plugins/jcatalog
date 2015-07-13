<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



 class Mailbox_Imap_addon extends Mailbox_Addon_class {

	var $report = true;
	protected $_currentMessage = null;		protected $_mbox = null;					var $_messages = array();		







	public function initialize() {

		$this->helper = WClass::get( 'mailbox.helper' );

		if ( extension_loaded( 'imap' ) ) return true;

				$prefix = ( PHP_SHLIB_SUFFIX == 'dll' ) ? 'php_' : '';
		$EXTENSION = $prefix . 'imap.' . PHP_SHLIB_SUFFIX;
		$fatalMessage = 'The system tried to load dynamically the ' . $EXTENSION . ' extension';
		$fatalMessage .= '<br/>If you see this message, that means the system could not load this PHP extension';
		$fatalMessage .= '<br/>Please enable the PHP Extension '.$EXTENSION;
		ob_start();
		echo $fatalMessage;

				dl( $EXTENSION );
		$warnings = str_replace( $fatalMessage, '', ob_get_clean() );
		if ( extension_loaded("imap") || function_exists('imap_open') ) return true;

		$message = WMessage::get();
		$message->adminW( 'The extension "'.$EXTENSION.'" could not be loaded, please change your PHP configuration to enable it', array(), 0 );
		if ( !empty($warnings) ) $message->adminW( $warnings, array(), 0 );

		return false;

	}






	function connect() {

				$buff = imap_alerts();
		$buff = imap_errors();


		$pref = WPref::get('mailbox.node');
		$timeout = $pref->getPref( 'opentimeout', 0 );
		if (!empty($timeout)) imap_timeout( IMAP_OPENTIMEOUT, $timeout );

		$serverName = '{'.$this->server;
		if (!empty($this->port)) $serverName .= ':'.$this->port;
				if (!empty($this->secure)) $serverName .= '/'.$this->secure;
		if (!empty($this->nocertif)) $serverName .= '/novalidate-cert';
				if (!empty($this->subtype)) $serverName .='/service='.$this->subtype;
		$serverName .= '}';

		ob_start();

		$this->_mbox = imap_open( $serverName, $this->username, $this->password );

		$warnings = ob_get_clean();

		if (!empty($warnings)){
			$message = WMessage::get();
			$message->userW($warnings);
		}
		$imapErrors = imap_errors();
		if (!empty($imapErrors)){
			$message = WMessage::get();
			$message->userW($imapErrors);
		}

		return $this->_mbox ? true : false;

	}

	




	function getNumberOfMessages(){
		return imap_num_msg($this->_mbox);
	}







	function getMessage(){

		if (empty($this->_messages)) return false;
				$msgNB = array_pop($this->_messages);

		$this->_currentMessage = imap_headerinfo( $this->_mbox, $msgNB );

		$this->addInformation( 'username', $this->username );
		$this->addInformation( 'server', $this->server);
		$this->addInformation( 'headerstring', $this->helper->explodeObject($this->_currentMessage) );
		$this->_currentMessage->messageNB = $msgNB;

				$this->_currentMessage->structure = imap_fetchstructure( $this->_mbox, $msgNB );
		if ( empty($this->_currentMessage->structure) ) return false;

				$this->_decodeBody();
		$this->_convertHeader();

		return true;

	}

	




	function getSubject(){
		if ( !empty($this->_currentMessage->subject) ) return $this->_currentMessage->subject;
	}

	







	function getBody($forceText=false){
		if (($forceText === true AND !empty($this->_currentMessage->text))) return $this->_currentMessage->text;
		if (!empty($this->_currentMessage->html)) return $this->_currentMessage->html;

		$returnText = $this->_currentMessage->text;
		if ($forceText === false) $returnText = nl2br($returnText);

		return $returnText;
	}






	function getFullheader(){
		$last = null;
		$header_string = imap_fetchheader( $this->_mbox, $this->_currentMessage->messageNB );
			$header_array = explode ( "\n", $header_string );
			foreach($header_array as $line){
			if ( eregi( "^([^:]*): (.*)", $line, $arg) ) {
				$header_obj[$arg[1]] = $arg[2];
				$last = $arg[1];
			}			else{
				$header_obj[$last] .= "\n" . $line;
			}		}	return $header_obj;
	}

	






	function isHTML(){
		return $this->_currentMessage->contentType;
	}

	




	function disconnect(){
						return imap_close($this->_mbox);
	}






	function deleteMSG() {
		if ( ! imap_delete( $this->_mbox, $this->_currentMessage->messageNB) ) return false;
		return imap_expunge( $this->_mbox );
	}





	function getMailboxStatus(){
		return imap_mailboxmsginfo( $this->_mbox );
	}





	function getErrors(){
		$return = array();
		$alerts = imap_alerts();
		$errors = imap_errors();
		if (!empty($alerts)) $return = array_merge($return,$alerts);
		if (!empty($errors)) $return = array_merge($return,$errors);
		return $return;
	}






	function addInformation($name,$info) {
		if ( !isset($this->_currentMessage) ) $this->_currentMessage = new stdClass;
		if ( !isset($this->_currentMessage->informations) ) $this->_currentMessage->informations = new stdClass;
		$this->_currentMessage->informations->$name = $info;
	}
	






	public function getInformation($name='',$default='') {
		if ( empty($name) ) return $this->_currentMessage->informations;
		if ( isset($this->_currentMessage->informations->$name ) ) return $this->_currentMessage->informations->$name;
		return $default;
	}





	public function getCurrentMessage($property=null) {
		if ( empty( $this->_currentMessage ) ) return null;
		if ( !empty($property) ) {
			if ( isset( $this->_currentMessage->$property ) ) {
				return $this->_currentMessage->$property;
			} else {
				return null;
			}		} else {
			return $this->_currentMessage;
		}	}

	



	private function _convertHeader() {
		$this->_decodeAddress('sender');
		$this->_decodeAddress('from');
		$this->_decodeAddress('reply_to');
		$this->_decodeAddress('to');
	}
	





	private function _decodeAddress($type){
		$address = $type.'address';
		$name = $type.'_name';
		$email = $type.'_email';
		if (empty($this->_currentMessage->$type)) return false;

		$var = $this->_currentMessage->$type;

		if (!empty($this->_currentMessage->$address)){
			$this->_currentMessage->informations->$name = $this->_currentMessage->$address;
		} else {
			$this->_currentMessage->informations->$name = $var[0]->personal;
		}
		$this->_currentMessage->informations->$email = $var[0]->mailbox.'@'.$var[0]->host;
		return true;

	}
	



	private function _decodeBody(){


		$this->_currentMessage->html = '';
		$this->_currentMessage->text = '';

				if ($this->_currentMessage->structure->type == 1){
			$this->_currentMessage->contentType = 2;
			$allParts = $this->helper->explodeBody($this->_currentMessage->structure);

			$html = '';
			$plain = '';
			foreach($allParts as $num => $onePart){
				$charset = $this->helper->getMailParam($onePart,'charset');
	            if ($onePart->subtype=='HTML'){
	            	$this->_currentMessage->html = $this->_decodeContent(imap_fetchbody($this->_mbox,$this->_currentMessage->messageNB,$num),$onePart);
	            }elseif ($onePart->subtype=='PLAIN'){
	            	$this->_currentMessage->text = $this->_decodeContent(imap_fetchbody($this->_mbox,$this->_currentMessage->messageNB,$num),$onePart);
	            }
			}
		} else {
			$charset = $this->helper->getMailParam($this->_currentMessage->structure,'charset');
			if ($this->_currentMessage->structure->subtype == 'HTML'){
				$this->_currentMessage->contentType = 1;
				$this->_currentMessage->html = $this->_decodeContent(imap_body($this->_mbox,$this->_currentMessage->messageNB),$this->_currentMessage->structure);
			} else {
				$this->_currentMessage->contentType = 0;
				$this->_currentMessage->text = $this->_decodeContent(imap_body($this->_mbox,$this->_currentMessage->messageNB),$this->_currentMessage->structure);
			}
		}

				if ( !empty($this->_currentMessage->subject) ){
			$this->_currentMessage->subject = $this->helper->decodeHeader($this->_currentMessage->subject);
			if (!$charset AND !empty($this->helper->charset)) $charset = $this->helper->charset;
			if ($charset) $this->_currentMessage->subject = WPage::changeEncoding($this->_currentMessage->subject,$charset,'UTF-8');
		}
	}









	private function _decodeContent($content,$structure){
		$encoding = $structure->encoding;

		        if ($encoding == 2) $content = imap_binary($content);
        elseif ($encoding == 3) $content = imap_base64($content);
        elseif ($encoding == 4) $content = imap_qprint($content);
		
                $charset = $this->helper->getMailParam($structure,'charset');
        if ($charset){
        	        	$content = WPage::changeEncoding($content,$charset,'UTF-8');
        }

        return $content;

	}

}