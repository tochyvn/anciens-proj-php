<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'alerte_type.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'ville.php');
	require_once(PWD_INCLUSION.'localisation_recherche.php');
	
	$liste_type=new ld_liste('select identifiant, designation from type where parent is null');
	
	$adherent=new ld_adherent();
	$adherent->identifiant=$_SESSION['adherent_identifiant'];
	$adherent->lire();
		
	$alerte=array();
	$liste=new ld_liste('select identifiant from alerte where adherent='.$_SESSION['adherent_identifiant'].' order by identifiant');
	for($i=0;$i<$liste->total;$i++)
	{
		$temp=new ld_alerte();
		$temp->identifiant=$liste->occurrence[$i]['identifiant'];
		$temp->lire();
		
		$alerte[]=$temp;
	}
	$alerte_erreur=false;
	
	if(isset($_REQUEST['alerte_submit']))
	{
		$objet=NULL;
		for($i=0,$trouve=false;$i<sizeof($alerte) && !$trouve;$i++)
		{
			if($alerte[$i]->identifiant==$_REQUEST['alerte_identifiant'])
			{
				$objet=&$alerte[$i];
				$trouve=true;
			}
		}
		
		if($objet!==NULL)
		{
			$objet->ville=(isset($_REQUEST['alerte_ville']))?(str_replace('VILLE_','',$_REQUEST['alerte_ville'])):(NULL);
			$objet->rayon=$_REQUEST['alerte_rayon'];
			
			for($i=sizeof($_REQUEST['alerte_type'])-1;$i>=0;$i--)
				if(!$_REQUEST['alerte_type'][$i]) unset($_REQUEST['alerte_type'][$i]);
			
			$type=array_unique($_REQUEST['alerte_type']);
			$type=array_values($type);
			
			for($i=$objet->alerte_type_compter()-1;$i>=0;$i--)
			{
				$resultat=$objet->alerte_type_lire($i);
				$alerte_type=$resultat['objet'];
				
				$trouve=false;
				for($j=0;$j<sizeof($type) && !$trouve;$j++)
				{
					if($alerte_type->type==$type[$j])
						$trouve=true;
				}
				if(!$trouve)
					$objet->alerte_type_supprimer($i);
			}
			
			for($i=0;$i<sizeof($type);$i++)
			{
				$clef=$objet->alerte_type_trouver($type[$i],'type');
				if($clef!==false)
				{
					$alerte_type=new ld_alerte_type();
					$alerte_type->alerte=$objet->identifiant;
					$alerte_type->nouveau_alerte=$objet->nouveau_identifiant;
					$alerte_type->type=$type[$i];
					$alerte_type->nouveau_type=$type[$i];
					$objet->alerte_type_modifier($alerte_type,$clef,'modifier');
				}
				else
				{
					$alerte_type=new ld_alerte_type();
					$alerte_type->alerte=$objet->identifiant;
					$alerte_type->nouveau_alerte=$objet->nouveau_identifiant;
					$alerte_type->type='';
					$alerte_type->nouveau_type=$type[$i];
					$objet->alerte_type_ajouter($alerte_type,'ajouter');
				}
			}
			
			switch($_REQUEST['alerte_submit'])
			{
				case 'Rafraîchir':
					break;
				case 'Modifier':
					$alerte_erreur=$objet->modifier();
					break;
				case 'Supprimer':
					$alerte_erreur=$objet->supprimer();
					if(!$alerte_erreur) {
						$alerte=array();
						$liste=new ld_liste('select identifiant from alerte where adherent='.$_SESSION['adherent_identifiant'].' order by identifiant');
						for($i=0;$i<$liste->total;$i++) {
							$temp=new ld_alerte();
							$temp->identifiant=$liste->occurrence[$i]['identifiant'];
							$temp->lire();
							$alerte[]=$temp;
						}
						$alerte_erreur=false;
					}
					break;
			}
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
    <div id="alerte_liste">
      <div id="alerte_adherent"> Bienvenue, <?php print(ma_htmlentities($adherent->email));?><br />
        Vous &ecirc;tes inscrit sur localerte.fr depuis le <?php print(ma_htmlentities(strftime('%d %B %Y',$adherent->date_enregistrement)));?> </div>
      <?php
	if(isset($_REQUEST['alerte_submit']))
	{
	  	if($_REQUEST['alerte_submit']=='Supprimer')
		{
		  	if($alerte_erreur) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/erreur.png"> Une erreur est survenue</p>');
		  	if(!$alerte_erreur) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/valid.png"> L\'alerte a bien &eacute;t&eacute; supprim&eacute;e</p>');
		}
	  	if($_REQUEST['alerte_submit']=='Modifier')
		{
		  	if($alerte_erreur&ALERTE_VILLE_ERREUR) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/erreur.png"> Indiquez une ville pour votre recherche</p>');
		  	if($alerte_erreur&ALERTE_RAYON_ERREUR_VALEUR || $alerte_erreur&ALERTE_RAYON_ERREUR_FILTRE) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/erreur.png"> Renseignez un rayon de recherche</p>');
		  	if($alerte_erreur&ALERTE_ALERTE_TYPE_ERREUR_TAILLE || $alerte_erreur&ALERTE_ALERTE_TYPE_ERREUR_CLASSE) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/erreur.png"> Renseignez au moins 1 type d\'habitation recherch&eacute;</p>');
		  	if(!$alerte_erreur) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/valid.png"> La modification a &eacute;t&eacute; apport&eacute;e</p>');
		}
	  	if($_REQUEST['alerte_submit']=='Ajouter')
		{
			print
			('
				<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/valid.png"> Votre alerte e-mail a bien &eacute;t&eacute; prise en compte. Vous recevrez d&eacute;sormais chaque jour toutes les nouvelles annonces de moins de 4 jours relev&eacute;es sur internet et dans la presse.<br />
				Dans le cas contraire, merci de v&eacute;rifier les courriers ind&eacute;sirables de votre boite e-mail.<br />
				<br /><a class="orange_fonce" href="'.URL_ADHERENT.'alerte/liste.php">Allez &agrave; la liste des alertes</a>
				<br /><a class="orange_fonce" href="'.URL_ADHERENT.'annonce/liste.php">Consultez les annonces</a>
				</p>
			');
		}
	}
?>
      <p class="lien"> <a class="bleu_fonce gras" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Voir les annonces</a><br />
        <?php if(sizeof($alerte)<ALERTE_CARDINALITE) print('<a class="orange2 gras" href="'.URL_ADHERENT.'alerte/fiche.php">Ajouter une nouvelle alerte</a><br />');?>
      </p>
      <?php
	for($i=0;$i<sizeof($alerte);$i++)
	{
		$objet=&$alerte[$i];
		//print($objet->ville);
		
		if(!isset($_REQUEST['alerte_filtre_'.$i]) && $objet->ville)
		{
			$ville=new ld_ville();
			$ville->identifiant=$objet->ville;
			if($ville->lire()) $_REQUEST['alerte_filtre_'.$i]=$ville->code_postal.' '.$ville->nom;
		}
		
		$localisation_recherche=new ld_localisation_recherche();
		$document=new DOMDocument();
		$document->loadXML($localisation_recherche->creer_xml((isset($_REQUEST['alerte_filtre_'.$i]))?($_REQUEST['alerte_filtre_'.$i]):('')));
		$items=$document->getElementsByTagName('item');
?>
      <br />
      <h2 class="alerte">Votre alerte <?php print($i+1);?> :</h2>
      <div class="alerte">
        <form action="liste.php" class="alerte">
          <p>
            <input type="hidden" name="alerte_identifiant" value="<?php print(ma_htmlentities($objet->identifiant));?>" />
          </p>
          <p><br />
            <label>Ville : </label>
            <input class="js-label js-localisation" type="text" name="<?php print('alerte_filtre_'.$i);?>" value="<?php print(((isset($_REQUEST['alerte_filtre_'.$i]))?(ma_htmlentities($_REQUEST['alerte_filtre_'.$i])):('')));?>" title="Saisissez la ville ou code postal" onchange="js_localisation_changer($(this),$('input[name=&quot;alerte_ville&quot;]'));" />
			<input type="hidden" name="alerte_ville" value="<?php print('VILLE_'.$objet->ville);?>" />
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
            <input type="submit" class="submit simple" name="alerte_submit" value="Modifier" />
            <input type="submit" class="submit simple" name="alerte_submit" value="Supprimer" onclick="return confirm('Êtes-vous sur de vouloir supprimer cette alerte ?');" />
          </p>
        </form>
      </div>
      <?php
	}
?>
      <p class="lien">
        <?php if(sizeof($alerte)<ALERTE_CARDINALITE) print('<a class="orange2 gras" href="'.URL_ADHERENT.'alerte/fiche.php">Ajouter une nouvelle alerte</a><br />');?>
        <a class="bleu_fonce gras" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Voir les annonces</a></p>
      <p class="gauche"><?php include(PWD_ADHERENT.'adsense.php');?></p>
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
</html>