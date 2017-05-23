<div class="logo">
  <h1><a href="./" title="Retour &agrave; page d'accueil"><img src="<?php print(HTTP_STATIC.'/img/logo2.png');?>" alt="<?php print(ma_htmlentities($head_title));?>" width="230" height="89"></a></h1>
  <ul>
    <li><small><a target="_blank" href="mon-compte.php" class="mon-compte">Mon compte</a></small></li>
    <li><small><a href="?deconnexion_submit=">D&eacute;connexion</a></small></li>
  </ul>
  <?php
    if($abonnement['resultat']=='ABONNEMENT_UTILISABLE'){
        if($abonnement['objet']->premiere_utilisation+$abonnement['objet']->delai<mktime(0,0,0,date('m'),date('d')+1,date('Y')))
            print('<p><small><strong>Votre abonnement</strong><span class="reabonnement">exp. le '.date('d/m H:i',$abonnement['objet']->premiere_utilisation+$abonnement['objet']->delai).'</span></small></p>');
        else
            print('<p><small><strong>Votre abonnement</strong> expire le '.date('d/m/y H:i',$abonnement['objet']->premiere_utilisation+$abonnement['objet']->delai).'</small></p>');
    }
  ?>
  <?php if($abonnement['resultat']=='ABONNEMENT_DELAI_PERIME') print('<p>&nbsp;<br><small><a class="reabonnement" href="mes-paiements.php">Abonnez-vous</a></small></p>');?>
  <div class="clear"></div>
</div>
