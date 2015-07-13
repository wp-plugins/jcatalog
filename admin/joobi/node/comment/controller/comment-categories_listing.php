<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_categories_listing_controller extends WController {
function listing() {



	if ( JOOBI_FRAMEWORK =='joomla16' || JOOBI_FRAMEWORK =='joomla30' ) $this->setView('comment_restrict_category_j16');

	else $this->setView('comment_restrict_category_j15');

	return true;



}}