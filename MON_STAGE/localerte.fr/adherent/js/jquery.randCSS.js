(function($){
	$.fn.removeRandCSS=function(){
		return this.each(function(){
			$(this).trigger('removeRandCSS');
		});
	};
	
	$.fn.randCSS=function(conf){
		return this.each(function(){
			if(typeof $(this).data('randcss')=='undefined'){
				var $this=$(this);
				
				$this.data('randcss','randcss');
				
				with($this){
					var $remove=function(){
						unbind('removeRandCSS',$remove);
						
						css(data('randcss_ori'));
						
						removeData('randcss_ori');
						removeData('randcss_conf');
						removeData('randcss');
					};
					
					data('randcss_conf',conf[(Math.floor(Math.random()*conf.length))])
					
					ori=new Object();
					$.each(data('randcss_conf'),function(key,value){ori[key]=css(key);});
					data('randcss_ori',ori);
					
					css(data('randcss_conf'));
					bind('removeRandCSS',$remove)
				}
			}
		});
	}
})(jQuery);
