<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Theme_canceledit_controller extends WController {
function canceledit(){



	$eid=WGlobals::getEID( false );

	WPages::redirect( 'controller=theme&task=show&eid='.$eid );



	return true;



}}