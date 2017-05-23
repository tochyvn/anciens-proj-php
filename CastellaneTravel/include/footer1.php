        
        </div>
        <div class="footer">
            
        </div>
        <script type="text/javascript">
     /*       
    $(document).ready(function(){
       
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
*/
        </script>
    </body>
</html>