$(document).ready(function(){
       
    var item_panier = $('.item-panier');
    //Suppression d'un produit du panier
    item_panier.each(function(index, value) {
        var id = $(value).attr('id');
        $('#'+id+' .form-suppr').submit(function(e) {
            e.preventDefault();
            console.log($(this).serialize()+'\n');/*
                    $.ajax({
                        type : "POST",
                        datatype : "JSON",
                        data : $(this).serialize(),
                        url : $(this).attr('action'),
                        error : function(){
                            console.log('la requête AJAX s\'est mal passée');
                        },
                        success : function(data) {
                            
                        }
                    });*/
        });
    });
    
    //On cache les boites d'affichage des erreurs
    $('#form-connexion .tooltip_error').css({"display": "none"});
    
    $('#form-connexion').submit(function(e) {
        
            e.preventDefault();
            var id = $(this).attr('id');
            var elem = $(this); 
            
            if( !form_validation(id) ) {
                return false;
            }
            $.ajax({
                type: "POST", 
                dataType: "json",
                data: $(this).serialize(), 
                url: $(this).attr('action'),
                error: function(result){
                    //console.log(result);
                    console.log("La requête Ajax s'est mal passée");
                },
                success: function(result) {
                    console.log("La requête Ajax s'est bien passée\n");  
                    console.log(result);
                    
                    
                    
                    /*
                    if (result.droit === "normal") {
                        location.href = '../consulter/produits';
                    }else {
                        location.href = '';
                    }
                    */
                }
                 
            });
            return false;
        });
           
        
        $('#form-subscribe').submit(function(e) {
            e.preventDefault();
            
            var id = $(this).attr('id'),
            elem = $(this),
            error = $('.form_error');
            error.each(function(index, value) {
                $(value).removeClass('form_error');
                console.log($(value));
            });
            
            if( !form_validation(id) ){
                return false;
            }
            passwd = $('#passwd');
            passwd1 = $('#passwd1');
            if (passwd1.val() !== passwd.val()) {
                console.log('non identiques');
                passwd.addClass('form_error');
                passwd1.addClass('form_error');
                return false;
            }
            
            $.ajax({
                type: "POST", 
                dataType: "json",
                data: elem.serialize(), 
                url: elem.attr('action'),
                error: function(){
                    console.log("La requête Ajax s'est mal passée");
                },
                success: function(result) {
                    console.log("La requête Ajax s'est bien passée\n");  
                    console.log(result);
                }
                 
            });
        });
        
        
        function validateEmail( email ) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }
        
        function form_validation( id ){
            var champs = $('#'+id+' .form_required');
            var validation = true;
            
            champs.each( function( index, value ){
                if( $(value).val() == '' || $(value).val() == null || typeof( $(value).val() ) == "undefined" ){
                    $(this).addClass('form_error');
                    validation = false;
                }
            });
            
            var email = $('#'+id+' .valid_email');
            email.each( function( index, value ){
                if( !validateEmail(  $(value).val() )){
                    $(this).addClass('form_error');
                    validation = false;
                }
            });  
            return validation;
        }
        
        
        /**
         * L'autocompletion
         */
        $('#ville').autocomplete({
            source : 'http://localhost/CastellaneTravel/index.php?use_case=auth&action=ajax',
            minLength : 3,
            scroll : true,
            select : function(event, ui) {
                var inputId = $('#id_ville');
                resultat = ui.item.value;
                tableau = resultat.split(' ');
                cp = tableau[0], ville = tableau[1], idVille = tableau[tableau.length - 1];
                console.log(tableau+'\n');
                for (i = 2; i<tableau.length-1; i++) {
                    ville = ville + ' ' + tableau[i];
                }
                ui.item.value = ville;
                inputId.val(idVille);
                console.log(inputId.val()+'\n');
            }
        });
         
});

//FORMULAIRE DE CONNEXION

