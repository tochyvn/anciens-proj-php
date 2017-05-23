(function($){
	$.hasAutofocus='autofocus' in document.createElement('input');
	$.fn.autoFocus=function(){
		return this.each(function(){
			$(this).trigger('focus');
		});
	}
})(jQuery);
