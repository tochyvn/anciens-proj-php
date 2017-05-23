/* 
 * Toutes les fonction javaScript utilisées
 */

$(document).ready(function(){
   
   //---- LES VARIABLES GLOBALES ---------
    var mouseX=0;
    var mouseY=0;
    var startX=0;
    var startY=0;
    var currentMode='noPositionDefined';
    var lineDraw='noDraw';
    var selectedElement=null;
    var rotateVal=90;
    var currentZoom=1.0;
    var idx=0;
    var numLien=0;
    var startLink=null;
    var strNewPoints='';
    var dep=true;
    var nbr_pattes=0;
    var mode_simul=false;
    var o_c=false;
    
     
    $('.items').click(function(e){
        
        var obj=this; //--- L'élément cliqué ---
        
        $('.items').css({"border":0});
        $(this).css({"border":"solid 0.1em #000"});
        
        //--- On crée un objet de type Ajax ----
        //---- et on appelle la fonction qui charge les composants ----
        mAjax=$.ajax({
            type:"POST",
            url:'proprieties.php',
            data:"ido=" + obj.id,
            success:loard
        });
        
    });
    
    //--- Ce code rend draggable la zone de conception ---
    //------------- Med Ali Idjabou ----------------------
    $('.items').draggable({
        containment :'#drop',
        helper: 'clone',
        revert : false
    });
    
    $('#drop').droppable({
        accept : '.items',
        drop : dragg
    });
    
    //--- Gestion de la barre d'outils ------
    $('.outils').click(function(e){
        $('.outils').css({"border":0});
        $(this).css({"border":"solid 0.1em #000"});
        
        //--- Si le traçage de ligne est activé ---
        //----------- Med Ali Idjabou -------------
        if(this.id==='link'){
            lineDraw='drawing';
        }else{
            lineDraw='noDraw';
        }
        
        //--- On gère le draggin des elements du concepteur ---
        //-------------- Tochap Lionel ------------------------
        if(this.id==='dep'){
            if(!mode_simul){
                $('.it').draggable('enable');
                dep=true;
            }
        }else{
            $('.it').draggable('disable');
            dep=false;
        }
        
    });
    
    //---- QUAND ON CLIQUE SUR LA ZONE DE CONCEPTION ON ACTIVE LE TRACAGE --
    //------------ Med Ali Idjabou ---------------
    $('#drop').click(function(e){ 
        //---  Initalisation du debut de la ligne ---
        if(lineDraw==='drawing'){
            captureClick(selectedElement.id); 
        }
        $('.outils').css({
            "border":0
        });
    });
    //--- Quand on survole la zone de conception et que ---
    //------------- on est en mode traçage ----------------
    //--------------- Med: Ali Idjabou --------------------
    $('#drop').mousemove(function(e){
        //alert(selectedElement.id);
        if(lineDraw==='drawing'){
            getMouseXY(e);
            tryDrawLine();
        }
    });
    
    //----------- MODULE PROPOSE PAR KADER --------------
    //---- e-mail : benboinakader@hotmail.fr ------------
    
     //----fermeture des fennetres kader----
       //---- fenetre de conception-----// 
        $('#close').mouseover(function(){
            $(this).css({"cursor":"pointer"});
             $(this).click(function(){
                $('#concept').css({
                    "display":"none"
                });
             });
        });
        
        function dimensionHeight(h){
            
            $('#drop').css({"height":h});
        }
        
        function dimensionWidth(){
           // $('#drop').css({"width":"auto"});
        }
        
        //---- fenetre du code-----//
       $('#code').mouseover(function(){
           $(this).css({"cursor":"pointer"});
           $(this).click(function(){
               $('.code').css({
                    "display":"none"
                });
                dimensionHeight("42.2em"); 
           });
       });
        
       //---- fenetre des images de bases-----//
      
       $('#closecomp').mouseover(function(){   
            $(this).css({"cursor":"pointer"});
            $(this).click(function(){ 
                $('#local').css({
                    "display":"none"
                });
            });
       }); 
     
       //---- fenetre pour la propriete-----//
       $('#closeprop').mouseover(function(){
           $(this).css({"cursor":"pointer"});
           $(this).click(function(){
                $('#propriete').css({
                    "display":"none"
                });
                dimensionWidth();
           });
       });
       
       //---- fenetre de nos portraits-----//
       
        $('#closeImg').mouseover(function(){
            $(this).css({"cursor":"pointer"});
            $(this).click(function(){
                $('.suppr').css({
                    "display":"none"
                });
                 
            });
        });
        
     //--- Reouverture des fenetres ------
     $('.composants').click(function(){
        //getBlocs('composants');
        $('#local').css({
            "display":"block"
        });
     });
     $('.proprietes').click(function(){
        //getBlocs('proprietes');
        $('#propriete').css({
            "display":"block"
        });
     });
     $('.groupe').click(function(){
        //getBlocs('groupe');
        $('.suppr').css({
            "display":"block"
        });
     });
     $('.concepteur').click(function(){
        $('#concept').css({
            "display":"block"
        });
     });
     $('.windcode').click(function(){
        $('.code').css({
            "display":"block"
        });
        dimensionHeight("34.0em"); 
     });
    
    //--- Si on clique sur  annuler ---
    //------ Ben Boina Kader ----------
    $('#cancel').click(function(){
        $('.c_' + numLien).remove();
        //-- Controle des pattes ----
        nbr_pattes=nbr_pattes + 2; // La relation avait pris deux pattes
    });
    
    //------------------------------------------
    
    //---si onclique sur print---
    //------ Sfaxi Chafik -------
    $('#print,.print').click(function(){
        printContent('#drop');
    });
        
        
    $('#save,.save').click(function(){
        alert($('.drop')[0].outerHTML);
    });
    
    //---Si onclique sur ZOUT---
    //---- Sfaxi Chafik --------
    $('#zout').click(function(){
        if(selectedElement!==null){
            id=selectedElement.id;
            if(currentZoom<1.0){
                currentZom=1.0;
            }else{
                currentZoom -= 0.05;
            }
            $('#' + id).animate({'zoom': currentZoom,
                                 '-webkit-zoom':currentZoom,
                                 '-moz-zoom':currentZoom,
                                 '-o-zoom':currentZoom,
                                 '-ms-zoom':currentZoom });
        }
    });
    
    //--- Si onclique sur ZIN---
    //---- Sfaxi Chafik --------
    $('#zin').click(function(){
        if(selectedElement!==null){
            id=selectedElement.id;
            if(currentZoom>1.5){
                currentZom=1.5;
            }else{
                //alert(currentZoom);
                currentZoom += 0.05;
            }
            $('#' + id).animate({'zoom': currentZoom,
                                 '-webkit-zoom':currentZoom,
                                 '-moz-zoom':currentZoom,
                                 '-o-zoom':currentZoom,
                                 '-ms-zoom':currentZoom });
        }
    });
    //----------------------------------------
    
    //------ Quant on clique sur le bouton RUN -------
    //------------ Idjabou -------------
    $('#run,.run').click(function(){
        if($('.it').length>0){
            //-- On verifie s'il y a un point d'entrée (INTER) et de sortie (LAMPE)---
            var inter=false;
            var lampe=false;
            $('.it').each(function(){
               if($(this).attr('name')==='INTER')inter=true;
               if($(this).attr('name')==='LAMPE')lampe=true;
            });
            
            //-- On terste si les deux condition sont satisfaites --
            if(inter && lampe){
                //---- On verifie ensuite si toutes les pattes sont liées ---
                if(nbr_pattes<=0){
                    //--- Le programme de simulation peut se lancer ---
                    //alert('La simulation peut se lancer correctement');
                    mode_simul=true;
                    
                    //-------
                }else{
                    alert('Certaines pattes ne sont pas reliées !');
                }
            }else{
                alert('Il manque probablement un point d\'entrée ou de sortie');
                //---- On quitte le processus de simulation
            }
            
        }else{
            alert('Aucun circuit n\'est crée !');
        }
    });
    
    $('.stop').click(function(){
        mode_simul=false;
        $('.inter').attr('src','graphics/upload/INTER.png');
        $('.lampe').attr('src','graphics/upload/LAMPE.png');
    });
    
    //--- Quand on click sur  le bouton rotation ---
    $('#rotate').click(function(){
        if(selectedElement!==null){
            rotateVal+=90;
            $(selectedElement).css({"transform": "rotate("+ rotateVal +"deg)",
            "-webkit-transform": "rotate("+ rotateVal +"deg)",
            "-moz-transform": "rotate("+ rotateVal +"deg)",
            "-ms-transform": "rotate("+ rotateVal +"deg)",
            "-o-transform": "rotate("+ rotateVal +"deg)"});
        }
    });
    
    //---- Quant on click sur le bouton supprimer ---
    $('#delete').click(function(){
        if(selectedElement!==null){
            id=selectedElement.id;
            
            //--- Controle des pattes ---
            nbr_pattes=nbr_pattes-parseInt($('#'+id).attr('code'));
            $('#' + id).remove();
            request_ajax();
        }
    });
    
    //--- SI ON CLIQUE SUR NOUVEAU -----
    $('#new,.new').click(function(){
        $('#drop').html('');
        showCode('');
    });
    //--------------------------
    
    //----- BLOC DE CODE PROPOSE PAR TOCHAP -----
    
    //--------------------------
    
    //#####################################################
    //#############  TOUTES LES FONCTIONS JS ##############
    //#####################################################
    
    //######## Fonction ecrites par Med Ali Idjabou #######
    //------ e-mail : mcri.infos@gmail.com ---------------
    
    function ajax_function(requete){
        $.ajax({
            type:"POST",
            url:'proprieties.php',
            data:"new=" + requete,
            success:showCode
        });
    }
    function showCode(rslt){
        //alert(rslt);
        document.getElementsByClassName('show_code')[0].innerHTML=rslt;
        //$('.show_code').height(rslt);
    }
    
    function loard(reslt){
        tab=reslt.split(",");
        $('#desc').html('Description : ' + tab[0]);
        if(tab[1]){
            $('#etat').html('Etat :Actif');
        }else{
            $('#etat').html('Etat : Iactif');
        }
        $('#Id').html('Reférence : ' + tab[2]);
        $('#entree').html("Nombre d'entrées : " + tab[3]);
        $('#sortie').html("Nombre de sorties : " + tab[4]);
    }
    
    //---- Fonctio appelée lorsqu'on draggue un element ----
    function dragg(e,ui){
        idx++;
        el=$(ui.draggable);
        clone=el.clone();
        clone.attr('name',el.attr('id'));
        if(el.attr('inter')){
           clone.attr('class','it inter');
        }else if(el.attr('lampe')){
           clone.attr('class','it lampe');
        }else{
           clone.attr('class','it'); 
        }
        clone.attr('etat','O');
        clone.attr('patte',0);
        clone.attr('sommet','S' + idx);
        clone.attr('id','id_'+idx);
        clone.attr('jts',''); //--- Cette attribut permet la mise en memoire des relations
        $(clone).css({"border":"0"});
            
        $('#drop').append(clone);
            
        //--- Controle des pattes ---
        nbr_pattes=nbr_pattes+parseInt(clone.attr('code'));
            
        $('.it').draggable({
            containment :'#drop',
            revert : false
        }); 
            
        //--- Une requete pour créer l'objet ajouté ---//
        request_ajax();
            
        //-- Gestion pour les composant du Concepteur ---
        $('.it').click(function(e){
            selectedElement=this;
            $('.it').css({"border":0});
            $(this).css({"border":"solid 0.1em #000"});
            
        });
            
        //-- Si on maintient le composant et on le deplace --
        $('.it').mouseup(function(){
            if(dep){
                request_ajax(); 
            }      
        });
            
        //--- On change l'apparence du curseur --
        $('.it').mousemove(function(){
            $(this).css({
                "cursor":"move"
            });
        });
            
        //---- En mode simulation, on change le type d'interrupteur Fermer/ouver ---
        $('.inter').click(function(e){
            if(mode_simul){
                if(!o_c){
                    if($(e.target).attr('etat')==='O'){
                        $(e.target).attr('src','graphics/upload/interdown.png');
                        $(e.target).attr('etat','F');
                        $(e.target).attr('s',"true");
                    }else{
                        $(e.target).attr('src','graphics/upload/INTER.png');
                        $(e.target).attr('etat','O');
                        $(e.target).attr('s',"false");
                    } 
                    o_c=true;
                }
                simule();
            } 
        });
        $('.inter').mouseup(function(){
            o_c=false;
        });   
        //--- Requete Ajax qui permet d'ajouter ou de modifier --
        //--- des élements depuis le code PHP ---------
        function request_ajax(){
                
            //---- On reconstruit tous les objets ---
            var cmp="";
            $('.it').each(function(){
                //alert($(this).attr('jts'));
                var jt=$(this).attr('jts').replace(/^\s+/g,'').replace(/\s+$/g,'');
                //alert(jointure);
                cmp+=Array(name=$(this).attr('name'),id=$(this).attr('sommet'),src=$(this).attr('src'),code=$(this).attr('code'),top=$(this).position().top,left=$(this).position().left,lien=jt)+";";
            });
                
            ajax_function(cmp);
        }
    }
    //---- Cette fonction envoie une requete de simulation --
    function simule(){
        var cmp="";
        $('.it').each(function(){
            var attr="";
            var jt=$(this).attr('jts').replace(/^\s+/g,'').replace(/\s+$/g,'');
            attr+=$(this).attr('name')+",";
            attr+=$(this).attr('sommet')+",";
            attr+=jt+",";
            if($(this).attr('e1')){ attr+=$(this).attr('e1')+",";}
            if($(this).attr('e2')){ attr+=$(this).attr('e2')+",";}
            if($(this).attr('s')){ attr+=$(this).attr('s');}
            
            cmp+=attr+";";
        });
                
        $.ajax({
            type:"POST",
            url:'proprieties.php',
            data:"sim=" + cmp,
            success:reponse
        });
    }
    function reponse(rslt){
        alert(rslt);
    }
    //-- Cette fonction capture le click d'un composant ---
    //-- et ouvre un leve un drapeau pour le debut du traçage --
    function captureClick(id){
             
        if(currentMode==='noPositionDefined')
            {
                numLien++;
                startLink=selectedElement.id;
                currentMode='firstPositionCaptured';
                startX=mouseX;
                startY=mouseY;
                lineDraw='drawing';
                
            }
        else{
                //--- On initialise les pattes ---
                if($(selectedElement).attr('patte')===2)$(selectedElement).attr('patte',0);
                
                if($(selectedElement).attr('patte')<2){ // Une porte ne peut avoir au max que 2 entrées---
                    $('#drop').append(strNewPoints);
                    $('#' + startLink).attr('jts',$('#' + startLink).attr('jts') + ' ' + $('#' + selectedElement.id).attr('sommet') + ':' + $(selectedElement).attr('patte'));
                    $(selectedElement).attr('patte',parseInt($(selectedElement).attr('patte'))+1);
                }
                
                //startLink=null;
                currentMode='noPositionDefined';
                lineDraw='noDraw';
                var cmp="";
                $('.it').each(function(){
                    var jt=$(this).attr('jts').replace(/^\s+/g,'').replace(/\s+$/g,'');
                    //alert(jointure);
                    cmp+=Array(name=$(this).attr('name'),id=$(this).attr('sommet'),src=$(this).attr('src'),code=$(this).attr('code'),top=$(this).position().top,left=$(this).position().left,lien=jt)+";";
                });
                ajax_function(cmp);
                
                //-- Controle des pattes ----
                nbr_pattes=nbr_pattes - 2;

        }
    }
    
    //--- Cette méthode recupère les coordonnées de l souris ---
    function getMouseXY(aEvent){
  	var myEvent = aEvent ? aEvent : window.event;
	if(myEvent.offsetX){
		mouseX=myEvent.clientX+document.body.scrollLeft-($('.aside').innerWidth()+6);
		mouseY=myEvent.clientY+document.body.scrollTop-($('.menu').innerHeight() + $('.bar_outils').innerHeight() + $('.sitmap').innerHeight()-6);
        }else
            {
		mouseX=myEvent.pageX-($('.aside').innerWidth()+6);//-(document.body.clientWidth-$('#drop').innerWidth()-6);
		mouseY=myEvent.pageY-($('.menu').innerHeight() + $('.bar_outils').innerHeight() + $('.sitmap').innerHeight()-6);
        }
    }
    
    //-- Cette méthode va tenter de tracer la ligne ----
    function tryDrawLine(){
	if(currentMode==='firstPositionCaptured')
	{
            drawLine(startX,startY,mouseX,mouseY);
	}
    }

    function drawLine(x1,y1,x2,y2)
    {
	//-- On recupère l'ID de l'élement selectionné --
        clss='c_' + numLien;
        
	//on calcule la longueur du segment
	var lg=Math.sqrt((x1-x2)*(x1-x2)+(y1-y2)*(y1-y2));
	
	//on determine maintenant le nombre de points necessaires
	var nbPointCentraux=Math.ceil(lg/1)-1;
	
	//stepX, stepY (distance entre deux points de pointillÃ©s);
	var stepX=(x2-x1)/(nbPointCentraux+0);
	var stepY=(y2-y1)/(nbPointCentraux+0);
	
	//on recreer un point apres l'autre
	strNewPoints='';
	for(var i=1 ; i<nbPointCentraux ; i++)
	{
            strNewPoints+='<div class="' + clss + '" style="font-size:1px; width:2em; height:2em; background-color:green; position:absolute; top:'+Math.round(y1+i*stepY)+'em; left:'+Math.round(x1+i*stepX)+'em; ">&nbsp;</div>';
	}
	
	//pointe de depart
	strNewPoints+='<div class="' + clss + '" style="font-size:1px; width:5em; height:5em; background-color:crimson; position:absolute; top:'+(y1-5)+'em; left:'+(x1-3)+'em; ">&nbsp;</div>';
	//point d'arrive
	strNewPoints+='<div class="' + clss + '" style="font-size:1px; width:5em; height:5em; background-color:crimson; position:absolute; top:'+(y2-5)+'em; left:'+(x2-5)+'em; ">&nbsp</div>';

	
	//on suprimme tous les points actuels et on mets les nouveaux div en place
        
	$('.'+clss).remove();
        
        //---- On retrace de nouveau ---
	//$('#drop').append(strNewPoints);
	
    }
    //------------------------------
    
    //####### FONCTION ECRITE PAR SFAXI CHAFIK ########
    //---- e-mail :
    //---Function  impression--- 
    function printContent(el){
        var restorepage = $('body').html();
        var printcontent = $(el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
    
});


