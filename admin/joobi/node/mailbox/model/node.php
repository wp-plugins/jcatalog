<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Mailbox_Node_model extends WModel {
function validate() {



	$this->server = trim( $this->server );

	$this->username = trim( $this->username );

	$this->password = trim( $this->password );





	return true;

	

}}