<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_Designation_picklist extends WPicklist {

	function create() {





		if ( $this->onlyOneValue() ) {



			if ($this->defaultValue == 3 ) $this->addElement( 3, WText::t('1206964391FHVU') );

			if ($this->defaultValue == 19 ) $this->addElement( 19, WText::t('1234467597SEXU') );

			if ($this->defaultValue == 23 ) $this->addElement( 23, WText::t('1213200727TEHS') );

			if ($this->defaultValue == 43 ) $this->addElement( 43, WText::t('1304525968YBL') );

			if ($this->defaultValue == 63 ) $this->addElement( 63, WText::t('1361919649HLBV') );

			return true;

		}


		$this->addElement( 3, WText::t('1206964391FHVU') );

		$this->addElement( 19, WText::t('1234467597SEXU') );

		$this->addElement( 23, WText::t('1213200727TEHS') );

		$this->addElement( 43, WText::t('1304525968YBL') );

		$this->addElement( 63, WText::t('1361919649HLBV') );



		return true;



	}
}