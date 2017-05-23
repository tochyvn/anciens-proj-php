function OuvrirPopup(url,popupdessus,titre,option)
{
	switch(OuvrirPopup.arguments.length)
	{
		case 0:
			url='';
		case 1:
			popupdessus=true;
		case 2:
			titre='_blank';
		case 3:
			option='toolbar=1,location=1,personnalbar=1,status=1,menubar=1,scrollbars=1,resizable=1,height=420,width=760,left=0,top=0,channelmode=0,directories=0';
		default:
	}
	if(url=='')
		url='about:blank';
	fenetre=window.open(url,titre,option);
	try
	{
		if(popupdessus==true)
			fenetre.focus();
		else
			window.focus();
		return true;
	}
	catch(e)
	{
		return false;
	}
}

function FermerPopup(retoursurparent)
{
	switch(FermerPopup.arguments.length)
	{
		case 0:
			retoursurparent=false;
		case 1:
			fermerfenetre=true;
		default:
	}
	if(window.opener!=null && retoursurparent==true)
		if(!window.opener.closed)
			window.opener.focus();
	if(fermerfenetre)
		window.close();
}

function DimensionnerPopupParId(id)
{
	var objet=document.getElementById(id);
	window.innerWidth=objet.offsetWidth;
	window.innerHeight=objet.offsetHeight;
	//window.resizeTo(objet.offsetWidth,objet.offsetHeight);
}

function VerifierParent(url)
{
	if(top==self)
	{
		if (window.opera)
		{
			var balise = document.createElement('a');
			balise.href=url;
			balise.target='_top';
			balise.click();
		}
		else
			top.location=url;
	}
}

function DonnerFocus(id,nameElement,indexElement)
{
	switch(DonnerFocus.arguments.length)
	{
		default:
			try
			{
				document.getElementById(id).focus();
			}
			catch(e)
			{}
			break;
		case 3:
			var idForm=id;
			var form=document.getElementsByTagName('form');
			for(i=0;i<form.length;i++)
			{
				if(form[i].id==idForm)
				{
					var element=form[i].elements;
					var index=0;
					for(j=0;j<element.length;j++)
					{
						if(element[j].name==nameElement)
						{
							if(index==indexElement)
								element[j].focus();
							index++;
						}
					}
				}
			}
			break;
	}
}

function TextareaCompter(textarea,text,minimum,maximum,couleur)
{
	document.getElementById(text).value=document.getElementById(textarea).value.length;
	if(document.getElementById(text).value<minimum || document.getElementById(text).value>maximum)
		document.getElementById(text).style.color=couleur;
	else
		document.getElementById(text).style.color='';		
}

function VerifierPattern(pattern,message)
{
	try
	{
		var subject='';
		var pattern=new RegExp(pattern);
		pattern.test(subject);
		if(message)
			alert('Le pattern est CORRECT');
		return true;
	}
	catch(e)
	{
		if(message)
			alert('Le pattern est ERRONE');
		return false;
	}
}

function FormaterPattern(pattern)
{
	pattern=pattern.replace(/( +)/g,' ');
	return pattern.replace(/( )/g, '[^a-z]+');
}

function EncapsulerPattern(pattern)
{
	return pattern.replace(/([\.\\\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\/])/g,'\\$1');
}

function CocherTous(name)
{
	for(i=0;i<document.getElementsByName(name).length;i++)
		document.getElementsByName(name)[i].checked=true;
}

function CocherAucun(name)
{
	for(i=0;i<document.getElementsByName(name).length;i++)
		document.getElementsByName(name)[i].checked=false;
}

function CocherInverse(name)
{
	for(i=0;i<document.getElementsByName(name).length;i++)
		document.getElementsByName(name)[i].checked=!document.getElementsByName(name)[i].checked;
}

function AjouterEvenement(objet,evenement,fonction,capture)
{
	try
	{
		if(objet.addEventListener)
			objet.addEventListener(evenement, fonction, capture);
		else if(objet.attachEvent)
			objet.attachEvent('on'+evenement, fonction);
	}
	catch(e)
	{}
}
