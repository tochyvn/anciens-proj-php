
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h1>Recevez les nouvelles annonces avant les autres !</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div style="overflow:hidden;">
            <div class="col-md-8">
                <form role="form">
                    <div class="formulaire_alerte">    
                        <span class="gris_uppercase"><i class="glyphicon glyphicon-search"></i> Votre recherche : </span>
                    </div> 
                    <br/>
                    <div class="form-group">
                        <select id="in_type_alerte"  class="form-control">
                            <?php
                            foreach ($this->immobiliers as $immo):
                                if ($immobilier_id == $immo['identifiant']) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                ?>
                                <option <?php echo $selected; ?> value="<?php echo $immo['identifiant']; ?>"><?php echo $immo['designation']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <fieldset class="">
                          <input type="text" autocomplete="off" id="in_ville_ajout_alerte" 
                                 data-toggle="tooltip"  title="Vous devez choisir une ville dans la liste déroulante"
                                 value=""
                                 placeholder="Saisissez la ville ou code postal" 
                                 class="ville-typeahead form-control">
                        </fieldset>
                    </div>
                    <br/>
                    <div class="form-group">
                        <input type="checkbox" name="inscription_geo" id="inscription_geo"/>&nbsp; <label style="font-weight: normal;" for="inscription_geo">Profiter des offres de nos partenaires avec La Lettre du Jour</label> 
                    </div>
                </form>
                <div id="message_success" class="alert alert-success" style="display: none;">

                </div>
                <div id="message_error" class="alert alert-danger" style="display: none;">

                </div>
            </div>
            <div class="col-md-4" style="margin-top: 10px; text-align:center">
                <img alt="Confiez-nous votre recherche" class="img-responsive" style="display:inline-block;" src="http://www.locamax.fr/assets/img/bonhomme_alerte.png<?php //echo base_url() . "assets/img/bonhomme_alerte.png"; ?>" />
            </div>
            <div style="padding : 10px;" class="col-md-12 col-lg-12 col-lg-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <div class="" style="text-align: center;">
                        <button type="button" class="btn btn-danger btn-sm" id="sauvegarder_alerte">Créer mon alerte mail</button>
                    </div>
                </div>
            </div>
            <div style="text-align: center;" class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                <small>Service gratuit limité à 2 alertes par jour. Désinscription à tout moment.</small> 
            </div>
        </div>
    </div>
</div>
<style>
    .page-header{
        text-align: center;
    }
    .page-header h1{
        font-size: 20px !important;
    }
</style>
<script type="text/javascript">
    $(function(){
        var alerteSelectedVille = '';
        $('#sauvegarder_alerte').click(function(){
            type = $('#in_type_alerte').val();
            email = $('#js_email_alerte').val();
            adherent_id = $('#js_adherent_alerte').val();
            var geo = $('#inscription_geo').val();
            if( geo == "on" ){
                geo = 1
            }
            else{
                geo = 0;
            }
            
            if( alerteSelectedVille == '' || $('#in_ville_ajout_alerte').val().length < 2){
                $('#in_ville_ajout_alerte').css('border-color' , 'red');
                $('#in_ville_ajout_alerte').tooltip('show');     
                return false;
            }
            
            //alerteSelectedVille = JSON.stringify(alerteSelectedVille);
            
            sauvegarderAlerte( email, type, alerteSelectedVille, adherent_id, geo );
        });   

        function getAutocompletions(query, process){
                alerteSelectedVille = '';
                villes = new Array();
                map = {};
                var url_base = '<?php echo base_url().'index.php/front/ajax_controller/typeAheadGeo/'; ?>';
                $.ajax({
                    url : url_base+encodeURIComponent(query),
                    dataType : 'JSON',
                    success : function(data){
                        while(villes.length > 0) {
                            villes.pop();
                        }
                        $.each( data, function (i, value) {
                            map[value.name] = value;
                            villes.push(value.name);
                        });
                        process(villes);                        
                    }
                });           
        }
        var map;
        var villes = new Array();
        $('.ville-typeahead').typeahead({
            source: function (query, process) {
                if( query.length == 2 ){
                    getAutocompletions(query, process);
                }else{
                    process(villes);
                }
            },
            updater: function (item) {
                alerteSelectedVille = map[item]['id'];
                return item;
            },
            matcher: function (item) {
                if ( item.toLowerCase().sansAccent().indexOf( this.query.trim().toLowerCase().sansAccent() ) != -1 ) {
                    return true;
                }
            },
            sorter: function (items) {
                $('#in_ville').tooltip('hide');
                return items;
            },
            highlighter: function (item) {
                var regex = new RegExp( '(' + this.query + ')', 'gi' );
                return item.replace( regex, "<strong>$1</strong>" );
            }
        });

        String.prototype.sansAccent = function(){
            var accent = [
                /[\300-\306]/g, /[\340-\346]/g, // A, a
                /[\310-\313]/g, /[\350-\353]/g, // E, e
                /[\314-\317]/g, /[\354-\357]/g, // I, i
                /[\322-\330]/g, /[\362-\370]/g, // O, o
                /[\331-\334]/g, /[\371-\374]/g, // U, u
                /[\321]/g, /[\361]/g, // N, n
                /[\307]/g, /[\347]/g, // C, c
            ];
            var noaccent = ['A','a','E','e','I','i','O','o','U','u','N','n','C','c'];

            var str = this;
            for(var i = 0; i < accent.length; i++){
                str = str.replace(accent[i], noaccent[i]);
                str = str.replace('-', ' ');
            }

            return str;
        }
        
        function sauvegarderAlerte( email, type, ville, adherent_id, geo ){
            $.ajax({
               url : '<?php echo base_url().'/front/alert/creer'; ?>',
               data : { email : email, type : type, ville : ville, adherent_id : adherent_id, geo : geo },
               datatype : 'json',     
               method : 'post',
               error : function(){
                    $('#message_error').html('Une erreur est survenue veuillez réassayer plus tard');
                    $('#message_error').slideDown();
                    setTimeout(
                            function(){
                            $('#modal_alerte').delay(2000).modal('hide');
                        }, 1500);
               },
               success : function(data){
                    $('#message_success').html('Votre alerte a été crée.');
                    $('#message_success').slideDown();
                    setTimeout(
                            function(){
                            $('#modal_alerte').delay(2000).modal('hide');
                            $('#message_success').slideUp();
                        }, 1500);
               }
            });
        }
    });
</script>
