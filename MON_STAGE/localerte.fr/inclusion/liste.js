liste_couleur_courante='';

function liste_onMouseOver(objet,couleur)
{
	try
	{
		liste_couleur_courante=objet.style.backgroundColor;
		objet.style.backgroundColor=couleur;
	}
	catch(e)
	{}
}

function liste_onMouseOut(objet)
{
	try
	{
		objet.style.backgroundColor=liste_couleur_courante;
	}
	catch(e)
	{}
}

function liste_onDblClick(id,couleur1,couleur2)
{
	//try
	{
		if(liste_couleur_courante.search(/rgb\([0-9]+, [0-9]+, [0-9]+\)/)!=-1)
		{
			resultat3=liste_couleur_courante.match(/[0-9]+/g);
			if(resultat3)
			{
				for(i3=0;i3<resultat3.length;i3++)
				{
					temp=parseInt(resultat3[i3]);
					resultat3[i3]=new String(temp.toString(16));
					if(resultat3[i3].length==1)
						resultat3[i3]='0'+resultat3[i3];
				}
				liste_couleur_courante=resultat3.join('');
				liste_couleur_courante='#'+liste_couleur_courante;
			}
		}
		if(liste_couleur_courante.toLowerCase()==couleur1.toLowerCase())
			liste_couleur_courante=couleur2;
		else
			liste_couleur_courante=couleur1;
	}
	/*catch(e) {
	}*/
}

function liste_onClick(id)
{
	try
	{
		document.getElementById(id).checked=document.getElementById(id).checked^1;
	}
	catch(e)
	{}
}
function liste_onClick2(id, submit_name, submit_id, hidden_id, checked)
{
	try
	{
		if(checked) document.getElementById(id).checked=document.getElementById(id).checked^1;
		if(document.getElementById(id).checked=document.getElementById(id).checked)
			document.getElementById(hidden_id).value++;
		else document.getElementById(hidden_id).value--;
		
		objet=document.getElementsByName(submit_name);
		switch(document.getElementById(hidden_id).value) {
			case '0':
				for(i=0;i<objet.length;i++)
					objet[i].value = 'COCHEZ les annonces de votre choix puis CLIQUEZ ICI pour valider';
				break;
			case '1':
				for(i=0;i<objet.length;i++)
					objet[i].value = '>> Voir 1 annonce cochée <<';
				break;
			default:
				for(i=0;i<objet.length;i++)
					objet[i].value = '>> Voir les ' + document.getElementById(hidden_id).value + ' annonces cochées <<';
				break;
		}
	}
	catch(e)
	{}
}

function liste_onClick3(id, submit_name, submit_id, hidden_id, checked)
{
	try
	{
		if(checked) document.getElementById(id).checked=document.getElementById(id).checked^1;
		if(document.getElementById(id).checked=document.getElementById(id).checked)
			document.getElementById(hidden_id).value++;
		else document.getElementById(hidden_id).value--;
		
		objet=document.getElementsByName(submit_name);
		switch(document.getElementById(hidden_id).value) {
			case '0':
				for(i=0;i<objet.length;i++)
					objet[i].value = '0 annonce cochée';
				break;
			case '1':
				for(i=0;i<objet.length;i++)
					objet[i].value = '1 annonce cochée';
				break;
			default:
				for(i=0;i<objet.length;i++)
					objet[i].value = document.getElementById(hidden_id).value + ' annonces cochées';
				break;
		}
	}
	catch(e)
	{}
}

function coche_effect(i, j, l, l2) {
	//alert('ok');	
	if(j!=0) {
		document.getElementById('ligne'+ (i+1) +'col1').className = 'coche';
	}
	document.getElementById('ligne'+i+'col1').className = 'coche_rouge';
	//alert("class: "+ document.getElementById('ligne'+i+'col1').className);
	if(i==(l2 - l%20)) {
		setTimeout("coche_effect2("+i+", "+(l2 - l%20)+", '_rouge');", 50);
		setTimeout("coche_effect2("+i+", "+(l2 - l%20)+", '');", 150);
	}
}
function coche_effect2(i, l, couleur) {
	document.getElementById('ligne'+i+'col1').className = 'coche';
	document.getElementById('ligne'+ l +'x20col1b').className = 'coche' + couleur;
	document.getElementById('ligne'+ l +'x20col1a').className = 'coche' + couleur;
	document.getElementById('ligne'+ l +'x20col2a').className = 'filler_gauche' + ((couleur!='')?(couleur):('_orange'));
	document.getElementById('ligne'+ l +'x20col3a').className = 'liste_valide' + couleur;
	document.getElementById('bouton'+ l +'x20col3a').className = 'liste_valide2' + couleur;
}


function liste_onClick_effect(id, submit_name, submit_id, hidden_id, checked, ligne, ligne_total)
{
	try
	{
		if(checked) document.getElementById(id).checked=document.getElementById(id).checked^1;
		if(document.getElementById(id).checked=document.getElementById(id).checked)
			document.getElementById(hidden_id).value++;
		else document.getElementById(hidden_id).value--;
		
		for(i=ligne_total,j=0; i>=(ligne_total - ligne%20); i--,j++) {
			//alert("i: " + i);
			//coche_effect(i, j, ligne_total);
			setTimeout("coche_effect("+i+", "+j+", "+ligne+", "+ligne_total+");", j * 50);
		}
		
		objet=document.getElementsByName(submit_name);
		switch(document.getElementById(hidden_id).value) {
			case '0':
				for(i=0;i<objet.length;i++)
					objet[i].value = '0 annonce cochée';
				break;
			case '1':
				for(i=0;i<objet.length;i++)
					objet[i].value = '1 annonce cochée';
				break;
			default:
				for(i=0;i<objet.length;i++)
					objet[i].value = document.getElementById(hidden_id).value + ' annonces cochées';
				break;
		}
	}
	catch(e)
	{}
}

function liste_cocher(objet,name)
{
	try
	{
		statut=objet.checked;
		for(i=0;i<document.getElementsByName(name).length;i++)
			document.getElementsByName(name)[i].checked=statut;
		for(i=0;i<document.getElementsByTagName('input').length;i++)
			if(document.getElementsByTagName('input')[i].id==objet.id)
				document.getElementsByTagName('input')[i].checked=statut;
	}
	catch(e)
	{}
}

function liste_onUnClick(objet,niveau)
{
	try
	{
		for(i=0;i<niveau;i++)
			var objet=objet.parentNode;
		objet.onclick();
	}
	catch(e)
	{}
}