<?php
	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']=='')
	{
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
                //S'il n'existe pas de premier paramètre ou s'il est nul on quitte
		if(!isset($argv[1])) die();
                //le nom du fichier passé en passé dans l'url correspond au premier parametre
		$_REQUEST['fichier']=$argv[1];
	}
	
	define('PWD_DOWNLOAD',$_SERVER['DOCUMENT_ROOT'].'/download');
	define('PWD_UPLOAD',$_SERVER['DOCUMENT_ROOT'].'/upload');
	define('PWD_ETC',$_SERVER['DOCUMENT_ROOT'].'/etc');
	define('PWD_SPOOL_ACTIVE',$_SERVER['DOCUMENT_ROOT'].'/spool/active');
	define('PWD_SPOOL_CORRUPT',$_SERVER['DOCUMENT_ROOT'].'/spool/corrupt');
	define('PWD_LOG',$_SERVER['DOCUMENT_ROOT'].'/log/pige'.date('Y-m-d').'.log');
	
	define('TAB',"\t");
	define('CRLF',"\r\n");
	define('CR',"\r");
	define('LF',"\n");
	
	/**
	 *FONCTION PERMETTANT DE RECUPERER LES ENTETES DU FICHIER PASSƒ EN PARAMETRE DANS L'URL ET LE CORPS DU FICHIER
	 *LES ENTETES ICI REPRESENTE LES PARAMETRES STOCKƒS DANS LE FICHIER Ë LA PHASE D'INITIALISATION (spool, etape, rang ...)
	 */
	function decouper(&$entete,&$corps,$fichier)
	{
		list($temp,$corps)=explode('<!-- gdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdf864654654564564897 -->',
					   preg_replace('/\r\n\r\n/',
							'<!-- gdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdf864654654564564897 -->'
							,file_get_contents($fichier),1));
		$temp=explode(CRLF,$temp);
		
		$entete=array();
		for($i=0;$i<sizeof($temp);$i++)
		{
			if(!preg_match('/^([^=]+)=(.+)/',$temp[$i],$resultat))
				return false;
			
			$entete[$resultat[1]]=$resultat[2];
		}
		
		if(!isset($entete['spool']) || !is_file(PWD_ETC.'/'.$entete['spool']))
			return false;
		if(!isset($entete['location']))
			return false;
		if(!isset($entete['etape']) || $entete['etape']!='capture')
			return false;
		
		return true;
	}
	
	function expressionner($xml)
	{
		$tableau=array();
		$tableau['expression']='';
		$tableau['option']='';
		$tableau['remplacement']='$1';
		$tableau['recherche']='ENFANT';
		$tableau['limite']=1;
		$tableau['filtre']=array();
		
		$noeuds=$xml->childNodes;
		for($i=0;$i<$noeuds->length;$i++)
		{
			$noeud=$noeuds->item($i);
			if(preg_match('/^(expression|option|remplacement|recherche|limite)$/',$noeud->nodeName))
				$tableau[$noeud->nodeName]=$noeud->nodeValue;
		}
		
		$noeuds=$xml->getElementsByTagName('filtre');
		for($i=0;$i<$noeuds->length;$i++)
		{
			$noeud=$noeuds->item($i);
			$tableau['filtre'][]=expressionner($noeud);
		}
		
		return $tableau;
	}
	
	function formater($tableau,$echappement,$separateur,$encapsulateur,$ligne)
	{
		$recherche=array(';',CR,LF,'"');
		$remplacement=array(':point virgule:',':saut ligne:',':saut paragraphe:',':guillemet:');
		
		$chaine='';
		for($i=0;$i<sizeof($tableau);$i++)
		{
			if($i) $chaine.=$separateur;
			$chaine.=$encapsulateur.str_replace($recherche,$remplacement,$tableau[$i]).$encapsulateur;
		}
		
		switch($ligne)
		{
			case 'CR':
				$chaine.=CR;
				break;
			case 'LF':
				$chaine.=LF;
				break;
			case 'CRLF':
				$chaine.=CRLF;
				break;
			default:
				$chaine.=$ligne;
				break;
		}
		
		return $chaine;
	}
	
	if(!isset($_REQUEST['fichier']) || !is_file(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier']))
		die('PB1');
	
	if(!decouper($entete,$document_html,PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier']))
	{
		copy(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier'],PWD_SPOOL_CORRUPT.'/'.$_REQUEST['fichier']);
		unlink(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier']);
		
		file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'navigation.php'.TAB.$_REQUEST['fichier'].TAB.'Notice'.TAB.'active::capture -> corrupt'.CRLF,FILE_APPEND);
		
		die('PB2');
	}
	
	$document_xml=new DOMDocument();
	$document_xml->load(PWD_ETC.'/'.$entete['spool']);
	
	$capture_xml=$document_xml->getElementsByTagName('capture')->item(0);
	
	$parent_xml=$capture_xml->getElementsByTagName('parent')->item(0);
	$enfant_xml=$capture_xml->getElementsByTagName('enfant')->item(0);
	
	$destination=$capture_xml->getElementsByTagName('destination')->item(0)->nodeValue;
	
	$echappement=$capture_xml->getElementsByTagName('echappement')->item(0)->nodeValue;
	$separateur=$capture_xml->getElementsByTagName('separateur')->item(0)->nodeValue;
	$encapsulateur=$capture_xml->getElementsByTagName('encapsulateur')->item(0)->nodeValue;
	$ligne=$capture_xml->getElementsByTagName('ligne')->item(0)->nodeValue;
	
	$enlever_balise=(bool)$capture_xml->getElementsByTagName('enlever_balise')->item(0)->nodeValue;
	$enlever_entite=(bool)$capture_xml->getElementsByTagName('enlever_entite')->item(0)->nodeValue;
	
	$exclusion=array();
	$exclusion_xml=$capture_xml->getElementsByTagName('exclusion');
	if($exclusion_xml->length)
	{
		$noeuds_xml=$exclusion_xml->item(0)->getElementsByTagName('fichier');
		if($noeuds_xml->length) $exclusion=explode(CRLF,trim(file_get_contents(PWD_DOWNLOAD.'/'.$noeuds_xml->item(0)->nodeValue)));
		$noeuds_xml=$exclusion_xml->item(0)->getElementsByTagName('expression');
		for($i=0;$i<$noeuds_xml->length;$i++)
		{
			$noeud_xml=$noeuds_xml->item($i);
			$exclusion[]=$noeud_xml->nodeValue;
		}
	}
	
	$parent_expression=expressionner($parent_xml);
	$parent_html=preg_replace('/'.$parent_expression['expression'].'/'.$parent_expression['option'],$parent_expression['remplacement'],$document_html);
	
	$enfant_expression=expressionner($enfant_xml);
	if(preg_match_all('/'.$enfant_expression['expression'].'/'.$enfant_expression['option'],$parent_html,$enfants_html))
	{
		$colonnes_xml=$capture_xml->getElementsByTagName('colonne');
		
		for($i=0;$i<sizeof($enfants_html[0]) && $i<$enfant_expression['limite'];$i++)
		{
			$enfant_html=preg_replace('/'.$enfant_expression['expression'].'/'.$enfant_expression['option'],$enfant_expression['remplacement'],$enfants_html[0][$i]);
			$colonne_csv=array();
			$erreur=false;
			
			for($j=0;$j<$colonnes_xml->length && !$erreur;$j++)
			{
				$colonne_xml=$colonnes_xml->item($j);
				
				switch($colonne_xml->getAttribute('mode'))
				{
					case 'valeur':
						$colonne_csv[]=$colonne_xml->getElementsByTagName('valeur')->item(0)->nodeValue;
						break;
					case 'expression':
						
						$colonne_expression=expressionner($colonne_xml);
						
						switch($colonne_expression['recherche'])
						{
							case 'ENFANT':
								$recherche=$enfant_html;
								break;
							case 'PARENT':
								$recherche=$parent_html;
								break;
							case 'LOCATION':
								$recherche=$entete['location'];
								break;
						}
						
						preg_match_all('/'.$colonne_expression['expression'].'/'.$colonne_expression['option'],$recherche,$colonnes_html);
						
						for($k=0;($k<sizeof($colonnes_html[0]) || $k<$colonne_expression['limite']) && !$erreur;$k++)
						{
							if($k<sizeof($colonnes_html[0]) && $k<$colonne_expression['limite'])
							{
								$resultat=preg_replace('/'.$colonne_expression['expression'].'/'.$colonne_expression['option'],$colonne_expression['remplacement'],$colonnes_html[0][$k]);
								
								for($l=0;$l<sizeof($colonne_expression['filtre']);$l++)
									$resultat=preg_replace('/'.$colonne_expression['filtre'][$l]['expression'].'/'.$colonne_expression['filtre'][$l]['option'],$colonne_expression['filtre'][$l]['remplacement'],$resultat);
								
								for($l=0;$l<sizeof($exclusion) && !$erreur;$l++)
								{
									if($exclusion[$l]!='' && preg_match('/'.$exclusion[$l].'/is',$resultat))
									{
										$erreur=true;
										
										file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'capture.php'.TAB.$_REQUEST['fichier'].TAB.'Warning'.TAB.'active::capture -> exclusion -> '.$exclusion[$l].CRLF,FILE_APPEND);
									}
								}
								
								if($enlever_balise)
								{
									$resultat=preg_replace('/<[^>]+\/>/m',' ',$resultat);									
									$resultat=preg_replace('/<[^>]+>/m','',$resultat);
								}
								
								if($enlever_entite)
								{
									$resultat=html_entity_decode($resultat);
									$resultat=str_replace(array('&euro;','&lsquo;','&rsquo;','&hellip;','&oelig;','&ndash;','&#039;','&#39;','&#9658;','&#8211;','&#8217;','&#8230;','&#164;','&#8364;'),array(chr(128),'\'','\'','...','oe','-','\'','\'','>','-','\'','...',chr(128),chr(128)),$resultat);
								}
								
								$colonne_csv[]=$resultat;
							}
							elseif($k<$colonne_expression['limite'])
								$colonne_csv[]='';
						}
						
						break;
				}
			}
			
			if(!$erreur)
			{
				if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='gx')
				{
					print('<pre>');
					print_r($colonne_csv);
					print('</pre>');
				}
				elseif (isset($_REQUEST['mode']) && $_REQUEST['mode']=='gx2') {
					print(formater($colonne_csv,$echappement,$separateur,$encapsulateur,$ligne));
				}
				else
				{
					$fichier=fopen(PWD_UPLOAD.'/'.$destination,'a');
					fputs($fichier,formater($colonne_csv,$echappement,$separateur,$encapsulateur,$ligne));
					fclose($fichier);
				}
			}
		}
	}
	
	unlink(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier']);
?>