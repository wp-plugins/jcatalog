<?php 

* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Currency_exchangesite_controller extends WController {




function exchangesite()

{

	WPages::redirect( 'controller=currency-exchangesite&task=listing' );

	return true;

}





}