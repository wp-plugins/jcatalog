<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Vendor_cancel_controller extends WController {
function cancel() {



WPages::redirect( 'controller=order-members' );

return true;

}}