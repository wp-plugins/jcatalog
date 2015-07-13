<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WListing_Corerating extends WListings_default{

	function create() {
		static $ratingC=null;

		if ( !isset($ratingC) ) $ratingC = WClass::get('output.rating');
		$this->_ratingC = $ratingC;

		if ( isset($this->rating->rating) ) {
			$this->_ratingC->rating = $this->rating->rating;
		} else {
			$score = $this->getValue( 'score' );
			$votes = $this->getValue( 'votes' );
						if ( empty($votes) ) $votes =1;

			if ( !empty($votes) ) $this->_ratingC->rating = $score / $votes;
			else $this->_ratingC->rating = 0;
		}

		$this->_ratingC->restriction = ( ( isset($this->rating->restriction) ) ) ? ( !isset($this->rating->restriction) ) : 1;
		if ( isset($this->rating->colorPref) ) {
			$this->_ratingC->colorPref = $this->rating->colorPref;
		} else {
		}		$this->_ratingC->rateController = ( ( isset($this->rating->rateController) ) ) ? ( !isset($this->rating->rateController) ) : '';
		$this->_ratingC->type = ( ( isset($this->rating->type) ) ) ? ( !isset($this->rating->type) ) : 0;

				$this->content = '<div style="width:75px;">'.$this->_ratingC->createHTMLRating($this).'</div>';

		return true;

	}

}



