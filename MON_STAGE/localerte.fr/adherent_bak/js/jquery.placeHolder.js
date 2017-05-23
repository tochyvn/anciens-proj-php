(function($){
	$.hasPlaceholder='placeholder' in document.createElement('input');
	
	$.fn.removePlaceHolder=function(){
		return this.each(function(){
			$(this).trigger('removePlaceHolder');
		});
	};
	
	$.fn.placeHolder=function(conf){
		return this.each(function(){
			if(typeof($(this).data('placeholder'))=='undefined'){
				var $this=$(this);
				var $label=$('<label>');
				
				$this.data('placeholder','placeholder');
				
				with($label){
					
					var $click=function(){$this.trigger('focus');};
					var $refresh=function(){
						css('position','absolute');
						css('white-space','nowrap');
						css('overflow','hidden');
						css('font-size',$this.css('font-size'));
						css('text-align',$this.css('text-align'));
						
						css('padding-top',$this.css('padding-top'));
						css('padding-right',$this.css('padding-right'));
						css('padding-bottom',$this.css('padding-bottom'));
						css('padding-left',$this.css('padding-left'));
						
						css('margin-top',$this.css('margin-top'));
						css('margin-right',$this.css('margin-right'));
						css('margin-bottom',$this.css('margin-bottom'));
						css('margin-left',$this.css('margin-left'));
						
						css('border-top-width',$this.css('border-top-width'));
						css('border-right-width',$this.css('border-right-width'));
						css('border-bottom-width',$this.css('border-bottom-width'));
						css('border-left-width',$this.css('border-left-width'));
						
						css('width',$this.css('width'));
						css('height',$this.css('height'));
						css('line-height',$this.css('line-height'));
					};
					
					insertBefore($this);
					addClass(conf.classCSS);
					css('display','block');
					html($this.attr('placeholder'));
					bind('click',$click);
					bind('refresh',$refresh);
					
					hide(0);
				}
				
				with($this){
					
					$refresh=function(){$label.trigger('refresh')};
					$change=function(){
						if(val()!=''){
							if($label.is(':visible')){
								$label.hide(0);
								trigger('refresh');
							}
						}
						else{
							if(!$label.is(':visible')){
								$label.show(0);
								trigger('refresh');
							}
						}
					}
					$remove=function(mode){
						unbind('refresh',$refresh);
						unbind('keypress keyup change input init',$change);
						unbind('removePlaceHolder',$remove);
						attr('placeholder',attr('title'))
						removeData('placeholder');
						
						$label.remove();
					}
					
					attr('title',attr('placeholder'))
					attr('placeholder','');
					bind('refresh',$refresh);
					bind('keypress keyup change input resize init',$change);
					bind('removePlaceHolder',$remove);
					
					trigger('init');
				}
			}
		});
	}
})(jQuery);
