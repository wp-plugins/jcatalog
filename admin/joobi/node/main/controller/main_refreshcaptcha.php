<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_refreshcaptcha_controller extends WController {


    function refreshcaptcha() {


        $captchaHandler = WClass::get('main.captcha');

        $captcha = $captchaHandler->loadDefault();

        $array = $captcha->getCaptcha();



        
        if ( $array===false ) {



            return false;

        }


        $arrayHTML = $array['html'];

        $id = $array['id'];



        echo '<div id="captchaHTMLResponse">' . $arrayHTML . '</div><input id="captchaIDResponse" value=' . $id . '></input>';



        return true;



	}
}