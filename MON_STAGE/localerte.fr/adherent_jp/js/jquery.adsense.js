(function($){
	$.adsense=function(conf){
		$(conf.selector).html($('<iframe scrolling="no" src="http://www.localerte.fr/adherent/adsense.php?'+$.param(conf.param)+'" width="'+conf.param.google_ad_width+'" height="'+conf.param.google_ad_height+'"></iframe>'));
	}
})(jQuery);

