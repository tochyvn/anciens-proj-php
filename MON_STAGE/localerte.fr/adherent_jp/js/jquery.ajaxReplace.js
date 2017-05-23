(function($){
	$.fn.removeAjaxReplace=function(){
		return this.each(function(){
			$(this).trigger('removeAjaxReplace');
		});
	};
	
	$.fn.ajaxReplace=function(conf){
		return this.each(function(){
			if(typeof $(this).data('ajaxreplace')=='undefined'){
				var $this=$(this);
				
				$this.data('ajaxreplace','ajaxreplace');
				
				with($this){
					var $event=function(){
						$this.html(conf.html);
						$.ajax({url:conf.url,cache:false,success:function(data){
							$this.replaceWith($(data).find(conf.find).html());
							$.refresh();
						}});
					};
					var $remove=function(mode){
						unbind(conf.event,$event);
						unbind('removeAjaxReplace',$remove);
						removeData('ajaxreplace');
					};
					
					bind(conf.event,$event);
					bind('removeAjaxReplace',$remove);
				}
			}
		});
	}
})(jQuery);
