<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_cancel_controller extends WController {
function cancel() {



WPages::redirect( 'controller=order-members' );

return true;

}}