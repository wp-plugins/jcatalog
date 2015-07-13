<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

















class WForm_Corecaptcha extends WForms_default {





	function create() {

				if ( WUser::isRegistered() ) return false;

		if ( ! WPref::load( 'PUSERS_NODE_USECAPTCHA' ) ) return false;

		$this->idLabel = 'cptch' . $this->idLabel;
				$captchaHandler = WClass::get( 'main.captcha' );
		$captcha = $captchaHandler->loadDefault();

				$array = $captcha->getCaptcha();
		if ( $array===false ) {
            return false;
		}

		        $this->content = '<div id="captcha" class="captcha-box">' . $array['html'] . '</div>';
		$this->content .= '<input type="hidden" id="id_captcha_id" name="captcha_id" value="' . $array['id'] . '"/>';


        if ( $captchaHandler->needInputBox() ) {

                     WPage::addJSLibrary( 'jquery' );
            if ( !defined('JOOBI_URL_JOOBI_IMAGES') ) WView::definePath();

                        $controllerPath = WPage::link( 'controller=main&task=refreshcaptcha' );
			$iconO = WPage::newBluePrint( 'icon' );
			$iconO->icon = 'loading';
			$iconO->size = 'xlarge';
			$iconO->text = WText::t('1395500509GSSS');
			$gifImage = WPage::renderBluePrint( 'icon', $iconO );

			$iconO = WPage::newBluePrint( 'icon' );
			$iconO->icon = 'refresh';
			$iconO->text = WText::t('1206732400OWXE');
			$iconO->id = 'captcha_refresh';
			$iconO->name = 'captcha_refresh';
			$iconO->size = 'xlarge';
			$refreshImage = WPage::renderBluePrint( 'icon', $iconO );



				$this->content .= '<div class="captcha-text">';


			$this->content .= '<div style="float:left;">';
				$this->content .= '<input type="text" placeholder="' . WText::t('1416948592JPZB') . '" class="form-control" id="'.$this->idLabel.'" name="captcha_verify" onfocus="removecaptchamessage();" onblur="checkcaptcha();"';
				$this->content .= ( !empty( $this->element->style ) ) ? '" style="'.$this->element->style .'"' : '';
				$this->content .= ( !empty( $this->element->align ) ) ? '" align="'.$this->element->align .'"' : '';
				$this->content .= '/>';
			$this->content .= '</div>';

	        $this->content .= '<div id="refresh-captcha-div" class="captcha-refresh">';
		        $this->content .= '<a id="refresh-captcha" style="cursor: pointer;">';
		        $this->content .= $refreshImage;
		        $this->content .= '</a>';
	        $this->content .= '</div>';
	        $this->content .= '<div id="'.$this->idLabel.'_message" class="clearfix"></div>';


		$this->content .= '</div>';
		


				$script = '
checkcaptcha = function(){
var form = eval("document.' . $this->formName . '");
var url= "' . WPage::linkPopUp( 'controller=main&task=checkcaptcha' ) . '";
';

					$script .=	'jQuery.ajax({
url : url,
data: jQuery(form).serialize()+"&controller=main&task=checkcaptcha",
method: "POST",
success: function(msg){
divid = jQuery("#'.$this->idLabel.'_message");
divid.html(msg);
}
});';

		$script .= '}
removecaptchamessage = function(){
divid = jQuery("#'.$this->idLabel.'_message")
divid.innerHTML="";
}
';
                                

                $script .= '
jQuery(document).ready(function()
{
jQuery("#refresh-captcha").click(function()
{
jQuery("#' . $this->formName . '").submit(function(e)
{
jQuery("#captcha").html(\'' . $gifImage . '\');
var kw = "xz7w";
jQuery.ajax(
{
url : "'.$controllerPath.'",
type: "POST",
data: "kw="+ kw,
success:function(jqXHR, textStatus, errorThrown)
{
jQuery("#captcha").html(\'\');
captchaHTML = jQuery(jqXHR).find(\'#captchaHTMLResponse\');
jQuery("#captcha").append(captchaHTML);
captchaID = jQuery(jqXHR).find(\'#captchaIDResponse\');
jQuery("#id_captcha_id").attr({value:captchaID.val()});
},
error: function(jqXHR, textStatus, errorThrown)
{
jQuery("#captcha").html(\'<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus=\'+textStatus+\', errorThrown=\'+errorThrown+\'</code></pre>\');
}
});
e.preventDefault();
});
jQuery("#' . $this->formName . '").submit();
});
});
';
	 

    WPage::addJSScript( $script, 'jquery', false );

        }



    return true;

	}


}