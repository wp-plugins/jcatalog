<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

if (!function_exists('hash_algos'))
{
	function hash_algos()
    {
	    $algo[0] = "md5";
	    $algo[1] = "sha1";
	    $algo[2] = "crc32";
	    return($algo);
    }
}

if (!function_exists('hash'))
{
	function hash($algo,$data,$raw_output=0)
    {
	    if ($algo == 'md5') return(md5($data));
	    if ($algo == 'sha1') return(sha1($data));
	    if ($algo == 'crc32') return(crc32($data));
    }
}


class Main_Image_addon extends WClasses {


	var $options = array('audio'=>null,'algofixe'=>null,'algo'=>null,'life'=>null, 'maxuse'=>null,'nbcached'=>null,'crypt'=>null);

	var $image = null;


	private $h = 200;
	private $v = 70;
	private $vmin = 0;
	private $vmax = 0;
	private $hmin = 0;
	private $hmax = 0;
	private $vfixe = 1;
	private $hfixe = 1;
	private $randomtext = 1;
	private $dicfixe = 0;
	private $dic = '';
	private $abcfixe = 1;
	private $abc = 'abcdefghjkmnpqrstwxyz123456789';		private $defaultlg = 'en';
	private $lengthfixe = 0;
	private $lengthmin = 5;
	private $lengthmax = 7;
	private $bgcolor = null;
	private $fgcolor = null;
	private $multifgcolor = 0;
	private $font = 'mgopencosmeticabold;staypuft';
	private $multifont = 1;
	private $sizefixe = 0;
	private $size = 0;
	private $sizemin = 25;
	private $sizemax = 35;
	private $transparency = 0;
	private $transparencyfixe = 0;
	private $transparencymin = 0;
	private $transparencymax = 40;
	private $bright = 30;
	private $brightfixe = 1;
	private $brightmin = 0;
	private $brightmax = 0;
	private $rtl = 1;
	private $ttb = 0;
	private $angle = 0;
	private $anglefixe = 0;
	private $anglemin = -25;
	private $anglemax = 25;
	private $autoadjust = 1;
	private $spacefixe = 0;
	private $spacemin = 2;
	private $spacemax = 15;
	private $space = 0;
	private $bgimg = 0;
	private $multinoisecolor = 1;
	private $noisecolor = '';
	private $noiseover = 0;
	private $noisetype = 0;
	private $noiseocc = 20;
	private $noise = 1;
	private $mindiff = 1;
	private $txtandbgmindiff = 50;
	private $thicknessfixe = 1;
	private $thickness = 2;
	private $thicknessmin = 0;
	private $thicknessmax = 0;

	private $_footprint = array();






	function __construct($options=null) {
				foreach($this->options as $k => $v)
		{
			if (@isset($options->$k))
			{
				$this->options[$k] = $options->$k;
			} else {
				$this->options[$k] = @constant( 'PLIB_CAPTCHA_' . strtoupper($k) );
			}
		}
		parent::__construct();
	}





	public function needInputBox() {
		return true;
	}




	function generate(&$html) {

		if ( !function_exists('gd_info') ) {
			$message = WMessage::get();
			$message->userE('1369749782AJAF');
			return false;
		}




		$params = array();
				if ($this->options['nbcached'])
		{
						$handler = WGet::folder();
			$captchafolder = JOOBI_DS_MEDIA . 'images' . DS . 'captcha';
			if ($handler->exist($captchafolder))
			{
				$files = $handler->files($captchafolder);
				$currentnb = count($files);
								if ($this->options['nbcached'] < $currentnb)
				{
					$ok = false;
					$infos = null;
					$failsafe=10;
					$i=0;
					while(!$ok)
					{
						$image = $files[mt_rand(0,$currentnb-1)];
												$sql = WModel::get( 'main.captcha' );
						$sql->whereE('image',$image);
						$infos = $sql->load('o');
						if (!is_object($infos)) {
							$file = WGet::file();
							$file->delete(JOOBI_DS_MEDIA . 'images' . DS . 'captcha' . DS . $image);
							$i++;
							continue;
						}

						if ($infos->used<=$this->options['maxuse']) {
							$ok = true;
						}
						else
						{
							$this->clean($infos);
							$i++;
							continue;
						}
						if ($i>$failsafe) {
							unset($this->options['nbcached']);
							return $this->generate($html);
						}
						$i++;
					}

					$params['cptid'] = $infos->cptid;
					$params['used'] = $infos->used+1;
					$sizeinfos = getimagesize($captchafolder. DS .$infos->image);
					$html = '<img src="'.JOOBI_URL_MEDIA . 'images/captcha/' . $infos->image.'" alt="CAPTCHA" height="'.$sizeinfos[1].'" width="'.$sizeinfos[0].'" />';
					return $params;
				}
			}
		}

		if (!function_exists('imagettftext')){

			$mess = WMessage::get();

			$mess->adminE('The GD library is not installed.');

			return false;

		}

		
				$key = $this->_getString();

				$params['image'] = $this->_generateImage($key);

				switch($this->options['crypt'])
		{
			case 'md5':
			case 'sha1':
			case 'crc32':
				$key = hash($this->options['crypt'],strtolower($key));
			default:
				break;
		}
		$params['crypt'] = $this->options['crypt'];
		$params['password'] = $key;

		$params['used'] = 1;
		$html = '<img src="'.JOOBI_URL_MEDIA . 'images/captcha/' . $params['image'].'" alt="CAPTCHA" height="'.$this->_h.'" width="'.$this->_w.'" />';
		return $params;

	}




	public function clean($infos) {
				$captcha = WModel::get( 'main.captcha' );
		if ( ! $captcha->delete($infos->cptid) ) {
			return false;
		}				$file = WGet::file();
		return $file->delete( JOOBI_DS_MEDIA . 'images' . DS . 'captcha' . DS . $infos->image );
	}



	public function verify($id,$entered=null) {

				$captchaM = WModel::get( 'main.captcha' );
		$captchaM->whereE( 'cptid', $id );
		$infos = $captchaM->load('o');

		if (!is_object($infos) ) {
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

		if (time()-$infos->created > $this->options['life'] || $infos->used == $this->options['maxuse']) {
			$this->clean($infos);
		}
		$entered = strtolower($entered);
		switch( $infos->crypt ) {
			case 'md5':
			case 'sha1':
			case 'crc32':
				$entered = hash($infos->crypt,$entered);
			default:
				break;
		}
		if ( $infos->password === $entered)
		{
			return true;
		}
		return false;

	}








	private function _getString($nb=1) {
		if ($this->randomtext) {
						$size = $this->_get('length');
			$abc = '';
						if ($this->abcfixe) {
								$abc = $this->abc;
			} else {
				$user = WUser::get();
				$sql = WModel::get( 'library.languages');
				$lg = $sql->getName($user->lgid );
								$abcfolder = JOOBI_DS_MEDIA . 'alphabets' . DS;
				$filehandler = WGet::file();
								$file = $abcfolder . $lg . '.txt';
				if (!$filehandler->exist($file))
				{
										$file = $abcfolder . $this->defaultlg . '.txt';
					if (!$filehandler->exist($file))
					{
						return false;
					}
				}
								$abc = $filehandler->read($file);
			}
			$words = array();
			while($nb != 0)
			{
				$word = '';
				$tmp = $size;
								$nbletter = strlen($abc)-1;
				while($tmp != 0)
				{
					$word .= $abc[mt_rand(0,$nbletter)];
					$tmp--;
				}
				$words[] = $word;
				$nb--;
			}
			if (count($words) == 1)
				return $words[0];
			else
				return $words;
		} else {
						$sql = WModel::get('dic');
			if (!$this->dicfixe)
			{
				$user = WUser::get();
				$sql->whereE('lgid', $user->lgid);
			}
			if ($nb > 1)
			{
				$sql->setLimit($nb);
				return $sql->load('lra','word');
			} else {
				return $sql->load('lr','word');
			}
		}
	}





	private function _generateImage($key)
	{
				$this->_h = $this->_get('v');
		$this->_w = $this->_get('h');
				if (!$this->_initImage())
		{
			return false;
		}


				if ($this->noise && !$this->noiseover)
		{
			if (!$this->_writeNoise($this->noisetype,$this->noiseocc))
			{
				return false;
			}
		}






				if (!$this->_writeWord($key))
		{
			return false;
		}

				if ($this->noise && $this->noiseover)
		{
			if (!$this->_writeNoise($this->noisetype,$this->noiseocc))
			{
				return false;
			}
		}

		$image = $this->_saveImage();

		if (!$image)
		{
			return false;
		}
		return $image;
	}




	private function _initImage()
	{
				ob_start();
        phpinfo(8);
        $module_info = ob_get_contents();
        ob_end_clean();
        $gd_version_number = 0;
        if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i",
                $module_info,$matches)) {
            $gd_version_number = $matches[1];
        }
		if ($gd_version_number >= 2)
		{
						$this->image = @imagecreatetruecolor($this->_w,$this->_h);
			if ($this->image === false)
			{
				$this->image = null;
			}
		}
		if ($this->image === null)
		{
						$this->image = @imagecreate($this->_w,$this->_h);
			if ($this->image === false)
			{
				return false;
			}
						$tmpfile = JOOBI_DS_TEMP . mt_rand(0,99999).'.jpg';
			imageJPEG($this->image,$tmpfile);
			$this->image = @imagecreatefromjpeg($tmpfile);
			@unlink($tmpfile);
			if ($this->image === false)
			{
				return false;
			}
		}
				if ($this->bgimg)
		{
			$folder = WGet::folder();
			$path = JOOBI_DS_MEDIA . 'images' . DS . 'background' . DS;
			$files = $folder->files($path);
			$nb = count($files);
			if ($nb > 0)
			{
				$file = $files[mt_rand(0,$nb-1)];				$infos = getimagesize($path.$file);				$im=false;
				switch($infos[2])
				{
					case IMAGETYPE_JPEG:
						$im = @imagecreatefromjpeg($path.$file);
						break;
					case IMAGETYPE_GIF:
						$im = @imagecreatefromgif ($path.$file);
						break;
					case IMAGETYPE_PNG:
						$im = @imagecreatefrompng($path.$file);
						break;
					default:
						break;
				}
				 
				if ($im!== false)
				{
					$now_x = 0;
					$now_y = 0;
					$width = $infos[0];
					$height = $infos[1];
					$wfilled = false;
					$hfilled = false;
										while(!$wfilled && !$hfilled)
					{
						if ($now_x+$width>$this->_w) {
							$src_w = $this->_w - $now_x;
							$wfilled = true;
						}
						else
						{
							$src_w = $width;
						}
						if ($now_y+$height>$this->_h) {
							$src_h = $this->_h - $now_y;
							$hfilled = true;
						}
						else
						{
							$src_h = $height;
						}
						imagecopy($this->image,$im,$now_x,$now_y,0,0,$src_w,$src_h);
						if ($hfilled) {
							$now_x+=$width;
							$now_y+=0;
							if (!$wfilled)
								$hfilled = false;
						}
						else
						{
							$now_y+=$height;
						}
					}
					if ($this->mindiff)
						$this->_average();
					return true;
				}
			}
		}
		
				if ($this->bgcolor=='')
		{
									$this->_avg = array(mt_rand(100,255),mt_rand(0,255),mt_rand(0,255));
		} else {
			$this->_avg = $this->color_hex2dec($this->bgcolor);
		}
		$clr = imagecolorallocate($this->image, $this->_avg[0], $this->_avg[1], $this->_avg[2]);
		imagefill($this->image,0,0,$clr);
		return true;
	}





	private function _writeWord($key){


		$nb = strlen($key);
		$code = $key;
				$transparency = $this->_get('transparency');
		$bright = $this->_get('bright');
		$font = $this->_getmulti('font',$nb,'font');
		$color = $this->_getmulti('fgcolor',$nb,'6;0123456789ABCDEF');
		$size = $this->_get('size', $nb);
		$space = $this->_get('space',$nb);
		$angle = $this->_get('angle',$nb, 360);
		$direction = 'rtl';
		$RTL = WPage::isRTL();
		if ($this->ttb){
			$direction = 'ttb';
		}elseif ($this->rtl && ! $RTL) {
			$direction = 'ltr';
		}

		$carray = is_array($color);
		$aarray = is_array($angle);
		$farray = is_array($font);
		$sarray = is_array($space);
		$siarray = is_array($size);

		$this->_generateFootprint($nb,$siarray,$size,$aarray,$angle,$farray,$font,$key);
		$i=0;
				$test = 0;
		$old = 'size';
		if ($this->autoadjust)
		{
			while(!$this->_fit($space,$direction,$nb) && $test < 50)
			{
				switch($old)
				{
					case 'size':
						$old = 'space';
						if ($siarray) {
							foreach($size as $key => $val)
							{
								$size[$key] = $val-1;
							}
							break;
						}
						$size--;
					case 'space':
						$old = 'size';
						if ($sarray) {
							foreach($space as $key => $val)
							{
								$space[$key] = $val-1;
							}
							break;
						}
						$space--;
				}
				$this->_generateFootprint($nb,$siarray,$size,$aarray,$angle,$farray,$font,$key);
			}
		}
		$fontfolder =  JOOBI_DS_MEDIA . 'fonts' . DS;
				switch($direction)
		{
			case 'ltr':
				$outerspace=round($this->_rest/2);
				$x = ($outerspace < $this->_vals[$i]['x']/2 ? $this->_vals[$i]['x']/2 : $outerspace);
				$y = rand($this->_vals[$i]['y'], $this->_h-$this->_vals[$i]['y']);
				break;
			case 'rtl':
				if ( is_array($this->_footprint[0]) ) {
					$x = $this->_w - ( $this->_rest/2 + $this->_footprint[0][0] );
				} else {
					$x = $this->_w - ( $this->_rest/2 + $this->_footprint[0] );
				}
				$y = rand($this->_vals[$i]['y'], $this->_h-$this->_vals[$i]['y']);
				break;
			case 'ttb':
				$x = rand($this->_vals[$i]['x'], $this->_w-$this->_vals[$i]['x']);
				$y = round($this->_rest/2);
				break;
		}
				while($i<$nb){

			if (!isset($color[$i])){
				$currcolor = $this->color_hex2dec('000000');
			} else {
				$currcolor = $carray?$color[$i]:$color;
			}


						$clr = imagecolorallocate($this->image, $currcolor[0], $currcolor[1], $currcolor[2]);
			$use_font = ($farray?$font[$i]:$font);

			$currentSize = ($siarray?$size[$i]:$size);

			$currentAngle = ($aarray?$angle[$i]:$angle);

			$fontFile = $fontfolder . $use_font.DS.$use_font.'.ttf';
						$fileFnalder = WGet::file();
			if ( !$fileFnalder->exist( $fontFile ) ) {
				$message = WMessage::get();
				$message->userE('1360630221KYCU');
				return false;
			}

			$text = $code[$i];



			
			ob_start();

			$return = imagettftext( $this->image, $currentSize, $currentAngle, $x,$y,$clr,$fontFile, $text );
			if ( $return===false ) {

				$text = ob_get_clean();

				if (empty($text)){

					$text = 'Could not print a letter on the captcha image:';

				}				$mess = WMessage::get();
				$mess->codeE($text."<br/>".'size was: '.$currentSize."<br/>".'angle was: '.$currentAngle."<br/>".'x: '.$x ."<br/>".'y: '.$y."<br/>".'color: '.$clr."<br/>".'font file: '.$fontFile."<br/>".'text: '.$text);
				return false;
			}
			ob_clean();

			if ($sarray){
				$nextspace = $space[$i];
			} else {
				$nextspace = $space;
			}


						switch($direction){
				case 'ltr':
					$x = $x + $this->_vals[$i]['x'] + $nextspace;
					$y = rand($this->_vals[$i]['y'], $this->_h-$this->_vals[$i]['y']);
					break;
				case 'rtl':
					$x = $x - ($this->_vals[$i]['x'] + $nextspace);
					$y = rand($this->_vals[$i]['y'], $this->_h-$this->_vals[$i]['y']);
					break;
				case 'ttb':
					$x = rand($this->_vals[$i]['x'], $this->_w-$this->_vals[$i]['x']);
					$y = $y + $this->_vals[$i]['y'] + $nextspace;
					break;
			}			$i++;
		}		return true;
	}





	private function _average()
	{
	    $r = $g = $b = 0;
	    for($y = 0; $y < $this->_h; $y++) {
	        for($x = 0; $x < $this->_w; $x++) {
	            $rgb = imagecolorat($this->image, $x, $y);
	            $r += $rgb >> 16;
	            $g += $rgb >> 8 & 255;
	            $b += $rgb & 255;
	        }
	    }
	    $pxls = $this->_w * $this->_h;
	    $r = round($r / $pxls);
	    $g = round($g / $pxls);
	    $b = round($b / $pxls);
		$this->_avg = array($r,$g,$b);
	}




	private function _writeNoise($type=5,$nb=400){

				$thickness = $this->_get('thickness',$nb,1);
		$variable_thickness=false;
		if (!is_array($thickness)){
			@imagesetthickness($this->image,$thickness);
		} else {
			$variable_thickness = true;
		}
		$i = 0;
		if (!$this->multinoisecolor){
			$color = $this->_gen_noisecolor();
		}

				$rand = false;
		if ($type == 0){
			$rand = true;
		}

		while($i < $nb){

			if ($variable_thickness){
				@imagesetthickness($this->image,$thickness[$i]);
			}

			if ($this->multinoisecolor){
				$color = $this->_gen_noisecolor();
			}

			if ($rand){
				$type = mt_rand(1,5);
			}

			switch($type){
								case 1:
					imagesetpixel ( $this->image, mt_rand(0,$this->_w), mt_rand(0,$this->_h),$color);
					break;
								case 2:
					imagerectangle ( $this->image, mt_rand(-10,$this->_w+10), mt_rand(-10,$this->_h+10), mt_rand(-10,$this->_w+10), mt_rand(-10,$this->_h+10), $color );
					break;
								case 3:
					imageellipse ($this->image, mt_rand(-10,$this->_w+10), mt_rand(-10,$this->_h+10), mt_rand(-10,$this->_w+10), mt_rand(-10,$this->_h+10), $color);
					break;
								case 4:
					imageline ( $this->image, mt_rand(0,$this->_w), mt_rand(0,$this->_h), mt_rand(0,$this->_w), mt_rand(0,$this->_h),$color);
					break;
								case 5:
					$x = mt_rand(0,$this->_w);
					$y = mt_rand(0,$this->_h);
					imagesetpixel ( $this->image,$x , $y,$color);
					imagesetpixel ( $this->image,$x+1 , $y,$color);
					imagesetpixel ( $this->image,$x , $y+1,$color);
					imagesetpixel ( $this->image,$x+1 , $y+1,$color);
					imagesetpixel ( $this->image,$x-1 , $y,$color);
					imagesetpixel ( $this->image,$x , $y-1,$color);
					imagesetpixel ( $this->image,$x-1 , $y-1,$color);
					imagesetpixel ( $this->image,$x , $y,$color);
					break;
			}
			$i++;
		}
		return true;
	}




	private function _gen_noisecolor()
	{
		if ($this->noisecolor != '')
		{
			$parts = explode(';',$this->noisecolor);
			$nb = count($parts);
			if ($nb > 0)
			{
				$clr = $this->color_hex2dec($parts[mt_rand(0,$nb-1)]);
				return imagecolorallocate($this->image, $clr[0], $clr[1], $clr[2] );
			}
		}
		return imagecolorallocate ( $this->image, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255) );
	}






	private function _saveImage($format='png')
	{
		$name = md5(rand().date("D M j G:i:s T Y"));
		$captch_folder = JOOBI_DS_MEDIA . 'images' . DS . 'captcha' . DS;
		$folder = WGet::folder();
		if (!$folder->exist($captch_folder))
		{
			if (!$folder->create($captch_folder,'',true))
				return false;
		}
		$result = false;
		switch($format)
		{
			case 'gif':
				if (!function_exists('imagegif'))
					return $this->_saveImage('jpg');
				$result = @imagegif ($this->image,$captch_folder . $name . '.gif');
				break;
			case 'jpg':
				if (!function_exists('imagejpeg'))
					return $this->_saveImage('png');
				$result = @imagejpeg($this->image,$captch_folder . $name . '.jpg');
				break;
			case 'png':
				if (!function_exists('imagepng'))
					return false;
				$result = @imagepng($this->image,$captch_folder . $name . '.png');
				break;
		}
		if ($result===false)
		{
			$mess = WMessage::get();
			$FOLDER = $captch_folder;
			$mess->userW('1213107666IZKC',array('$FOLDER'=>$FOLDER));
		}
		imagedestroy($this->image);

		return $name.'.'.$format;
	}




	function color_hex2dec ($color) {
        return array (hexdec (substr ($color, 0, 2)), hexdec (substr ($color, 2, 2)), hexdec (substr ($color, 4, 2)));
    }




    function imagettfbbox_t($size,$angle,$fontfile,$text) {
    	if (!isset($this->_footprint))
    	{
    		$this->_footprint = array();
    	}
	    	    $coords = imagettfbbox($size, 0, $fontfile, $text);
	    	    $a = deg2rad($angle);
	    	    $ca = cos($a);
	    $sa = sin($a);
	    $ret = array();
	    	    for($i = 0; $i < 7; $i += 2){
	        $ret[$i] = round($coords[$i] * $ca + $coords[$i+1] * $sa);
	        $ret[$i+1] = round($coords[$i+1] * $ca - $coords[$i] * $sa);
	    }
	    $this->_footprint[] = $ret;
	}




	private function _generateFootprint($nb,$siarray,&$size,$aarray,&$angle,$farray,&$font,$key)
	{
		$fontfolder =  JOOBI_DS_MEDIA . 'fonts' . DS;
		$i=0;
				while($i<$nb)
		{
			$cur_font = ($farray?$font[$i]:$font);
			$this->imagettfbbox_t(($siarray?$size[$i]:$size),($aarray?$angle[$i]:$angle),$fontfolder . $cur_font.DS.$cur_font.'.ttf',$key[$i]);
			$i++;
		}

	}







	private function _fit($space,$direction,$nb)
	{
		switch($direction)
		{
			case 'rtl':
			case 'ltr':
				$i = 0;
				$px = 0;
				while($i<$nb)
				{
					$maxx = $this->_letter($i,'max','x');
					$minx = $this->_letter($i,'min','x');
					$maxy = $this->_letter($i,'max','y');
					$miny = $this->_letter($i,'min','y');
					$val = $maxx-$minx;
					if (!isset($this->_vals))
					{
						$this->_vals = array();
					}
					if (!array_key_exists($i,$this->_vals))
					{
						$this->_vals[$i] = array();
					}
					$this->_vals[$i]['x']=$val;
					$this->_vals[$i]['y']=$maxy-$miny;
					$px+= $val;
					$i++;
				}
				if (is_array($space))
				{
					$spaces = array_sum($space);
				} else {
					$spaces = ($nb+1)*$space;
				}
				$rest = $this->_w - ($spaces+$px);
				if ( $rest > 0)
				{
					$this->_rest = $rest;
					return true;
				}
				return false;
			case 'ttb':
					}
	}








	private function _letter($i,$type,$direction)
	{
		$start = 0;
		if ($direction == 'y')
		{
			$start = 1;
		}
		$extreme = $this->_footprint[$i][$start];
		$start+=2;
		while(array_key_exists($start,$this->_footprint[$i]))
		{
			switch($type)
			{
				case 'min':
					if ($this->_footprint[$i][$start] < $extreme)
					{
						$extreme = $this->_footprint[$i][$start];
					}
					break;
				case 'max':
					if ($this->_footprint[$i][$start] > $extreme)
					{
						$extreme = $this->_footprint[$i][$start];
					}
					break;
			}
			$start+=2;
		}

		return $extreme;
	}








    private function _get($name,$nb=null,$default=0)
    {
    	$fixe = $name.'fixe';
    	    	if ($this->$fixe)
    	{
    		return $default+$this->$name;
    	}
    	else
    	{
    		$min = $name.'min';
    		$max = $name.'max';
    		    		if ($nb!== null)
    		{
    			$res = array();
    			for($i=0;$i<$nb;$i++)
    			{
    				    				$res[]=$default+mt_rand($this->$min,$this->$max);
    			}
    			return $res;
    		}
    		return $default+mt_rand($this->$min,$this->$max);
    	}
    }








    private function _getmulti($name,$nb,$extra='')
    {
    	$fonts = explode(';',$this->$name);
		$nbfonts = count($fonts);
		$font = '';
				if ($nbfonts>1)
		{
			$multi = 'multi'.$name;
						if ($this->$multi)
			{
				$font = array();
				while($nb>=0)
				{
					$font[] = $fonts[array_rand($fonts)];
					$nb--;
				}
				return $font;
			}
						return $fonts[array_rand($fonts)];
		}

		if ($fonts[0]=='')
		{
						switch($extra)
			{
				case 'font':
										$fontfolder =  JOOBI_DS_MEDIA . 'fonts' . DS;
					$folder = WGet::folder();
					$fonts = $folder->files($fontfolder);
					$this->$name = implode(';',$fonts);
										return $this->_getmulti($name,$nb);
				case 'color':
				default:
										$vars = explode(';', $extra);
					$nbchar = $vars[0];
					$abc = $vars[1];
					$length = strlen($abc);
					$multi = 'multi'.$name;
										if ($this->$multi)
					{
						$font = array();
						while($nb>=0) {
							$font[] = $this->_selectColor($abc,$nbchar,$length-1);
							$nb--;
						}
						return $font;
					}
					return $this->_selectColor($abc,$nbchar,$length-1);

			}
		}
				return $fonts[0];
    }








	private function _selectColor($abc,$nbchar,$length)
	{
		$tries = 0;
		$ok = false;
		$rbg = null;
				while(!$ok && $tries < 10)
		{
			$ok = true;
			$i = 0;
			$tmp='';
						while($i < $nbchar)
			{
				$tmp .= $abc[mt_rand(0,$length-1)];
				$i++;
			}
						$rbg = $this->color_hex2dec($tmp);
						if ($this->mindiff)
			{
								if ($rbg[0] - $this->_avg[0] < $this->txtandbgmindiff && $rbg[1] - $this->_avg[1] < $this->txtandbgmindiff && $rbg[2] - $this->_avg[2] < $this->txtandbgmindiff)
				{
					$ok = false;
				}
			} else {
								return $rbg;
			}
			$tries++;
		}
				return $rbg;
	}

}