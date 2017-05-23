(function($){
	$.fn.removeFindJSON=function(){
		return this.each(function(){
			$(this).trigger('removeFindJSON');
		});
	};
	
	$.fn.findJSON=function(conf){
		return this.each(function(){
			if(typeof $(this).data('findjson')=='undefined'){
				var $this=$(this);
				var $parent=$this.parent();
				var $span=$('<span>');
				var $texte=null;
				var $json=[];
				var $survol=false;
				var $visible=false;
				var $focus=false;
				
				$this.data('findjson','findjson');
				
				var remplacer=function(chaine,tableau){
					for(i=0;i<tableau.entree.length;i++)
					{
						var regexp=new RegExp(tableau.entree[i][0],tableau.entree[i][1]);
						chaine=chaine.replace(regexp,tableau.sortie[i])
					}
					
					return chaine;
				};
				
				var rechercher=function(){
					chaine=remplacer($this.val(),conf.formater);
					chaine=remplacer(chaine,conf.masquer);
					
					var regexp=new RegExp(conf.condition[0],conf.condition[1]);
					if(!chaine.match(regexp) || conf.longueur<1) return '';
					
					var index=chaine.substring(0,conf.longueur);
					
					if(!(index in $json)){
						tableau={'chaine':chaine};
						$.ajax({url:conf.json.replace(/INDEX/,index)+'?'+$.param(tableau),async:true,dataType:'json',cache:true,success:function(data){
							$json[index]=data;
							$texte=null;
							if(mettre_a_jour()) regler();
						}});
						
						return '';
					}
					else{
						var json=$json[index];
						var resultat='';
						var i,j;
						for(i=0,j=0;j<conf.maximum && i<json.length;i++){
							ville=remplacer(json[i]['text'],conf.formater);
							if(ville.indexOf(chaine)==0){
								var regexp=new RegExp('(^'+remplacer(chaine,conf.expressionner)+')','i');
								
								resultat+='<li js-findJSON-value="'+json[i]['value']+'">'+json[i]['text'].replace(regexp,'<strong>$1</strong>')+'</li>'
								j++;
							}
							else if(ville.indexOf(' '+chaine)!=-1){
								var regexp=new RegExp('([^a-z0-9абвгдезийклмнопртуфхцщъыьэя]'+remplacer(chaine,conf.expressionner)+')','i');
								
								resultat+='<li js-findJSON-value="'+json[i]['value']+'">'+json[i]['text'].replace(regexp,'<strong>$1</strong>')+'</li>'
								j++;
							}
						}
						
						return (resultat)? '<ul>'+resultat+'</ul>' : resultat;
					}
				};
				
				var vider=function(){
					conf.hidden.val('');
				}
				
				var choisir=function(){
					var li=$span.find('li.selected');
					if(li.length){
						$this.val(li.text());
						$texte=$this.val();
						conf.hidden.val(li.attr('js-findJSON-value'));
					}
					else conf.hidden.val('');
				};
				
				var redimensionner=function(){
					$span
						.css('top',$this.position().top+$this.innerHeight())
						.css('left',$this.position().left)
						.css('width',$this.innerWidth());
				};
				
				var fermer=function(){
					$span.css('display','none');
					$visible=false;
				};
				
				var ouvrir=function(){
					$span.css('display','block');
					positionner();
					$visible=true;
				};
				
				var regler=function(){
					if(!$visible && $span.html()) ouvrir();
					else if($visible && !$span.html()) fermer();
				};
				
				var positionner=function()
				{
					var li=$span.find('li.selected');
					if(!li.length) $span.scrollTop(0);
					else if(li.position().top<0){
						$span.animate({scrollTop:'+='+li.position().top},0);
						if($span.scrollTop()+li.position().top+li.outerHeight()<$span.innerHeight()) $span.scrollTop(0);
					}
					else if(li.position().top+li.outerHeight()>$span.innerHeight())$span.animate({scrollTop:'+='+(li.outerHeight()-($span.innerHeight()-li.position().top))},0);
				};
				
				var mettre_a_jour=function(){
					if($this.val()!=$texte){
						
						vider();
						$texte=$this.val();
						
						$span.html(rechercher());
						if($span.html()){
							$span.find('li')
									.bind('mouseover',function(){
										$span.find('li').removeClass('selected');
										$(this).addClass('selected');
									})
									.bind('click',function(event){
										choisir();
										fermer();
										
										event.stopPropagation();
										event.preventDefault();
									});
							
							return 2;
						}
						
						return 1;
					}
					
					return 0;
				};
				
				with($parent){
					if(css('position')!='absolute') css('position','relative');
				}
				
				with($span){
					appendTo($parent);
					addClass(conf.classe);
					css('position','absolute');
					css('top',$this.position().top+$this.innerHeight());
					css('left',$this.position().left);
					bind('mouseover',function(){$survol=true;});
					bind('mouseout',function(){$survol=false;});
					hide(0);
				}
				
				with($this){
					var $keydown=function(event){
						switch(event.keyCode){
							case 9://TAB
								if($visible){
									choisir();
									
									event.stopPropagation();
									event.preventDefault();
								}
								break;
							case 13://ENTREE
								if($visible){
									choisir();
									fermer();								
									
									event.stopPropagation();
									event.preventDefault();
								}
								break;
							case 27://ECHAP
								if($visible){
									fermer();
								}
								break;
							case 38://FLECHE HAUT
								if($visible){
									var li=$span.find('li.selected');
									if(li.length){
										li.removeClass('selected');
										li.prev().addClass('selected');
									}
									else
										$span.find('li:last').addClass('selected');
									
									positionner();
								}
								
								break;
							case 40://FLECHE BAS
								if(!$visible){regler();}
								else{
									var li=$span.find('li.selected');
									if(li.length){
										li.removeClass('selected');
										li.next().addClass('selected');
									}
									else
										$span.find('li:first').addClass('selected');
									
									positionner();
								}
							
								break;
						}
					};
					var $blur=function(){if(!$survol) fermer(); $focus=false;};
					var $dblclick=function(){regler();};
					var $keyup=function(){if(mettre_a_jour()) regler();};
					var $change=function(){if(mettre_a_jour()) regler();};
					var $input=function(){if(mettre_a_jour()) regler();};
					var $focus=function(){$focus=true;};
					var $remove=function(){
						unbind('keydown',$keydown);
						unbind('blur',$blur);
						unbind('dblclick',$dblclick);
						unbind('keyup',$keyup);
						unbind('change',$change);
						unbind('input',$input);
						unbind('focus',$focus);
						unbind('refresh',$redimensionner);
						unbind('removeFindJSON',$remove);
						removeData('findjson');
						$span.remove();
					};
					
					bind('keydown',$keydown);
					bind('blur',$blur);
					bind('dblclick',$dblclick);
					bind('keyup',$keyup);
					bind('change',$change);
					bind('input',$input);
					bind('focus',$focus);
					bind('refresh',redimensionner);
					bind('removeFindJSON',$remove);
					trigger('refresh');
				}
				
				if($this.is(':focus')) $focus=true;
			}
		});
	};
})(jQuery);
