<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Project_Category_picklist extends WPicklist {
	function create() {





		$projectM = WModel::get('project');






		$projectM->makeLJ('projecttrans','pjid');

		$projectM->makeLJ('project.members','pjid');



		$projectM->select('name',1);

		$projectM->select('uid',2);



		$uid=WUser::get('uid');

		$projectM->whereE( 'type', 1 );

		$projectM->whereE( 'uid', $uid , 2 );






		if ( $this->onlyOneValue() ) {					$projectM->rememberQuery();

			$projectM->whereE( 'pjid' , $this->defaultValue );


			$result = $projectM->load('o', array('pjid') );

			if ( !empty($result) ) {

				$this->addElement( $result->pjid, $result->name );

			}
			return true;

		}


		$projectM->select('pjid',0);

		$allpj=$projectM->load('ol');



		$this->addElement( 1, WText::t('1206732429GMSU') );



		
		if (empty($allpj)) return;

		foreach($allpj as $project) {

			$this->addElement( $project->pjid,$project->name);

		}





	}}