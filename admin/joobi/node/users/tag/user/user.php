<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');























class Users_user_tag {

 	
 	var $usertag=true;



 	





 	var $_excludeA=array('password','question','answer');













	function process($object){

		static $adminStatus=null;

		








		$tags=array();

		$message=WMessage::get();



		
		$query=false;

		
		foreach( $object as $tagname=> $value){

			
			if( empty($value->select)) $value->select=$value->_type;

			$valeur=strtolower( $value->select );



			
			if( in_array( $valeur, $this->_excludeA )){

				$FIELD=$valeur;

				$message->userW('1212843293BKVD',array('$FIELD'=>$FIELD));

				$tags[$tagname]='';

				continue;

			}


			
			if( isset($this->user->$valeur)){

				$tags[$tagname]=$this->user->$valeur;

				continue;

			}else{





				if( !isset($adminStatus)){

					$roleC=WRole::get();

					$adminStatus=WRole::hasRole( 'admin' );

				}


				if( !$adminStatus){

					
					$tags[$tagname]='';

				}
			}


			
			if( empty($this->user->uid)){


				continue;

			}


			$this->user=WUser::get( 'data', $this->user->uid );





			if( 'firstname'==$valeur){

				$expldeNAmeA=explode( ' ', $this->user->name );

				$tags[$tagname]=$expldeNAmeA[0];

				continue;

			}elseif( 'lastname'==$valeur){

				$expldeNAmeA=explode( ' ', $this->user->name );

				$tags[$tagname]=array_pop( $expldeNAmeA );

				continue;

			}else{

				
				if( isset($this->user->$valeur)){

					$tags[$tagname]=$this->user->$valeur;

					continue;

				}


			}













			
			$FIELD=$valeur;



			$message->userW('1299148902FYMY',array('$FIELD'=>$FIELD));




		}


		return $tags;

	}
}