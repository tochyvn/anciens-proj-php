var localisationID=0;
var localisationJSON=new Array();

function js_localisation_formater(chaine)
{
	chaine=chaine.replace(/[àáâãäåa]/gi,'a');
	chaine=chaine.replace(/[çc]/gi,'c');
	chaine=chaine.replace(/[èéêëe]/gi,'e');
	chaine=chaine.replace(/[ìíîïi]/gi,'i');
	chaine=chaine.replace(/[ğòóôõöo]/gi,'o');
	chaine=chaine.replace(/[ùúûüu]/gi,'u');
	chaine=chaine.replace(/[ıÿy]/gi,'y');
	chaine=chaine.replace(/[^a-z0-9]+/gi,' ');
	chaine=chaine.replace(/ +/g,' ');
	chaine=chaine.replace(/^ /,'');
	//chaine=chaine.replace(/ $/,'');
	chaine=chaine.toLowerCase();
	
	return chaine;
}

function js_localisation_expressionner(chaine)
{
	chaine=chaine.replace(/[àáâãäåa]/g,'[àáâãäåa]');
	chaine=chaine.replace(/[çc]/g,'[çc]');
	chaine=chaine.replace(/[èéêëe]/g,'[èéêëe]');
	chaine=chaine.replace(/[ìíîïi]/g,'[ìíîïi]');
	chaine=chaine.replace(/[ğòóôõöo]/g,'[ğòóôõöo]');
	chaine=chaine.replace(/[ùúûüu]/g,'[ùúûüu]');
	chaine=chaine.replace(/[ıÿy]/g,'[ıÿy]');
	chaine=chaine.replace(/[ ]/g,'[^a-z0-9àáâãäåçèéêëìíîïğòóôõöùúûüıÿ]+');
	
	return chaine;
}

function js_localisation_rechercher(parent,enfant,maximum)
{
	chercher=['^p ?a ?c ?a$',
				'^ ',
				' (eme( |$))',
				' (er( |$))',
				'^paris i(er?)?$',
				'^paris ii(em?e?)?$',
				'^paris iii(em?e?)?$',
				'^paris iv(em?e?)?$',
				'^paris v(em?e?)?$',
				'^paris vi(em?e?)?$',
				'^paris vii(em?e?)?$',
				'^paris viii(em?e?)?$',
				'^paris ix(em?e?)?$',
				'^paris x(em?e?)?$',
				'^paris xi(em?e?)?$',
				'^paris xii(em?e?)?$',
				'^paris xiii(em?e?)?$',
				'^paris xiv(em?e?)?$',
				'^paris xv(em?e?)?$',
				'^paris xvi(em?e?)?$',
				'^paris xvii(em?e?)?$',
				'^paris xviii(em?e?)?$',
				'^paris xix(em?e?)?$',
				'^paris xx(em?e?)?$',
				'^paris ([1-9])(em?e?)?$',
				'^paris ([1-9])(er?)?$',
				'^paris ([1-2][0-9])(em?e?)?$',
				'^paris ([1-2][0-9])(er?)?$',
				'^marseille i(er?)?$',
				'^marseille ii(em?e?)?$',
				'^marseille ii(em?e?)?$',
				'^marseille iv(em?e?)?$',
				'^marseille v(em?e?)?$',
				'^marseille vi(em?e?)?$',
				'^marseille vii(em?e?)?$',
				'^marseille viii(em?e?)?$',
				'^marseille ix(em?e?)?$',
				'^marseille x(em?e?)?$',
				'^marseille xi(em?e?)?$',
				'^marseille xii(em?e?)?$',
				'^marseille xiii(em?e?)?$',
				'^marseille ([1-9])(em?e?)?$',
				'^marseille ([1-9])(er?)?$',
				'^marseille ([1-2][0-9])(em?e?)?$',
				'^marseille ([1-2][0-9])(er?)?$',
				'^lyon i(er?)?$',
				'^lyon ii(em?e?)?$',
				'^lyon iii(em?e?)?$',
				'^lyon iv(em?e?)?$',
				'^lyon v(em?e?)?$',
				'^lyon vi(em?e?)?$',
				'^lyon vii(em?e?)?$',
				'^lyon viii(em?e?)?$',
				'^lyon ix(em?e?)?$',
				'^lyon ([1-9])(em?e?)?$',
				'^lyon ([1-9])(er?)?$',
				'^lyon ([1-2][0-9])(em?e?)?$',
				'^lyon ([1-2][0-9])(er?)?$',
				'^idf$',
				'(^| )st ',
				'(^| )ste ',
				'^2a$',
				'^2b$',
				'^([ a-z]+) ([0-9]+)$',
				'^([0-9]+) ([ a-z]+)$'];
	
	remplacer=['provence alpes cote d azur',
				'',
				'$1',
				'$1',
				'75001 paris',
				'75002 paris',
				'75003 paris',
				'75004 paris',
				'75005 paris',
				'75006 paris',
				'75007 paris',
				'75008 paris',
				'75009 paris',
				'75010 paris',
				'75011 paris',
				'75012 paris',
				'75013 paris',
				'75014 paris',
				'75015 paris',
				'75016 paris',
				'75017 paris',
				'75018 paris',
				'75019 paris',
				'75020 paris',
				'7500$1 paris',
				'7500$1 paris',
				'750$1 paris',
				'750$1 paris',
				'13001 marseille',
				'13002 marseille',
				'13003 marseille',
				'13004 marseille',
				'13005 marseille',
				'13006 marseille',
				'13007 marseille',
				'13008 marseille',
				'13009 marseille',
				'13010 marseille',
				'13011 marseille',
				'13012 marseille',
				'13013 marseille',
				'1300$1 marseille',
				'1300$1 marseille',
				'130$1 marseille',
				'130$1 marseille',
				'69001 lyon',
				'69002 lyon',
				'69003 lyon',
				'69004 lyon',
				'69005 lyon',
				'69006 lyon',
				'69007 lyon',
				'69008 lyon',
				'69009 lyon',
				'690$01 lyon',
				'6900$1 lyon',
				'690$1 lyon',
				'690$1 lyon',
				'ile de france',
				'$1saint ',
				'$1sainte ',
				'corse du sud',
				'haute corse',
				'$2 $1',
				'$1 $2'];
	
	chaine=js_localisation_formater(parent.val());
	for(i=0;i<chercher.length;i++)
	{
		var regexp=new RegExp(chercher[i],'g');
		chaine=chaine.replace(regexp,remplacer[i])
	}
	
	if(chaine==' ' || chaine=='') return '';
	
	if(!localisationJSON[chaine.substring(0,1)])
	{
		$.ajax({url:'/public/localisation/localisation-'+chaine.substring(0,1)+'.json', success:function(data){
			localisationJSON[chaine.substring(0,1)]=data;
			enfant.removeAttr('text');
			js_localisation_maj(parent,enfant);
			js_localisation_ouvrir(parent,enfant);
		}});
		
		return '';
	}
	else
	{
		var json=localisationJSON[chaine.substring(0,1)];
		var resultat='';
		for(i=0,j=0;j<maximum && i<json.length;i++)
		{
			ville=js_localisation_formater(json[i]['text']);
			if(ville.indexOf(chaine)==0)
			{
				regexp=new RegExp('(^'+js_localisation_expressionner(chaine)+')','i');
				
				resultat+='<li js-localisation-value="'+json[i]['value']+'">'+json[i]['text'].replace(regexp,'<strong>$1</strong>')+'</li>'
				j++;
				trouve=true;
			}
			else if(ville.indexOf(' '+chaine)!=-1)
			{
				regexp=new RegExp('([^a-z0-9àáâãäåçèéêëìíîïğòóôõöùúûüıÿ]'+js_localisation_expressionner(chaine)+')','i');
				
				resultat+='<li js-localisation-value="'+json[i]['value']+'">'+json[i]['text'].replace(regexp,'<strong>$1</strong>')+'</li>'
				j++;
				trouve=true;
			}
		}
		
		if(resultat) resultat='<ul>'+resultat+'</ul>';
		return resultat;
	}
}

function js_localisation_maj(parent,enfant)
{
	if(parent.val()!=enfant.attr('text'))
	{
		enfant.html(js_localisation_rechercher(parent,enfant,30));
		
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
				//.css('display','none')
				.bind('mouseover',function(){$(this).attr('survol',1)})
				.bind('mouseout',function(){$(this).attr('survol',0)});
		}
		
		var parent=$(this);
		var enfant=$('#'+$(this).attr('js-localisation-id'));
		
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