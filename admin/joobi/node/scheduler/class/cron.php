<?php 

* @link joobi.co
* @license GNU GPLv3 */














class Scheduler_Cron_class extends WClasses {




	function checkCron(){


						$data=new stdClass;
		$data->url=JOOBI_SITE;
		$data->username=WUser::get( 'username' );
		$data->email=WUser::get( 'email' );
		$data->type=3;
		$data->platform=JOOBI_FRAMEWORK;
		$data->cronurl=WPages::linkHome( 'controller=scheduler&task=process' . URL_NO_FRAMEWORK );

		$netcom=WNetcom::get();
		$result=$netcom->send( WPref::load('PAPPS_NODE_REQUEST'), 'site', 'createcron', $data );
		
		return $result;

	}
}