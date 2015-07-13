<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_CorePrivate_listing extends WListings_default{






function create() {

	$private = $this->getValue( 'private' );	

	if ($private )

	        $this->content='<span style="color:green;">'. WText::t('1206732372QTKI').'</span>';

	else

	        $this->content='<span style="color:red; ">'. WText::t('1206732372QTKJ').'</span>';

	return true;

}}