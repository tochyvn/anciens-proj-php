(function($){
	$.fn.removeAnnonce=function(){
		return this.each(function(){
			$(this).trigger('removeAnnonce');
		});
	};
	
	$.fn.annonce=function(){
		return this.each(function(){
			if(typeof $(this).data('annonce')=='undefined'){
				var $this=$(this);
				var $input=$this.find('input');
				
				$this.data('annonce','annonce');
				$this.attr('annonce','annonce');
				
				with($input){
					var $input_change=function(){
						$this.trigger('click');
					}
					var $input_remove=function(){
						$input.unbind('change',$input_change);
						$input.unbind('remove',$input_remove);
					}
					bind('change',$input_change);
					bind('remove',$input_remove);
				}
				
				with($this){
					var $this_click=function(){
						if($input.is(':checked'))
							$input.prop('checked',false);
						else
							$input.prop('checked',true);
						
						$this.trigger('change');
						$this.trigger('refresh');
					}
					var $this_refresh=function(){
						if($input.is(':checked')){
							$this.addClass('checked');
							$this.removeClass('unchecked');
						}
						else{
							$this.addClass('unchecked');
							$this.removeClass('checked');
						}
					}
					var $this_remove=function(){
						$this.unbind('click',$this_click);
						$input.unbind('refresh',$this_refresh);
						$this.unbind('removeAnnonce',$this_remove);
						$this.removeAttr('annonce');
						removeData('annonce');
						
						$input.trigger('remove');
					};
					
					css('cursor','pointer');
					bind('click',$this_click);
					bind('refresh',$this_refresh);
					bind('removeAnnonce',$this_remove);
					
				}
			}
		});
	}
})(jQuery);
