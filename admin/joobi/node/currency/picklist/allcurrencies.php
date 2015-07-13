<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Currency_Allcurrencies_picklist extends WPicklist {


	function create() {



		static $model=null;

		if (empty($model)) $model=WModel::get( 'currency');

		$model->select(array('curid','title','publish'));

		$model->orderBy('publish','DESC','1');

		$model->orderBy('title','ASC','2');

		$list=$model->load('ol');



		if (empty($list)){ return; }



		foreach($list as $elem)  {

			$name=$elem->title;



			if ($elem->publish=='0') $name.=' ('.WText::t('1227580958QHGM').')';



			$this->addElement($elem->curid,$name);

		}
		

		return true;

   }















}