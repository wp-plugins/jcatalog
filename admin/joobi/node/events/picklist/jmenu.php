<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















 class Events_Jmenu_picklist extends WPicklist{





	function create(){

		if( JOOBI_FRAMEWORK_TYPE !='joomla' ) return false;

		$model=WTable::get( '#__menu_types','','id');
		$model->select( array('title', 'menutype'));
		$model->orderBy('title','ASC');
		$categories=$model->load('ol');

		if( empty($categories)) return false;


		$this->addElement( '0', WText::t('1206732410ICCJ'));
		foreach($categories as $key=> $category)  {
			$type=$category->menutype;
						$this->addElement( $category->menutype, $category->title );
		}   } }


