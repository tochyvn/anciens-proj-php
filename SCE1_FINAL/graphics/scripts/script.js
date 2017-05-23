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
    var cancelClass=null;
    var selectedElement=null;
    var rotateVal=90;
    var mouseUp = true; 
    var startX1;
    var startY1;
    
     
    $('.items').click(function(e){
        
        var obj=this; //--- L'élément cliqué ---
        
        $('.items').css({"border":0});
        $(this).css({"border":"solid 0.1em #000"});
        
        //--- On crée un objet de type Ajax ----
        
        mAjax=$.ajax({
            type:"POST",
            url:'proprieties.php',
            data:"ido=" + obj.id,
            success:loard
        });
        
    });
    
    //--- Ce code rend draggable la zone de conception ---
    
    $('.items').draggable({
        containment :'#drop',
        helper: 'clone',
        revert : true
    });
    
    $('#drop').droppable({
        accept : '.items',
        drop : function(e,ui){
            el=$(ui.draggable);
            clone=el.clone();
            clone.attr('name',el.attr('id'));
            clone.attr('class','it');
            clone.attr('id','id_'+$('.it').length);
            $(clone).css({"border":"0"});
            $('#drop').append(clone);
            
            $('.it').draggable({
                containment :'#drop',
                revert : false
            }); 

            //-- Gestion pour les composant du Concepteur ---
            $('.it').click(function(){
                selectedElement=this;
            });
            
            //--- On change l'apparence du curseur --
                $('.it').mousemove(function(){
                   $(this).css({
                        "cursor":"move"
                    });
                });
        }
    });
    
    //--- Gestion de la barre d'outils ------
    $('.outils').click(function(e){
        $('.outils').css({"border":0});
        $(this).css({"border":"solid 0.1em #000"});
        //--- Quand on click sur  le bouton rotation ---
        if(this.id==='rotate'){
            if(selectedElement!==null){
                rotateVal+=90;
                $(selectedElement).css({"transform": "rotate("+ rotateVal +"deg)",
                "-webkit-transform": "rotate("+ rotateVal +"deg)",
                "-moz-transform": "rotate("+ rotateVal +"deg)",
                "-ms-transform": "rotate("+ rotateVal +"deg)",
                "-o-transform": "rotate("+ rotateVal +"deg)"});
            }
        }
        
        //---- Quant on click sur le bouton supprimer ---
        if(this.id==='delete'){
            if(selectedElement!==null){
                id=selectedElement.id;
                $('#' + id).remove();
            }
        }
        
        //--- On gère le draggin des elements du concepteur ---

        if(this.id==='dep'){
            $('.it').draggable('enable');
        }else{
            $('.it').draggable('disable');
        }
        
        //--- Si le traçage de ligne est activé ---
        if(this.id==='link'){
            lineDraw='drawing';
        }else{
            lineDraw='noDraw';
        }
        
        //--- Si on clique sur  annuler ---
        if(this.id==='cancel'){
            clss='c_'+selectedElement.id;
            $('.'+clss).remove();
        }
        
        //---Si on clique sur selectionner
        if(this.id === 'select') {
            selectedElement = 'selection';
        }
        
    });
    
    //---- QUAND ON CLIQUE SUR LA ZONE DE CONCEPTION ON ACTIVE LE TRACAGE --
    $('#drop').click(function(e){
        $('#drop .cadrage').remove();
        //---  Initalisation du debut de la ligne ---
        if(lineDraw==='drawing'){
            captureClick(this); 
            //alert(e.pageX +" , "+ mouseX);
        }
        
        $('.outils,.it').css({
            "border":0
        });
    });
    //--- Quand on survole la zone de conception et que ---
    $('#drop').mousemove(function(e){
        //alert(selectedElement.id);
        if(lineDraw==='drawing'){
            getMouseXY(e);
            tryDrawLine();
        }
        
        //Gestion de la selection
        if (selectedElement === 'selection') {
            
            
            if (!mouseUp) {
                $('.cadrage').remove();
                console.log('mouvement : '+mouseUp);
                var div = document.createElement('div');
                div.setAttribute('class', 'cadrage');
                x = e.pageX - $('aside').innerWidth(); 
                y = e.pageY - 97;
                $(this).append(div);
                //Si la selection est faite à partir du coin superieur gauche
                if ((x - startX1 >= 0) && (y - startY1 >= 0)) {
     
                   $('.cadrage').css({"top":startY1, "left":startX1, "width":(x-startX1), "height":(y-startY1)});
                   console.log(' tochap X: '+(x-startX1)+' Y: '+ (y-startY1));
                   
                } else { 
                    //Si la selection est faite à partir du coin supérieur droit
                    if ((x - startX1 < 0) && (y - startY1 > 0)) {
                        //console.log('Si la selection est faite à partir du coin supérieur droit');
                        $('.cadrage').css({"left":(startX1-x)+"px", "top":startY1+"px", "width":(startX1-x)+"px", "height":(y-startY1)+"px"});
                        console.log(' tochap X: '+(startX1-x)+' Y: '+ (y-startY1));
                    } else {
                        //Si la selection est faite à partir du coin inferieur gauche
                        if ((x - startX > 0) && (y - startY < 0)) {
                       /* rect.setAttribute('x', startX);
                        rect.setAttribute('y', y);
                        rect.setAttribute('width', (x - startX));
                        rect.setAttribute('height', (startY - y));
                        console.log('X: '+(x - startX)+' Y: '+ (startY - y));*/
                    } else { // //Si la selection est faite à partir du coin inferieur droit
                        /*rect.setAttribute('x', x);
                        rect.setAttribute('y', y);
                        rect.setAttribute('width', (startX - x));
                        rect.setAttribute('height', (startY - y));
                    
                        console.log('X: '+(startX - x)+' Y: '+ (startY - y));*/
                    }
                
                }
                
            }
            
            
            } 
        }
        
    });
    
    //LORSQUE LA SOURIS EST ENFONCÉE
    $('#drop').mousedown(function(e) {
       
        mouseUp = false; 
        console.log('Appuyé : '+mouseUp);
        startX1 = e.pageX - $('aside').innerWidth();
        startY1 = e.pageY - 97;
        console.log('X: '+startX1+' Y: '+startY1 );
        //alert($('header.menu').innerHeight()+$('section hgroup:first-child').innerHeight());
        //$('.rectg').remove();
        //var div = document.createElement('div');
        
        /*
        div.top = 10;
        div.left = 20;
        div.width = 250;   //clone.attr('class','it');
        div.height = 200;
        */
        //div.setAttribute('class','cadrage');
        //$(this).append(div);
        //$('.cadrage').css({"top":"9.0em", "left":"4.0em", "width":"10.0em", "height":"9.0em"});
        
       
    });
    
    //LORSQUE LA SOURIS EST RELACHEE
    $('#drop').mouseup(function(e) {
        
         
        //On recupère la position finale de la souris
        endX = e.pageX - $('aside').innerWidth();
        endY = e.pageY - 90;
        mouseUp = true;
        
        //On va donner la classe selection1 a tout les éléments qui sont dans le cadrage
        //if (selectedElement === 'selection')  {
        /*
            for (var i=0; i<$('.it').length; i++) {
                ele = [];
                ele = $('.it');
                alert(ele[i].prop('left'));
            }
            */
            
            $('.it').each(function() {
                stl=$(this).attr('style').split(';');
                
                for(var i=0;i<stl.length;i++){
                    var left=null;
                    var top=null;
                
                    att=stl[i].split(':');
                    at=att[0].replace(/^\s+/g,'').replace(/\s+$/g,'');
                    if(at==='top'){top=att[1].substring(1,att[1].length);}
                    if(at==='left'){left=att[1].substring(1,att[1].length)}
                    
                    if(top!==null){
                        alert($(this).attr('id') + " -- " +top);
                    }
                    
                    if(left!==null){
                        alert($(this).attr('id') + " -- " + left);
                    }
                }
                
            });
        //}
        
        console.log('relaché : '+mouseUp);
        console.log('X: '+endX+'  Y: '+endY);
        
        //alert($('aside').innerWidth()+'  '+$('aside').innerHeight());
        
        
    });
    
    //#####################################################
    //#############  TOUTES LES FONCTIONS JS ##############
    //#####################################################
    
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
        
    //-- Cette fonction capture le click d'un composant ---
    //-- et ouvre un leve un drapeau pour le debut du traçage --
    function captureClick(e){
        
        if(currentMode==='noPositionDefined')
            {
                currentMode='firstPositionCaptured';
                startX=mouseX;
                startY=mouseY;
                lineDraw='drawing';
                
            }
        else{
            currentMode='noPositionDefined';
            lineDraw='noDraw';
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
        clss="c_"+selectedElement.id;
        
	//on calcule la longueur du segment
	var lg=Math.sqrt((x1-x2)*(x1-x2)+(y1-y2)*(y1-y2));
	
	//on determine maintenant le nombre de points necessaires
	var nbPointCentraux=Math.ceil(lg/1)-1;
	
	//stepX, stepY (distance entre deux points de pointillÃ©s);
	var stepX=(x2-x1)/(nbPointCentraux+0);
	var stepY=(y2-y1)/(nbPointCentraux+0);
	
	//on recreer un point apres l'autre
	var strNewPoints='';
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
	$('#drop').append(strNewPoints);
	
    }
    
});


