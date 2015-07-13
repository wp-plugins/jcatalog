<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Events_override_controller extends WController {
	

	

	
	

	function override(){

		$override=WGlobals::get('override');		
		$ctrid=WGlobals::get('eid');		
		

		$controllerRoles=WModel::get('library.controllerroles');	
			

		switch ( $override){	
	

			case '1':	
				$controllerRoles->whereE('ctrid', $ctrid);

				$controllerRoles->setVal('override', 5);

				$controllerRoles->update();

				break;

	

			case '5':	
				$controllerRoles->whereE('ctrid', $ctrid);

				$controllerRoles->setVal('override', 9);

				$controllerRoles->update();

				break;

	

			case '9':	
				$controllerRoles->whereE('ctrid', $ctrid);

				$controllerRoles->setVal('override', 1);

				$controllerRoles->update();

				break;

				

	

			default:

				break;		

		}
			

		WPages::redirect('controller=events');

		

		return true;

	}
	
}