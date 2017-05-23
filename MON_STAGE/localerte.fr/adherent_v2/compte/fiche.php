<?php
	define('ALERTE_CARDINALITE',3);
	
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'ville.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	$adherent=new ld_adherent();
	$adherent_erreur=0;
	
	$alerte=array();
	$alerte_erreur=array();
	for($i=0;$i<ALERTE_CARDINALITE;$i++)
	{
		$alerte[]=new ld_alerte();
		$alerte_erreur[]=0;
	}
	
	$cardinalite_erreur=false;
	
	if(isset($_REQUEST['adherent_submit']))
	{
		if((isset($_SESSION['adherent_identifiant'])))
		{
			$adherent->identifiant=$_SESSION['adherent_identifiant'];
			$adherent->lire();
			$adherent->email=$_REQUEST['adherent_email'];
			$mode=1;
		}
		else
		{
			$adherent->email=$_REQUEST['adherent_email'];
			if($adherent->lire('email'))
			{
				if($adherent->abonne!='OUI')
					$mode=2;
				else
					$mode=3;
			}
			else
			{
				$adherent->identifiant='';
				$adherent->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_adherent','identifiant',ADHERENT_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
				$mode=4;
			}
		}
		$adherent->passe=$_REQUEST['adherent_passe'];
		$adherent->confirmation=$_REQUEST['adherent_confirmation'];
		
		for($i=0;$i<sizeof($alerte);$i++)
		{
			if($_REQUEST['alerte'][$i]['identifiant']!='')
			{
				$alerte[$i]->identifiant=$_REQUEST['alerte'][$i]['identifiant'];
				$alerte[$i]->lire();
			}
			else
			{
				$alerte[$i]->identifiant='';
				$alerte[$i]->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_alerte','identifiant',ALERTE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
			}
			$alerte[$i]->adherent=$adherent->nouveau_identifiant;
			$alerte[$i]->ville=$_REQUEST['alerte'][$i]['ville'];
			$alerte[$i]->rayon=$_REQUEST['alerte'][$i]['rayon'];
			
			for($j=$alerte[$i]->alerte_type_compter()-1;$j>=0;$j--)
			{
				$resultat=$alerte[$i]->alerte_type_lire($j);
				$alerte_type=$resultat['objet'];
				$trouve=false;
				for($k=0;$k<sizeof($_REQUEST['alerte'][$i]['alerte_type']) && !$trouve;$k++)
				{
					if($alerte_type->type==$_REQUEST['alerte'][$i]['alerte_type'][$k]['type'])
						$trouve=true;
				}
				if(!$trouve)
					$alerte[$i]->alerte_type_supprimer($j);
			}
			
			for($j=0;$j<sizeof($_REQUEST['alerte'][$i]['alerte_type']);$j++)
			{
				if($alerte[$i]->alerte_type_trouver($_REQUEST['alerte'][$i]['alerte_type'][$j]['nouveau_type'],'nouveau_type')===false)
				{
					if($_REQUEST['alerte'][$i]['alerte_type'][$j]['type']!='')
						$clef=$alerte[$i]->alerte_type_trouver($_REQUEST['alerte'][$i]['alerte_type'][$j]['type'],'type');
					else
						$clef=false;
					
					if($_REQUEST['alerte'][$i]['alerte_type'][$j]['nouveau_type']!='')
					{
						if($clef!==false)
						{
							$alerte_type=new ld_alerte_type();
							$alerte_type->alerte=$alerte[$i]->identifiant;
							$alerte_type->nouveau_alerte=$alerte[$i]->nouveau_identifiant;
							$alerte_type->type=$_REQUEST['alerte'][$i]['alerte_type'][$j]['type'];
							$alerte_type->nouveau_type=$_REQUEST['alerte'][$i]['alerte_type'][$j]['nouveau_type'];
							$alerte[$i]->alerte_type_modifier($alerte_type,$clef,'modifier');
						}
						else
						{
							$alerte_type=new ld_alerte_type();
							$alerte_type->alerte=$alerte[$i]->identifiant;
							$alerte_type->nouveau_alerte=$alerte[$i]->nouveau_identifiant;
							$alerte_type->type='';
							$alerte_type->nouveau_type=$_REQUEST['alerte'][$i]['alerte_type'][$j]['nouveau_type'];
							$alerte[$i]->alerte_type_ajouter($alerte_type,'ajouter');
						}
					}
					else
					{
						if($clef!==false && $_REQUEST['alerte'][$i]['alerte_type'][$j]['type']!='')
							$alerte[$i]->alerte_type_supprimer($clef);
					}
				}
			}
		}
		
		switch($_REQUEST['adherent_submit'])
		{
			case 'Rafraîchir':
				break;
			case 'Valider':
				switch($mode)
				{
					case 1:
						break;
					case 2:
					case 3:
						$adherent->abonne='OUI';
						$adherent->validation='OUI';
						break;
					case 4:
						$adherent->abonne='OUI';
						$adherent->brule='NON';
						$adherent->validation='OUI';
						$adherent->spamtrap='NON';
						$adherent->hardbounce=0;
						$adherent->softbounce=0;
						$adherent->plainte=0;
						break;
				}
				
				$adherent_erreur=$adherent->tester(($mode>=3)?('ajouter'):('modifier'));
				
				$cardinalite=0;
				$erreur=false;
				for($i=0;$i<sizeof($alerte);$i++)
				{
					if(!isset($_REQUEST['alerte'][$i]['enregistrer']))
					{
						$cardinalite++;
						if($_REQUEST['alerte'][$i]['identifiant']!='')
							$alerte_erreur[$i]=$alerte[$i]->tester('modifier');
						else
						{
							$alerte_erreur[$i]=$alerte[$i]->tester('ajouter');
							$alerte_erreur[$i]&=~ALERTE_ADHERENT_ERREUR;
						}
						if(!$erreur && $alerte_erreur[$i])
							$erreur=true;
					}
				}
				
				$cardinalite_erreur=!$cardinalite;
				
				if(!$adherent_erreur && !$cardinalite_erreur && !$erreur)
				{
					if(isset($_SESSION['adherent_identifiant']) || $mode<4)
						$adherent_erreur=$adherent->modifier(isset($_REQUEST['lalettredujour']));
					else
						$adherent_erreur=$adherent->ajouter(isset($_REQUEST['lalettredujour']));
					
					if($mode==2 && !$adherent_erreur)
					{
						$liste=new ld_liste
						('
							select identifiant
							from alerte
							where adherent=\''.addslashes($adherent->identifiant).'\'
						');
						for($i=0;$i<$liste->total;$i++)
						{
							$alerte_ancien=new ld_alerte();
							$alerte_ancien->identifiant=$liste->occurrence[$i]['identifiant'];
							$alerte_ancien->supprimer();
						}
					}
					
					$erreur=false;
					for($i=0;$i<sizeof($alerte);$i++)
					{
						if(!isset($_REQUEST['alerte'][$i]['enregistrer']))
						{
							if($_REQUEST['alerte'][$i]['identifiant']!='')
								$alerte_erreur[$i]=$alerte[$i]->modifier();
							else
								$alerte_erreur[$i]=$alerte[$i]->ajouter();
						}
						elseif($_REQUEST['alerte'][$i]['identifiant'])
							$alerte[$i]->supprimer();
						
						if($alerte_erreur[$i])
							$erreur=true;
					}
					
					if(!$erreur)
					{
						$_SESSION['adherent_identifiant']=$adherent->identifiant;
						if($mode==2 || $mode==4)
							$adherent->envoyer('inscription');
						header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=ajouter'));
						die();
					}
				}
				break;
		}
	}
	elseif(isset($_SESSION['adherent_identifiant']))
	{
		for($i=0;$i<sizeof($alerte);$i++)
			if(!isset($_REQUEST['alerte'][$i]['departement']))
			{
				$_REQUEST['alerte'][$i]['departement']='';
				$_REQUEST['alerte'][$i]['enregistrer']='';
			}
		
		$adherent->identifiant=$_SESSION['adherent_identifiant'];
		$adherent->lire();
		
		$liste=new ld_liste
		('
			select identifiant
			from alerte
			where adherent=\''.addslashes($_SESSION['adherent_identifiant']).'\'
		');
		
		for($i=0;$i<$liste->total;$i++)
		{
			$alerte[$i]=new ld_alerte();
			$alerte[$i]->identifiant=$liste->occurrence[$i]['identifiant'];
			$alerte[$i]->lire();
			
			$ville=new ld_ville();
			$ville->identifiant=$alerte[$i]->ville;
			$ville->lire();
			$_REQUEST['alerte'][$i]['departement']=$ville->departement;
			unset($_REQUEST['alerte'][$i]['enregistrer']);
		}
	}
	else
	{
		for($i=0;$i<sizeof($alerte);$i++)
			if(!isset($_REQUEST['alerte'][$i]['departement']))
			{
				$_REQUEST['alerte'][$i]['departement']='';
				$_REQUEST['alerte'][$i]['enregistrer']='';
			}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
<script language="javascript">
	function rafraichir()
	{
		var objet=document.getElementsByName('adherent_submit');
		for(i=0;i<objet.length;i++)
			if(objet[i].tagName=='INPUT')
			{
				objet[i].value='Rafraîchir';
				objet[i].click();
			}
	}
	
	function alerte_verifier(actionner, index)
	{
		if(actionner)
		{
			document.getElementsByName('alerte['+index+'][enregistrer]')[0].checked=false;
			
			objet=document.getElementsByTagName('a');
			for(i=0;i<objet.length;i++)
				if(objet[i].id=='alerte_'+index+'_enregistrer')
					objet[i].style.visibility='visible';
		}
		else
		{
			var annuler=true;
			if(document.getElementsByName('alerte['+index+'][departement]')[0].selectedIndex)
				annuler=false;
			objet=document.getElementsByName('alerte['+index+'][rayon]')[0];
			if(objet.selectedIndex && objet.options[objet.selectedIndex].value!=<?php print(ALERTE_RAYON_DEFAUT);?>)
				annuler=false;
			if(document.getElementsByName('alerte['+index+'][ville]')[0].selectedIndex)
				annuler=false;
			for(i=0;i<<?php print(ALERTE_ALERTE_TYPE_MAX);?> && annuler;i++)
				if(document.getElementsByName('alerte['+index+'][alerte_type]['+i+'][nouveau_type]')[0].selectedIndex)
					annuler=false;
			
			if(annuler)
				alerte_annuler(index);
		}
	}
	
	function alerte_annuler(index)
	{
		document.getElementsByName('alerte['+index+'][enregistrer]')[0].checked=true;
		document.getElementsByName('alerte['+index+'][departement]')[0].selectedIndex=0;
		
		objet=document.getElementsByName('alerte['+index+'][rayon]')[0];
		for(i=0;i<objet.options.length;i++)
			if(objet.options[i].value==<?php print(ALERTE_RAYON_DEFAUT);?>)
				objet.selectedIndex=i;
		
		document.getElementsByName('alerte['+index+'][ville]')[0].selectedIndex=0;
		
		for(i=0;i<<?php print(ALERTE_ALERTE_TYPE_MAX);?>;i++)
			document.getElementsByName('alerte['+index+'][alerte_type]['+i+'][nouveau_type]')[0].selectedIndex=0;
		
		document.getElementsByName('adherent_submit')[0].value='Rafra&icirc;chir';
		document.getElementsByName('adherent_submit')[0].click();
		
		objet=document.getElementsByTagName('a');
		for(i=0;i<objet.length;i++)
			if(objet[i].id=='alerte_'+index+'_enregistrer')
				objet[i].style.visibility='hidden';
		
		rafraichir();
	}
	
	function alerte_initialiser(index)
	{
		document.write('<a href="" id="alerte_'+index+'_enregistrer" onclick="alerte_annuler('+index+'); return false;"><img src="<?php print(URL_ADHERENT_V2.'image/annuler.jpg');?>" /></a>');
		
		if(document.getElementsByName('alerte['+index+'][enregistrer]')[0].checked)
		{
			objet=document.getElementsByTagName('a');
			for(i=0;i<objet.length;i++)
				if(objet[i].id=='alerte_'+index+'_enregistrer')
					objet[i].style.visibility='hidden';
		}
		else
		{
			objet=document.getElementsByTagName('a');
			for(i=0;i<objet.length;i++)
				if(objet[i].id=='alerte_'+index+'_enregistrer')
					objet[i].style.visibility='visible';
		}
		
		objet=document.getElementsByTagName('input');
		for(i=0;i<objet.length;i++)
			if(objet[i].id=='alerte['+index+'][enregistrer]')
				objet[i].style.visibility='hidden';
		
		objet=document.getElementsByTagName('label');
		for(i=0;i<objet.length;i++)
			if(objet[i].getAttribute('for')=='alerte['+index+'][enregistrer]' || objet[i].getAttribute('htmlFor')=='alerte['+index+'][enregistrer]')
				objet[i].style.visibility='hidden';
	}
</script>
</head>
<body onload="DonnerFocus('adherent_fiche','adherent_email',0);">
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="adherent_fiche">
    <?php if(isset($_SESSION['adherent_identifiant'])) print('Vos crit&egrave;res'); else print('Inscription');?>
  </h1>
  <?php if(!isset($_SESSION['adherent_identifiant'])) print('<p id="adherent_fiche">Veuillez entrer l\'adresse email &agrave; laquelle vous d&eacute;sirez recevoir vos annonces</p>');?>
  <form id="adherent_fiche" action="<?php print(URL_ADHERENT_V2.'compte/fiche.php');?>" method="post">
    <div id="adherent_email">
      <?php
	if(isset($_REQUEST['adherent_submit']) && ($adherent_erreur & ADHERENT_EMAIL_ERREUR_LONGUEUR || $adherent_erreur & ADHERENT_EMAIL_ERREUR_FILTRE))
	  	print('<p><img src="'.URL_ADHERENT_V2.'image/ko.png" />Adresse email erron&eacute;</p>');
	elseif(isset($_REQUEST['adherent_submit']) && $adherent_erreur & ADHERENT_EMAIL_ERREUR_UNIQUE)
	  	print('<p><img src="'.URL_ADHERENT_V2.'image/ko.png" />Email d&eacute;j&agrave; existant</p>');
?>
      <label>Votre adresse-email:</label>
      <input type="text" name="adherent_email" value="<?php print(ma_htmlentities($adherent->email));?>" maxlength="<?php print(ma_htmlentities(ADHERENT_EMAIL_MAX));?>" />
    </div>
    <div id="adherent_passe">
      <?php
	if(isset($_REQUEST['adherent_submit']) && $adherent_erreur & ADHERENT_PASSE_ERREUR)
	  	print('<p><img src="'.URL_ADHERENT_V2.'image/ko.png" />Mot de passe de '.ma_htmlentities(ADHERENT_PASSE_MIN).' &agrave; '.ma_htmlentities(ADHERENT_PASSE_MAX).' caract&egrave;res</p>');
	elseif(isset($_REQUEST['adherent_submit']) && $adherent_erreur & ADHERENT_CONFIRMATION_ERREUR)
	  	print('<p><img src="'.URL_ADHERENT_V2.'image/ko.png" />Mot de passe différent de sa confirmation</p>');
?>
      <label>Choisissez un mot de passe:</label>
      <input type="password" name="adherent_passe" value="<?php print(ma_htmlentities($adherent->passe));?>" maxlength="<?php print(ma_htmlentities(ADHERENT_PASSE_MAX));?>" />
    </div>
    <div id="adherent_confirmation">
      <label>Mot de passe (confirmation):</label>
      <input type="password" name="adherent_confirmation" value="<?php print(ma_htmlentities($adherent->confirmation));?>" maxlength="<?php print(ma_htmlentities(ADHERENT_PASSE_MAX));?>" />
    </div>
 <?php
	for($i=0;$i<ALERTE_CARDINALITE;$i++)
	{
?>
    <h3 id="alerte_<?php print($i);?>">Alerte n&deg;<?php print($i+1);?></h3>
    <div id="alerte_<?php print($i);?>_enregistrer">
      <?php
	if(isset($_REQUEST['adherent_submit']) && ($alerte_erreur[$i] || (!$i && $cardinalite_erreur)))
	  	print('<p><img src="'.URL_ADHERENT_V2.'image/ko.png" />Votre alerte mail est incompl&egrave;te</p>');
?>
      <input id="alerte[<?php print($i);?>][enregistrer]" type="checkbox" name="alerte[<?php print($i);?>][enregistrer]" value="" <?php if(isset($_REQUEST['alerte'][$i]['enregistrer'])) print(' checked="checked"');?> onclick="if(this.checked) alerte_annuler(<?php print($i);?>);" />
      <label for="alerte[<?php print($i);?>][enregistrer]">Annuler</label>
    </div>
    <input type="hidden" name="alerte[<?php print($i);?>][identifiant]" value="<?php print(ma_htmlentities($alerte[$i]->identifiant));?>" />
    <div id="alerte_<?php print($i);?>_departement">
      <label>Je cherche &agrave; louer dans le d&eacute;partement :</label>
      <select name="alerte[<?php print($i);?>][departement]" onchange=" alerte_verifier(this.selectedIndex, <?php print($i);?>); rafraichir();">
        <option value="">Choisissez un d&eacute;partement</option>
        <?php
		$liste=new ld_liste
		('
			select
				identifiant,
				nom
			from departement
			order by nom
		');
		for($j=0;$j<$liste->total;$j++)
			print('<option value="'.ma_htmlentities($liste->occurrence[$j]['identifiant']).'"'.(($liste->occurrence[$j]['identifiant']==$_REQUEST['alerte'][$i]['departement'])?(' selected="selected"'):('')).'>'.ma_htmlentities($liste->occurrence[$j]['nom']).'</option>');
?>
      </select>
      <noscript>
      <input id="submit" type="submit" name="adherent_submit" value="Rafra&icirc;chir" tabindex="2" />
      </noscript>
      <script language="javascript">
	  	try
		{
		  	var attribut=document.createAttribute('class');
			attribut.nodeValue='js';
	    	document.getElementsByName('alerte[<?php print($i);?>][departement]')[0].setAttributeNode(attribut);
		}
		catch(e){}
      </script>
    </div>
    <div id="alerte_<?php print($i);?>_rayon">
      <label>&agrave; :</label>
      <select name="alerte[<?php print($i);?>][rayon]" onchange="alerte_verifier(this.selectedIndex && this[this.selectedIndex].value!=<?php print(ALERTE_RAYON_DEFAUT);?>, <?php print($i);?>);">
        <option value="5"<?php if($alerte[$i]->rayon==5) print(' selected="selected"');?>>5 km</option>
        <option value="10"<?php if($alerte[$i]->rayon==10) print(' selected="selected"');?>>10 km</option>
        <option value="20"<?php if($alerte[$i]->rayon==20) print(' selected="selected"');?>>20 km</option>
        <option value="35"<?php if($alerte[$i]->rayon==35) print(' selected="selected"');?>>35 km</option>
        <option value="50"<?php if($alerte[$i]->rayon==50) print(' selected="selected"');?>>50 km</option>
      </select>
    </div>
    <div id="alerte_<?php print($i);?>_ville">
      <label>autour de :</label>
      <select name="alerte[<?php print($i);?>][ville]" onchange="alerte_verifier(this.selectedIndex, <?php print($i);?>);">
        <?php
		$liste=new ld_liste
		('
			select
				identifiant,
				nom,
				code_postal
			from ville
			where departement=\''.addslashes($_REQUEST['alerte'][$i]['departement']).'\'
			order by nom, code_postal
		');
		if($liste->total)
			print('<option value="">Choisissez une ville</option>');
		else
			print('<option value="">Choisissez d\'abord un d&eacute;partement</option>');
		for($j=0;$j<$liste->total;$j++)
			print('<option value="'.ma_htmlentities($liste->occurrence[$j]['identifiant']).'"'.(($liste->occurrence[$j]['identifiant']==$alerte[$i]->ville)?(' selected="selected"'):('')).'>'.ma_htmlentities($liste->occurrence[$j]['nom'].' ('.$liste->occurrence[$j]['code_postal'].')').'</option>');
?>
      </select>
    </div>
    <?php
		for($j=0;$j<ALERTE_ALERTE_TYPE_MAX;$j++)
		{
			if($j<$alerte[$i]->alerte_type_compter())
			{
				$resultat=$alerte[$i]->alerte_type_lire($j);
				$alerte_type=$resultat['objet'];
			}
			else
				$alerte_type=new ld_alerte_type();
?>
    <div id="alerte_<?php print($i);?>_alerte_type_<?php print($j);?>">
      <input type="hidden" name="alerte[<?php print($i);?>][alerte_type][<?php print($j);?>][type]" value="<?php print(ma_htmlentities($alerte_type->type));?>" />
      <label>
      <?php if(!$j) print('Je souhaiterais louer un(e) :');?>
      </label>
      <select name="alerte[<?php print($i);?>][alerte_type][<?php print($j);?>][nouveau_type]" onchange="alerte_verifier(this.selectedIndex, <?php print($i);?>);">
        <option value="">Type n&deg; <?php print($j+1);?></option>
        <?php
		$liste=new ld_liste
		('
			select
				identifiant,
				designation
			from type
			where parent is null
			order by position
		');
		for($k=0;$k<$liste->total;$k++)
			print('<option value="'.ma_htmlentities($liste->occurrence[$k]['identifiant']).'"'.(($alerte_type->nouveau_type==$liste->occurrence[$k]['identifiant'])?(' selected="selected"'):('')).'>'.ma_htmlentities($liste->occurrence[$k]['designation']).'</option>');
?>
      </select>
    </div>
    <?php
		}
?>
<?php
	}
    ?>
    <div id="adherent_lalettredujour">
      <input id="lalettredujour" type="checkbox" name="lalettredujour" value="" <?php if(isset($_REQUEST['lalettredujour'])) print(' checked="checked"');?> />
      <label for="lalettredujour">Je souhaite &eacute;galement m'abonner &agrave; la lettre du jour</label>
      ( <a href="http://www.lalettredujour.fr/inclusion/newsletter.php?mode=specimen" target="_blank">voir la derni&egrave;re newsletter</a> ) </div>
    <div id="adherent_submit">
      <input id="submit" type="submit" name="adherent_submit" value="Valider" />
    </div>
	   	<?php
			for($i=0;$i<sizeof($alerte) && $i<ALERTE_CARDINALITE;$i++)
			    print('<script language="">alerte_initialiser('.$i.');</script>');
        ?>
  </form>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
