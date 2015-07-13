<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');













class WPane_nopane extends WPane {



	





	function miseEnPageTwo(&$params,$value) {

		$this->content = $value;

		return $value;

	}


	function body() {

	}


	function cell($value,$notUsed=null) {

		$this->content .= $value;

		return $value;

	}


	function line() {

	}










	public function startPane($params) {



	}








	public function endPane() {

	}










	public function startPage($params) {



	}








	public function endPage() {



	}


}


