<?php 

* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');











class Api_Wp4_Controller_class extends WClasses {













	public function wpRun($identifer){



		$content=JoobiWP::slugToApp( $identifer );



		echo $content;



	}


}