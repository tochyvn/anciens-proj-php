(function($){
	$.fn.removeInputReset=function(){
		return this.each(function(){
			$(this).trigger('removeInputReset');
		});
	};
	
	$.fn.inputReset=function(conf){
		return this.each(function(){
			if(typeof $(this).data('inputreset')=='undefined'){
				var $this=$(this);
				var $label=$('<label>');
				
				$this.data('inputreset','inputreset');
				
				with($label){
					var $click=function(){
						$this.val('');
						$this.trigger('init');
						$this.trigger('focus');
					};
					var $refresh=function(){
						css('position','absolute');
						css('white-space','nowrap');
						css('overflow','hidden');
						css('cursor','pointer');
						
						css('padding','0');
						css('margin','0');
						css('border','none');
						
						css('margin-left',$this.outerWidth(true));
					};
					
					insertBefore($this);
					addClass(conf.classCSS);
					css('display','block');
					bind('click',$click);
					bind('refresh',$refresh);
					
					hide(0);
				}
				
				with($this){
					var $refresh=function(){$label.trigger('refresh')};
					var $change=function(){
						if(val()!=''){
							if(!$label.is(':visible')){
								css('width','-='+parseInt($label.css('width')));
								$label.show(0);
								trigger('refresh');
							}
						}
						else{
							if($label.is(':visible')){
								css('width','+='+parseInt($label.css('width')));
								$label.hide(0);
								trigger('refresh');
							}
						}
					};
					var $remove=function(mode){
						unbind('refresh',$refresh);
						unbind('keypress keyup change input init',$change);
						unbind('removeInputReset',$remove);
						removeData('inputreset');
						if($label.is(':visible')) css('width','+='+parseInt($label.css('width')));
						
						$label.remove();
					};
					
					bind('refresh',$refresh);
					bind('keypress keyup change input init',$change);
					bind('removeInputReset',$remove);
					
					trigger('init');
				}
			}
		});
	}
})(jQuery);
