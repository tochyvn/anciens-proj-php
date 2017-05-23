<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'fichier.php');
	
	function hexrgb($couleur)
	{
		$correspondance=array(1=>'r',2=>'g',3=>'b');
		preg_match('/#([A-F0-9]{2})([A-F0-9]{2})([A-F0-9]{2})/i',$couleur,$resultat);
		unset($resultat[0]);
		for($i=1;$i<4;$i++)
		{
			$resultat[$correspondance[$i]]=hexdec($resultat[$i]);
			unset($resultat[$i]);
		}
		return $resultat;
	}
	
	if(!function_exists('image_type_to_extension'))
	{
		function image_type_to_extension($imagetype,$include_dot=true)
		{
			if(empty($imagetype)) return false;
			$dot = $include_dot ? '.' : '';
			switch($imagetype)
			{
				case IMAGETYPE_GIF     : return $dot.'gif';
				case IMAGETYPE_JPEG    : return $dot.'jpg';
				case IMAGETYPE_PNG     : return $dot.'png';
				case IMAGETYPE_SWF     : return $dot.'swf';
				case IMAGETYPE_PSD     : return $dot.'psd';
				case IMAGETYPE_WBMP    : return $dot.'wbmp';
				case IMAGETYPE_XBM     : return $dot.'xbm';
				case IMAGETYPE_TIFF_II : return $dot.'tiff';
				case IMAGETYPE_TIFF_MM : return $dot.'tiff';
				case IMAGETYPE_IFF     : return $dot.'aiff';
				case IMAGETYPE_JB2     : return $dot.'jb2';
				case IMAGETYPE_JPC     : return $dot.'jpc';
				case IMAGETYPE_JP2     : return $dot.'jp2';
				case IMAGETYPE_JPX     : return $dot.'jpf';
				case IMAGETYPE_SWC     : return $dot.'swc';
				default                : return false;
			}
		}
	}	
	
	if(isset($_REQUEST['forme']))
	{
		switch($_REQUEST['forme'])
		{
			case 'rectangle':
				header('Last-Modified: '.gmdate('D, d M Y H:i:s',time()+365*24*60*60).' GMT');
				header('Expires: '.gmdate('D, d M Y H:i:s',time()+365*24*60*60).' GMT');
				header('Content-type: image/gif');
				
				$image=imagecreate($_REQUEST['x'], $_REQUEST['y']);
				$couleur=hexrgb($_REQUEST['c']);
				$couleur=imagecolorallocate($image,$couleur['r'],$couleur['g'],$couleur['b']);
				imagerectangle($image,0,0,$_REQUEST['x'],$_REQUEST['y'],$couleur);
				imagegif($image);
				break;
				
			case 'multirectangle':
				header('Content-type: image/gif');
				
				$image=imagecreate($_REQUEST['x'], $_REQUEST['y']);
				$couleur=hexrgb($_REQUEST['c']);
				$couleur=imagecolorallocate($image,$couleur['r'],$couleur['g'],$couleur['b']);
				imagefilledrectangle($image,0,0,$_REQUEST['x'],$_REQUEST['y'],$couleur);
				foreach($_REQUEST['r'] as $valeur)
				{
					$couleur=hexrgb($valeur['c']);
					$couleur=imagecolorallocate($image,$couleur['r'],$couleur['g'],$couleur['b']);
					imagefilledrectangle($image,$valeur['x1'],$valeur['y1'],$valeur['x2'],$valeur['y2'],$couleur);
				}
				imagegif($image);
				break;
			case 'vignette':
				ini_set('default_socket_timeout',1);
				ini_set('limit_memory','-1');
				session_write_close();
				
				$chemin=tempnam(PWD_INCLUSION.'prive/temp/','');
				@file_put_contents($chemin,file_get_contents($_REQUEST['url']));
				switch(@exif_imagetype($chemin))
				{
					default:
						$source=false;
						break;
					case IMAGETYPE_GIF:
						require_once(PWD_INCLUSION.'configuration.php');
						header('Content-type: image/gif');
						$source=imagecreatefromgif($chemin);
						$function='imagegif';
						break;
					case IMAGETYPE_JPEG:
						require_once(PWD_INCLUSION.'configuration.php');
						header('Content-type: image/jpg');
						//file_put_contents(PWD_INCLUSION.'prive/log/php_error.log','tain: '.$_REQUEST['url']."\r\n",FILE_APPEND);
						$source=imagecreatefromjpeg($chemin);
						$function='imagejpeg';
						break;
				}
				
				if(!$source)
				{
					unlink($chemin);
					$chemin=PWD_INCLUSION.'gd.gif';
					header('Content-type: image/gif');
					$source=imagecreatefromgif($chemin);
					$function='imagegif';
				}
				
				if(isset($_REQUEST['largeur']) && $_REQUEST['largeur']<imagesx($source))
				{
					$destination_x=$_REQUEST['largeur'];
					$destination_y=imagesy($source)/(imagesx($source)/$destination_x);
				}
				elseif(isset($_REQUEST['hauteur']) && $_REQUEST['hauteur']<imagesy($source))
				{
					$destination_y=$_REQUEST['hauteur'];
					$destination_x=imagesx($source)/(imagesy($source)/$destination_y);
				}
				else
				{
					$destination_x=imagesx($source);
					$destination_y=imagesy($source);
				}
				
				$destination=imagecreatetruecolor($destination_x,$destination_y);
				imagecopyresampled($destination,$source,0,0,0,0,$destination_x,$destination_y,imagesx($source),imagesy($source));
				
				call_user_func($function,$destination);
				
				if($chemin!=PWD_INCLUSION.'gd.gif') unlink($chemin);
				
				break;
			case 'antiflood':
				require_once(PWD_INCLUSION.'configuration.php');
				$complement='';
				if(isset($_SERVER['HTTP_REFERER']))
				{
					if(preg_match('/^'.regencode(HTTP_PUBLIC.'newsletter_ami.php').'/',$_SERVER['HTTP_REFERER']))
						$complement='newsletter_ami_';
				}
				if(isset($_SESSION[$complement.'code_antiflood']))
				{
					header('Content-type: image/jpeg');
					
					$image = imagecreate(72, 15);
					
					$blanc = imagecolorallocate($image, 238, 238, 238);
					$noir = imagecolorallocate($image, 0, 0, 0);
					$gris = imagecolorallocate($image, 128, 128, 128);
					
					imagefilledrectangle($image, 0, 0, 72, 25, $blanc);
					
					imagestring($image, 5, 12, 0, $_SESSION[$complement.'code_antiflood'], $noir);
					
					for($i=0;$i<150;$i++)
						imagesetpixel($image, rand(0,72), rand(0,25), $gris);
					
					imagejpeg($image);
				}
		}
	}
?>