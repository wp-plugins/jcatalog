<?php 

* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_Moderatorsrolid_filter {








function create(){

	$rolid = '';

	$namekey = array( 'author', 'manager', 'admin', 'sadmin', 'supportmanager', 'agent', 'moderator' );

	$membersM = WModel::get('role');

	$membersM->whereIn('namekey',$namekey);
	$membersM->setLimit( 10000 );
	$rolid = $membersM->load('lra', 'rolid');

	

	return $rolid;

}}