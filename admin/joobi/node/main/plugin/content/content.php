<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Main_Content_plugin extends WPlugin {










function onContentBeforeDisplay($context,&$article,&$params,$limitstart) {
		$tagC = WClass::get('output.process');
	if ( !empty($article->text) ) $tagC->replaceTags( $article->text );
	if ( !empty($article->introtext) ) $tagC->replaceTags( $article->introtext );
	$tagC->replaceTags( $article->title );

	return '';
}







function onPrepareContent(&$article,&$params,$limitstart) {
	return '';
}









function onBeforeDisplayContent(&$article,&$params,$limitstart) {
		$tagC = WClass::get('output.process');
	$tagC->replaceTags( $article->text );
	$tagC->replaceTags( $article->title );
	return '';
}









function onAfterContentSave(&$article,$isNew) {
	return true;
}
}