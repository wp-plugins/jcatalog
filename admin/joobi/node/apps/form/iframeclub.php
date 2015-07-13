<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_CoreIframeclub_form extends WForms_default {
function show(){



$link='https://www.joobi.co/r.php?l=club';


$this->content='<iframe src="' . $link . '" width=1100 height=900 ></iframe>';



return true;

}}