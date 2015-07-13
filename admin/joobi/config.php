<?php
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

//defined('JOOBI_SECURE') or define( 'JOOBI_SECURE', true );

class Joobi_Config{
public $model = array(
'tablename'=>'#__model_node'
);
public $table = array(
'tablename'=>'#__dataset_tables'
);
public $db = array(
'tablename'=>'#__dataset_node'
);
public $multiDB = false;
public $secret = 'JoobiDev';
}//endclass