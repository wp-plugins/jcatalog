<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





































class ReCaptchaResponse{
    public $success;
    public $errorCodes;
}
class ReCaptcha{
    private static $_signupUrl = "https://www.google.com/recaptcha/admin";
    private static $_siteVerifyUrl = "https://www.google.com/recaptcha/api/siteverify?";
    private $_secret;
    private static $_version = "php_1.0";
    




    function ReCaptcha($secret)
    {
        if ($secret == null || $secret == "") {
            die("To use reCAPTCHA you must get an API key from <a href='"
                . self::$_signupUrl . "'>" . self::$_signupUrl . "</a>");
        }
        $this->_secret=$secret;
    }
    






    private function _encodeQS($data)
    {
        $req = "";
        foreach ($data as $key => $value) {
            $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
        }
                $req=substr($req, 0, strlen($req)-1);
        return $req;
    }
    







    private function _submitHTTPGet($path,$data)
    {
        $req = $this->_encodeQS($data);
        $response = file_get_contents($path . $req);
        return $response;
    }
    








    public function verifyResponse($remoteIp,$response)
    {
                if ($response == null || strlen($response) == 0) {
            $recaptchaResponse = new ReCaptchaResponse();
            $recaptchaResponse->success = false;
            $recaptchaResponse->errorCodes = 'missing-input';
            return $recaptchaResponse;
        }
        $getResponse = $this->_submitHttpGet(
            self::$_siteVerifyUrl,
            array (
                'secret' => $this->_secret,
                'remoteip' => $remoteIp,
                'v' => self::$_version,
                'response' => $response
            )
        );
        $answers = json_decode($getResponse, true);
        $recaptchaResponse = new ReCaptchaResponse();
        if (trim($answers ['success']) == true) {
            $recaptchaResponse->success = true;
        } else {
            $recaptchaResponse->success = false;
            $recaptchaResponse->errorCodes = $answers [error-codes];
        }
        return $recaptchaResponse;
    }
}







class Main_Recaptcha_addon extends WClasses {


        private $resp = null;
        private $error = null;
    private $reCaptcha;





	public function needInputBox() {
		return false;
	}





	function generate(&$html) {

        $lgid = WUser::get( 'lgid' );
        $lang = WLanguage::get( $lgid, 'code' );

		$mainCredentialsC = WClass::get( 'main.credentials' );
		$siteKey = $mainCredentialsC->loadFromType( 'recaptcha', 'username' );
		if ( empty($siteKey) ) {
			$this->userE('1425922198CPJX');
			return false;
		}

				$params = array();

        $html = "<div class='g-recaptcha' data-sitekey='" . $siteKey . "'></div>
        <script src='https://www.google.com/recaptcha/api.js?hl='" . $lang . "'></script>";


		return $params;

	}




	function clean($id) {
		return true;
	}




	function verify($id,$entered=null) {

		$response = WGlobals::get( 'g-recaptcha-response' );

		$mainCredentialsC = WClass::get( 'main.credentials' );
		$secretKey = $mainCredentialsC->loadFromType( 'recaptcha', 'passcode' );
		if ( empty($secretKey) ) {
			return false;
		}


        $reCaptcha = new ReCaptcha( $secretKey );
        $remoteAdd = WGlobals::get( 'REMOTE_ADDR', null, 'server' );
        $resp = $reCaptcha->verifyResponse( $remoteAdd, $response );
        if ( $resp != null && $resp->success ) {
            return true;
        }else{
            return false;
        }

	}
}