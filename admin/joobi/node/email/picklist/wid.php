<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Email_Wid_picklist extends WPicklist {








	function create(){



		$mailModel=WModel::get('email');

		$mailModel->select('wid');

		$mailModel->setDistinct();

		$wids=$mailModel->load('lra');



		if(!empty($wids)){

			$extensionModel=WModel::get( 'install.apps' );

			$extensionModel->select('name');

			$extensionModel->select('wid');

			$extensionModel->whereIn('wid',$wids);

			$extensionModel->orderBy('name','ASC');

			$results=$extensionModel->load('ol');



			if(!empty($results)){



				foreach($results as $extension)  {

					$this->addElement( $extension->wid , $extension->name );

				}
			}
		}


	}

}