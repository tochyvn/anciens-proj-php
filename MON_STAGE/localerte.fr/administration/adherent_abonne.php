<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'archive.php');
	
	$adherent=new ld_adherent();
	$adherent_fichier_erreur_fichier=0;
	$adherent_fichier_erreur_decompression=0;
	$adherent_fichier_erreur_abonne=0;
	$adherent_fichier_erreur_champ=0;
	$adherent_fichier_succes=0;
	
	set_time_limit(0);
	
	if(isset($_REQUEST['adherent_fichier_submit']))
	{
		switch($_REQUEST['adherent_fichier_submit'])
		{
			case 'Enregistrer':
				$adherent_fichier_erreur_fichier=$_FILES['adherent_fichier']['error'];
				
				$fichier=false;
				if($adherent_fichier_erreur_fichier==UPLOAD_ERR_NO_FILE)
					$adherent_fichier_erreur_fichier=0;
				elseif(!$adherent_fichier_erreur_fichier)
					$fichier=true;
				
				if(!$adherent_fichier_erreur_fichier)
				{
					$contenu=$_REQUEST['adherent_email'];
					if($fichier)
					{
						switch($_REQUEST['adherent_compression'])
						{
							case 'BZIP':
								if($fichier=bzopen($_FILES['adherent_fichier']['tmp_name'], "r"))
								{
									$contenu.=CRLF;
									while(!feof($fichier))
										$contenu.=bzread($fichier,4096);
									bzclose($fichier);
								}
								else
									$adherent_fichier_erreur_decompression=true;
								break;
							case 'GZIP':
								if($fichier=gzopen($_FILES['adherent_fichier']['tmp_name'], "rb"))
								{
									$contenu.=CRLF;
									while(!gzeof($fichier))
										$contenu.=gzgetc($fichier);
									gzclose($fichier);
								}
								else
									$adherent_fichier_erreur_decompression=true;
								break;
							case 'TAR':
								$fichier=new tar_file($_FILES['adherent_fichier']['tmp_name']);
								$fichier->set_options(array('basedir'=>$chemin,'overwrite'=>1,'inmemory' => 1));
								@$fichier->extract_files();
								if(sizeof($fichier->files)!=1)
									$adherent_fichier_erreur_decompression=true;
								else
								{
									$contenu.=CRLF;
									foreach($fichier->files as $file)
										$contenu.=$file['data'];
								}
								break;
							case 'ZIP':
								$fichier=zip_open($_FILES['adherent_fichier']['tmp_name']);
								if($fichier && $file=zip_read($fichier))
								{
									if(zip_entry_open($fichier,$file,'r'))
									{
										$contenu.=CRLF;
										$contenu.=zip_entry_read($file,zip_entry_filesize($file));
										zip_entry_close($file);
									}
									else
										$adherent_fichier_erreur_decompression=true;
									zip_close($fichier);
								}
								else
									$adherent_fichier_erreur_decompression=true;
								break;
							case 'AUCUN':
								$contenu.=CRLF.file_get_contents($_FILES['adherent_fichier']['tmp_name']);
								break;
						}
					}
					

					if(!isset($_REQUEST['adherent_abonne']))
						$adherent_fichier_erreur_abonne=true;
					
					if(!isset($_REQUEST['adherent_champ']) || !preg_match('/^(identifiant|email)$/',$_REQUEST['adherent_champ']))
						$adherent_fichier_erreur_champ=true;
					
					$compteur=0;
					if(!$adherent_fichier_erreur_decompression && !$adherent_fichier_erreur_abonne && !$adherent_fichier_erreur_champ)
					{
						switch($_REQUEST['adherent_champ'])
						{
							case 'email':
								preg_match_all('/'.STRING_TROUVE_EMAIL.'/',$contenu,$valeur);
								break;
							case 'identifiant':
								preg_match_all('/([0-9]+)/',$contenu,$valeur);
								break;
						}
						
						$valeur=$valeur[0];
						$valeur=array_unique($valeur);
						$valeur=array_values($valeur);
						
						for($i=0;$i<sizeof($valeur);$i++)
						{
							$adherent=new ld_adherent();
							$adherent->{$_REQUEST['adherent_champ']}=$valeur[$i];
							if($adherent->lire($_REQUEST['adherent_champ']))
							{
								$adherent->abonne=$_REQUEST['adherent_abonne'];
								
								if(!$adherent->modifier())
									$compteur++;
							}
						}
					}
				}
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid('adherent_liste.php'));
				die();
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body onload="DonnerFocus('adherent_provenance');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Fichier contenant des adh&eacute;rents </th>
        </tr>
        <tr>
          <td class="important">
<?php
	if(isset($_REQUEST['adherent_fichier_submit']))
	{
		if($adherent_fichier_erreur_fichier==UPLOAD_ERR_INI_SIZE) print('Le fichier exc&egrave;de la taille les '.ini_get('upload_max_filesize').'o autoris&eacute;es dans la configuration du serveur<br />');
		if($adherent_fichier_erreur_fichier==UPLOAD_ERR_FORM_SIZE) print('Le fichier exc&egrave;de la taille les '.octet_format(((int)ini_get('upload_max_filesize'))*1024*1024).' autoris&eacute;es par l\'application<br />');
		if($adherent_fichier_erreur_fichier==UPLOAD_ERR_PARTIAL) print('Le fichier n\'a &eacute;t&eacute; que partiellement t&eacute;l&eacute;charg&eacute;.<br />');
		if($adherent_fichier_erreur_fichier==UPLOAD_ERR_NO_FILE) print('Aucun fichier n\'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.<br />');
		if($adherent_fichier_erreur_fichier==UPLOAD_ERR_NO_TMP_DIR) print('Un dossier temporaire est manquant.<br />');
		if($adherent_fichier_erreur_fichier==UPLOAD_ERR_CANT_WRITE) print('Echec de l\'&eacute;criture du fichier sur le disque.<br />');
		if($adherent_fichier_erreur_fichier==UPLOAD_ERR_EXTENSION) print('Le fichier ne poss&egrave;de pas l\'extension requise.<br />');
		if($adherent_fichier_erreur_decompression) print('Une erreur est survenue durant la d&eacute;compression. Merci de v&eacute;rifier votre archive.<br />');
		if($adherent_fichier_erreur_abonne) print('Choisissez la valeur du champ "Abonn&eacute;".<br />');
		if($adherent_fichier_erreur_champ) print('Choisissez le champ de recherche.<br />');
		if(!$adherent_fichier_erreur_fichier && !$adherent_fichier_erreur_decompression) print($compteur.' email(s) ajout&eacute;(s) ou modifi&eacute;(s).<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="adherent_abonne.php" method="post" enctype="multipart/form-data" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Email : </td>
                  <td><textarea name="adherent_email" id="adherent_email" style="width:300px; height:300px;"></textarea></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['adherent_fichier_submit']) && $adherent_fichier_erreur_fichier) print(' class="important"');?>>Fichier : </td>
                  <td><input name="adherent_fichier" type="file" id="adherent_fichier" value="" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['adherent_fichier_submit']) && $adherent_fichier_erreur_decompression) print(' class="important"');?>>Compression : </td>
                  <td><select name="adherent_compression" id="adherent_compression">
                      <option value="AUCUN">Aucun</option>
                      <option value="BZIP">BZIP</option>
                      <option value="GZIP">GZIP</option>
                      <option value="TAR">TAR</option>
                      <option value="ZIP">ZIP</option>
                    </select></td>
                </tr>
                <tr>
                  <td>Abonn&eacute;</td>
                  <td><input name="adherent_abonne" type="radio" id="adherent_abonne_oui" value="OUI" checked="checked" />
                      <label for="adherent_abonne_oui">OUI</label>
                      <br />
                      <input name="adherent_abonne" type="radio" id="adherent_abonne_non" value="NON" />
                      <label for="adherent_abonne_non">NON</label></td>
                </tr>
                <tr>
                  <td>Champ</td>
                  <td><input name="adherent_champ" type="radio" id="adherent_champ_email" value="email" checked="checked" />
                    <label for="adherent_champ_email">Email</label>
                    <br />
                    <input name="adherent_champ" type="radio" id="adherent_champ_identifiant" value="identifiant" />
                    <label for="adherent_champ_identifiant">Identifiant</label></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="adherent_fichier_submit" id="adherent_fichier_submit" value="Enregistrer" />
                    <input type="submit" name="adherent_fichier_submit" id="adherent_fichier_submit" value="Retour" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
