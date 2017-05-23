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
                            <a href="#">Question</a>
                        </li>
                        <li>
                            <a href="#">Reponse</a>
                        </li>
                        <li>
                            <a href="#">Yolo</a>
                        </li>
                        <li>
                            <a href="#">Langue</a>
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

        <!-- Main Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-1  hidden-sm hidden-xs">
                <!--<nav class='menu'>
                        <input checked='checked' class='menu-toggler' id='menu-toggler' type='checkbox'>
                        <label for='menu-toggler'></label>
                        <ul>
                          <li class='menu-item'>
                            <a class='fa fa-facebook' href='https://www.facebook.com/' target='_blank'></a>
                          </li>
                          <li class='menu-item'>
                            <a class='fa fa-google' href='https://www.google.com/' target='_blank'></a>
                          </li>
                          <li class='menu-item'>
                            <a class='fa fa-dribbble' href='https://dribbble.com/' target='_blank'></a>
                          </li>
                          <li class='menu-item'>
                            <a class='fa fa-codepen' href='http://codepen.io/' target='_blank'></a>
                          </li>
                          <li class='menu-item'>
                            <a class='fa fa-linkedin' href='https://www.linkedin.com/' target='_blank'></a>
                          </li>
                          <li class='menu-item'>
                            <a class='fa fa-github' href='https://github.com/' target='_blank'></a>
                          </li>
                        </ul>
                    </nav> -->
                    <div id="menuSide">
                        <div class="menu"id="menuSide">
                            <div class='bar'></div>
                            <div class='bar'></div>
                            <div class='bar'></div>  
                        </div>
                        <ul>
                            <li><a>Home</a></li>
                            <li><a>About</a></li>
                            <li><a>Pricing</a></li>
                            <li><a>Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h2 class="section-heading">The Final Frontier</h2>
                        <p>There can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>
                        <p>There can be no thought of finishing for ‘aiming for the stars.’ Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>
                        <blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>
                        <p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>
                        <a href="#">
                            <img class="img-responsive" src="img/post-sample-image.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-4 col-md-10 col-md-offset-2 hidden-sm hidden-xs">
                   <?php include'include/MenuMetro.php' ?>
                </div>
            </div>
        </div>

        <hr>

        <!-- Footer -->
        <?php
        include 'include/footer.php';
        ?>

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
                })
            });
        </script>

    </body>

</html>
