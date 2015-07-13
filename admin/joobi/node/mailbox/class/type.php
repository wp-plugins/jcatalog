<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_Type_class extends Mailbox_Mailbox_class {

	var $report = false;

	





	public function identifyType() {

		$typeFile = WType::get('mailbox.type');

		$message = WMessage::get();
				$identifyType = $this->getInformation('sender_name') . $this->getInformation('sender_email') . $this->getSubject();
		$SUBJECT = $this->getSubject();

				$pref = WPref::get( 'mailbox.node' );
		$bounceString = $pref->getPref( 'regexbounce' );
		$identifyemail = $pref->getPref( 'identifyemail' );

				if ( !empty($identifyemail) ) $identifyemail = trim($identifyemail).'|';

				$identifyemail .= str_replace(array('%'),array('@'),$this->getInformation('username',''));
				$identifyemail = '#'.$identifyemail.'#i';

		$patternEmail = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@([a-z0-9\-]+\.)+[a-z0-9]{2,7}/i';

		if ( preg_match( '#'.$bounceString.'#i', $identifyType ) ) {

			$bounceType = $typeFile->getValue('bounce');
			$this->addInformation('type',$bounceType);
			$this->addInformation('box',30); 			preg_match_all( $patternEmail, $this->getBody(), $results );
			$bouncedemail = '';
			if (!empty($results[0])){
				foreach($results[0] as $oneEmail){
										if (!preg_match($identifyemail,$oneEmail)){
												$bouncedemail = strtolower($oneEmail);
						break;
					}				}			}
			if ( !empty($bouncedemail) ) {

				$this->addInformation( 'bouncedemail', $bouncedemail );
				$ADDRESS = $bouncedemail;
				$this->addReport( str_replace(array('$SUBJECT','$ADDRESS'), array($SUBJECT,$ADDRESS),WText::t('1418159587ECXP')) );

								$mailboxBounceC = WClass::get( 'mailbox.bounce' );
				$infos = $mailboxBounceC->addHandled( $bouncedemail, $bounceType );
				if ( !empty($infos) ) {
										$this->addInformation( 'total', $infos->total );
					$this->addInformation( 'delay', $infos->delay );
				}			} else {
				$this->addReport(str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXQ')));
			}			return true;

		}
		$this->addInformation( 'type', 2 );
		$this->addReport( str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXR')) );

		return false;

	}

}