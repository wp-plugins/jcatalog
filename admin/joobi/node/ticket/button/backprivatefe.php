<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreBackprivatefe_button extends WButtons_external {




function create() {



	$this->setAddress( WPage::routeURL('controller=ticket-my') );



	$myText = WText::t('1206961882TDHA');



	$this->setTitle($myText);

	$this->setIcon('back');



}}