<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Apps_CoreIframeclub_form extends WForms_default {
function show(){



$link='https://www.joobi.co/r.php?l=club';


$this->content='<iframe src="' . $link . '" width=1100 height=900 ></iframe>';



return true;

}}