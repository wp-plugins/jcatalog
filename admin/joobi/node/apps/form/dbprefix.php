<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_CoreDbprefix_form extends WForms_default {
function show(){

$this->content=JOOBI_DB_PREFIX;

return true;





}
}