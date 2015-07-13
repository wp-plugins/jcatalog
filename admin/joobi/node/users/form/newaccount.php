<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_Newaccount_form extends WForms_default {
function create(){



	$objButtonO=WPage::newBluePrint( 'button' );

	$objButtonO->text=$this->element->name;

	$objButtonO->color='success';

	$objButtonO->icon='fa-user';

	$objButtonO->link=WPage::routeURL('controller=users&task=register' );

	$this->content=WPage::renderBluePrint( 'button', $objButtonO );





	return true;



}}