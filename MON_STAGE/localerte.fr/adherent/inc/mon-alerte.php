<?php
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'alerte_type.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	$alerte=new ld_alerte();
	$alerte->identifiant=isset($_REQUEST['alerte_identifiant']) && $_REQUEST['alerte_identifiant']?$_REQUEST['alerte_identifiant']:'';
	if(!$alerte->lire() || $alerte->adherent!=$_SESSION['adherent_identifiant']){$_REQUEST['alerte_identifiant']=''; $mode='ajouter';}
	else{$mode='modifier'; if(!isset($_REQUEST['alerte_submit'])) $_REQUEST['alerte_ville']='VILLE_'.$alerte->ville;}
	
	$alerte_erreur=false;
	
	if(isset($_REQUEST['alerte_submit']))
	{
		if($mode=='ajouter')
		{
			$alerte->identifiant='';
			$alerte->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_alerte','identifiant',ALERTE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
			$alerte->adherent=$_SESSION['adherent_identifiant'];
		}
		
		$alerte->ville=(isset($_REQUEST['alerte_ville']))?(str_replace('VILLE_','',$_REQUEST['alerte_ville'])):(NULL);
		$alerte->rayon=$_REQUEST['alerte_rayon'];
		
		for($i=sizeof($_REQUEST['alerte_type'])-1;$i>=0;$i--)
			if(!$_REQUEST['alerte_type'][$i]) unset($_REQUEST['alerte_type'][$i]);
		
		$type=array_unique($_REQUEST['alerte_type']);
		$type=array_values($type);
		
		for($i=$alerte->alerte_type_compter()-1;$i>=0;$i--)
		{
			$resultat=$alerte->alerte_type_lire($i);
			$alerte_type=$resultat['objet'];
			
			$trouve=false;
			for($j=0;$j<sizeof($type) && !$trouve;$j++)
			{
				if($alerte_type->type==$type[$j])
					$trouve=true;
			}
			if(!$trouve)
				$alerte->alerte_type_supprimer($i);
		}
		
		for($i=0;$i<sizeof($type);$i++)
		{
			$clef=$alerte->alerte_type_trouver($type[$i],'type');
			if($clef!==false)
			{
				$alerte_type=new ld_alerte_type();
				$alerte_type->alerte=$alerte->identifiant;
				$alerte_type->nouveau_alerte=$alerte->nouveau_identifiant;
				$alerte_type->type=$type[$i];
				$alerte_type->nouveau_type=$type[$i];
				$alerte->alerte_type_modifier($alerte_type,$clef,'modifier');
			}
			else
			{
				$alerte_type=new ld_alerte_type();
				$alerte_type->alerte=$alerte->identifiant;
				$alerte_type->nouveau_alerte=$alerte->nouveau_identifiant;
				$alerte_type->type='';
				$alerte_type->nouveau_type=$type[$i];
				$alerte->alerte_type_ajouter($alerte_type,'ajouter');
			}
		}
		
		$alerte_erreur=$alerte->$mode();
		
		if(!$alerte_erreur)
		{
			$mode='modifier';
			$_REQUEST['alerte_identifiant']=$alerte->identifiant;
			//header('location: '.url_use_trans_sid(URL_ADHERENT.'/mes-alertes.php?message=modification'));
			//die();
		}
	}
	
	if(!isset($_REQUEST['alerte_filtre']) && isset($_REQUEST['alerte_ville']))
	{
		require_once(PWD_INCLUSION.'ville.php');
		$ville=new ld_ville();
		$ville->identifiant=str_replace('VILLE_','',$_REQUEST['alerte_ville']);
		if($ville->lire()) $_REQUEST['alerte_filtre']=$ville->code_postal.' '.$ville->nom;
	}
?>
