<?php 
    $statut_particulier = '';
    $statut_professionnel = '';
    if( $adherent['statut'] == 'PARTICULIER' ){
        $statut_particulier = 'checked';
    }elseif( $adherent['statut'] == 'PROFESSIONNEL' ){
        $statut_professionnel = 'checked';
    }
    
    if( set_value("email") != "" ){
        $adherent['email'] = set_value("email");
    }
    
    if( set_value("telephone") != "" ){
        $adherent['telephone'] = set_value("telephone");
    }

?>


<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js" type="text/javascript"></script>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h1>Déposer votre annonce <small>Locamax.fr</small></h1>
        </div>
        <?php echo form_open('ajouter-mon-annonce', array('enctype' => 'multipart/form-data', 'id' => 'ajouter-mon-annonce', 'class' => 'form-horizontal', 'role' => 'form' )); ?>
        <?php echo validation_errors(); ?>
        <form class="form-horizontal" role="form">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="" value="<?php echo $adherent['email']; ?>">
              </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Téléphone</label>
                <div class="col-sm-10">
                    <input type="text" name="telephone" class="form-control" value="<?php echo $adherent['telephone']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Titre de l'annonce</label>
                <div class="col-sm-10">
                    <input type="text" name="titre" class="form-control" value="<?php echo set_value('titre'); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Type de bien</label>
                <div class="col-sm-10">
                    <select id="ajout_annonce_in_type" name="type" style="width:100%;" class="form-control">
                        <option>Choissisez un bien</option>
                        <?php foreach( $immobiliers as $immo ): ?>
                            <option <?php echo set_select('type', $immo['identifiant'] ); ?> value="<?php echo $immo['identifiant']; ?>"><?php echo $immo['designation']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Ajouter votre photo <span style="font-size: 10px;">(1 seule photo par annonce)</span></label>
                <div class="col-sm-10">
                    <input type="button" class="btn btn-primary js_ouverture_explorer" value="Ajouter une photo"/>
                    <input style="display:none;" name="photo_to_upload" type="file" id="input_file_photo"/>
                    <div style="padding:10px;" class="col-md-12">
                        <ul id="filesInfo">
                            
                        </ul>                        
                    </div>
                </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                  <textarea class="form-control" id="inputPassword3" name="description" placeholder="" rows="4" ><?php echo set_value('description'); ?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Loyer en €</label>
              <div class="col-sm-10">
                  <input type="number" name="loyer" class="form-control rprix" value="<?php echo set_value('loyer'); ?>">
              </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Ville</label>
                <div class="col-sm-10">
                    <input name="lieu" type="hidden" id="js_param_ville_vue_ajout_annonce" value="" />
                    <input type="text" autocomplete="off" id="js_param_ville_ajout_annonce" class="ville-typeahead form-control" value="<?php echo set_value('lieu'); ?>">
                </div>
            </div>          
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Statut</label>
                <div class="radio">
                    <label>
                      <input name="statut"  <?php echo $statut_particulier; ?> type="radio" VALUE="PARTICULIER"> Particulier
                    </label>
                    <label>
                      <input name="statut"  <?php echo $statut_professionnel; ?> type="radio" VALUE="PROFESSIONNEL"> Professionnel
                    </label>
                </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Ajouter votre annonce</button>
              </div>
            </div>
          </form>
    </div>    
</div>
<script type="text/javascript">
    $(function(){
        
        $('.rprix').blur(function(){
            var prix = $(this).val();
            console.log(prix);
            prix = prix.replace(',', '.');
            console.log(prix);
            $(this).attr('value', prix);
        });
        var nombre_photo = 0;
        function fileSelect(evt) {
            if (window.File && window.FileReader && window.FileList && window.Blob) {
                var files = evt.target.files;

                var result = '';
                var file;
                for (var i = 0; file = files[i]; i++) {
                    // if the file is not an image, continue
                    if (!file.type.match('image.*')) {
                        continue;
                    }
                    if( nombre_photo < 1 ){
                        nombre_photo = 1;
                    }
                    else{
                        return;
                    }
                    reader = new FileReader();
                    reader.onload = (function (tFile) {
                        return function (evt) {
                            var div = document.createElement('div');
                            div.innerHTML = '<li style="list-style:none;" class="col-md-4"><img style="width: 150px;" class="thumbnail" src="' + evt.target.result + '" /></li>';
                            document.getElementById('filesInfo').appendChild(div);
                        };
                    }(file));
                    reader.readAsDataURL(file);
                }
            } else {
                alert('The File APIs are not fully supported in this browser.');
            }
        }

        document.getElementById('input_file_photo').addEventListener('change', fileSelect, false);

        $('.js_ouverture_explorer').click(function(){
            $('#input_file_photo').click();
        });
        
        var selectedVille = '';
        $('#ajouter-mon-annonce').submit(function(data){
            
            if( typeof($('#ajout_annonce_in_type option:selected').val()) === 'undefined' || $('#ajout_annonce_in_type option:selected').val() == '' ){
                $('#ajout_annonce_in_type').css('border-color', 'red');
                return false;
            }
            
            selectedVille = JSON.stringify(selectedVille);
            $('#js_param_ville_vue_ajout_annonce').attr('value', selectedVille);
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