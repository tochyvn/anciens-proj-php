<?php
	define('KEYVALUE','05f5e89b08ac16913c16bc3d1a1b12c0');
	
	require_once(PWD_INCLUSION.'configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$mode=str_replace('/wha_','',$_SERVER['REDIRECT_URL']);
	file_put_contents(PWD_INCLUSION.'prive/log/wha_tmp.log',$_SERVER['REQUEST_URI']."\r\n", FILE_APPEND);
	
	switch($mode)
	{
		case 'confirmation':
		case 'annulation':
			$url=parse_url($_SERVER['REQUEST_URI']);
			$url['query']=$_SERVER['QUERY_STRING'];
			
			if(isset($url['query']))
			{
				$query='';
				$retour='';
				$redirection='';
				$segment=explode('&',$url['query']);
				for($i=0;$i<sizeof($segment);$i++)
				{
					if(strpos($segment[$i],'=')!==false) list($variable,$valeur)=explode('=',$segment[$i]);
					else{$variable=$segment[$i]; $valeur='';}
					
					$variable=urldecode($variable);
					$valeur=urldecode($valeur);
					
					if(strpos($variable,'mp_')===0 && $variable!='mp_wha_desc2' && $variable!='mp_securite')
					{
						if($variable=='mp_r')
							$redirection=$valeur;
						else
						{
							if($retour!='') $retour.='&';
							$retour.=urlencode(preg_replace('/^mp_/','',$variable)).'='.urlencode($valeur);
						}
					}
					
					if($variable!='hmac')
					{
						if($query!='') $query.='&';
						$query.=urlencode($variable).'='.urlencode($valeur);
					}
				}
				
				if(isset($_REQUEST['hmac']) && $_REQUEST['hmac']==hmac_md5($query,KEYVALUE))
				{
					unset($_SESSION['WHA_PAYE']);
					if($mode=='confirmation')
					{
						$fichier=fopen(PWD_INCLUSION.'prive/log/wha.log','a');
						fputs($fichier,date('Y-m-d H:i:s',MAINTENANT).' '.$redirection.((strpos($redirection,'?')===false)?('?'):('&')).$retour.CRLF);
						fclose($fichier);
						$_SESSION['WHA_PAYE']='';
					}
				}
				
				header('location: '.url_use_trans_sid($redirection.((strpos($redirection,'?')===false)?('?'):('&')).$retour));
				die();
			}
			
			break;
		case 'fulfillmentUrl':
		case 'trxCancelFromPaymentPanelUrl':
			$url=parse_url($_SERVER['REQUEST_URI']);
			
			if(isset($url['query']))
			{
				$query='';
				$segment=explode('&',$url['query']);
				for($i=0;$i<sizeof($segment);$i++)
				{
					if(strpos($segment[$i],'=')!==false) list($variable,$valeur)=explode('=',$segment[$i]);
					else{$variable=$segment[$i]; $valeur='';}
					
					$variable=urldecode($variable);
					$valeur=urldecode($valeur);
					
					$_REQUEST[$variable]=$valeur;
					if($variable!='DATAS' && $variable!='trxId' && $variable!='hmac')
						$query.='&'.urlencode($variable).'='.urlencode($valeur);
				}
				
				if(isset($_REQUEST['hmac']) && $_REQUEST['hmac']==hmac_md5('DATAS='.urlencode($_REQUEST['DATAS']).$query,KEYVALUE))
				{
					$query=str_replace('&r='.urlencode($_REQUEST['r']),'',$query);
					$query=substr($query,1);
					
					unset($_SESSION['WHA_PAYE']);
					if($mode=='fulfillmentUrl')
					{
						$fichier=fopen(PWD_INCLUSION.'prive/log/wha.log','a');
						fputs($fichier,date('Y-m-d H:i:s',MAINTENANT).' '.$_REQUEST['r'].'?'.$query.CRLF);
						fclose($fichier);
						$_SESSION['WHA_PAYE']='';
					}
					
					header('location: '.url_use_trans_sid($_REQUEST['r'].'?'.$query));
					die();
				}
			}
			break;
		case 'productUnavailableUrl':
		case 'merchantHomeUrl':
		case 'mcttrxCancelFromPaymentPanelUrl':
		default:
	}
	
	header('location: '.url_use_trans_sid(URL_PUBLIC));
	die();
?>