<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Currency_CoreXmlformdisp_form extends WForms_default {




function create() {

	static $map=null;

	if (empty($map)) $map = 'url_'. $this->modelID;

	$url = $this->data->$map;



	static $curRateC=null;

	if (empty($curRateC)) $curRateC = WClass::get( 'currency.rate' );

	$html = $curRateC->viewRateHTML($url);



	$this->content = $html;

	return true;

}



}