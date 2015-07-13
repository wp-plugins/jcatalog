<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_Node_install extends WInstall {

	public function install(&$object) {



		if ( !empty( $this->newInstall ) || ( property_exists($object, 'newInstall' ) && $object->newInstall) ) {

			$mainInstallC = WClass::get( 'main.install' );
			$mainInstallC->insertExtension( 'ticket.emailreplyconvert.mailbox', 'Email Reply Conversion', 'ticket.node' );
			$mainInstallC->insertExtension( 'ticket.ticketbyemail.mailbox', 'Email to ticket conversion', 'ticket.node' );

			$schedulerInstallC = WClass::get( 'scheduler.install' );
			$schedulerInstallC->newScheduler(
			  'ticket.ticketclose.scheduler'
			, WText::t('1230530205IVSH')
			, WText::t('1230530205IVSG')
			, 100				, 86400				, 60				, 1					);

			$schedulerInstallC->newScheduler(
			  'ticket.latereply.scheduler'
			, WText::t('1389884106NVYT')
			, WText::t('1389884106NVYU')
			, 100				, 21600				, 60				, 1					);

			$schedulerInstallC->newScheduler(
			  'ticket.ticketwarnuser.scheduler'
			, WText::t('1233642225DNTT')
			, WText::t('1233642225DNTS')
			, 50				, 86400				, 60				, 1					);

			$schedulerInstallC->newScheduler(
			  'ticket.ticketwarning.scheduler'
			, WText::t('1225790131RNIX')
			, WText::t('1230530205IVSF')
			, 50				, 604800				, 60				, 1					);


		}

				$projectM = WModel::get( 'project');
		$projectM->whereIn( 'namekey', array( 'root', 'default', 'other_vendors' ) );
		$categoryA = $projectM->load( 'lra', 'namekey' );

		if ( empty( $categoryA ) || !is_array($categoryA) || !in_array( 'root', $categoryA ) ) $this->_rootCategory();


				if ( !empty( $this->newInstall ) || ( property_exists($object, 'newInstall') && $object->newInstall) ) {
						$usersSyncroleC = WClass::get( 'users.syncrole' );
			$usersSyncroleC->updateThisRole( 'moderator', 'manager' );
			$usersSyncroleC->updateThisRole( 'supportmanager', 'admin' );
			$usersSyncroleC->process();
						$this->_insertDefType();

		} else {
						$prodTypeM = WModel::get( 'ticket.type' );
			$prodTypeM->whereE( 'namekey', 'ticket_inquiries' );
			$exists = $prodTypeM->exist();

			if ( ! $exists ) {
								$this->_insertDefType();

			}
		}


				WGlobals::setCandy( 50 );


		
		
		$project=WClass::get('ticket.project','init');

		$project->jProjectManagement(false);



		
		
		
		$projectTransM = WModel::get('ticket.projecttrans');

		$projectM = WModel::get('ticket.project');

		



		$projectM->whereE('namekey', 'mainproject',0,null,0,0,0);

		$projectM->whereE('namekey', 'maincategory',0,null,0,0,1);	
		$pjid = $projectM->load('lr', 'pjid');



		$uid = WUser::get('uid'); 

		if ( empty($pjid) ) {				


			$projectM->publish = 1;

			$projectM->parent = 1;

			$projectM->namekey = 'maincategory';

			$projectM->frontend = 1;
			$projectM->uid = $uid;

			$projectM->returnId();

			$projectM->save();



			if ( isset($projectM->pjid) ) {

				$id = $projectM->pjid;



				$lgid = WLanguage::get( 'en', 'lgid' );


				$projectTransM->pjid = $id;

				$projectTransM->lgid = $lgid;

				$projectTransM->name = 'Default Category';

				$projectTransM->description = '';

				$projectTransM->insert();





		







				$ticketM = WModel::get('ticket');

				$ticketM->uid = $uid;

				$ticketM->pjid = $id;

				
				$ticketM->authoruid = $uid;

				$ticketM->tktypeid = 110;			
				$ticketM->priority = 10;		
				$ticketM->private = 1;			
				$ticketM->assignuid = $uid;

				$ticketM->ip = WUser::get( 'ip' );

				$ticketM->returnId();

				$ticketM->save( false );





			


				$ticketT = WModel::get('tickettrans');



				$ticketT->tkid = $ticketM->tkid;

				$ticketT->lgid = $lgid;

				$ticketT->name = 'Welcome!';

				$ticketT->description = 'Thank  you for purchasing jTickets!<br/><br/>

							Here at Joobi, we always aim for simplicity. We wanted to make our customers venture at using our products easier and faster so to become more efficient at work. jTickets is focused on simplicity and automation.

							jTickets helps you manage inbound inquiries, track and respond to customers requests as easy as pie! It got brisk and flexible features for you to enjoy!<br/><br/>

							Enjoy business with jTickets!<br/><br/>

							Should you have questions, do not hesitate to contact our support';



				$ticketT->insert();



		







			}
		} else {							
			
			$projectM->whereE('pjid', $pjid);

			$projectM->setVal('namekey', 'maincategory');

			$projectM->update();



			
			$projectTransM->whereE('pjid', $pjid);

			$projectTransM->setVal('name', 'Default Category');

			$projectTransM->update();

		}

		return true;


	}


	function version_3588() {

			$mainInstallC = WClass::get( 'main.install' );
			$mainInstallC->insertExtension( 'ticket.emailreplyconvert.mailbox', 'Email Reply Conversion', 'ticket.node' );
			$mainInstallC->insertExtension( 'ticket.ticketbyemail.mailbox', 'Email to ticket conversion', 'ticket.node' );

	}






	public function addExtensions() {

				$extension = new stdClass;
		$extension->namekey = 'ticket.search.plugin';
		$extension->name = "Joobi - Tickets' search";
		$extension->folder = 'search';
		$extension->type = 50;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|ticket|plugin';
		$extension->core = 1;
		$extension->params = 'publish=0';
		$extension->description = '';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );


				$extension = new stdClass;
		$extension->namekey = 'ticket.last.module';
		$extension->name = 'Joobi - Latest Tickets';
		$extension->folder = 'last';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|ticket|module';
		$extension->core = 1;
		$extension->params = 'publish=0';
		$extension->description = '';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );


				$extension = new stdClass;
		$extension->namekey = 'ticket.dashboard.module';
		$extension->name = 'Joobi - Tickets';
		$extension->folder = 'ticket';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|ticket|module';
		$extension->core = 1;
		$extension->params = "position=cpanel\npublish=1\naccess=1\nclient=1\nordering=1";
		$extension->description = '';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );

	}





	private function _insertDefType() {
		$listOfTypeA  = array();
				$typeO = new stdClass;
		$typeO->tktypeid = 110;
		$typeO->name = 'General Inquiries';
		$typeO->description = 'Ticket - General Inquiries';
		$typeO->namekey = 'ticket_inquiries';
		$typeO->type = 3;
		$typeO->publish = 1;
		$typeO->ordering = 1;
		$listOfTypeA[] = $typeO;

		$typeO = new stdClass;
		$typeO->tktypeid = 10;
		$typeO->name = 'Feature Request';
		$typeO->description = 'Ticket - Feature Request';
		$typeO->namekey = 'ticket_feature';
		$typeO->type = 3;
		$typeO->publish = 1;
		$typeO->ordering = 2;
		$listOfTypeA[] = $typeO;

		$typeO = new stdClass;
		$typeO->tktypeid = 100;
		$typeO->name = 'License Issue';
		$typeO->description = 'Ticket - License Issue';
		$typeO->namekey = 'ticket_license';
		$typeO->type = 3;
		$typeO->publish = 1;
		$typeO->ordering = 3;
		$listOfTypeA[] = $typeO;

		$typeO = new stdClass;
		$typeO->tktypeid = 20;
		$typeO->name = 'Bug Report';
		$typeO->description = 'Ticket - Bug Report';
		$typeO->namekey = 'ticket_bug';
		$typeO->type = 3;
		$typeO->publish = 1;
		$typeO->ordering = 4;
		$listOfTypeA[] = $typeO;

		$typeO = new stdClass;
		$typeO->tktypeid = 50;
		$typeO->name = 'Submitted by email';
		$typeO->description = 'Ticket - by email';
		$typeO->namekey = 'ticket_email';
		$typeO->type = 3;
		$typeO->publish = 1;
		$typeO->ordering = 5;
		$listOfTypeA[] = $typeO;

		$useMultipleLang = WPref::load( 'PLIBRARY_NODE_MULTILANG' );
				$lgid = 1;
		if ( $useMultipleLang ) {
						if ( !isset($lgid) ) $lgid = WUser::get( 'lgid' );
			if ( empty($lgid) ) {
				$useMultipleLangENG = WPref::load( 'PLIBRARY_NODE_MULTILANGENG' );
				$lgid = ( $useMultipleLangENG ? 1: WApplication::userLanguage() );
			}
		}
		$prodTypeM = WModel::get( 'ticket.type' );


		foreach( $listOfTypeA as $oneType ) {

			$prodTypeM->setVal( 'tktypeid', $oneType->tktypeid );

			$prodTypeM->setVal( 'alias', $oneType->name );
			$prodTypeM->setVal( 'namekey', $oneType->namekey );
			$prodTypeM->setVal( 'type', $oneType->type );
			$prodTypeM->setVal( 'publish', $oneType->publish );
			$prodTypeM->setVal( 'ordering', $oneType->ordering );
			$prodTypeM->setVal( 'core', 1 );
			$prodTypeM->returnId();
			$prodTypeM->insertIgnore();





			$ticketTypeTansM = WModel::get( 'ticket.typetrans' );
			$ticketTypeTansM->setVal( 'lgid', $lgid );
			$ticketTypeTansM->setVal( 'tktypeid', $oneType->tktypeid );
			$ticketTypeTansM->setVal( 'name', $oneType->name );
			$ticketTypeTansM->setVal( 'description', $oneType->description );
			$ticketTypeTansM->insertIgnore();

		}
		return true;

	}







	private function _rootCategory() {

				$projecttM = WModel::get( 'project' );
		$projecttM->noValidate();
		$projecttM->namekey = 'root';
		$projecttM->setChild( 'projecttrans', 'name', 'Top' ); 		$projecttM->setChild( 'projecttrans', 'description', 'Top: root category, do not remove it!' ); 		$projecttM->setChild( 'projecttrans', 'lgid', 1); 		$projecttM->publish=1;
		$projecttM->lft=1;
		$projecttM->rgt=2;
		$projecttM->parent=0;
		$projecttM->uid=0;
		$projecttM->save();

		return true;
	}


}