<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');

















class WRender_Pagination_class extends Theme_Render_class {









































  	public function render($data) {



  		if ( empty($data->pageNumbersA) ) return '';



		$pageLinks = '';

  		
  		foreach( $data->pageNumbersA as $onePage ) {

  			$pageLinks .= $this->_oneLink( $onePage );

  		}




  		$paginationHTMLMAIN = '<ul';

  		
  		$paginationHTMLMAIN .= '>'.$pageLinks.'</ul>';





		$paginationHTML = '';





		if ( APIPage::isRTL() ) {

			$html = $paginationHTMLMAIN . $paginationHTML;

		} else {

			$html = $paginationHTML . $paginationHTMLMAIN;

		}




		$return = '<div class="pagination">' . $html . '</div>';



		$return = '<div class="pagination-wrap">' . $return . '</div>';



		return $return;



  	}



























  	private function _oneLink($onePage) {



  		if ( empty($onePage) ) return '';




		
			$addtionalClass = ( !empty($onePage->class) ? ' class="pagination-'.$onePage->class.'"' : '' );



			if ( !empty($onePage->current) ) {



				$html = '<li'.$addtionalClass.'><span class="pagenav">'.$onePage->text.'</span></li>';

				return $html;



			} else {





				$return = '<li'.$addtionalClass.'><a';

				$return .= ' class="pagenav"';

				if ( !empty($onePage->linkOnClick) ) $return .= ' onclick="' . $onePage->linkOnClick . '"';

				$return .= ' href="#">'.$onePage->text.'</a></li>';

				return $return;





				$link = '<span class="pagiCenter"><a href="#" class="page" title="'.$onePage->text .

'" onclick="' . $onePage->linkOnClick . '">'.$onePage->text.'</a></span>';



				$test = '<span class="pagiCenter">' . $onePage->text . '</span>';



				if ( empty($onePage->off) ) $onePage->off = '';

				$return ='<span class="'.$onePage->classTwo. $onePage->off .'"><span class="'.$onePage->classOne.'">';

				$return .= ( trim( $onePage->off ) == 'disabled' ) ? $test : $link;

				$return .=	'</span></span>';



			}


			return $return;





	}


}
