<?php
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'ville.php');
	require_once(PWD_INCLUSION.'type.php');
	
	//LES VARIABLES
	if(!isset($_SESSION['annonce_tri'])) $_SESSION['annonce_tri']='distance';
	if(!isset($_SESSION['annonce_ordre'])) $_SESSION['annonce_ordre']='asc';
	if(!isset($_SESSION['annonce_statut'])) $_SESSION['annonce_statut']='';
	if(!isset($_SESSION['annonce_ville'])) $_SESSION['annonce_ville']='';
	if(!isset($_SESSION['alerte_identifiant'])) $_SESSION['alerte_identifiant']='';
	if(1) $_SESSION['annonce_page']='1';
	if(1) $_SESSION['annonce_nombre']=$_SERVER['PHP_SELF']==URL_ADHERENT.'/ma-liste.php'?120:120;
	
	if(isset($_REQUEST['annonce_tri']))
	{
		$_SESSION['annonce_tri']=$_REQUEST['annonce_tri'];
		if(!isset($_REQUEST['annonce_ordre']) || $_REQUEST['annonce_ordre']!='desc')
			$_REQUEST['annonce_ordre']='asc';
	}
	if(isset($_REQUEST['annonce_ordre'])) $_SESSION['annonce_ordre']=$_REQUEST['annonce_ordre'];
	if(isset($_REQUEST['annonce_statut']) && (preg_match('/^(PARTICULIER|PROFESSIONNEL)$/',$_REQUEST['annonce_statut']) || $_REQUEST['annonce_statut']=='')) $_SESSION['annonce_statut']=$_REQUEST['annonce_statut'];
	if(isset($_REQUEST['annonce_ville'])) $_SESSION['annonce_ville']=$_REQUEST['annonce_ville'];
	if(isset($_REQUEST['alerte_identifiant']) && preg_match('/^[0-9]+$/',$_REQUEST['alerte_identifiant'])) $_SESSION['alerte_identifiant']=$_REQUEST['alerte_identifiant'];
	if(isset($_REQUEST['annonce_page']) && preg_match('/^[0-9]+$/',$_REQUEST['annonce_page'])) $_SESSION['annonce_page']=$_REQUEST['annonce_page'];
	
	//VENANT DE LOCALERTE.MOBI
	if(!$_SESSION['alerte_identifiant'])
	{
		$liste=new ld_liste('select identifiant from alerte where adherent='.$_SESSION['adherent_identifiant'].' order by alerte.enregistrement, alerte.identifiant');
		if($liste->total){
			$_SESSION['annonce_ville']='';
			$_SESSION['alerte_identifiant']=$liste->occurrence[0]['identifiant'];
		}
	}
	
	//INFO ALLERTE
	$alerte=new ld_alerte();
	$alerte->identifiant=$_SESSION['alerte_identifiant'];
	if(!$alerte->lire() || $alerte->adherent!=$_SESSION['adherent_identifiant'])
	{
		unset($_SESSION['alerte_identifiant']);
		$query=array();
		if(isset($_REQUEST['msgbox'])) $query['msgbox']=$_REQUEST['msgbox'];
		if(isset($_REQUEST['msgbox_query'])) $query['msgbox_query']=$_REQUEST['msgbox_query'];		
		header('location: '.url_use_trans_sid(URL_ADHERENT.'/ma-premiere-alerte.php'.(sizeof($query)?'?'.http_build_query($query,'','&'):'')));
		die();
	}
	
	//INFO VILLE
	$ville=new ld_ville();
	$ville->identifiant=$alerte->ville;
	$ville->lire();
	
	//INFO TYPE
	$type_identifiant=array();
	$type=array();
	for($i=0;$i<$alerte->alerte_type_compter();$i++)
	{
		$instance=$alerte->alerte_type_lire($i);
		
		$type[$i]=new ld_type();
		$type[$i]->identifiant=$instance['objet']->type;
		$type[$i]->lire();
		
		$temp=new ld_liste('select identifiant from type where identifiant='.$instance['objet']->type.' or parent='.$instance['objet']->type);
		for($j=0;$j<$temp->total;$j++)
			$type_identifiant[]=$temp->occurrence[$j]['identifiant'];
	}
	
	//LA LISTE DES ANNONCES
	$liste=new ld_liste
	('
		select sql_calc_found_rows
			liste.identifiant as identifiant,
			loyer,
			ville_nom as ville,
			liste.code_postal as code_postal,
			type_designation as type,
			statut,
			if(datediff(enregistrement,modification)=0,unix_timestamp(enregistrement),unix_timestamp(parution)) as parution,
			unix_timestamp(enregistrement) as enregistrement,
			(adherent_annonce.adherent is not null) as adherent_annonce,
			if(loyer is null,1,0) as loyer_not_null,
			image,
			ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),2),0) as distance,
			descriptif,
			url
		from
			liste
			inner join ville on liste.ville_identifiant=ville.identifiant
			left join adherent_annonce on adherent_annonce.adherent='.addslashes($_SESSION['adherent_identifiant']).' and liste.identifiant=adherent_annonce.annonce and adherent_annonce.lu>now() - interval (select annonce_affiche_lu from preference limit 1) day
		where 1
			'.(preg_match('/ma-selection\.php/',$_SERVER['PHP_SELF'])?'and liste.identifiant in (\''.implode('\', \'',array_map('addslashes',$_SESSION['annonce_identifiant'])).'\')':'').'
			and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
			and type_identifiant in ('.implode(', ',$type_identifiant).')
			'.(($_SESSION['annonce_statut']!='')?('and statut=\''.addslashes($_SESSION['annonce_statut']).'\''):('')).'
			'.(($_SESSION['annonce_ville']!='')?('and ville_identifiant in ('.addslashes($_SESSION['annonce_ville']).')'):('')).'
		order by '.(($_SESSION['annonce_tri']=='loyer')?('loyer_not_null, '):('')).'`'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].(($_SESSION['annonce_tri']=='ville')?(', code_postal '.$_SESSION['annonce_ordre']):('')).'/*, parution DESC*/
		limit '.(($_SESSION['annonce_page']-1)*$_SESSION['annonce_nombre']).', '.$_SESSION['annonce_nombre'].'
	',5);
	
	//LA LISTE DES STATUTS
	$statut_liste=new ld_liste('
		select
			liste.statut as statut,
			count(liste.identifiant) as nombre
		from liste
			inner join ville on liste.ville_identifiant=ville.identifiant
		where 1
			'.(preg_match('/ma-selection\.php/',$_SERVER['PHP_SELF'])?'and liste.identifiant in (\''.implode('\', \'',array_map('addslashes',$_SESSION['annonce_identifiant'])).'\')':'').'
			and type_identifiant in ('.implode(', ',$type_identifiant).')
			and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
			'.(($_SESSION['annonce_ville']!='')?('and ville_identifiant in ('.addslashes($_SESSION['annonce_ville']).')'):('')).'
		group by statut
	');
	
	//LA LISTE DES VILLES
	$uniqid=uniqid();
	
	$sql=new ld_sql();
	$sql->ouvrir();
	$sql->executer
	('
		CREATE TEMPORARY TABLE `'.$uniqid.'` (
		`identifiant` INT UNSIGNED NOT NULL DEFAULT \'0\',
		`nom` VARCHAR(100) NOT NULL,
		`nombre` INT UNSIGNED NOT NULL DEFAULT \'0\',
		`distance` INT UNSIGNED NOT NULL DEFAULT \'0\',
		`selected` INT UNSIGNED NOT NULL DEFAULT \'0\',
		`latitude` FLOAT NOT NULL DEFAULT \'0\',
		`longitude` FLOAT NOT NULL DEFAULT \'0\',
		PRIMARY KEY ( `identifiant` )
		) ENGINE = MYISAM ;
	');
	$sql->executer
	('
		insert into `'.$uniqid.'`
		select
			ville.identifiant,
			concat(ville.code_postal,\' \', if(ville.nom_accent<>\'\',ville.nom_accent,ville.nom)) as nom,
			count(liste.identifiant) as nombre,
			ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0) as distance,
			if(ville.identifiant='.(int)$_SESSION['annonce_ville'].',1,0) as selected,
			ville.latitude,
			ville.longitude
		from liste
			inner join ville on liste.ville_identifiant=ville.identifiant
		where 1
			'.(preg_match('/ma-selection\.php/',$_SERVER['PHP_SELF'])?'and liste.identifiant in (\''.implode('\', \'',array_map('addslashes',$_SESSION['annonce_identifiant'])).'\')':'').'
			and type_identifiant in ('.implode(', ',$type_identifiant).')
			and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
		group by ville.identifiant
	');
	
	$ville_liste=new ld_liste('
		select 
			identifiant,
			nom,
			nombre,
			distance,
			selected,
			longitude,
			latitude
		from `'.$uniqid.'`
		order by /*selected desc, */distance, nom
	');
?>
