<?php
	define('DATE_DEPART',7);
	
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'dossier.php');
	
	function fichier_suppimer($chemin,$date)
	{
		$fichier=scandir($chemin);
		for($i=0;$i<sizeof($fichier);$i++)
		{
			if($fichier[$i]!='.' && $fichier[$i]!='..')
			{
				if(is_dir($chemin.$fichier[$i]))
					rmdir_recursive_avec_date($chemin.$fichier[$i],$date);
				else
					{
						$stat=stat($chemin.$fichier[$i]);
						if($stat[8]<=$date)
							unlink($chemin.$fichier[$i]);
					}
			}
		}
	}
	function rmdir_recursive_avec_date($directory,$date)
	{
		if(is_dir($directory))
		{
			$directory=realpath($directory);
			
			if($directory===false)
			{
				trigger_error('Oups!!!.', E_USER_WARNING);
				return false;
			}
			
			$directory.=DIRECTORY_SEPARATOR;

			foreach(scandir($directory) as $folderItem)
			{
				if($folderItem!='.' && $folderItem!='..')
				{
					if(is_dir($directory.$folderItem.DIRECTORY_SEPARATOR))
						rmdir_recursive_avec_date($directory.$folderItem.DIRECTORY_SEPARATOR,$date);
					else
					{
						$stat=stat($directory.$folderItem);
						if($stat[8]<=$date)
							unlink($directory.$folderItem);
					}
				}
			}
			
			@rmdir($directory);
		}
		else
		{
			trigger_error('Le r&eacute;pertoire '.$directory.' n\'existe pas.', E_USER_WARNING);
			return false;
		}
	}
	
	if(isset($_REQUEST['submit']))
	{
		switch($_REQUEST['submit'])
		{
			case 'Nettoyer':
				if(isset($_REQUEST['maintenance_repertoire']))
				{
					if(is_array($_REQUEST['maintenance_date']))
						$date=mktime($_REQUEST['maintenance_date'][3],$_REQUEST['maintenance_date'][4],$_REQUEST['maintenance_date'][5],$_REQUEST['maintenance_date'][1],$_REQUEST['maintenance_date'][0],$_REQUEST['maintenance_date'][2]);
					elseif(preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/',$_REQUEST['maintenance_date'],$resultat))
						$date=mktime($resultat[4],$resultat[5],$resultat[6],$resultat[2],$resultat[1],$resultat[3]);
					
					if(isset($date))
					{
						if(array_search('ADHERENT',$_REQUEST['maintenance_repertoire'])!==false)
							fichier_suppimer(PWD_ADHERENT.'prive/temp/',$date);
						if(array_search('ADMINISTRATION',$_REQUEST['maintenance_repertoire'])!==false)
							fichier_suppimer(PWD_ADMINISTRATION.'prive/temp/',$date);
						if(array_search('INCLUSION',$_REQUEST['maintenance_repertoire'])!==false)
							fichier_suppimer(PWD_INCLUSION.'prive/temp/',$date);
						if(array_search('PUBLIC',$_REQUEST['maintenance_repertoire'])!==false)
							fichier_suppimer(PWD_PUBLIC.'prive/temp/',$date);
						if(array_search('REF',$_REQUEST['maintenance_repertoire'])!==false)
							fichier_suppimer(PWD_REF.'prive/temp/',$date);
					}
				}
				break;
		}
	}
	
	$date=mktime(date('H',MAINTENANT),date('i',MAINTENANT),date('s',MAINTENANT),date('m',MAINTENANT),date('d',MAINTENANT)-DATE_DEPART,date('Y',MAINTENANT));
	
	$_REQUEST['maintenance_date']=array();
	$_REQUEST['maintenance_date'][0]=date('d',$date);
	$_REQUEST['maintenance_date'][1]=date('m',$date);
	$_REQUEST['maintenance_date'][2]=date('Y',$date);
	$_REQUEST['maintenance_date'][3]=date('H',$date);
	$_REQUEST['maintenance_date'][4]=date('i',$date);
	$_REQUEST['maintenance_date'][5]=date('s',$date);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script src="general.js" language="javascript" type="text/javascript"></script>
</head>
<body onload="DonnerFocus('maintenance_repertoire[]');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Maintenance des r&eacute;pertoires /temp</th>
        </tr>
        <tr>
          <td class="important">&nbsp;</td>
        </tr>
        <tr>
          <td><form action="maintenance.php" method="post" enctype="multipart/form-data" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Date maximum: </td>
                  <td><noscript>
                    <select name="maintenance_date[]" id="maintenance_date_jour">
                      <option value="">--</option>
                      <?php
	for($i=1;$i<=31;$i++)
		print('<option value="'.ma_htmlentities($i).'"'.(($i==$_REQUEST['maintenance_date'][0])?(' selected="selected"'):('')).'>'.ma_htmlentities((($i<10)?('0'):('')).$i).'</option>');
?>
                    </select>
                    /
                    <select name="maintenance_date[]" id="maintenance_date_mois">
                      <option value="">--</option>
                      <?php
	for($i=1;$i<=12;$i++)
		print('<option value="'.ma_htmlentities($i).'"'.(($i==$_REQUEST['maintenance_date'][1])?(' selected="selected"'):('')).'>'.ma_htmlentities(ucwords(strftime('%B',mktime(0,0,0,$i,1,2000)))).'</option>');
?>
                    </select>
                    <select name="maintenance_date[]" id="maintenance_date_annee">
                      <option value="">--</option>
                      <?php
	for($i=date('Y')+1;$i>=2007;$i--)
		print('<option value="'.ma_htmlentities($i).'"'.(($i==$_REQUEST['maintenance_date'][2])?(' selected="selected"'):('')).'>'.ma_htmlentities($i).'</option>');
?>
                    </select>
                    <select name="maintenance_date[]" id="maintenance_date[]">
                      <?php
	for($i=0;$i<24;$i++)
		print('<option value="'.$i.'"'.(($i==date('H',$date))?(' selected="selected"'):('')).'>'.(($i<10)?('0'):('')).$i.'</option>');
?>
                    </select>
                    :
                    <select name="maintenance_date[]" id="maintenance_date[]">
                      <?php
	for($i=0;$i<60;$i++)
		print('<option value="'.$i.'"'.(($i==date('i',$date))?(' selected="selected"'):('')).'>'.(($i<10)?('0'):('')).$i.'</option>');
?>
                    </select>
                    :
                    <select name="maintenance_date[]" id="maintenance_date[]">
                      <?php
	for($i=0;$i<60;$i++)
		print('<option value="'.$i.'"'.(($i==date('s',$date))?(' selected="selected"'):('')).'>'.(($i<10)?('0'):('')).$i.'</option>');
?>
                    </select>
                    </noscript>
                    <script type="text/javascript">CreerCalendrier('maintenance_date',1,'<?php print($_REQUEST['maintenance_date'][0].'/'.$_REQUEST['maintenance_date'][1].'/'.$_REQUEST['maintenance_date'][2].' '.$_REQUEST['maintenance_date'][3].':'.$_REQUEST['maintenance_date'][4].':'.$_REQUEST['maintenance_date'][5]);?>');</script></td>
                </tr>
                <tr>
                  <td>R&eacute;pertoire &agrave; nettoyer :</td>
                  <td><input type="checkbox" name="maintenance_repertoire[]" value="ADHERENT" id="maintenance_repertoire_adherent" />
                    <label for="maintenance_repertoire_adherent">/adherent/prive/temp</label>
                    <br />
                    <input type="checkbox" name="maintenance_repertoire[]" value="ADMINISTRATION" id="maintenance_repertoire_administration" />
                    <label for="maintenance_repertoire_administration">/administration/prive/temp</label>
                    <br />
                    <input type="checkbox" name="maintenance_repertoire[]" value="INCLUSION" id="maintenance_repertoire_inclusion" />
                    <label for="maintenance_repertoire_inclusion">/inclusion/prive/temp</label>
                    <br />
                    <input type="checkbox" name="maintenance_repertoire[]" value="PUBLIC" id="maintenance_repertoire_public" />
                    <label for="maintenance_repertoire_public">/public/prive/temp</label>
                    <br />
                    <input type="checkbox" name="maintenance_repertoire[]" value="REF" id="maintenance_repertoire_ref" />
                    <label for="maintenance_repertoire_ref">/ref/prive/temp</label></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="submit" id="submit" value="Nettoyer" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
