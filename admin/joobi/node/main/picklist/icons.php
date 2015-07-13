<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');







class Main_Icons_picklist extends WPicklist {


	function create() {



		
		WPage::addCSSFile( 'fonts/font-awesome/css/font-awesome.css', 'theme', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );


		$listA = array();

		$listA['fa-adjust'] = true;
		$listA['fa-adn'] = true;
		$listA['fa-align-center'] = true;
		$listA['fa-align-justify'] = true;
		$listA['fa-align-left'] = true;
		$listA['fa-align-right'] = true;
		$listA['fa-ambulance'] = true;
		$listA['fa-anchor'] = true;
		$listA['fa-android'] = true;
		$listA['fa-angle-double-down'] = true;
		$listA['fa-angle-double-left'] = true;
		$listA['fa-angle-double-right'] = true;
		$listA['fa-angle-double-up'] = true;
		$listA['fa-angle-down'] = true;
		$listA['fa-angle-left'] = true;
		$listA['fa-angle-right'] = true;
		$listA['fa-angle-up'] = true;
		$listA['fa-apple'] = true;
		$listA['fa-archive'] = true;
		$listA['fa-arrow-circle-down'] = true;
		$listA['fa-arrow-circle-left'] = true;
		$listA['fa-arrow-circle-o-down'] = true;
		$listA['fa-arrow-circle-o-left'] = true;
		$listA['fa-arrow-circle-o-right'] = true;
		$listA['fa-arrow-circle-o-up'] = true;
		$listA['fa-arrow-circle-right'] = true;
		$listA['fa-arrow-circle-up'] = true;
		$listA['fa-arrow-down'] = true;
		$listA['fa-arrow-left'] = true;
		$listA['fa-arrow-right'] = true;
		$listA['fa-arrow-up'] = true;
		$listA['fa-arrows'] = true;
		$listA['fa-arrows-alt'] = true;
		$listA['fa-arrows-h'] = true;
		$listA['fa-arrows-v'] = true;
		$listA['fa-asterisk'] = true;
		$listA['fa-automobile'] = true;
		$listA['fa-backward'] = true;
		$listA['fa-ban'] = true;
		$listA['fa-bank'] = true;
		$listA['fa-bar-chart-o'] = true;
		$listA['fa-barcode'] = true;
		$listA['fa-bars'] = true;
		$listA['fa-beer'] = true;
		$listA['fa-behance'] = true;
		$listA['fa-behance-square'] = true;
		$listA['fa-bell'] = true;
		$listA['fa-bell-o'] = true;
		$listA['fa-bitbucket'] = true;
		$listA['fa-bitbucket-square'] = true;
		$listA['fa-bitcoin'] = true;
		$listA['fa-bold'] = true;
		$listA['fa-bolt'] = true;
		$listA['fa-bomb'] = true;
		$listA['fa-book'] = true;
		$listA['fa-bookmark'] = true;
		$listA['fa-bookmark-o'] = true;
		$listA['fa-briefcase'] = true;
		$listA['fa-btc'] = true;
		$listA['fa-bug'] = true;
		$listA['fa-building'] = true;
		$listA['fa-building-o'] = true;
		$listA['fa-bullhorn'] = true;
		$listA['fa-bullseye'] = true;
		$listA['fa-cab'] = true;
		$listA['fa-calendar'] = true;
		$listA['fa-calendar-o'] = true;
		$listA['fa-camera'] = true;
		$listA['fa-camera-retro'] = true;
		$listA['fa-car'] = true;
		$listA['fa-caret-down'] = true;
		$listA['fa-caret-left'] = true;
		$listA['fa-caret-right'] = true;
		$listA['fa-caret-square-o-down'] = true;
		$listA['fa-caret-square-o-left'] = true;
		$listA['fa-caret-square-o-right'] = true;
		$listA['fa-caret-square-o-up'] = true;
		$listA['fa-caret-up'] = true;
		$listA['fa-certificate'] = true;
		$listA['fa-chain'] = true;
		$listA['fa-chain-broken'] = true;
		$listA['fa-check'] = true;
		$listA['fa-check-circle'] = true;
		$listA['fa-check-circle-o'] = true;
		$listA['fa-check-square'] = true;
		$listA['fa-check-square-o'] = true;
		$listA['fa-chevron-circle-down'] = true;
		$listA['fa-chevron-circle-left'] = true;
		$listA['fa-chevron-circle-right'] = true;
		$listA['fa-chevron-circle-up'] = true;
		$listA['fa-chevron-down'] = true;
		$listA['fa-chevron-left'] = true;
		$listA['fa-chevron-right'] = true;
		$listA['fa-chevron-up'] = true;
		$listA['fa-child'] = true;
		$listA['fa-circle'] = true;
		$listA['fa-circle-o'] = true;
		$listA['fa-circle-o-notch'] = true;
		$listA['fa-circle-thin'] = true;
		$listA['fa-clipboard'] = true;
		$listA['fa-clock-o'] = true;
		$listA['fa-cloud'] = true;
		$listA['fa-cloud-download'] = true;
		$listA['fa-cloud-upload'] = true;
		$listA['fa-cny'] = true;
		$listA['fa-code'] = true;
		$listA['fa-code-fork'] = true;
		$listA['fa-codepen'] = true;
		$listA['fa-coffee'] = true;
		$listA['fa-cog'] = true;
		$listA['fa-cogs'] = true;
		$listA['fa-columns'] = true;
		$listA['fa-comment'] = true;
		$listA['fa-comment-o'] = true;
		$listA['fa-comments'] = true;
		$listA['fa-comments-o'] = true;
		$listA['fa-compass'] = true;
		$listA['fa-compress'] = true;
		$listA['fa-copy'] = true;
		$listA['fa-credit-card'] = true;
		$listA['fa-crop'] = true;
		$listA['fa-crosshairs'] = true;
		$listA['fa-css3'] = true;
		$listA['fa-cube'] = true;
		$listA['fa-cubes'] = true;
		$listA['fa-cut'] = true;
		$listA['fa-cutlery'] = true;
		$listA['fa-dashboard'] = true;
		$listA['fa-database'] = true;
		$listA['fa-dedent'] = true;
		$listA['fa-delicious'] = true;
		$listA['fa-desktop'] = true;
		$listA['fa-deviantart'] = true;
		$listA['fa-digg'] = true;
		$listA['fa-dollar'] = true;
		$listA['fa-dot-circle-o'] = true;
		$listA['fa-download'] = true;
		$listA['fa-dribbble'] = true;
		$listA['fa-dropbox'] = true;
		$listA['fa-drupal'] = true;
		$listA['fa-edit'] = true;
		$listA['fa-eject'] = true;
		$listA['fa-ellipsis-h'] = true;
		$listA['fa-ellipsis-v'] = true;
		$listA['fa-empire'] = true;
		$listA['fa-envelope'] = true;
		$listA['fa-envelope-o'] = true;
		$listA['fa-envelope-square'] = true;
		$listA['fa-eraser'] = true;
		$listA['fa-eur'] = true;
		$listA['fa-euro'] = true;
		$listA['fa-exchange'] = true;
		$listA['fa-exclamation'] = true;
		$listA['fa-exclamation-circle'] = true;
		$listA['fa-exclamation-triangle'] = true;
		$listA['fa-expand'] = true;
		$listA['fa-external-link'] = true;
		$listA['fa-external-link-square'] = true;
		$listA['fa-eye'] = true;
		$listA['fa-eye-slash'] = true;
		$listA['fa-facebook'] = true;
		$listA['fa-facebook-square'] = true;
		$listA['fa-fast-backward'] = true;
		$listA['fa-fast-forward'] = true;
		$listA['fa-fax'] = true;
		$listA['fa-female'] = true;
		$listA['fa-fighter-jet'] = true;
		$listA['fa-file'] = true;
		$listA['fa-file-archive-o'] = true;
		$listA['fa-file-audio-o'] = true;
		$listA['fa-file-code-o'] = true;
		$listA['fa-file-excel-o'] = true;
		$listA['fa-file-image-o'] = true;
		$listA['fa-file-movie-o'] = true;
		$listA['fa-file-o'] = true;
		$listA['fa-file-pdf-o'] = true;
		$listA['fa-file-photo-o'] = true;
		$listA['fa-file-picture-o'] = true;
		$listA['fa-file-powerpoint-o'] = true;
		$listA['fa-file-sound-o'] = true;
		$listA['fa-file-text'] = true;
		$listA['fa-file-text-o'] = true;
		$listA['fa-file-video-o'] = true;
		$listA['fa-file-word-o'] = true;
		$listA['fa-file-zip-o'] = true;
		$listA['fa-files-o'] = true;
		$listA['fa-film'] = true;
		$listA['fa-filter'] = true;
		$listA['fa-fire'] = true;
		$listA['fa-fire-extinguisher'] = true;
		$listA['fa-flag'] = true;
		$listA['fa-flag-checkered'] = true;
		$listA['fa-flag-o'] = true;
		$listA['fa-flash'] = true;
		$listA['fa-flask'] = true;
		$listA['fa-flickr'] = true;
		$listA['fa-floppy-o'] = true;
		$listA['fa-folder'] = true;
		$listA['fa-folder-o'] = true;
		$listA['fa-folder-open'] = true;
		$listA['fa-folder-open-o'] = true;
		$listA['fa-font'] = true;
		$listA['fa-forward'] = true;
		$listA['fa-foursquare'] = true;
		$listA['fa-frown-o'] = true;
		$listA['fa-gamepad'] = true;
		$listA['fa-gavel'] = true;
		$listA['fa-gbp'] = true;
		$listA['fa-ge'] = true;
		$listA['fa-gear'] = true;
		$listA['fa-gears'] = true;
		$listA['fa-gift'] = true;
		$listA['fa-git'] = true;
		$listA['fa-git-square'] = true;
		$listA['fa-github'] = true;
		$listA['fa-github-alt'] = true;
		$listA['fa-github-square'] = true;
		$listA['fa-gittip'] = true;
		$listA['fa-glass'] = true;
		$listA['fa-globe'] = true;
		$listA['fa-google'] = true;
		$listA['fa-google-plus'] = true;
		$listA['fa-google-plus-square'] = true;
		$listA['fa-graduation-cap'] = true;
		$listA['fa-group'] = true;
		$listA['fa-h-square'] = true;
		$listA['fa-hacker-news'] = true;
		$listA['fa-hand-o-down'] = true;
		$listA['fa-hand-o-left'] = true;
		$listA['fa-hand-o-right'] = true;
		$listA['fa-hand-o-up'] = true;
		$listA['fa-hdd-o'] = true;
		$listA['fa-header'] = true;
		$listA['fa-headphones'] = true;
		$listA['fa-heart'] = true;
		$listA['fa-heart-o'] = true;
		$listA['fa-history'] = true;
		$listA['fa-home'] = true;
		$listA['fa-hospital-o'] = true;
		$listA['fa-html5'] = true;
		$listA['fa-image'] = true;
		$listA['fa-inbox'] = true;
		$listA['fa-indent'] = true;
		$listA['fa-info'] = true;
		$listA['fa-info-circle'] = true;
		$listA['fa-inr'] = true;
		$listA['fa-instagram'] = true;
		$listA['fa-institution'] = true;
		$listA['fa-italic'] = true;
		$listA['fa-joomla'] = true;
		$listA['fa-jpy'] = true;
		$listA['fa-jsfiddle'] = true;
		$listA['fa-key'] = true;
		$listA['fa-keyboard-o'] = true;
		$listA['fa-krw'] = true;
		$listA['fa-language'] = true;
		$listA['fa-laptop'] = true;
		$listA['fa-leaf'] = true;
		$listA['fa-legal'] = true;
		$listA['fa-lemon-o'] = true;
		$listA['fa-level-down'] = true;
		$listA['fa-level-up'] = true;
		$listA['fa-life-bouy'] = true;
		$listA['fa-life-ring'] = true;
		$listA['fa-life-saver'] = true;
		$listA['fa-lightbulb-o'] = true;
		$listA['fa-link'] = true;
		$listA['fa-linkedin'] = true;
		$listA['fa-linkedin-square'] = true;
		$listA['fa-linux'] = true;
		$listA['fa-list'] = true;
		$listA['fa-list-alt'] = true;
		$listA['fa-list-ol'] = true;
		$listA['fa-list-ul'] = true;
		$listA['fa-location-arrow'] = true;
		$listA['fa-lock'] = true;
		$listA['fa-long-arrow-down'] = true;
		$listA['fa-long-arrow-left'] = true;
		$listA['fa-long-arrow-right'] = true;
		$listA['fa-long-arrow-up'] = true;
		$listA['fa-magic'] = true;
		$listA['fa-magnet'] = true;
		$listA['fa-mail-forward'] = true;
		$listA['fa-mail-reply'] = true;
		$listA['fa-mail-reply-all'] = true;
		$listA['fa-male'] = true;
		$listA['fa-map-marker'] = true;
		$listA['fa-maxcdn'] = true;
		$listA['fa-medkit'] = true;
		$listA['fa-meh-o'] = true;
		$listA['fa-microphone'] = true;
		$listA['fa-microphone-slash'] = true;
		$listA['fa-minus'] = true;
		$listA['fa-minus-circle'] = true;
		$listA['fa-minus-square'] = true;
		$listA['fa-minus-square-o'] = true;
		$listA['fa-mobile'] = true;
		$listA['fa-mobile-phone'] = true;
		$listA['fa-money'] = true;
		$listA['fa-moon-o'] = true;
		$listA['fa-mortar-board'] = true;
		$listA['fa-music'] = true;
		$listA['fa-navicon'] = true;
		$listA['fa-openid'] = true;
		$listA['fa-outdent'] = true;
		$listA['fa-pagelines'] = true;
		$listA['fa-paper-plane'] = true;
		$listA['fa-paper-plane-o'] = true;
		$listA['fa-paperclip'] = true;
		$listA['fa-paragraph'] = true;
		$listA['fa-paste'] = true;
		$listA['fa-pause'] = true;
		$listA['fa-paw'] = true;
		$listA['fa-pencil'] = true;
		$listA['fa-pencil-square'] = true;
		$listA['fa-pencil-square-o'] = true;
		$listA['fa-phone'] = true;
		$listA['fa-phone-square'] = true;
		$listA['fa-photo'] = true;
		$listA['fa-picture-o'] = true;
		$listA['fa-pied-piper'] = true;
		$listA['fa-pied-piper-alt'] = true;
		$listA['fa-pied-piper-square'] = true;
		$listA['fa-pinterest'] = true;
		$listA['fa-pinterest-square'] = true;
		$listA['fa-plane'] = true;
		$listA['fa-play'] = true;
		$listA['fa-play-circle'] = true;
		$listA['fa-play-circle-o'] = true;
		$listA['fa-plus'] = true;
		$listA['fa-plus-circle'] = true;
		$listA['fa-plus-square'] = true;
		$listA['fa-plus-square-o'] = true;
		$listA['fa-power-off'] = true;
		$listA['fa-print'] = true;
		$listA['fa-puzzle-piece'] = true;
		$listA['fa-qq'] = true;
		$listA['fa-qrcode'] = true;
		$listA['fa-question'] = true;
		$listA['fa-question-circle'] = true;
		$listA['fa-quote-left'] = true;
		$listA['fa-quote-right'] = true;
		$listA['fa-ra'] = true;
		$listA['fa-random'] = true;
		$listA['fa-rebel'] = true;
		$listA['fa-recycle'] = true;
		$listA['fa-reddit'] = true;
		$listA['fa-reddit-square'] = true;
		$listA['fa-refresh'] = true;
		$listA['fa-renren'] = true;
		$listA['fa-reorder'] = true;
		$listA['fa-repeat'] = true;
		$listA['fa-reply'] = true;
		$listA['fa-reply-all'] = true;
		$listA['fa-retweet'] = true;
		$listA['fa-rmb'] = true;
		$listA['fa-road'] = true;
		$listA['fa-rocket'] = true;
		$listA['fa-rotate-left'] = true;
		$listA['fa-rotate-right'] = true;
		$listA['fa-rouble'] = true;
		$listA['fa-rss'] = true;
		$listA['fa-rss-square'] = true;
		$listA['fa-rub'] = true;
		$listA['fa-ruble'] = true;
		$listA['fa-rupee'] = true;
		$listA['fa-save'] = true;
		$listA['fa-scissors'] = true;
		$listA['fa-search'] = true;
		$listA['fa-search-minus'] = true;
		$listA['fa-search-plus'] = true;
		$listA['fa-send'] = true;
		$listA['fa-send-o'] = true;
		$listA['fa-share'] = true;
		$listA['fa-share-alt'] = true;
		$listA['fa-share-alt-square'] = true;
		$listA['fa-share-square'] = true;
		$listA['fa-share-square-o'] = true;
		$listA['fa-shield'] = true;
		$listA['fa-shopping-cart'] = true;
		$listA['fa-sign-in'] = true;
		$listA['fa-sign-out'] = true;
		$listA['fa-signal'] = true;
		$listA['fa-sitemap'] = true;
		$listA['fa-skype'] = true;
		$listA['fa-slack'] = true;
		$listA['fa-sliders'] = true;
		$listA['fa-smile-o'] = true;
		$listA['fa-sort'] = true;
		$listA['fa-sort-alpha-asc'] = true;
		$listA['fa-sort-alpha-desc'] = true;
		$listA['fa-sort-amount-asc'] = true;
		$listA['fa-sort-amount-desc'] = true;
		$listA['fa-sort-asc'] = true;
		$listA['fa-sort-desc'] = true;
		$listA['fa-sort-down'] = true;
		$listA['fa-sort-numeric-asc'] = true;
		$listA['fa-sort-numeric-desc'] = true;
		$listA['fa-sort-up'] = true;
		$listA['fa-soundcloud'] = true;
		$listA['fa-space-shuttle'] = true;
		$listA['fa-spinner'] = true;
		$listA['fa-spoon'] = true;
		$listA['fa-spotify'] = true;
		$listA['fa-square'] = true;
		$listA['fa-square-o'] = true;
		$listA['fa-stack-exchange'] = true;
		$listA['fa-stack-overflow'] = true;
		$listA['fa-star'] = true;
		$listA['fa-star-half'] = true;
		$listA['fa-star-half-empty'] = true;
		$listA['fa-star-half-full'] = true;
		$listA['fa-star-half-o'] = true;
		$listA['fa-star-o'] = true;
		$listA['fa-steam'] = true;
		$listA['fa-steam-square'] = true;
		$listA['fa-step-backward'] = true;
		$listA['fa-step-forward'] = true;
		$listA['fa-stethoscope'] = true;
		$listA['fa-stop'] = true;
		$listA['fa-strikethrough'] = true;
		$listA['fa-stumbleupon'] = true;
		$listA['fa-stumbleupon-circle'] = true;
		$listA['fa-subscript'] = true;
		$listA['fa-suitcase'] = true;
		$listA['fa-sun-o'] = true;
		$listA['fa-superscript'] = true;
		$listA['fa-support'] = true;
		$listA['fa-table'] = true;
		$listA['fa-tablet'] = true;
		$listA['fa-tachometer'] = true;
		$listA['fa-tag'] = true;
		$listA['fa-tags'] = true;
		$listA['fa-tasks'] = true;
		$listA['fa-taxi'] = true;
		$listA['fa-tencent-weibo'] = true;
		$listA['fa-terminal'] = true;
		$listA['fa-text-height'] = true;
		$listA['fa-text-width'] = true;
		$listA['fa-th'] = true;
		$listA['fa-th-large'] = true;
		$listA['fa-th-list'] = true;
		$listA['fa-thumb-tack'] = true;
		$listA['fa-thumbs-down'] = true;
		$listA['fa-thumbs-o-down'] = true;
		$listA['fa-thumbs-o-up'] = true;
		$listA['fa-thumbs-up'] = true;
		$listA['fa-ticket'] = true;
		$listA['fa-times'] = true;
		$listA['fa-times-circle'] = true;
		$listA['fa-times-circle-o'] = true;
		$listA['fa-tint'] = true;
		$listA['fa-toggle-down'] = true;
		$listA['fa-toggle-left'] = true;
		$listA['fa-toggle-right'] = true;
		$listA['fa-toggle-up'] = true;
		$listA['fa-trash-o'] = true;
		$listA['fa-tree'] = true;
		$listA['fa-trello'] = true;
		$listA['fa-trophy'] = true;
		$listA['fa-truck'] = true;
		$listA['fa-try'] = true;
		$listA['fa-tumblr'] = true;
		$listA['fa-tumblr-square'] = true;
		$listA['fa-turkish-lira'] = true;
		$listA['fa-twitter'] = true;
		$listA['fa-twitter-square'] = true;
		$listA['fa-umbrella'] = true;
		$listA['fa-underline'] = true;
		$listA['fa-undo'] = true;
		$listA['fa-university'] = true;
		$listA['fa-unlink'] = true;
		$listA['fa-unlock'] = true;
		$listA['fa-unlock-alt'] = true;
		$listA['fa-unsorted'] = true;
		$listA['fa-upload'] = true;
		$listA['fa-usd'] = true;
		$listA['fa-user'] = true;
		$listA['fa-user-md'] = true;
		$listA['fa-users'] = true;
		$listA['fa-video-camera'] = true;
		$listA['fa-vimeo-square'] = true;
		$listA['fa-vine'] = true;
		$listA['fa-vk'] = true;
		$listA['fa-volume-down'] = true;
		$listA['fa-volume-off'] = true;
		$listA['fa-language'] = true;
		$listA['fa-warning'] = true;
		$listA['fa-wechat'] = true;
		$listA['fa-weibo'] = true;
		$listA['fa-weixin'] = true;
		$listA['fa-wheelchair'] = true;
		$listA['fa-windows'] = true;
		$listA['fa-won'] = true;
		$listA['fa-wordpress'] = true;
		$listA['fa-wrench'] = true;
		$listA['fa-xing'] = true;
		$listA['fa-xing-square'] = true;
		$listA['fa-yahoo'] = true;
		$listA['fa-yen'] = true;
		$listA['fa-youtube'] = true;
		$listA['fa-youtube-play'] = true;
		$listA['fa-youtube-square'] = true;






		if ( $this->onlyOneValue() ) {

			$defaults = $this->getDefault();

			if ( empty($defaults) ) return false;



			if ( isset( $listA[ $defaults ] ) ) {

				$this->addElement( $defaults , '<i class="fa ' . $defaults . ' fa-3x"></i> ' );

			}
		} else {





			
			$this->addElement( '', WText::t('1206732410ICCJ') );




			$css = '';

			foreach( $listA as $oneKey => $oneVal ) {

				$css .= '.' . $oneKey . ':before{padding:5px;}';
				$onjClass = new stdClass;
				$onjClass->class = 'fancyPicklist fa ' . $oneKey . ' fa-lg';

				$this->addElement( $oneKey, $oneKey, $onjClass );

			}


			WPage::addCSS( '.fancyPicklist{display: block;}' . $css );





		}




		return true;



	}}