<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Daterange_picklist extends WPicklist {
function create() {



	
	$trucs = WGlobals::get('trucs');

	$currentPresetDate = (!empty( $trucs['x']['presetdate'] ) ? $trucs['x']['presetdate'] : WGlobals::get('presetdate') );

	if ( empty($currentPresetDate) ) $currentPresetDate = WGlobals::getSession( 'graphFilters', 'presetdate' );

	if ( !empty($currentPresetDate) ) $this->setDefault( $currentPresetDate, true );





	$this->addElement( 2 , WText::t('1242282415NZVT') );

	$this->addElement( 4 , WText::t('1259308004LCOJ') );

	$this->addElement( 6 , WText::t('1337266385HCKZ') );

	$this->addElement( 12 , WText::t('1256627134RCAX') );

	$this->addElement( 24 , WText::t('1256627134RCAY') );

	$this->addElement( 30 , WText::t('1256627135RQMP') );

	$this->addElement( 36 , WText::t('1256627135RQMQ') );

	$this->addElement( 42 , WText::t('1256627135RQMR') );

	$this->addElement( 48 , WText::t('1256627135RQMS') );

	$this->addElement( 51 , WText::t('1377546988CHLS') );
	$this->addElement( 53 , WText::t('1377546988CHLT') );
	$this->addElement( 54 , WText::t('1373935459SQDD') ); 







	return true;



}}