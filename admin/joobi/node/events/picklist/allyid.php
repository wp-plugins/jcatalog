<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Events_Allyid_picklist extends WPicklist {






function create(){



	$this->addElement( 'lay1' , '++LAYOUT' );



	$controller=WGlobals::get('controller');





	$layouts=$this->loadLayouts();



}




function loadLayouts(){



	$filterBYLayout=false;



	$viewM=WModel::get( 'library.view' );

	$viewM->makeLJ( 'apps', 'wid' );

	$viewM->select('alias' , 0,'name');

	$viewM->select('yid');

	$viewM->select('type');


	$viewM->select('name', 1,'ename');






	$viewM->orderBy( 'core', 'ASC' );

	$viewM->orderBy( 'name', 'ASC', 1 );

	$viewM->orderBy( 'type', 'ASC' );

	$viewM->orderBy( 'alias', 'ASC', 0 );

	$viewM->setLimit( 5000 );



	$layouts=$viewM->load( 'ol' );



	if( !empty($layouts)){



		$index=1;

		$myPrefix='';



		$prevextension='';

		if( $filterBYLayout){

			


			foreach($layouts as $layout)  {

				$index++;



				$extension=( !empty($layout->extension)) ?  $layout->extension: '';



				if( $myPrefix!=$layout->ename){

					$this->addElement( 'ax' . $index , '--' . $layout->ename );

					$myPrefix=$layout->ename;

				}
				if($prevextension!=$extension){

					$this->addElement( 'zx' . $index , '--' . $extension );

					$prevextension=$extension;

				}



				$this->addElement( $layout->yid ,  $layout->name );


			}


		}else{



			
			foreach($layouts as $layout)  {

				$index++;

				$extension=( !empty($layout->ename)) ?  $layout->ename : '';



				if($prevextension!=$extension){

					$this->addElement( 'zx' . $index , '--'.$extension );

					$prevextension=$extension;

				}

				$this->addElement( $layout->yid , $layout->name );

			}
		}




	}
}}