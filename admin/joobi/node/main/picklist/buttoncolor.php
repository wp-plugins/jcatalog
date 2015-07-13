<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Buttoncolor_picklist extends WPicklist {


	function create() {



		
		$this->addElement( '', WText::t('1206732425HINT') );

		$this->addElement( 'default', WText::t('1242282444LHMZ') );

		$this->addElement( 'primary', WText::t('1242282444LHMX') );

		$this->addElement( 'success', WText::t('1242282417SQNH') );

		$this->addElement( 'info', WText::t('1393290131DEFB') );

		$this->addElement( 'warning', WText::t('1242282444LHNB') );

		$this->addElement( 'danger', WText::t('1242282444LHMY') );

		$this->addElement( 'link', WText::t('1206732410ICCJ') );



		return true;



	}}