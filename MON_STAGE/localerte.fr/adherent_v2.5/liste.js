function js_liste_case()
{
	$('.js-liste-case').each(function(){
		if(!$(this).attr('js-liste-case'))
		{
			$(this)
				.attr('js-liste-case','js-liste-case')
				.html('<label style="cursor:pointer;"><input type="checkbox" name="" value="" />Toutes</label>');
			$('input',$(this)).bind('click',function(){
				if($('#js-liste-popup')) $('#js-liste-popup').remove();
				
				var checked=$(this).attr('checked');
				
				$('.js-liste-case input',$(this).parents('table')).each(function(){
					if(checked!=$(this).attr('checked'))
					{
						if(checked=='checked') $(this).attr('checked','checked');
						else $(this).removeAttr('checked');
					}
				});
				
				$('tr[id^="liste_ligne_"]',$(this).parents('table')).each(function(){
					if(checked!=$(this).attr('checked'))
					{
						if(checked=='checked') $(this).attr('checked','checked');
						else $(this).removeAttr('checked');
						js_liste_checkbox($(this));
					}
				});
			});
		}
	});
}

function js_liste_checkbox(objet)
{
	if(objet.attr('checked'))
	{
		objet.find('input').attr('checked','checked');
		objet.css('background','#F9D3AE');
	}
	else
	{
		objet.find('input').removeAttr('checked');
		if(objet.attr('class').search(/impair/)!=-1) objet.css('background','#F6F6F6');
		else  objet.css('background','#d7e3ef');
	}
}

function js_liste_popup(objet)
{
	if($('#js-liste-popup')) $('#js-liste-popup').remove();
	
	$('<TR />')
		.attr('id','js-liste-popup')
		.html('<td colspan="7">\
			<div style="background-image:url(/adherent/image/liste-popup-fond.png); padding:20px 10px 5px 70px; margin-top:-17px; overflow:visible;">\
			<p style="float:left; font-weight:normal; color:#FFF;">'+(objet.attr('checked')?
			'<strong style="color:#FFF;">Annonce ajout&eacute;e &agrave; votre s&eacute;lection</strong><br />Vous pouvez poursuivre votre s&eacute;lection ou consulter':
			'<strong style="color:#FFF;">Annonce d&eacute;s&eacute;lectionn&eacute;e</strong><br />'+($('tr[checked="checked"]',objet.parents('table')).length?'Vous pouvez poursuivre votre s&eacute;lection ou consulter':'Cochez les annonces &agrave; consulter'))+'</p>\
			'+($('tr[checked="checked"]',objet.parents('table')).length?'<p style="float:right; margin-right:10px; height:24px; padding-top:1px; background:#A12104;"><input type="submit" name="annonce_submit" value="Consulter" style="background:#A12104; width:131px; padding:3px; border:none; color:#FFF; font-weight:bold; float:right; cursor:pointer; margin:0px;" /></p>':'')+'\
			<p style="width:160px; line-height:25px; background-color:#FFF; text-align:center; color:#FF7602; float:right;">'+$('tr[checked="checked"]',objet.parents('table')).length+' annonce'+($('tr[checked="checked"]',objet.parents('table')).length>1?'s':'')+' coch&eacute;e'+($('tr[checked="checked"]',objet.parents('table')).length>1?'s':'')+'</p>\
			</div>\
		  </td>')
		.insertAfter(objet)
	
	$('#js-liste-popup td')
		.css('height',0)
		.css('padding',0)

	$('#js-liste-popup div')
		.css('height',0)
		.animate({height:30, opacity:1},300);
}

function js_liste_ligne()
{
	$('tr[id^="liste_ligne_"]').each(function(){
		if(!$(this).attr('js-liste-ligne'))
		{
			 $(this)
				.attr('js-liste-ligne','js-liste-ligne')
				.css('cursor','pointer')
				.css('z-index','10000')
				.bind('click',function(){
					if($(this).attr('checked')) $(this).removeAttr('checked');
					else $(this).attr('checked','checked');
					js_liste_checkbox($(this));
					js_liste_popup($(this));
				})
			js_liste_checkbox($(this));
		}
	});
	
	$('#js-liste-formulaire').bind('submit',function(e){
		if(!$('tr[checked="checked"]').length){
			alert('Sélectionnez vos annonces avant de cliquer sur "Consulter"');
			
			e.stopPropagation();
			e.preventDefault();
		}
	});
}

function js_liste_interrogation()
{
	$('.js-liste-interrogation')
		.css('float','right')
		.css('display','block')
		.css('width','16px')
		.css('height','16px')
		.css('line-height','16px')
		.css('padding','0px')
		.css('margin-top','0px')
		.css('text-align','center')
		.css('background','#fff')
		.css('color','#82a0c3')
		.css('cursor','pointer')
		.css('border-radius','10px')
		.bind('mouseover',function(){
			if($('#js-liste-popup2')) $('#js-liste-popup2').remove();
			$('<DIV />')
				.attr('id','js-liste-popup2')
				.appendTo($('body'))
				.css('border','1px solid #FFFFF6')
				.css('padding','10px')
				.css('background','#FFFF96')
				.css('text-align','left')
				.css('font-size','11px')
				.css('color','#666')
				.css('position','absolute')
				.css('top',$(this).offset().top+30)
				.css('left',$(this).offset().left-50)
				.css('width','200px')
				.css('box-shadow','0 0 3px #666')
				.html($(this).attr('title'));
			$(this).removeAttr('title');
		})
		.bind('mouseout',function(){
			if($('#js-liste-popup2'))
			{
				$(this).attr('title',$('#js-liste-popup2').html());
				$('#js-liste-popup2').remove();
			}
		});
}

function js_resultat(){
	$('.js-resultat a').bind('click',function(event){
		var id=$(this).attr('class').replace(/^js-resultat-(.+)$/,'$1');
		var objet=$(this);
		
		$(this).html('Attente de la r&eacute;ponse ...');
		$.ajax({url:$(this).attr('href'),success:function(data){
			objet.parents('tr').replaceWith($(data).find('#'+id+' tbody').html());
			js_liste_case();
			js_liste_ligne();
			js_liste_interrogation();
			js_resultat();
		}});
		
		event.stopPropagation();
		event.preventDefault();
	});
}

$(function(){js_resultat();});
$(function(){js_liste_case();});
$(function(){js_liste_ligne();});
$(function(){js_liste_interrogation();});
