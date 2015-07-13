<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

### Copyright (c) 2006-2015 Joobi Limited. All rights reserved.
### license GNU GPLv3 , link http://www.joobi.co

define( 'JOOBI_FRAMEWORK_TYPE', 'wordpress' );
define( 'JOOBI_FRAMEWORK_TYPE_ID', 10 );
define( 'JOOBI_MAIN_APP', 'japps' );	
define( 'JOOBI_URLAPP_PAGE', 'page' );	define( 'JOOBI_PAGEID_NAME', 'page_id' );

define( 'JOOBI_PREFIX', JOOBI_FOLDER );

define( 'JOOBI_SITE', rtrim( home_url(), "/" ) . '/' );

define( 'JOOBI_USE_FTP', false );

define( 'IS_ADMIN', ( is_admin()) ? '250' : false );
define( 'JOOBI_SITE_NAME', get_option( 'blogname' ));
define( 'JOOBI_SITE_TOKEN' , SECURE_AUTH_SALT );
define( 'JOOBI_DS_ADMIN', JOOBI_DS_ROOT );

define( 'JOOBI_SITE_PATH', COOKIEPATH );

define( 'JOOBI_DEBUGCMS', WP_DEBUG );

define( 'JOOBI_TIME_OFFSET', get_option( 'gmt_offset' ) * 60 );	

if( IS_ADMIN){
		define( 'URL_NO_FRAMEWORK', '&noheader=1' );	}else{
			define( 'URL_NO_FRAMEWORK', '&bfrhead=1' );
}

global $wpdb;
$table_prefix=$wpdb->prefix;
if( empty($table_prefix)) $table_prefix=$wpdb->base_prefix;
if( empty($table_prefix)) $table_prefix='wp_';

define( 'JOOBI_DB_PREFIX', $table_prefix );

define( 'JOOBI_DB_NAME', DB_NAME );
define( 'JOOBI_DB_HOSTNAME', DB_HOST );
define( 'JOOBI_DB_USER', DB_USER );
define( 'JOOBI_DB_PASS', DB_PASSWORD );
define( 'JOOBI_LIST_LIMIT', get_option( 'posts_per_page' ));


define( 'JOOBI_FORM_METHOD', 'post' );
define( 'JOOBI_FORM_HASOPTION', true );
define( 'JOOBI_FORM_HASRETURNID', true );
define( 'JOOBI_FORM_NAME', 'adminForm' );
define( 'JOOBI_FORM_AUTOCOMPLETE' , true );

define( 'JOOBI_APP_DEVICE_TYPE', 'bw' );
define( 'JOOBI_APP_DEVICE_SIZE', '' );


define('JOOBI_SESSION_LIFETIME', 43200 );	

if( IS_ADMIN){
	define( 'JOOBI_INDEX', 'admin.php' );
	define( 'JOOBI_INDEX2', 'admin.php' );
}else{
	define( 'JOOBI_INDEX', '' );
	define( 'JOOBI_INDEX2', '' );
}






abstract class APIPage {

	public static $jsFileA=array();
	public static $jsA=array();
	public static $cssFileA=array();
	public static $cssA=array();






	public static function setTitle($title){

		return;






	}





	public static function setDescription($title){

	}





	public static function setMetaTag($key,$value){
	}






	public static function setGenerator($title){
	}








	public static function setLink($link,$relation,$relType='rel',$extraAttributesA=array()){
	}





	public static function setType($type){
	}





	public static function setLanguage($lang='en'){
	}





	public static function setDirection($dir='ltr'){
	}






	public static function getTemplate($return=''){
	}






	public static function isRTL(){
		return function_exists( 'is_rtl' ) && is_rtl() ? true : false;
	}






	public static function getSpoof($alt=null){
		return SECURE_AUTH_KEY;
	}








	public static function addScript($header,$type='text/javascript'){
		static $lenght=null;
		static $alreadyA=array();

		if( !isset($lenght)){
			$lenght=strlen( JOOBI_SITE_PATH );
		}
		if( isset($alreadyA[$header])) return false;
		$alreadyA[$header]=true;

				if( 'http' !=substr( $header, 0, 4 )){
			if( $lenght > 0){
				$header=substr( $header, $lenght-1 );
			}
			$name=str_replace( '/', '-', $header );
			$js=rtrim( JOOBI_SITE, '/' ) . $header;
		}else{
			$js=$header;
		}
		APIPage::$jsFileA[]=$js;


	}









	public static function addStyleSheet($header,$type='text/css',$media=null,$attributes=array()){
		static $lenght=null;
		static $isPopUp=null;

		if( !isset($lenght)){
			$lenght=strlen( JOOBI_SITE_PATH );
		}
		if( $lenght > 0){
			$header=substr( $header, $lenght-1 );
		}		$name=str_replace( '/', '-', $header );

		if( !isset($isPopUp)) $isPopUp=WGlobals::get( 'isPopUp' );

		if( ! IS_ADMIN && $isPopUp){
			self::$cssFileA[$name]=rtrim( JOOBI_SITE, '/' ) . $header;
		}else{
			wp_enqueue_style( $name, $header );
		}

	}







	public static function addCSS($header,$type='text/css'){
		static $isPopUp=null;

		if( !isset($isPopUp)) $isPopUp=WGlobals::get( 'isPopUp' );

		if( ! IS_ADMIN && $isPopUp){
			self::$cssA[]=$header;
		}else{
			$rand=rand( 100000, 999999 ) . '-' . time();
			wp_add_inline_style( $rand, $header );
		}
	}






	public static function addJS($header,$type='text/javascript'){
		self::$jsA[]=$header;
	}





	public static function encoding(){
		return get_option( 'blog_charset' );
	}






	public static function cmsGetItemId(){
		static $defaultID=null;

		if( IS_ADMIN){
			return;
		}
		$page_id=WGlobals::get( JOOBI_PAGEID_NAME );

		if( empty($page_id)){

			if( !isset($defaultID)){

				$menuM=WTable::get( '#__posts', '', 'id' );
				$string='[joobipage ';
								$menuM->whereE( 'post_type', 'page' );
				$menuM->whereE( 'post_status', 'publish' );
				$menuM->where( 'post_content', 'LIKE', "$string%" );
				$defaultID=$menuM->load( 'lr', 'ID' );
			}			$page_id=$defaultID;
		}
		return $page_id;

	}






	public static function cmsRoute($link,$SSL=null){
		static $sefC=null;
		static $option=null;

				if( !isset($option)) $option=get_option( 'permalink_structure' );

				if( empty($option)) return $link;

		$linkQuestion=trim( $link, '?' );
		$linkA=explode( '&', $linkQuestion );
		if( empty($linkA)) return $link;


		$query=array();
		foreach( $linkA as $l){
			$lA=explode( '=', $l );
			if( !empty($lA)){
				$query[$lA[0]]=$lA[1];
			}else{
			}		}


		$SEFlink='';
				if( !empty( $query[ JOOBI_PAGEID_NAME ] )){
			$post_data=get_post( $query[ JOOBI_PAGEID_NAME ] );
		    if( !empty($post_data->post_name)) $SEFlink=$post_data->post_name . '/';
		    unset( $query[ JOOBI_PAGEID_NAME ] );
		}else{
			return $link;
		}

		if( !isset( $sefC )){
			$exit=WLoadFile( 'api.addon.wp4.class.sef', JOOBI_DS_NODE );
			$className='Api_Wp4_Sef_class';
			$sefC=new $className;
		}
		$SEFlinkA=$sefC->buildSEF( $query );

		$SEFlink .=implode( '/', $SEFlinkA );

		if( !empty($query)){
			$SEFlink .='?';
			$extraLinkA=array();
			foreach( $query as $k=> $v){
				$extraLinkA[]=$k . '=' . $v;
			}			$SEFlink .=implode( '&', $extraLinkA );
		}
		$baseURL=WGlobals::get( JOOBI_PAGEID_NAME . '_base' );
		if( !empty($baseURL)){
			$basePost=WGlobals::get( JOOBI_PAGEID_NAME . '_post' );

			$ln=strlen($basePost);
			if( substr( $SEFlink, 0, $ln )==$basePost){
				$SEFlink=$baseURL . substr( $SEFlink, $ln );
			}		}
				if( substr( $option, -1 )=='/'){
			return rtrim( $SEFlink, '/' ) . '/';
		}else{
			return $SEFlink;
		}
	}





	public static function cmsGetShema(){
echo  '<br>need to test with SSL on wordpress ';
		return WPage::getHTTP();
	}





	public static function frameworkToken(){
		return LOGGED_IN_KEY;
	}





	public static function getMailInfo(){
		$mail=new stdClass;
		$mail->fromname=JOOBI_SITE_NAME;
		$mail->mailfrom=get_option('admin_email');
		$mail->mailer='mail';			$mail->sendmail='/usr/sbin/sendmail';			$mail->smtpauth=get_option('admin_email');			$mail->smtpsecure=false;			$mail->smtpport=get_option('mailserver_port');			$mail->smtpuser=get_option('mailserver_login');			$mail->smtppass=get_option('mailserver_pass');			$mail->smtphost=get_option('mailserver_url');			return $mail;
	}





	public static function cmsDefaultTheme(){
		return 'wp40';
	}





	public static function keepAlive($get=false){
	}
}





abstract class APIUser {





	public static function getSessionId(){
		if( !session_id()){
			session_start();
		}
		$sessionID=session_id();
		return $sessionID;

	}






	public static function cmsMyUser($property=''){
		static $user=null;

		if( !isset($user)){
			require_once( ABSPATH . WPINC . '/pluggable.php' );

			$wpDI=get_current_user_id();

			if( empty($wpDI)){
				$user=new stdClass;
				$user->id=0;
			}else{
				$userO=get_user_by( 'id', $wpDI );
				$user=$userO->data;
				$user->id=$user->ID;
			}
		}
		return (( empty($property)) ? $user : $user->$property );

	}






	public static function cmsMakePassword($password){
		if( class_exists( 'JUserHelper' )){
			$salt=JUserHelper::genRandomPassword(32);
			$crypt=JUserHelper::getCryptedPassword($password,$salt);
			$password=$crypt.':'.$salt;
			return $password;
		}	}
}






abstract class APIApplication {







	public static function version($return='short'){

		$version=WGlobals::get( 'wp_version', null, 'globals' );
		return $version;

	}





	public static function cacheFolder(){
												return JOOBI_DS_ROOT . 'cache';
	}







	public static function cmsMainLang($location='site'){

		$userLang=APIApplication::cmsUserLang();
		if( !empty( $userLang )) return $userLang;

		if( defined( 'WPLANG' ) && ( '' !==WPLANG ) && in_array( WPLANG, get_available_languages())){
			return WPLANG;
		}else{
			return 'en_US';
		}
	}





	public static function cmsUserLang(){

		if( defined( 'WPLANG' ) && ( '' !==WPLANG ) && in_array( WPLANG, get_available_languages())){
			return WPLANG;
		}else{
			return 'en_US';
		}
			}






	public static function cmsAvailLang($path=''){
		return get_available_languages();
	}







	public static function extract($file,$dest){
		return false;
	}





	public static function installThemePath(){
		define( 'JOOBI_URL_THEME_JOOBI', JOOBI_URL_USER . 'theme/admin/' . WPage::cmsDefaultTheme() . '/' );
	}
}

















abstract class CMSAPIPage extends APIPage {

	static private $_popOnlyOnce=true;



















	public static function routeURL($link,$absoluteLink='',$indexPassed=false,$SSL=false,$pageID=true,$foption=null,$noSEF=false){

		$link=trim($link);
		if( substr($link, 0, 4 )==='http' ) return $link;
		$absoluteLink=trim($absoluteLink);

				$device=WGlobals::get( 'device', false );
		if( $device=='mobile' || $device=='fb' ) $indexPassed='popup';



						if( $link=='previous'){
									$url=WGlobals::getReturnId();

			if( !empty($url)) return WPage::routeURL( $url, '', 'link', $SSL, false );
			$referer=WGlobals::get('HTTP_REFERER','','server','string');

			if(empty($referer) || strpos($referer,JOOBI_SITE)===false){
				$referer=JOOBI_SITE . ( $absoluteLink=='smart' ? ( IS_ADMIN ? 'wp-admin' : '' ) : '' );			}else{
				$referer=str_replace('&amp;','&', $referer );
			}			return $referer;
		}elseif( $link=='home'){
			return JOOBI_SITE;
		}

				if( $indexPassed===false){
									$isPopUp=WGlobals::get( 'is_popup', false, 'global' );
			if(( $isPopUp )) $index='popup';
			else $index='default';
		}else{
			$index=trim( strtolower($indexPassed));
		}
		$home=false;
		if( $absoluteLink=='smart'){
			if( IS_ADMIN){
				$absoluteLinkNewLink=JOOBI_SITE . 'wp-admin/';
			}else{
				$absoluteLinkNewLink=JOOBI_SITE;
			}		}elseif( $absoluteLink=='home'){
			$absoluteLinkNewLink=JOOBI_SITE;
						if( $indexPassed===false ) $index='default';
		}elseif( $absoluteLink=='admin'){
			$absoluteLinkNewLink=JOOBI_SITE . 'wp-admin/';
			$pageID=false;
			if( $indexPassed===false ) $index='default';
		}elseif( $absoluteLink){
			$absoluteLinkNewLink=JOOBI_SITE . $absoluteLink . '/';
		}else{
			$absoluteLinkNewLink=$absoluteLink;
			$noIndex=true;
		}
				$page_id='';
		if( ! IS_ADMIN && ! $noSEF){

						if( $pageID){
				if( $pageID===true){

										if( strpos( $link, JOOBI_PAGEID_NAME . '=' )===false){
						if( !isset($item)){
							$item=APIPage::cmsGetItemId();								}												if(empty($item)) $item=1;
						$page_id=JOOBI_PAGEID_NAME . '=' . $item;
					}				}else{
					if( $pageID !='none'){
						if( is_numeric($pageID)){
							$page_id .=JOOBI_PAGEID_NAME . '=' . $pageID;	
						}else{
														if( !empty($foption)) $pageID=$foption;
							$item=CMSAPIPage::cmsGetComponentItemId( $pageID );
							if( empty($item)) $item=APIPage::cmsGetItemId();
							$page_id .=JOOBI_PAGEID_NAME . '=' . $item;							}					}				}
			}		}
				if( $index=='default'){
						if( strpos($link,'index') !==0){
				if( !isset($currentOption) && $foption==null){
					$currentOption=WApplication::name( 'default', $pageID, $link );
				}
				$fullOption=($foption !=null ) ? $foption . '&' : $currentOption;
				$link=ltrim( $link, '&' );
				if( !empty($page_id)){
					$link=$absoluteLinkNewLink . JOOBI_INDEX . '?' . $page_id . '&' . $link;
				}else{
					$link=$absoluteLinkNewLink . JOOBI_INDEX . '?page=' . $fullOption . $link;
				}
			}else{
				$link=$absoluteLinkNewLink . $link;
			}		}elseif( $index=='popup'){
			$pageID=false;

			if( !isset($currentOption) && $foption==null ) $currentOption=WApplication::name( 'short', false, $link );

			$fullOption=($foption !=null ) ? $foption : $currentOption;
			if( !empty($page_id)){
				$link=$absoluteLinkNewLink . JOOBI_INDEX2 . '?'. $page_id . '&' . $link . '&isPopUp=true&' . URL_NO_FRAMEWORK;
			}else{
				$link=$absoluteLinkNewLink . JOOBI_INDEX2 . '?page='. $fullOption . '&' . $link . '&isPopUp=true&' . URL_NO_FRAMEWORK;
			}
		}elseif( $index=='link'){
			$link=$absoluteLinkNewLink . ( isset($noIndex) ? '' : JOOBI_INDEX . '?' ) . $link;
		}
		if( $device=='mobile' ) $link .=URL_NO_FRAMEWORK . '&device=mobile';

				if( !IS_ADMIN && !$noSEF){

			
			if( defined('PLIBRARY_NODE_SSLFE') && PLIBRARY_NODE_SSLFE){
				$SSL=true;
			}
			$link=rtrim( $link, '&' );

									if( substr( $link, 0, strlen(JOOBI_SITE))==JOOBI_SITE){
								$subLink=substr( $link, strlen( JOOBI_SITE ));

				$url=( $pageID ) ? CMSAPIPage::cmsRoute( $subLink, $SSL ) : $subLink;
								static $pathOnly=null;
				if( !isset($pathOnly)){
					$pathOnly=JOOBI_SITE_PATH;
				}
				if( !empty($pathOnly)){
					$pathOnlyLen=strlen($pathOnly);
					if( substr( $url, 0, $pathOnlyLen) ==$pathOnly ) $url=substr( $url, $pathOnlyLen );
				}
				$url=ltrim( $url, '/');
				if( substr( $url, 0, 4 ) !='http'){
					$url=JOOBI_SITE . $url;
				}
							}else{
								$url=( $pageID ) ? JOOBI_SITE . CMSAPIPage::cmsRoute( $link, $SSL ) : JOOBI_SITE . $link;
			}
			return $url;

		}else{
						$url=rtrim( $link, '&' );
			return $url;
		}
	}















	public static function createPopUpLink($url,$text,$x=550,$y=400,$className='',$idName='',$title='',$justNormalLink=false,$extras=''){

		if( empty($url)) return $text;

		if( !empty($title)) $title=' title="' . $title. '"';
		if( !empty($idName)) $idName=' id="' . $idName. '"';


		if( $justNormalLink){
			$target='';
			if( !empty($className)) $className=' class="' . $className. '"';
		}else{

			$className=' class="' . $className . '"';


				$target=self::createPopUpRelTag( $x, $y );

								$htnl='<a href="'.$url.'"' . $className . $idName . $title . $target . $extras . '>' . $text . '</a>';

			return $htnl;

		}
		return '<a href="' . $url . '"' . $title . $idName . $className . $target . $extras . '>' . $text . '</a>';

	}









	public static function createPopUpRelTag($x=550,$y=400){

		trim($x);
		trim($y);

		$target='';
		if( strpos( $x, '%') !==false){
			$x=substr( $x, 0, -1 );
			$target .=' data-pwidth="' . $x . '"';
		}else{
			$target .=' data-width="' . $x . '"';
		}		if( strpos($y, '%') !==false){
			$y=substr( $y, 0, -1 );
			$y -=5;				$target .=' data-pheight="' . $y . '"';
		}else{
			$target .=' data-height="' . $y . '"';
		}

		if( ! self::$_popOnlyOnce ) return ' data-target="#wzpOpUp" data-toggle="modal"' . $target;


				$js="
jQuery('a[data-toggle=\"modal\"]').on('click', function(e){
var target_modal=jQuery(e.currentTarget).data('target');
var rmtC=e.currentTarget.href;
var hPX=jQuery(e.currentTarget).data('height');
var wPX=jQuery(e.currentTarget).data('width');
var modal=jQuery(target_modal);
var modalBody=jQuery(target_modal + ' .modal-body');
modal.on('show.bs.modal', function (){
modalBody.find('iframe').attr('src',rmtC);
if( hPX==undefined){
    var pHeight=jQuery(e.currentTarget).data('pheight');
    if( pHeight==undefined){
        hPX=500;
    }else{
        var hSC=document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientHeight:document.body.clientHeight;
";
if( IS_ADMIN )  $js .='hSC=hSC-50';
$js .="
        hPX=Math.ceil((pHeight*hSC)/100);
    }
}
if( wPX==undefined){
    var pWidth=jQuery(e.currentTarget).data('pwidth');
    if( pWidth==undefined){
        wPX=500;
    }else{
        var wSC=document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientWidth:document.body.clientWidth;
";
if( IS_ADMIN )  $js .='wSC=wSC-170';
$js .="
        wPX=Math.ceil((pWidth*wSC)/100);
    }
}
jQuery('.modal-dialog').width( wPX );
jQuery(modalBody.find('iframe')).height( hPX );
}).modal();
return false;
});
";

		WPage::addJSScript( $js );

		self::$_popOnlyOnce=false;

$html='<div id="wzpOpUp" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body">
<iframe width="99.6%" height="400px" frameborder="0" src=""></iframe>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times-circle"></i>' . WText::t('1228820287MBVC') . '</button>
</div>
</div>
</div>
</div>';

				WView::popupMemory( $html );

		return ' data-target="#wzpOpUp" data-toggle="modal"' . $target;

	}







	public static function cmsGetComponentItemId($component,$view=''){
		return;
	}






	public static function getPageInfoFromID($id=0){
		if( empty($id)) return ;

		$menuM=WTable::get( '#__posts', '', 'ID' );
		$menuM->remember( $id, true );
		$menuM->whereE( 'ID', $id );
		$post_content=$menuM->load( 'lr', 'post_content' );

		if( empty( $post_content )) return ;

				$start=strpos( $post_content, 'id="page_' );
		if( $start===false ) return;

		$start +=9;
		$end=strpos( $post_content, '__', $start );
		$option=substr( $post_content, $start, $end - $start );

		return $option;

	}









	public static function getSpecificItemId($controller='',$task=''){
		static $resultA=array();

				if( IS_ADMIN ) return false;

		if( empty($controller)) return APIPage::cmsGetItemId();
		

		$key=$controller . '|' . $task;
		if( !isset( $resultA[$key] )){

			$app=WGlobals::getApp();
			if( empty($app)){
				$pageID=WGlobals::get( JOOBI_PAGEID_NAME );
				if( !empty($pageID)) $app=self::getPageInfoFromID( $pageID );
			}


			$stringStart='[joobipage id="page_' . $app . '__ctrl_' . $controller;
			$stringTask=( !empty( $task ) ? '__task_' . $task : '' );

			$stringClose='"]';
			$menuM=WTable::get( '#__posts', '', 'ID' );
			$menuM->rememberQuery( true );
			$menuM->whereE( 'post_type', 'page' );
			$menuM->whereE( 'post_status', 'publish' );
			$search=$stringStart . $stringTask . $stringClose;
			$menuM->whereSearch( 'post_content', $search, 0, null, null, true );
			$nowResult=$menuM->load( 'lr', 'ID' );

			if( empty($nowResult)){
								$menuM->resetAll();
				$menuM->rememberQuery( true );
				$menuM->whereE( 'post_type', 'page' );
				$menuM->whereE( 'post_status', 'publish' );
				$search=$stringStart . $stringTask;
				$menuM->whereSearch( 'post_content', $search, 0, null, null, true );
				$nowResult=$menuM->load( 'lr', 'ID' );

				if( empty($nowResult) && !empty($stringTask)){

										$menuM->resetAll();
					$menuM->rememberQuery( true );
					$menuM->whereE( 'post_type', 'page' );
					$menuM->whereE( 'post_status', 'publish' );
					$menuM->whereSearch( 'post_content', $stringStart, 0, null, null, true );
					$nowResult=$menuM->load( 'lr', 'ID' );
				}
			}
			if( !empty($nowResult)){
				$resultA[$key]=$nowResult;
			}else{
				$resultA[$key]=true;
WMessage::log( $stringStart . $stringTask . $stringClose, 'wp_no_page_id');

			}
		}
		return $resultA[$key];

	}





	public static function cmsGetLinkBasedItemId($pageID){
		return false;
	}






	public static function refreshFrameworkMenu($wid=null,$action='',$recursive=false){

		$libraryCMSMenuC=WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$libraryCMSMenuC->cmsLinks( $wid, $action, $recursive );
		return true;

	}






	public static function jsPreload(){

		
		return true;

	}













	public static function includeMootools(){
	}






	public static function includejQuery(){
		if( ! IS_ADMIN && ! WPref::load( 'LIBRARY_NODE_LOADJQUERY' )){
			wp_enqueue_script('jquery');
		}	}







	public static function includeRootScript(){
		static $onlyOnce=true;

		if( $onlyOnce){

			if( ! IS_ADMIN && WPref::load( 'LIBRARY_NODE_LOADJQUERY' )){
								$path=WPage::fileLocation( 'js', 'js/jquery-1.11.2.js' );
				WPage::addScript( $path );
			}
			$path=WPage::fileLocation( 'js', 'js/rootscript.1.1.js', 'api' );
			WPage::addScript( $path );

			$path=WPage::fileLocation( 'js', 'js/themescript.1.1.js' );
			WPage::addScript( $path );

			$onlyOnce=false;

		}	}






	public static function includeJoobiBox(){
	}







	public static function interpretURL($segmentsA){
		$vars=array();
		$vars['controller']=str_replace( ':', '-', $segmentsA[0] );
		$i=1;


		while( !empty($segmentsA[$i])){
			WPage::parseURL( $segmentsA[$i], $vars );
			$i++;
		}

				WGlobals::set( 'MainURL', $vars, 'global' );

		return $vars;

	}





	public static function buildURL(&$query){

				if( empty($query['controller'])){

									return array();

		}

		$segmentsA=array();

				if( !empty($query['controller'])){

			$myControllerA=explode( '-', $query['controller'] );
			$myController=array_shift( $myControllerA );

						$mySEFC=WClass::get( $myController. '.sef', null, 'class', false );
			if( !empty($mySEFC)){
				$segmentsA=$mySEFC->buildSEF( $query );
				return $segmentsA;
			}
		}
		if(!empty($query['controller'])){
			$segmentsA[]=$query['controller'];
			unset($query['controller']);
		}		if(!empty($query['task'])){
			$segmentsA[]=$query['task'];
			unset($query['task']);
		}		if(!empty($query['eid'])){
			$segmentsA[]=$query['eid'];
			unset($query['eid']);
		}		if(!empty($query['type'])){
			$segmentsA[]=$query['type'];
			unset($query['type']);
		}
		return $segmentsA;
	}







	public static function parseURL($string,&$vars){

				$alreadyDone=false;
		if( !empty($vars['controller'])){

			$myControllerA=explode( '-', $vars['controller'] );
			$myController=array_shift( $myControllerA );

						$mySEFC=WClass::get( $myController. '.sef', null, 'class', false );

			if( !empty($mySEFC)){
									if( strpos( $string, '-' ) !==false){
						$dashA=explode( '-', $string );
						$newString=array_pop( $dashA );
						$replace=true;

						do {
							$val=array_pop( $dashA );
							if( $replace ) $newString=$val . '-' . $newString;
							else  $newString=$val . ':' . $newString;

							$replace=! $replace;
						} while ( !empty($dashA));

						$string=$newString;

					}
				$alreadyDone=$mySEFC->parseSEF( $vars, $string );
			}
		}

		if( !$alreadyDone){

			if( is_numeric($string)){
								$vars['eid']=$string;
			}else{					$vars['task']=$string;
			}
		}


	}










	public static function completeURL($url='',$popup=null,$raw=false){

		$url=trim($url);
		$popup=( !empty($popup) ? true : WGlobals::get( 'is_popup', false, 'global' ));

				return ( $popup ? ( empty($url) ? '?' : $url . '&' ) . 'noheader=1'. ( $raw ? '' : '') : $url );


	}







	public static function formURL($option='',$controller=''){
		if( !empty($controller)) $controller='&controller=' . $controller;

				if( empty($option)) $option=WApplication::name( 'com' );
		return JOOBI_SITE . JOOBI_INDEX . '?page=' . $option . $controller;
	}








	public static function clearCache($folder=''){
		static $done=false;

		if( $done ) return;
						$extensionHelperC=WCache::get();
			$extensionHelperC->resetCache( 'page' );

		$done=true;

	}







}














abstract class WApplication extends APIApplication {

	public static $cmsName='wp4';	
	public static $ID=21;





	public static function getFrameworkName(){
		return self::$cmsName;
	}






	public static function getAppLink($app=''){
		if( empty($app)) $app=WApplication::name( 'short' );
		return $app;
	}













	public static function name($short='default',$pageID=null,$linkController=null){

			$option=WGlobals::getApp();
									
						$joptionVal=array( 'jvendor', 'juser', 'jcommunity','jiptracker', 'jnotebook', 'jprojects', 'jlinks','jdesign','jfaq','jdiscuss','jservicesprovider','jdefender', 'infusionstats', 'jurlauncher','jcenter',
'jstore','jfeedback','jcomment','jtickets','jcloner','jaffiliates', 'japplication', 'jbackup', 'jscheduler', 'jstudio', 'jmobile','jmarket','jauction','jlottery','jvouchers',
 'jsubscription','jtestcases','jcontacts','jcatalog','jdownloads', 'jdloads','jclassifieds','jdatabase','jtodo', 'jchecklist','jdocumentation','jdistribution','jbounceback','jdictionary','jforum','jlicense','jnewsletters','jcampaign', 'joomfusion' );

			$myOption=$option;

						if( !in_array( $myOption, $joptionVal ) || ( !IS_ADMIN && $myOption==JOOBI_MAIN_APP )){
				$myOption=JOOBI_MAIN_APP;

								$tryController=true;

								if( $tryController && !empty($linkController)){

					$linkController=str_replace('&amp;','&', $linkController );
					$findControllerA=explode( '&', $linkController );
					if( !empty($findControllerA)){
						foreach( $findControllerA as $oneControl){
							if( substr( $oneControl, 0, 11 )=='controller='){
								$conA=explode( '=', $oneControl );
								$myController=$conA[1];
								$conAlmostA=explode( '-', $myController );
								if( count($conAlmostA) > 1){
									$myController=$conAlmostA[0];
								}else{
																		$conAlmostA=explode( '.', $myController );
									if( count($conAlmostA) > 1){
										$myController=$conAlmostA[0];
									}								}								break;
							}						}
						if( !empty($myController)){
							static $allDependsControl=array();
														$myController;

							$WIDController=WExtension::get( $myController . '.node', 'wid');
							if( !isset($allDependsControl[$WIDController])){
								$allDependsControl[$WIDController]=JOOBI_MAIN_APP; 								$appsDependencyM=WModel::get( 'apps.dependency' );
								$appsDependencyM->makeLJ( 'apps.userinfos', 'wid' );
								$appsDependencyM->makeLJ( 'apps', 'wid', 'wid', 1, 2 );

								$appsDependencyM->select( 'namekey', 2 );
								$appsDependencyM->whereE( 'ref_wid', $WIDController );
								$appsDependencyM->orderBy( 'level', 'DESC', 1 );
								$appsDependencyM->orderBy( 'wid', 'DESC', 0 );
								$allDependsA=$appsDependencyM->load( 'lra' );

								if( !empty( $allDependsA)){
									foreach( $allDependsA as $oneDepend){
																				$myComponentA=explode( '.', $oneDepend );
										$isEnabled=WApplication::isEnabled( $myComponentA[0] );
										if( $isEnabled){
											$myOption=$myComponentA[0];
											if( !in_array( $myOption, $joptionVal )) $myOption=JOOBI_MAIN_APP;
											else $allDependsControl[$WIDController]=$myComponentA[0];
											break;
										}									}
								}
							}else{
								$myOption=$allDependsControl[$WIDController];
							}						}
					}

				}

			}

		switch( $short){
			case 'short':
			case 'com':
				return $myOption;
				break;
			case 'application':
				return $myOption . '.application';
				break;
			case 'wid':
				return WExtension::get( $myOption . '.application', 'wid' );
				break;
			case 'default':
			default:
				return  $myOption . '&';
				break;
		}
	}








	public static function mainLanguage($return='lgid',$force=false,$suggestedLang=array(),$location='site'){
		static $lang=null;

		if( empty($lang) || $force){

			$langCode=array( APIApplication::cmsMainLang( $location ));	
			if( !empty($langCode)){

				$langCode[]=substr( $langCode[0], 0, 2 );

								$availableLanguageA=WApplication::availLanguages( array( 'lgid', 'name', 'code', 'locale' ));

				$foundLanguage=false;
				foreach( $langCode as $oneLGCode){
					foreach( $availableLanguageA as $availLang){
						if( $availLang->code==$oneLGCode){
							$foundLanguage=true;
							$lang=$availLang;
							break;
						}					}					if( $foundLanguage ) break;
				}
			}
						if( empty($lang)){
				$lang=new stdClass;
				$lang->lgid=1;
				$lang->name='English';
				$lang->code='en';
				$lang->locale='en_GB.utf8,en_GB.UTF-8,en_GB,eng_GB,en,english,english-uk,uk,gbr,britain,england,great britain,uk,united kingdom,united-kingdom';
			}
		}
		return $lang->$return;

	}





	public static function userLanguage(){

		$lang=APIApplication::cmsUserLang();

		$langCode=array( substr( $lang, 0, 2 ));

		$location=IS_ADMIN ? 'admin' : 'site';
		$myLang=WApplication::mainLanguage( 'lgid', false, $langCode, $location );

		return $myLang;

	}











	public static function availLanguages($map='code',$site='current'){

		$langA=WApplication::_getLanguages( $map );

		return $langA;

	}








	private static function _getLanguages($map){
		static $results=array();

		$languages=APIApplication::cmsAvailLang();
		$bool=WPref::load( 'PLIBRARY_NODE_EXTLANG' );

		$availLangs=array();
		foreach( $languages as $language){				if( $bool){
				$availLangs[]=str_replace( '_', '-', $language );
			}else{
				$availLangs[]=substr( $language, 0, 2 );
			}		}
		$keyG=serialize($availLangs);

		$cachedLanguageA=array();
		foreach( $availLangs as $oneCode){
			$cachedLanguageA[]=WLanguage::get( $oneCode, array( 'name', 'code', 'lgid', 'real', 'locale' ));
		}
		if( is_string($map)){
			$a=array();
			foreach( $cachedLanguageA as $oneLnag){
				$a[]=$oneLnag->$map;
			}			return $a;
		}elseif( is_array($map)){
			$a=array();
			foreach( $cachedLanguageA as $oneLnag){
				$obj=new stdClass;
				foreach( $map as $myMap){
					if( isset($oneLnag->$myMap)) $obj->$myMap=$oneLnag->$myMap;
				}				$a[]=$obj;
			}			return $a;

		}else{

		}

	}




















	public static function setWidget($object){

				if( !isset($object->name)){
			$message=WMessage::get();
			$message->codeE( 'The name of the widget is not specified.' );
			return false;
		}elseif( !isset($object->type)){
			$message=WMessage::get();
			$message->codeE( 'The type of the widget is not specified.' );
			return false;
		}
		$joobiWidget=( isset($object->joobi)) ? $object->joobi : true;

		$cmsObject=null;
		if( isset($object->publish)) $cmsObject->published=$object->publish;
		if( isset($object->access)) $cmsObject->access=$object->access;
		if( isset($object->ordering)) $cmsObject->ordering=$object->ordering;
		if( isset($object->core)) $cmsObject->iscore=$object->core;
		if( isset($object->params)) $cmsObject->params=$object->params;

		switch ( strtolower($object->type)){
			case 'module' :
				$name='module';
				if( isset($object->region)) $cmsObject->position=$object->region;
				$cmsObject->$name='mod_'.$object->name;
				$widgetM=WTable::get( '#__modules', '', 'id');
				break;
			case 'plugin' :
				$name='element';
				if( isset($object->location)) $cmsObject->folder=$object->location;
				$cmsObject->$name=$object->name;
				$widgetM=WTable::get( '#__extensions', '', 'extension_id' );
				$widgetM->setVal( 'type', 'plugin' );

				break;
			default :
				$message=WMessage::get();
				$message->codeE( 'The type specified does not exist in WordPress 4 :' . $object->type );
				return false;
				break;
		}
		foreach( $cmsObject as $key=> $property){
			if( $key!=$name ) $widgetM->setVal( $key, $property);
		}
		$namekey=str_replace( '.', '_', $cmsObject->$name );
		$widgetM->whereE( $name, $namekey );
		return $widgetM->update();

	}





	public static function createMenu($name,$menuParent,$link,$option,$client=1,$access=0,$level=0,$ordering=0,$param=null){

		WLoadFile( 'helper', JOOBI_DS_NODE . 'api' .  DS . 'addon' . DS . JOOBI_FRAMEWORK . DS );
		$APIHelperC=new Api_Wp4_Helper_addon;
		return $APIHelperC->createMenu( $name, $menuParent, $link, $option, $client, $access, $level, $ordering, $param );

	}








	public static function isEnabled($component,$strict=true,$addCom=true){
		static $alreadyChecked=array();

		if( isset($alreadyChecked[$component])) return $alreadyChecked[$component];

		$alreadyChecked[$component]=false;
				$fileS=WGet::folder();
		$exist=$fileS->exist( WP_PLUGIN_DIR . DS . $component );

		if( $exist){

			$active_plugins=(array) get_option( 'active_plugins', array());

			if( !empty($active_plugins)){
				foreach( $active_plugins as $plugin){
					if( $plugin==$component . '/' . $component . '.php'){
						$alreadyChecked[$component]=true;
						break;
					}				}			}
		}
		return $alreadyChecked[$component];

	}









	public static function enable($extension,$value=1,$type=''){	
		return false;


	}
	




	public static function getComponents($option='',$column=''){
		static $extensionsA=array();


		$active_plugins=(array) get_option( 'active_plugins', array());
		return $active_plugins;


	}








	public static function date($format=null,$time=null){
		static $alreadyDoneA=array();

				if( empty($time)) $time=time();
		if( empty($format)) $format=WTools::dateFormat( 'date-number' );

		$key=$format . '-' . $time;
		if( !empty( $alreadyDoneA[$key] )) return $alreadyDoneA[$key];

		$alreadyDoneA[$key]=date( WGlobals::filter( $format ), $time );

		return $alreadyDoneA[$key];

	}






	public static function stringToTime($date=null){
		return strtotime( $date );
	}







	public static function stringFilter($string,$html=false){

				if( !class_exists('JFilterInput')) return $string;

		if( $html){
			$safeHtmlFilter=JFilterInput::getInstance( null, null, 1, 1 );
			$cleanString=$safeHtmlFilter->clean( $string, 'string' );
		}else{
			$noHtmlFilter=JFilterInput::getInstance();
			$cleanString=$noHtmlFilter->clean( $string, 'string' );
		}
		return $cleanString;
	}
}







class JoobiWP {







	public static function linkToSlug($link='',$option='',$namekeyA=array()){

		if( !empty($option)) $namekeyA['page']='page_' . $option;

		if( !empty($link)){
			$explodeLinkA=explode( '&', $link );
			foreach( $explodeLinkA as $oneLink){
				$explodEqualA=explode( '=', $oneLink );
				$key=( 'controller'==$explodEqualA[0] ? 'ctrl' : $explodEqualA[0] );
				$namekeyA[]=$key . '_' . $explodEqualA[1];
			}		}
		return implode( '__', $namekeyA );

	}









	public static function linkToOption($link='',$option='',$namekeyA=array()){

		$strpos=strpos( $link, ' ' );
		if( $strpos===false){
			$myLink=$link;
		}else{
			$myLink=substr( $link, 0, $strpos );
		}
		if( !empty($option)) $namekeyA['page']='page_' . $option;

		if( !empty($myLink)){
			$explodeLinkA=explode( '&', $myLink );
			foreach( $explodeLinkA as $oneLink){
				$explodEqualA=explode( '=', $oneLink );
				$key=( 'controller'==$explodEqualA[0] ? 'ctrl' : $explodEqualA[0] );
				$namekeyA[]=$key . '_' . $explodEqualA[1];
			}		}
		$option=JOOBI_PREFIX . 'pg|' . implode( '|', $namekeyA );

		return substr( $option, 0, 64 );

	}






	public static function slugToApp($slug=''){
		$aParamsA=explode( '__', $slug );

		if( empty($aParamsA)) return false;

		$option='';
		foreach( $aParamsA as $oneP){

			if( $oneP==JOOBI_PREFIX ) continue;	
			$explodePA=explode( '_', $oneP );
			if( count( $explodePA) > 1){
				$fct=array_shift( $explodePA );
				WGlobals::set( $fct, implode( '-', $explodePA ));
			}elseif( count( $explodePA)==1){
				$option=$explodePA[0];
				WGlobals::set( JOOBI_URLAPP_PAGE, $option );
			}
		}
				if( 'page_jvendor'==$slug){
			$controller=WGlobals::get( 'controller' );
			if( empty($controller)) WGlobals::set( 'controller', 'vendors-area' );
		}

		if( empty($option)) $option=WGlobals::getApp();


				WGlobals::set( 'resetForm', 'yes', 'global' );

						$params=null;
		$namekey=$option . '.application';
		$content=WGet::startApplication( 'application', $namekey, $params );

		$jsHTML=JoobiWP::renderCSS();
		$jsHTML .=JoobiWP::renderJS();
		$noheader=WGlobals::get( 'noheader' );
		if( $noheader){
			$head='<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml">';
			$content=$head . '<head>' . $jsHTML . '</head><body>' . $content;
		}else{
			$content=$jsHTML . "\n" . $content;
		}
		return $content;

	}





	public static function renderJS(){

		$noheader=WGlobals::get( 'noheader' );

		$jsHTML='';
		if( $noheader){
						$jsHTML .='<script type="text/javascript" src="' . JOOBI_SITE . 'wp-includes/js/jquery/jquery.js"></script>' . WGet::$rLine;
		}
		if( !empty(APIPage::$jsFileA)){
			$jsFiel='';
			foreach( APIPage::$jsFileA as $name=> $header){
				$jsFiel .='<script type="text/javascript" src="' . $header . '"></script>' . WGet::$rLine;
			}			$jsHTML .=$jsFiel . WGet::$rLine;
		}

		if( !empty(APIPage::$jsA)){
			$jsHTML .='<script type="text/javascript">' . implode( '; ', APIPage::$jsA ) . WGet::$rLine . '</script>' . WGet::$rLine;
		}

				APIPage::$jsFileA=array();
		APIPage::$jsA=array();


				if( JOOBI_DEBUGCMS
			|| ( defined('PLIBRARY_NODE_PLEX') && PLIBRARY_NODE_PLEX )
		){
			$html="\n\r<!-- Start Joobi Javascript -->" . WGet::$rLine;
			$html .=$jsHTML;
			$html .="<!-- End Joobi Javascript -->\n\r";

			$jsHTML=$html;
		}

		return $jsHTML;

	}





	public static function renderWidget(){
		static $onlyOnce=true;
		if( $onlyOnce && WRoles::isAdmin( 'manager' )
		&& ( strpos( WGlobals::get( 'PHP_SELF', '', 'server'), 'widgets.php' ) !==false
		|| strpos( WGlobals::get( 'PHP_SELF', '', 'server'), 'customize.php' ) !==false )
			){
			$onlyOnce=false;
			return JoobiWP::renderPopUpButton();
		}		return '';
	}




	public static function renderPopUpButton(){
		static $onlyOnce=true;

		if( $onlyOnce){

			if( !defined('JOOBI_URL_THEME_JOOBI')){
				WView::definePath();
			}
			$lenght=strlen( JOOBI_SITE_PATH );
			$site=rtrim( JOOBI_SITE, '/' );
			$jsFileA=array();
			$cssFileA=array();
			$path=WPage::fileLocation( 'js', 'js/rootscript.1.1.js', 'api' );
			if( $lenght > 0 ) $jsFileA[]=substr( $path, $lenght-1 );
			else $jsFileA[]=$path;
			$path=WPage::fileLocation( 'js', 'js/themescript.1.1.js' );
			if( $lenght > 0 ) $jsFileA[]=substr( $path, $lenght-1 );
			else $jsFileA[]=$path;
			$path=WPage::fileLocation( 'js',  'js/bootstrap.js' );
			if( $lenght > 0 ) $jsFileA[]=substr( $path, $lenght-1 );
			else $jsFileA[]=$path;
			$path=WPage::fileLocation( 'css',  'css/bootstrap.css' );
			if( $lenght > 0 ) $cssFileA[]=substr( $path, $lenght-1 );
			else $cssFileA[]=$path;
			$path=WPage::fileLocation( 'css',  'css/style.css' );
			if( $lenght > 0 ) $cssFileA[]=substr( $path, $lenght-1 );
			else $cssFileA[]=$path;

			$pH='';
			foreach( $jsFileA as $js ) $pH .=WGet::$rLine . '<script type="text/javascript" src="' . $site . $js . '"></script>';
			foreach( $cssFileA as $css ) $pH .=WGet::$rLine . '<link rel="stylesheet" href="' . $site . $css . '" type="text/css" media="all" />';

			$js=WGet::$rLine . "<script type=\"text/javascript\">
joobi.onDOMready(function(){
jQuery('a[data-toggle=\"modal\"]').on('click', function(e){
var target_modal=jQuery(e.currentTarget).data('target');
var rmtC=e.currentTarget.href;
var hPX=jQuery(e.currentTarget).data('height');
var wPX=jQuery(e.currentTarget).data('width');
var modal=jQuery(target_modal);
var modalBody=jQuery(target_modal + ' .modal-body');
modal.on('show.bs.modal', function (){
modalBody.find('iframe').attr('src',rmtC);
if( hPX==undefined){
    var pHeight=jQuery(e.currentTarget).data('pheight');
    if( pHeight==undefined){
        hPX=500;
    }else{
        var hSC=document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientHeight:document.body.clientHeight;
hSC=hSC-50
        hPX=Math.ceil((pHeight*hSC)/100);
    }
}
if( wPX==undefined){
    var pWidth=jQuery(e.currentTarget).data('pwidth');
    if( pWidth==undefined){
        wPX=500;
    }else{
        var wSC=document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientWidth:document.body.clientWidth;
wSC=wSC-170
        wPX=Math.ceil((pWidth*wSC)/100);
    }
}
jQuery('.modal-dialog').width( wPX );
jQuery(modalBody.find('iframe')).height( hPX );
}).modal();
return false;
});

}
);
</script>" . WGet::$rLine;


			$pH .=$js;

			$onlyOnce=false;

			return $pH;


		}

	}





	public static function renderCSS(){

		$jsHTML='';

		if( !empty(APIPage::$cssFileA)){
			$jsFiel='';
			foreach( APIPage::$cssFileA as $name=> $header){
				$jsFiel .='<link type="text/css" media="all" rel="stylesheet" id="' . $name . '-css" href="' . $header . '"/>' . WGet::$rLine;
							}			$jsHTML .=$jsFiel . WGet::$rLine;
		}

		if( !empty(APIPage::$cssA)){
			$jsHTML .='<style type="text/css" media="screen">' . implode( '; ', APIPage::$cssA ) . WGet::$rLine . '</style>' . WGet::$rLine;
		}

				APIPage::$cssFileA=array();
		APIPage::$cssA=array();


				if( JOOBI_DEBUGCMS
			|| ( defined('PLIBRARY_NODE_PLEX') && PLIBRARY_NODE_PLEX )
		){
			$html="\n\r<!-- Start Joobi CSS styling -->" . WGet::$rLine;
			$html .=$jsHTML;
			$html .="<!-- End Joobi CSS styling -->\n\r";

			$jsHTML=$html;
		}

		return $jsHTML;

	}










}




class WApplication_wp4 {	
	public static $appName='';







	public static function renderFunction($WPClass,$WPfct='wpRun',$appName=null,$p1=null,$p2=null){

		$exit=WLoadFile( 'api.addon.wp4.class.' . $WPClass, JOOBI_DS_NODE );

		if( $exit){
			$className='Api_Wp4_' . ucfirst($WPClass) . '_class';
			if( empty($WPfct)) $WPfct='wpRun';
			$isnt=new $className;
			if( !empty($appName)){
				if( isset($p2)){
					return $isnt->$WPfct( $appName, $p1, $p2 );
				}elseif( isset($p1))  {
					return $isnt->$WPfct( $appName, $p1 );
				}else{
					return $isnt->$WPfct( $appName );
				}			}else{
				if( isset($p2)){
					return $isnt->$WPfct( $p1, $p2 );
				}elseif( isset($p1))  {
					return $isnt->$WPfct( $p1 );
				}else{
					return $isnt->$WPfct();
				}			}
		}else{
			$message=WMessage::get();
			$message->codeE( 'Could not find the function for WordPress 4 :' . $WPClass );
		}
	}









	public static function createClass($functionName,$fileName,$identifier){
		static $alreadyDoneA=array();

		if( isset($alreadyDoneA[$functionName])) return false;
		$alreadyDoneA[$functionName]=true;

		$functionName=WGlobals::filter( str_replace( array('-', '.'), '_', $functionName ), 'namekey' );
		$fileName=WGlobals::filter( str_replace( array('-', '.'), '_', $fileName ), 'namekey' );
		$identifier=WGlobals::filter( str_replace( array('-', '.'), '_', $identifier ), 'namekey' );

				$code='function ' . $functionName . '(){WApplication_wp4::renderFunction("' . $fileName . '",null,"' . $identifier . '");}';

		eval($code);

	}








	public static function createFunction($functionName,$className,$methodName,$params=null){
		static $alreadyDoneA=array();

		if( isset($alreadyDoneA[$functionName])) return false;
		$alreadyDoneA[$functionName]=true;

		$functionName=WGlobals::filter( str_replace( array('-', '.'), '_', $functionName ), 'namekey' );
		$className=WGlobals::filter( str_replace( array('-', '.'), '_', $className ), 'namekey' );
		$methodName=WGlobals::filter( str_replace( array('-', '.'), '_', $methodName ), 'namekey' );
		$params=(string)WGlobals::filter( $params );

				$code='function ' . $functionName . '($p1=null,$p2=null){WApplication_wp4::renderFunction("' . $className . '","' . $methodName . '","' . $params . '",$p1,$p2);}';

		eval($code);

	}






	private static function _add_action($WPFunction){
		static $countA=array();

		$appFunction=self::$appName . '_' . $WPFunction;
		if( !isset($countA[$appFunction])) $countA[$appFunction]=0;
		$countA[$appFunction]++;
		add_action( $WPFunction, $appFunction, $countA[$appFunction] );

				self::createClass( $appFunction, $WPFunction, self::$appName );

	}





	private static function _wpInit(){

		self::_add_action( 'init' );
				if( IS_ADMIN){

			self::_add_action( 'admin_menu' );

			
			add_filter( 'plugin_action_links_' . self::$appName . '/'. self::$appName . '.php', self::$appName . '_pluginActionLinks_WP' );
			add_action( 'admin_notices', self::$appName . '_installNotice_WP' );

		}else{
		}


	}








	public static function make($entrypoint,$params=null){
		static $loadConfig=true;


				if( $loadConfig){
			$loadConfig=false;
			require_once( JOOBI_LIB_CORE . 'define.php' );
			require_once( JOOBI_DS_NODE . 'api' . DS . 'addon' . DS . JOOBI_FRAMEWORK . DS . 'api.php' );


						WPref::override( 'PCATALOG_NODE_EDITITEMLOCATION', 'vendors' );

									$use_mysqli=false;
			if( function_exists( 'mysqli_connect' )){
				$wpVR=WGlobals::get( 'wp_version', null, 'globals' );
				if( defined( 'WP_USE_EXT_MYSQL' )){
					$use_mysqli=! WP_USE_EXT_MYSQL;
				}elseif( version_compare( phpversion(), '5.5', '>=' ) || ! function_exists( 'mysql_connect' )){
					$use_mysqli=true;
				}elseif( false !==strpos( $wpVR, '-' )){
					$use_mysqli=true;
				}			}
			define( 'JOOBI_DB_TYPE', 'framework' );

						define( 'JOOBI_CHARSET' , WPage::encoding());

						$session=WGet::session( 0, true );

						$membersSesionC=WUser::session();
			$membersSesionC->checkUserSession( false, 'id' );

						$userID=WUser::cmsMyUser( 'id' );


			$user=new WP_User( $userID );
								$rolidA=WUser::roles();
				if( !empty($rolidA)){

					$roleAddon=WAddon::get( 'api.'. JOOBI_FRAMEWORK . '.role' );
					$allEquivalentA=$roleAddon->getRoles();
					foreach( $rolidA as $oneRole){

						$namekey=WRole::get( $oneRole, 'namekey' );

												if( !empty($allEquivalentA[$namekey])) $user->add_cap( $allEquivalentA[$namekey] );

												$user->add_cap( 'wzrole_' . $oneRole );

					}				}



		}
		$isPopUp=WGlobals::get( 'isPopUp', false );
		if( $isPopUp){
			WGlobals::set( 'is_popup', true, 'global', true );
			WGlobals::set( 'noheader', '1' );
		}
		$processApplication=false;
		$entryTypeText='';
		$isPopUp=false;
		self::$appName='';


		if( empty($entrypoint)){
			$processApplication=false;
		}elseif( $entrypoint=='install'){
			$namekey='';
			$extType=$entrypoint;
		}elseif( $entrypoint=='relaunch'){
			$processApplication=true;
			$extType='application';
		}else{

			$mypath=explode( DS , strtolower( $entrypoint ));
			self::$appName=substr( array_pop( $mypath ), 0, -4 );


		}

		

		WGet::loadLibrary();

				self::_wpInit();


		if( $processApplication){

						WGlobals::set( 'resetForm', 'yes', 'global' );

						if( !isset($extType)) $extType='';
			if( !isset($namekey)) $namekey='';
			$params=null;
			$content=WGet::startApplication( $extType, $namekey, $params );

			
		}else{
						$content='';
		}
				if( $processApplication){				WPage::keepAlive( true );
		}





				$soundMusic=WGlobals::getSession( 'installRedirectInfo' );

		if( WPref::load( 'PLIBRARY_NODE_ENABLESOUND' ) && is_object($soundMusic) && !empty($soundMusic->alex) && $soundMusic->alex==WPage::linkAdmin(WGlobals::currentURL())){
			$browser=WPage::browser( 'namekey' );
			$extension=( $browser=='safari' || $browser=='msie' ) ? 'mp3' : 'ogg';

			$URLBeep=WPref::load( 'PLIBRARY_NODE_CDNSERVER' ) . '/joobi/user/media/sounds/finish.' . $extension;

			$content .='<audio autoplay="true" src="' . $URLBeep . '" preload="auto" autobuffer></audio>';
		}		
		return $content;

	}
}





function joobiIsPopUp(){

		
	$joobiRedirect=WGlobals::get( 'joobiRedirect' );
	if( !empty($joobiRedirect)){

		$login=WGlobals::get( 'log' );
		$pwd=WGlobals::get( 'pas' );

		$creds=array();
		$creds['user_login']=$login;
		$creds['user_password']=$pwd;
		$creds['remember']=true;

		$current_user=wp_signon( $creds, false );

		$rtrn=WGlobals::get( 'rtrn' );

		$returnURL=ltrim( base64_decode( $rtrn ) , '?' );

		WPage::redirect( $returnURL );

		exit;

	}

	$isPopup=WGlobals::get( 'isPopUp' );
	$noheader=WGlobals::get( 'noheader' );
	if(( empty($isPopup) || $isPopup=='false' ) && empty($noheader)) return;

	
			$params=null;
	$namekey='';						
		WGlobals::set( 'resetForm', 'yes', 'global' );

	$content=WGet::startApplication( 'application', $namekey, $params );

	$js=JoobiWP::renderJS();
	$css=JoobiWP::renderCSS();


	$html='<!DOCTYPE html><html>';
	$html .='<header>';
	$html .=$css . $js;
	$html .='</header>';
	$html .='<body>';
	$html .=$content;
	$html .='</body>';
	$html .='</html>';

	echo $html;
	exit;

}


function joobiGetShortCodeFromPage($tag='',&$joobiPage){

	if( empty($tag)){
		return '';
	}
		$shortCode='';
		$matches=null;
		$pattern=get_shortcode_regex();

		if( strpos( $pattern, 'joobipage' )===false || strpos( $pattern, 'joobipage' )===false){
			$pattern=str_replace( 'embed|', 'embed|joobipage|joobiwidget', $pattern );
		}

		$gotPatterns=preg_match_all( '/'. $pattern .'/s', $tag, $matches );

		if( $gotPatterns
        && array_key_exists( 2, $matches )
        && in_array( 'joobipage', $matches[2] )){
                $shortCode=substr( $matches[3][0], 5, -1 );

			if( empty($shortCode)) return '';
			$shortCodeA=explode( '__', $shortCode );
			if( empty($shortCodeA )) return '';
			$AlreadyDoneA=array();
			foreach( $shortCodeA as $oneG){
				$oneGA=explode( '_', $oneG );
				if( !empty($oneGA[1])){
					if( 'ctrl'==$oneGA[0] ) $oneGA[0]='controller';
					WGlobals::set( $oneGA[0], $oneGA[1] );
					$AlreadyDoneA[$oneGA[0]]=$oneGA[1];
				}			}
			$joobiPage=true;

        }elseif( $gotPatterns
        && array_key_exists( 2, $matches )
        && in_array( 'joobiwidget', $matches[2] )){
                $shortCode=substr( $matches[3][0], 5, -1 );

			if( empty($shortCode)) return '';

			$joobiPage=false;

        }else{
        	        	return '';
        }
        return $shortCode;

}







function joobiAddPageContent($tag=''){
	static $option=null;



	if( empty($tag)){
		return '';
	}

		if( !isset($option)) $option=get_option( 'permalink_structure' );


	if( ! IS_ADMIN && !empty($option)){
		
		$joobiPage=null;
        $shortCode=joobiGetShortCodeFromPage( $tag, $joobiPage );

        if( empty($shortCode)) return '';


        if( ! $joobiPage){

        	$outputWidgetsC=WClass::get( 'output.widgets' );
        	$allWidgetsA=$outputWidgetsC->loadWidgetsFromNamekey( $this->_namekeyA );

						$mainWidgetM=WModel::get( 'library.widget' );
			$mainWidgetM->whereE( 'namekey', $shortCode );
			$oneWidget=$mainWidgetM->load( 'o', array( 'widgetid', 'params', 'namekey' ));	
			if( empty($oneWidget)) return '';

			$namekey=$oneWidget->namekey;
			WTools::getParams( $oneWidget );

			unset( $oneWidget->widgetid );
			unset( $oneWidget->namekey );

			$name=explode( '.', $oneWidget->namekey );
			if( sizeof($name) < 2 ) return '';

			$exists=WLoadFile( $name[0].'.module.'.$name[1].'.'.$name[1] , JOOBI_DS_NODE  );
			$className=ucfirst( $name[0] ) . '_' . ucfirst($name[1]).'_module';

			if( $exists && class_exists( $className )){

				WTools::getParams( $oneWidget );

				if( empty($oneWidget->widgetID)) $oneWidget->widgetID='wdgtalias_' . $count++;
				if( empty($oneWidget->widgetSlug)) $oneWidget->widgetSlug=str_replace( '.', '_', $oneWidget->namekey );

				$newClass=new $className( $oneWidget );
							}else{
				return '';
			}
			$newClass->create();

			return $newClass->content;

        }

                $specialOption='joobipg|' . str_replace( '__', '|', $shortCode );
        $page=get_option($specialOption );

		if( empty($page)) return '';


		$currentURL=WGlobals::get( 'REDIRECT_URL', null, 'server' );

		if( !empty($currentURL)){

			$newURL=substr( $currentURL, strlen(JOOBI_SITE_PATH));

			$urlA=explode( '/', $newURL );
			if( !empty($urlA)) foreach( $urlA as $k=> $v ) if( empty($v)) unset( $urlA[$k] );

			$allParent2RemoveA=array();

			$pageData=get_post( $page );
			$allParent2RemoveA[]=$pageData->post_name;

			if( !empty($pageData->post_parent)){

				$basePost=$pageData->post_name;

				$pageData=get_post( $pageData->post_parent );
				array_unshift( $allParent2RemoveA, $pageData->post_name );

				$baseURL=implode( '/', $allParent2RemoveA );
				WGlobals::set( JOOBI_PAGEID_NAME . '_post', $basePost );
				WGlobals::set( JOOBI_PAGEID_NAME . '_base', $baseURL );

			}
		if( !empty($allParent2RemoveA)){
			foreach( $allParent2RemoveA as $key=> $oneRev){
				if( $oneRev==$urlA[$key] ) unset( $urlA[$key] );
			}		}
		$urlA=array_values( $urlA );


			WGlobals::set( JOOBI_PAGEID_NAME, $page );


			if( !empty($urlA)){
				$arrayULR=WPage::interpretURL( $urlA );
				if( !empty($arrayULR)){
					foreach( $arrayULR as $k=> $v){
						if( !empty($v)){
							WGlobals::set( $k, $v );
						}					}				}
			}
		}

	}

	$controller=WGlobals::get( 'controller' );

	if( !empty( $controller )){

				WGlobals::set( 'resetForm', 'yes', 'global' );

				$params=null;
		$namekey='';
		$content=WGet::startApplication( 'application', $namekey, $params );

		$js=JoobiWP::renderJS();

	}else{

						$content=do_shortcode( $tag );

		$js='';
	}
		WGlobals::set( 'pageRendered', true, 'global' );


	return $js . $content;

		








}
add_filter( 'the_content', 'joobiAddPageContent' );

