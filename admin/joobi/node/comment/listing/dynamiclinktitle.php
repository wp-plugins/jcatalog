<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_CoreDynamiclinktitle_listing extends WListings_default{


function textLink() {

	$this->_createLink();

	return WText::t('1327592640PUQE');

}










private function _createLink() {



	$link = null;

	$type = $this->getValue('commenttype');		
	$commentID = $this->getValue('tkid');



	$anchor = '#comment';






	
	switch ($type) {

		case '10': 					
		case '1':

		case '5':

		case '11':

		case '100':

		case '141':

			$etid = $this->getValue('etid');

			$link = WPage::routeURL('controller=catalog&task=show&eid='.$etid . $anchor, 'home', 'popup' );	
		 	break;



		 case '20':					
		 	if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return false;



		 	$articleId = $this->getValue('id');		
		 	$catMID = WModel::getID('joomla.content');

		 	$tempCatId = 'catid_'.$catMID;

		 	$catid = $this->data->$tempCatId;

		 	$link = WPage::routeURL('view=article&id='.$articleId.'&catid='.$catid . URL_NO_FRAMEWORK . $anchor,'home',false, false,false,'content','content');		
		 	$title = $this->getValue('alias');

			break;



		 case '30':					
		 	$vendorID = $this->getValue('etid');

		 	$vendorC = WClass::get('vendor.helper',null,'class',false);

		 	$vendorInfo = $vendorC->getVendor($vendorID);



		 	$link = WPage::routeURL('controller=vendors&task=home&eid='.$vendorID . $anchor, 'home', 'popup' );



		 	$title = empty($vendorInfo->name) ?  '' : $vendorInfo->name;

		 	break;

		 default:

		 	break;

	}


	$this->element->lien = $link;

	
	$this->element->dontConvertLien = true;

	return true;

}}