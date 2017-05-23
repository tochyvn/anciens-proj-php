<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'enquete.php');
	require_once(PWD_INCLUSION.'date.php');
	
	if(!isset($_SESSION['enquete_page']))
		$_SESSION['enquete_page']=1;
	if(!isset($_SESSION['enquete_tri']))
		$_SESSION['enquete_tri']='enregistrement';
	if(!isset($_SESSION['enquete_ordre']))
		$_SESSION['enquete_ordre']='desc';
	if(!isset($_SESSION['enquete_recherche']))
		$_SESSION['enquete_recherche']='';
	
	if(isset($_REQUEST['enquete_page']))
		$_SESSION['enquete_page']=$_REQUEST['enquete_page'];
	if(isset($_REQUEST['enquete_tri']))
	{
		$_SESSION['enquete_tri']=$_REQUEST['enquete_tri'];
		if(!isset($_REQUEST['enquete_ordre']) || $_REQUEST['enquete_ordre']!='desc')
			$_REQUEST['enquete_ordre']='asc';
	}
	if(isset($_REQUEST['enquete_ordre']))
		$_SESSION['enquete_ordre']=$_REQUEST['enquete_ordre'];
	if(isset($_REQUEST['enquete_adherent']))
		$_SESSION['enquete_adherent']=$_REQUEST['enquete_adherent'];
	
	$enquete_liste_erreur=0;
	$enquete_liste_succes=0;
	
	if(isset($_REQUEST['enquete_liste_submit']))
	{
		switch($_REQUEST['enquete_liste_submit'])
		{
			default:
				break;
		}
	}
	
	$liste=new ld_liste
	('
		select
			adherent_email,
			unix_timestamp(enregistrement) as enregistrement,
			question1,
			question2,
			question3,
			question4,
			question5,
			libre
		from enquete
		where 1
		order by `'.$_SESSION['enquete_tri'].'` '.$_SESSION['enquete_ordre'].'
		limit '.(($_SESSION['enquete_page']-1)*LISTE_INTERVAL).','.LISTE_INTERVAL.'
	',LISTE_PAGE);
	/*$moyenne=new ld_liste
	('
		select
			AVG(question1),
			AVG(question2),
			AVG(question3),
			AVG(question5)
		from enquete
	',0);
	
	print_r($moyenne);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script src="<?php print(URL_INCLUSION);?>liste.js" language="javascript" type="text/javascript"></script>
</head>
<body>
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table cellspacing="0" cellpadding="4">
        <tr>
          <td><form action="enquete_liste.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'enquete_liste.php','enquete_page');?></td>
                  <td align="right"></td>
                </tr>
                <tr>
                  <td colspan="2"><?php
	if($liste->total)
	{
?>
                    <table cellspacing="0" cellpadding="4">
                      <?php
		for($i=0;$i<sizeof($liste->occurrence);$i++)
		{
			if($i==0)
			{
?>
                      <tr>
                        <td class="entete">Adresse email<br />
                          <a href="enquete_liste.php?enquete_tri=adherent_email">&Lambda;</a> <a href="enquete_liste.php?enquete_tri=adherent_email&enquete_ordre=desc">V</a></td>
                        <td class="entete">Enregistrement<br />
                          <a href="enquete_liste.php?enquete_tri=enregistrement">&Lambda;</a> <a href="enquete_liste.php?enquete_tri=enregistrement&enquete_ordre=desc">V</a></td>
                        <td class="entete">Q1<br /></td>
                        <td class="entete">Q2<br /></td>
                        <td class="entete">Q3<br /></td>
                        <td class="entete">Q4<br /></td>
                        <td class="entete">Q5<br /></td>
                        <td class="entete">Libre<br /></td>
                        <td width="10" align="center"><script language="javascript" type="text/javascript">document.write('<input type="checkbox" id="cocher_enquete_identifiant" onclick="liste_cocher(this,\'enquete_identifiant[]\');" \/>');</script></td>
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
				    onclick="liste_onClick('enquete_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('enquete_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['adherent_email']));?></td>
                        <td><?php print(ma_htmlentities(date(STRING_DATETIME,$liste->occurrence[$i]['enregistrement'])));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['question1']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['question2']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['question3']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['question4']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['question5']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['libre']));?></td>
                        <td width="10" align="center"><input type="checkbox" name="enquete_identifiant[]" id="enquete_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" value="<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" onclick="liste_onUnClick(this,2);" /></td>
                      </tr>
                      <?php
		}
?>
                    </table>
                    <?php
	}
	else
		print('<span class="important">Aucun &eacute;l&eacute;ment</span>');
?>
                  </td>
                </tr>
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'enquete_liste.php','enquete_page');?></td>
                  <td align="right"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
