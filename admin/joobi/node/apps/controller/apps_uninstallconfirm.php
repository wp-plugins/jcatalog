<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Apps_uninstallconfirm_controller extends WController {
function uninstallconfirm(){



	$uninstall_choice=WController::getFormValue( 'uninstall_choice' );

	$eid=WController::getFormValue( 'eid' );



	$appsUninstallC=WClass::get( 'apps.uninstall' );

	$appsUninstallC->uninstallApps( $eid, $uninstall_choice );

	

	return true;



}}