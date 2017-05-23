(function($){
	$.fn.removeEtiquette=function(){
		return this.each(function(){
			$(this).trigger('removeEtiquette');
		});
	};
	
	$.fn.etiquette=function(conf){
		return this.each(function(){
			if(typeof $(this).data('etiquette')=='undefined'){
				var $this=$(this);
				
				with($this){
					var $refresh=function(){};
					var $update=function(){
						with($this){
							if(is('.selected')){
								css('cursor','');
								animate({'height':attr('hauteur')-1});
							}
							else{
								css('cursor','pointer');
								$this.css('height','52px');
							}
						}
					};
					var $selected=function(){
						$('[etiquette="etiquette"]').not($this).each(function(){$(this).addClass('unselected');});
						$('[etiquette="etiquette"]').not($this).each(function(){$(this).removeClass('selected');});
						$('[etiquette="etiquette"]').not($this).each(function(){$(this).trigger('update');});
						
						$this.addClass('selected');
						$this.removeClass('unselected');
						$this.trigger('update');
					}
					var $focus=function(){
						$this.trigger('selected');
					}
					var $click=function(){
						$(this).trigger('selected');
						if($this.find('.tarif a').length) window.open($this.find('.tarif a').attr('href'),'_self');
					};
					var $remove=function(mode){
						
						unbind('refresh',$refresh);
						unbind('update',$update);
						unbind('selected',$selected);
						unbind('click',$click);
						unbind('removeEtiquette',$remove);
						
						removeData('etiquette');
						removeAttr('etiquette');
						find('*').unbind('focus',$focus);
						
					};
					
					bind('refresh',$refresh);
					bind('update',$update);
					bind('selected',$selected);
					bind('click',$click);
					bind('removeEtiquette',$remove);
					
					data('etiquette','etiquette');
					attr('etiquette','etiquette');
					attr('hauteur',height());
					css('overflow','hidden');
					find('*').bind('focus',$focus);
					
					trigger('update');
				}
			}
		});
	}
})(jQuery);
