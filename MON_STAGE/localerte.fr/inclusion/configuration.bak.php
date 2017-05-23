<?php
	define('CONFIGURATION_DEBUG',0);
	define('MAINTENANT',time());
	
	ini_set('error_reporting',E_ALL);
	ini_set('display_startup_errors','1');
	ini_set('log_errors_max_len',0);
	ini_set('ignore_repeated_errors','0');
	ini_set('ignore_repeated_source','0');
	ini_set('report_memleaks','1');
	ini_set('track_errors','0');
	ini_set('html_errors','1');
	//ini_set('docref_root','http://aide.intraneos.fr/php/');
	//ini_set('docref_ext','.html');
	ini_set('error_prepend_string','');
	ini_set('error_append_string','');
	ini_set('warn_plus_overloading','1');
	if(CONFIGURATION_DEBUG)
	{
		ini_set('display_errors','1');
		ini_set('log_errors','0');
		ini_set('error_log','');
	}
	else
	{
		ini_set('display_errors','0');
		ini_set('log_errors','1');
		ini_set('error_log',PWD_INCLUSION.'prive/log/php_error.log');
	}
	
	//ini_set('session.auto_start','1');
	ini_set('session.serialize_handler','php');
	ini_set('session.cookie_lifetime',0);
	ini_set('session.cookie_path','/');
	ini_set('session.cookie_domain','localerte.fr');
	ini_set('session.cookie_secure','0');
	ini_set('session.use_cookies','1');
	ini_set('session.use_only_cookies','0');
	ini_set('session.cache_limiter','nocache');
	ini_set('session.cache_expire','180');
	//ini_set('session.use_trans_sid','0');
	ini_set('session.save_handler','files');
	//ini_set('session.save_path',PWD_INCLUSION.'prive/temp');
	//ini_set('session.name','LA');
	session_start();
	
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	/*switch($_SERVER['SERVER_PROTOCOL'])
	{
		case 'HTTP/1.1':
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: post-check=0, pre-check=0', false);
			break;
		case 'HTTP/1.0':
			header('Pragma: no-cache');
			break;
	}*/
	header('Content-Language: fr');
	header('Content-Type: text/html; charset=iso-8859-1');
	
	@setlocale(LC_TIME,'fr_FR','fr');

	function url_use_trans_sid($chaine)
	{
		if(ini_get('session.use_trans_sid') && !isset($_COOKIE[session_name()]) && !preg_match('/^https?:\/\//',$chaine) && !preg_match('/(\?|&)'.preg_quote(session_name().'=').'/',$chaine))
			return $chaine.((strpos($chaine,'?')===false)?('?'):('&')).urlencode(session_name()).'='.urlencode(session_id());
		else
			return $chaine;
	}
	
	function moteur_de_recherche($chemin)
	{
		if(!isset($_SERVER['HTTP_USER_AGENT']) || preg_match('/(MSIE|Netscape|Opera|Firefox|Safari|Wanadoo|Firebird|Konqueror)/i',$_SERVER['HTTP_USER_AGENT']))
			return false;
		if(func_num_args() && func_get_arg(0))
		{
			$fichier=@fopen($chemin,'a');
			@fwrite($fichier,date('d/m/Y H:i:s',time()).'	'.$_SERVER['HTTP_USER_AGENT'].'	'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\r\n");
			@fclose($fichier);
		}
		return true;
	}
?>