<?php 

* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Currency_exchangesite_back_controller extends WController {


function back(){

	WPages::redirect( 'controller=currency&task=listing' );

	return true;

}





}