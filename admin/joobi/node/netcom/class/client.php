<?php 

* @link joobi.co
* @license GNU GPLv3 */


class Netcom_Client_class extends WClasses {
	





	public $APIVersion='1.0';
	





	
	public $APIUserID=0;
		




	
	public $servicesCredentials=array(
	);	
		
	
	public function getServicesCredentials(){
		return $this->servicesCredentials;
	}	
	
	public function setAPIUserID($UserID){
		$this->APIUserID=$UserID;
	}	
	
	public function setVersion($version){
		
		$this->APIVersion=$version;
		
	}	
	
	public function createResponseMessage($status,$message){
		
		$errorMessage=new NetcomResponse;
		if( $status){
			$errorMessage->status='SUCCESS';
		}else{
			$errorMessage->status='FAILED';
		}		
		if( !empty($message)){
			$errorMessage->message=$message;
		}		
		return $errorMessage;
	}	
}

class NetcomResponse {
	
	public $status='';
	
	public $message='';

}