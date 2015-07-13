<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Chat_class extends WClasses {



    public function displayChatButton() {

    	return false;

    	$lang = substr( WLanguage::get( WUser::get( 'lgid' ), 'code' ), 0, 2 );

    	switch( $lang ) {
    		case 'lt':
    			$chat = '/lit';
    			break;
    		case 'he':
    			$chat = '/hrv';
    			break;
    		case 'es':
    			$chat = '/esp';
    			break;
    		case 'pt':
    			$chat = '/por';
    			break;
    		case 'nl':
    			$chat = '/nld';
    			break;
    		case 'de':
    			$chat = '/ger';
    			break;
    		case 'pl':
    			$chat = '/pol';
    			break;
    		case 'ru':
    			$chat = '/rus';
    			break;
    		case 'it':
    			$chat = '/ita';
    			break;
    		case 'fr':
    			$chat = '/fre';
    			break;
    		case 'zh':
    			$chat = '/chn';
    			break;
    		case 'nb':
    			$chat = '/nor';
    			break;
    		case 'tr':
    			$chat = '/tur';
    			break;
    		case 'vi':
    			$chat = '/vnm';
    			break;
    		case 'id':
    			$chat = '/idn';
    			break;
    		case 'sv':
    			$chat = '/sve';
    			break;
    		case 'da':
    			$chat = '/dnk';
    			break;
    		case 'bg':
    			$chat = '/bgr';
    			break;
    		case 'th':
    			$chat = '/tha';
    			break;
    		case 'fi':
    			$chat = '/fin';
    			break;
    		case 'el':
    			$chat = '/ell';
    			break;
    		case 'sq':
    			$chat = '/alb';
    			break;
    		case 'ar':
    			$chat = '/ara';
    			break;
    		case 'cs':
    			$chat = '/cse';
    			break;
    		case 'ro':
    			$chat = '/rou';
    			break;
    		case 'fa':
    			$chat = '/per';
    			break;
    		case 'ka':
    			$chat = '/geo';
    			break;

    		default:
    			$chat = '';
    			break;
    	}
			

    	
						$js = "var LHCChatboxOptions = {hashchatbox:'empty',identifier:'default',status_text:'Chatbox'};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = '//chat.joobi.co/index.php/chatbox/getstatus/(position)/middle_right/(top)/300/(units)/pixels/(width)/300/(theme)/2/(height)/300/(chat_height)/220/(scm)/true';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();";



			WPage::addJS( $js );




	}

}