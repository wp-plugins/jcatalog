<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Date_class extends WClasses {







    public function countDown($time,$precisonOfCountDown=2) {


    	
		$countDownO = WPage::newBluePrint( 'countdown' );
		$countDownO->type = 'standard';
		$countDownO->time = $time;
		$countDownO->precision = $precisonOfCountDown;


		$countDownO->years   = WText::t('1343426232QZMH');
		$countDownO->months  = WText::t('1343426232QZMG');
		$countDownO->days    = WText::t('1206961954EAMZ');
		$countDownO->hours   = WText::t('1215507788CYDF');
		$countDownO->minutes = WText::t('1360366414NJAI');
		$countDownO->seconds = WText::t('1360366414NJAJ');
		$countDownO->stop = WText::t('1360366414NJAK');


		return WPage::renderBluePrint( 'countdown', $countDownO );


    }

}