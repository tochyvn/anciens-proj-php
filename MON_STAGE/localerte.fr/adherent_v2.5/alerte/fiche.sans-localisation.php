<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'alerte_type.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'ville.php');
	
	$liste_type=new ld_liste('select identifiant, designation from type where parent is null');
	$liste_departement=new ld_liste('select identifiant, nom from departement');
	
	$liste=new ld_liste('select identifiant from alerte where adherent='.$_SESSION['adherent_identifiant']);
	if($liste->total>=ALERTE_CARDINALITE)
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'alerte/liste.php'));
		die();
	}
	
	$adherent=new ld_adherent();
	$adherent->identifiant=$_SESSION['adherent_identifiant'];
	$adherent->lire();
	
	$alerte=new ld_alerte();
	$alerte_erreur=false;
	
	if(isset($_REQUEST['alerte_submit']))
	{
		$objet=&$alerte;
		
		$objet->identifiant='';
		$objet->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_alerte','identifiant',ALERTE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		$objet->adherent=$_SESSION['adherent_identifiant'];
		$objet->ville=$_REQUEST['alerte_ville'];
		$objet->rayon=$_REQUEST['alerte_rayon'];
		
		for($i=sizeof($_REQUEST['alerte_type'])-1;$i>=0;$i--)
			if(!$_REQUEST['alerte_type'][$i]) unset($_REQUEST['alerte_type'][$i]);
		
		$type=array_unique($_REQUEST['alerte_type']);
		$type=array_values($type);
		
		for($i=0;$i<sizeof($type);$i++)
		{
			$alerte_type=new ld_alerte_type();
			$alerte_type->alerte=$objet->identifiant;
			$alerte_type->nouveau_alerte=$objet->nouveau_identifiant;
			$alerte_type->type='';
			$alerte_type->nouveau_type=$type[$i];
			$objet->alerte_type_ajouter($alerte_type,'ajouter');
		}
		
		$rafraichissement_identifiant=$objet->nouveau_identifiant;
		$rafraichissement_departement=$_REQUEST['alerte_departement'];
		
		switch($_REQUEST['alerte_submit'])
		{
			case 'Rafraîchir':
				break;
			case 'Ajouter':
				$alerte_erreur=$objet->ajouter();
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
</head>
<body>
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header">
    <?php include(PWD_ADHERENT.'tete.php');?>
  </div>
  <div id="centre_haut"></div>
  <div id="centre">
    <div id="pub_gauche">
      <?php include(PWD_ADHERENT.'adsense_gauche.php');?>
    </div>
    <div id="alerte_fiche">
      <div id="alerte_adherent"> Compte: <?php print(ma_htmlentities($adherent->email));?><br />
        Enregistr&eacute; le <?php print(ma_htmlentities(date('d-m-Y',$adherent->date_enregistrement)));?> </div>
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT.'alerte/liste.php');?>">Retour &agrave; votre liste d'alertes</a><br /><br /></p>
      <?php
	if(isset($_REQUEST['alerte_submit']) && $_REQUEST['alerte_submit']!='Rafraîchir')
	{
		//print($alerte_erreur);
		if($alerte_erreur&ALERTE_VILLE_ERREUR) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/erreur.png"> Indiquez une ville pour votre recherche</p>');
		if($alerte_erreur&ALERTE_RAYON_ERREUR_VALEUR || $alerte_erreur&ALERTE_RAYON_ERREUR_FILTRE) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/erreur.png"> Renseignez un rayon de recherche</p>');
		if($alerte_erreur&ALERTE_ALERTE_TYPE_ERREUR_TAILLE || $alerte_erreur&ALERTE_ALERTE_TYPE_ERREUR_CLASSE) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/erreur.png"> Renseignez au moins 1 type d\'habitation recherch&eacute;</p>');
		if(!$alerte_erreur) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/valid.png"> Votre alerte e-mail a bien &eacute;t&eacute; prise en compte. Vous recevrez d&eacute;sormais chaque jour toutes les nouvelles annonces de moins de 4 jours relev&eacute;es sur internet et dans la presse.<br />
Dans le cas contraire, merci de v&eacute;rifier les courriers ind&eacute;sirables de votre boite e-mail.<br />
<br /><a class="orange_fonce" href="'.URL_ADHERENT.'alerte/liste.php">Allez &agrave; la liste des alertes</a>
<br /><a class="orange_fonce" href="'.URL_ADHERENT.'annonce/liste.php">Consultez les annonces</a>
</p>');
	}
?>
      <?php
		$objet=&$alerte;
		
		$ville=new ld_ville();
		$ville->identifiant=$objet->ville;
		$ville->lire();
		
		if(isset($rafraichissement_identifiant) && $rafraichissement_identifiant==$objet->nouveau_identifiant)
			$ville->departement=$rafraichissement_departement;
		
		$liste_ville=new ld_liste('select identifiant, nom, code_postal, departement from ville where departement=\''.addslashes($ville->departement).'\' ORDER BY nom');
?>
      <br />
      <h2 class="alerte">Votre alerte :</h2>
      <div class="alerte">
        <form action="fiche.php" class="alerte">
          <p><br />
            <label>Je chercher &agrave; louer dans le d&eacute;partement : </label>
            <select name="alerte_departement">
              <option></option>
              <?php
	  	for($j=0;$j<$liste_departement->total;$j++)
			print('<option value="'.ma_htmlentities($liste_departement->occurrence[$j]['identifiant']).'"'.(($liste_departement->occurrence[$j]['identifiant']==$ville->departement)?(' selected="selected"'):('')).'>'.ma_htmlentities($liste_departement->occurrence[$j]['identifiant'].' '.$liste_departement->occurrence[$j]['nom']).'</option>');
      ?>
            </select>
            <input type="submit" name="alerte_submit" value="Rafra&icirc;chir" />
          </p>
          <p><br />
            <label>autour de : </label>
            <select name="alerte_ville">
              <option></option>
              <?php
	  	for($j=0;$j<$liste_ville->total;$j++)
			print('<option value="'.ma_htmlentities($liste_ville->occurrence[$j]['identifiant']).'"'.(($liste_ville->occurrence[$j]['identifiant']==$objet->ville)?(' selected="selected"'):('')).'>'.ma_htmlentities($liste_ville->occurrence[$j]['nom'].' '.$liste_ville->occurrence[$j]['code_postal']).'</option>');
      ?>
            </select>
          </p>
          <p><br />
            <label>dans un rayon de : </label>
            <select name="alerte_rayon">
              <option value="5"<?php if($objet->rayon==5) print(' selected="selected"');?>>5 km</option>
              <option value="10"<?php if($objet->rayon==10) print(' selected="selected"');?>>10 km</option>
              <option value="20"<?php if($objet->rayon==20) print(' selected="selected"');?>>20 km</option>
              <option value="35"<?php if($objet->rayon==35) print(' selected="selected"');?>>35 km</option>
              <option value="50"<?php if($objet->rayon==50) print(' selected="selected"');?>>50 km</option>
            </select>
          </p>
          <p><br />
            <label>Pr&eacute;cisez le type d'habitation recherch&eacute;e : </label>
            <br />
            <br />
            <?php
		for($j=0;$j<ALERTE_ALERTE_TYPE_MAX;$j++)
		{
			if($j<sizeof($objet->alerte_type)) $type=$objet->alerte_type[$j]['objet']->type;
			else $type=NULL;
  ?>
            <label class="w80">Type n&deg;<?php print(($j+1));?> : </label>
            <select name="alerte_type[]">
              <option></option>
              <?php
	  	for($k=0;$k<$liste_type->total;$k++)
			print('<option value="'.ma_htmlentities($liste_type->occurrence[$k]['identifiant']).'"'.(($type && $liste_type->occurrence[$k]['identifiant']==$type)?(' selected="selected"'):('')).'>'.ma_htmlentities(($liste_type->occurrence[$k]['designation'] != 'Chambre de bonne')?($liste_type->occurrence[$k]['designation']):('Ch. de bonne')).'</option>');
      ?>
            </select>
            <?php
		}
  ?>
          </p>
          <p class="submit"><br />
            <br />
            <input type="submit" class="submit simple" name="alerte_submit" value="Ajouter" />
          </p>
        </form>
      </div>
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT.'alerte/liste.php');?>">Retour &agrave; votre liste d'alertes</a></p>
    </div>
    <div id="pub_droite">
      <?php include(PWD_ADHERENT.'adsense_droit.php');?>
    </div>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
