<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');









class Output_Param_tag {



	function process($object){

		$tags=array();



		foreach( $object as $tag=> $mytag){

			if( empty($mytag->name)) $mytag->name=$mytag->_type;

			$name=$mytag->name;

			if( isset($this->params->$name)){

				if( is_string($this->params->$name) || is_numeric($this->params->$name) || is_bool($this->params->$name)){

					$tags[$tag]=$this->params->$name;

				}else{

					$message=WMessage::get();

					$message->codeE('Your param tag "' . $name . '" is not a string, please change it!', array(), 0 );

					$tags[$tag]=serialize( $this->params->$name );

				}


			}else{


				$tags[$tag]='';



			}
		}


		return $tags;



	}


}