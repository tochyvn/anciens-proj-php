<?php include '../fonctions/generate_url.php'; ?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            div {
                position: absolute;
                border: black solid thick;
                margin: auto;
                top: 30%;
                left: 40%;
                width: 20%;
                padding-left: 20px;
                padding-top: 20px;
            }
            
            .form_error {
                border: red solid thin;
            }
        </style>
        <script type="text/javascript" src="../assets/js/jquery-1.11.1.min.js"></script>
        <script>
            
    $(function(){
       
        // envoi du formulaire de connexion
        $('#form-connexion').submit(function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var elem = $(this); 
            
            if( !form_validation(id) ){
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
                }
                 
            });
            return false;
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
    });

        </script>
    </head>
    <body>
        <div class="form">
            <form id="form-connexion" action="<?php echo site_url('index.php?use_case=auth&action=connexion'); ?>" method="POST">
            <!--
            <p>
                <input type="hidden" name="action" value="connexion" />
            </p>
            -->
            <p>
                <label>Email : </label>
                <input type="text" name="email" class="form_required valid_email" />
            </p>
            <p>
                <label>Mot de passe : </label>
                <input type="password" name="passwd" class="form_required" />
            </p>
            <p>
                <input type="submit" value="Soummetre le formulaire" />
            </p>
        </form>
        </div>
        
        <?php
        
        ?>
    </body>
</html>

