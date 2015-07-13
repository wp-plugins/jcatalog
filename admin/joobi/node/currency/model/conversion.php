<?php 

* @link joobi.co
* @license GNU GPLv3 */







class Currency_Conversion_model extends WModel {


	function validate() {



		if (empty($this->name))

			$this->name=$this->_getCurrencyTitle($this->curid).' => '.$this->_getCurrencyTitle($this->curid_ref);

		if (empty($this->alias))

			$this->alias=$this->_getCurrencyTitle($this->curid).' => '.$this->_getCurrencyTitle($this->curid_ref);



		$this->rate = $this->exchange * ( ( $this->fee + 100 )/100 );




		return true;

	}













	function _getCurrencyTitle($curid) {





		return WModel::getElementData( 'currency', $curid, 'title' );


	}











}