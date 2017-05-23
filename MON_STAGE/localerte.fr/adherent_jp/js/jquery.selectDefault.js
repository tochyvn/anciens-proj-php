(function($){
	$.fn.removeSelectDefault=function(){
		return this.each(function(){
			$(this).trigger('removeSelectDefault');
		});
	};
	
	$.fn.selectDefault=function(conf){
		return this.each(function(){
			if(typeof $(this).data('selectdefault')=='undefined'){
				var $this=$(this);
				
				$this.data('selectdefault','selectdefault');
				
				with($this){
					var $change=function(){
						if(val()==conf.defaultValue){
							find('[value="'+conf.defaultValue+'"]').each(function(){
								$(this).removeClass(conf.cancelCSS);
								$(this).html($(this).data('html'));
							});
							addClass(conf.selectCSS);
						}
						else{
							find('[value="'+conf.defaultValue+'"]')
								.addClass(conf.cancelCSS)
								.html(conf.cancelHtml);
							removeClass(conf.selectCSS);
						}
					};
					var $remove=function(mode){
						find('[value="'+conf.defaultValue+'"]').removeClass(conf.optionCSS);
						unbind('keypress change init',$change);
						unbind('removeSelectDefault',$remove);
						removeData('selectdefault');
					};
					
					with(find('[value="'+conf.defaultValue+'"]')){
						addClass(conf.optionCSS);
						data('html',html());
					}
					
					bind('keypress change init',$change);
					bind('removeSelectDefault',$remove);
					
					trigger('init');
				}
			}
		});
	}
})(jQuery);
