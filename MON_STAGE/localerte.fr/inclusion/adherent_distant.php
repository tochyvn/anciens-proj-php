<?php
	define('ERREUR_XML',-1);
	define('ADHERENT_ALERTE_MAX',3);
	
	require_once(PWD_INCLUSION.'configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'fichier.php');
	require_once(PWD_INCLUSION.'archive.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'alerte_type.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	$erreur_fichier=0;
	$erreur_decompression=false;
	$erreur_xml=false;
	$erreur_adherent=array();
	
	if(isset($_FILES['fichier']))
	{
		$erreur_fichier=$_FILES['fichier']['error'];
		
		if(!$erreur_fichier)
		{
			if(!isset($_REQUEST['compression']))
				$_REQUEST['compression']='AUCUN';
			
			$contenu='';
			switch($_REQUEST['compression'])
			{
				case 'BZIP':
					if($fichier=bzopen($_FILES['fichier']['tmp_name'], "r"))
					{
						while(!feof($fichier))
							$contenu.=bzread($fichier,4096);
						bzclose($fichier);
					}
					else
						$erreur_decompression=true;
					break;
				case 'GZIP':
					if($fichier=gzopen($_FILES['fichier']['tmp_name'], "rb"))
					{
						while(!gzeof($fichier))
							$contenu.=gzgetc($fichier);
						gzclose($fichier);
					}
					else
						$erreur_decompression=true;
					break;
				case 'TAR':
					$fichier=new tar_file($_FILES['fichier']['tmp_name']);
					$fichier->set_options(array('basedir'=>'','overwrite'=>1,'inmemory' => 1));
					@$fichier->extract_files();
					if(sizeof($fichier->files)<1)
						$erreur_decompression=true;
					else
					{
						foreach($fichier->files as $file)
							$contenu.=$file['data'];
					}
					break;
				case 'ZIP':
					$fichier=zip_open($_FILES['fichier']['tmp_name']);
					if($fichier && $file=zip_read($fichier))
					{
						if(zip_entry_open($fichier,$file,'r'))
						{
							$contenu.=zip_entry_read($file,zip_entry_filesize($file));
							zip_entry_close($file);
						}
						else
							$erreur_decompression=true;
						zip_close($fichier);
					}
					else
						$erreur_decompression=true;
					break;
				default:
				case 'AUCUN':
					$contenu.=file_get_contents($_FILES['fichier']['tmp_name']);
					break;
			}
			
			$chemin=PWD_INCLUSION.'prive/temp/'.strrnd(10,3);
			file_put_contents($chemin,$contenu);
			
			$document=new DOMDocument();
			if(!$document->load($chemin))
				$erreur_xml=true;
			else
			{
				$adherent_dom=$document->getElementsByTagName('adherent');
				for($i=0;$i<$adherent_dom->length;$i++)
				{
					$erreur_adherent[$i]['adherent']=0;
					switch($adherent_dom->item($i)->getAttribute('submit'))
					{
						default:
							$adherent_objet=new ld_adherent();
							if($adherent_dom->item($i)->getElementsByTagName('email')->length)
							{
								$adherent_objet->email=ma_html_entity_decode($adherent_dom->item($i)->getElementsByTagName('email')->item(0)->nodeValue);
								
								/*if(preg_match('/@(hotmail|live|msn)/',$adherent_objet->email))
									die();*/
								
								if($adherent_objet->lire('email'))
								{
									
									if($adherent_objet->abonne=='NON')
									{
										$adherent_objet->passe='';
										$adherent_objet->confirmation='';
										$adherent_objet->abonne='OUI';
										$adherent_objet->validation='OUI';
										$nouveau=1;
									}
									else
									{
										$adherent_objet->abonne='NON';
										$adherent_objet->modifier();
										$adherent_objet->abonne='OUI';
										$adherent_objet->validation='OUI';
										$nouveau=2;
									}
									
									$alerte_liste=new ld_liste
									('
										select identifiant
										from alerte
										where adherent=\''.addslashes($adherent_objet->identifiant).'\'
										order by modification asc
									');
								}
								else
								{
									$adherent_objet->identifiant='';
									$adherent_objet->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_adherent','identifiant',ADHERENT_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
									$adherent_objet->passe='';
									$adherent_objet->confirmation='';
									$adherent_objet->abonne='OUI';
									$adherent_objet->brule='NON';
									$adherent_objet->validation='OUI';
									$adherent_objet->spamtrap='NON';
									$adherent_objet->hardbounce=0;
									$adherent_objet->softbounce=0;
									$adherent_objet->plainte=0;
									$nouveau=3;
								}
								
								if($adherent_dom->item($i)->getElementsByTagName('passe')->length && $adherent_objet->passe=='')
									$adherent_objet->passe=ma_html_entity_decode($adherent_dom->item($i)->getElementsByTagName('passe')->item(0)->nodeValue);
								if($adherent_objet->passe=='')
									$adherent_objet->passe=strrnd(ADHERENT_EMAIL_MIN,3);
								$adherent_objet->confirmation=$adherent_objet->passe;
								
								if($nouveau!=3)
									$erreur_adherent[$i]['adherent']=$adherent_objet->tester('modifier');
								else
									$erreur_adherent[$i]['adherent']=$adherent_objet->tester('ajouter');
								
								$erreur_adherent[$i]['alerte']=array();
								$nombre_alerte_ok=0;
								$alerte_objet=array();
								$alerte_dom=$adherent_dom->item($i)->getElementsByTagName('alerte');
								for($j=0;$j<$alerte_dom->length;$j++)
								{
									$erreur_adherent[$i]['alerte'][$j]=0;
									
									$alerte_objet[$j]=new ld_alerte();
									$alerte_objet[$j]->identifiant='';
									$alerte_objet[$j]->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_alerte','identifiant',ALERTE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
									$alerte_objet[$j]->adherent=$adherent_objet->nouveau_identifiant;
									
									$filtre=array();
									if($alerte_dom->item($j)->getElementsByTagName('ville')->length)
										$filtre[]='ville.nom=\''.addslashes(ma_html_entity_decode($alerte_dom->item($j)->getElementsByTagName('ville')->item(0)->nodeValue)).'\'';
									if($alerte_dom->item($j)->getElementsByTagName('code_postal')->length)
										$filtre[]='ville.code_postal=\''.addslashes(ma_html_entity_decode($alerte_dom->item($j)->getElementsByTagName('code_postal')->item(0)->nodeValue)).'\'';
									if(sizeof($filtre))
									{
										$alerte_objet[$j]->executer
										('
											select identifiant
											from ville
											where '.implode(' and ',$filtre).'
										');
										$occurrence=array();
										while($alerte_objet[$j]->donner_suivant($occurrence[]));
										unset($occurrence[sizeof($occurrence)-1]);
										if(sizeof($occurrence)==1)
											$alerte_objet[$j]->ville=$occurrence[0]['identifiant'];
									}
									
									if($alerte_dom->item($j)->getElementsByTagName('rayon')->length)
										$alerte_objet[$j]->rayon=ma_html_entity_decode($alerte_dom->item($j)->getElementsByTagName('rayon')->item(0)->nodeValue);
									
									$type_dom=$alerte_dom->item($j)->getElementsByTagName('type');
									for($k=0;$k<$type_dom->length;$k++)
									{
										$alerte_type_objet=new ld_alerte_type();
										$alerte_type_objet->alerte='';
										$alerte_type_objet->nouveau_alerte=$alerte_objet[$j]->nouveau_identifiant;
										$alerte_type_objet->type='';
										
										$alerte_type_objet->executer
										('
											select ifnull(parent.identifiant,enfant.identifiant) as identifiant
											from `type` enfant
												left join `type` parent on enfant.parent=parent.identifiant
											where enfant.designation=\''.addslashes(ma_html_entity_decode($type_dom->item($k)->nodeValue)).'\'
										');
										$occurrence=array();
										while($alerte_type_objet->donner_suivant($occurrence[]));
										unset($occurrence[sizeof($occurrence)-1]);
										if(sizeof($occurrence)==1)
										{
											$alerte_type_objet->nouveau_type=$occurrence[0]['identifiant'];
											$alerte_objet[$j]->alerte_type_ajouter($alerte_type_objet,'ajouter');
										}
									}
									
									$erreur_adherent[$i]['alerte'][$j]=$alerte_objet[$j]->tester('ajouter');
									if($nouveau==3 && $erreur_adherent[$i]['alerte'][$j] & ALERTE_ADHERENT_ERREUR)
										$erreur_adherent[$i]['alerte'][$j]-=ALERTE_ADHERENT_ERREUR;
									
									if(!$erreur_adherent[$i]['alerte'][$j])
										$nombre_alerte_ok++;
								}
								
								if(!$erreur_adherent[$i]['adherent'] && $nombre_alerte_ok)
								{
									$limite=ADHERENT_ALERTE_MAX;
									if($nouveau==2){
										$limite-=$alerte_liste->total;
										if(sizeof($alerte_objet)>$limite){
											for($j=0;$j<sizeof($alerte_objet);$j++)
											{
												$alerte_ancien=new ld_alerte();
												$alerte_ancien->identifiant=$alerte_liste->occurrence[$j]['identifiant'];
												$alerte_ancien->supprimer();
												
												$limite++;
											}
										}
									}
									
									if($nouveau==1)
									{
										for($j=0;$j<$alerte_liste->total;$j++)
										{
											$alerte_ancien=new ld_alerte();
											$alerte_ancien->identifiant=$alerte_liste->occurrence[$j]['identifiant'];
											$alerte_ancien->supprimer();
										}
									}
									
									if($nouveau!=3)
										$erreur_adherent[$i]['adherent']=$adherent_objet->modifier();
									else
										$erreur_adherent[$i]['adherent']=$adherent_objet->ajouter();
									
									for($j=0;$j<sizeof($alerte_objet) && $j<$limite;$j++)
										$alerte_objet[$j]->ajouter();
									
									if($nouveau!=2)
									{
										//if(preg_match('/@(hotmail|msn|live|outlook|dbmail|dartybox)/i',$adherent_objet->email))
										//	$adherent_objet->envoyer('code2');
										//else
											$adherent_objet->envoyer('cheznous');
									}
								}
							}
							else
								$erreur_adherent[$i]=ERREUR_XML;
							break;
					}
				}
			}
			
			unlink($chemin);
		}
	}
	else
		$erreur_fichier=UPLOAD_ERR_NO_FILE;
	
	if($erreur_fichier==UPLOAD_ERR_INI_SIZE) print('Le fichier exc&egrave;de la taille les '.ini_get('upload_max_filesize').'o autoris&eacute;es dans la configuration du serveur<br />');
	if($erreur_fichier==UPLOAD_ERR_FORM_SIZE) print('Le fichier exc&egrave;de la taille les '.octet_format(((int)ini_get('upload_max_filesize'))*1024*1024).' autoris&eacute;es par l\'application<br />');
	if($erreur_fichier==UPLOAD_ERR_PARTIAL) print('Le fichier n\'a &eacute;t&eacute; que partiellement t&eacute;l&eacute;charg&eacute;.<br />');
	if($erreur_fichier==UPLOAD_ERR_NO_FILE) print('Aucun fichier n\'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.<br />');
	if($erreur_fichier==UPLOAD_ERR_NO_TMP_DIR) print('Un dossier temporaire est manquant.<br />');
	if($erreur_fichier==UPLOAD_ERR_CANT_WRITE) print('Echec de l\'&eacute;criture du fichier sur le disque.<br />');
	if($erreur_fichier==UPLOAD_ERR_EXTENSION) print('Le fichier ne poss&egrave;de pas l\'extension requise.<br />');
	if($erreur_decompression) print('Une erreur est survenue durant la d&eacute;compression. Merci de v&eacute;rifier votre archive.<br />');
	if($erreur_xml) print('Le fichier XML a g&eacute;n&eacute;r&eacute; une erreur. Merci de v&eacute;rifier votre fichier.<br />');
	if(!$erreur_fichier && !$erreur_decompression && !$erreur_xml)
		print_r($erreur_adherent);
?>