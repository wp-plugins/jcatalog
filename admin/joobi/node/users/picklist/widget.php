<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Users_Widget_picklist extends WPicklist {
function create(){



	$this->addElement( 'name', WText::t('1206732392OZVB'));

	$this->addElement( 'firstname', WText::t('1206732412DABT'));

	$this->addElement( 'lastname', WText::t('1206732412DABX'));

	$this->addElement( 'username', WText::t('1206732411EGRV'));
	$this->addElement( 'email', WText::t('1206961899DDKP'));


	return true;



}}