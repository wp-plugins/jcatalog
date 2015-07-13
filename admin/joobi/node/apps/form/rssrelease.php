<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_CoreRssrelease_form extends WForms_default {


	function create(){





		switch ( JOOBI_FRAMEWORK_TYPE){

			case 'joomla':

				$headerSize='2';

				break;

			default:

				$headerSize='3';

				break;

		}


		$this->content=WText::t('1426726331GHCC');

		
		

		$xml='http://joobi.co/r.php?l=rssreleasenote';

		if( ! class_exists( 'DOMDocument' )){
			$this->userN('1433250437OEYO');
			return false;
		}
		$xmlDoc=new DOMDocument();

		@$xmlDoc->load( $xml );



		if( empty($xmlDoc)) return;


		
		$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
		if( empty($channel)) return;



		$channel_title=$channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;

		$channel_link=$channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;

		$channel_desc=$channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;



		$html='';

		
		
		
		


		
		$x=$xmlDoc->getElementsByTagName('item');

		$maxFeed=6;



		for( $i=0; $i<=$maxFeed; $i++){



			$item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;

			$item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;

			$item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;



			$html .='<p><a href="' . $item_link . '" target="_blank"><h' . $headerSize . '><span style="background-color:#0C8EC2;font-size: 18px;line-height:25px;" class="badge">' . ( $i+1 ) . '</span> ' . $item_title . '</h' . $headerSize . '></a>';

			$html .="<br>";



			$item_desc=str_replace( '<img src="', '<img width="200px;" style="padding:10px;" align="left" src="', $item_desc );

			$item_desc=str_replace( '<br /><a href=', '<div style="clear:both;"></div><a class="btn btn-success" target="_blank" href=', $item_desc );

			$item_desc=str_replace( '<a href="', '<a target="_blank" href="', $item_desc );




			$html .=$item_desc . "</p>";

			$html .='<div style="clear:both;"></div>';



			if( $i < $maxFeed ) $html .='<hr style="margin-top: 20px;">';	


		}


		$this->content=$html;



		return true;



	}




	function show(){

		return $this->create();

	}
}