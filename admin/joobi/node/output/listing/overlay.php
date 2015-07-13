<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WListing_Coreoverlay extends WListings_default{





	function create(){



		if(!empty($this->element->truncate) && strlen($this->value) > $this->element->truncate){

			
			$this->value=substr( trim(strip_tags( $this->value,'<br>')), 0 , $this->element->truncate) . '...';

		}


		$this->content=$this->value;


		return true;

	}
}
