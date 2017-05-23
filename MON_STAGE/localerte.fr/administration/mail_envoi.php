<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'mail.php');
	
	$mail=new ld_mail();
	$mail_envoi_erreur=0;
	
	if(isset($_REQUEST['mail_envoi_submit']))
	{
		$mail->de=$_REQUEST['mail_de'];
		$mail->reponse_a=$_REQUEST['mail_reponse_a'];
		$mail->retour_a=$_REQUEST['mail_retour_a'];
		$mail->accuse_a=$_REQUEST['mail_accuse_a'];
		$mail->a=$_REQUEST['mail_a'];
		$mail->copie_a=$_REQUEST['mail_copie_a'];
		$mail->copie_cachee_a=$_REQUEST['mail_copie_cachee_a'];
		$mail->sujet=$_REQUEST['mail_sujet'];
		switch($_REQUEST['mail_format'])
		{
			case 'text':
				$mail->text=$_REQUEST['mail_message'];
				break;
			case 'html':
				$mail->html=ma_htmlentities($_REQUEST['mail_message']);
				break;
		}
		
		switch($_REQUEST['mail_envoi_submit'])
		{
			case 'Envoyer':
				if(isset($_SESSION['mail_fichier_joint']))
					$mail->fichier=$_SESSION['mail_fichier_joint'];
				
				$mail_envoi_erreur=@$mail->envoyer();
				if($mail_envoi_erreur===true)
				{
					$mail_envoi_erreur=0;
					$mail->effacer();
					$mail->de=ini_get('sendmail_from');
					if(isset($_SESSION['mail_fichier_joint']))
						for($i=0;$i<sizeof($_SESSION['mail_fichier_joint']);$i++)
							unlink($_SESSION['mail_fichier_joint'][$i]['chemin']);
					unset($_SESSION['mail_fichier_joint']);
				}
				break;
			case 'Attacher':
				if(is_uploaded_file($_FILES['mail_fichier_attache']['tmp_name']))
				{
					move_uploaded_file($_FILES['mail_fichier_attache']['tmp_name'],'prive/temp/'.basename($_FILES['mail_fichier_attache']['tmp_name']));
					$_SESSION['mail_fichier_joint'][]['chemin']='prive/temp/'.basename($_FILES['mail_fichier_attache']['tmp_name']);
					$_SESSION['mail_fichier_joint'][sizeof($_SESSION['mail_fichier_joint'])-1]['nom']=$_FILES['mail_fichier_attache']['name'];
				}
				else
					$mail_envoi_erreur=MAIL_TOTAL_ERREUR+1;
			case 'Supprimer':
				if(isset($_REQUEST['mail_fichier_joint']))
				{
					$mail_fichier_joint=array();
					for($i=0;$i<sizeof($_SESSION['mail_fichier_joint']);$i++)
					{
						if(array_search($i,$_REQUEST['mail_fichier_joint'])===false)
							$mail_fichier_joint[]=$_SESSION['mail_fichier_joint'][$i];
						else
							unlink($_SESSION['mail_fichier_joint'][$i]['chemin']);
					}
					$_SESSION['mail_fichier_joint']=$mail_fichier_joint;
					if(!sizeof($_SESSION['mail_fichier_joint']))
						unset($_SESSION['mail_fichier_joint']);
				}
				break;
			case 'Afficher':
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid($_REQUEST['referer']));
				die();
				break;
		}
	}
	else
	{
		$_REQUEST['mail_format']='text';
		if(isset($_REQUEST['mail_a']))
			$mail->a=$_REQUEST['mail_a'];
		if(isset($_REQUEST['mail_de']))
			$mail->de=$_REQUEST['mail_de'];
		else
			$mail->de=ini_get('sendmail_from');
		$_REQUEST['referer']=(isset($_SERVER['HTTP_REFERER']))?($_SERVER['HTTP_REFERER']):('mail_envoi.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>
<body onload="DonnerFocus('mail_de');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Envoyer un mail</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['mail_envoi_submit']))
	{
		switch($_REQUEST['mail_envoi_submit'])
		{
			case 'Envoyer':
				if($mail_envoi_erreur===false)
					print('Suite &agrave; une erreur de notre serveur, nous vous invitons &agrave; nous contacter ult&egrave;rieurement');
				elseif($mail_envoi_erreur)
				{
					if($mail_envoi_erreur & MAIL_DE_ERREUR) print('L\'email de l\'exp&eacute;diteur n\'est pas un email valide<br />');
					if($mail_envoi_erreur & MAIL_REPONSE_A_ERREUR) print('L\'email pour la r&eacute;ponse n\'est pas un email valide<br />');
					if($mail_envoi_erreur & MAIL_RETOUR_A_ERREUR) print('L\'email pour le retour d\'erreurs n\'est pas un email valide<br />');
					if($mail_envoi_erreur & MAIL_ACCUSE_A_ERREUR) print('L\'email pour l\'accus&eacute; de reception n\'est pas un email valide<br />');
					if($mail_envoi_erreur & MAIL_A_ERREUR) print('Au moins un email des destinataires n\'est pas un email valide<br />');
					if($mail_envoi_erreur & MAIL_COPIE_A_ERREUR) print('Au moins un email des copies n\'est pas un email valide<br />');
					if($mail_envoi_erreur & MAIL_COPIE_CACHEE_A_ERREUR) print('Au moins un email des copies cach&eacute;es n\'est pas un email valide<br />');
					if($mail_envoi_erreur & MAIL_SUJET_ERREUR) print('Le sujet doit &ecirc;tre compris entre '.MAIL_SUJET_MIN.' et '.MAIL_SUJET_MAX.' caract&egrave;re(s)<br />');
					if($mail_envoi_erreur & MAIL_FICHIER_ERREUR) print('Au moins un des fichiers est inaccessible (inexistant, droit d\'acc&egrave;s)<br />');
					if($mail_envoi_erreur & MAIL_TEXT_HTML_FICHIER_ERREUR) print('Le message du mail est vide<br />');
				}
				else
					print('Mail envoyé');
				break;
			case 'Attacher':
				if($mail_envoi_erreur)
					print('Fichier trop gros ou non attach&eacute;');
				else
					print('Fichier attach&eacute;');
				break;
			default:
				print('&nbsp;');
				break;
		}
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="mail_envoi.php" method="post" enctype="multipart/form-data" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && $mail_envoi_erreur & MAIL_DE_ERREUR) print(' class="important"');?>>De : </td>
                  <td><input name="mail_de" type="text" id="mail_de" value="<?php print(ma_htmlentities($mail->de));?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && $mail_envoi_erreur & MAIL_REPONSE_A_ERREUR) print(' class="important"');?>>R&eacute;ponse &agrave; </td>
                  <td><input name="mail_reponse_a" type="text" id="mail_reponse_a" value="<?php print(ma_htmlentities($mail->reponse_a));?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && $mail_envoi_erreur & MAIL_RETOUR_A_ERREUR) print(' class="important"');?>>Retour des erreurs &agrave; : </td>
                  <td><input name="mail_retour_a" type="text" id="mail_retour_a" value="<?php print(ma_htmlentities($mail->retour_a));?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && $mail_envoi_erreur & MAIL_ACCUSE_A_ERREUR) print(' class="important"');?>>Accus&eacute; de reception &agrave; : </td>
                  <td><input name="mail_accuse_a" type="text" id="mail_accuse_a" value="<?php print(ma_htmlentities($mail->accuse_a));?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && $mail_envoi_erreur & MAIL_A_ERREUR) print(' class="important"');?>>A : </td>
                  <td><input name="mail_a" type="text" id="mail_a" value="<?php print(ma_htmlentities($mail->a));?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && $mail_envoi_erreur & MAIL_COPIE_A_ERREUR) print(' class="important"');?>>Copie &agrave;  : </td>
                  <td><input name="mail_copie_a" type="text" id="mail_copie_a" value="<?php print(ma_htmlentities($mail->copie_a));?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && $mail_envoi_erreur & MAIL_COPIE_CACHEE_A_ERREUR) print(' class="important"');?>>Copie cach&eacute;e &agrave;  : </td>
                  <td><input name="mail_copie_cachee_a" type="text" id="mail_copie_cachee_a" value="<?php print(ma_htmlentities($mail->copie_cachee_a));?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && $mail_envoi_erreur & MAIL_SUJET_ERREUR) print(' class="important"');?>>Sujet : </td>
                  <td><input name="mail_sujet" type="text" id="mail_sujet" value="<?php print(ma_htmlentities($mail->sujet));?>" maxlength="<?php print(MAIL_SUJET_MAX);?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && $mail_envoi_erreur & MAIL_TEXT_HTML_FICHIER_ERREUR) print(' class="important"');?>>Message : </td>
                  <td><input type="radio" name="mail_format" value="text" id="mail_format_text"<?php if($_REQUEST['mail_format']=='text') print('checked="cheched"');?> /><label for="mail_format_text">Text</label>
			      <input type="radio" name="mail_format" value="html" id="mail_format_html"<?php if($_REQUEST['mail_format']=='html') print('checked="cheched"');?> /><label for="mail_format_html">HTML</label></td>
                </tr>
                <tr>
                  <td colspan="2"><textarea name="mail_message" cols="50" rows="6" id="mail_message">
<?php
	if($_REQUEST['mail_format']=='text')
		print(ma_htmlentities($mail->text));
	else
		print(ma_htmlentities($mail->html));
?></textarea></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && ($mail_envoi_erreur & MAIL_FICHIER_ERREUR || $mail_envoi_erreur & MAIL_TEXT_HTML_FICHIER_ERREUR || $mail_envoi_erreur==MAIL_TOTAL_ERREUR+1)) print(' class="important"');?>>Fichier &agrave; ajouter (<?php print(ma_htmlentities(ini_get('upload_max_filesize')));?>) : </td>
                  <td><input name="mail_fichier_attache" type="file" id="mail_fichier_attache" />
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php print(((int)ini_get('upload_max_filesize'))*1024*1024)?>" />
				    <input type="submit" name="mail_envoi_submit" id="mail_envoi_submit" value="Attacher" /></td>
                </tr>
<?php
	if(isset($_SESSION['mail_fichier_joint']))
	{
?>
                <tr>
                  <td<?php if(isset($_REQUEST['mail_envoi_submit']) && ($mail_envoi_erreur & MAIL_FICHIER_ERREUR || $mail_envoi_erreur & MAIL_TEXT_HTML_FICHIER_ERREUR)) print(' class="important"');?>>Fichier(s) joint(s) : </td>
                  <td>
<?php
		for($i=0;$i<sizeof($_SESSION['mail_fichier_joint']);$i++)
			print('<input type="checkbox" name="mail_fichier_joint[]" id="mail_fichier_joint_'.$i.'" value="'.$i.'" /><label for="mail_fichier_joint_'.$i.'">'.ma_htmlentities($_SESSION['mail_fichier_joint'][$i]['nom']).'</label><br />');
?>
				  <br />
				  <input type="submit" name="mail_envoi_submit" id="mail_envoi_submit" value="Supprimer" /></td>
                </tr>
<?php
	}
?>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="referer" type="hidden" id="referer" value="<?php print(ma_htmlentities($_REQUEST['referer']));?>" />
                  <input type="submit" name="mail_envoi_submit" id="mail_envoi_submit" value="Envoyer" />
				  <?php if($_REQUEST['referer']) print('<input type="submit" name="mail_envoi_submit" id="mail_envoi_submit" value="Retour" />');?></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
