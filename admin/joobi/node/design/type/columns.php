<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Design_Columns_type extends WTypes {


	public $columns = array(



		'a1' => '--Populars' ,	
		'14' => 'VARCHAR',

		'15' => 'CHAR',

		'16' => 'TEXT',

		'25' => 'TINYINT',



		'a2' => '--Numbers',

		'1' => 'TINYINT',

		'2' => 'SMALLINT',

		'3' => 'MEDIUMINT',

		'4' => 'INT',

		'5' => 'BIGINT',

		'6' => 'FLOAT',

		'7' => 'DOUBLE',

		'8' => 'DECIMAL',



		'a3' => '--Dates',

		'9' => 'DATE',

		'10' => 'DATETIME',

		'11' => 'TIMESTAMP',

		'12' => 'TIME',

		'13' => 'YEAR',



		'a4' => '--Texts',

		'17' => 'TINYTEXT',

		'18' => 'MEDIUMTEXT',

		'19' => 'LONGTEXT',

		'20' => 'BLOB',

		'21' => 'TINYBLOB',

		'22' => 'MEDIUMBLOB',

		'23' => 'LONGBLOB',



		'a5' => '--Binaries',

		'24' => 'BOOL',

		'26' => 'BINARY',

		'27' => 'VARBINARY',



		'a6' => '--Sets',

		'28' => 'ENUM',

		'29' => 'SET',



		'a9' => '-- Special Fields',

		'30' => 'SMART FIELD'

	  );
}