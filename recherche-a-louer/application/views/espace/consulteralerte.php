<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
                <?php $alertes[0] = array( 1); 
                 $alertes[1] = array( 1); 
                        if (!empty($alertes) && !isset($alertes['error'])): ?>
                    <?php foreach ($alertes as $key => $alerte): 
                        $key = $key + 1;
                    ?>
                    <div id="recherche_1" class="box-recherche">
                        <div class="row ligne" >
                            <div class="col-md-12">
                                <span class="label-bold">#2</span> Votre recherche : <span class="label-bold">Studio <br/>
                                    <i class="glyphicon glyphicon-map-marker"></i> à le pradet et 5km autour</span>
                            </div>
                        </div>
                        <div class="row ligne">
                            <div class="col-md-12">
                                <span class="label-orange">
                                    <span class="label-bold">252 annonces</span> correspondent à votre recherche
                                </span>
                            </div>
                        </div>
                        <div class="row ligne">
                            <div class="col-md-12">
                                <button type="button" class="form-control btn btn-action">Accéder à ces annonces</button>
                            </div>
                        </div>
                        <div class="row ligne">
                            <div class="col-md-6">
                                <span class="lien-action"><a>Mettre fin à cette recherche</a></span>
                            </div>
                            <div class="col-md-6">
                                <span class="lien-action"><a>Modifier cette recherche</a></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info" style="text-align: center;">
                        Vous n'avez créer aucune alerte email personnalisé. <br/>
                        <strong><a href="<?php echo site_url( 'ajouter-une-alerte' ); ?>">Cliquer ici pour créer votre première alerte de recherche</a> </strong>
                    </div>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>