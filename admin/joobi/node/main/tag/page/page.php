<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');









class Main_Page_tag {



	private static $_regexCSS = null;

	private static $_regexOnClick = null;





 









	public function process($object) {

		$tags = array();

		$message = WMessage::get();



		if (PHP_VERSION < "5"){

			$message->userW('1380143302RHWW');

			return $tags;

		}



		foreach($object as $tag => $value){

			
			$tags[$tag] = '';



			if (empty($value->url)){

				$message->userW('1380143302RHWX');

				$message->userW('1418159563RQJB');

				continue;

			}



			
			if (strpos($value->url,'http://') === false){

				$value->url = 'http://'.$value->url;

			}



			$page = file_get_contents($value->url);



			
			if ($page === false){

				$URL = $value->url;

				$message->userW('1380143302RHWZ',array('$URL'=>$URL));

				$tags[$tag] = '';

				continue;

			}


			
			$page = str_replace('&nbsp;',' ',$page);

			$this->_charset($page);

			$this->_completeURL($page,$value->url);

			$css = $this->_extractCSS($page,$value->url);

			$this->_replaceCSS($page,$css);

			$this->_removeScript($page);

			$tags[$tag] = $page;

		}

		return $tags;

	}








	private function _removeScript(&$page) {

		$remove = array();

		
		$remove[] = "< *style(?:(?!< */ *style *>).)*< */ *style *>";

		$remove[] = "< *script(?:(?!< */ *script *>).)*< */ *script *>";

		$remove[] = "< *link(?:(?!>).)*>";

		$remove[] = "< *head(?:(?!< */ *head *>).)*< */ *head *>";

		$remove[] = "< *object(?:(?!< */ *object *>).)*< */ *object *>";

		$remove[] = "< *embed(?:(?!< */ *embed *>).)*< */ *embed *>";

		$remove[] = "< *applet(?:(?!< */ *applet *>).)*< */ *applet *>";

		$remove[] = "< *noframes(?:(?!< */ *noframes *>).)*< */ *noframes *>";

		$remove[] = "< *noembed(?:(?!< */ *noembed *>).)*< */ *noembed *>";

		$remove[] = "< *noscript(?:(?!< */ *noscript *>).)*< */ *noscript *>";

		$remove[] = "< */ *html *>";

		$remove[] = ".*< *html *>";

		if ( !isset( self::$_regexOnClick ) ) self::$_regexOnClick = base64_decode( 'KG9uY2xpY2t8b25mb2N1c3xvbmxvYWQpICo9ICoiKD86KD8hIikuKSoi' );

		$remove[] = self::$_regexOnClick;




		$page = preg_replace("#(".implode(')|(',$remove).")#is",'',$page);



		
		$replace = array();

		$replaceBy = array();

		$replace[] = "#< *body#i";

		$replace[] = "#< */ *body#i";

		$replaceBy[] = "<div";

		$replaceBy[] = "</div";



		$page = preg_replace($replace,$replaceBy,$page);



	}
















	private function _replaceCSS(&$page,&$css){

		
		WExtension::includes( 'emogrifier' );



		$class = new Emogrifier($page,$css);

		$page = $class->emogrify($page);

	}










	private function _extractCSS(&$page,$url){

		$css = '';



		if ( !isset( self::$_regexCSS ) ) self::$_regexCSS = base64_decode( 'IzwgKmxpbmsuKmhyZWYgKj0gKiIoKD86KD8hIikuKSopIi4qPiNp' );



		

		if ( preg_match_all( self::$_regexCSS, $page, $results) ) {

			foreach( $results[0] as $key => $myResult ) {

				
				if (preg_match("#(stylesheet)|(text\/css)#i",$myResult)){

					$css .= $this->_convertCSS(file_get_contents($results[1][$key]),$results[1][$key]);

				}

			}

		}


		
		if (preg_match_all("#< *style *>((?:(?!< */ *style *>).)*)< */ *style *>#is",$page,$results)){

			foreach( $results[1] as $key => $myResult ) {

				$css .= $this->_convertCSS( $myResult, $url );

			}
		}


		return $css;

	}
















	private function _convertCSS($css,$url){



		$urls = explode('/',$url);

		$arguments = count($urls);

		
		
		if ($arguments > 3 AND strpos($urls[$arguments-1],'.') !== false){

			array_pop($urls);

		}



		$replace = array();

		$cssfolder = implode('/',$urls).'/';

		$i = 0;

		while(array_pop($urls)){

			$i++;

			$replace[str_repeat('../',$i)] = implode('/',$urls).'/';

		}

		
		
		krsort($replace);

		$css = str_replace(array_keys($replace),$replace,$css);



		
		if (preg_match_all("#@import *url *\( *\"((?:(?!\").)*)\"#i",$css,$results)){

			foreach($results[1] as $result){

				
				if (strpos($result,'http://') === false ) {

					$cssurl = $cssfolder.trim($result,"/");

				} else {

					$cssurl = $result;

				}

				
				$css .= $this->_convertCSS(file_get_contents($cssurl),$cssurl);

			}

			
			$css = preg_replace("#@import *url *\( *\"((?:(?!\").)*)\" *\) *;?#i",'',$css);

		}

		return $css;

	}















	private function _charset(&$page){



		$charset = '#charset.*=[a-z0-9_\-\.]+#i';

		if (!preg_match($charset,$page,$results)) return;

		
		$pageCharsets = explode('=',$results[0]);

		$pageCharset = $pageCharsets[1];



		$page = WPage::changeEncoding($page,$pageCharset,'utf-8');

	}

















	private function _completeURL(&$page,$urlPage) {

			$urls = explode('/',$urlPage);

			$arguments = count($urls);

			
			
			
			
			if ($arguments > 3 AND strpos($urls[$arguments-1],'.') !== false){

				array_pop($urls);

			};



			$website = implode('/',$urls).'/';



		$page = preg_replace('#(href|src|action)[ ]*=[ ]*\"(?!(https?://|\#|mailto:))(?:\.\./|\./|/)?#i','$1="'.$website,$page);

	}


}
