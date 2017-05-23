<?php
	print('<div class="degueuli"></div>');
	print('<h3 class="bouton">Villes recenc&eacute;es</h3>');
	if($ville_liste->total!=1)
		print('<p><strong>'.$ville_liste->total.' ville'.($ville_liste->total>1?'s':'').'</strong> dans un rayon de '.$alerte->rayon.'Km</p>');
	else
		print('<p><strong>'.ma_htmlentities(ucwords(mb_strtolower(str_replace('-',' ',$ville_liste->occurrence[0]['nom'])))).'</strong> est la seule ville dans un rayon de '.$alerte->rayon.'Km</p>');
	if($ville_liste->total>1){
		$total=0; for($i=0;$i<sizeof($ville_liste->occurrence);$i++) $total+=$ville_liste->occurrence[$i]['nombre'];
		print('<hr>');
		print('<ul>');
		print('<li'.(!(int)$_SESSION['annonce_ville']?' class="selected"':'').'><a href="?annonce_ville=&amp;annonce_statut=">'.(!(int)$_SESSION['annonce_ville']?'Toutes les villes
			<small>&gt; '.$total.' annonce'.($total>1?'s':'').'</small>':'<strong>Afficher toutes les villes</strong>&nbsp;').'</a><img src="'.HTTP_STATIC.'/img/fleche.png" alt="" width="20" height="20"></li>');
		for($i=0;$i<sizeof($ville_liste->occurrence);$i++)
			print('<li'.($ville_liste->occurrence[$i]['selected']?' class="selected"':'').'><a'.($ville_liste->occurrence[$i]['selected']?' class="croix"':'').' href="'.($ville_liste->occurrence[$i]['selected']?'?annonce_ville=&amp;annonce_statut=':'?annonce_ville='.urlencode($ville_liste->occurrence[$i]['identifiant']).'&amp;annonce_statut=').'"><strong>'.ma_htmlentities(ucwords(mb_strtolower(str_replace('-',' ',$ville_liste->occurrence[$i]['nom'])))).'</strong>
			'.((int)$_SESSION['annonce_ville']?'<small>':'').'&gt; '.($ville_liste->occurrence[$i]['nombre'].' annonce'.($ville_liste->occurrence[$i]['nombre']>1?'s':'')).''.((int)$_SESSION['annonce_ville']?'</small>':'').'</a><img src="'.HTTP_STATIC.'/img/fleche.png" alt="" width="20" height="20"></li>');
		print('</ul>');
	}
?>