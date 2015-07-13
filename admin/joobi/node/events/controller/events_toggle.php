<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Events_toggle_controller extends WController {




function toggle(){





	$eid=WGlobals::getEID();

	$rolid=$this->getToggleValue( 'value' );



	if( empty($eid)) return parent::toggle();	


	$controllerRolesM=WModel::get( 'library.controllerroles' );


	$controllerRolesM->setVal( 'modified', time());

	$controllerRolesM->setVal( 'uid', WUser::get('uid'));

	$controllerRolesM->setVal( 'rolid', $rolid );

	$controllerRolesM->setVal( 'ctrid', $eid );

	$controllerRolesM->insertIgnore();



	if( $controllerRolesM->affectedRows() < 1){

		if($rolid==0)

		{

		$controllerRolesM->whereE( 'ctrid', $eid );

		$controllerRolesM->delete();

		}

		else

		{

		$controllerRolesM->setVal( 'modified', time());

		$controllerRolesM->setVal( 'uid', WUser::get('uid'));

		$controllerRolesM->setVal( 'rolid', $rolid );

		$controllerRolesM->whereE( 'ctrid', $eid );

		$controllerRolesM->update();

		}



	}


	return true;

}
}