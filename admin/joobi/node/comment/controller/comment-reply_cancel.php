<?php 

* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Comment_reply_cancel_controller extends WController {












function cancel(){



	WPages::redirect('controller=comment');

	return true;

}}