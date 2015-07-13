<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Main_Captcha_class extends WClasses {









	private $_options = array('type'=>null);
	private $_addonoptions = null;

	function __construct($options=null) {

		foreach($this->_options as $k => $v) {

			if ( @isset($options->$k) ) {
				$this->_options[$k] = $options->$k;
				unset($options->$k);
				continue;
			}
			$this->_options[$k] = @constant('PLIB_CAPTCHA_' . strtoupper($k));
		}
		$this->_addonoptions =& $options;

	}

	




	public function loadDefault() {

		$obj = new stdClass; 				$obj->type = 1;
		$obj->life = 10000;
				$obj->maxuse = 10;
				$obj->audio = 0;
		$obj->algofixe = 1;
		$obj->algo = 1;
		$obj->nbcached = 10;
		$obj->crypt = 'md5';
		return WClass::get( 'main.captcha', $obj );

	}





	public function needInputBox() {

		$captchatype = WPref::load( 'PUSERS_NODE_USECAPTCHA' );

				$captcha = WAddon::get( 'main.' . $captchatype, $this->_addonoptions );
		if ( ! is_object($captcha) ) {
			return false;
		}
		return $captcha->needInputBox();

	}






	public function getCaptcha() {



		


		$captchatype = WPref::load( 'PUSERS_NODE_USECAPTCHA' );

				$captcha = WAddon::get( 'main.' . $captchatype, $this->_addonoptions );
		if ( ! is_object($captcha) ) {
			return false;
		}
		$html = '';
		$params = $captcha->generate($html);
				if ( $params === false ) {
			return false;
		}
		$return = array('html'=>$html);

		if ( isset($params['nofield']) ) $return['nofield'] = true;

		$p = array( 'cptid', 'password', 'used', 'image', 'crypt' );

		$captchaM = WModel::get( 'main.captcha' );

		foreach( $p as $v ) {
			if ( array_key_exists( $v, $params ) ) {
				$captchaM->$v = $params[$v];
				unset($params[$v]);
			}		}
		if ( isset($captchaM->password) ) $captchaM->password = strtolower($captchaM->password);
				$captchaM->p =& $params;
		$captchaM->returnId(true);
		if ( ! $captchaM->save() ) return false;


		$id = $captchaM->cptid;
				$return['id'] = $id;

				if ( !empty($id) ) WGlobals::setSession( 'captcha', 'id', $id );

		return $return;

	}






	public function verify($captchaID) {

		$captcha = $this->loadDefault();

		$captchaValue = WGlobals::get( 'captcha_verify' );

		return $captcha->verifyOnly( $captchaID, $captchaValue );

	}





	public function checkProcedure() {

		$useCaptcha = WPref::load( 'PUSERS_NODE_USECAPTCHA' );
		if ( empty($useCaptcha) ) return true;

		$captchaID = WGlobals::get( 'captcha_id', null, '', 'int' );

		if ( $captchaID && is_numeric($captchaID) ) {
			if ( ! $this->verify($captchaID) ) {
				$message = WMessage::get();
				$this->_saveEditorStuff();
				$message->historyE('1206732406SEHE');
				return false;
			}		} else {
			$message = WMessage::get();
			$this->_saveEditorStuff();
			$message->historyE('1206732406SEHE');
			return false;
		}
		WGlobals::setSession( 'captcha', 'id', null, true );

		return true;

	}





	private function _saveEditorStuff() {

		$requestA = WGlobals::get();
		if ( !empty($requestA) ) {
			foreach( $requestA as $oneK => $oneV ) {

				if ( 'zdtr_trucs_' == substr( $oneK, 0, 11 ) ) {
					WGlobals::setSession( 'formEditor', $oneK, $oneV );
				}
			}		}

	}







	public function verifyOnly($id=null,$entered='',$text=null) {


			
			$captchatype = WPref::load( 'PUSERS_NODE_USECAPTCHA' );

						$myaddon = WAddon::get( 'main.' . $captchatype, $this->_addonoptions );
			if ( ! is_object($myaddon) ) {
				return false;
			}

						if ( ! $myaddon->verify( $id, $entered ) ) {
				return false;
			}


		return true;

	}
}