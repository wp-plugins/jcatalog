<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Comment_rate_controller extends WController {




function rate(){



	$x = WGlobals::get('starRate');

	$score = WGlobals::get('score');			


	if (empty($score)){						
		WPages::redirect('controller=comment&task=add&score='. $x );

	}


	return true;



}}