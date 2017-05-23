<?php
	if(isset($_SESSION['adherent_identifiant']) && $abonnement['resultat']=='ABONNEMENT_UTILISABLE')
	{
		require_once(PWD_INCLUSION.'date.php');
		
		$abonnement=$abonnement['objet'];
		
		$restant=$abonnement->premiere_utilisation+$abonnement->delai-time();
		if($restant>60*60*24)
			$chrono=duree($restant,'%jj %hh');
		elseif($restant>60*60)
			$chrono=duree($restant,'%hh %mm');
		else
			$chrono=duree($restant,'%mm %ss');
		
		print
		('
			<p class="chrono" id="chrono">'.preg_replace('/([0-9]+)/','<strong>$1</strong>',$chrono).'</p>
			<script type="text/javascript">
			<!--
			function chrono(id,restant)
			{
				if(restant)
				{
					restant--; if(restant<0) restant=0;
					
					nombre=restant;
					seconde=nombre%60;
					nombre=Math.floor(nombre/60);
					minute=nombre%60;
					nombre=Math.floor(nombre/60);
					heure=nombre%24;
					nombre=Math.floor(nombre/24);
					jour=nombre;
					
					var objet=document.getElementById(id);
					
					if(jour)
						objet.innerHTML=\'<strong>\'+jour+\'</strong>j <strong>\'+heure+\'</strong>h\';
					else if(heure)
						objet.innerHTML=\'<strong>\'+heure+\'</strong>h <strong>\'+minute+\'</strong>m\';
					else
						objet.innerHTML=\'<strong>\'+minute+\'</strong>m <strong>\'+seconde+\'</strong>s\';
					
					if(restant>0) window.setTimeout(\'chrono(\\\'\'+id+\'\\\', \\\'\'+restant+\'\\\');\',1000);
				}
			}


			chrono(\'chrono\', '.$restant.');
			//-->
			</script>
		');
	}
?>