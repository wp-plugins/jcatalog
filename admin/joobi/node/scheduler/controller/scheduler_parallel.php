<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Scheduler_parallel_controller extends WController {













	function parallel(){


		$status=false;

        if( intval( PLIBRARY_NODE_CRON ) >=5){



			$schid=WGlobals::get( 'schid', 0, '', 'int' );

			$password=WGlobals::get( 'password', '', '', 'string' );


									if( !empty($password)){
				$tasksO=WObject::get( 'scheduler.task' );
				$pcsid=WGlobals::get( 'pcsid' );

				$status=$tasksO->process( $schid, $password, $pcsid );

			}


		}
		if( $status){
			echo "Working...";
		}else{
			echo "NOT Working...";
		}		exit();


		return true;

	}}