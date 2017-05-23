<?php
	require_once(PWD_INCLUSION.'configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	if(preg_match('/^\/([a-z0-9]+)_([0-9a-zA-Z]{32})(_([0-9]{8})([^\.]+))?\.html/',$_SERVER['REQUEST_URI'],$resultat))
	{
										/* A SUPPRIMER 05/06/2013 */
										$liste=new ld_liste('select identifiant from adherent where code=\''.addslashes($resultat[2]).'\'');
										if($liste->total)
										{
											$adherent=new ld_adherent();
											$adherent->identifiant=$liste->occurrence[0]['identifiant'];
											$adherent->lire();
											$adherent->abonne='OUI';
											$adherent->modifier();
										}

		$adherent=new ld_adherent();
		$adherent->identifiant=$resultat[2];
		$trouve=$adherent->identifier('cryptage');
		if($trouve)
		{
			$adherent->actionner();
			
			if(sizeof($resultat)==6 && $resultat[4] && $resultat[5])
			{
				$sql=new ld_sql();
				$sql->ouvrir();
				$sql->executer
				('
					insert ignore into statistiques_mail
					(
						jour,
						mail,
						action,
						adherent,
						enregistrement
					)
					values
					(
						\''.preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})$/','$1-$2-$3',$resultat[4]).'\',
						\''.$resultat[5].'\',
						\''.$resultat[1].'\',
						'.$adherent->identifiant.',
						now()
					)
				');
			}
		}
		
		//a: action
		//c: accueil pour connexion
		//d: desabonnement
		//f: fiche
		//l: liste
		//i: image
		//c1: code_1
		//c2: code_2
		//cn: cheznous
		
		if(isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'],'code_2=message'))
			$_SESSION['code_2']='message';
		
		if(strpos($resultat[1],'c1')===0)
		{
			$_SESSION['code_1']=substr($resultat[1],2);
			$resultat[1]='c1';
		}
		
		if(strpos($resultat[1],'c2')===0)
		{
			$_SESSION['code_2']=substr($resultat[1],2);
			$resultat[1]='c2';
		}
		
		switch($resultat[1])
		{
			case 'c1':
				if($trouve)
				{
					$sql->executer
					('
						insert into statistiques_alerte
						(
							jour,
							mail,
							clic
						)
						values
						(
							\''.preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})$/','$1-$2-$3',$resultat[4]).'\',
							\''.$resultat[5].'\',
							1
						)
						on duplicate key update
							clic=clic+1
					');
					
					$_SESSION['adherent_identifiant']=$adherent->identifiant;
					header('location: '.url_use_trans_sid(URL_ADHERENT.'code_1.php'));
					die();
				}
				break;
			case 'c2':
				if($trouve)
				{
					$sql->executer
					('
						insert into statistiques_alerte
						(
							jour,
							mail,
							clic
						)
						values
						(
							\''.preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})$/','$1-$2-$3',$resultat[4]).'\',
							\''.$resultat[5].'\',
							1
						)
						on duplicate key update
							clic=clic+1
					');
					$_SESSION['adherent_identifiant']=$adherent->identifiant;
					header('location: '.url_use_trans_sid(URL_ADHERENT.'code_2.php'));
					die();
				}
				break;
			case 'a':
				if($trouve)
				{
					$_SESSION['adherent_identifiant']=$adherent->identifiant;
					header('location: '.url_use_trans_sid(URL_ADHERENT.'compte/action.php'));
				}
				else
				{
					$liste=new ld_liste('select identifiant from adherent where code=\''.addslashes($resultat[2]).'\'');
					if($liste->total)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$liste->occurrence[0]['identifiant'];
						$adherent->lire();
						$adherent->abonne='OUI';
						$adherent->modifier();
						$_SESSION['adherent_identifiant']=$adherent->identifiant;
						header('location: '.url_use_trans_sid(URL_ADHERENT.'compte/action.php'));
					}
					else header('location: '.url_use_trans_sid(URL_ADHERENT.'compte/fiche.php'));
				}
				die();
				break;
			case 'c':
				if(isset($_SESSION['adherent_identifiant']))
					unset($_SESSION['adherent_identifiant']);
				header('location: '.url_use_trans_sid(URL_ADHERENT));
				die();
				break;
			case 'd':
				$_SESSION['adherent_identifiant']=$adherent->identifiant;
				//header('location: '.url_use_trans_sid(URL_ADHERENT.'compte/desabonnement.php?adherent_email='.urlencode($adherent->email).'&desabonnement_submit=automatique'));
				header('location: '.url_use_trans_sid(URL_ADHERENT.'compte/desabonnement_direct.php?adherent_email='.urlencode($adherent->email).'&desabonnement_submit=valider'));
				die();
				break;
			case 'f':
				$sql=new ld_sql();
				$sql->ouvrir();
				$sql->executer
				('
					insert into statistiques_alerte
					(
						jour,
						mail,
						clic
					)
					values
					(
						\''.preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})$/','$1-$2-$3',$resultat[4]).'\',
						\''.$resultat[5].'\',
						1
					)
					on duplicate key update
						clic=clic+1
				');
				
				$_SESSION['adherent_identifiant']=$adherent->identifiant;
				//header('location: '.url_use_trans_sid(URL_ADHERENT.'compte/fiche.php'));
				header('location: '.url_use_trans_sid(URL_ADHERENT.'alerte/liste.php'));
				die();
				break;
			case 'l':
				
				$sql=new ld_sql();
				$sql->ouvrir();
				$sql->executer
				('
					insert into statistiques_alerte
					(
						jour,
						mail,
						clic
					)
					values
					(
						\''.preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})$/','$1-$2-$3',$resultat[4]).'\',
						\''.$resultat[5].'\',
						1
					)
					on duplicate key update
						clic=clic+1
				');
				//PAS DE BREAK: NORMAL
			case 'cn':
				$_SESSION['adherent_identifiant']=$adherent->identifiant;
				if($trouve)
					header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/liste.php'));
				else {
					//header('location: '.url_use_trans_sid(URL_ADHERENT.'compte/fiche.php'));					
					header('location: '.url_use_trans_sid(URL_ADHERENT.'alerte/liste.php'));
				}
				die();
				break;
			case 'h':
				$_SESSION['adherent_identifiant']=$adherent->identifiant;
				if($trouve)
					header('location: '.url_use_trans_sid(URL_ADHERENT.'comment.php'));
				else
					header('location: '.url_use_trans_sid(URL_ADHERENT.'comment.php'));					
				die();
				break;
			case 'i':
				
				$sql=new ld_sql();
				$sql->ouvrir();
				$sql->executer
				('
					insert into statistiques_alerte
					(
						jour,
						mail,
						affichage
					)
					values
					(
						\''.preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})$/','$1-$2-$3',$resultat[4]).'\',
						\''.$resultat[5].'\',
						1
					)
					on duplicate key update
						affichage=affichage+1
				');
				
				$image=imagecreate(1,1);
				$noir=imagecolorallocate($image,0,0,0);
				imagecolortransparent($image,$noir);
				
				header('Content-Type: image/gif');
				imagegif($image);
				die();
				break;
		}
	}
	
	if(preg_match('/^\/([a-z]+)_([0-9a-zA-Z]{32})_([0-9]+)(_([0-9]{8})([^\.]+))?\.html/',$_SERVER['REQUEST_URI'],$resultat))
	{
		$adherent=new ld_adherent();
		$adherent->identifiant=$resultat[2];
		$trouve=$adherent->identifier('cryptage');
		if($trouve)
			$adherent->actionner();
		
		//f: facture
		
		switch($resultat[1])
		{
			case 'f':
				header('location: '.url_use_trans_sid(URL_INCLUSION.'facture.php?mode=voir&identifiant='.urlencode($resultat[3]).'&adherent='.urlencode($resultat[2])));
				die();
				break;
		}
	}
	
	header('location: '.url_use_trans_sid(URL_ADHERENT));
	die();
?>