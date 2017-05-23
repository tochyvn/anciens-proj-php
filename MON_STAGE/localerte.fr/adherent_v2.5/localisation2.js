var localisationID=0;
var localisationJSON=null;

function js_localisation_rechercher(chaine,maximum)
{
	if(!localisationJSON) return '';
	
	chaine=chaine.replace(/[^a-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ]+/gi,' ');
	
	if(chaine==' ' || chaine=='') return '';
	
	chercher=['^P\.?A\.?C\.?A\.?$',
				'^ ',
				' ((e|è)me( |$))',
				' (er( |$))',
				'^PARIS I(er?)?$',
				'^PARIS II((e|è)m?e?)?$',
				'^PARIS III((e|è)m?e?)?$',
				'^PARIS IV((e|è)m?e?)?$',
				'^PARIS V((e|è)m?e?)?$',
				'^PARIS VI((e|è)m?e?)?$',
				'^PARIS VII((e|è)m?e?)?$',
				'^PARIS VIII((e|è)m?e?)?$',
				'^PARIS IX((e|è)m?e?)?$',
				'^PARIS X((e|è)m?e?)?$',
				'^PARIS XI((e|è)m?e?)?$',
				'^PARIS XII((e|è)m?e?)?$',
				'^PARIS XIII((e|è)m?e?)?$',
				'^PARIS XIV((e|è)m?e?)?$',
				'^PARIS XV((e|è)m?e?)?$',
				'^PARIS XVI((e|è)m?e?)?$',
				'^PARIS XVII((e|è)m?e?)?$',
				'^PARIS XVIII((e|è)m?e?)?$',
				'^PARIS XIX((e|è)m?e?)?$',
				'^PARIS XX((e|è)m?e?)?$',
				'^PARIS ([1-9])((e|è)m?e?)?$',
				'^PARIS ([1-9])(er?)?$',
				'^PARIS ([1-2][0-9])((e|è)m?e?)?$',
				'^PARIS ([1-2][0-9])(er?)?$',
				'^MARSEILLE I(er?)?$',
				'^MARSEILLE II((e|è)m?e?)?$',
				'^MARSEILLE III((e|è)m?e?)?$',
				'^MARSEILLE IV((e|è)m?e?)?$',
				'^MARSEILLE V((e|è)m?e?)?$',
				'^MARSEILLE VI((e|è)m?e?)?$',
				'^MARSEILLE VII((e|è)m?e?)?$',
				'^MARSEILLE VIII((e|è)m?e?)?$',
				'^MARSEILLE IX((e|è)m?e?)?$',
				'^MARSEILLE X((e|è)m?e?)?$',
				'^MARSEILLE XI((e|è)m?e?)?$',
				'^MARSEILLE XII((e|è)m?e?)?$',
				'^MARSEILLE XIII((e|è)m?e?)?$',
				'^MARSEILLE ([1-9])((e|è)m?e?)?$',
				'^MARSEILLE ([1-9])(er?)?$',
				'^MARSEILLE ([1-2][0-9])((e|è)m?e?)?$',
				'^MARSEILLE ([1-2][0-9])(er?)?$',
				'^LYON I(er?)?$',
				'^LYON II((e|è)m?e?)?$',
				'^LYON III((e|è)m?e?)?$',
				'^LYON IV((e|è)m?e?)?$',
				'^LYON V((e|è)m?e?)?$',
				'^LYON VI((e|è)m?e?)?$',
				'^LYON VII((e|è)m?e?)?$',
				'^LYON VIII((e|è)m?e?)?$',
				'^LYON IX((e|è)m?e?)?$',
				'^LYON ([1-9])((e|è)m?e?)?$',
				'^LYON ([1-9])(er?)?$',
				'^LYON ([1-2][0-9])((e|è)m?e?)?$',
				'^LYON ([1-2][0-9])(er?)?$',
				'^IDF$',
				'(^| )st ',
				'(^| )ste ',
				'^2A$',
				'^2B$',
				'^([ a-z]+) ([0-9]+)$',
				'^([0-9]+) ([ a-z]+)$'];
	
	remplacer=['provence alpes cote d azur',
				'',
				'$1',
				'$1',
				'75001 PARIS',
				'75002 PARIS',
				'75003 PARIS',
				'75004 PARIS',
				'75005 PARIS',
				'75006 PARIS',
				'75007 PARIS',
				'75008 PARIS',
				'75009 PARIS',
				'75010 PARIS',
				'75011 PARIS',
				'75012 PARIS',
				'75013 PARIS',
				'75014 PARIS',
				'75015 PARIS',
				'75016 PARIS',
				'75017 PARIS',
				'75018 PARIS',
				'75019 PARIS',
				'75020 PARIS',
				'750+$1[0-9]* PARIS',
				'750+$1[0-9]* PARIS',
				'750+$1[0-9]* PARIS',
				'750+$1[0-9]* PARIS',
				'13001 MARSEILLE',
				'13002 MARSEILLE',
				'13003 MARSEILLE',
				'13004 MARSEILLE',
				'13005 MARSEILLE',
				'13006 MARSEILLE',
				'13007 MARSEILLE',
				'13008 MARSEILLE',
				'13009 MARSEILLE',
				'13010 MARSEILLE',
				'13011 MARSEILLE',
				'13012 MARSEILLE',
				'13013 MARSEILLE',
				'130+$1[0-9]* MARSEILLE',
				'130+$1[0-9]* MARSEILLE',
				'130+$1[0-9]* MARSEILLE',
				'130+$1[0-9]* MARSEILLE',
				'69001 LYON',
				'69002 LYON',
				'69003 LYON',
				'69004 LYON',
				'69005 LYON',
				'69006 LYON',
				'69007 LYON',
				'69008 LYON',
				'69009 LYON',
				'690+$1[0-9]* LYON',
				'690+$1[0-9]* LYON',
				'690+$1[0-9]* LYON',
				'690+$1[0-9]* LYON',
				'ILE DE FRANCE',
				'$1saint ',
				'$1sainte ',
				'Corse du Sud',
				'Haute-Corse',
				'$2[0-9]* $1',
				'$1[0-9]* $2'];
	
	for(i=0;i<chercher.length;i++)
	{
		var regexp=new RegExp(chercher[i],'gi');
		chaine=chaine.replace(regexp,remplacer[i])
	}
	
	chaine=chaine.replace(/[àáâãäåa]/gi,'[àáâãäåa]');
	chaine=chaine.replace(/[çc]/gi,'[çc]');
	chaine=chaine.replace(/[èéêëe]/gi,'[èéêëe]');
	chaine=chaine.replace(/[ìíîïi]/gi,'[ìíîïi]');
	chaine=chaine.replace(/[ðòóôõöo]/gi,'[ðòóôõöo]');
	chaine=chaine.replace(/[ùúûüu]/gi,'[ùúûüu]');
	chaine=chaine.replace(/[ýÿy]/gi,'[ýÿy]');
	chaine=chaine.replace(/[ ]/gi,'[^a-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ]+');
	
	var regexp=new Array();
	regexp[0]=new RegExp('(^'+chaine+')','i');
	regexp[1]=new RegExp('([^a-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ]+'+chaine+')','i');
	
	var resultat='';
	for(i=0,j=0;j<maximum && i<localisationJSON.length;i++)
	{
		for(k=0,trouve=false;!trouve && k<regexp.length;k++)
			if(localisationJSON[i]['text'].search(regexp[k])!=-1)
			{
				resultat+='<li js-localisation-value="'+localisationJSON[i]['value']+'">'+localisationJSON[i]['text'].replace(regexp[k],'<strong>$1</strong>')+'</li>'
				j++;
				trouve=true;
			}
	}
	
	if(resultat) resultat='<ul>'+resultat+'</ul>';
	return resultat;
}

function js_localisation_maj(parent,enfant)
{
	if(parent.val()!=enfant.attr('text'))
	{
		enfant.html(js_localisation_rechercher(parent.val(),30));
		
		if(enfant.html()) parent.attr('selectedIndex',1);
		else parent.attr('selectedIndex',0);
		
		enfant.find('li').bind('mouseover',function(event){
			var enfant=$(this).parents('div');
			
			enfant.find('li').removeClass('selected');
			$(this).addClass('selected');
		});
		enfant.find('li').bind('click',function(event){
			var enfant=$(this).parents('div');
			var parent=$('[js-localisation-id="'+enfant.attr('id')+'"]');
			
			position=js_localisation_trouver(parent,enfant);
			js_localisation_choisir(parent,enfant,position);
		});
		
		enfant.attr('text',parent.val());
	}
}

function js_localisation_position(parent,enfant)
{
	var position=js_localisation_trouver(parent,enfant);
	
	enfant.scrollTop(0);
	enfant.scrollTop(enfant.find('li:nth-child('+position+')').position().top-enfant.innerHeight()+enfant.find('li:nth-child('+position+')').outerHeight(true)-enfant.scrollTop());
}

function js_localisation_ouvrir(parent,enfant)
{
	if(enfant.html())
	{
		enfant.find('li').removeClass('selected');
		enfant.find('li:nth-child('+parent.attr('selectedIndex')+')').addClass('selected');
		enfant
			.css('display','block')
			.css('top',parent.offset().top+parent.innerHeight())
			.css('left',parent.offset().left)
			.css('width',parent.innerWidth());
		js_localisation_position(parent,enfant);
	}
	else js_localisation_fermer(parent,enfant)
}

function js_localisation_fermer(parent,enfant)
{
	enfant.css('display','none');
}

function js_localisation_choisir(parent,enfant,position)
{
	if(position>=1 && position<=enfant.find('li').length)
	{
		parent.attr('selectedIndex',position);
		parent.val(enfant.find('li:nth-child('+position+')').text());
		parent.trigger('change');
	}
}

function js_localisation_selectionner(parent,enfant,position)
{
	if(position>=1 && position<=enfant.find('li').length)
	{
		enfant.find('li').removeClass('selected');
		enfant.find('li:nth-child('+position+')').addClass('selected');
		js_localisation_position(parent,enfant)
	}
}

function js_localisation_trouver(parent,enfant)
{
	var position=0;
	var trouve=false;
	enfant.find('li').each(function(){
		if(!trouve)
		{
			position++;
			if($(this).hasClass('selected')) trouve=true;
		}
	});
	
	return position;
}

function js_localisation_changer(parent,destination)
{
	var enfant=$('#'+parent.attr('js-localisation-id'));
	var position=js_localisation_trouver(parent,enfant);
	if(position) destination.val(enfant.find('li:nth-child('+position+')').attr('js-localisation-value'));
	else destination.val('');
}

function js_localisation()
{
	$('input[type="text"].js-localisation').each(function(){
		
		if(!$(this).attr('js-localisation-id'))
		{
			localisationID++;
			$(this)
				.attr('js-localisation-id','js-localisation-'+localisationID)
				.attr('autocomplete','off');
			
			$('<DIV />')
				.appendTo($('body'))
				.attr('id',$(this).attr('js-localisation-id'))
				.attr('selectedIndex',0)
				.attr('text','')
				.attr('survol',0)
				.addClass('js-localisation-popup')
				.css('position','absolute')
				.css('display','none')
				.bind('mouseover',function(){$(this).attr('survol',1)})
				.bind('mouseout',function(){$(this).attr('survol',0)});
		}
		
		var parent=$(this);
		var enfant=$('#'+$(this).attr('js-localisation-id'));
		
		if(!localisationJSON)
		{
			$.ajax({url:'/adherent/localisation.json', success:function(data){
				localisationJSON=data;
				js_localisation_maj(parent,enfant);
			}});
		}
		
		parent.bind('blur',function(){
			var parent=$(this);
			var enfant=$('#'+$(this).attr('js-localisation-id'));
			
			if(!parseInt(enfant.attr('survol'))) js_localisation_fermer(parent,enfant);
		});
		
		parent.bind('keydown',function(event){
			var parent=$(this);
			var enfant=$('#'+$(this).attr('js-localisation-id'));
			
			switch(event.keyCode)
			{
				case 9://TAB
					if(enfant.css('display')!='none')
					{
						position=js_localisation_trouver(parent,enfant);
						if(parent.val()!=enfant.find('li:nth-child('+position+')').text())
						{
							js_localisation_choisir(parent,enfant,position);
							
							event.stopPropagation();
							event.preventDefault();
						}
					}
					break;
				case 13://ENTREE
					if(enfant.css('display')!='none')
					{
						position=js_localisation_trouver(parent,enfant);
						js_localisation_choisir(parent,enfant,position);
						js_localisation_fermer(parent,enfant);
						
						event.stopPropagation();
						event.preventDefault();
					}
					break;
				case 27://ECHAP
					if(enfant.css('display')!='none')
					{
						js_localisation_fermer(parent,enfant);
						
						event.stopPropagation();
						event.preventDefault();
					}
					break;
				case 38://FLECHE HAUT
					if(enfant.css('display')!='none')
					{
						position=js_localisation_trouver(parent,enfant);
						js_localisation_selectionner(parent,enfant,(position>1?position-1:enfant.find('li').length));
						
						event.stopPropagation();
						event.preventDefault();
					}
					break;
				case 40://FLECHE BAS
					if(enfant.css('display')=='none') js_localisation_ouvrir(parent,enfant);
					else
					{
						position=js_localisation_trouver(parent,enfant);
						js_localisation_selectionner(parent,enfant,(position<enfant.find('li').length?position+1:1));
						
						event.stopPropagation();
						event.preventDefault();
					}
					
					break;
			}
		});
		
		parent.bind('keyup',function(event){
			var parent=$(this);
			var enfant=$('#'+$(this).attr('js-localisation-id'));
			
			switch(event.keyCode)
			{
				case 9:
				case 13:
				case 27:
				case 38:
				case 40:
					break;
				default:
					js_localisation_maj(parent,enfant);
					js_localisation_ouvrir(parent,enfant);
					break;
			}
		});
		
		parent.bind('dblclick',function(){
			var parent=$(this);
			var enfant=$('#'+$(this).attr('js-localisation-id'));
			
			js_localisation_ouvrir(parent,enfant);
		});
		
		enfant
			.attr('text','fhdklfhdjkfhdfjhgdjghfjkghkljmsj')
			.bind('click',function(event){js_localisation_fermer(parent,enfant);})
		
		//js_localisation_maj(parent,enfant);
		//js_localisation_choisir(parent,enfant,3);
		//js_localisation_ouvrir(parent,enfant);
	});
	
			
	$(window).bind('resize',function(){
		$('input[type="text"].js-localisation').each(function(){
			var parent=$(this);
			var enfant=$('#'+$(this).attr('js-localisation-id'));
			
			enfant
				.css('top',parent.offset().top+parent.innerHeight())
				.css('left',parent.offset().left)
				.css('width',parent.innerWidth());
		});
	});
}

$(function(){js_localisation();});