<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Mailbox_CoreEditparams_listing extends WListings_default{


function create() {









	if ( 'newzletter.newzletterbounce.mailbox' != $this->getValue( 'namekey' ) ) return true;



	$this->content = '<a href="'.WPage::routeURL('controller=mailbox-email&task=pref&wid='.$this->value).'">';


	$this->content .= WView::getLegend( 'preferences', WText::t('1236791959FTZU'), 'standard' );
	$this->content .= '</a>';



	return true;

}}