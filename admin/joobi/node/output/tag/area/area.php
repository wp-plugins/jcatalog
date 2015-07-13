<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');







 class Output_Area_tag {



	







	function process($object){



		$tags=array();

		if( empty($this->params->container) || !is_array($this->params->container)){

			return $tags;

		}

		foreach($object as $tag=> $tagparam){

			$area=$tagparam->name;

			if(isset($this->params->container[$area])){

				
				$tags[$tag]=$this->params->container[$area];

			}else{

				
				$tags[$tag]='';

			}

		}

		return $tags;

	}
}