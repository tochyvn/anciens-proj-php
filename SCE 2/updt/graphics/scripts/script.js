/* 
 * Toutes les fonction javaScript utilisées
 */

$(document).ready(function(){
   
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
    });
    
    
});


