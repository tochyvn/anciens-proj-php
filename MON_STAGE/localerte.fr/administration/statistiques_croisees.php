<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'wha.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'abonnement.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'annonce.php');
	
	define('STATISTIQUE_X',15);
	define('STATISTIQUE_Y',200);
	
	$correspondance_compteur=array
	(
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
						
						$parametre=array();
						$parametre[]=$date;
						$parametre[]=$_REQUEST['statistiques_periodicite'];
						if(!is_array($correspondance_compteur[$_REQUEST['statistiques_compteur'][$i]]['parametre']))
							$parametre[][]=$correspondance_compteur[$_REQUEST['statistiques_compteur'][$i]]['parametre'];
						else
						{
							$parametre[]=$correspondance_compteur[$_REQUEST['statistiques_compteur'][$i]]['parametre'][0];
							$parametre[][]=$correspondance_compteur[$_REQUEST['statistiques_compteur'][$i]]['parametre'][1];
						}
						$parametre[sizeof($parametre)-1][]=$_REQUEST['statistiques_mode'];
						
						call_user_func_array(array(&$statistiques[$i],'croiser'),$parametre);
					}
				}
				break;
		}
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
	if(!isset($_REQUEST['statistiques_mode']))
		$_REQUEST['statistiques_mode']='SANS_LOYER';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('statistiques_jour');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <th>Statistiques</th>
  </tr>
  <tr>
    <td><form action="statistiques_croisees.php" method="post" name="formulaire" id="formulaire">
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
            <td nowrap="nowrap">P&eacute;riodicit&eacute; : </td>
            <td><select name="statistiques_periodicite" id="statistiques_periodicite">
                <option value="H"<?php if($_REQUEST['statistiques_periodicite']=='H') print(' selected="selected"');?>>Horaire</option>
                <option value="S"<?php if($_REQUEST['statistiques_periodicite']=='S') print(' selected="selected"');?>>Semaine</option>
                <option value="M"<?php if($_REQUEST['statistiques_periodicite']=='M') print(' selected="selected"');?>>Mois</option>
                <option value="A"<?php if($_REQUEST['statistiques_periodicite']=='A') print(' selected="selected"');?>>Ann&eacute;e</option>
              </select></td>
          </tr>
          <tr>
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
					print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).' /> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'" /> '.ma_htmlentities($valeur['designation']).'</label></nobr><br/>');
					$i++;
				}
			?>                  </td>
                  <td style="border:none; vertical-align:top;"><?php
				while($i<sizeof($provenance)/4*2)
				{
					$each=each($provenance);
					$clef=$each[0];
					$valeur=$each[1];
					print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).' /> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'" /> '.ma_htmlentities($valeur['designation']).'</label></nobr><br/>');
					$i++;
				}
			?>                  </td>
                  <td style="border:none; vertical-align:top;"><?php
				while($i<sizeof($provenance)/4*3)
				{
					$each=each($provenance);
					$clef=$each[0];
					$valeur=$each[1];
					print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).' /> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'" /> '.ma_htmlentities($valeur['designation']).'</label></nobr><br/>');
					$i++;
				}
			?>                  </td>
                  <td style="border:none; vertical-align:top;"><?php
				while($i<sizeof($provenance))
				{
					$each=each($provenance);
					$clef=$each[0];
					$valeur=$each[1];
	            	print('<nobr><input type="checkbox" name="statistiques_compteur[]" value="'.ma_htmlentities($clef).'" id="statistiques_compteur_'.ma_htmlentities($clef).'"'.((array_search($clef,$_REQUEST['statistiques_compteur'])!==false)?(' checked="checked"'):('')).' /> <label for="statistiques_compteur_'.ma_htmlentities($clef).'"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=10&c='.urlencode($valeur['couleur']).'" alt="'.ma_htmlentities($valeur['couleur']).'" title="'.ma_htmlentities($valeur['couleur']).'" /> '.ma_htmlentities($valeur['designation']).'</label></nobr><br/>');
					$i++;
				}
			?>                  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="statistiques_mode" value="SANS_LOYER" id="statistiques_mode_sans_loyer"<?php if($_REQUEST['statistiques_mode']=='SANS_LOYER') print(' checked="checked"');?> />
            <label for="statistiques_mode_sans_loyer">Proportion des annonces sans loyer</label><br />
            <input type="radio" name="statistiques_mode" value="SANS_STATUT" id="statistiques_mode_sans_statut"<?php if($_REQUEST['statistiques_mode']=='SANS_STATUT') print(' checked="checked"');?> />
            <label for="statistiques_mode_sans_statut">Proportion des annonces sans statut</label><br />
            <input type="radio" name="statistiques_mode" value="SANS_TELEPHONE_ET_EMAIL" id="statistiques_mode_sans_telephone_et_email"<?php if($_REQUEST['statistiques_mode']=='SANS_TELEPHONE_ET_EMAIL') print(' checked="checked"');?> />
            <label for="statistiques_mode_sans_telephone_et_email">Proportion des annonces sans t&eacute;l&eacute;phone et sans email</label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="Calculer" /></td>
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
					$map[]='<area sharpe="rect" nohref="" coords="0,'.$y1.','.STATISTIQUE_X.','.$y2.'" alt="'.$statistiques[$j]->occurrence[$i]['nombre'].'%" title="'.$statistiques[$j]->occurrence[$i]['nombre'].'%">';
					$y1=$y2;
				}
			}
			if(sizeof($query)>4)
			{
				$ligne1.=
				'
					<img src="'.URL_INCLUSION.'gd.php?'.implode('&',$query).'" border="0" usemap="#'.$i.'" />
					<map name="'.$i.'">
					'.implode('',$map).'
					</map>
				';
				
			}
			else
				$ligne1.='&nbsp;';
			$ligne1.='</td>';
			$ligne2.='<td align="center" height="30">'.$correspondance_periode[$_REQUEST['statistiques_periodicite']][$statistiques[0]->occurrence[$i]['periode']].'</td>';
			$ligne3.='<td align="center" height="20" style="font-size: x-small;">'.$somme.'%</td>';
		}
		print
		('
			<tr>
			'.$ligne1.'
			<td rowspan="3" valign="top">
			<table cellspacing="0" cellpadding="4">
			<tr>
			<td nowrap="nowrap">Minimum : </td>
			<td>'.$minimum.'%</td>
			</tr>
			<tr>
			<td nowrap="nowrap">Maximum : </td>
			<td>'.$maximum.'%</td>
			</tr>
			<tr>
			<td nowrap="nowrap">Moyenne : </td>
			<td>'.$moyenne.'%</td>
			</tr>
			<tr>
			<td nowrap="nowrap">Total : </td>
			<td>'.$total.'%</td>
			</tr>
			</table>
			</td>
			</tr>
		');
		print('<tr>'.$ligne3.'</tr>');
		print('<tr>'.$ligne2.'</tr>');
		print('</table>');
	}
?>
    </td>
  </tr>
</table>
</body>
</html>
