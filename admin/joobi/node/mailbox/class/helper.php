<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_Helper_class extends WClasses {

	private static $_regexOnClick = null;
	






	function decodeHeader($input){
        	        	$input = preg_replace('/(=\?[^?]+\?(q|b)\?[^?]*\?=)(\s)+=\?/i', '\1=?', $input);
		$this->charset = false;

		        	while (preg_match('/(=\?([^?]+)\?(q|b)\?([^?]*)\?=)/i', $input, $matches)) {
			$encoded  = $matches[1];
            		$charset  = $matches[2];
            		$encoding = $matches[3];
            		$text     = $matches[4];

            		switch (strtolower($encoding)) {
                		case 'b':
                    			$text = base64_decode($text);
                    			break;

                		case 'q':
                    			$text = str_replace('_', ' ', $text);
                    			preg_match_all('/=([a-f0-9]{2})/i', $text, $matches);
                    			foreach($matches[1] as $value)
                        			$text = str_replace('='.$value, chr(hexdec($value)), $text);
                    			break;
            		}
            		$this->charset = $charset;
            		$input = str_replace($encoded, $text, $input);
        	}

        	return $input;
    	}

	






    	function secureText($text){

		$remove = array();
				$pref = WPref::get('mailbox.node');
		if ($pref->getPref('removestyle',true)) $remove[] = "< *style(?:(?!< */ *style *>).)*< */ *style *>";
		if ($pref->getPref('removescript',true)){
			$remove[] = "< *script(?:(?!< */ *script *>).)*< */ *script *>";
			$remove[] = "< *link(?:(?!>).)*>";
			$remove[] = "< *head(?:(?!< */ *head *>).)*< */ *head *>";
			$remove[] = "< *object(?:(?!< */ *object *>).)*< */ *object *>";
			$remove[] = "< *embed(?:(?!< */ *embed *>).)*< */ *embed *>";
			$remove[] = "< *applet(?:(?!< */ *applet *>).)*< */ *applet *>";
			$remove[] = "< *noframes(?:(?!< */ *noframes *>).)*< */ *noframes *>";
			$remove[] = "< *noembed(?:(?!< */ *noembed *>).)*< */ *noembed *>";
			$remove[] = "< *noscript(?:(?!< */ *noscript *>).)*< */ *noscript *>";
			if ( !isset( self::$_regexOnClick ) ) self::$_regexOnClick = base64_decode( 'KG9uY2xpY2t8b25mb2N1c3xvbmxvYWQpICo9ICoiKD86KD8hIikuKSoi' );
			$remove[] = self::$_regexOnClick;
		}
		$remove[] = "< */ *html *>";
		$remove[] = ".*< *html *>";

		$replace = array();
		$replaceBy = array();
		$replace[] = "#< *body#i";
		$replace[] = "#< */ *body#i";
		$replace[] = "#(".implode(')|(',$remove).")#is";
		$replaceBy[] = "<div";
		$replaceBy[] = "</div";
		$replaceBy[] = '';

		$text = preg_replace($replace,$replaceBy,$text);

		return $text;
    	}

    	    	function incPath($path,$inc){
        	$newpath="";
        	$path_elements = explode(".",$path);
        	$limit = count($path_elements);
        	for($i=0;$i < $limit;$i++){
        		if ($i == $limit-1){             			$newpath .= $path_elements[$i]+$inc;         		}
        		else{
            			$newpath .= $path_elements[$i].".";         		}        	}        return $newpath;
    	}


    	   	function explodeBody($struct,$path="0",$inline=0){
    		$allParts = array();

       		if (empty($struct->parts)) return $allParts;

		$c=0;         	foreach($struct->parts as $part){
	        	if ($part->type==1){
	           			            		if ($part->subtype=="MIXED"){ 	            			$path = $this->incPath($path,1); 	            			$newpath = $path.".0"; 	            			$allParts = array_merge($this->explodeBody($part,$newpath),$allParts); 	            		}
	            		else{ 	            			$newpath = $this->incPath($path, 1);
	            			$path = $this->incPath($path,1);
	            			$allParts = array_merge($this->explodeBody($part,$newpath,1),$allParts);
	            		}	        	}
	        	else {
	            		$c++;
	            			            		if ($c==1 && $inline){
	            			$path = $path.".0";
	            		}
	            			            		$path = $this->incPath($path, 1);
	            			            		$allParts[$path] = $part;
	        	}        	}
        return $allParts;

    	}

    	function getMailParam($params,$name){
    		$searchIn = array();

		if ($params->ifparameters)
			$searchIn=array_merge($searchIn,$params->parameters);
		if ($params->ifdparameters)
			$searchIn=array_merge($searchIn,$params->dparameters);

		if (empty($searchIn)) return false;

		foreach($searchIn as $num => $values){
            		if (strtolower($values->attribute) == $name){
                		return $values->value;
			}
		}

    	}
	





    	function explodeObject($object){
    		if (!empty($object) AND (is_object($object) OR is_array($object))){
    			$string = '';
    			foreach($object as $name => $property){
    				$string .= '<tr><td>'.$name.'</td><td>'.$this->explodeObject($property).'<tr/>';
    			}
    		return '<table>'.$string.'</table>';
    		}

    	return (string) $object;
    	}
}