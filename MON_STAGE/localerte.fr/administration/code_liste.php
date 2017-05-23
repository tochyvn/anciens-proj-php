<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'code.php');
	
	$code_liste_erreur=0;
	$code_liste_succes=0;
	
	if(isset($_REQUEST['code_liste_submit']))
	{
		switch($_REQUEST['code_liste_submit'])
		{
			case 'Donner':
				if(isset($_REQUEST['code_reference']))
				{
					$code=new ld_code();
					for($i=0;$i<sizeof($_REQUEST['code_reference']);$i++)
						$code->donner($_REQUEST['code_reference'][$i]);
					$message='Code(s) promo donn&eacute;(s)';
				}
				else
					$code_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
		}
	}
	
	$liste=new ld_liste
	('
		select reference
		from code
		where appartenance is null
			and
			(
				date_debut is null
				or date_debut<=\''.addslashes(date(SQL_DATETIME,MAINTENANT)).'\'
			)
			and
			(
				date_fin is null
				or date_fin>=\''.addslashes(date(SQL_DATETIME,MAINTENANT)).'\'
			)
		order by rand()
		limit 10
	');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script language="javascript" src="<?php print(URL_INCLUSION);?>liste.js" type="text/javascript"></script>
</head>
<body>
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php');?></td>
    <td valign="top"><table cellspacing="0" cellpadding="4">
        <tr>
          <th>Liste des codes promo &agrave; donner </th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['code_liste_submit']))
	{
		if($code_liste_erreur & LISTE_ERREUR_AUCUN) print('Aucun &eacute;l&eacute;ment s&eacute;lectionn&eacute;<br />');
		if($code_liste_erreur & LISTE_ERREUR_TROP) print('Trop d\'&eacute;l&eacute;ments s&eacute;lectionn&eacute;s<br />');
		if($code_liste_erreur & LISTE_ERREUR_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous supprim&eacute;s<br />');
		if($code_liste_succes & LISTE_SUCCES_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; supprim&eacute;s<br />');
		if($code_liste_erreur & LISTE_ERREUR_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous modifi&eacute;s<br />');
		if($code_liste_succes & LISTE_SUCCES_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; modifi&eacute;s<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="code_liste.php" method="post" name="formulaire" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td nowrap="nowrap"><div align="right">
                      <input name="code_liste_submit" type="submit" id="code_liste_submit" value="Donner" />
                    </div></td>
                </tr>
                <tr>
                  <td><?php
	if($liste->total)
	{
?>
                    <table cellspacing="0" cellpadding="4">
                      <?php
		for($i=0;$i<sizeof($liste->occurrence);$i++)
		{
			if($i%10==0)
			{
?>
                      <tr>
                        <td class="entete">Reference<br /></td>
                        <td width="10" align="center"><script>document.write('<input type="checkbox" id="cocher_code_reference" onclick="liste_cocher(this,\'code_reference[]\');" />');</script></td>
                      </tr>
                      <?php
			}
			$couleur_survol=LISTE_SURVOL;
			$couleur_click=LISTE_CLICK;
			if($i%2)
				$couleur_courant=LISTE_IMPAIR;
			else
				$couleur_courant=LISTE_PAIR;
?>
                      <tr
				    style="background-color: <?php print($couleur_courant);?>;"
					onmouseover="liste_onMouseOver(this,'<?php print($couleur_survol);?>');"
					onmouseout="liste_onMouseOut(this,'<?php print($couleur_courant);?>');"
				    onclick="liste_onClick('code_reference_<?php print(ma_htmlentities($liste->occurrence[$i]['reference']));?>');"
				    ondblclick="liste_onDblClick('code_reference_<?php print(ma_htmlentities($liste->occurrence[$i]['reference']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['reference']));?></td>
                        <td width="10" align="center"><input type="checkbox" name="code_reference[]" id="code_reference_<?php print(ma_htmlentities($liste->occurrence[$i]['reference']))?>" value="<?php print(ma_htmlentities($liste->occurrence[$i]['reference']))?>" onclick="liste_onUnClick(this,2);" /></td>
                      </tr>
                      <?php
		}
?>
                    </table>
                    <?php
	}
	else
		print('&nbsp;');
?>
                  </td>
                </tr>
                <tr>
                  <td nowrap="nowrap"><div align="right">
                      <input name="code_liste_submit" type="submit" id="code_liste_submit" value="Donner" />
                    </div></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
