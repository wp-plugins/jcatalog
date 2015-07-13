<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Mailbox_plugin_back_controller extends WController {








function back() {

	WPages::redirect('controller=mailbox'); 
  return true;

}}