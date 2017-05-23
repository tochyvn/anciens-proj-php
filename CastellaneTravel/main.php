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
        <link href="css/bootstrap.css" rel="stylesheet">
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

        <!-- Custom CSS -->
        <link href="css/clean-blog.css" rel="stylesheet">
        
        <link href="css/map-google.css" rel="stylesheet">
        <link href="css/testCSS.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/menuMetro.css" rel="stylesheet">
        <!--<link href="css/clean-blog.min.css" rel="stylesheet"> -->

        <!-- Custom Fonts -->
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

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
                            <a href="index.php">Acceuil</a>
                        </li>
                        <li>
                            <a href="#">Catalogue</a>
                        </li>
                        <li>
                            <a href="#">Produits</a>
                        </li>
                        <li>
                            <a href="#">Societés</a>
                        </li>
                        <li>
                            <a href="#">Connexion</a>
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
        <header class="intro-header" style="background-image: url(<?php if ($nextWeek > "20:00"):?>'img/home-night.jpg'<?php else : ?>'img/home-day.jpg'<?php endif ?>)">
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
        




<div class="container inscription_connexion" >
    <div class="row" >
        <div class="col-lg-5 col-md-5" style="min-height: 400px; ">
            <h3>Vous etes deja client veillez vous connecter</h3>
            <div class="form-connexion">
            <form id="form-connexion" action="<?php //echo site_url('auth/connexion'); ?>" method="POST">
            <!--
            <p>
                <input type="hidden" name="action" value="connexion" />
            </p>
            -->
            <p>
                <label>Email : </label>
                <input type="text" name="email" class="form_required valid_email" required />
            </p>
            <p>
                <label>Mot de passe : </label>
                <input type="password" name="passwd" class="form_required" required/>
            </p>
            <p class="valider">
                <input type="submit" value="Connexion" />
            </p>
            </form>
            </div>
        </div>
        <div class="col-lg-7 col-lg-offset-0 col-md-5 col-md-offset-2" >
            <h3 >Vous n'êtes pas client veillez vous inscrire</h3>
            <div class="form-subscribe">
                <div class="error-msg"></div>
                <div class="success-msg"></div>
                <form id="form-subscribe" action="<?php //echo site_url('auth/signin'); ?>" method="POST">
                    <p>
                        <label for="nom">Nom : </label>
                        <input type="text" name="nom" id="nom" class="form_required" required />
                    </p>
                    <p>
                        <label for="pseudo">Pseudonyme : </label>
                        <input type="text" name="pseudo" id="pseudo" class="form_required" required />
                    </p>
                    <p>
                        <label for="email">Email : </label>
                        <input type="email" name="email" id="email" class="form_required valid_email" required />
                    </p>
                    <p>
                        <label for="passwd">Mot de passe : </label>
                        <input type="password" name="passwd" id="passwd" class="form_required" required />
                    </p>
                    <p>
                        <label for="passwd1">Confirmer mot de passe : </label>
                        <input type="password" name="passwd1" id="passwd1" class="form_required" required />
                    </p>
                    <p>
                        <label for="adresse">Adresse : </label>
                        <input type="text" name="adresse" id="adresse" class="form_required" required />
                    </p>
                    <p>
                        <label for="ville">Ville : </label>
                        <input type="text" id="ville" name="ville" class="form_required" autocomplete="off" required />
                        <input type="hidden" name="id_ville" id="id_ville" />
                    </p>
                    <p class="valider">
                        <input type="submit" value="Inscription" />
                    </p>
                </form>
            </div>
        </div>
    </div>   
</div>

        
        
<div class="footer">
            <div class="container">
                <div class="row">
                    
                    <div class="col-footer col-sm-4 ">
                        <h3>Navigation</h3>
                        <ul class="no-list-style footer-navigate-section">
                            <li><a href="#">Accueil</a></li>
                            <li><a href="#">Decouvrir</a></li>
                            <li><a href="#">Savoir</a></li>
                            <li><a href="#">Proposer</a></li>
                            <li><a href="#">Nous contacter</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-footer col-sm-4">
                        <h3>Liens utiles</h3>
                        <ul class="no-list-style footer-navigate-section">
                            <li><a href="#">Réseau de la RTM</a></li>
                            <li><a href="#">Office du tourisme</a></li>
                            <li><a href="#">Centrale des Taxis</a></li>
                            
                        </ul>
                    </div>
                    <div class="col-footer col-sm-4">
                        
                        <h3>Réseaux sociaux</h3>
                        <ul class="footer-stay-connected no-list-style">
                            <li><a href="#" class="facebook"></a></li>
                            <li><a href="#" class="twitter"></a></li>
                            <li><a href="#" class="googleplus"></a></li>
                        </ul>
                    </div>
                    
                    
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-copyright">&copycopyright 2015 Popcorn Travelers. All rights reserved.</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <!-- <script src="js/clean-blog.min.js"></script> -->
        <script src="js/clean-blog.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/testJS.js"></script>
        <script>
            $(document).ready(function() {
                $("#menuSide").sticky({topSpacing:70});
                $('.menu').on('click', function(ev) {
                    $('.menu').toggleClass('active');
                });
            });
        </script>

    </body>

</html>        
