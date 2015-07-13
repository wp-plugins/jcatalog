<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_CoreCategory_listing extends WListings_default{








function create(){

	$typeV = $this->getValue('type');		
	$tkid = $this->getValue('tkid');

	$name = null;


	if ($typeV == '80'){			
		if (WGlobals::checkCandy(25)){

			$type = $this->getValue('commenttype');

			switch ($type){

				case '10':																	$option = WGlobals::getApp();
					if ( !empty($option) ) $option = substr( $option, 4 );

										if ( empty($option) ) $option = 'jstore';


					$prodId = $this->getValue('pid');			
					$catId = $this->getValue('catid');		
					$prodIDM = WModel::getID('product');

					$tempProdName = 'namekey_'.$prodIDM;

					$name = $this->data->$tempProdName;			
					$link = WPage::routeURL('controller=catalog&task=show&eid='.$prodId.'&catid='.$catId.'#'.$tkid,'home', false, false, true,$option);	
					$name = 'Alias: <a href ='.$link.' target=_blank>'.$name.'</a>';

					break;

				 case '20':					
				 	if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return false;

				 	$articleId = $this->getValue('id');						 	$alias = $this->getValue('alias');
				 	$catMID = WModel::getID('joomla.content');
				 	$tempCatId = 'catid_'.$catMID;
				 	$catid = $this->data->$tempCatId;
				 	$link = WPage::routeURL('view=article&id='.$articleId.'&catid='.$catid.'#'.$tkid,'home',false, false,false,'content','content');				 			$name = 'Alias: <a href ='.$link.' target=_blank>'.$alias.'</a>';

			}
		} else {

			return true;

		}
	} else {

		$name = 'Category: '.$this->value;

	}


	$this->content = $name;



	return true;

}}