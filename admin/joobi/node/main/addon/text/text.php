<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Text_addon extends WClasses {

	var $number = array('one','two','three','four','five','six','seven','eight','nine');

	var $operations = array('plus','minus','max','min');

	var $crypt = 'md5';

	var $options = array( 'crypt'=>null, 'life'=>null, 'maxuse'=>null );


	function __construct($options=null) {

		
		$this->number = array();
		for ($i = 1; $i < 10; $i++) {
			$this->number[$i] = $i;
		}

		$this->operations = array();
		$this->operations[] = '-';
		$this->operations[] = '+';
		$this->operations[] = 'max';
		$this->operations[] = 'min';

		parent::__construct();
	}




	function generate(&$html) {

		$question = $this->generate_question();

		switch($this->crypt) {
			case 'md5':
			case 'sha1':
			case 'crc32':
				$question[1] = hash( $this->crypt, strtolower($question[1]) );
			default:
				break;
		}
		$params['crypt'] = $this->crypt;
		$params['password'] = $question[1];
		$params['used'] = 1;


		$html = $question[0];
		return $params;
	}





	public function needInputBox() {
		return true;
	}





	function generate_question() {

		$query = WText::t('1424997296GVOP') . ': "';
		$answer = 0;
		$nbnumber = count($this->number);
		$op1 = mt_rand(1,$nbnumber);
		$op2 = mt_rand(1,$nbnumber);
		if ( $op2 == $op1 ) $op2 = mt_rand(0,$nbnumber);
		if ( $op2 == $op1 ) $op2 = mt_rand(0,$nbnumber);
		if ( $op2 == $op1 ) $op2 = mt_rand(0,$nbnumber);
		if ( $op2 == $op1 ) $op2 = mt_rand(0,$nbnumber);

		$operand = mt_rand( 0, count($this->operations)-1 );


				if ( $operand == 0 ) {
			if ( $op1 < $op2 ) {
				$tmp = $op1;
				$op1 = $op2;
				$op2 = $tmp;
			}		}

		switch($operand) {
			case 'minus':
			case 0:
			case '':
				$answer = $op1 - $op2;
				$query.= $this->number[$op1] . ' '. $this->operations[$operand] . ' ' . $this->number[$op2] . ' = ';
				break;
			case 'plus':
			case 1:
				$answer = $op1 + $op2;
				$query.= $this->number[$op1] . ' ' . $this->operations[$operand] . ' ' . $this->number[$op2] . ' = ';
				break;
			case 'min':
			case 3:
				if ( $op1 <= $op2 ) {
					$answer = $op1;
				} else {
					$answer = $op2;
				}
				$query.= WText::t('1424997296GVOQ') . ' '.$this->number[$op1] . ' ' . WText::t('1242282450QJDL') .  ' ' . $this->number[$op2].' ';
				break;
			case 'max':
			case 2:
			default:
				if ( $op1 >= $op2 ) {
					$answer = $op1;
				} else {
					$answer = $op2;
				}				$query.= WText::t('1424997297STJG') . ' '.$this->number[$op1] . ' ' . WText::t('1242282450QJDL') .  ' ' . $this->number[$op2].' ';
				break;
		}
		$query .= '"';

		return array( $query, $answer );

	}




	function clean($infos) {
				$captcha = WModel::get( 'main.captcha' );
		if ( !$captcha->delete($infos->cptid) ) {
			return false;
		}
	}





	function verify($id,$entered=null) {

				$captchaM = WModel::get( 'main.captcha' );
		$captchaM->whereE('cptid',$id);
		$infos = $captchaM->load('o');

		if ( !is_object($infos) ) {
						return false;
		}
		
		if ( isset($infos->params) && $infos->params!='' ) {
			$infos->p = array();
			$params = explode("\n",$this->params);
			if (is_array($params) && count($params)>0)
			{
				foreach($params as $param)
				{
					$p = explode('=', $param);
					if (is_array($p) && count($p) == 2)
						$infos->p[$p[0]] = $p[1];
				}
			}
			unset($infos->params);
		}

				if ($infos==null) return false;


		switch( $this->crypt ) {
			case 'md5':
			case 'sha1':
			case 'crc32':
				$entered = hash( $this->crypt, strtolower($entered) );
			default:
				break;
		}

		if ($infos->password === $entered)
		{
			return true;
		}

		return false;

	}
}