// JavaScript Document

function js_blank()
{
	var objets=document.getElementsByTagName('A');
	for(var i=0; i<objets.length; i++)
	{
		var objet=objets.item(i);
		if(objet.getAttribute('className'))
			var className=objet.getAttribute('className');
		else if(objet.getAttribute('class'))
			var className=objet.getAttribute('class');
		else
			var className=null;
		
		if(className!=null && className!='' && className.search(/(^| )js-blank( |$)/)!=-1)
			objet.target='_blank';
	}
}

function js_autocomplete()
{
	var objets=document.getElementsByTagName('INPUT');
	for(var i=0; i<objets.length; i++)
	{
		var objet=objets.item(i);
		if(objet.getAttribute('className'))
			var className=objet.getAttribute('className');
		else if(objet.getAttribute('class'))
			var className=objet.getAttribute('class');
		else
			var className=null;
		
		if(className!=null && className!='' && className.search(/(^| )js-autocomplete( |$)/)!=-1)
			objet.setAttribute('autocomplete','off');
	}
}

function js_submit()
{
	var objets=document.getElementsByTagName('*');
	for(var i=0; i<objets.length; i++)
	{
		var objet=objets.item(i);
		if(objet.getAttribute('className'))
			var className=objet.getAttribute('className');
		else if(objet.getAttribute('class'))
			var className=objet.getAttribute('class');
		else
			var className=null;
		
		if(className!=null && className!='' && className.search(/(^| )js-submit( |$)/)!=-1)
		{
			objet.setAttribute('onchange','alert(\'toto\');this.form.submit();alert(\'toto\');');
			//objet.onchange='alert(\'toto\');this.form.submit();alert(\'toto\');';
			alert('ok');
		}
	}
}

function js_label()
{
	var objets=document.getElementsByTagName('INPUT');
	for(var i=0; i<objets.length; i++)
	{
		var objet=objets.item(i);
		if(objet.getAttribute('className')) var className=objet.getAttribute('className');
		else if(objet.getAttribute('class')) var className=objet.getAttribute('class');
		else var className=null;
		
		if(className!=null && className!='' && className.search(/(^| )js-label( |$)/)!=-1 && !objet.getAttribute('jslabel'))
		{
			AjouterEvenement(objet,'focus',function(e){
				if(e.srcElement) var objet=e.srcElement; else var objet=e.currentTarget;
				
				objet.className=objet.className.replace(/(^| )js-label-defaut( |$)/,'$1');
				objet.className=objet.className.replace(/(^| )js-label-normal( |$)/,'$1');
				
				if(objet.value==objet.title)
				{
					objet.value='';
					objet.className+=' js-label-normal';
				}
				},false);
			AjouterEvenement(objet,'blur',function(e){
				if(e.srcElement) var objet=e.srcElement; else var objet=e.currentTarget;
				
				objet.className=objet.className.replace(/(^| )js-label-defaut( |$)/,'$1');
				objet.className=objet.className.replace(/(^| )js-label-normal( |$)/,'$1');
				
				if(objet.value=='')
				{
					objet.value=objet.title;
					objet.className+=' js-label-defaut';
				}
				},false);
			
			objet.className=objet.className.replace(/(^| )js-label-defaut( |$)/,'$1');
			objet.className=objet.className.replace(/(^| )js-label-normal( |$)/,'$1');
			
			if(objet.value==''){
				objet.value=objet.title;
				objet.className+=' js-label-defaut';
			}else objet.className+=' js-label-normal';
			objet.setAttribute('jslabel','jslabel');
		}
	}
	
	var objets=document.getElementsByTagName('FORM');
	for(var i=0; i<objets.length; i++)
	{
		var objet=objets.item(i);
		AjouterEvenement(objet,'submit',function(e){
			if(e.srcElement) var objet=e.srcElement;
			else var objet=e.currentTarget;
			
			for(i=0;i<objet.elements.length;i++)
				if(objet.elements[i].value==objet.elements[i].title) objet.elements[i].value='';
			},false);
	}
}

/*CARTE*/
function CarteInitialiser()
{
	document.getElementById('iCARTE').style.backgroundImage='url('+document.getElementById('iCARTE').getAttribute('src')+')';
	document.getElementById('iCARTE').setAttribute('src','<?php print(URL_ADHERENT.'image/carte/transparent.gif');?>');
	
	var objet=document.getElementsByTagName('*');
	for(var i=0;i<objet.length;i++)
	{
		var id=objet[i].getAttribute('id')
		if(id && id.search(/^departement-/)==0)
		{
			AjouterEvenement(objet[i],'mouseover',function(e){CarteCharger(e);},false);
			AjouterEvenement(objet[i],'mouseout',function(e){CarteDecharger(e);},false);
		}
	}
}

function CarteCharger(e)
{
	if(e.srcElement)
		var objet=e.srcElement;
	else
		var objet=e.currentTarget;
	
	var id=objet.getAttribute('id');
	var departement=id.match(/^departement-([^-]+)/);
	var departement_nb=id.match(/^departement-[^-]+-([0-9]+)/);
	
	document.getElementById('iCARTE').setAttribute('src','<?php print(URL_ADHERENT.'image/carte/');?>'+departement[1]+'.gif');
	document.getElementById('dpt_mini').setAttribute('src','<?php print(URL_ADHERENT.'image/carte/mini/');?>'+departement[1]+'.gif');
	document.getElementById('dpt_num').setAttribute('value','Dpt ' + departement[1] + ' :');
	document.getElementById('dpt_nb').setAttribute('value',departement_nb[1] + ' annonce' + ((departement_nb[1]>1)?('s'):('')));
}

function CarteDecharger(e)
{
	if(e.srcElement)
		var objet=e.srcElement;
	else
		var objet=e.currentTarget;
	
	document.getElementById('iCARTE').setAttribute('src','<?php print(URL_ADHERENT.'image/carte/transparent.gif');?>');
}