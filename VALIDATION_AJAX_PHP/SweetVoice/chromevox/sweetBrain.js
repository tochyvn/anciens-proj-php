var withConfirmation = false;
$(document).ready(function() {
	
	var speech = new webkitSpeechRecognition();
	var i=0;
	chrome.tts.speak('Maintenez la touche: Effe. Puis énnoncez votre demande.');
	$(document).keydown(function(e)
	{
		if ((e.which == 70 || e.keyCode == 70) && (i==0))
		{ 
			speech.start();
			i++;
			$('#result').val("");
			//chrome.experimental.speechInput.onSoundStart.addListener(function() {alert('ok');});
		}
	}).keyup(function(e)
	{
		speech.stop();
		i=0;
	});
	$('#vocalcmd').bind('input',function(){
		doSearch($('#vocalcmd').val());
	});
	var final_transcript = '';
	var nError=0;
	speech.onresult = function(event) {
		final_transcript = '';
		var interim_transcript = '';
		for (var i = event.resultIndex; i < event.results.length; ++i) {
		  if (event.results[i].isFinal) {
			final_transcript += event.results[i][0].transcript;
		  } else {
			interim_transcript += event.results[i][0].transcript;
		  }
		}
		var mot = final_transcript;
		var varr = final_transcript.split(' ');
		var command = varr.join(' ');
		var action = varr[0];
		var found = false;
		var newpage = false;
		
				
/* ---------------------------------------------------------------------------------------  */
/* ----------------------- Fonctions liées à la recherche --------------------------------  */
/* ---------------------------------------------------------------------------------------  */

		//recherche sur Google
		if( action=='chercher' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://www.google.fr/#hl=fr&safe=off&output=search&q=' + encodeURIComponent(mySearch);
			var confirmation = 'Chercher '+ mySearch + ' sur Google ?';
		}
		
		//recherche sur wikipedia
		if( action=='Wikipedia' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://fr.wikipedia.org/wiki/' + encodeURIComponent(mySearch);
			var confirmation = 'Wikipedia'+ mySearch;
		}
		
		//recherche sur le bon coin
		if( action=='leboncoin' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://www.leboncoin.fr/annonces/offres/provence_alpes_cote_d_azur/occasions/?f=a&th=1&q=' + encodeURIComponent(mySearch);
			var confirmation = 'leboncoin'+ mySearch;
		}
		
/* ---------------------------------------------------------------------------------------  */
/* --------------------------------- Raccourcis Vocaux VIDEO -----------------------------  */
/* ---------------------------------------------------------------------------------------  */

		// recherche d'une vidéo sur youtube
		if( action=='Youtube' || action=='YouTube') {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://www.youtube.com/results?search_query=' + encodeURIComponent(mySearch);
			var confirmation = 'recherche vidéo '+ mySearch + ' sur you tube ?';
		}
		
		//rechercher une vidéo sur dailymotion
		if( action=='dailymotion' || action=='Dailymotion') {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://www.dailymotion.com/fr/relevance/search/'+ encodeURIComponent(mySearch);
			var confirmation = 'recherche vidéo '+ mySearch + ' sur dailymotion ?';
		}
		
/* ---------------------------------------------------------------------------------------  */
/* --------------------------------- Raccourcis Messagerie   -----------------------------  */
/* ---------------------------------------------------------------------------------------  */

		// Aller sur Gmail
		if( action=='Gmail') {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://accounts.google.com/ServiceLogin?service=mail&passive=true&rm=false&continue=https://mail.google.com/mail/&ss=1&scc=1&ltmpl=default&ltmplcache=2';
			
		}
		
		// Aller sur Hotmail
		if( action=='Hotmail') {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://login.live.com/login.srf?wa=wsignin1.0&rpsnv=11&ct=1372204342&rver=6.1.6206.0&wp=MBI&wreply=http:%2F%2Fmail.live.com%2Fdefault.aspx&lc=1036&id=64855&mkt=fr-fr&cbcxt=mai&snsc=1';
			
		}
		
		// Aller sur Outlook
		if( action=='Outlook') {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://login.live.com/login.srf?wa=wsignin1.0&rpsnv=11&ct=1372204342&rver=6.1.6206.0&wp=MBI&wreply=http:%2F%2Fmail.live.com%2Fdefault.aspx&lc=1036&id=64855&mkt=fr-fr&cbcxt=mai&snsc=1';
			
		}
		
		// Aller sur la messagerie Yahoo
		if( action=='Yahoo messagerie') {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://login.yahoo.com/config/mail?&.src=ym&.intl=fr';
			
		}
		
/* ---------------------------------------------------------------------------------------  */
/* --------------------------------- Autres Liens ----------------------------------------  */
/* ---------------------------------------------------------------------------------------  */
		
		//Lance BattleLog de BF3
		if( mot=='Battlefield 3' ) {
		
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://battlelog.battlefield.com/bf3/';
	
		}
		
		//Allez sur le site d'enovae
		if( mot=='innova' ) {
		
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://www.novae.info/v4/etudiants/nov1_logetu.php';
		}
		
		//Aller sur le site du zero
		if( mot=='le site du zéro' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://www.siteduzero.com/';
	
		}
		
		//La météo du moment
		if( mot=='météo du jour' ) {
			varr[0]='';
			found = true;
			//newpage = true;
			var mySearch = varr.join(' ');
			
			chrome.tts.speak('Voici les prévision météo.Sur les deux tiers nord du pays, le temps sera couvert le matin, il pleuvra par intermittence. Les pluies seront faibles mais plus fréquentes du Nord au Massif central et aux Alpes. Il fera bien frais pour un début dété sur ces régions, les températures maximales plafonneront entre 14 et 17 degrés en général, 18 à Paris, Lille et Lyon. Il neigera vers 2200 m. En plaine dAlsace abritée par les Vosges, les pluies seront rares et on atteindra les 20 degrés à Strasbourg. Sur la moitié ouest, il fera 18 à 21 degrés de Brest à Bordeaux et Toulouse. Il pleuvra un peu le matin sur le quart nord-ouest, un temps plus sec avec de timides éclaircies simposera laprès-midi. Inversement sur le Sud-Ouest, après des éclaircies matinales le ciel se couvrira avec quelques gouttes. De la Provence au Roussillon, mitral et tramontane seront sensibles, le ciel peu nuageux mais là encore il ne fera pas très chaud avec 23 à 25 degrés. Des averses seront possibles sur les Alpes frontalières laprès-midi. ')
			
		}
		//Site de meteo france
		if( mot=='météo' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://france.meteofrance.com/';
		}
		//Musique sur 8 tracks
		if( mot=='musique' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://8tracks.com/';
	
		}
		
		//8 tracks metal step
		if( mot=='musique qui tue' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://8tracks.com/rahul-flint/metal-step';
		}	
		
		
		//Bf3 In Game
		if( mot=='jouer à Battlefield 3' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'http://battlelog.battlefield.com/bf3/servers/show/pc/4655d137-b08b-411e-a835-7a5495cc51c2/UN-NOOBS-IN-A-BOX-UN-UNITEDNOOBS/';
		}	
		
		//fin de la soutenance
		if( mot=='soutenance terminé' ) {
			varr[0]='';
			found = true;
			//newpage = true;
			var mySearch = varr.join(' ');
			chrome.tts.speak('Merci pour votre ecoute. Madame Vallet. Meussieu Fare jon. Meussieu Rit Gua . Et Meussieu Chelle Mis niake vous remercie. Ils sont maintenant disponible pour répondre à vos éventuel questions. A bientot')
			
		}
		//Ou suis je ?
		if( mot=='où suis-je' ) {
			varr[0]='';
			found = true;
			//newpage = true;
			var mySearch = varr.join(' ');
			chrome.tts.speak('Vous êtes derrière votre ordinateur.')
			
		}
/* ---------------------------------------------------------------------------------------  */
/* --------------------------------- Gadgets Google --------------------------------------  */
/* ---------------------------------------------------------------------------------------  */
		
		//Affiche les news
		if( mot=='news' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://news.google.fr/nwshp?hl=fr&tab=wn';
	
		}
		
		//Affiche l'agenda google
		if( mot=='agenda' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://accounts.google.com/ServiceLogin?service=cl&passive=1209600&continue=https://www.google.com/calendar/render?tab%3Dnc&followup=https://www.google.com/calendar/render?tab%3Dnc&scc=1';
	
		}
		
		//Affiche le store
		if( mot=='Google Store' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://chrome.google.com/webstore/category/apps?utm_source=chrome-ntp-icon';
	
		}
		//Affiche le store
		if( mot=='sur le store' ) {
			varr[0]='';
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = 'https://chrome.google.com/webstore/detail/sweetvoice/kpifnbjbiilhicpnghmbcboebhjnlfaf/SweetVoice';
	
		}


/* ---------------------------------------------------------------------------------------  */
/* ---------------------------------Fonctions liés au Navigateur--------------------------  */
/* ---------------------------------------------------------------------------------------  */
		
		
		//ouvrir une nouvelle fenêtre
		if( mot=='nouvelle fenêtre') {
			var mySearch = varr.join(' ');
			chrome.windows.create({url:'chrome-extension://ccliihiofbfdkphpnfgahhodomfnpdmj/chromevox/sweetBrain.html'});
		}
		//Fermer une fenêtre
		if( mot=='fermer fenêtre') {
			found=true;
			 // get the current window
			chrome.windows.getCurrent(function(win)
			{
				chrome.tabs.getCurrent(function(cur){
					var current = cur.id;
					// get an array of the tabs in the window
					chrome.tabs.getAllInWindow(win.id, function(tabs)
					{
						for (i in tabs) // loop over the tabs
						{
							
								// close it
								chrome.tabs.remove(tabs[i].id)
							
						}
					});
					chrome.tts.speak('Tous les onglets ont été fermés.');	
				});
			});	
		}
		
		
		// ouvrir un nouvel onglet
		if( mot=='nouvel onglet') {
			found = true;
			newpage = true;
			var mySearch = varr.join(' ');
			var url = ' ';
			
		}
		
		// Fermer les onglets
		if( mot=='fermer onglet') {
			found=true;
			 // get the current window
			chrome.windows.getCurrent(function(win)
			{
				chrome.tabs.getCurrent(function(cur){
					var current = cur.id;
					// get an array of the tabs in the window
					chrome.tabs.getAllInWindow(win.id, function(tabs)
					{
						for (i in tabs) // loop over the tabs
						{
							 // if the tab is not the selected one
							if (tabs[i].id != current)
							{
								// close it
								chrome.tabs.remove(tabs[i].id)
							}
						}
					});
					chrome.tts.speak('Tous les onglets ont été fermés.');	
				});
			});	
		}
		
		
		//Aide
		if( mot=='memo' || mot=='mémo' ) {
			found = true;
			var mySearch = varr.join(' ');
			chrome.tts.speak('Pour chercher sur Gougueule. Dites. Chercher. Suivit de votre recherche. Pour chercher sur Youtube. Dites. Youtube. Suivit de votre recherche. Pour chercher sur Dailymocheune. Dites. Dailymocheune. Suivit de votre recherche. Pour ouvrir un nouvel onglet. Dites. Nouvel onglet. Pour fermer tous les onglets. Dites. Fermer Onglet. Pour ouvrir une fenêtre. Dites. Nouvelle fenêtre. Pour fermer une fenêtre. Dites. Fermer Fenêtre. Pour aller sur jai mail. Dites. Jai mail. Pour aller sur Houte louque. Dites. Houte louque. Pour consulter la météo. Dites météo. Pour connaitre les prévision du jour. Dites. météo du jour. ');
		}
		
/* ---------------------------------------------------------------------------------------  */
/* -------------------------------- Ouvre une page ---------------------------------------  */
/* ---------------------------------------------------------------------------------------  */
		
		
		
		
		
		if(found) {
			if(newpage){
				console.log(action);
				if(!withConfirmation || confirm(confirmation)) {
					window.open(url,'_blank')
					return false;
				}
				else {
					document.getElementById('s').value = '';
					return false;
				}
			}
		}
		else{
			if(nError<2)
			{
				chrome.tts.speak('Votre recherche n\'a pas aboutie, veuillez recommencer.');
				nError = nError + 1;
				
			}
			else
			{
				chrome.tts.speak('Pour obtenir de l\aide, dîtes. Mes mots.');
				nError = 0;
			}
		}
		$('#result').val(command);
	  };
	});