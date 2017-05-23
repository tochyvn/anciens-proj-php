var Calendrier_nombre=0;

function Calendrier(p_date,p_horaire,p_nom,p_invoke)
{
	var maintenant=new Date();
	if(p_date==null)
		var date=maintenant;
	else
		var date=p_date
	var horaire=p_horaire;
	var pointeur=date;
	var nom=p_nom;
	var invoke=p_invoke;
	var instance=++Calendrier_nombre;
	
	var semaine=new Array();
	semaine[0]='L';
	semaine[1]='M';
	semaine[2]='M';
	semaine[3]='J';
	semaine[4]='V';
	semaine[5]='S';
	semaine[6]='D';
	
	var mois=new Array();
	mois[0]='Janvier';
	mois[1]='F&eacute;vrier';
	mois[2]='Mars';
	mois[3]='Avril';
	mois[4]='Mai';
	mois[5]='Juin';
	mois[6]='Juillet';
	mois[7]='Ao&ucirc;t';
	mois[8]='Septembre';
	mois[9]='Octobre';
	mois[10]='Novembre';
	mois[11]='D&eacute;cembre';
	
	document.write('<style type="text/css">\
				   div#calendrier_'+instance+' {border:1px solid #c6c6c6; background-color:#ffffff; padding:2px; clear:both; float:left; text-align:center; position:absolute;z-index:1000;}\
				   div#calendrier_'+instance+' * {font-family:Arial; font-size:11px}\
				   div#calendrier_'+instance+' .fleche {width:20px; text-align:center; color:#ffffff; border:1px solid #d6d6d6; background-color:#d6d6d6; padding:2px; margin:2px;}\
				   div#calendrier_'+instance+' .mois {width:87px; text-align:center; padding:3px; margin:2px; display:}\
				   div#calendrier_'+instance+' .main {cursor:pointer;}\
				   div#calendrier_'+instance+' .gauche {float:left;}\
				   div#calendrier_'+instance+' .droite {float:right;}\
				   div#calendrier_'+instance+' .clear {clear:both;}\
				   div#calendrier_'+instance+' .cellule {width:25px; text-align:center; border:1px solid #c6c6c6; padding:1px; margin:1px;}\
				   div#calendrier_'+instance+' .survol:hover {background-color:#66ff66;}\
				   div#calendrier_'+instance+' .we {background-color:#cccccc; color:#ffffff;}\
				   div#calendrier_'+instance+' .focus {background-color:#ffcccc; color:#000000;}\
				   div#calendrier_'+instance+' .ajourdhui {border-color:#ff0000;}\
				   div#calendrier_'+instance+' select {margin-top:5px; border:1px solid #c6c6c6;}\
				   div#calendrier_'+instance+' .bloc {width:219px; margin:0px; padding:0px;//display:inline-block;}\
				   </style>');
	
	document.write('<div id="calendrier_'+instance+'" style="position:absolute; display:none;">\
				   <div class="bloc">\
				   <div class="main gauche fleche" onclick="'+nom+'.aller_precedent_annee();">&lt;&lt;</div>\
				   <div class="main gauche fleche" onclick="'+nom+'.aller_precedent_mois();">&lt;</div>\
				   <div class="gauche mois" id="calendrier_mois_'+instance+'">&nbsp;</div>\
				   <div class="main gauche fleche" onclick="'+nom+'.aller_suivant_mois();">&gt;</div>\
				   <div class="main gauche fleche" onclick="'+nom+'.aller_suivant_annee();">&gt;&gt;</div>\
				   </div>');
				   
	document.write('<div class="bloc">');
	
	for(var i=0;i<7;i++)
	{
		var clear=' clear';
		if(i%7) clear='';
		
		var we='';
		if(i%7>=5) we=' we';		
		
		document.write('<div class="gauche'+clear+' cellule'+we+'">'+semaine[i]+'</div>');
	}
	
	document.write('</div>');
	
	document.write('<div id="calendrier_jour_'+instance+'" class="bloc">');
	
	for(i=1;i<=42;i++)
	{
		clear=' clear';
		if((i-1)%7) clear='';
		
		var we='';
		if((i-1)%7>=5) we=' we';		
		
		document.write('<div class="gauche'+clear+' cellule'+we+'" onclick="'+nom+'.invoquer(this.innerHTML);">&nbsp;</div>');
	}
	
	document.write('</div>');
	
	if(horaire)
	{
		document.write('<div id="calendrier_horaire_'+instance+'">');
		
		document.write('<select name="heure" onchange="'+nom+'.changer_horaire();">');
		for(i=0;i<=23;i++)
			document.write('<option value="'+i+'">'+((i<10)?('0'):(''))+i+'h</option>');
	    document.write('</select>');
		
		document.write('<select name="minute" onchange="'+nom+'.changer_horaire();">');
		for(i=0;i<=59;i++)
			document.write('<option value="'+i+'">'+((i<10)?('0'):(''))+i+'m</option>');
	    document.write('</select>');
		
		document.write('<select name="seconde" onchange="'+nom+'.changer_horaire();">');
		for(i=0;i<=59;i++)
			document.write('<option value="'+i+'">'+((i<10)?('0'):(''))+i+'s</option>');
	    document.write('</select>');
		
		document.write('</div>');
	}
	
	document.write('</div>');
	
	this.aller_precedent_mois=function()
	{
		var temp=new Date(pointeur.getFullYear() , pointeur.getMonth()-1,1, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		var temp=new Date(temp.getFullYear(), temp.getMonth(), 31, temp.getHours(), temp.getMinutes(), temp.getSeconds());
		var nombre_jour=31-temp.getDate()%31;
		
		if(nombre_jour<pointeur.getDate())
			var jour=nombre_jour;
		else
			var jour=pointeur.getDate();
		
		pointeur=new Date(pointeur.getFullYear() , pointeur.getMonth()-1,jour, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		
		this.ecrire();
	}
	
	this.aller_suivant_mois=function()
	{
		var temp=new Date(pointeur.getFullYear() , pointeur.getMonth()+1,1, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		var temp=new Date(temp.getFullYear(), temp.getMonth(), 31, temp.getHours(), temp.getMinutes(), temp.getSeconds());
		var nombre_jour=31-temp.getDate()%31;
		
		if(nombre_jour<pointeur.getDate())
			var jour=nombre_jour;
		else
			var jour=pointeur.getDate();
		
		pointeur=new Date(pointeur.getFullYear() , pointeur.getMonth()+1,jour, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		
		this.ecrire();
	}
	
	this.aller_precedent_annee=function()
	{
		var temp=new Date(pointeur.getFullYear()-1 , pointeur.getMonth(), 1, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		var temp=new Date(temp.getFullYear(), temp.getMonth(), 31, temp.getHours(), temp.getMinutes(), temp.getSeconds());
		var nombre_jour=31-temp.getDate()%31;
		
		if(nombre_jour<pointeur.getDate())
			var jour=nombre_jour;
		else
			var jour=pointeur.getDate();
		
		pointeur=new Date(pointeur.getFullYear()-1 , pointeur.getMonth(), jour, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		
		this.ecrire();
	}
	
	this.aller_suivant_annee=function()
	{
		var temp=new Date(pointeur.getFullYear()+1 , pointeur.getMonth(), 1, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		var temp=new Date(temp.getFullYear(), temp.getMonth(), 31, temp.getHours(), temp.getMinutes(), temp.getSeconds());
		var nombre_jour=31-temp.getDate()%31;
		
		if(nombre_jour<pointeur.getDate())
			var jour=nombre_jour;
		else
			var jour=pointeur.getDate();
		
		pointeur=new Date(pointeur.getFullYear()+1 , pointeur.getMonth(), jour, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		
		this.ecrire();
	}
	
	this.changer_horaire=function()
	{
		var div=document.getElementById('calendrier_horaire_'+instance);
		
		var noeud=div;
		if(noeud.parentNode.getAttribute('id')=='calendrier_'+instance)
		{
			trouve=true;
			pointeur=new Date(pointeur.getFullYear() , pointeur.getMonth(), pointeur.getDate(), noeud.getElementsByTagName('select').item(0).selectedIndex, noeud.getElementsByTagName('select').item(1).selectedIndex, noeud.getElementsByTagName('select').item(2).selectedIndex);
		}
		
		this.ecrire();
	}
	
	this.changer_date=function(p_date)
	{
		if(p_date==null)
			date=maintenant;
		else
			date=p_date
		pointeur=date;
		
		this.ecrire();
	}
	
	this.ecrire=function()
	{
		var temp=new Date(pointeur.getFullYear(), pointeur.getMonth(), 31, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		var nombre_jour=31-temp.getDate()%31;
		
		var temp=new Date(pointeur.getFullYear(), pointeur.getMonth(), 1, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
		var jour_semaine=temp.getDay();
		if(jour_semaine==0)
	        jour_semaine=7;
		
		var noeud=document.getElementById('calendrier_mois_'+instance);
		
		//for(i=0, trouve=false;!trouve && i<div.length;i++)
		//{
		//	var noeud=div.item(i);
		//	if(noeud.parentNode.getAttribute('id')=='calendrier_'+instance)
		//	{
		//		trouve=true;
				noeud.innerHTML=mois[pointeur.getMonth()]+' '+pointeur.getFullYear();
		//	}
		//}
		
		var noeud=document.getElementById('calendrier_jour_'+instance);
		
		//for(i=0, trouve=false;!trouve && i<div.length;i++)
		//{
		//	var noeud=div.item(i);
		//	if(noeud.parentNode.getAttribute('id')=='calendrier_'+instance)
		//	{
		//		trouve=true;
				for(j=1;j<=42;j++)
				{
					clear=' clear';
					if((j-1)%7) clear='';
					
					var we='';
					if((j-1)%7>=5) we=' we';		
					
					if(jour_semaine<=j && j-jour_semaine<nombre_jour)
					{
						var temp=new Date(pointeur.getFullYear(), pointeur.getMonth(), j-jour_semaine+1, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
						
						var ajourdhui='';
						if(maintenant.getDate()==temp.getDate() && maintenant.getMonth()==temp.getMonth() && maintenant.getFullYear()==temp.getFullYear()) ajourdhui=' ajourdhui';
						
						var rose='';
						if(date.getDate()==temp.getDate() && date.getMonth()==temp.getMonth() && date.getFullYear()==temp.getFullYear()) rose=' focus';
						
						noeud.getElementsByTagName('div').item(j-1).setAttribute('className','gauche'+clear+' cellule'+we+' survol'+' main'+ajourdhui+rose);
						noeud.getElementsByTagName('div').item(j-1).setAttribute('class','gauche'+clear+' cellule'+we+' survol'+' main'+ajourdhui+rose);
						
						noeud.getElementsByTagName('div').item(j-1).innerHTML=j-jour_semaine+1;
					}
					else
					{
						noeud.getElementsByTagName('div').item(j-1).innerHTML='&nbsp;';
						noeud.getElementsByTagName('div').item(j-1).setAttribute('className','gauche'+clear+' cellule'+we);
						noeud.getElementsByTagName('div').item(j-1).setAttribute('class','gauche'+clear+' cellule'+we);
					}
				}
		//	}
		//}
				
		var noeud=document.getElementById('calendrier_horaire_'+instance);
		
		//for(i=0, trouve=false;!trouve && i<div.length;i++)
		//{
		//	var noeud=div.item(i);
		//	if(noeud.parentNode.getAttribute('id')=='calendrier_'+instance)
		//	{
		//		trouve=true;
				if(horaire)
				{
					noeud.getElementsByTagName('select').item(0).selectedIndex=pointeur.getHours();
					noeud.getElementsByTagName('select').item(1).selectedIndex=pointeur.getMinutes();
					noeud.getElementsByTagName('select').item(2).selectedIndex=pointeur.getSeconds();
				}
		//	}
		//}
	}
	
	this.invoquer=function(chaine)
	{
		if(chaine!='&nbsp;')
		{
			date=new Date(pointeur.getFullYear(), pointeur.getMonth(), chaine, pointeur.getHours(), pointeur.getMinutes(), pointeur.getSeconds());
			this.ecrire();
			eval(invoke);
		}
	}
	
	this.dater=function()
	{
		return date;
	}
	
	this.informer=function()
	{
		return instance;
	}
	
	this.ecrire();
}

function CalendrierDefaut(p_id,p_value,p_date,p_nom,p_heure)
{
	this.objet;
	this.div;
	this.input;
	var id=p_id;
	var value=p_value;
	var date=p_date;
	var nom=p_nom;
	var heure=p_heure;
	
	this.charger=function()
	{
		document.write('<input type="text" name="'+id+'" id="'+id+'" value="'+value+'" readonly="readonly" style="display:inline-block;" onclick="'+nom+'.div.style.display=\'block\';" /> inclus');
		/*document.write('<a href="#" onclick="'+nom+'.div.style.display=\'block\'; return false;">Afficher</a>');
		document.write('<a href="#" onclick="'+nom+'.div.style.display=\'none\'; '+nom+'.input.value=\'\'; return false;">Effacer</a>');
		document.write('<a href="#" onclick="'+nom+'.div.style.display=\'none\'; return false;">Fermer</a>');*/
		
		if(heure)
			this.objet=new Calendrier(date,true,nom+'.objet',nom+'.invoquer(\'d/m/Y H:i:s\')')
		else
			this.objet=new Calendrier(date,false,nom+'.objet',nom+'.invoquer(\'d/m/Y\')')
		this.div=document.getElementById('calendrier_'+this.objet.informer());
		this.input=document.getElementById(id);
		
		this.div.style.display='none';
		this.div.style.position='absolute';
		this.div.style.top=(this.input.offsetTop+this.input.offsetHeight)+'px';
		this.div.style.left=this.input.offsetLeft+'px';
	}

	this.invoquer=function(pattern)
	{
		var date=this.objet.dater();
		switch(pattern)
		{
			case 'd/m/Y H:i:s':
				this.input.value=((date.getDate()<10)?('0'):(''))+date.getDate()+'/'+(((date.getMonth()+1)<10)?('0'):(''))+(date.getMonth()+1)+'/'+((date.getFullYear()<10)?('0'):(''))+date.getFullYear()+' '+((date.getHours()<10)?('0'):(''))+date.getHours()+':'+((date.getMinutes()<10)?('0'):(''))+date.getMinutes()+':'+((date.getSeconds()<10)?('0'):(''))+date.getSeconds();
				break;
			case 'd/m/Y':
				this.input.value=((date.getDate()<10)?('0'):(''))+date.getDate()+'/'+(((date.getMonth()+1)<10)?('0'):(''))+(date.getMonth()+1)+'/'+((date.getFullYear()<10)?('0'):(''))+date.getFullYear();
				break;
		}
		this.div.style.display='none';
	}
	
	this.charger();
}
