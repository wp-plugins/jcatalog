<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');








class Ticket_saveprefplus_controller extends WController {


	function saveprefplus() {


		parent::savepref();


		$trucs = WGlobals::get( 'trucs' );			
		$tkvar= $trucs['c'][ 'ticket.node' ];			


		if ( WGlobals::checkCandy(50) && isset( $tkvar[ 'tkproject' ] ) ) {



			








			
			if ( $tkvar[ 'tkproject' ] != $ctkproject ) {

				$project = WClass::get( 'ticket.project' );

				if ( $tkvar[ 'tkproject' ]==1 ) $project->jProjectManagement();	
				else $project->jProjectManagement( false );			
			}


			
			if ( $tkvar[ 'tkrt' ] != $ctkrt ) {

				$resptime = WClass::get( 'ticket.resptime' );

				$resptime->switchResptime( $tkvar[ 'tkrt' ] );

			}
		}


		if ( WGlobals::checkCandy(25) ) {

			$frequency = $tkvar[ 'tkfrequency' ];



			if ( $frequency != WPref::load('PTICKET_NODE_TKFREQUENCY' ) ) {

				$schedulerM=WModel::get( 'scheduler' );

				$schedulerM->setVal( 'frequency', $frequency*3600 );

				$schedulerM->whereE( 'namekey', 'ticketwarning' );

				$schedulerM->update();

			}

			
			if ( WGlobals::checkCandy(50) ) {

				if ($tkvar['tktype']) {

					
					$udropsetM = WModel::get('library.picklist');

					$udropsetM->whereE('namekey', 'ticket-all-type');

					$udropsetM->setVal('publish', 0);

					$udropsetM->update();

				} else {

					$udropsetM = WModel::get('library.picklist');

					$udropsetM->whereE('namekey', 'ticket-all-type');

					$udropsetM->setVal('publish', 1);

					$udropsetM->update();

				}

				
				if ( $tkvar[ 'followupticket' ]) {

					$filtersM = WModel::get( 'library.viewfilters' );

					$filtersM->whereE( 'namekey', 'tickets_myassigned_assignbyuid' );

					$publish = $filtersM->load( 'lr', 'publish' );

					if (!$publish) {

						$filtersM->whereE( 'namekey', 'tickets_myassigned_assignbyuid' );

						$filtersM->setVal('publish', 1);

						$filtersM->update();



						$filtersM->whereE( 'namekey', 'tickets_myassigned_assignuid' );

						$filtersM->setVal( 'bktafter', 0 );

						$filtersM->update();

					}
				} else {

					$filtersM = WModel::get( 'library.viewfilters' );

					$filtersM->whereE( 'namekey', 'tickets_myassigned_assignbyuid' );

					$publish = $filtersM->load( 'lr', 'publish');

					if ($publish) {

						$filtersM = WModel::get( 'library.viewfilters' );

						$filtersM->whereE( 'namekey', 'tickets_myassigned_assignbyuid' );

						$publish = $filtersM->load( 'lr', 'publish' );

						if ($publish) {

							$filtersM->whereE( 'namekey', 'tickets_myassigned_assignbyuid' );

							$filtersM->setVal( 'publish', 0 );

							$filtersM->update();



							$filtersM->whereE( 'namekey', 'tickets_myassigned_assignuid' );

							$filtersM->setVal( 'bktafter', 1 );

							$filtersM->update();

						}
					}
				}

				if ( !empty( $tkvar['tkusecomment'] ) ) {

					
					
										
					if ( !defined( 'PTICKET_NODE_TKPROJCOMMENT' ) && empty( $tkvar[ 'tkprojcomment' ] ) ) {			
							$projectM=WModel::get( 'ticket.project' );			
							$author = WUser::get( 'uid' );

							$projectM->namekey = 'Comments';

							$projectM->modified = time();

							$projectM->created = time();

							$projectM->publish =1;

							$projectM->rolid = 7;

							$projectM->parent = 1;

							$projectM->uid = $author;

							$projectM->frontend =1;

							$projectM->returnId();

							$projectM->save();



							
							$pjid = $projectM->pjid;

							$projectTransM=WModel::get( 'ticket.projecttrans' );		
							$projectTransM->setVal( 'pjid', $pjid );

							$projectTransM->setVal( 'name', 'Comments' );

							$projectTransM->setVal( 'lgid', 1 );

							$projectTransM->insert();



							
							$wid = $this->wid;				







						}
				}
			}
		}

	
	}
}