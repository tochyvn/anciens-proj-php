<!DOCTYPE HTML>
<html lang="fr">
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- BOOTSTRAP + JQUERY -->
        <link href="<?php echo base_url(); ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>/assets/css/yamm.css" rel="stylesheet" type="text/css">
        <script href="<?php echo base_url(); ?>/assets/bootstrap/js/bootstrap.min.js" type='text/javascript'></script>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js" text="text/javascript"></script>

        <!--FONTS-->
        <link href="<?php echo base_url(); ?>/assets/css/front.css" rel="stylesheet" type="text/css">
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" text="text/javascript"></script>
        <script src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js" text="text/javascript"></script>
        <link href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" text="text/css" rel="stylesheet">
        <link href="http://www.locamax.fr/assets/css/bootstrap-social.css" text="text/css" rel="stylesheet">
        <link href="http://www.locamax.fr/assets/design/jquery-ui-1.11.1.custom/jquery-ui.css" text="text/css" rel="stylesheet">
        <script src="http://www.google.com/adsense/search/ads.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="navbar navbar-default" id="barre_superieur">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-1 col-md-1 col-sm-1">
                        <div class="navbar-header">
                            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main" style="margin-right:0px;">
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-offset-1 col-sm-10">
                        <div class="navbar-collapse collapse" id="navbar-main">
                            <ul id="nav_ul" class="nav navbar-nav navbar-right">
                                <li>
                                    <a title="" href="<?php echo site_url( 'ajouter-une-alerte' ); ?>">Créer une alerte personnalisée</a>
                                </li>
                                <li>
                                    <a title="" href="<?php echo site_url( 'consulter-mes-alertes' ); ?>">Mon compte</a>
                                </li>
                                <li>
                                    <a title="" href="<?php echo site_url( 'logout' ); ?>">Deconnexion</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-default no-dsp" id="barre_scroll">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-1 col-md-1 col-sm-1">
                        <div class="navbar-header">
                            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main" style="margin-right:0px;">
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-offset-1 col-sm-10">
                        <div class="navbar-collapse collapse" id="navbar-main">
                            <ul id="nav-selection" class="nav navbar-nav navbar-right">
                                <li>
                                    <span class="call-to-action">
                                        <button class="btn btn-sm">
                                            <i class="glyphicon glyphicon-bookmark"></i> Consulter ma sélection ( 5 )
                                        </button>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>       
        <?php echo $output; ?> 
    </body>
</html>

<style>
    #encart-pub{
        text-align: center;
    }
    
    #nav-selection{
        margin-top:10px;
    }
    
    .no-dsp{
        display: none;
    }
    
    .fixed-navbar-selection{
        position: absolute;
        top : 0%;
    }
    
    #barre_superieur, #barre_scroll{
        background-color : #1c5290;;
        color : white;
        border-radius: 0px;
    }
    
    #barre_superieur a, #barre_scroll a{
        color : white;
    }
    
    .call-to-action{
        padding:15px;
        text-align: right;
    }
    
    .call-to-action button{
        background-color : #fe7503;
        color : white;
    }
    
    .call-to-action button:hover{
        color : white;
    }
    
    .liste{
        margin-top:20px;
        overflow: hidden;
    }
    
    .texte-tete-liste{
        text-align: center;
    }
    
    .lien-action{
        font-size: 12px;
        cursor:pointer;
    }
    
    .btn-action{
        background-color: #1c5290;
        color: #ffffff;
    }

    .btn-action:hover{
        color: #ffffff;
        text-decoration: underline;
    }
            
    .box-recherche span.nbr-recherche{
        font-weight: bold;
    }
    
    .label-orange{
        color: #fe7503;
    }
    
    .label-rouge{
        color: red;
    }
    
    .label-vert{
        color: green;
    }
    
    .label-bold{
        font-weight: bold;
    }
    
    .box-recherche{
        border: solid 1px #cccccc;
        padding:10px;
        border-radius: 2px;
        margin-bottom: 15px;
    }
    
    .box-recherche .ligne{
        text-align: center;
        margin-top:5px;
        margin-bottom:5px;
    }
    
    #container_liste{
        background-color: #f2f2f2;
        padding:10px;
        border-radius: 2px;
    }
    
    #bandeau_pub_sup{
        text-align: center;
    }
    #nav_ul{
        float: right;
    }
    
    #nav_ul li{
        float: left;
        list-style: none;
    }
    
    #nav_ul li>a{
        padding-left:10px;
        padding-right:10px;
        border-right: 1px solid #144277; 
    }
    
    #nav_ul li:hover{
        background: #144277;
    }
    
    #nav_ul li:last-child>a{
        border-right: none;
    }
</style>