<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Catalog_Sortingpresentation_picklist extends WPicklist {
function create() { 
	
	$this->addElement( 'picklist', WText::t('1219769913SSOH') );
	$this->addElement( 'tab', WText::t('1308888990BUDU') );
	
	return true;
	 
}}