<!DOCTYPE html>
<html>

    <head>
    <!-- Version 00.2-->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Castellane Travel</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo site_url('css/bootstrap.css'); ?>" rel="stylesheet">
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

        <!-- Custom CSS -->
        <link href="<?php echo site_url('css/clean-blog.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('css/toch.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('css/map-google.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('css/testCSS.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('css/footer.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('css/menuMetro.css'); ?>" rel="stylesheet">
        <!--<link href="css/clean-blog.min.css" rel="stylesheet"> -->

        <!-- Custom Fonts -->
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="<?php echo site_url('js/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('js/toch.js'); ?>"></script>
        
        <script type="text/javascript" src="<?php echo site_url('assets/jquery-ui-1.11.4/jquery-ui.min.js'); ?>"></script>
        <link rel="stylesheet" href="<?php echo site_url('assets/jquery-ui-1.11.4/jquery-ui.min.css'); ?>" />
        <script type="text/javascript" src="<?php echo site_url('js/bootstrap.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('js/clean-blog.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('js/jquery.sticky.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('js/testJS.js'); ?>"></script>
        
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            #form-connexion label {
                width: 30%;
                text-align: right;
            }
            #form-subscribe input {
                width: 50%;
            }
            #form-subscribe label {
                width: 40%;
                text-align: right;
            }
            #form-connexion .valider, #form-subscribe .valider {
                margin-left: 35%;
            }
            
            #form-connexion input, #form-subscribe input {
                //border-radius: 0.2em;
            }
            
            .inscription_connexion h3 {
                text-align: center;
                margin-top: 20px;
            }
            
            
        </style>
    </head>

    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">Logo</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="<?php echo site_url(); ?>">Accueil</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('consulter/produits'); ?>">Catalogue</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('consulter/histoire'); ?>">Histoire</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('consulter/architecture'); ?>">Decouvrir</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('auth/authenfier'); ?>">Societés</a>
                        </li>
                        <li>
                            <a href="<?php if (!isset($_SESSION['email'])) { echo site_url('auth/authenfier');  ?>">Connexion</a><?php } else { echo site_url('auth/deconnexion');  ?>">Deconnexion</a><?php }?>
                        </li>
                        <li>
                            <a href="#">Decouvrir</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Header -->
        <!-- Set your background image for this header on the line below. -->
        <?php $nextWeek = date("H:i"); ?>
        <header class="intro-header" style="background-image: url(<?php if ($nextWeek > "20:00"):?>'<?php echo site_url('img/home-night.jpg'); ?>'<?php else : ?>'<?php echo site_url('img/home-day.jpg'); ?>'<?php endif ?>)">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                        <div class="site-heading">
                            <h1>Castellane Travel</h1>
                            <hr class="small">
                            <span class="subheading">Un projet de Popcorn Travelers</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <nav class="container-fluid second_nav">
            <ul class="nav navbar-nav navbar-right">
                       
                        <li>
                            <a href="<?php echo site_url('consulter/produits'); ?>">Mon compte</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('consulter/histoire'); ?>">Panier</a>
                        </li>
                        
                        
                    </ul>
        </nav>