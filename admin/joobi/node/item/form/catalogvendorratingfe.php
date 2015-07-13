<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreCatalogvendorratingfe_form extends WForms_default {





function show() {

	    $vendid = $this->getValue( 'vendid' );

		if ( empty( $vendid ) ) return false;

		$vote = $this->getValue( 'votes', 'vendor' );
	$rating = $this->getValue( 'score', 'vendor' );
	$nbreviews = $this->getValue( 'nbreviews', 'vendor' );

        if ( $rating > 0 ) $rating = ( $rating / $vote );

    $starColor = 'yellow';

	    static $rateClass=null;
    if ( empty($rateClass) ) $rateClass= WClass::get('output.rating');

        $rateC = $rateClass;
    $rateC->primaryId = $vendid;
    $rateC->restriction = 1;
    $rateC->colorPref = $starColor;
    $rateC->rating = $rating;
   	$rateC->option = 0;
    $rateC->type = 0;

				$nbreviews = !empty( $nbreviews ) ? $nbreviews : 0;
	$commentHTML = ' <span class="badge">'. $nbreviews . '</span> ';	
		$returnId = WView::getURI();				$realVal = base64_encode($returnId);		$option	= WGlobals::getApp();			$vendorURL = 'controller=vendors&task=home&eid='. $vendid;
	$route = WPage::link( $vendorURL ) . '#comment';

        $display = null;
    $display .= $rateC->createHTMLRating( $this );	    $display .= '<a href="'.$route.'">';
    $display .= $commentHTML;
    $display .= '</a>';

    $this->content = $display;
	return true;
}
}
