<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_module_directtranslate_controller extends WController {








	function directtranslate() {



		$directEdit = WPref::load( 'PMAIN_NODE_DIRECT_TRANSLATE' );

		$pref = WPref::get( 'library.node' );

		$pref->updatePref( 'direct_translate', (int)!$directEdit );

		WPages::redirect('previous');



		return true;



	}
}