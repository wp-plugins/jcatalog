<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_Node_install extends WInstall {

	public function install(&$object) {

		if ( !empty( $this->newInstall ) || ( property_exists($object, 'newInstall' ) && $object->newInstall) ) {


			$mainInstallC = WClass::get( 'main.install' );
			$mainInstallC->insertExtension( 'mailbox.filter.mailbox', 'Dictionary Filter', 'mailbox.node' );


						$mailboxM = WModel::get( 'mailbox' );

	    		    	$widgetM = WModel::get( 'mailbox.email' );

						$mailboxM->name = 'Sample Mailbox';
			$mailboxM->description = 'This sample mailbox is created just for our reference, on how we should create and set the connection of the mailbox';
			$mailboxM->publish=0;
			$mailboxM->addon = 'imap';
			$mailboxM->username='youremail@domain.com';
			$mailboxM->password='password';
			$mailboxM->server='imap.domain.com';
			$mailboxM->params="secure=ssl\nnocertif=1\nport=993\nsavemessage=2\ndeletemsg=1";
			$mailboxM->returnId();
			$mailboxM->save();


			if ( !isset($widgetsM) ) $widgetsM = WModel::get('apps');
			$widgetsM->whereE('type','78');
									$widgets = $widgetsM->load('lra','wid');

			if ( isset($mailboxM->inbid) ) {

				$inbid = $mailboxM->inbid;
				$widgetM->inbid=$inbid;
				$order=1; 
				for( $count=0; $count<=count($widgets)-1; $count++ ) {
										$widgetM->wid=$widgets[$count];
					$widgetM->ordering=$order;
					$widgetM->save();
					$order++;
				}
			}

			$schedulerInstallC = WClass::get( 'scheduler.install' );
			$schedulerInstallC->newScheduler(
			  'mailbox.mailbox.scheduler'
			, WText::t('1241989374PAXK')
			, WText::t('1433086401BPBR')
			, 70				, 1800				, 120				, 1					);

			$schedulerInstallC->newScheduler(
			  'mailbox.emptytrashbox.scheduler'
			, WText::t('1260253904QSSP')
			, WText::t('1260253904QSSO')
			, 80				, 86400				, 60				, 1					);


			$installWidgetsC = WClass::get( 'install.widgets' );
			$installWidgetsC->installTable( 'mailbox.ruledictionary', $this->_installValuesA() );


		}
		return true;

	}





	function version_1688() {

		$mainInstallC = WClass::get( 'main.install' );
		$mainInstallC->insertExtension( 'mailbox.filter.mailbox', 'Dictionary Filter', 'mailbox.node' );

	}





	private function _installValuesA() {

		return array(
  array('dctid' => '2','words' => 'You have been added to','type' => '35','core' => '1','searchin' => '2','publish' => '1','ordering' => '2'),
  array('dctid' => '3','words' => 'Autoresponder','type' => '30','core' => '1','searchin' => '1','publish' => '1','ordering' => '3'),
  array('dctid' => '4','words' => 'Out of Office','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '4'),
  array('dctid' => '5','words' => 'Out of the Office','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '5'),
  array('dctid' => '6','words' => 'Vacation Reply','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '6'),
  array('dctid' => '7','words' => 'Out of Office Autoreply','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '7'),
  array('dctid' => '8','words' => 'Yahoo! Auto Response ','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '8'),
  array('dctid' => '9','words' => 'Yahoo! -Message d\'absence','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '9'),
  array('dctid' => '10','words' => 'Αυτόματη απόκριση του Yahoo!','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '10'),
  array('dctid' => '11','words' => 'Respuesta automática de Yahoo!','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '11'),
  array('dctid' => '12','words' => 'AutoReply','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '12'),
  array('dctid' => '13','words' => 'Automatski odgovor','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '13'),
  array('dctid' => '14','words' => 'Automaska potrvda','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '14'),
  array('dctid' => '15','words' => 'Respuesta automática','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '15'),
  array('dctid' => '16','words' => 'Automatisch antwoord bij afwezigheid:','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '16'),
  array('dctid' => '17','words' => 'Absence du bureau :','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '17'),
  array('dctid' => '18','words' => 'Abwesend:','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '18'),
  array('dctid' => '19','words' => 'AUTO:','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '19'),
  array('dctid' => '20','words' => 'Réponse automatique d\'absence du bureau','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '20'),
  array('dctid' => '21','words' => 'Notification d\'absence','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '21'),
  array('dctid' => '22','words' => 'Réponse en cas d\'absence','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '22'),
  array('dctid' => '23','words' => 'Out of Office Notification','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '23'),
  array('dctid' => '24','words' => 'Automatic Autoresponder','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '24'),
  array('dctid' => '25','words' => 'Autoresponse from','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '25'),
  array('dctid' => '26','words' => 'Urlaub / Vacaciones','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '26'),
  array('dctid' => '27','words' => 'Risposta di assenza','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '27'),
  array('dctid' => '28','words' => 'what that means?  Niet aanwezig: walt','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '28'),
  array('dctid' => '29','words' => 'Auto Answer','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '29'),
  array('dctid' => '30','words' => 'Email Address Changed','type' => '40','core' => '1','searchin' => '2','publish' => '1','ordering' => '30'),
  array('dctid' => '31','words' => 'Email address has changed','type' => '40','core' => '1','searchin' => '2','publish' => '1','ordering' => '31'),
  array('dctid' => '32','words' => 'Changement d\'adresse email','type' => '40','core' => '1','searchin' => '2','publish' => '1','ordering' => '32'),
  array('dctid' => '33','words' => 'Change of Address','type' => '40','core' => '1','searchin' => '2','publish' => '1','ordering' => '33'),
  array('dctid' => '34','words' => 'Mail adres niet meer in gebruik','type' => '40','core' => '1','searchin' => '2','publish' => '1','ordering' => '34'),
  array('dctid' => '35','words' => 'Message Receive Do Not Reply','type' => '20','core' => '1','searchin' => '2','publish' => '1','ordering' => '35'),
  array('dctid' => '36','words' => 'NON RECAPITATO','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '36'),
  array('dctid' => '37','words' => 'Your Message has been received','type' => '20','core' => '1','searchin' => '2','publish' => '1','ordering' => '37'),
  array('dctid' => '38','words' => 'Thank you for contacting us','type' => '20','core' => '1','searchin' => '2','publish' => '1','ordering' => '38'),
  array('dctid' => '39','words' => 'AntiSpam:','type' => '15','core' => '1','searchin' => '2','publish' => '1','ordering' => '39'),
  array('dctid' => '40','words' => 'AntiSpam requires you to confirm that you are a legitimate sender','type' => '15','core' => '1','searchin' => '2','publish' => '1','ordering' => '40'),
  array('dctid' => '41','words' => 'Message Not Delivered','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '41'),
  array('dctid' => '42','words' => 'verify your account','type' => '10','core' => '1','searchin' => '1','publish' => '1','ordering' => '43'),
  array('dctid' => '43','words' => 'Verification of Account','type' => '10','core' => '1','searchin' => '2','publish' => '1','ordering' => '45'),
  array('dctid' => '44','words' => 'Your email requires verification verify','type' => '10','core' => '1','searchin' => '2','publish' => '1','ordering' => '46'),
  array('dctid' => '45','words' => 'Reply to this message and leave the subject line intact','type' => '10','core' => '1','searchin' => '1','publish' => '1','ordering' => '47'),
  array('dctid' => '46','words' => 'failure notice','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '48'),
  array('dctid' => '47','words' => 'require','type' => '15','core' => '1','searchin' => '1','publish' => '1','ordering' => '49'),
  array('dctid' => '51','words' => 'Re:','type' => '25','core' => '1','searchin' => '2','publish' => '1','ordering' => '1'),
  array('dctid' => '53','words' => 'Non remis:','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '50'),
  array('dctid' => '54','words' => 'Undeliverable:','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '51'),
  array('dctid' => '55','words' => 'Nondeliverable mail','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '52'),
  array('dctid' => '56','words' => 'Returned mail: see transcript for details','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '53'),
  array('dctid' => '58','words' => 'DELIVERY FAILURE: Recipient\'s Domino Directory entry does not specify a valid Notes mail file','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '54'),
  array('dctid' => '59','words' => 'Mail delivery failed: returning message to sender','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '42'),
  array('dctid' => '60','words' => 'Delivery Notification','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '44'),
  array('dctid' => '62','words' => 'Neisporučivo メールの配達に失敗しました (Mail delivery failed)','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '55'),
  array('dctid' => '63','words' => 'Your Message Could Not Be Delivered','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '56'),
  array('dctid' => '64','words' => 'Mail System Error - Returned Mail','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '57'),
  array('dctid' => '65','words' => '[Auto-Reply]','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '58'),
  array('dctid' => '66','words' => 'failure delivery ','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '59'),
  array('dctid' => '67','words' => 'Mail Delivery Failure','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '60'),
  array('dctid' => '68','words' => 'Undelivered Mail Returned to Sender','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '61'),
  array('dctid' => '69','words' => 'Warning: message delayed 25 hours','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '62'),
  array('dctid' => '70','words' => 'Delivery Notification: Delivery has timed out and failed','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '63'),
  array('dctid' => '71','words' => 'Delivery Notification: Delivery has been delayed','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '64'),
  array('dctid' => '72','words' => 'Warning: message 1NDcJD-000331-PO delayed 48 hours','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '65'),
  array('dctid' => '73','words' => 'Notification d\'+AOk-tat de remise (+AOk-chec)','type' => '30','core' => '1','searchin' => '2','publish' => '1','ordering' => '66'),
  array('dctid' => '74','words' => 'Email security change','type' => '40','core' => '1','searchin' => '2','publish' => '1','ordering' => '67'),
  array('dctid' => '75','words' => 'Your E-Mail','type' => '40','core' => '1','searchin' => '2','publish' => '1','ordering' => '68'),
  array('dctid' => '76','words' => 'Het e-mailbericht is vertraagd:','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '69'),
  array('dctid' => '77','words' => 'Zprava o nedoruceni:','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '70'),
  array('dctid' => '78','words' => 'Nondeliverable','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '71'),
  array('dctid' => '79','words' => 'There has been a problem delivering your email','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '72'),
  array('dctid' => '80','words' => 'Delivery to the following recipient failed permanently:','type' => '5','core' => '1','searchin' => '2','publish' => '1','ordering' => '73')
);

	}
}