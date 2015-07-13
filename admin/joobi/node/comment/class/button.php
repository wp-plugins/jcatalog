<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Comment_Button_class extends WClasses {









function getTitle($total=0,$type='comment') {

	$html = '<h3 id="commentHeader">';

	if ( $total < 2 ) {
	 	$text = ( $type=='comment' ) ? WText::t('1219769904NDHD') : WText::t('1304253943KWEJ');
	} else {
	 	$text = ( $type=='comment' ) ? WText::t('1206961912MJQH') : WText::t('1257243218GPNH');
	}
	if ( empty($total) ) $html .= $text;
	else $html .= $text.' <span class="badge">'.$total.'</span>';

	$html .= '</h3>';

	return $html;

}







public function addComment($messageType='',$textType='comment') {

	WPage::addJSFile( 'node/comment/js/compile.js' );

 	WText::load( 'comment.node' );

	$eid = WGlobals::getEID();
	$uri = WView::getURI();
	$baseURI = base64_encode($uri);

	$comVal = WGlobals::get( 'sharedItemType', 0, 'global' );


	$commentRegistere = WPref::load( 'PCOMMENT_NODE_CMTNONORREG' );
	$commentOnReg = ( $commentRegistere ) ? $commentRegistere : WUser::isRegistered();

	if ( empty($commentOnReg) ) {
		if ( $textType=='review' ) {
			$text = WText::t('1344536624AUFN');
		} else {
			$text = WText::t('1344536624AUFO');
		}
	} else {

		if ( strtolower($messageType) == 'first' ) {

			if ( $textType=='review' ) {
				$text = WText::t('1303972032APHM');
			} else {
				$text = WText::t('1307673208ILBE');
			}
	 					$content = '<div class="mainContent"><table class="style"><tbody></tbody></table></div>';
		} else {
			if ( $textType=='review' ) {
				$text = WText::t('1307673208ILBF');
			} else {
				$text = WText::t('1306763027PHWE');
			}		}	}


	if ( empty($comVal) ) {
		$option = WGlobals::getApp();
		$controller = WGlobals::get('controller');
		$task = WGlobals::get('task');

		if ( 'vendors' == $controller && 'home' == $task ) $type = 'vendors-profile';
		else $type = $option;

		static $commentC = null;
		if ( !isset($commentC ) ) $commentC = WClass::get( 'comment.commenttype' );
		$comVal = $commentC->comValue( $type );

	}

	$hasPopUp = true;
	if ( empty($commentOnReg) ) {
		$link = 'controller=users&task=login';
		$hasPopUp = false;
	} else {
		$link = 'controller=comment&task=add&commenttype=' . $comVal . '&etid=' . $eid . '&returnid=' . $baseURI;
	}
	$showComment = WPref::load( 'PVENDOR_NODE_ONLYCUSTOMERS' );
	if ( WUser::isRegistered() ) {
				if ( in_array( $comVal, array( 10, 30 ) ) ) {
			$vendorREviewsC = WClass::get( 'vendor.reviews' );
		 	$allowReview = $vendorREviewsC->reviewAllowed();
		 	if ( !$allowReview ) {

		 		$text = WText::t('1418689659NRQX');
		 		$link = '';
		 	}		}	} elseif ( $showComment ) {
				$link = 'controller=users&task=login';
		$hasPopUp = false;

		if ( $textType=='review' ) {
			$text = WText::t('1344536624AUFN');
		} else {
			$text = WText::t('1344536624AUFO');
		}
	}
	if ( !empty($link) ) {
		if ( $hasPopUp ) {
			$link = WPage::routeURL( $link, '', 'popup', false, false, JOOBI_MAIN_APP );
		} else {
			$link = WPage::link( $link, '', 'home', false, false, JOOBI_MAIN_APP );
		}	}
	$objButtonO = WPage::newBluePrint( 'button' );
	$objButtonO->type = 'standard-question';

	if ( $hasPopUp ) {
		$objButtonO->popUpIs = true;
		if ( ! WUser::isRegistered() ) {
			$objButtonO->popUpHeight = '90%';
			$objButtonO->popUpWidth = '80%';
		} else {
			$objButtonO->popUpHeight = '80%';
			$objButtonO->popUpWidth = '80%';
		}	}
	$objButtonO->link = $link;
	$objButtonO->text = $text;
	$objButtonO->id = 'rvwsBtn';
	$objButtonO->icon = 'fa-comment';
	$objButtonO->color = 'primary';
	$content = WPage::renderBluePrint( 'button', $objButtonO );

	return $content;

}










function useful($usefulclick,$useful,$tkid,$authoruid,$clickID) {

	$widCat = WExtension::get( 'comment.node', 'wid' );
	if ( !empty($widCat) ) {
		WPage::addJSFile( 'node/comment/js/compile.js' );
	}
		$controller = WGlobals::get( 'controller' );
	if ( !empty($controller) ) {
		$wid = WController::get( $controller, 'wid' );
		$extensionNameKey = WExtension::get( $wid, 'namekey' );
		if ( $extensionNameKey == 'catalog.node' || $extensionNameKey == 'vendors.node' ) $wordType = 'review';
		else $wordType = 'comment';
	} else {
		$wordType = 'comment';
	}
		static $loguid = null;
	$allow = 'false';									$click = 0;

	if ( empty($loguid) ) $loguid = WUser::get('uid');	
		


	static $tkClickM = null;
	 $clickDone = null;
	if ( !isset($tkClickM) ) $tkClickM = WModel::get('ticket.clickyesno');
	$tkClickM->whereE('tkid', $tkid);
	$tkClickM->whereE('uid', $loguid);
	$clickDone = $tkClickM->load( 'lr', 'clickid' );
	$path = JOOBI_URL_INC . 'lib/jquery/';

	if ( $usefulclick ) {
		if ( $wordType == 'comment' ) {
			$usefulText = WText::t('1307514212KJCT');
		} else {
			$usefulText = WText::t('1307514212KJCU');
		}
		$usefulness = '<div class="reviewUsefulTotal"><span>'.$useful.' </span >'. WText::t('1272278972GKND') .' <span>'.$usefulclick.'</span> '. $usefulText .'</div>';
	} else {
		$usefulness = '';
	}
	$yesno = '<div class="reviewUseful" id="cmt_vote_'.$tkid.'">';

		if ( $authoruid!=$loguid && empty($clickDone) ) {						$click=1;
		$allow='true';						
		$mainurl = 'controller=comment&task=useful';
		$yes = $mainurl.'&case=yes&tkid='.$tkid.'&usefulclick='.$usefulclick.'&useful='.$useful.'&allow='.$allow.'&uid='.$authoruid.'&loguid='.$loguid;
		$no = $mainurl.'&case=no&tkid='.$tkid.'&usefulclick='.$usefulclick.'&useful='.$useful.'&allow='.$allow.'&uid='.$authoruid.'&loguid='.$loguid;

		$yes = WPage::routeURL( $yes );
		$no = WPage::routeURL( $no );


		$iconO = WPage::newBluePrint( 'icon' );
		$iconO->icon = 'loading';
		$iconO->text = WText::t('1395500509GSSS');
		$loading = ' <span style="display: none;" id="cmt-loading_'.$tkid.'" class="cmt-loading">' . WPage::renderBluePrint( 'icon', $iconO ) . '</span>';

		$yesno .= '<div id="reviewUseful-vote">';
		if ( $wordType == 'comment' ) {
			$yesno = WText::t('1307514212KJCV');
		} else {
			$yesno = WText::t('1307514212KJCW');
		}
		$yesno .= '<div class="clearfix">';
		$yesno .= '<a class="btn btn-success btn-sm" href="javascript:void(0)" id="comments_fe_cmtyes" onCLick="voteJS(\''.$yes.'\',\''.$tkid.'\',\''.$path.'\')">'.WText::t('1206732372QTKI').'</a>';
		$yesno .= '<a class="btn btn-danger btn-sm" href="javascript:void(0)" id="comments_fe_cmtyes" onCLick="voteJS(\''.$no.'\',\''.$tkid.'\',\''.$path.'\')">'.WText::t('1206732372QTKJ').$loading. '</a>';
		$yesno .= '</div>';

		$yesno .= '</div>';

	}
	$yesno .= $usefulness.'</div>';

	return $yesno;
}


}