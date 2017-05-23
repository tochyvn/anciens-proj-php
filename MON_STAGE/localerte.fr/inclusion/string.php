<?php
	define('STRING_FILTRE_ENTIER_POSITIF','^[0-9]+$');
	define('STRING_FILTRE_ENTIER','^-?[0-9]+$');
	define('STRING_FILTRE_DECIMAL_POSITIF','^[0-9]+(\.[0-9]+)?$');
	define('STRING_FILTRE_DECIMAL','^-?[0-9]+(\.[0-9]+)?$');
	define('STRING_FILTRE_MONNAIE_POSITIF','^[0-9]+(\.[0-9]{1,4})?$');
	define('STRING_FILTRE_MONNAIE','^-?[0-9]+(\.[0-9]{1,4})?$');
	define('STRING_FILTRE_DOMAINE','^(([0-9a-z]+([_-][0-9a-z]+)*)\.)?([0-9a-z]+([_-][0-9a-z]+)*\.[a-z]{2,4})$');
	define('STRING_FILTRE_IP','^([0-9]{1,2}|1[0-9]{2}|2[0-4][0-9]|25[0-5])(\.([0-9]{1,2}|1[0-9]{2}|2[0-4][0-9]|25[0-5])){3}$');
	define('STRING_FILTRE_URL','^[hH][tT][tT][pP][sS]?:\/\/([^:]+:[^@]*@)?([a-zA-Z0-9]+([.-][a-zA-Z0-9]+)*\.[a-zA-Z]{2,4}|([0-9]{1,2}|1[0-9]{2}|2[0-4][0-9]|25[0-5])(\.([0-9]{1,2}|1[0-9]{2}|2[0-4][0-9]|25[0-5])){3})(:[0-9]+)?(\/.*){0,1}$');
	define('STRING_FILTRE_COULEUR','^#[0-9A-F]{6}$');
	define('STRING_FILTRE_COULEUR_216','^#(00|33|66|99|CC|FF){3}$');
	define('STRING_FILTRE_EMAIL','^[a-zA-Z0-9]+([_.-][a-zA-Z0-9]+)*@[a-zA-Z0-9]+([.-][a-zA-Z0-9]+)*\.[a-zA-Z]{2,4}$');
	define('STRING_FILTRE_TELEPHONE_LAXISTE_FR','^(0[1-6789][^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[0-9]{2}([^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[0-9]{3}){2}|0[1-6789]([^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[0-9]{2}){4}|0[^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[1-6789][0-9]{2}([^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[0-9]{3}){2})$');
	define('STRING_FILTRE_TELEPHONE_TRES_LAXISTE','^(0[^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]*[1-6789]([^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]*[0-9]){8})$');
	define('STRING_FILTRE_TELEPHONE_STRICT_FR','^(0[1-679][0-9]{8}|080[059][0-9]{6})$');
	define('STRING_FILTRE_TELEPHONE_STRICT_FR_GSM','^0[67][0-9]{8}$');
	define('STRING_FILTRE_TELEPHONE_STRICT_FR_DOMICILE','^(0[1-59][0-9]{8})$');
	define('STRING_FILTRE_NON_MOT','[^\d\wÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]');
	define('STRING_FILTRE_SIRET','^[0-9]{3} [0-9]{3} [0-9]{3} [0-9]{5}$');
	define('STRING_FILTRE_CODE_POSTAL','^([0-8][0-9]|9[0-578])[0-9]{3}$');
	
	define('STRING_TROUVE_EMAIL','('.substr(STRING_FILTRE_EMAIL,1,strlen(STRING_FILTRE_EMAIL)-2).')');
	define('STRING_TROUVE_TELEPHONE_LAXISTE_FR','('.substr(STRING_FILTRE_TELEPHONE_LAXISTE_FR,1,strlen(STRING_FILTRE_TELEPHONE_LAXISTE_FR)-2).')');
	define('STRING_TROUVE_TELEPHONE_TRES_LAXISTE','('.substr(STRING_FILTRE_TELEPHONE_TRES_LAXISTE,1,strlen(STRING_FILTRE_TELEPHONE_TRES_LAXISTE)-2).')');
	define('STRING_TROUVE_TELEPHONE_STRICT_FR','('.substr(STRING_FILTRE_TELEPHONE_STRICT_FR,1,strlen(STRING_FILTRE_TELEPHONE_STRICT_FR)-2).')');
	define('STRING_TROUVE_URL','('.substr(STRING_FILTRE_URL,1,strlen(STRING_FILTRE_URL)-2).')');
	
	define('TAB',"\t");
	define('CR',"\r");
	define('LF',"\n");
	define('CRLF',CR.LF);
	
	define('STRING_DATETIME','d/m/y H:i:s');
	define('STRING_DATETIMECOMLPLET','%A %d %B %Y %H:%M');
	define('STRING_DATE','d/m/y');
	
	define('STRRND_MODE',1);
	
	function strrnd($longueur,$mode=STRRND_MODE)
	{
		$tableau=array();
		if($mode & 1)//1-9
		{
			for($i=48;$i<=57;$i++)
				$tableau[]=chr($i);
		}
		if($mode & 2)//A-Z
		{
			for($i=65;$i<=90;$i++)
				$tableau[]=chr($i);
		}
		if($mode & 4)//a-z
		{
			for($i=97;$i<=122;$i++)
				$tableau[]=chr($i);
		}
		$resultat='';
		if(sizeof($tableau))
			for($i=0;$i<$longueur;$i++)
				$resultat.=$tableau[mt_rand(0,sizeof($tableau)-1)];
		return $resultat;
	}
	
	function sans_accent($chaine)
	{
		return strtr($chaine, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'); 
	}
	
	function encrypt_text($chaine,$clef)
	{
		if(strlen($clef))
		{
			$resultat='';
			for($i=0;$i<strlen($chaine);$i++)
			{
				$caractere=ord(substr($chaine,$i,1));
				$caractere=$caractere+ord(substr($clef,($i%strlen($clef)),1));
				$resultat.=chr($caractere+'\xFF');
			}
		}
		else
			$resultat=$chaine;
		return $resultat;
	}
	function decrypt_text($chaine,$clef)
	{
		if(strlen($clef))
		{
			$resultat='';
			for($i=0;$i<strlen($chaine);$i++)
			{
				$caractere=ord(substr($chaine,$i,1));
				$caractere=$caractere-ord(substr($clef,($i%strlen($clef)),1));
				$resultat.=chr($caractere+'\xFF');
			}
		}
		else
			$resultat = $chaine;
		return $resultat;
	}
	
	function realpath_url($url,$lien)
	{
		if(preg_match('/^(http|https|ftp|ftps):\/\/.+/i',$lien))
			return $lien;
		
		if(preg_match('/^\?/i',$lien))
			return $url.$lien;
		
		if(!preg_match('/^(http|https|ftp|ftps):\/\/.+/i',$url))
			return false;
		
		$parse_url=parse_url($url);
		
		if(!isset($parse_url['host']))
			return false;
		
		if(!isset($parse_url['path']))
			$parse_url['path']='';
		
		$position_slashe=strrpos($parse_url['path'],'/');
		$position_point=strrpos($parse_url['path'],'.');
		if($position_point>$position_slashe)
			$parse_url['path']=substr($parse_url['path'],0,$position_slashe);
		
		$parse_url['path']=preg_replace(array('/^\//','/\/$/'),array('',''),$parse_url['path']);

		$parse_lien=preg_replace('/^\.\//','',$lien);
		
		$rebuild_url=$parse_url['scheme'].'://'.((isset($parse_url['user']) || isset($parse_url['pass']))?(((isset($parse_url['user']))?($parse_url['user']):('')).':'.((isset($parse_url['pass']))?($parse_url['pass']):('')).'@'):('')).$parse_url['host'].((isset($parse_url['port']))?(':'.$parse_url['port']):('')).'/';
		
		if(strpos($parse_lien,'../')===false && strpos($parse_lien,'/')===false)
			return $rebuild_url.$parse_url['path'].(($parse_url['path']!='')?('/'):('')).$parse_lien;
		elseif(strpos($parse_lien,'/')===0)
			return $rebuild_url.substr($parse_lien,1);
		else
		{
			$nombre=substr_count($lien,'../');
			
			$dossier=explode('/',$parse_url['path']);
			
			if($nombre>sizeof($dossier))
				return false;
			
			$chemin='';
			for($i=0;$i<=sizeof($dossier)-$nombre-1;$i++)
				$chemin.=$dossier[$i].'/';
			return $rebuild_url.$chemin.str_replace('../','',$parse_lien);
		}
	}
	
	function regencode($chaine)
	{
		$recherche=array('/','.','+','*','?','^','$','|','(',')','[',']','{','}');
		$remplacement=array('\/','\.','\+','\*','\?','\^','\$','\|','\(','\)','\[','\]','\{','\}');
		return str_replace($recherche,$remplacement,$chaine);
	}
	
	function flword($chaine)
	{
		$retour=array();
		$tableau=str_word_count($chaine,2);
		foreach($tableau as $valeur)
			if($valeur!='')
				$retour[]=substr($valeur,0,1);
		return $retour;
	}
	
	if(!function_exists('http_build_query'))
	{
	   	function http_build_query($formdata,$numeric_prefix=NULL,$key=NULL)
	   	{
		   	$res=array();
		   	foreach((array)$formdata as $k=>$v)
		   	{
			   	$tmp_key=urlencode(is_int($k)?$numeric_prefix.$k:$k);
			   	if($key)
				   	$tmp_key=$key.'['.$tmp_key.']';
			   	if(is_array($v) || is_object($v))
				   	$res[]=http_build_query($v,NULL,$tmp_key);
			   	else
				   	$res[]=$tmp_key."=".urlencode($v);
		   	}
		   	return implode("&",$res);
	   	}
	}
	
	if(!function_exists('stripos'))
	{
	   	function stripos($str,$needle,$offset=0)
		{
			return strpos(strtolower($str),strtolower($needle),$offset);
		}
	}
	
	if(!function_exists('str_ireplace'))
	{
	   	function str_ireplace($search,$replace,$subject)
	   	{
			$search=regencode($search);
			return preg_replace('/'.$search.'/i',$replace,$subject);
	   	}
	}
	
	function formater($chaine,$type)
	{
		switch($type)
		{
			case 'siret':
				return preg_replace('/^([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{5})$/','\\1 \\2 \\3 \\4',str_replace(' ','',$chaine));
				break;
			case 'telephone':
				return str_replace(array(' ','.','-','/'),array('','','',''),$chaine);
				break;
			case 'decimal':
			case 'monnaie':
				return str_replace(' ','',str_replace(',','.',$chaine));
				break;
			case 'date':
				return intval($chaine);
				break;
			case 'telephone_espace':
				return preg_replace('/^([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$/','$1 $2 $3 $4 $5',$chaine);
				break;
		}
	}
	
	function octet_format($valeur)
	{
		$tableau=array();
		$tableau[]='o';
		$tableau[]='Ko';
		$tableau[]='Mo';
		$tableau[]='Go';
		$tableau[]='To';
		
		for($i=1; $i<sizeof($tableau) && $valeur>1000;$i++)
			$valeur/=1024;
		
		return number_format($valeur,2).$tableau[$i-1];
	}
	
	if(!function_exists('hmac_md5'))
	{
		function hmac_md5($data,$key='')
		{
			// RFC 2104 HMAC implementation for php.
			// Creates an md5 HMAC.
			// Eliminates the need to install mhash to compute a HMAC
			// Hacked by Lance Rushing
		
			$b = 64; // byte length for md5
			if (strlen($key) > $b) {
				$key = pack("H*",md5($key));
			}
			$key  = str_pad($key, $b, chr(0x00));
			$ipad = str_pad('', $b, chr(0x36));
			$opad = str_pad('', $b, chr(0x5c));
			$k_ipad = $key ^ $ipad ;
			$k_opad = $key ^ $opad;
		
			return md5($k_opad  . pack("H*",md5($k_ipad . $data)));
		}
	}
?>