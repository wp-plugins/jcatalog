<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
 class Translation_Save_controller extends WController {





	function save(){

		$trucs=WGlobals::get('trucs');
		$sid=$trucs['s']['mid'];

		$model=WModel::get($sid);

		$tpkey='tpkey_' . $sid;
		$teid='teid_' . $sid;
		$tpkey=WGlobals::get($tpkey);
		$teid=WGlobals::get($teid);

		$lgid=WController::getFormValue( 'lgid', $sid );

		$trucs=WGlobals::get('trucs');
		$submitedthings=$trucs[$sid];
		$copyofsub=$submitedthings;

		if($model->_type==20){

			$model->whereE( $tpkey, $teid );
			$model->whereE('lgid', $lgid);
			$reus=$model->load('o');

			if( !empty ($reus)){
								unset($copyofsub['lgid']);
				foreach($copyofsub as $toset=> $value){
					$model->setVal( $toset, $value );
				}
				$model->whereE('lgid', $lgid);
				$model->whereE($tpkey, $teid);
				$model->update();

				$language=WLanguage::get( $lgid, 'name' );
				return 'Success, translation for ' . $language . ' updated';
			}else{

								$model->$tpkey=$teid;
				foreach($submitedthings as $toset=> $value){
					$model->$toset=$value;
				}				$model->save();
				return 'Success, Translation added';
			}		}else{
			return 'Error';
		}
	}
}