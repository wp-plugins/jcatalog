<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Comment_categories_listing_controller extends WController {
function listing() {



	if ( JOOBI_FRAMEWORK =='joomla16' || JOOBI_FRAMEWORK =='joomla30' ) $this->setView('comment_restrict_category_j16');

	else $this->setView('comment_restrict_category_j15');

	return true;



}}