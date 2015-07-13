<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_Rating_class extends WClasses {
















function updateRating($obj) {

	
	
	switch ( $obj->commenttype ) {


		case 20:

			if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return true;


			$nodeM = WModel::get('role.content');

			if ( !empty($nodeM) ) {

				$nodeM->whereE('id',$obj->etid);

				$article = $nodeM->load( 'lr','id');			
				if ( empty($article) ) {			
				        $nodeM->setVal( 'id', $obj->etid );		
	               			$nodeM->setVal( 'comment', 0 );

	               			$nodeM->setVal('rolid',1);

	               			if ($obj->score > 1) {

	               				$nodeM->updatePlus('rating_num',1);

	               				$nodeM->updatePlus('rating_sum',$obj->score);

	               			}	               			$nodeM->insert();

	                	} else {						
					if ($obj->score > 0 ) {

						$nodeM->whereE('id',$obj->etid);

						$nodeM->updatePlus('rating_num',1);

						$nodeM->updatePlus('rating_sum',$obj->score);


						$nodeM->update();

					}
				}
			}
			break;


		case 30:
			$vendorM = WModel::get( 'vendor' );
			if ( !empty($vendorM) && $obj->score > 0 ) {						$vendorM->whereE('vendid',$obj->etid);
				$vendorM->updatePlus('nbreviews',1);							$vendorM->updatePlus('votes',1);
				$vendorM->updatePlus('score',$obj->score);							$vendorM->update();
			}			break;
		default:
			$ItemType = array( 10, 1, 5, 11, 100, 141 );
			if ( in_array( $obj->commenttype, $ItemType ) ) {
				$productM = WModel::get('item');
				if ( !empty($productM) && $obj->score > 0 ) {							$productM->whereE( 'pid', $obj->etid );
					$productM->updatePlus( 'nbreviews',1 );								$productM->updatePlus( 'votes',1 );
					$productM->updatePlus( 'score', $obj->score );								$productM->update();
				}
			}
			break;

			break;
	}
	return true;

}






 function getHtmlRating($score){
 	$htmlRating = null;

	if (!isset($rateC))	$rateC= WClass::get('output.rating');				$this->_ratingC = $rateC;
	$this->_ratingC->restriction = 1;

	$this->_ratingC->rating			=	$score;
	$this->_ratingC->rateController	= 	'';
	$this->_ratingC->option			=	0;
	$this->_ratingC->type			=	0;
 	$htmlRating = $this->_ratingC->createHTMLRating($this);
 	return $htmlRating;
 }}