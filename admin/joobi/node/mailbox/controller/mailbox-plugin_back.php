<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Mailbox_plugin_back_controller extends WController {








function back() {

	WPages::redirect('controller=mailbox'); 
  return true;

}}