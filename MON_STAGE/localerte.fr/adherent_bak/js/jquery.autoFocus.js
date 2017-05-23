(function($){
	$.hasAutofocus='autofocus' in document.createElement('input');
	$.fn.autoFocus=function(){
		return $.hasAutofocus?this:this.each(function(){
			$(this).trigger('focus');
		});
	}
})(jQuery);
