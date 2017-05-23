<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
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
                            <li><a>Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 col-md-10 col-md-offset-1">
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
                <div class="col-lg-3 col-md-2">
                   <div class="map" id="googleMap" style="width:270px;height:600px;"></div>
                </div>
            </div>
        </div>
        
        <hr>
        
        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                        <ul class="list-inline text-center">
                            <li>
                                <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-pinterest fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-muted">Copyright &copy; Your Website 2014</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <!-- <script src="js/clean-blog.min.js"></script> -->
        <script src="js/clean-blog.js"></script>
        
        <script src="js/jquery.sticky.js"></script>
        <script>
            $(document).ready(function(){
                $("#googleMap").sticky({topSpacing:0});
                
                $("#menuSide").sticky({topSpacing:70});
                $('.menu').on('click', function(ev) {
                    $('.menu').toggleClass('active');
                })
            });
        </script>
        <!-- Custom Maps Api JavaScript -->
        <script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>
        <script>
            var myCenter=new google.maps.LatLng(43.285114,5.3837181,16);
            var marker;

            function initialize()
            {
                var mapProp = {
                    center:myCenter,
                    zoom:15,
                    mapTypeId:google.maps.MapTypeId.ROADMAP
                };

                var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

                var marker=new google.maps.Marker({
                    position:myCenter,
                    title:'Click to zoom',
                    animation:google.maps.Animation.BOUNCE
                });

                marker.setMap(map);

                // Zoom to 9 when clicking on marker
                google.maps.event.addListener(marker,'click',function() {
                map.setZoom(9);
                map.setCenter(marker.getPosition());
                });
                marker.setMap(map);
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </body>
</html>
