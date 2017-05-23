<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'allopass.php');
	require_once(PWD_INCLUSION.'wha.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'abonnement.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'annonce.php');
	require_once(PWD_INCLUSION.'facture.php');
	
	define('STATISTIQUE_X',15);
	define('STATISTIQUE_Y',200);
	
	$correspondance_compteur=array
	(
		'WHA'=>array
		(
			'designation'=>'WHA',
			'classe'=>'ld_wha',
			'couleur'=>'#FF0000'
		),
		/*'CODE_GRATUIT'=>array
		(
			'designation'=>'Codes gratuits',
			'classe'=>'ld_code',
			'couleur'=>'#00FF00',
			'parametre'=>'GRATUIT'
		),
		'CODE_PAYANT'=>array
		(
			'designation'=>'Codes payants',
			'classe'=>'ld_code',
			'couleur'=>'#0000FF',
			'parametre'=>'PAYANT'
		),
		'CODE_INACTIVITE'=>array
		(
			'designation'=>'Codes données pour inactivité',
			'classe'=>'ld_code',
			'couleur'=>'#0F0F0F',
			'parametre'=>'INACTIVITE'
		),*/
		/*'ALLOPASS_GRATUIT_V2'=>array
		(
			'designation'=>'Allopass gratuits V2',
			'classe'=>'ld_allopass',
			'couleur'=>'#FFFFFF',
			'parametre'=>'GRATUIT_V2'
		),*/
		'ALLOPASS_PAYANT_V2_0_88'=>array
		(
			'designation'=>'Allopass payants V2 0.88',
			'classe'=>'ld_allopass',
			'couleur'=>'#00FF00',
			'parametre'=>'PAYANT_V2_088'
		),
		'ALLOPASS_PAYANT_V2_1_05'=>array
		(
			'designation'=>'Allopass payants V2 1.05',
			'classe'=>'ld_allopass',
			'couleur'=>'#00CC00',
			'parametre'=>'PAYANT_V2_105'
		),
		'ALLOPASS_PAYANT_V2_1_20'=>array
		(
			'designation'=>'Allopass payants V2 1.20',
			'classe'=>'ld_allopass',
			'couleur'=>'#006600',
			'parametre'=>'PAYANT_V2_120'
		),
		/*'ALLOPASS_PAYANT_V2_1_67'=>array
		(
			'designation'=>'Allopass payants V2 Mobile',
			'classe'=>'ld_allopass',
			'couleur'=>'#00dd00',
			'parametre'=>'PAYANT_V2_167'
		),*/
		/*'ALLOPASS_GRATUIT_V2.5'=>array
		(
			'designation'=>'Allopass gratuits V2.5',
			'classe'=>'ld_allopass',
			'couleur'=>'#FFFFFF',
			'parametre'=>'GRATUIT_V2.5'
		),*/
		'ALLOPASS_PAYANT_V2.5_0_88'=>array
		(
			'designation'=>'Allopass payants V2.5 Appel',
			'classe'=>'ld_allopass',
			'couleur'=>'#669933',
			'parametre'=>'PAYANT_V2.5_088'
		),
		'ALLOPASS_PAYANT_V2.5_1_05'=>array
		(
			'designation'=>'Allopass payants V2.5 1.05',
			'classe'=>'ld_allopass',
			'couleur'=>'#0000CC',
			'parametre'=>'PAYANT_V2.5_105'
		),
		'ALLOPASS_PAYANT_V2.5_1_20'=>array
		(
			'designation'=>'Allopass payants V2.5 SMS',
			'classe'=>'ld_allopass',
			'couleur'=>'#ffcc33',
			'parametre'=>'PAYANT_V2.5_120'
		),
		'ALLOPASS_PAYANT_V2.5_1_67'=>array
		(
			'designation'=>'Allopass payants V2.5 Mobile',
			'classe'=>'ld_allopass',
			'couleur'=>'#ff9999',
			'parametre'=>'PAYANT_V2.5_167'
		),
		'ALLOPASS_PAYANT_V2.6_0_85'=>array
		(
			'designation'=>'Allopass payants V2.6 SMS',
			'classe'=>'ld_allopass',
			'couleur'=>'#ff9900',
			'parametre'=>'PAYANT_V2.6_085'
		),
		'ALLOPASS_PAYANT_V2.6_1_05'=>array
		(
			'designation'=>'Allopass payants V2.6 TEL',
			'classe'=>'ld_allopass',
			'couleur'=>'#009999',
			'parametre'=>'PAYANT_V2.6_105'
		),
		'ADHERENT_ABONNEMENT'=>array
		(
			'designation'=>'Abonnés',
			'classe'=>'ld_adherent',
			'couleur'=>'#990000',
			'parametre'=>'ABONNEMENT'
		),
		'ADHERENT_DESABONNEMENT'=>array
		(
			'designation'=>'Désabonnés',
			'classe'=>'ld_adherent',
			'couleur'=>'#009900',
			'parametre'=>'DESABONNEMENT'
		),
		'ADHERENT_ENREGISTREMENT'=>array
		(
			'designation'=>'Nouveaux inscrits',
			'classe'=>'ld_adherent',
			'couleur'=>'#000099',
			'parametre'=>'ENREGISTREMENT'
		),
		'ABONNEMENT_ENREGISTREMENT'=>array
		(
			'designation'=>'Abonnements souscrits',
			'classe'=>'ld_abonnement',
			'couleur'=>'#660000',
			'parametre'=>'ENREGISTREMENT'
		),
		'FACTURE_ABONNEMENT_V2'=>array
		(
			'designation'=>'Somme des montants d\'abonnements V2',
			'classe'=>'ld_facture',
			'couleur'=>'#CC0000',
			'parametre'=>'ABONNEMENT_V2'
		),
		'FACTURE_ABONNEMENT_AB'=>array
		(
			'designation'=>'Somme des montants d\'abonnements AB',
			'classe'=>'ld_facture',
			'couleur'=>'#880000',
			'parametre'=>'ABONNEMENT_AB'
		),
		'FACTURE_ABONNEMENT_VF'=>array
		(
			'designation'=>'Somme des montants d\'abonnements VF',
			'classe'=>'ld_facture',
			'couleur'=>'#008800',
			'parametre'=>'ABONNEMENT_VF'
		),
		'FACTURE_ABONNEMENT_OR'=>array
		(
			'designation'=>'Somme des montants d\'abonnements OR',
			'classe'=>'ld_facture',
			'couleur'=>'#000088',
			'parametre'=>'ABONNEMENT_OR'
		),
		'FACTURE_ABONNEMENT_NULL'=>array
		(
			'designation'=>'Somme des montants d\'abonnements NULL',
			'classe'=>'ld_facture',
			'couleur'=>'#000088',
			'parametre'=>'ABONNEMENT_NULL'
		),
		'FACTURE_ABONNEMENT_WHA'=>array
		(
			'designation'=>'Somme des montants d\'abonnements WHA',
			'classe'=>'ld_facture',
			'couleur'=>'#008800',
			'parametre'=>'ABONNEMENT_WHA'
		),
		'FACTURE_ABONNEMENT_CHEQUE'=>array
		(
			'designation'=>'Somme des montants d\'abonnements CHEQUE',
			'classe'=>'ld_facture',
			'couleur'=>'#880000',
			'parametre'=>'ABONNEMENT_CHEQUE'
		),
		'FACTURE_ABONNEMENT_PAYPAL'=>array
		(
			'designation'=>'Somme des montants d\'abonnements PAYPAL',
			'classe'=>'ld_facture',
			'couleur'=>'#888800',
			'parametre'=>'ABONNEMENT_PAYPAL'
		),
		'FACTURE_ABONNEMENT_CB'=>array
		(
			'designation'=>'Somme des montants d\'abonnements CB',
			'classe'=>'ld_facture',
			'couleur'=>'#880088',
			'parametre'=>'ABONNEMENT_CB'
		),
		'FACTURE_FORFAIT'=>array
		(
			'designation'=>'Somme des montants des forfaits',
			'classe'=>'ld_facture',
			'couleur'=>'#330000',
			'parametre'=>'FORFAIT'
		)/*,
				'FACTURE'=>array
		(
			'designation'=>'Somme des montants d\'abonnements',
			'classe'=>'ld_facture',
			'couleur'=>'#FF6666',
			'parametre'=>'ABONNEMENT'
		)/*,

		'ABONNEMENT_PREMIERE_UTILISATION'=>array
		(
			'designation'=>'Abonnements utilisés pour la première fois',
			'classe'=>'ld_abonnement',
			'couleur'=>'#00FF00',
			'parametre'=>'PREMIERE_UTILISATION'
		),
		'ABONNEMENT_DERNIERE_UTILISATION'=>array
		(
			'designation'=>'Abonnements utilisés pour la dernière fois',
			'classe'=>'ld_abonnement',
			'couleur'=>'#0000FF',
			'parametre'=>'DERNIERE_UTILISATION'
		)*/
	);

	$liste=new ld_liste
	('
		select
			identifiant,
			designation,
			couleur
		from provenance
		order by designation
	');
	
	for($i=0;$i<$liste->total;$i++)
		$correspondance_compteur['PROVENANCE_'.$liste->occurrence[$i]['identifiant']]=array
		(
			'designation'=>$liste->occurrence[$i]['designation'],
			'classe'=>'ld_annonce',
			'couleur'=>$liste->occurrence[$i]['couleur'],
			'parametre'=>array($liste->occurrence[$i]['identifiant'],'TOUTES')
		);
	
	$correspondance_periode=array
	(
		'H'=>array('00H','01H','02H','03H','04H','05H','06H','07H','08H','09H','10H','11H','12H','13H','14H','15H','16H','17H','18H','19H','20H','21H','22H','23H'),
		'S'=>array('','Lu','Ma','Me','Je','Ve','Sa','Di'),
		'M'=>array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31),
		'A'=>array('','Jan','F&eacute;v','Mars','Avril','Mai','Juin','Juil','Ao&ucirc;t','Sept','Oct','Nov','D&eacute;c')
	);
	
	if(isset($_REQUEST['statistiques_jour']) && isset($_REQUEST['statistiques_mois']) && isset($_REQUEST['statistiques_annee']))
	{
		$date=mktime(0,0,0,$_REQUEST['statistiques_mois'],$_REQUEST['statistiques_jour'],$_REQUEST['statistiques_annee']);
		$_REQUEST['statistiques_jour']=date('d',$date);
		$_REQUEST['statistiques_mois']=date('m',$date);
		$_REQUEST['statistiques_annee']=date('Y',$date);
	}
	
	if(isset($_REQUEST['submit']))
	{
		switch($_REQUEST['submit'])
		{
			case 'Calculer':
				if(isset($_REQUEST['statistiques_compteur']) && sizeof($_REQUEST['statistiques_compteur']))
				{
					$statistique=array();
					$date=mktime(0,0,0,$_REQUEST['statistiques_mois'],$_REQUEST['statistiques_jour'],$_REQUEST['statistiques_annee']);
					for($i=0;$i<sizeof($_REQUEST['statistiques_compteur']);$i++)
					{
						eval('$statistiques['.$i.']=new '.$correspondance_compteur[$_REQUEST['statistiques_compteur'][$i]]['classe'].'();');
						if(isset($correspondance_compteur[$_REQUEST['statistiques_compteur'][$i]]['parametre']))
						{
							$parametre=array();
							$parametre[]=$date;
							$parametre[]=$_REQUEST['statistiques_periodicite'];
							if(!is_array($correspondance_compteur[$_REQUEST['statistiques_compteur'][$i]]['parametre']))
								$parametre[]=$correspondance_compteur[$_REQUEST['statistiques_compteur'][$i]]['parametre'];
							else
								$parametre=array_merge($parametre,$correspondance_compteur[$_REQUEST['statistiques_compteur'][$i]]['parametre']);
							$parametre[]=(isset($_REQUEST['statistiques_domaine'])?$_REQUEST['statistiques_domaine']:array());
							$parametre[]=(bool)$_REQUEST['statistiques_ca'];
							
							call_user_func_array(array(&$statistiques[$i],'compter'),$parametre);
						}
						else
							$statistiques[$i]->compter($date,$_REQUEST['statistiques_periodicite'],(isset($_REQUEST['statistiques_domaine'])?$_REQUEST['statistiques_domaine']:array()),(bool)$_REQUEST['statistiques_ca']);
					}
				}
				break;
		}
	}
	else
	{
		$_REQUEST['statistiques_domaine']=array();
		$_REQUEST['statistiques_domaine'][]='www.localerte.fr';
		$_REQUEST['statistiques_domaine'][]='www.localerte.mobi';
		$_REQUEST['statistiques_ca']='1';
	}
	
	if(!isset($_REQUEST['statistiques_jour']))
		$_REQUEST['statistiques_jour']=date('d');
	if(!isset($_REQUEST['statistiques_mois']))
		$_REQUEST['statistiques_mois']=date('m');
	if(!isset($_REQUEST['statistiques_annee']))
		$_REQUEST['statistiques_annee']=date('Y');
	if(!isset($_REQUEST['statistiques_periodicite']))
		$_REQUEST['statistiques_periodicite']='H';
	if(!isset($_REQUEST['statistiques_compteur']))
		$_REQUEST['statistiques_compteur']=array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script>
	function decocheTout()
	{
		var objet=document.getElementsByName('statistiques_compteur[]');
		for(var i=0;i<objet.length;i++) objet.item(i).checked=false;
	}
	
	function cocheId(id)
	{
		decocheTout();
		for(var i=0;i<id.length;i++) document.getElementById(id[i]).checked=true;
	}
</script>
</head>
<body onload="DonnerFocus('statistiques_jour');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <th>Statistiques</th>
  </tr>
  <tr>
    <td><form action="statistiques_simples.php" method="post" name="formulaire" id="formulaire">
        <table cellspacing="0" cellpadding="4" class="petit" align="center">
          <tr>
            <td>Date : </td>
            <td><select name="statistiques_jour" id="statistiques_jour">
                <?php
	for($i=1;$i<32;$i++)
		print('<option value="'.$i.'"'.(($_REQUEST['statistiques_jour']==$i)?(' selected="selected"'):('')).'>'.(($i<10)?('0'):('')).$i.'</option>');
?>
              </select>
              <select name="statistiques_mois" id="statistiques_mois">
                <?php
	for($i=1;$i<13;$i++)
		print('<option value="'.$i.'"'.(($_REQUEST['statistiques_mois']==$i)?(' selected="selected"'):('')).'>'.ucfirst(strftime('%B',mktime(0,0,0,$i,1,0))).'</option>');
?>
              </select>
              <select name="statistiques_annee" id="statistiques_annee">
                <?php
	for($i=date('Y');$i>2005;$i--)
		print('<option value="'.$i.'"'.(($_REQUEST['statistiques_annee']==$i)?(' selected="selected"'):('')).'>'.(($i<10)?('0'):('')).$i.'</option>');
?>
              </select></td>
          </tr>
          <tr>
            <td>P&eacute;riodicit&eacute; : </td>
            <td><select name="statistiques_periodicite" id="statistiques_periodicite">
                <option value="H"<?php if($_REQUEST['statistiques_periodicite']=='H') print(' selected="selected"');?>>Horaire</option>
                <option value="S"<?php if($_REQUEST['statistiques_periodicite']=='S') print(' selected="selected"');?>>Semaine</option>
                <option value="M"<?php if($_REQUEST['statistiques_periodicite']=='M') print(' selected="selected"');?>>Mois</option>
                <option value="A"<?php if($_REQUEST['statistiques_periodicite']=='A') print(' selected="selected"');?>>Ann&eacute;e</option>
              </select></td>
          </tr>
          <tr>
            <td nowrap="nowrap">Consommation :</td>
            <td><?php
				foreach($correspondance_compteur as $clef=>$valeur)
					if(strpos($clef,'ALLOPASS')===0 || $clef=='WHA' || strpos($clef,'CODE')===0)
	            		print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).'> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'"> '.ma_htmlentities($valeur['designation']).'</label></nobr> ');
			?></td>
          </tr>
          <tr>
            <td>Abonnements :</td>
            <td><?php
				foreach($correspondance_compteur as $clef=>$valeur)
					if(strpos($clef,'ABONNEMENT')===0)
	            		print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).'> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'"> '.ma_htmlentities($valeur['designation']).'</label></nobr> ');
			?></td>
          <tr>
            <td>Facture :</td>
            <td><?php
				foreach($correspondance_compteur as $clef=>$valeur)
					if(strpos($clef,'FACTURE')===0)
	            		print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).'> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'"> '.ma_htmlentities($valeur['designation']).'</label></nobr> ');
			?></td>
          </tr>
          <tr>
            <td>Adh&eacute;rents :</td>
            <td><?php
				foreach($correspondance_compteur as $clef=>$valeur)
					if(strpos($clef,'ADHERENT')===0)
	            		print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).'> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'"> '.ma_htmlentities($valeur['designation']).'</label></nobr> ');
			?></td>
          </tr>
          <!--tr>
            <td style="vertical-align:top;">Annonces :</td>
            <td><table cellspacing="0" cellpadding="0">
                <tr>
                  <td style="border:none; vertical-align:top;"><?php
				$provenance=array();
				foreach($correspondance_compteur as $clef=>$valeur)
					if(strpos($clef,'PROVENANCE')===0)
						$provenance[$clef]=$valeur;
				
				$i=0;
				while($i<sizeof($provenance)/4)
				{
					$each=each($provenance);
					$clef=$each[0];
					$valeur=$each[1];
					print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).'> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'"> '.ma_htmlentities($valeur['designation']).'</label></nobr><br>');
					$i++;
				}
			?>                  </td>
                  <td style="border:none; vertical-align:top;"><?php
				while($i<sizeof($provenance)/4*2)
				{
					$each=each($provenance);
					$clef=$each[0];
					$valeur=$each[1];
					print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).'> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'"> '.ma_htmlentities($valeur['designation']).'</label></nobr><br>');
					$i++;
				}
			?>                  </td>
                  <td style="border:none; vertical-align:top;"><?php
				while($i<sizeof($provenance)/4*3)
				{
					$each=each($provenance);
					$clef=$each[0];
					$valeur=$each[1];
					print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).'> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'"> '.ma_htmlentities($valeur['designation']).'</label></nobr><br>');
					$i++;
				}
			?>                  </td>
                  <td style="border:none; vertical-align:top;"><?php
				while($i<sizeof($provenance))
				{
					$each=each($provenance);
					$clef=$each[0];
					$valeur=$each[1];
	            	print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).'> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'"> '.ma_htmlentities($valeur['designation']).'</label></nobr><br>');
					$i++;
				}
			?>                  </td>
                </tr>
              </table></td>
          </tr-->
          <tr>
            <td>&nbsp;</td>
            <td><a href="#" onclick="cocheId(new Array('statistiques_compteur_WHA','statistiques_compteur_ALLOPASS_PAYANT_V2_0_88','statistiques_compteur_ALLOPASS_PAYANT_V2_1_05','statistiques_compteur_ALLOPASS_PAYANT_V2_1_20','statistiques_compteur_FACTURE_ABONNEMENT_V2','statistiques_compteur_FACTURE_FORFAIT'));">Choix V2</a> <a href="#" onclick="cocheId(new Array('statistiques_compteur_WHA','statistiques_compteur_ALLOPASS_PAYANT_V2.5_0_88','statistiques_compteur_ALLOPASS_PAYANT_V2.5_1_05','statistiques_compteur_ALLOPASS_PAYANT_V2.5_1_20','statistiques_compteur_ALLOPASS_PAYANT_V2.5_1_67','statistiques_compteur_FACTURE_ABONNEMENT_AB','statistiques_compteur_FACTURE_ABONNEMENT_VF','statistiques_compteur_FACTURE_ABONNEMENT_OR'));">Choix V2.5</a> <a href="#" onclick="cocheId(new Array('statistiques_compteur_WHA','statistiques_compteur_ALLOPASS_PAYANT_V2_0_88','statistiques_compteur_ALLOPASS_PAYANT_V2_1_05','statistiques_compteur_ALLOPASS_PAYANT_V2_1_20','statistiques_compteur_ALLOPASS_PAYANT_V2.5_0_88','statistiques_compteur_ALLOPASS_PAYANT_V2.5_1_05','statistiques_compteur_ALLOPASS_PAYANT_V2.5_1_20','statistiques_compteur_ALLOPASS_PAYANT_V2.5_1_67','statistiques_compteur_FACTURE_ABONNEMENT_V2','statistiques_compteur_FACTURE_ABONNEMENT_AB','statistiques_compteur_FACTURE_ABONNEMENT_VF','statistiques_compteur_FACTURE_ABONNEMENT_OR','statistiques_compteur_FACTURE_FORFAIT'));">Choix V2+V2.5</a> <a href="#" onclick="decocheTout();">Aucun</a></td>
          </tr>
          <tr>
            <td>Domaines :</td>
            <td>
	        	<nobr><input type="checkbox" name="statistiques_domaine[]" value="www.localerte.fr" id="statistiques_domaine_localerte_fr"<?php print((array_search('www.localerte.fr',$_REQUEST['statistiques_domaine'])!==false)?(' checked="checked"'):(''))?>> <label for="statistiques_domaine_localerte_fr">www.Localerte.FR</label></nobr>
	        	<nobr><input type="checkbox" name="statistiques_domaine[]" value="www.localerte.mobi" id="statistiques_domaine_localerte_mobi"<?php print((array_search('www.localerte.mobi',$_REQUEST['statistiques_domaine'])!==false)?(' checked="checked"'):(''))?>> <label for="statistiques_domaine_localerte_mobi">www.Localerte.MOBI</label></nobr>
			</td>
          </tr>
          <tr>
            <td>Chiffre d'affaire:</td>
            <td><nobr>
              <input type="radio" name="statistiques_ca" value="1" id="statistiques_ca_1"<?php print(($_REQUEST['statistiques_ca']=='1')?(' checked="checked"'):(''))?>>
              <label for="statistiques_ca_1">Oui</label>
              </nobr> <nobr>
                <input type="radio" name="statistiques_ca" value="0" id="statistiques_ca_0"<?php print(($_REQUEST['statistiques_ca']=='0')?(' checked="checked"'):(''))?>>
                <label for="statistiques_ca_0">Non</label>
              </nobr></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="Calculer"></td>
          </tr>
        </table>
    </form></td>
  </tr>
  <tr>
    <td align="center"><?php
	if(isset($statistiques) && sizeof($statistiques))
	{
		$minimum=0;
		$maximum=0;
		$moyenne=0;
		$total=0;
		
		for($i=0;$i<sizeof($statistiques[0]->occurrence);$i++)
		{
			$somme=0;
			
			for($j=0;$j<sizeof($statistiques);$j++)
				$somme+=$statistiques[$j]->occurrence[$i]['nombre'];
			
			if(!$i || $minimum>$somme)
				$minimum=$somme;
			
			if($maximum<$somme)
				$maximum=$somme;
			
			$total+=$somme;
		}
		
		$moyenne=$total/sizeof($statistiques[0]->occurrence);
		
		print('<table cellspacing="0" cellpadding="4" class="petit">');
		$ligne1='';
		$ligne2='';
		$ligne3='';
		
		$date=$statistiques[0]->debut;
		
		for($i=0;$i<sizeof($statistiques[0]->occurrence);$i++,$date+=$interval)
		{
			if(!isset($internval) || $_REQUEST['statistiques_periodicite']=='A')
				switch($_REQUEST['statistiques_periodicite'])
				{
					case 'H':
						$interval=60*60;
						break;
					case 'M':
					case 'S':
						$interval=60*60*24;
						break;
					case 'A':
						$interval=date('t',$date)*60*60*24;
						break;
				}
			
			if($_REQUEST['statistiques_periodicite']!='A')
				$week_end=(date('w',$date)==6 || date('w',$date)==0);
			else
				$week_end=0;
			
			$ligne1.='<td align="center" valign="bottom" style="background-color:'.(($week_end)?('#CCCCCC'):('#EEEEEE')).'">';
			$query=array();
			$query[]='forme=multirectangle';
			$query[]='x='.STATISTIQUE_X;
			$query[]='y='.STATISTIQUE_Y;
			$query[]='c='.urlencode((($week_end)?('#CCCCCC'):('#EEEEEE')));
			$map=array();
			$somme=0;
			$y2=STATISTIQUE_Y;
			$y1=STATISTIQUE_Y;
			for($j=0;$j<sizeof($statistiques);$j++)
			{
				if($statistiques[$j]->occurrence[$i]['nombre']>0)
				{
					$somme+=$statistiques[$j]->occurrence[$i]['nombre'];
					$y2=$y1-(floor(STATISTIQUE_Y*$statistiques[$j]->occurrence[$i]['nombre']/$maximum));
					$query[]=urlencode('r['.$j.'][c]').'='.urlencode($correspondance_compteur[$_REQUEST['statistiques_compteur'][$j]]['couleur']);
					$query[]=urlencode('r['.$j.'][x1]').'=0';
					$query[]=urlencode('r['.$j.'][y1]').'='.$y2;
					$query[]=urlencode('r['.$j.'][x2]').'='.STATISTIQUE_X;
					$query[]=urlencode('r['.$j.'][y2]').'='.$y1;
					$map[]='<area sharpe="rect" nohref="" coords="0,'.$y1.','.STATISTIQUE_X.','.$y2.'" alt="'.$statistiques[$j]->occurrence[$i]['nombre'].'" title="'.$statistiques[$j]->occurrence[$i]['nombre'].'">';
					$y1=$y2;
				}
			}
			if(sizeof($query)>4)
			{
				$ligne1.=
				'
					<img src="'.URL_INCLUSION.'gd.php?'.implode('&',$query).'" border="0" usemap="#'.$i.'">
					<map name="'.$i.'">
					'.implode('',$map).'
					</map>
				';
				
			}
			else
				$ligne1.='&nbsp;';
			$ligne1.='</td>';
			$ligne2.='<td align="center" height="30">'.$correspondance_periode[$_REQUEST['statistiques_periodicite']][$statistiques[0]->occurrence[$i]['periode']].'</td>';
			$ligne3.='<td align="center" height="20" style="font-size: x-small;">'.$somme.'</td>';
		}
		print
		('
			<tr>
			'.$ligne1.'
			<td rowspan="3" valign="top">
			<table cellspacing="0" cellpadding="4">
			<tr>
			<td nowrap="nowrap">Minimum : </td>
			<td>'.$minimum.'</td>
			</tr>
			<tr>
			<td nowrap="nowrap">Maximum : </td>
			<td>'.$maximum.'</td>
			</tr>
			<tr>
			<td nowrap="nowrap">Moyenne : </td>
			<td>'.$moyenne.'</td>
			</tr>
			<tr>
			<td nowrap="nowrap">Total : </td>
			<td>'.$total.'</td>
			</tr>
			</table>
			</td>
			</tr>
		');
		print('<tr>'.$ligne3.'</tr>');
		print('<tr>'.$ligne2.'</tr>');
		print('</table>');
	}
?></td>
  </tr>
</table>
</body>
</html>
