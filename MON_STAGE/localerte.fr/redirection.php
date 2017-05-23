<?php
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	$_SESSION['redirection']=true;
			
	$sql=new ld_sql();
	$sql->ouvrir();
	
	if(preg_match('/^\/([a-z0-9]+)_([0-9a-zA-Z]{32})(_([0-9]{8})([^\.]+))?\.html/',$_SERVER['REQUEST_URI'],$resultat))
	{
										/* A SUPPRIMER 05/06/2013 */ /* PAS ENVIE */
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
		$adherent->code=$resultat[2];
		$trouve=$adherent->lire('code');
		
		if($trouve)
		{
			$adherent->actionner();
			
			if(sizeof($resultat)==6 && $resultat[4] && $resultat[5])
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
			
			if($adherent->abonne=='OUI'){
				unset_adherent();
				$_SESSION['adherent_identifiant']=$adherent->identifiant;
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
					if(sizeof($resultat)==6 && $resultat[4] && $resultat[5])
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
					header('location: '.url_use_trans_sid(URL_ADHERENT.'ma-liste.php?msgbox=code-1'));
					die();
				}
				break;
			case 'c2':
				if($trouve)
				{
					if(sizeof($resultat)==6 && $resultat[4] && $resultat[5])
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
					header('location: '.url_use_trans_sid(URL_ADHERENT.'ma-liste.php?msgbox=code-2'));
					die();
				}
				break;
			case 'a':
				$message='Votre inscription a bien été prolongée.';
				$message=ma_htmlentities($message);
				$message=urlencode($message);
				if($trouve)
				{
					header('location: '.url_use_trans_sid(URL_ADHERENT.'ma-liste.php?msgbox=message&msgbox_query='.$message));
					die();
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
						header('location: '.url_use_trans_sid(URL_ADHERENT.'ma-liste.php?msgbox=message&msgbox_query='.$message));
					}
					else header('location: '.url_use_trans_sid(URL_ADHERENT.'bienvenue.php'));
				}
				die();
				break;
			case 'c':
				if(isset($_SESSION['adherent_identifiant'])) unset($_SESSION['adherent_identifiant']);
				header('location: '.url_use_trans_sid(URL_ADHERENT.'bienvenue.php'));
				die();
				break;
			case 'd':
				//file_put_contents(PWD_INCLUSION.'prive/log/redirection.log',print_r($_SERVER,true)."\r\n",FILE_APPEND);
				header('location: '.url_use_trans_sid(URL_ADHERENT.'bienvenue.php?msgbox=desabonnement&msgbox_query='.urlencode('adherent_email='.urlencode($adherent->email).'&desabonnement_submit=valider')));
				die();
				break;
			case 'f':
				if(sizeof($resultat)==6 && $resultat[4] && $resultat[5])
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
				
				header('location: '.url_use_trans_sid(URL_ADHERENT.'ma-liste.php'));
				die();
				break;
			case 'l':
				
				if(sizeof($resultat)==6 && $resultat[4] && $resultat[5])
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
				header('location: '.url_use_trans_sid(URL_ADHERENT.'ma-liste.php'));
				die();
				break;
			case 'h':
				header('location: '.url_use_trans_sid(URL_ADHERENT.'bienvenue.php?msgbox=cgv'));
				die();
				break;
			case 'i':
				if(sizeof($resultat)==6 && $resultat[4] && $resultat[5])
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
	
	//file_put_contents(PWD_INCLUSION.'prive/log/redirection.log',print_r($_SERVER,true)."\r\n",FILE_APPEND);
	
	header('location: '.url_use_trans_sid(URL_ADHERENT));
	die();
?>
