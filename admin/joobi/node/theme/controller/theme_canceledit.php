<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Theme_canceledit_controller extends WController {
function canceledit(){



	$eid=WGlobals::getEID( false );

	WPages::redirect( 'controller=theme&task=show&eid='.$eid );



	return true;



}}