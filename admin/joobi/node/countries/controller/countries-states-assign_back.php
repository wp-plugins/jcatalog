<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Countries_states_assign_back_controller extends WController {




function back() {

	WPages::redirect( 'controller=countries' );

	return true;

}}