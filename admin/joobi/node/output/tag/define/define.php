<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');













class Output_Define_tag {











 	 private $definedVar=array( 'SITENAME'=> 'JOOBI_SITE_NAME', 'SITE'=> 'JOOBI_SITE' );	




















	function process($object){

		$tags=array();



		if( WRoles::isAdmin( 'manager' )) $this->definedVar['ROOT']='JOOBI_DS_ROOT';

		else $this->definedVar['ROOT']='';



		foreach( $object as $TAG=> $parameters){



			
			if( empty($parameters->name)) $parameters->name=$parameters->_type;



			$parameters->name=strtoupper( $parameters->name );



			
			if($parameters->name=='SITEURL') $parameters->name='SITE';

			elseif($parameters->name=='SITEURLADMIN') $parameters->name='SITE_ADMIN';



			
			if( !isset($this->definedVar[$parameters->name])){

				$VALUE=$parameters->name;

				$message=WMessage::get();

				$message->userW('1212843293BKVE',array('$TAG'=>$TAG));

				$message->userW('1213369322GXOW',array('$VALUE'=>$VALUE));

				$VALUES=implode(' | ',array_keys($this->definedVar));

				$message->userW('1213369322GXOX',array('$VALUES'=>$VALUES));

				$message->userW('1380025960NDBN');

				continue;

			}


			
			$tags[$TAG]=defined($this->definedVar[$parameters->name]) ? constant( $this->definedVar[$parameters->name] ) : '';



		}


		return $tags;



	}


}