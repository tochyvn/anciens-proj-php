(function($){
	$.fn.removeTimer=function(){
		return this.each(function(){
			$(this).trigger('removeTimer');
		});
	};
	
	$.fn.timer=function(conf){
		return this.each(function(){
			if(typeof $(this).data('timer')=='undefined'){
				var $this=$(this);
				var $interval=null;
				var $timer=new Date($this.html().replace(/(.+[^a-z])?([a-z]+, [0-9]+ [a-z]+ [0-9]+ [0-9]+:[0-9]+:[0-9]+ (\+|\-)?[0-9]+).*/i,'$2'));
				
				$this.data('timer','timer');
				
				with($this){
					var $refresh=function(){
						
						$maintenant=Math.floor(new Date().getTime()/1000);
						$fin=Math.floor($timer.getTime()/1000);
						$restant=$fin-$maintenant;
						if($restant<0) $restant=0;
						
						nombre=$restant;
						seconde=nombre%60;
						nombre=Math.floor(nombre/60);
						minute=nombre%60;
						nombre=Math.floor(nombre/60);
						heure=nombre%24;
						nombre=Math.floor(nombre/24);
						jour=nombre;
						
						if(typeof conf.print=='function') $chaine=conf.print(jour,heure,minute,seconde);
						else $chaine=jour+'j '+heure+'h '+minute+'min '+seconde+'s';
						$this.html($chaine);
					};
					var $remove=function(mode){
						unbind('refresh',$refresh);
						unbind('removeTimer',$remove);
						clearInterval($interval);
						delete $interval;
						removeData('timer');
					};
					
					bind('refresh',$refresh);
					bind('removeTimer',$remove);
					
					trigger('refresh');
					$interval=setInterval(function(){trigger('refresh');},1000);
				}
			}
		});
	}
})(jQuery);
