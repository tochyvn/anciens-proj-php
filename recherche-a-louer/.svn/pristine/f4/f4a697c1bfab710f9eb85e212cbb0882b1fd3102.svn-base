<?php 

    function calculerAbonnementRestant( $time ){
        $nombre_jour_exact =  $time / 86400 ; 
        $nombre_jour_arr = ceil($nombre_jour_exact) -1;
        if( $nombre_jour_arr < 0 ){
            $nombre_jour_arr = 0;
        }
        $nombre_heure = ceil(($nombre_jour_exact - ( $nombre_jour_arr ) )*86400/3600);
        if( $nombre_heure == 24 ){
            $nombre_jour_arr++;
            $nombre_heure = 0;
        }
        return array('nombre_jour' => $nombre_jour_arr, 'nombre_heure' => $nombre_heure );
    }
    
    $adherent = $this->session->userdata('utilisateur');
    $abonne = $this->session->userdata('premium');
    $session = true;
    if( !isset( $adherent ) || empty ( $adherent ) || $adherent == false ){
        $session = false;
    }  
    if ( $abonne == true ){
        $abonnement =  $this->session->userdata('abonnement');
        $delai_restant = $abonnement['temps_restant'];
        $time = calculerAbonnementRestant( $delai_restant );
        $pass = $abonnement['label']; 
    }
    $adherent['email'] = "guillaume.cozic@gmail.com";
?>
<div class="container">
    <div class="row">
        <div class="col-md-3" id="espace_left_content">
            <div class="row">
                <div class="col-md-12 label-center">
                    <span class="label-bold">Bonjour <?php echo $adherent['email']; ?></span>
                </div>
            </div>
            <div class="delim">                
            </div>
            <?php if( $abonne == true ): ?>
                 <strong>Abonnement Premium</strong></br></br>
                 <i class="glyphicon glyphicon-time"></i>&nbsp;<?php echo $pass.' reste : '.$time['nombre_jour'].' jour(s) et '.$time['nombre_heure'].' heure(s)'; ?>
                <div class="delim"></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">
                    <ul id="menu_espace" class="nav nav-pills nav-stacked">
                        <?php foreach( $this->menu as $menu ): ?>  
                        <li class="<?php echo $menu['state']; ?>"><a href="<?php echo $menu['url']; ?>"><i class="<?php echo $menu['class']; ?>"></i>&nbsp;<?php echo $menu['label']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="delim">                
            </div>
            <div class="row">
                <div class="col-md-12" id="espace_pub">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:250px;height:280px"
                         data-ad-client="ca-pub-9592588828246820"
                         data-ad-slot="6132024098"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
            <div class="delim">                
            </div>
        </div>
        <div class="col-md-8" id="espace_body_content">
            <?php $this->load->view($vue_action); ?>    
        </div>
    </div>
</div>

<style>
    #espace_pub{
        text-align: center;
    }
    .nav-pills>li.active>a{
        border-radius: 0px;
    }
    
    .nav-pills>li:hover>a{
        border-radius: 0px;
    }
    
    .delim{
        margin-top:10px;
        margin-bottom:10px;
        border-bottom: 1px solid #eee;
    }
    #espace_left_content, #espace_body_content{
        border: solid 1px #cccccc;
        padding:10px;
        border-radius: 2px;
        margin-bottom: 15px;
    }
    #espace_body_content{
        margin-left:5px; 
    }
    .label-center{
        text-align: center;
    }
</style>