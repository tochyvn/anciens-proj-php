(function($){
	$.msgBox=function(conf){
		var $div=$('<div>');
			
		with($div){
			var $refresh=function(){
				css('position','absolute');
				css('top','0');
				css('left','0');
				css('width',1);
				css('height',1);
				css('width',($(document).width()<$(window).width()?$(window).width():$(document).width())-(outerWidth()-width()));
				css('height',($(document).height()<$(window).height()?$(window).height():$(document).height())-(outerHeight()-height()));
			};
			
			appendTo($('body'));
			addClass(conf.classCSS);
			html('<div><p class="fermeture">X</p>'+conf.html+'</div>');
			bind('refresh',$refresh),
			css('opacity',0);
			$refresh();
			
			hauteur=height();
			css('opacity',0);
			animate({opacity:1},500);
			
			$('html, body').animate({scrollTop:0},500);
			
			with(find('.fermeture')){
				css('cursor','pointer');
				bind('click',function(){$div.animate({opacity:0},500,function(){$div.remove();conf.close();})});
			}
		};
		
		setInterval(function(){if($div.attr('trigger')=='close') $div.find('.fermeture').trigger('click');},1000);
	};
})(jQuery);
