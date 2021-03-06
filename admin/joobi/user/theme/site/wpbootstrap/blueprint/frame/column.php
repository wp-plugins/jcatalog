<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');













class WPane_column extends WPane {



	private $_htmlContentA = array();



	private $_isRTL = null;


























	public function startPane($params) {

		$this->_isRTL = WPage::isRTL();

		$this->_htmlContentA = array();

	}












	public function endPane() {



		if ( empty($this->_htmlContentA) ) {

			$this->content = '';

			return '';

		}


		
		$total = count( $this->_htmlContentA );



		if ( $total > 12 ) $total = 12;

		



		
		$totalUsed = 0;

		$totalExitCol = 0;

		if ( !empty($this->_columnWidthA) ) {

			foreach( $this->_columnWidthA as $key => $col ) {

				if ( !empty($col) ) {

					$new = floor( 12 * $col / 100 );

					$this->_columnWidthA[$key] = $new;

					$totalUsed += $new; 

					$totalExitCol++;

				}
			}
		}
		

		$totalLEft = $total - $totalExitCol;

		if ( $totalLEft > 0 ) $indiceRef = floor( (12-$totalUsed) / ( $totalLEft ) );

		else $indiceRef = 0;

		

		$html = '<div class="container-fluid"><div class="row">';

		foreach( $this->_htmlContentA as $key => $oneColumn ) {

			

			if ( !empty( $this->_columnWidthA[$key] ) ) $indice = $this->_columnWidthA[$key];

			else $indice = $indiceRef;



			
			$pushRight = ( $this->_isRTL ? ' col-md-push-' . $indice : '' );

			

			$html .= '<div class="col-md-' . $indice . $pushRight . '">' . $oneColumn . '</div>';

		}
		$html .= '</div></div>';



		$this->content = $html;



	}










	public function startPage($params) {

	}






	function add($content) {



		$this->_htmlContentA[] = $content;



	}






	public function endPage() {

	}


}
