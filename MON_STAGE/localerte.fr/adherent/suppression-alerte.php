<?php
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'alerte.php');
	
	$alerte=new ld_alerte();
	$alerte_erreur=0;
	
	if(isset($_REQUEST['alerte_submit']))
	{
		$alerte->identifiant=$_REQUEST['alerte_identifiant'];
		$alerte->lire();
		if($alerte->adherent==$_SESSION['adherent_identifiant']) $alerte_erreur=$alerte->supprimer();
	}
	
	$liste=new ld_liste
	('
		select identifiant
		from alerte
		where 1
			and adherent='.$_SESSION['adherent_identifiant'].'
		order by alerte.enregistrement, alerte.identifiant
	');
	
	$numero=0;
	for($i=0;$i<$liste->total;$i++)
		if($liste->occurrence[$i]['identifiant']==(int)$_REQUEST['alerte_identifiant'])
		{
			$numero=$i+1;
			$i=$liste->total-1;
		}
	
	$liste=new ld_liste
	('
		select count(*) as nombre
		from alerte
		where 1
			and adherent='.$_SESSION['adherent_identifiant'].'
			and identifiant not in ('.(int)$_REQUEST['alerte_identifiant'].')
	');
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Suppression alerte - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<div class="style3 style3-suppression-alerte">
  <div class="header">
    <h1>Supprimer l'alerte <?php print(ma_htmlentities($numero));?> ?</h1>
    <?php include_once(__DIR__.'/inc/style3.header.php');?>
  </div>
  <div class="section">
    <form action="suppression-alerte.php" method="post">
      <?php
	  	if($liste->occurrence[0]['nombre'])
    		print('<p>Voulez-vous supprimer cette alerte de recherche ?</p>');
		else
	        print
		  	('
				<p class="orange"><strong class="orange">Attention :</strong> en supprimant cette derni&egrave;re alerte de recherche, vous serez automatiquement d&eacute;sinscrit de notre service.</p>
		  		<p>si vous disposez d&rsquo;un abonnement payant, celui-ci sera automatiquement caduque</p>
			');
		?>
      <hr>
      <?php
	if(isset($_REQUEST['alerte_submit']))
	{
		if($alerte_erreur)
		{
			print('<ul class="erreur">');
			print('<li>identifiant d\'alerte inconnu</li>');
			print('</ul>');
		}
		else print('<p class="succes">Suppression effectu&eacute;e</p>');
	}
	if(!isset($_REQUEST['alerte_submit']) || $alerte_erreur)
	{
?>
      <p class="action">
        <button class="bouton" type="submit" name="alerte_submit" value="Valider">Valider</button>
      </p>
<?php
	}
?>
      <p class="cache">
        <input type="hidden" name="alerte_identifiant" value="<?php print(ma_htmlentities($_REQUEST['alerte_identifiant']));?>">
      </p>
    </form>
  </div>
  <div class="footer">
    <?php include_once(__DIR__.'/inc/style3.footer.php');?>
  </div>
</div>
</body>
</html>
