//LOCALISATION
function LocalisationCharger()
{
	var objets=document.getElementsByTagName('INPUT');
	for(var i=0; i<objets.length; i++)
	{
		var objet=objets.item(i);
		if(objet.getAttribute('id'))
			var id=objet.getAttribute('id');
		else
			var id=null;
		
		if(id!=null && id!='' && id.search(/^lt_/)!=-1)
		{
			var index=id.replace(/^lt_/,'');
			if(ie6 || ie7)
			{
				objet.onfocus=function(){LocalisationActionner('focus','lt',index)};
				objet.onkeyup=function(){LocalisationActionner('keyup','lt',index)};
				objet.onblur=function(){LocalisationActionner('blur','lt',index)};
			}
			else
			{
				objet.setAttribute('onfocus','LocalisationActionner(\'focus\',\'lt\',\''+index+'\')');
				objet.setAttribute('onkeyup','LocalisationActionner(\'keyup\',\'lt\',\''+index+'\')');
				objet.setAttribute('onblur','LocalisationActionner(\'blur\',\'lt\',\''+index+'\')');
			}
			
			LocalisationBlur('lt',index);
			
			objet=document.getElementById('ls_'+index);
			if(ie6 || ie7)
			{
				objet.onfocus=function(){LocalisationActionner('focus','ls',index)};
				objet.onblur=function(){LocalisationActionner('blur','ls',index)};
				objet.onchange=function(){LocalisationActionner('change','ls',index)};
				objet.ondblclick=function(){LocalisationActionner('dblclick','ls',index)};
			}
			else
			{
				objet.setAttribute('onfocus','LocalisationActionner(\'focus\',\'ls\',\''+index+'\')');
				objet.setAttribute('onblur','LocalisationActionner(\'blur\',\'ls\',\''+index+'\')');
				objet.setAttribute('onchange','LocalisationActionner(\'change\',\'ls\',\''+index+'\')');
				objet.setAttribute('ondblclick','LocalisationActionner(\'dblclick\',\'ls\',\''+index+'\')');
			}
		}
	}
}

function LocalisationActionner(action,mode,index)
{
	if(LocationAction!==null) {clearTimeout(LocationAction); LocationAction=null;}
	
	switch(action)
	{
		case 'focus':
			LocationAction=setTimeout('LocalisationFocus(\''+mode+'\',\''+index+'\');',100);
			break;
		case 'keyup':
			LocationAction=setTimeout('LocalisationKeyup(\''+mode+'\',\''+index+'\');',500);
			break;
		case 'blur':
			LocationAction=setTimeout('LocalisationBlur(\''+mode+'\',\''+index+'\');',100);
			break;
		case 'change':
			LocationAction=setTimeout('LocalisationChange(\''+mode+'\',\''+index+'\');',100);
			break;
		case 'dblclick':
			LocationAction=setTimeout('LocalisationDblclick(\''+mode+'\',\''+index+'\');',100);
			break;
	}
}

function LocalisationDblclick(mode,index)
{
	var lt_o=document.getElementById('lt_'+index);
	var ls_o=document.getElementById('ls_'+index);
	var lb_o=document.getElementById('lb_'+index);
	var lf_o=document.getElementById('lf_'+index);
	
	ls_o.style.display='none';
}

function LocalisationFocus(mode,index)
{
	var lt_o=document.getElementById('lt_'+index);
	var ls_o=document.getElementById('ls_'+index);
	
	if(lt_o.getAttribute('focus')) lt_o.removeAttribute('focus');
	if(ls_o.getAttribute('focus')) ls_o.removeAttribute('focus');
	if(mode=='lt') lt_o.setAttribute('focus','focus');
	if(mode=='ls') ls_o.setAttribute('focus','focus');
	
	if(lt_o.value=='Saisissez la ville ou code postal') lt_o.value='';
	else ls_o.style.display='';
}

function LocalisationKeyup(mode,index)
{
	var lt_o=document.getElementById('lt_'+index);
	var ls_o=document.getElementById('ls_'+index);
	
	for(var i=ls_o.options.length-1;i>0;i--) ls_o.options[i]=null;
	
	if(window.XMLHttpRequest) var socket=new XMLHttpRequest();
	else if(window.ActiveXObject) var socket=new ActiveXObject('Microsoft.XMLHTTP');
	socket.open('GET','<?php print(addslashes(HTTP_INCLUSION.'localisation_recherche.php?localisation_ajax='));?>'+encodeURIComponent(lt_o.value),false);
	socket.send(null);
	
	if(socket.readyState != 4) return false;
			
	var xml=socket.responseXML;
	var items=xml.getElementsByTagName('item');
	if(items.length)
	{
		for(var i=0; i<items.length; i++)
		{
			var value=items[i].getElementsByTagName('value')[0].firstChild.nodeValue;
			var text=items[i].getElementsByTagName('text')[0].firstChild.nodeValue;
			ls_o.options[i]=new Option(text,value);
		}
		ls_o.style.display='';
	}
	else ls_o.style.display='none';
}

function LocalisationChange(mode,index)
{
	var lt_o=document.getElementById('lt_'+index);
	var ls_o=document.getElementById('ls_'+index);
	
	if(mode=='ls'){lt_o.value=ls_o.options[ls_o.selectedIndex].text; ls_o.style.display='none';}
}

function LocalisationBlur(mode,index)
{
	var lt_o=document.getElementById('lt_'+index);
	var ls_o=document.getElementById('ls_'+index);
	
	if(ls_o.getAttribute('focus')!='focus' || mode=='ls') ls_o.style.display='none';
	
	if(mode=='lt') lt_o.removeAttribute('focus');
	if(mode=='ls') ls_o.removeAttribute('focus');
	
	if(lt_o.value=='') lt_o.value='Saisissez la ville ou code postal';
}

var LocationAction=null;

var ie6=false;
var ie7=false;
if(navigator.appName=='Microsoft Internet Explorer')
{
	var chaine=new String(navigator.appVersion);
	var resultat=chaine.match(/MSIE ([0-9]+.[0-9]+)/);
	if(resultat && parseInt(resultat[1])>=6 && parseInt(resultat[1])<7)
		ie6=true;
	if(resultat && parseInt(resultat[1])>=7 && parseInt(resultat[1])<8)
		ie7=true;
}