<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_CoreHeader_listing extends WListings_default{








function create() {



	
	$score = $this->getValue('score');			
	$title = $this->getValue('name');



	static $rateC = null;

	
	$titleLen=strlen($title);

	
	if ($titleLen > 50) {

		$title = substr($title,0,30);

		$title = $title.'...';

	}


	
	$title=ucfirst($title);



	if (empty($cmtRatingC)) $cmtRatingC = WClass::get('comment.rating');	

	$header = '<div class="reviewRating">'.$cmtRatingC->getHtmlRating($score).'<span class="reviewRating">'.$title. '</span></div>';



	$this->content = $header;



	return true;

}}