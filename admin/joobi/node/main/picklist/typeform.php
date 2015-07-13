<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Typeform_picklist extends WPicklist {

	function create() {



	
	
		$this->addElement( '-no-type-select-', ' - ' .  WText::t('1360922680DLQR') . ' - ' );



		$this->addElement( 'output.tab', WText::t('1358294811IVXF') );

		$this->addElement( 'output.fieldset', WText::t('1395500511PPJW') );

		$this->addElement( 'output.slider', WText::t('1395500511PPJX') );
		$this->addElement( 'main.widgetbox', WText::t('1359165829EPZO') );

		$this->addElement( 'output.column', WText::t('1358294811IVXH') );

		$this->addElement( 'output.row', WText::t('1358294811IVXI') );

		$this->addElement( 'output.div', WText::t('1358294811IVXK') );



		return true;



	}
}