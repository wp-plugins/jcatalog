<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_Commenttype_class extends WClasses {












function commentType($commenttype) {




	if (!empty($commenttype)) {

		switch ($commenttype) {

			case 10 :

				$comName='product';		
				break;

			case 30 :

				$comName='vendors-profile';

				break;

			case 20 :

			default:

				$comName='content';		
				break;

		}
	}


	return $comName;

}












function comValue($option) {

	$comVal = WGlobals::get( 'sharedItemType', 0, 'global' );
	if ( !empty($comVal) ) return $comVal;




	
	if (!empty($option)) {

		switch ($option) {

			case 'vendors-profile' :	
				$comVal=30;

				break;

			case 'com_jtickets' :

			case 'com_content' :		
				$comVal=20;
				break;
			case 'com_jstore' :					case 'com_jmarket':
			case 'com_jauction':
			case 'com_jcatalog':
			case 'com_jsubscription':
			default:
				$comVal=10;
				break;
		}
	} else {
		$comVal = 20;
	}


	return $comVal;


}










function optionCom($commenttype) {




	if (!empty($commenttype)) {

		switch ($commenttype) {



			case 'com_jstore' :

			case 'com_jmarket':

				$comName='product';		
				break;

			case 'vendors-profile' :

				$comName='vendors-profile';

				break;



			case 'com_jtickets' :

				$comName='';



			case 'com_content' :		
			default:

				$comName='content';

				break;



		}
	return $comName;

	}
}}