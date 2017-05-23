<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'spool_alerte.php');
	require_once(PWD_INCLUSION.'spool_optimisation.php');
	require_once(PWD_INCLUSION.'spool_vieux.php');
	require_once(PWD_INCLUSION.'spool_rappel.php');
	require_once(PWD_INCLUSION.'spool_veille.php');
	require_once(PWD_INCLUSION.'spool_aide.php');
	require_once(PWD_INCLUSION.'spool_abonnement.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$spool_optimisation=new ld_spool_optimisation();
	$spool_vieux=new ld_spool_vieux();
	$spool_alerte=new ld_spool_alerte();
	$spool_rappel=new ld_spool_rappel();
	$spool_veille=new ld_spool_veille();
	$spool_aide=new ld_spool_aide();
	$spool_abonnement=new ld_spool_abonnement();
	
	if(isset($_REQUEST['submit']))
	{
		switch($_REQUEST['submit'])
		{
			case 'charger':
				${$_REQUEST['spool']}->charger();
				break;
			case 'stopper':
				${$_REQUEST['spool']}->stopper();
				break;
			case 'vider':
				${$_REQUEST['spool']}->vider();
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>

<body>
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php');?></td>
    <td valign="top"><table cellspacing="0" cellpadding="20">
        <tr>
          <td><table cellspacing="0" cellpadding="4">
            <tr>
              <th colspan="2">Abonnement</th>
              </tr>
            <tr>
              <td>Date de chargement:</td>
              <td><?php if($spool_abonnement->chargement!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_abonnement->chargement)));?></td>
              </tr>
            <tr>
              <td>D&eacute;but de l'envoi:</td>
              <td><?php if($spool_abonnement->debut!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_abonnement->debut)));?></td>
              </tr>
            <tr>
              <td>Fin de l'envoi:</td>
              <td><?php if($spool_abonnement->fin!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_abonnement->fin)));?></td>
              </tr>
            <tr>
              <td>Nombre total:</td>
              <td><?php if($spool_abonnement->total!==NULL) print(ma_htmlentities($spool_abonnement->total));?></td>
              </tr>
            <tr>
              <td>Nombre restant:</td>
              <td><?php if($spool_abonnement->restant!==NULL) print(ma_htmlentities($spool_abonnement->restant));?></td>
              </tr>
            <tr>
              <td>En cours d'envoi:</td>
              <td><?php if($spool_abonnement->envoye!==NULL) print(ma_htmlentities($spool_abonnement->envoye));?></td>
              </tr>
            <tr>
              <td colspan="2" align="center">
                <a href="spool_gestion.php?spool=spool_abonnement&amp;submit=charger" onclick="return confirm('Etes-vous certain de vouloir charger le spool ?');">Charger</a> | <a href="spool_abonnement.php" target="_blank" onclick="return confirm('Etes-vous certain de vouloir envoyer le spool ?');">Envoyer</a> | <a href="spool_gestion.php?spool=spool_abonnement&amp;submit=stopper" onclick="return confirm('Etes-vous certain de vouloir stopper l\'envoi ?');">Stopper</a> | <a href="spool_gestion.php?spool=spool_abonnement&amp;submit=vider" onclick="return confirm('Etes-vous certain de vouloir vider le spool ?');">Vider</a></td>
            </tr>
          </table></td> <td><table cellspacing="0" cellpadding="4">
            <tr>
              <th colspan="2">Spool matin</th>
              </tr>
            <tr>
              <td>Date de chargement:</td>
              <td><?php if($spool_alerte->chargement!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_alerte->chargement)));?></td>
              </tr>
            <tr>
              <td>D&eacute;but de l'envoi:</td>
              <td><?php if($spool_alerte->debut!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_alerte->debut)));?></td>
              </tr>
            <tr>
              <td>Fin de l'envoi:</td>
              <td><?php if($spool_alerte->fin!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_alerte->fin)));?></td>
              </tr>
            <tr>
              <td>Nombre total:</td>
              <td><?php if($spool_alerte->total!==NULL) print(ma_htmlentities($spool_alerte->total));?></td>
              </tr>
            <tr>
              <td>Nombre restant:</td>
              <td><?php if($spool_alerte->restant!==NULL) print(ma_htmlentities($spool_alerte->restant));?></td>
              </tr>
            <tr>
              <td>En cours d'envoi:</td>
              <td><?php if($spool_alerte->envoye!==NULL) print(ma_htmlentities($spool_alerte->envoye));?></td>
              </tr>
            <tr>
              <td colspan="2" align="center">
                <a href="spool_gestion.php?spool=spool_alerte&amp;submit=charger" onclick="return confirm('Etes-vous certain de vouloir charger le spool ?');">Charger</a> 
              | <a href="spool_alerte.php" target="_blank" onclick="return confirm('Etes-vous certain de vouloir envoyer le spool ?');">Envoyer</a>
              | <a href="spool_gestion.php?spool=spool_alerte&amp;submit=stopper" onclick="return confirm('Etes-vous certain de vouloir stopper l\'envoi ?');">Stopper</a>
              | <a href="spool_gestion.php?spool=spool_alerte&amp;submit=vider" onclick="return confirm('Etes-vous certain de vouloir vider le spool ?');">Vider</a>
              </td>
              </tr>
          </table></td>
          <td><table cellspacing="0" cellpadding="4">
            <tr>
              <th colspan="2">Spool soir</th>
            </tr>
            <tr>
              <td>Date de chargement:</td>
              <td><?php if($spool_optimisation->chargement!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_optimisation->chargement)));?></td>
            </tr>
            <tr>
              <td>D&eacute;but de l'envoi:</td>
              <td><?php if($spool_optimisation->debut!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_optimisation->debut)));?></td>
            </tr>
            <tr>
              <td>Fin de l'envoi:</td>
              <td><?php if($spool_optimisation->fin!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_optimisation->fin)));?></td>
            </tr>
            <tr>
              <td>Nombre total:</td>
              <td><?php if($spool_optimisation->total!==NULL) print(ma_htmlentities($spool_optimisation->total));?></td>
            </tr>
            <tr>
              <td>Nombre restant:</td>
              <td><?php if($spool_optimisation->restant!==NULL) print(ma_htmlentities($spool_optimisation->restant));?></td>
            </tr>
            <tr>
              <td>En cours d'envoi:</td>
              <td><?php if($spool_optimisation->envoye!==NULL) print(ma_htmlentities($spool_optimisation->envoye));?></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><a href="spool_gestion.php?spool=spool_optimisation&amp;submit=charger" onclick="return confirm('Etes-vous certain de vouloir charger le spool ?');">Charger</a> | <a href="spool_optimisation.php" target="_blank" onclick="return confirm('Etes-vous certain de vouloir envoyer le spool ?');">Envoyer</a> | <a href="spool_gestion.php?spool=spool_optimisation&amp;submit=stopper" onclick="return confirm('Etes-vous certain de vouloir stopper l\'envoi ?');">Stopper</a> | <a href="spool_gestion.php?spool=spool_optimisation&amp;submit=vider" onclick="return confirm('Etes-vous certain de vouloir vider le spool ?');">Vider</a></td>
            </tr>
          </table></td>
         </tr><tr>
          <td><table cellpadding="4" cellspacing="0">
            <tr>
              <th colspan="2">Relance</th>
            </tr>
            <tr>
              <td>Date de chargement:</td>
              <td><?php if($spool_rappel->chargement!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_rappel->chargement)));?></td>
            </tr>
            <tr>
              <td>D&eacute;but de l'envoi:</td>
              <td><?php if($spool_rappel->debut!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_rappel->debut)));?></td>
            </tr>
            <tr>
              <td>Fin de l'envoi:</td>
              <td><?php if($spool_rappel->fin!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_rappel->fin)));?></td>
            </tr>
            <tr>
              <td>Nombre total:</td>
              <td><?php if($spool_rappel->total!==NULL) print(ma_htmlentities($spool_rappel->total));?></td>
            </tr>
            <tr>
              <td>Nombre restant:</td>
              <td><?php if($spool_rappel->restant!==NULL) print(ma_htmlentities($spool_rappel->restant));?></td>
            </tr>
            <tr>
              <td>En cours d'envoi:</td>
              <td><?php if($spool_rappel->envoye!==NULL) print(ma_htmlentities($spool_rappel->envoye));?></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><a href="spool_gestion.php?spool=spool_rappel&amp;submit=charger" onclick="return confirm('Etes-vous certain de vouloir charger le spool ?');">Charger</a> | <a href="spool_rappel.php" target="_blank" onclick="return confirm('Etes-vous certain de vouloir envoyer le spool ?');">Envoyer</a> | <a href="spool_gestion.php?spool=spool_rappel&amp;submit=stopper" onclick="return confirm('Etes-vous certain de vouloir stopper l\'envoi ?');">Stopper</a> | <a href="spool_gestion.php?spool=spool_rappel&amp;submit=vider" onclick="return confirm('Etes-vous certain de vouloir vider le spool ?');">Vider</a></td>
            </tr>
          </table></td>
          <td><table cellpadding="4" cellspacing="0">
            <tr>
              <th colspan="2">Aide</th>
            </tr>
            <tr>
              <td>Date de chargement:</td>
              <td><?php if($spool_aide->chargement!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_aide->chargement)));?></td>
            </tr>
            <tr>
              <td>D&eacute;but de l'envoi:</td>
              <td><?php if($spool_aide->debut!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_aide->debut)));?></td>
            </tr>
            <tr>
              <td>Fin de l'envoi:</td>
              <td><?php if($spool_aide->fin!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_aide->fin)));?></td>
            </tr>
            <tr>
              <td>Nombre total:</td>
              <td><?php if($spool_aide->total!==NULL) print(ma_htmlentities($spool_aide->total));?></td>
            </tr>
            <tr>
              <td>Nombre restant:</td>
              <td><?php if($spool_aide->restant!==NULL) print(ma_htmlentities($spool_aide->restant));?></td>
            </tr>
            <tr>
              <td>En cours d'envoi:</td>
              <td><?php if($spool_aide->envoye!==NULL) print(ma_htmlentities($spool_aide->envoye));?></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><a href="spool_gestion.php?spool=spool_aide&amp;submit=charger" onclick="return confirm('Etes-vous certain de vouloir charger le spool ?');">Charger</a> | <a href="spool_aide.php" target="_blank" onclick="return confirm('Etes-vous certain de vouloir envoyer le spool ?');">Envoyer</a> | <a href="spool_gestion.php?spool=spool_aide&amp;submit=stopper" onclick="return confirm('Etes-vous certain de vouloir stopper l\'envoi ?');">Stopper</a> | <a href="spool_gestion.php?spool=spool_aide&amp;submit=vider" onclick="return confirm('Etes-vous certain de vouloir vider le spool ?');">Vider</a></td>
            </tr>
          </table></td>
          <td>
          <table cellpadding="4" cellspacing="0">
            <tr>
              <th colspan="2">Veille</th>
            </tr>
            <tr>
              <td>Date de chargement:</td>
              <td><?php if($spool_veille->chargement!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_veille->chargement)));?></td>
            </tr>
            <tr>
              <td>D&eacute;but de l'envoi:</td>
              <td><?php if($spool_veille->debut!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_veille->debut)));?></td>
            </tr>
            <tr>
              <td>Fin de l'envoi:</td>
              <td><?php if($spool_veille->fin!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_veille->fin)));?></td>
            </tr>
            <tr>
              <td>Nombre total:</td>
              <td><?php if($spool_veille->total!==NULL) print(ma_htmlentities($spool_veille->total));?></td>
            </tr>
            <tr>
              <td>Nombre restant:</td>
              <td><?php if($spool_veille->restant!==NULL) print(ma_htmlentities($spool_veille->restant));?></td>
            </tr>
            <tr>
              <td>En cours d'envoi:</td>
              <td><?php if($spool_veille->envoye!==NULL) print(ma_htmlentities($spool_veille->envoye));?></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><a href="spool_gestion.php?spool=spool_veille&amp;submit=charger" onclick="return confirm('Etes-vous certain de vouloir charger le spool ?');">Charger</a> | <a href="spool_veille.php" target="_blank" onclick="return confirm('Etes-vous certain de vouloir envoyer le spool ?');">Envoyer</a> | <a href="spool_gestion.php?spool=spool_veille&amp;submit=stopper" onclick="return confirm('Etes-vous certain de vouloir stopper l\'envoi ?');">Stopper</a> | <a href="spool_gestion.php?spool=spool_veille&amp;submit=vider" onclick="return confirm('Etes-vous certain de vouloir vider le spool ?');">Vider</a></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table cellspacing="0" cellpadding="4">
            <tr>
              <th colspan="2">Vieux</th>
            </tr>
            <tr>
              <td>Date de chargement:</td>
              <td><?php if($spool_vieux->chargement!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_vieux->chargement)));?></td>
            </tr>
            <tr>
              <td>D&eacute;but de l'envoi:</td>
              <td><?php if($spool_vieux->debut!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_vieux->debut)));?></td>
            </tr>
            <tr>
              <td>Fin de l'envoi:</td>
              <td><?php if($spool_vieux->fin!==NULL) print(ma_htmlentities(strftime(STRING_DATETIMECOMLPLET,$spool_vieux->fin)));?></td>
            </tr>
            <tr>
              <td>Nombre total:</td>
              <td><?php if($spool_vieux->total!==NULL) print(ma_htmlentities($spool_vieux->total));?></td>
            </tr>
            <tr>
              <td>Nombre restant:</td>
              <td><?php if($spool_vieux->restant!==NULL) print(ma_htmlentities($spool_vieux->restant));?></td>
            </tr>
            <tr>
              <td>En cours d'envoi:</td>
              <td><?php if($spool_vieux->envoye!==NULL) print(ma_htmlentities($spool_vieux->envoye));?></td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <a href="spool_gestion.php?spool=spool_vieux&amp;submit=charger" onclick="return confirm('Etes-vous certain de vouloir charger le spool ?');">Charger</a> 
              | <a href="spool_vieux.php" target="_blank" onclick="return confirm('Etes-vous certain de vouloir envoyer le spool ?');">Envoyer</a> 
              | <a href="spool_gestion.php?spool=spool_vieux&amp;submit=stopper" onclick="return confirm('Etes-vous certain de vouloir stopper l\'envoi ?');">Stopper</a> 
              | <a href="spool_gestion.php?spool=spool_vieux&amp;submit=vider" onclick="return confirm('Etes-vous certain de vouloir vider le spool ?');">Vider</a></td>
            </tr>
          </table></td>
          <td></td>
          <td></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>