<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Report_type_picklist extends WPicklist {
function create() {



	$this->addElement( 220 , WText::t('1374276934ANBO') );

	$this->addElement( 200 , WText::t('1219769904NDKA') );

	
	
	


	$reportHeaderView = WGlobals::get( 'reportHeaderType', 'report_header', 'global' );

	if ( $reportHeaderView == 'report_header' ) $this->addElement( 240 , WText::t('1206732405TIXB') );



	return true;



}}