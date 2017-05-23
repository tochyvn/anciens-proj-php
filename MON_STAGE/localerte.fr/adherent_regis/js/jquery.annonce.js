(function($){
	$.fn.removeAnnonce=function(){
		return this.each(function(){
			$(this).trigger('removeAnnonce');
		});
	};
	
	var $annonce_coche=0;
	var $annonce_action=null;
	var $annonce_div=$('<div>');
	var $annonce_tout=$('<div>');
	
	var $action_label=$('<label>').html(' Tout s&eacute;lectionner');
	var $action_span=$('<span>');
	var $action_input=$('<input type="checkbox" name="annonce_tout" value="1">')
	
	$.fn.annonce=function(){
		if($annonce_action===null && $('.ma-liste .action').length){
			$annonce_action=$('.ma-liste .action');
			
			with($annonce_tout){
				
				with($action_input){
					css('display','none');
					bind('cancel',function(){
						$(this).prop('checked',false);
						$action_span.addClass('unchecked');
						$action_span.removeClass('checked');
					});
					bind('click',function(){
						if($(this).is(':checked')){
							$action_span.addClass('checked');
							$action_span.removeClass('unchecked');
						}
						else{
							$action_span.addClass('unchecked');
							$action_span.removeClass('checked');
						}
					})
					bind('change',function(){
						$annonce_div.html('').remove();
						if($(this).is(':checked'))
							$('[annonce="annonce"] input').prop('checked',true);
						else
							$('[annonce="annonce"] input').prop('checked',false);
						$('[annonce="annonce"] input').trigger('refresh');
						$annonce_coche=$('[annonce="annonce"] input:checked').length;
					});
				}
				
				$action_span.append($action_input);
				$action_label.prepend($action_span);
				
				addClass('tout');
				prepend($action_label);
				$annonce_action.after($annonce_tout);
			}
		}		
		
		return this.each(function(){
			if(typeof $(this).data('annonce')=='undefined'){
				var $this=$(this);
				var $label=$this.find('.colonne1 label');
				var $input=$label.find('input');
				
				$this.data('annonce','annonce');
				$this.attr('annonce','annonce');
				
				with($annonce_div){
					insertAfter($this);
					addClass('bandeau');
					css('display','block');
					animate({height:0},0);
					//hide(0);
				}
				
				with($this){
					if($action_input.is(':checked')){
						$input.prop('checked',true);
						$annonce_coche++;
					}
					
					var $click=function(event){
						if($input.is(':checked'))
							$input.prop('checked',false);
						else
							$input.prop('checked',true);
						
						$input.trigger('change');
						$input.trigger('refresh');
						
						event.stopPropagation();
						event.preventDefault();
					}
					var $refresh=function(){
						if($input.is(':checked')){
							$this.addClass('checked');
							$this.removeClass('unchecked');
						}
						else{
							$this.addClass('unchecked');
							$this.removeClass('checked');
						}
						
						if($annonce_coche) $annonce_action.html('<span>Pour voir votre s&eacute;lection, cliquez sur </span><button class="bouton" type="submit" name="annonce_submit" value="Go">Consulter</button>');
						else $annonce_action.html('<span>Cochez les annonces &agrave; d&eacute;couvrir, puis </span><button class="bouton" type="submit" name="annonce_submit" value="Go">Consultez</button>');
					}
					var $change=function(){
						$annonce_div.animate({height:0},0,function(){
							$action_input.trigger('cancel');
							
							//$annonce_div.hide(0);
							$annonce_div.html('<img src="http://static.localerte.fr/adherent/img/bandeau.png" alt="" width="130" height:"15">');
							
							if($input.is(':checked')){
								$annonce_coche++;
								
								$annonce_div.html($annonce_div.html()+'<p class="bandeau-01"><strong>Annonce ajout&eacute;e &agrave; votre s&eacute;lection</strong></p>');
								$annonce_div.html($annonce_div.html()+'<p class="bandeau-02">Vous pouvez poursuivre votre s&eacute;lection ou consulter</p>');
								$annonce_div.html($annonce_div.html()+'<p class="bandeau-03"><label>'+$annonce_coche+($annonce_coche<2?' annonce s&eacute;lectionn&eacute;e':' annonces s&eacute;lectionn&eacute;es')+'</label><button class="bouton" type="submit" name="annonce_submit" value="Go">Consulter</button></p>');
							}
							else{
								$annonce_coche--;
							
								$annonce_div.html($annonce_div.html()+'<p class="bandeau-01"><strong>Annonce enlev&eacute;e de votre s&eacute;lection</strong></p>');
								if($annonce_coche){
									$annonce_div.html($annonce_div.html()+'<p class="bandeau-02">Vous pouvez poursuivre votre s&eacute;lection ou consulter</p>');
									$annonce_div.html($annonce_div.html()+'<p class="bandeau-03"><label>'+$annonce_coche+($annonce_coche<2?' annonce s&eacute;lectionn&eacute;e':' annonces s&eacute;lectionn&eacute;es')+'</label><button class="bouton" type="submit" name="annonce_submit" value="Go">Consulter</button></p>');
								}
							}
							
							$annonce_div.html($annonce_div.html()+'<div class="clear"></div>');
							$input.trigger('refresh');
							
							$annonce_div.insertAfter($this);
							
							$annonce_div.animate({height:56},500,function(){
							//$annonce_div.slideDown(200,function(){
								h1=$(document).scrollTop()+$(window).height();
								h2=parseInt($annonce_div.offset().top)+$annonce_div.outerHeight();
								if(h1<h2) $('html, bodt').animate({scrollTop:'+='+(h2-h1)},500);
							});
						});
					};
					var $remove=function(){
						$input.unbind('change',$change);
						$input.unbind('refresh',$refresh);
						$annonce_tout.remove();
						$this.unbind('click',$click);
						removeData('annonce');
					};
					
					with($input){
						css('display','none');
						bind('change',$change);
						bind('refresh',$refresh);
						
						trigger('refresh');
					}
					
					css('cursor','pointer');
					bind('click',$click);
					bind('removeAnnonce',$remove);
					
				}
			}
		});
	}
})(jQuery);
