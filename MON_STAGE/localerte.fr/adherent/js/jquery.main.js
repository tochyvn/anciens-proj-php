//AVANT LE TRAITEMENT DES DONNEES
(function($){
	$.msgbox_desabonnement=function(url){$.msgBox({classCSS:'msgbox msgbox-desabonnement',html:'<iframe src="'+url+'"></iframe>','close':function(){window.location.href='http://www.localerte.fr/adherent/ma-liste.php';},'success':function(){}});}
	$.msgbox_nous_contacter=function(url){$.msgBox({classCSS:'msgbox msgbox-nous-contacter',html:'<iframe src="'+url+'"></iframe>','close':function(){},'success':function(){}});}
	$.msgbox_mot_de_passe=function(url){$.msgBox({classCSS:'msgbox msgbox-mot-de-passe',html:'<iframe src="'+url+'"></iframe>','close':function(){},'success':function(){}});}
	$.msgbox_cgv=function(url){$.msgBox({classCSS:'msgbox msgbox-cgv',html:'<iframe src="'+url+'"></iframe>','close':function(){},'success':function(){}});}
	$.msgbox_qsn=function(url){$.msgBox({classCSS:'msgbox msgbox-qsn',html:'<iframe src="'+url+'"></iframe>','close':function(){},'success':function(){}});}
	$.msgbox_esp=function(url){$.msgBox({classCSS:'msgbox msgbox-esp',html:'<iframe src="'+url+'"></iframe>','close':function(){},'success':function(){}});}
	$.msgbox_mon_compte=function(url){$.msgBox({classCSS:'msgbox msgbox-mon-compte',html:'<iframe src="'+url+'"></iframe>','close':function(){},'success':function(){}});}
	$.msgbox_signaler_une_erreur=function(url){$.msgBox({classCSS:'msgbox msgbox-signaler-une-erreur',html:'<iframe src="'+url+'"></iframe>','close':function(){}});}
	$.msgbox_mon_alerte=function(url){$.msgBox({classCSS:'msgbox msgbox-mon-alerte',html:'<iframe src="'+url+'"></iframe>','close':function(){window.location.href='http://www.localerte.fr/adherent/ma-liste.php'},'success':function(){}});}
	$.msgbox_suppression_alerte=function(url){$.msgBox({classCSS:'msgbox msgbox-suppression-alerte',html:'<iframe src="'+url+'"></iframe>','close':function(){window.location.href=window.location.href;},'success':function(){}});}
	$.msgbox_message=function(html){$.msgBox({classCSS:'msgbox msgbox-message','html':html,'close':function(){},'success':function(){}});}
	$.msgbox_code_1=function(url){$.msgBox({classCSS:'msgbox msgbox-code-1',html:'<iframe src="'+url+'"></iframe>','close':function(){},'success':function(){}});}
	$.msgbox_code_2=function(url){$.msgBox({classCSS:'msgbox msgbox-code-2',html:'<iframe src="'+url+'"></iframe>','close':function(){},'success':function(){}});}
	
	$('[name="tarif_abonnement_identifiant"]').bind('click change init',function(){
		if(parseInt($(this).parent().find('em').html())<=30)
			$('[name="paiement_mode_wha"]').css('display','block');
		else
			$('[name="paiement_mode_wha"]').css('display','none');
	});
	$('[name="tarif_abonnement_identifiant"]:checked').trigger('init');
	
	$.refresh=function(){
		
		$(':input[placeholder]').placeHolder({classCSS:'placeholder'});
		$(':input.inputreset').inputReset({classCSS:'inputreset'});
		$(':input.selectdefault').selectDefault({selectCSS:'selectdefault',optionCSS:'selectdefault',defaultValue:'',cancelHtml:'Annulez mon choix',cancelCSS:'cancel'});
		$('.timer').timer({});
		$('.timer-bis').timer({'print':function(jour,heure,minute,seconde){
			if(jour>1) return jour+' jours';
			else if(jour==1) return jour+' jour';
			else if(heure) return heure+'h '+minute+'min';
			else if(minute) return minute+'min '+seconde+'s';
			else return seconde+'s';
		}});
		
		$('.desabonnement:not([msgbox])').attr('msgbox','desabonnement').bind('click',function(event){$.msgbox_desabonnement($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.nous-contacter:not([msgbox])').attr('msgbox','nous-contacter').bind('click',function(event){$.msgbox_nous_contacter($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.mot-de-passe:not([msgbox])').attr('msgbox','mot-de-passe').bind('click',function(event){$.msgbox_mot_de_passe($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.conditions-generales-de-vente:not([msgbox])').attr('msgbox','conditions-generales-de-vente').bind('click',function(event){$.msgbox_cgv($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.qui-sommes-nous:not([msgbox])').attr('msgbox','qui-sommes-nous').bind('click',function(event){$.msgbox_qsn($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.en-savoir-plus:not([msgbox])').attr('msgbox','en-savoir-plus').bind('click',function(event){$.msgbox_esp($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.mon-compte:not([msgbox])').attr('msgbox','mon-compte').bind('click',function(event){$.msgbox_mon_compte($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.signaler-une-erreur:not([msgbox])').attr('msgbox','signaler-une-erreur').bind('click',function(event){$.msgbox_signaler_une_erreur($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.mon-alerte:not([msgbox])').attr('msgbox','mon-alerte').bind('click',function(event){$.msgbox_mon_alerte($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.suppression-alerte:not([msgbox])').attr('msgbox','suppression-alerte').bind('click',function(event){$.msgbox_suppression_alerte($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.message:not([msgbox])').attr('msgbox','message').bind('click',function(event){$.msgbox_message($(this).html()); event.stopPropagation(); event.preventDefault();});
		$('.code-1:not([msgbox])').attr('msgbox','code-1').bind('click',function(event){$.msgbox_code_1($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		$('.code-2:not([msgbox])').attr('msgbox','code-2').bind('click',function(event){$.msgbox_code_2($(this).attr('href')); event.stopPropagation(); event.preventDefault();});
		
		var conf={
			'formater':{
				'entree':[[['[àáâãäåa]'],['gi']], [['[çc]'],['gi']], [['[èéêëe]'],['gi']], [['[ìíîïi]'],['gi']], [['[ðòóôõöo]'],['gi']], [['[ùúûüu]'],['gi']], [['[ýÿy]'],['gi']], [['[^a-z0-9]+'],['gi']], [[' +'],['g']], [['^ /']], [['A'],['g']], [['B'],['g']], [['C'],['g']], [['D'],['g']], [['E'],['g']], [['F'],['g']], [['G'],['g']], [['H'],['g']], [['I'],['g']], [['J'],['g']], [['K'],['g']], [['L'],['g']], [['M'],['g']], [['N'],['g']], [['O'],['g']], [['P'],['g']], [['Q'],['g']], [['R'],['g']], [['S'],['g']], [['T'],['g']], [['U'],['g']], [['V'],['g']], [['W'],['g']], [['X'],['g']], [['Y'],['g']], [['Z'],['g']]],
				'sortie':['a', 'c', 'e', 'i', 'o', 'u', 'y', ' ', ' ', '', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z']
			},
			'expressionner':{
				'entree':[[['[àáâãäåa]'],['g']], [['[çc]'],['g']], [['[èéêëe]'],['g']], [['[ìíîïi]'],['g']], [['[ðòóôõöo]'],['g']], [['[ùúûüu]'],['g']], [['[ýÿy]'],['g']], [['[ ]'],['g']]],
				'sortie':['[àáâãäåa]', '[çc]', '[èéêëe]', '[ìíîïi]', '[ðòóôõöo]', '[ùúûüu]', '[ýÿy]', '[^a-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ]+']
			},
			'masquer':{
				'entree':[[['^p ?a ?c ?a$'],['gi']], [['^ '],['gi']], [[' (eme( |$))'],['gi']], [[' (er( |$))'],['gi']], [['^paris i(er?)?$'],['gi']], [['^paris ii(em?e?)?$'],['gi']], [['^paris iii(em?e?)?$'],['gi']], [['^paris iv(em?e?)?$'],['gi']], [['^paris v(em?e?)?$'],['gi']], [['^paris vi(em?e?)?$'],['gi']], [['^paris vii(em?e?)?$'],['gi']], [['^paris viii(em?e?)?$'],['gi']], [['^paris ix(em?e?)?$'],['gi']], [['^paris x(em?e?)?$'],['gi']], [['^paris xi(em?e?)?$'],['gi']], [['^paris xii(em?e?)?$'],['gi']], [['^paris xiii(em?e?)?$'],['gi']], [['^paris xiv(em?e?)?$'],['gi']], [['^paris xv(em?e?)?$'],['gi']], [['^paris xvi(em?e?)?$'],['gi']], [['^paris xvii(em?e?)?$'],['gi']], [['^paris xviii(em?e?)?$'],['gi']], [['^paris xix(em?e?)?$'],['gi']], [['^paris xx(em?e?)?$'],['gi']], [['^paris ([1-9])(em?e?)?$'],['gi']], [['^paris ([1-9])(er?)?$'],['gi']], [['^paris ([1-2][0-9])(em?e?)?$'],['gi']], [['^paris ([1-2][0-9])(er?)?$'],['gi']], [['^marseille i(er?)?$'],['gi']], [['^marseille ii(em?e?)?$'],['gi']], [['^marseille ii(em?e?)?$'],['gi']], [['^marseille iv(em?e?)?$'],['gi']], [['^marseille v(em?e?)?$'],['gi']], [['^marseille vi(em?e?)?$'],['gi']], [['^marseille vii(em?e?)?$'],['gi']], [['^marseille viii(em?e?)?$'],['gi']], [['^marseille ix(em?e?)?$'],['gi']], [['^marseille x(em?e?)?$'],['gi']], [['^marseille xi(em?e?)?$'],['gi']], [['^marseille xii(em?e?)?$'],['gi']], [['^marseille xiii(em?e?)?$'],['gi']], [['^marseille ([1-9])(em?e?)?$'],['gi']], [['^marseille ([1-9])(er?)?$'],['gi']], [['^marseille ([1-2][0-9])(em?e?)?$'],['gi']], [['^marseille ([1-2][0-9])(er?)?$'],['gi']], [['^lyon i(er?)?$'],['gi']], [['^lyon ii(em?e?)?$'],['gi']], [['^lyon iii(em?e?)?$'],['gi']], [['^lyon iv(em?e?)?$'],['gi']], [['^lyon v(em?e?)?$'],['gi']], [['^lyon vi(em?e?)?$'],['gi']], [['^lyon vii(em?e?)?$'],['gi']], [['^lyon viii(em?e?)?$'],['gi']], [['^lyon ix(em?e?)?$'],['gi']], [['^lyon ([1-9])(em?e?)?$'],['gi']], [['^lyon ([1-9])(er?)?$'],['gi']], [['^lyon ([1-2][0-9])(em?e?)?$'],['gi']], [['^lyon ([1-2][0-9])(er?)?$'],['gi']], [['^idf$'],['gi']], [['(^| )st '],['gi']], [['(^| )ste '],['gi']], [['^2a$'],['gi']], [['^2b$'],['gi']], [['^([ a-z]+) ([0-9]+)$'],['gi']], [['^([0-9]+) ([ a-z]+)$'],['gi']]],
				'sortie':['provence alpes cote d azur', '', '$1', '$1', '75001 paris', '75002 paris', '75003 paris', '75004 paris', '75005 paris', '75006 paris', '75007 paris', '75008 paris', '75009 paris', '75010 paris', '75011 paris', '75012 paris', '75013 paris', '75014 paris', '75015 paris', '75016 paris', '75017 paris', '75018 paris', '75019 paris', '75020 paris', '7500$1 paris', '7500$1 paris', '750$1 paris', '750$1 paris', '13001 marseille', '13002 marseille', '13003 marseille', '13004 marseille', '13005 marseille', '13006 marseille', '13007 marseille', '13008 marseille', '13009 marseille', '13010 marseille', '13011 marseille', '13012 marseille', '13013 marseille', '1300$1 marseille', '1300$1 marseille', '130$1 marseille', '130$1 marseille', '69001 lyon', '69002 lyon', '69003 lyon', '69004 lyon', '69005 lyon', '69006 lyon', '69007 lyon', '69008 lyon', '69009 lyon', '690$01 lyon', '6900$1 lyon', '690$1 lyon', '690$1 lyon', 'ile de france', '$1saint ', '$1sainte ', 'corse du sud', 'haute corse', '$2 $1', '$1 $2']
			},
			'maximum':20,
			'condition':[['^[0-9a-zA-Z]{2}'],['']],
			'longueur':2,
			'classe':'json-localisation-popup',
			'json':'http://www.localerte.fr/adherent/json/localisation-INDEX.json',
			'hidden':$('[name="alerte_ville"]')
		};
	
		$('.json-localisation').findJSON(conf);
		$('.resultat').each(function(){$(this).ajaxReplace({url:$(this).attr('href'),'find':'#resultat','event':'click',html:'...: Attente de la réponse :...'}).attr('href','javascript:void(0);');});
		$('.pre-annonce').annonce();
		
		if($('#adsearch-01').length){
			conf={
				'option':{'pubId':'pub-9592588828246820','query':$('#adsearch-01').attr('title'),'channel':'0901693454','hl':'fr','linkTarget':'_blank'},
				'bloc':[
					{'container':'adsearch-01','number':'2','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'},
					{'container':'adsearch-02','number':'2','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'},
					{'container':'adsearch-03','number':'2','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'},
					{'container':'adsearch-04','number':'2','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'}
			]};
			$.adsearch(conf);
		}
		if($('#adsearch-05').length){
			conf={
				'option':{'pubId':'pub-9592588828246820','query':$('#adsearch-05').attr('title'),'channel':'0901693454','hl':'fr','linkTarget':'_blank'},
				'bloc':[
					{'container':'adsearch-05','number':'2','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'},
					{'container':'adsearch-06','number':'2','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'},
					{'container':'adsearch-07','number':'2','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'},
					{'container':'adsearch-08','number':'2','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'}
			]};
			$.adsearch(conf);
		}
		if($('#adsearch-09').length){
			conf={
				'option':{'pubId':'pub-9592588828246820','query':$('#adsearch-09').attr('title'),'channel':'0901693454','hl':'fr','linkTarget':'_blank'},
				'bloc':[{'container':'adsearch-09','number':'4','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'}]};
			$.adsearch(conf);
		}
		if($('#adsearch-10').length){
			conf={
				'option':{'pubId':'pub-9592588828246820','query':$('#adsearch-10').attr('title'),'channel':'0901693454','hl':'fr','linkTarget':'_blank'},
				'bloc':[{'container':'adsearch-10','number':'4','colorTitleLink':'#1c5290','colorText':'#777777','colorDomainLink':'#777777','fontSizeTitle':'12','fontSizeDescription':'11','fontSizeDomainLink':'11','siteLinks':false,'colorBackground':'#f2f2f2'}]};
			$.adsearch(conf);
		}
		
		//conf={
		//	'selector':'#adsense-7693851696',
		//	'param':{'google_ad_client':'ca-pub-9592588828246820','google_ad_slot':'7693851696','google_ad_width':728,'google_ad_height':90}
		//}
		//$.adsense(conf);
	};
	
	$(window).bind('resize',function(){$(':not(document)').trigger('refresh');})
})(jQuery);

//APRES LE TRAITEMENT DES DONNEES
$(window).load(function(){
	//
	if(window.location.href.search('bienvenue.php')!=-1 && window.self!=window.top)
		window.top.location.href='http://www.localerte.fr/adherent/bienvenue.php';
	
	//
	$('[autofocus]').autoFocus();
	$.refresh();
	
	//
	var $input_tout=$('<input type="checkbox" name="annonce_tout" value="1">');
	$('.nom-colonne .colonne1').html($input_tout);
	$input_tout.bind('change',function(){
		$input_tout.prop('checked',$(this).is(':checked'));
		
		$('[name="annonce_identifiant\[\]"]').prop('checked',!$(this).is(':checked'));
		$('.pre-annonce').trigger('click');
	});
	
	//
	$('.ma-liste [name="annonce_submit"]').bind('click',function(event){
		if(!$('[name="annonce_identifiant\[\]"]').is(':checked')){
			$('[name="annonce_identifiant\[\]"]').prop('checked',true);
			//alert('Erreur: cochez d\'abord une annonce');
			//event.stopPropagation();
			//event.preventDefault();
		}
	})
	
	
	
	//
	//$orange=(window.location.href.search('bienvenue.php')!=-1 || window.location.href.search('ma-premiere-alerte.php')!=-1);
	//conf=[{
	//		'backgroundImage':'url(http://static.localerte.fr/adherent/img/fond'+($orange?'-orange':'')+'-005.jpg)',
	//		'backgroundAttachment':'fixed',
	//		'backgroundPosition':'top center',
	//		'backgroundRepeat':'no-repeat',
	//},{
	//		'backgroundImage':'url(http://static.localerte.fr/adherent/img/fond'+($orange?'-orange':'')+'-003.jpg)',
	//		'backgroundAttachment':'fixed',
	//		'backgroundPosition':'top center',
	//		'backgroundRepeat':'no-repeat',
	//},{
	//		'backgroundImage':'url(http://static.localerte.fr/adherent/img/fond'+($orange?'-orange':'')+'-004.jpg)',
	//		'backgroundAttachment':'fixed',
	//		'backgroundPosition':'top center',
	//		'backgroundRepeat':'no-repeat',
	//},{
	//		'backgroundImage':'url(http://static.localerte.fr/adherent/img/fond'+($orange?'-orange':'')+'-005.jpg)',
	//		'backgroundAttachment':'fixed',
	//		'backgroundPosition':'top center',
	//		'backgroundRepeat':'no-repeat',
	//}];
	//try{
	//	if(!$.storage.existSession('bg-body')) $.storage.setSession('bg-body',Math.floor(Math.random()*conf.length));
	//	$('body:not(.no-bg-image)').randCSS([conf[$.storage.getSession('bg-body')]]);
	//}
	//catch(error){
	//	if(error.code===DOMException.QUOTA_EXCEEDED_ERR && sessionStorage.length===0)//BUG SAFARI
	//	  $('body:not(.no-bg-image)').randCSS([conf[0]]);
	//}
	
	//
  	var resultat=window.location.href.match(/msgbox_query=([^&#]+)/);
	if(window.location.href.search('msgbox=desabonnement')!=-1) $.msgbox_desabonnement('http://www.localerte.fr/adherent/desabonnement.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=nous-contacter')!=-1) $.msgbox_nous_contacter('http://www.localerte.fr/adherent/nous-contacter.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=mot-de-passe')!=-1) $.msgbox_mot_de_passe('http://www.localerte.fr/adherent/mot-de-passe-oublie.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=cgv')!=-1) $.msgbox_cgv('http://www.localerte.fr/adherent/conditions-generales-de-vente.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=qsn')!=-1) $.msgbox_qsn('http://www.localerte.fr/adherent/qui-sommes-nous.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=esp')!=-1) $.msgbox_esp('http://www.localerte.fr/adherent/en-savoir-plus.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=mon-compte')!=-1) $.msgbox_mon_compte('http://www.localerte.fr/adherent/mon-compte.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=signaler-une-erreur')!=-1) $.msgbox_signaler_une_erreur('http://www.localerte.fr/adherent/signaler-une-erreur.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=mon-alerte')!=-1) $.msgbox_mon_alerte('http://www.localerte.fr/adherent/mon-alerte.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=suppression-alerte')!=-1) $.msgbox_suppression_alerte('http://www.localerte.fr/adherent/suppression-alerte.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=message')!=-1 && resultat) $.msgbox_message(decodeURIComponent(resultat[1].replace(/\+/g,'%20')));
	if(window.location.href.search('msgbox=code-1')!=-1) $.msgbox_code_1('http://www.localerte.fr/adherent/code-1.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(window.location.href.search('msgbox=code-2')!=-1) $.msgbox_code_2('http://www.localerte.fr/adherent/code-2.php'+(resultat?'?'+decodeURIComponent(resultat[1].replace(/\+/g,'%20')):''));
	if(typeof msgbox_message=='string') $.msgBox({classCSS:'msgbox msgbox-message',html:msgbox_message,'close':function(){},'success':function(){}});
});

//ANALYTICS
(function(i,s,o,g,r,a,m){
	
	i['GoogleAnalyticsObject']=r;
	i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();
	
	var a=s.createElement(o);
	a.async=1;
	a.src=g;
	$(window).bind('load',function(){
		document.body.appendChild(a);
	});
	
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-382336-7', 'www.localerte.fr');
ga('send', 'pageview');
