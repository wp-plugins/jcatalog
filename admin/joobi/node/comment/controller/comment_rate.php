<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Comment_rate_controller extends WController {




function rate(){



	$x = WGlobals::get('starRate');

	$score = WGlobals::get('score');			


	if (empty($score)){						
		WPages::redirect('controller=comment&task=add&score='. $x );

	}


	return true;



}}