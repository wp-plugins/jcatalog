<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Apps_send_controller extends WController {






function send(){



	$trucs=WGlobals::get('trucs');

	$mess=WMessage::get();



	$extension=$trucs['x']['extension'];



	
	if(!isset($extension)){

		$mess->historyE('1213020853MLHQ');

	}





	
	if(isset($trucs['x']['reason'])){
		$typeInquiry=$trucs['x']['reason'];
		switch( $typeInquiry){

			case 10:				
			case 20:				
			case 100:				
			case 110:				
				break;















			default:

				$mess->historyE('1206732398LZJD');

				break;

		}


		$extExp=explode( '_', $extension);

		$extNamekey=$extExp[0];

		$token=isset($extExp[1]) ? $extExp[1] : '';



		$link='http://www.joobi.co/index.php?option=com_jlinks&controller=redirect';

		$link .='&link=newticket'; 
		$link .='&project=' . $extNamekey;

		$link .='&type=' . $typeInquiry;

		$link .='&token=' . $token;

		$link .='&web=' . rtrim( JOOBI_SITE, "/" );  		

		WPages::redirect( $link, false, false );



	}else{

		$mess->historyE('1206732398LZJD');

	}


}

























}