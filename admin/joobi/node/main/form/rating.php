<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WForm_Corerating extends WForms_default {

	function __construct()	{
		static $ratingC=null;
		if ( !isset($ratingC) ) $ratingC = WClass::get('output.rating');
		$this->_ratingC = $ratingC;
	}
	


	function create() {

		if ( isset($this->rating->rating) ) {
			$this->_ratingC->rating = $this->rating->rating;
		} else {
			$score = $this->getValue( 'score' );
			$votes = $this->getValue( 'votes' );

			if ( !empty($votes) ) $this->_ratingC->rating = $score / $votes;
			else $this->_ratingC->rating = 0;
		}
		$this->_ratingC->restriction = ( ( isset($this->rating->restriction) ) ) ? ( !isset($this->rating->restriction) ) : 1;
		if ( isset($this->rating->colorPref) ) {
			$this->_ratingC->colorPref = $this->rating->colorPref;
		} else {
		}
		$this->_ratingC->rateController = ( ( isset($this->rating->rateController) ) ) ? ( !isset($this->rating->rateController) ) : $this->controller->controller;
		if ( !isset($this->_ratingC->type) ){
			$this->_ratingC->type = ( ( isset($this->rating->type) ) ) ? ( !isset($this->rating->type) ) : 1;
		}		$this->_ratingC->primaryId = ( ( isset($this->rating->primaryId) ) ) ? ( !isset($this->rating->primaryId) ) : WGlobals::getEID();

		$this->_ratingC->map = ( ( isset($this->rating->map) ) ) ? ( !isset($this->rating->map) ) : $this->element->map;

		WText::load( 'main.node' );
				$this->content = '<div style="float:left;">' . $this->_ratingC->createHTMLRating( $this ) . '</div>&nbsp;<span id=jratingstarqer style="color:red;font-weight:bold;display:none;"> '.WText::t('1303355093GUFG').'</span>';

	return true;
	}
	

	function show() {
		$this->_ratingC->type = ( ( isset($this->rating->type) ) ) ? ( !isset($this->rating->type) ) : 0;
	return $this->create();
		}




}



