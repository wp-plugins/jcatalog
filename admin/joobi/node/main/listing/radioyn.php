<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

















class WListing_Coreradioyn extends WListings_default{





	function create() {
		static $text=null;
		static $addLegend = array();

		if ( !isset($text) ) {
			$aValue = array( 0, 1 );

			$aImg = array( 'cancel', 'yes' );
			$yes = WText::t('1206732372QTKI');
			$no = WText::t('1206732372QTKJ');
			$aLabel = array( $no, $yes );

			$size = 2 ;
			for( $index = 0; $index < $size; $index++ ) {
				$label = $aLabel[$index];
				$alt = $label;


				$opt = $label. WView::getLegend( $aImg[$index], $label, 'publish', $index );
				$pub[] = WSelect::option( $aValue[$index], $opt );
			}
			$text = $pub;
		}
		$primaryVal = $this->pkeyMap;
				if ( substr( $this->element->map, 1,1 ) =='[' ) {
			$map2Use = str_replace(']', '', $this->element->map );
			$map2Use = str_replace('[', '][', $map2Use );
		} else {
			$map2Use = $this->element->map;
		}
		$dropdownName =  'trucs[' . $this->element->sid .']['.$map2Use.']'.'['.$this->data->$primaryVal.']';
	 	$dropdownTADID = substr( $this->name, 6, strlen($this->name) );
		$dropdownTADID = str_replace( array( '.', ']', '['), '_', $dropdownTADID );

		if ( !empty($this->value) ) $this->value = '1'; else $this->value = '0';

		$HTMLRadio = new WRadio();
		$this->content = $HTMLRadio->create( $text, $dropdownName, '', 'value' , 'text' , $this->value, $dropdownTADID.$this->line, false );

		return true;

	}
}