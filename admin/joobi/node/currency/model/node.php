<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Currency_Node_model extends WModel {










function validate() {

	$ca = WModel::get( 'currency');

	$ca->whereE('publish', 1);

	$rez = $ca->load('o', 'curid');

	if (empty ($rez)) {

		$message = WMessage::get();

		$this->publish = 1;

		$title = $this->title;

		$message->userW('1227580958QHGL',array('$title'=>$title));

	}



		$this->core = 0;






	return true;

	

}}