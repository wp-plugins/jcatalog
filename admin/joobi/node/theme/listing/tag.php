<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');



class Theme_CoreTag_listing  extends WListings_default{



	function create(&$listing){



		$map=$this->mapList['map'];

		$mapName=$this->data->$map;



		$tag='widget:area|name='.$mapName.'';



		return $tag;

	}


}
