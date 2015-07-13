<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_Handle_class extends WClasses {

	var $report = true;
	var $_reports = array();
	var $maxtime = 0;		var $finishProcessing = false;







	public function processMailbox($myMailBox=null){

						if ( empty($myMailBox) ) {
			$mailbox = WModel::get( 'mailbox' );
			$mailbox->rememberQuery( true, 'Mailbox_node' );
			$mailbox->whereE( 'publish', 1 );
			$mailboxes = $mailbox->load( 'ol' );
		} else {
			$mailboxes[] = $myMailBox;
		}
		if ( empty($mailboxes) ) return true;

		$message = WMessage::get();

				if ( empty($this->maxtime) ) {
						$maxexectime = ini_get('max_execution_time');
						if ( empty($maxexectime) ) $maxexectime = 40;
			$this->maxtime = time() + $maxexectime - 10;
		}
		$prefMailbox = WPref::get('mailbox.node');
		$deleteStatsDays = $prefMailbox->getPref( 'deletestats', 0 );
		$deleteMsgDays = $prefMailbox->getPref( 'deletemsg', 0 );

		
				if ( !empty($deleteMsgDays) ) {
			$handleModel = WModel::get( 'mailbox.messages' );
			$handleModel->where('created','<',time() - $deleteMsgDays * 86400 );				$handleModel->delete();
		}
				foreach( $mailboxes as $myMailBox ) {

			$this->displayReports();

						if ( !$this->continueProcess() ) {
				$this->addReport( WText::t('1389656700JZFI') );
				break;
			}
			$connection = $this->connect( $myMailBox );

			$MAILBOX_NAME = $myMailBox->name;
			if ($connection === false){
				$this->addReport( str_replace(array('$MAILBOX_NAME'), array($MAILBOX_NAME),WText::t('1242580111TAIP')) );
				continue;
			}			else{
				$this->addReport( str_replace(array('$MAILBOX_NAME'), array($MAILBOX_NAME),WText::t('1242580111TAIQ')) );
			}
						$connectorO =& $connection->getConnector();

									$actions = WModel::get( 'mailbox.email' );
			$actions->makeLJ('apps','wid');            			$actions->whereE('publish',1,1);               			$actions->whereE( 'inbid', $myMailBox->inbid );   			$actions->orderBy('ordering','ASC');
			$actions->select('name',1);
			$actions->select('namekey',1);
			$actions->select('wid',1);
			$myActions = $actions->load('ol');

						$connection->checkAllMessages();

						while( $connection->getMessage() !== false ) {
				$deleteMessage = false;
				$type = array();

                $SUBJECT = $connection->getSubject();

								if ( !empty($myActions) ) {
					foreach( $myActions as $oneAction ) {
						$FILE = substr($oneAction->namekey,0,strrpos($oneAction->namekey,'.'));
						$externalAction = WAddon::get( $FILE, null, 'mailbox' );
						if (!method_exists($externalAction,'process')){
							if ($this->report) $message->codeE('There is no process function in the file '.$FILE);
							continue;
						}
						$externalAction->setConnector( $connection->getConnector() );

												WPref::get( $oneAction->wid );
						$externalAction->report = $this->report;

																														if ( $externalAction->process() ) {
														$this->addReport( $externalAction->getReports() );
							if ( $externalAction->deleteMessage ) {
																$deleteMessage = true;
								break;
							}
						} else {								if ( $externalAction->deleteMessage ) {
								$deleteMessage = true;
							}							break;
						}
					}
				}
				$type = $connection->getInformation('type');
				$box = $connection->getInformation('box');

								if ( ( !empty($connectorO->savemessage) && !empty($type) ) && ( ($type == 1 || $type == 2) && ($connectorO->savemessage == 1) ) ){
					$mailboxMessage = WModel::get( 'mailbox.messages' );
					$mailboxMessage->setVal('inbid',$myMailBox->inbid);
					$mailboxMessage->setVal('subject',$connection->getSubject());
					$mailboxMessage->setVal('header',$connection->getInformation('headerstring'));
					$mailboxMessage->setVal('body',$connection->getBody());
					$mailboxMessage->setVal('created',time());
					$mailboxMessage->setVal('type', $type );
					if ( !empty($box) ) $mailboxMessage->setVal('box', $box );
					$mailboxMessage->setVal( 'sender', $connection->getInformation('bouncedemail', $connection->getInformation('sender_email') ) );
					$mailboxMessage->insert();
					$connectorO->mgsid = $mailboxMessage->lastID();
					$this->addReport(str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXH')));

															if ($box==1 AND !empty($connectorO->forward)){
						$forwardMessage = WMail::get();
						$forwardMessage->addParameter('subject',$connection->getSubject());
						$forwardMessage->addParameter('body',$connection->getBody());
						$forwardMessage->addParameter($connection->getInformation());
						$forwardMessage->addSender($connection->getInformation('from_email'),$connection->getInformation('from_name'));
						$forwardMessage->replyTo($connection->getInformation('reply_to_email'),$connection->getInformation('reply_to_name'));
						$EMAIL_ADDRESS = trim($connectorO->forward);

						$forwardStatus = $forwardMessage->sendNow($EMAIL_ADDRESS,'forward_message',false);
						if ($forwardStatus){
							$this->addReport(str_replace(array('$SUBJECT','$EMAIL_ADDRESS'), array($SUBJECT,$EMAIL_ADDRESS),WText::t('1242580111TAIS')));
						} else {
							$this->addReport(str_replace(array('$SUBJECT','$EMAIL_ADDRESS'), array($SUBJECT,$EMAIL_ADDRESS),WText::t('1242580111TAIT')));
						}
					}
				}
								if ( !empty($connectorO->savemessage)  && ($connectorO->savemessage == 2 ) ) {
					$mailboxMessage = WModel::get( 'mailbox.messages' );
					$mailboxMessage->setVal('inbid',$myMailBox->inbid);
					$mailboxMessage->setVal('subject',$connection->getSubject());
					$mailboxMessage->setVal('header',$connection->getInformation('headerstring'));
					$mailboxMessage->setVal('body',$connection->getBody());
					$mailboxMessage->setVal('created',time());
					if ( !empty($type) ) $mailboxMessage->setVal('type', $type );
					if ( !empty($box) ) $mailboxMessage->setVal('box', $box );
					$mailboxMessage->setVal( 'sender', $connection->getInformation( 'bouncedemail', $connection->getInformation('sender_email') ) );
					$mailboxMessage->insert();
					$connectorO->mgsid = $mailboxMessage->lastID();
					$this->addReport(str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXH')));

															if ($box==1 AND !empty($connectorO->forward)){
						$forwardMessage = WMail::get();
						$forwardMessage->addParameter('subject',$connection->getSubject());
						$forwardMessage->addParameter('body',$connection->getBody());
						$forwardMessage->addParameter($connection->getInformation());
						$forwardMessage->addSender($connection->getInformation('from_email'),$connection->getInformation('from_name'));
						$forwardMessage->replyTo($connection->getInformation('reply_to_email'),$connection->getInformation('reply_to_name'));
						$EMAIL_ADDRESS = trim($connectorO->forward);

						$forwardStatus = $forwardMessage->sendNow($EMAIL_ADDRESS,'forward_message',false);
						if ($forwardStatus){
							$this->addReport(str_replace(array('$SUBJECT','$EMAIL_ADDRESS'), array($SUBJECT,$EMAIL_ADDRESS),WText::t('1242580111TAIS')));
						} else {
							$this->addReport(str_replace(array('$SUBJECT','$EMAIL_ADDRESS'), array($SUBJECT,$EMAIL_ADDRESS),WText::t('1242580111TAIT')));
						}
					}
				}
								if ( $deleteMessage && !empty($connectorO->delete ) ) {

					if ( $connectorO->deleteMSG() ) {
						$this->addReport( str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXI')) );
					} else {
						$this->addReport(str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXJ')));
						$errors = $connectorO->getErrors();
						if (!empty($errors)){
							foreach($errors as $error){
								$this->addReport($error);
							}
						}
					}
				}
								if ( $deleteMessage && !empty($connectorO->deletemsg) ) {

					if ( $connectorO->deleteMSG() ) {
						$this->addReport(str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXK')));
					} else {
						$this->addReport(str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXJ')));
						$errors = $connectorO->getErrors();
						if (!empty($errors)){
							foreach($errors as $error){
								$this->addReport($error);
							}
						}
					}
				}
								if ( !$this->continueProcess() ) {
					$this->addReport( WText::t('1389656700JZFI') );
					break;
				}
			}
						$connectorO->disconnect();

		}
		$this->displayReports();

	}





	public function displayReports(){
		if ($this->report AND !empty($this->_reports)){
			$message = WMessage::get();
			$entireMessage = '<ul><li>'.implode('</li><li>',$this->_reports).'</li></ul>';
			$message->userN($entireMessage);
			$this->_reports = array();
		}

	}








	public function continueProcess(){
		if (time() >= $this->maxtime) return false;
		return true;
	}







	public function connect($myMailBox) {
		static $connection=null;

		if ($this->report){
			$message = WMessage::get();
			$NAME = $myMailBox->name;
		}
		if ( !isset($connection) ) $connection = WClass::get('mailbox.mailbox');
		$connection->report = $this->report;
		if ( !$connection->initialize( $myMailBox ) ) return false;

		if ( $this->report ) {
			$message->userS('1418159587ECXL',array('$NAME'=>$NAME));
						$NBMSG = $connection->getNumberOfMessages();
			$message->userN('1418159587ECXM',array('$NBMSG'=>$NBMSG,'$NAME'=>$NAME));
		}
		return $connection;

	}






	public function addReport($message){
		if (empty($message)) return;
		if (is_array($message)) $this->_reports = array_merge($this->_reports,$message);
		else $this->_reports[] = $message;
	}





	public function getReports(){
		return $this->_reports;
	}
}