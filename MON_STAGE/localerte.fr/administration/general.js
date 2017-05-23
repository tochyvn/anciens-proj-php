function OuvrirCalendrier(id,masque)
{
	return OuvrirPopup('calendrier.html?id='+id+'&masque='+masque,true,'Calendrier','toolbar=0,location=0,personnalbar=0,status=0,menubar=0,scrollbars=0,resizable=1,height=300,width=300,left='+(screen.width/2-150)+',top='+(screen.height/2-150)+',channelmode=0,directories=0');
}

function CreerCalendrier(id,masque,value)
{
	document.write('<input type="text" name="'+id+'" id="'+id+'" value="'+value+'" readonly="readonly" onclick="OuvrirCalendrier(\''+id+'\','+masque+'); return false;" />');
	document.write('<a href="#" onclick="OuvrirCalendrier(\''+id+'\','+masque+'); return false;"><img src="image/calendrier_affichage.jpg" style="vertical-align:bottom; border-style:none;" alt="Afficher le calendrier" title="Afficher le calendrier" /></a>');
	document.write('<a href="#" onclick="document.getElementById(\''+id+'\').value=\'\'; return false;"><img src="image/calendrier_vide.jpg" style="vertical-align:bottom; border-style:none;" alt="Effacer la date" title="Effacer la date" /></a>');
}

function OuvrirCouleur(id)
{
	return OuvrirPopup('couleur.html?id='+id,true,'Couleur','toolbar=0,location=0,personnalbar=0,status=0,menubar=0,scrollbars=0,resizable=1,height=288,width=306,left='+(screen.width/2-153)+',top='+(screen.height/2-144)+',channelmode=0,directories=0');
}

function CreerCouleur(id,value)
{
	document.write('<input type="text" name="'+id+'" id="'+id+'" value="'+value+'" readonly="readonly"'+((value!='')?(' style="background-color:'+value+';"'):(''))+' onclick="OuvrirCouleur(\''+id+'\'); return false;" />');
	document.write('<a href="#" onclick="OuvrirCouleur(\''+id+'\'); return false;"><img src="image/couleur_affichage.jpg" style="vertical-align:bottom; border-style:none;" alt="Afficher les couleurs" title="Afficher les couleurs" /></a>');
	document.write('<a href="#" onclick="document.getElementById(\''+id+'\').value=\'\'; document.getElementById(\''+id+'\').style.backgroundColor=\'#FFFFFF\'; return false;"><img src="image/couleur_vide.jpg" style="vertical-align:bottom; border-style:none;" alt="Effacer la couleur" title="Effacer la couleur" /></a>');
}