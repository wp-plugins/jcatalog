<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Files_Amazon_picklist extends WPicklist {
function create() {



	$this->addElement( 'standard', WText::t('1206732405TIXC') );

	$this->addElement( 'reduced', WText::t('1349726929FOOL') );

	

	

	return true;



}}