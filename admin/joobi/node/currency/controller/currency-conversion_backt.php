<?php 

* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Currency_conversion_backt_controller extends WController {




function backt()

{

	$curid = WGlobals::get( 'curid' );

	WPages::redirect( 'controller=currency-conversion&task=listing&curid='. $curid );

	return true;

}









}