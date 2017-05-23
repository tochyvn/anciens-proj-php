<?php 
    $civilite_homme = '';
    $civilite_femme = '';
    if( $adherent['civilite'] == 'MONSIEUR' ){
        $civilite_homme = 'checked';
    }elseif( $adherent['civilite'] == 'MADAME' || $adherent['civilite'] == 'MADEMOISELLE' ){
        $civilite_femme = 'checked';
    }
    
    $statut_particulier = '';
    $statut_professionnel = '';
    if( $adherent['statut'] == 'PARTICULIER' ){
        $statut_particulier = 'checked';
    }elseif( $adherent['statut'] == 'PROFESSIONNEL' ){
        $statut_professionnel = 'checked';
    }
?>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js" type="text/javascript"></script>
<div class="row">
    <div class="col-md-12">
        <?php echo form_open('mes-parametres', array( 'id' => 'modifier_information', 'class' => 'form-horizontal', 'role' => 'form' )); ?>
        <form class="form-horizontal" role="form">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Email *</label>
              <div class="col-sm-10">
                <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="" value="<?php echo $adherent['email']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Nom</label>
              <div class="col-sm-10">
                <input type="text" name="nom" class="form-control" id="inputPassword3" placeholder="" value="<?php echo $adherent['nom']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Prénom</label>
              <div class="col-sm-10">
                <input type="text" name="prenom" class="form-control" id="inputPassword3" placeholder="" value="<?php echo $adherent['prenom']; ?>">
              </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Ville</label>
                <div class="col-sm-10">
                    <input name="lieu" type="hidden" id="js_param_ville_vue_espace" value="" />
                    <input type="text" autocomplete="off" id="js_param_ville_param" class="ville-typeahead form-control" value="<?php if($adherent['code_postal'] != '') echo $adherent['code_postal'].' '.$adherent['ville_nom_reel']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Téléphone</label>
                <div class="col-sm-10">
                    <input type="text" name="telephone" class="form-control" value="<?php echo $adherent['telephone']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Civilité</label>
                <div class="radio">
                    <label>
                      <input name="civilite" <?php echo $civilite_femme; ?> type="radio" value="MADAME"> Madame
                    </label>
                    <label>
                      <input name="civilite" <?php echo $civilite_homme; ?> type="radio" value="MONSIEUR"> Monsieur
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Statut</label>
                <div class="radio">
                    <label>
                      <input name="statut" <?php echo $statut_particulier; ?> type="radio" VALUE="PARTICULIER"> Particulier
                    </label>
                    <label>
                      <input name="statut" <?php echo $statut_professionnel; ?> type="radio" VALUE="PROFESSIONNEL"> Professionnel
                    </label>
                </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Modifier vos informations</button>
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10" style="font-size: 10px;">
                 Conformément à la Loi Informatique et Libertés du 6 Janvier 1978, vous disposez d'un droit d'accès, de modification et de suppression des données personnelles vous concernant que vous pouvez exercer à tout moment sur demande à : contact@locamax.fr

                Locamax s'engage à ne JAMAIS transmettre votre adresse à un tiers. Vous aurez la possibilité de vous désabonner par la suite à tout moment en cliquant sur le lien de désabonnement présent sur chacune de nos alertes.
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10" style="font-size: 10px;">
                 * : Champ obligatoire
              </div>
            </div>
          </form>
    </div>    
</div>
<script type="text/javascript">
    $(function(){
        
        var selectedVille = JSON.parse('<?php if($adherent['code_postal'] != '') echo json_encode(array( 'id' => $adherent['ville'])); else echo "1"; ?>');
        $('#modifier_information').submit(function(data){
            if( $('#js_param_ville_param').val() == "" ){
                selectedVille = {};
            }
            selectedVille = JSON.stringify(selectedVille);
            $('#js_param_ville_vue_espace').attr('value', selectedVille);
            return true;
        });
                  
        function getAutocompletions(query, process){
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
                    getAutocompletions(query, process);
              },
              updater: function (item) {
                  selectedVille = map[item];
                  return item;
              },
              matcher: function (item) {
                  if ( item.toLowerCase().indexOf( this.query.trim().toLowerCase() ) != -1 ) {
                      return true;
                  }
              },
              sorter: function (items) {
                  return items;
              },
              highlighter: function (item) {
                  var regex = new RegExp( '(' + this.query + ')', 'gi' );
                  return item.replace( regex, "<strong>$1</strong>" );
              }
          });
          
    });
</script>