<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreRating_form extends WForms_default {





	function show() {


			    $comment = $this->getValue( 'pageprdallowreview' );

				if ( !empty( $comment ) ) {   
			$starColor = 'yellow';

						$pid = WGlobals::getEID();   
						$vote = $this->getValue( 'votes', $this->modelID );
			$score = $this->getValue( 'score', $this->modelID );
			$nbreviews = $this->getValue( 'nbreviews', $this->modelID );

		    		    if ( $score != 0 && $score != 0 ) $rating = ( $score / $vote );
			else $rating = 0;

				    	$outputRatingC= WClass::get('output.rating');

	        	     	$outputRatingC->primaryId = $pid;
	        $outputRatingC->restriction = 1;
	    	$outputRatingC->colorPref = $starColor;
	     	$outputRatingC->rating = $rating;
	     	$outputRatingC->option = 0;
	     	$outputRatingC->type = 0;


												if ( !empty( $nbreviews ) ) {
				$reviewsText = ( empty($nbreviews) ||  $nbreviews == 1 ) ? WText::t('1304253943KWEJ') : WText::t('1257243218GPNH');
				$commentHTML = ' <span class="badge">'. $nbreviews . '</span> ' . $reviewsText;
			} else $commentHTML = '';	
			
			
			$route = '#comment';

			$form = null;
					     $this->content = $outputRatingC->createHTMLRating( $form, true );

	     	$this->content.= '<a href="'.$route.'">';
	     	$this->content.= $commentHTML;
	     	$this->content.= '</a>';

		    return true;
	    } else return false;

	}

}