<?php 

* @link joobi.co
* @license GNU GPLv3 */





class Output_Helper_class {







	function convertSearchTerms($searchWords){

		$removeMe=WText::t('1206732365OQJI') .'...';
		if( $removeMe==$searchWords ) return false;

			$searchedResultA=array();
						if( strpos($searchWords, '"' )===false){							$mywordssearchedA=explode( ' ', $searchWords );
			foreach( $mywordssearchedA as $mywordssea){
				$mywordssea=trim($mywordssea);
				if( !empty($mywordssea) && strlen($mywordssea) > 1 ) $searchedResultA[]=$mywordssea;
			}		}else{				$text=$searchWords;
			preg_match_all( '#"((?:(?!").)*)"#' ,$searchWords, $reusltSearchet );
			$mywordssearchedA=$reusltSearchet[1];
					foreach( $mywordssearchedA as $mywordssea){
				$mywordssea=trim($mywordssea);
				if( !empty($mywordssea) && strlen($mywordssea)>1 ) $searchedResultA[]=$mywordssea;
			}		}
				return $searchedResultA;

	}
}