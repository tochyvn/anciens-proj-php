<div class="row">
    <form action="" role="form"  method="get" >
    <div class="col-md-4 col-md-offset-2 marginbottom25">
        <select multiple class="multiselect form-control">
            <option value="">Choix du type</option>
            <option value="TOUS">Tous les types de biens</option>
            <option value="1">Chambre</option>
            <option value="2">Chambre de bonne</option>
            <option value="3">Appartement studio</option>
            <option value="4">Appartement T1</option>
            <option value="5">Appartement T2</option>
            <option value="6">Appartement T3</option>
            <option value="7">Appartement T4</option>
            <option value="8">Appartement T5 et plus</option>
            <option value="9">Maison / Villa</option>
            <option value="10">Garage</option>
            <option value="11">Parking</option>
            <option value="12">Box</option>
            <option value="13">Cave</option>
            <option value="14">Colocation</option>
            <option value="15">Loft</option>
            <option value="16">Duplex</option>
            <option value="17">Triplex</option>
            <option value="18">Local</option>
            <option value="19">Bateau</option>
            <option value="20">Immeuble</option>
            <option value="21">Terrain</option>
            <option value="22">Ferme</option>    
        </select>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input  id="example" data-toggle="tooltip" data-placement="left" title="Tooltip on left"class="col-xs-12 form-control typeahead" autocomplete="off" type="text" placeholder="Saisissez la ville ou code postal">
        </div>
    </div>
    <button type="submit" class="btn btn-primary" name="annonce_submit">Rechercher</button>
  </form>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <span class="ligne_1">Aujourd’hui, <?php //echo $nombreAnnonceMoins3Jour; ?> annonces de locations à l’année trouvées </span>
        <br/><span>dans la Presse & sur le Web</span>
    </div>
</div>