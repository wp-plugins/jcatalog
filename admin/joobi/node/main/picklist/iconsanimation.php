<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Iconsanimation_picklist extends WPicklist {


	function create() {



		
		WPage::addCSSFile( 'fonts/font-awesome/css/font-awesome-animation.css', 'theme' );



		$listA = array();

		$listA[0] = '-' . WText::t('1206732410ICCJ') . '-';

$listA['--0--'] = WText::t('1400811120SUCB');



		$listA['faa-wrench animated'] = 'fa-wrench faa-wrench animated';

		$listA['faa-ring animated'] = 'fa-bell faa-ring animated';

		$listA['faa-horizontal animated'] = 'fa-envelope faa-horizontal animated';

		$listA['faa-vertical animated'] = 'fa-thumbs-o-up faa-vertical animated';

		$listA['faa-flash animated'] = 'fa-envelope faa-horizontal animated';

		$listA['faa-horizontal animated'] = 'fa-warning faa-flash animated';

		$listA['faa-bounce animated'] = 'fa-envelope faa-horizontal animated';

		$listA['faa-horizontal animated'] = 'fa-thumbs-o-up faa-bounce animated';

		$listA['faa-spin animated'] = 'fa-spinner faa-spin animated';

		$listA['faa-float animated'] = 'fa-plane faa-float animated';

		$listA['faa-pulse animated'] = 'fa-heart faa-pulse animated';

		$listA['faa-shake animated'] = 'fa-envelope faa-shake animated';

		$listA['faa-tada animated'] = 'fa-trophy faa-tada animated';

		$listA['faa-passing animated'] = 'fa-space-shuttle faa-passing animated';



		$listA['--1--'] = WText::t('1400811120SUCC');



		$listA['faa-wrench animated-hover'] = 'fa-wrench faa-wrench animated-hover';

		$listA['faa-ring animated-hover'] = 'fa-bell faa-ring animated-hover';

		$listA['faa-horizontal animated-hover'] = 'fa-envelope faa-horizontal animated-hover';

		$listA['faa-vertical animated-hover'] = 'fa-thumbs-o-up faa-vertical animated-hover';

		$listA['faa-flash animated-hover'] = 'fa-envelope faa-horizontal animated-hover';

		$listA['faa-horizontal animated-hover'] = 'fa-warning faa-flash animated-hover';

		$listA['faa-bounce animated-hover'] = 'fa-envelope faa-horizontal animated-hover';

		$listA['faa-horizontal animated-hover'] = 'fa-thumbs-o-up faa-bounce animated-hover';

		$listA['faa-spin animated-hover'] = 'fa-spinner faa-spin animated-hover';

		$listA['faa-float animated-hover'] = 'fa-plane faa-float animated-hover';

		$listA['faa-pulse animated-hover'] = 'fa-heart faa-pulse animated-hover';

		$listA['faa-shake animated-hover'] = 'fa-envelope faa-shake animated-hover';

		$listA['faa-tada animated-hover'] = 'fa-trophy faa-tada animated-hover';

		$listA['faa-passing animated-hover'] = 'fa-space-shuttle faa-passing animated-hover';





		if ( $this->onlyOneValue() ) {

			$defaults = $this->getDefault();

			if ( empty($defaults) ) return false;



			if ( isset( $listA[ $defaults ] ) ) {

				$this->addElement( $defaults , '<i class="fa ' . $defaults . ' fa-3x"></i> ' );

			}
		} else {





			
			$this->addElement( '', WText::t('1206732410ICCJ') );



			$css = '';

			foreach( $listA as $oneKey => $oneVal ) {

				$css .= '.' . $oneKey . ':before{padding:5px;}';

				$onjClass = new stdClass;

				$onjClass->class = 'fancyPicklist fa ' . $oneKey . ' fa-lg';

				if ( substr( $oneKey, 0, 2 ) == '--' ) $this->addElement( $oneKey, $oneKey, $onjClass );

				else $this->addElement( $oneKey, $oneVal );

			}


			WPage::addCSS( '.fancyPicklist{display: block;}' . $css );





		}




		return true;



	}}