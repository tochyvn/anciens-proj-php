<?php 
    function getAffichageDeterminant($chaine){
        switch($chaine){
            case "Web":
                $chaine = "sur le ".$chaine;
            break;
            case "Presse nationale":
                $chaine = "sur la ".$chaine;
            break;
            case "Presse régionale":
                $chaine = "sur la ".$chaine;
            break;
        }
        return $chaine;
    }
    
    function getAffichageStatut($chaine){
        switch($chaine){
            case "PARTICULIER":
                $html = '<strong>Annonce de Particulier</strong>';
            break;
            case "PROFESSIONNEL":
                $html = 'Annonce de Professionnel';
            break;
            default :
                 $html = 'Annonce de Professionnel';
            break;
        }
        return $html;
    }
    
    function getUrlPhoto($photo){
        if($photo == ''){
            $url = base_url().'assets/img/photo.png';
        }
        else{
            $url = $photo;
        }
        return $url;
    }
    
    function getHtmlVisionnage($cookie){
        if(isset($cookie) && $cookie != ''){
            $html = '<img src="'.base_url().'assets/img/vu_ok.png" alt="Annonce déjà consultée"/>';
        }
        else{
            $html = '<img src="'.base_url().'assets/img/vu_ko.png" alt="Annonce pas encore consultée"/>';
        }
        return $html;
    }
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/listeannonces.css'; ?>"/>
<div class="row">
    <div class="liste_annonce col-md-8 col-lg-offset-2">
        <?php 
            foreach($annonces as $annonce): 
                $cookie = '';
                $cookie = get_cookie('annonce_'.$annonce['identifiant']); 
        ?>
            <div class="row">
                <div class="well col-md-12">
                    <div class="col-md-1">
                        <a target="_blank" rel="nofollow" href="<?php echo site_url('front/track/redir/'.$annonce['identifiant']); ?>" class="btn btn-primary">
                            Voir >
                        </a>
                    </div>
                    <div class="photo_annonce col-md-2">
                        <a href="#" class="thumbnail">
                            <img data-src="holder.js/100%x180" src="<?php echo getUrlPhoto($annonce['photo']); ?>" alt="<?php echo $annonce['description'] ?>">
                        </a>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-9">
                            <span>Annonce du <?php echo date("d/m/Y", $annonce['parution']); ?></span><br/>
                            <span>Trouvée par le moteur LOCAMAX <?php echo getAffichageDeterminant($annonce['provenance_classification']); ?></span><br/>
                            <span><?php echo $annonce['type_designation'].' - '.$annonce['ville_nom']; ?></span><br/>
                            <span>Loyer: <?php echo (int)$annonce['prix']; ?>€ - <?php echo getAffichageStatut($annonce['statut']); ?></span>
                            <div>
                                <?php echo getHtmlVisionnage($cookie); ?>
                            </div>
                        </div>
                        <div class="col-md-1 col-md-offset-2">
                            <a href="<?php echo site_url('front/signaler/annonce'.$annonce['identifiant']); ?>">
                                <img  width="22" height="20" title="Signaler un abus pour cette annonce" alt="signaler un abus" src="<?php echo base_url().'/assets/img/abus.png'; ?>" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>