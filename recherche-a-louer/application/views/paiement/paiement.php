<link href="<?php echo base_url().'assets/css/funky.css'; ?>" rel="stylesheet" type="text/css"/>
<div class="container">
    <div id="corps-paiement">
        <div class="row div-titre">
            <div class="col-md-12">
                <span class="label-bold">Accès 24H/24, à toutes les annonces détaillées</span><br/><br/>

                Pour <span class="label-orange">visualiser toutes les annonces</span> détaillées,
                vous avez besoin d'un code que vous pouvez obtenir par téléphone ou SMS.<br/>
                Vous pourrez alors naviguer <span class="label-orange">librement</span> et <span class="label-orange">immédiatement</span> 
                entre la liste et le détail des annonces.
            </div>
        </div>
        <div class="row div-allopass">
            <div class="col-md-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Abonnement à la journée</h3>
                        </div>
                        <div class="panel-body">
                            <div id="tarif_allopass">
                                <div class="row" id="div-allopass-haut">
                                    <div class="col-md-6">
                                        <img style="margin-bottom:5px;" alt="sms" width="35" src="http://www.locamax.fr/assets/img/sms-plus5.png"><br>
                                        Pour recevoir votre code par SMS <span class="keyword">envoyez AP au 81038</span><br/>
                                        <small style="font-size: 61%;">
                                            3.00 €/SMS + prix d'un SMS
                                            1 envoi de SMS par code d'accès
                                        </small>
                                    </div>
                                    <div class="col-md-6" id="div-image-sva">
                                        <img alt="sms" class="img-responsive" src="<?php echo base_url( ).'/assets/images/sva_localerte.png'; ?>"><br>
                                        Pour obtenir votre code, appelez le
                                        <span class="keyword">08 99 23 02 21</span><br/>
                                        <small style="font-size: 61%;">Service / appel 
                                            + prix appel</small>
                                    </div>
                                </div>
                                <div class="row" id="div-allopass-bas">
                                    <div class="col-md-12">  
                                        <form class="form-inline" action="" method="POST">
                                            <div class="form-group">
                                                <input placeholder="Saisissez ici le code obtenu" type="text" name="code" value="" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-danger form-control" style="background-color: #c00000;" value="Valider">
                                            </div>
                                        </form>
                                    </div>                     
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-md-6" id="div-wha">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Abonnement 48h</h3>
                    </div>
                    <div class="panel-body" id="body-wha">
                        <div class="col-md-12">
                            Accès immédiat pour 48H en utilisant votre abonnement téléphonique** :<br/>
                        </div>
                        <div class="col-md-12 div-image-wha">
                            <img class="img-responsive" src="<?php echo base_url() . '/assets/images/internetplus.v3.png'; ?>"/>
                        </div>
                        <div class="col-md-12">
                            <small style="font-size: 61%;">**Montant de 3€ débité sur votre prochaine facture</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sélectionnez votre abonnement.</h3>
                    </div>
                    <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="funkyradio"> 
                                            <div class="col-md-6">
                                                <div class="funkyradio-default">
                                                    <input class="radio_choix_pass" data-tarif="ab0005" type="radio" name="radio" id="radio1"/>
                                                    <label for="radio1">Pass 48h : <strong>3 €</strong></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="funkyradio-default">
                                                    <input class="radio_choix_pass" data-tarif="ab0003" type="radio" name="radio" id="radio2"/>
                                                    <label for="radio2">Pass 7 jours : <strong>6 €</strong></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="funkyradio-default">
                                                    <input class="radio_choix_pass" data-tarif="ab0006" type="radio" name="radio" id="radio3" />
                                                    <label for="radio3">Pass 14 jours : <strong>11 €</strong></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="funkyradio-default">
                                                    <input class="radio_choix_pass" data-tarif="ab0007" type="radio" name="radio" id="radio4" />
                                                    <label for="radio4">Pass 21 jours : <strong>16 €</strong></label>
                                                </div>                         
                                            </div>
                                            <div class="col-md-6">
                                                <div class="funkyradio-default">
                                                    <input class="radio_choix_pass" data-tarif="ab0001" type="radio" name="radio" id="radio5" />
                                                    <label for="radio5">Pass 60 jours : <strong>40 €</strong></label>
                                                </div>                             
                                            </div>
                                            <div class="col-md-6">
                                                <div class="funkyradio-default">
                                                    <input class="radio_choix_pass" data-tarif="ab0001" type="radio" name="radio" id="radio5" />
                                                    <label for="radio5">Pass 60 jours : <strong>40 €</strong></label>
                                                </div>                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="modes_paiements" id="paiement_cb_pay_intplus">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <a class="link_to_paiement_paybox" href="http://www.locamax.fr/front/paiement/effectuer/paybox/ab0005">
                                                            <img alt="Cartes Bleues" title="Payer par carte" src="http://www.locamax.fr/assets/img/paiements_cartes.png">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="delim"></div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <a class="link_to_paiement_paypal" href="http://www.locamax.fr/front/paiement/effectuer/paypal/ab0005">
                                                            <img alt="Paypal" title="Payer via Paypal" src="http://www.locamax.fr/assets/img/paiements_paypal.png">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="delim"></div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <a class="link_to_paiement_paypal" href="http://www.locamax.fr/front/paiement/effectuer/paypal/ab0005">
                                                            <img alt="Paypal" title="Payer via Paypal" src="http://static.localerte.fr/adherent/img/wha.png">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<style>
    
    #div-wha{
        text-align: center;
        overflow: hidden;
    }
    
    #body-wha{
        padding: 35px;
    }
    
    .div-image-wha{
        padding:15px;
    }
    
    .div-image-wha img:hover, #div-image-sva:hover img {
        -webkit-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);
    }
    
    .div-image-wha img, #div-image-sva img {
        cursor: pointer;
    }
    
    .delim{
        margin-top:10px;
        margin-bottom:10px;
        border-bottom: 1px solid #eee;
    }
    
    .modes_paiements{
        text-align: center;
        margin-top:28px;
    }
    
    .modes_paiements img:hover {
        -webkit-transform: scale(1.1);
        -ms-transform: scale(1.1);
        transform: scale(1.1);
    }
    
    .keyword, .shortcode{
        font-weight: bold;
        color : #0079C2;
    }
    
    #div-allopass-haut{
        border-bottom: 1px solid #eee;
        padding:20px;
    }
    
    #div-allopass-bas{
        padding:10px;
    }
    
    #tarif_allopass{
        text-align: center;
    }
    
    .div-allopass{
        margin-top:15px; 
    }
        
    .div-titre{
        text-align: center;
    }
    
    .funkyradio-default input[type="radio"]:checked ~ label:before, .funkyradio-default input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #cc0000;
    }

</style>    