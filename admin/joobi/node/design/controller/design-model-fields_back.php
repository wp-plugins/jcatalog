<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Design_model_fields_back_controller extends WController {
function back() {



WPages::redirect( 'controller=design-model-fields' );



return true;

}
}