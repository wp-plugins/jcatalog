<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Design_System_class extends WClasses {

			protected $useCore = false;

				var $chmodSet='0777';	var $safeSet=false;	var $use_same_rightsSet=true;
		var $generalHeader="<?php defined('JOOBI_SECURE') or die('J....');\n";
	var $generalBottom="\n}";

		var $fileCodeType='';	var $fileCodeClassExtends = '';
	var $headAddImport = true;
	
		var $saveMssS='';
	var $saveMssE='';
	var $deleteMssS='';
	var $deleteMssE='';
	var $loadMssW='';


		var $fileParts=array();
	var $headBoundary='class';	var $botBoundary='}';	var $className='';
		var $name='';
	var $description='';
	var $code='';

		var $folder='';	var $fileP='';	var $type='';
	var $fileLocation='';
	var $extendsclass='';
	var $defaultextendsclass='';
	var $overwrite=true;
	var $line=0;

		var $contentType = 'php';
		var $automaticComments = true;

		var $message;
	var $hl = null;



	


	function __construct() {
		
				$this->saveMssE = WText::t('1220263310JRFM');
		$this->deleteMssS = WText::t('1220263310JRFN');
		$this->deleteMssE = WText::t('1220263310JRFO');
		$this->loadMssW = WText::t('1220263310JRFP');

		$this->hl = WGet::file();
	}

	function getLine() {
		return $this->line;
	}
	





	function _deleteFile() {

				$tabExt=explode( '.', $this->fileLocation );
		if ( !empty($tabExt[0]) && empty($tabExt[1]) ) $tabExt[1] = 'node';

		if ( empty($tabExt[0]) || empty($tabExt[1]) || empty($this->folder) ) {
			$this->userW('1220215906LFIQ');
			return false;
		}
		else $this->fileP = JOOBI_DS_USER . 'node' . DS . $tabExt[0] . DS . $this->folder . DS . $tabExt[1].'.php';

				if ( $this->fileP!='' && $this->hl->exist($this->fileP) )
		{
			if ( $this->hl->delete($this->fileP) )
			{
				$mess = $this->deleteMssS;
 				$this->userS($mess);
 				return true;
			} else {
				$mess = $this->deleteMssE;
 				$this->userE($mess);
 				return false;
			}
		} else {
												return true;
		}
	}








	function getSQL4ExtFile($eid,$modelName,$PK,$select=array()) {
		static $objectA=array();
		if ( !isset($objectA[$eid.$modelName.'-'.$PK]) ) {
						$modelM=WModel::get($modelName);
			if (empty($select)) $select = array( 'params', 'yid' );
			$modelM->select($select);
			$modelM->whereE($PK,$eid);
			$objectA[$eid.$modelName.'-'.$PK]=$modelM->load('o');
		}
		return $objectA[$eid.$modelName.'-'.$PK];
	}







	function setupVariables() {

		$this->fileParts[0]=$this->generalHeader."\n"; 		$this->fileParts[10]='class '; 		$this->fileParts[20]='_'.$this->fileCodeType.' {'; 		$this->fileParts[200]=$this->generalBottom; 		$this->defaultextendsclass = $this->fileCodeClassExtends; 		$this->headBoundary = $this->headBoundary;
		$this->botBoundary='}';		$this->folder=$this->fileCodeType; 
		return true;
	}








	function getImport($extendsclass){
		return '';
	}





	function filePathSetVar($subfolder='') {

		if ( $this->type!='' && ( $this->type!=3 && $this->type!=4 ) ) return '';
		if ( $this->fileLocation=='' ) return '';

				$match = $this->setupVariables();

		if ( !empty($subfolder) ) $this->folder = $this->folder. DS . $subfolder;

				$tabExt = explode('.',$this->fileLocation);
		if ( !empty($tabExt[0]) && empty($tabExt[1]) ) $tabExt[1]='node';

		if ( empty($tabExt[0]) || empty($tabExt[1]) || $match==false ) {
			$this->userW('1220263310JRFR');
			return '';
		}

		$this->fileP = JOOBI_DS_USER . 'node' . DS . $tabExt[0] . DS .  $this->folder . DS . $tabExt[1] . '.' . $this->contentType;

								$tabExt[0]=ucfirst($tabExt[0]);
		$tabExt[1]=ucfirst($tabExt[1]);
		if ( empty($this->className) ) {
			$this->className = $tabExt[0];
			if ( $this->useCore ) $this->className .= '_Core';
			else  $this->className .= '_';
			$this->className .= $tabExt[1];
		}
				if ( $this->fileCodeType=='controller' ) $this->className = $tabExt[1];

		$this->className = str_replace( '-', '_', $this->className );

		return true;

	}








	function _saveFile($subfolder='') {

		
				$eid = WGlobals::getEID();
		if ( empty($eid) ) $this->overwrite=false;

				if ( !empty($this->fileP) && ( $this->hl->exist($this->fileP) && $this->overwrite ) ){
						$currentContent=$this->hl->read($this->fileP);
			$struct=$this->_getStruct($currentContent);
			if ($struct) {
				$content = $this->_buildContent($this->code);
				return $this->_recordFile( $content, 'force', $this->code);
			}		} else {
						$content = $this->_buildContent($this->code);				return $this->_recordFile( $content, 'write', $this->code );
		}	}







	function _recordFile($content,$action,$codeerror) {
		if ( $this->hl->write( $this->fileP, $content, $action, $this->chmodSet, $this->safeSet, $this->use_same_rightsSet ) ) {
 			return true;
		} else {
			$mess = $this->saveMssE.' File : '. $this->fileP.' Code : '.$codeerror;
 			$this->userE($mess);
 			return false;
		}
	}





	function _buildContent($code) {

		static $finalReservedFunctionsA=array();

		if ( $this->contentType =='html' ) return $code;

				$codingRulesA = array();
		$codingRulesA['function & '] = 'function &';
		$codingRulesA['function& '] = 'function &';
		$codingRulesA['switch('] = 'switch (';
		$codingRulesA['foreach('] = 'foreach(';
		$codingRulesA["'://"] = "': //";			$codingRulesA[")://"] = "): //";			$codingRulesA['if ('] = 'if (';
		$codingRulesA['){'] = ') {';
		$codingRulesA['} else {'] = '} else {';
		$code = str_replace( array_keys($codingRulesA), $codingRulesA, $code );

		if ( empty($finalReservedFunctionsA) ) {

												$fucntionNameA = array( 'addElement', 'onlyOneValue' );

									$newinstance = new WQuery;
			$fucntionNameA = array_merge( $fucntionNameA,get_class_methods($newinstance));
			$newinstance = new WTable;
			$fucntionNameA = array_merge( $fucntionNameA,get_class_methods($newinstance));
			$newinstance = new WModel;
			$fucntionNameA = array_merge( $fucntionNameA,get_class_methods($newinstance));

						$keepThoseFunctionsA = array('add','edit','save','validate','addValidate','editValidate',
			'extra','addExtra','editExtra','copy','copyValidate','copyExtra','delete','deleteValidate','deleteExtra',
			 'getPossibleTypes', 'getItemTypeColumn' );

			$fucntionNameA = array_diff( $fucntionNameA, $keepThoseFunctionsA );
			$newinstance = new WMessage;
			$fucntionNameA = array_merge( $fucntionNameA,get_class_methods($newinstance));

						foreach( $fucntionNameA as $key => $val ) {
				if ( $val[0]=='_' ) continue;
				else $finalReservedFunctionsA[] = $val;
			}
		}
				foreach( $finalReservedFunctionsA as $reservedFct ) {
			$count1 = substr_count( $code, 'function ' . $reservedFct .'(' );
			$count2 = substr_count( $code, 'function &' . $reservedFct .'(' );
			if ( $count1>0 || $count2>0 ) { 				$RESERVED_FUNCTION = $reservedFct;
				$this->userE('1309938525PUJW',array('$RESERVED_FUNCTION'=>$RESERVED_FUNCTION));
								if ($count1>0) $code = str_replace( 'function ' . $reservedFct .'(', 'function ' . $reservedFct.'Reserved(', $code );
				else $code = str_replace( 'function &' . $reservedFct .'(', 'function &' . $reservedFct.'Reserved(', $code );
				$count1=$count2=0;
			}		}

		$header=$this->_buildHead();
		$bottom=$this->fileParts[200];
		return $header.$code.$bottom;	
	}
	






	function _buildStruct()
	{
		$content=array();
		$this->fileParts[15]='\'BuiltClassName\'';
		ksort($this->fileParts);
		$head=array();
		$bot=array();
		foreach($this->fileParts as $ind => $val)
		{
			if ($ind<='50') $head[$ind]=$val;
			if ($ind>='100') $bot[$ind]=$val;
		}

		$content[0]=implode('',$head);
		$content[1]='';
		$content[2]=implode('',$bot);

		return $content;
	}






	function _buildHead() {

		$member=WUser::get();
		if ( empty($this->extendsclass) && !empty($this->defaultextendsclass) ) $this->extendsclass = $this->defaultextendsclass;

		if ( !empty($this->extendsclass) ) $this->fileParts[20] = str_replace(' {', ' extends '.$this->extendsclass.' {', $this->fileParts[20]);

		$content = $this->fileParts[0];
		if ( $this->automaticComments ) {
			$content .= '/**';
			$content .= '* <p>'. $this->name .'</p>';
			$content .= '* <p>'. $this->description .'</p>';
			$content .= '* @author '.$member->username; 			$content .= '*/';
		}
		if (!empty($this->extendsclass) && $this->headAddImport ) {
			$import = $this->getImport($this->extendsclass);
			if ( !empty($import) ) $content .= $import .'';
		}		if ( !empty($this->className) ) $content .= "\n" . $this->fileParts[10] . $this->className . $this->fileParts[20] ."\n";

		return $content;
	}








	function _getExtendsClass($currentContent,$noEndTag=false) {
		$pos = strpos($currentContent,'extends ');
		if ($pos==0) return '';
		else {
			$newcontent = substr( $currentContent, $pos );
			$pos = strpos( $newcontent, ' {' );

			if ($pos==0 && !$noEndTag ){
				$fileP = $this->fileP;
				$SHOWFILEP = $fileP;
				$this->userW('1263970750NGKF',array('$SHOWFILEP'=>$SHOWFILEP));
				return false;
			}			return substr($newcontent,8,$pos-8);
		}
	}









	function _getStruct($currentContent) {

		if ( $this->contentType == 'html' ) {
			$struct[0] = '';
			$struct[1] = $currentContent;
			$struct[2] = '';

		} else {

			$pos = strrpos( $currentContent, $this->botBoundary );
			if ($pos==0 && !empty($this->botBoundary) ) {
				$botBoundary = $this->botBoundary;

				$fileP = $this->fileP;
				$SHOWFILEP = $fileP;
				$SHOWBOTBOUNDARY = $botBoundary;
				$this->userW('1309938525PUJX',array('$SHOWBOTBOUNDARY'=>$SHOWBOTBOUNDARY,'$SHOWFILEP'=>$SHOWFILEP));
				return false;
			} else {
				$end=substr($currentContent,-strlen($currentContent)+$pos);

				$pos=strpos( $currentContent, $this->headBoundary );

				if ($pos==0) {
					$headBoundary = $this->headBoundary;
					$fileP = $this->fileP;
					$SHOWFILEP = $fileP;
					$this->userW('1309938525PUJY',array('$headBoundary'=>$headBoundary,'$SHOWFILEP'=>$SHOWFILEP));
					return false;
				}
				$contentTMP = substr($currentContent,$pos,strlen($currentContent)-$pos);
				$pos = strpos($contentTMP,'{')+1;
				$contentTMP = substr($contentTMP,$pos,strlen($contentTMP)-$pos);
				$begining = substr($currentContent,0,strlen($currentContent)-strlen($contentTMP));

				$middle = substr($currentContent,strlen($begining),strlen($currentContent)-strlen($begining)-strlen($end));

				$struct[0] = $begining;
				$struct[1] = $middle;
				$struct[2] = $end;

			}		}		return $struct;

	}







	function _clearLineSpaces($code){

		 $total_chars= strlen($code)-2;
		 $lineStr=substr($code, $total_chars, 2);  
		 if ($lineStr=="\r\n"){
		 	$code=substr($code, 0, -2);  		 	$code=$this->_clearLineSpaces($code);
		 	return $code;
		 }else 	return $code;
	}

}