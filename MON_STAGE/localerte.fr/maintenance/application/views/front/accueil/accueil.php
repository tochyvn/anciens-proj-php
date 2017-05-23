<link href="<?php echo base_url().'assets/css/accueil.css'; ?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url().'assets/js/typeahead.js'; ?>" type="text/javascript"></script>
<link href="<?php echo base_url().'assets/css/typeahead.css'; ?>" type="text/css" rel="stylesheet"></script>
<script src="http://www.google.com/adsense/search/ads.js" type="text/javascript"></script>
<div class="container-fluid">
    <div class="col-md-6 col-md-offset-3 well margintop50">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?php $this->load->view('front/accueil/header.php'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                <h3>Recherchez votre location à l’année, partout en France :</h3>
            </div>
        </div>
        <br/>
        <div class="row">
            <form action="" id="recherche_annonce" role="form"  method="get" >
                <div class="col-md-4 col-md-offset-1 marginbottom25">
                    <select multiple class="multiselect form-control">
                        <option value="">Choix du type</option>
                        <option value="TOUS">Tous les types de biens</option>
                        <?php foreach($immobiliers as $immobilier): ?>
                            <option value="<?php echo $immobilier['identifiant']; ?>"><?php echo $immobilier['designation']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input  id="ahead_ville" data-toggle="tooltip" data-placement="left" title="Tooltip on left"class="col-md-12 form-control typeahead" autocomplete="off" type="text" placeholder="Saisissez la ville ou code postal">
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary" name="annonce_submit">Rechercher</button>
                </div>
          </form>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 margintop25">
                <span class="ligne_1">Aujourd’hui, <?php echo $nombreAnnonceMoins3Jour; ?> annonces de locations à l’année trouvées </span>
                <br/><span>dans la Presse & sur le Web</span>
            </div>
        </div>
        <div class="row">
            <?php //$this->load->view('front/google/adsense.php'); ?>
            <div class="adsearch" id="adsearch-accueil"></div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?php $this->load->view('front/accueil/footer.php'); ?>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-6 col-md-offset-4 margintop25 marginbottom25"> 
                <span>© AICOM 2011 - Tous droits réservés</span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        
    $(function(){
        
        $('#recherche_annonce').submit(function(){
            var ville = $('#ahead_ville').val();
            if(ville == ''){
                return false;
            }
            return false;
        });
        
        var villes = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            limit: 10,
            remote: '<?php echo base_url().'index.php/front/ajax_controller/typeAheadGeo/%QUERY'; ?>'
          });

          villes.initialize();

          $('.typeahead').typeahead(null, {
            name: 'villes',
            displayKey: 'value',
            source: villes.ttAdapter()
          });
    });
</script>
