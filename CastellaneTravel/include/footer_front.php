<div class="footer">
            <div class="container">
                <div class="row">
                    
                    <div class="col-footer col-sm-4 ">
                        <h3>Navigation</h3>
                        <ul class="no-list-style footer-navigate-section">
                            <li><a href="#">Accueil</a></li>
                            <li><a href="#">Decouvrir</a></li>
                            <li><a href="#">Catalogue</a></li>
                            <li><a href="#">Sociétés</a></li>
                            <li><a href="<?php if (!isset($_SESSION['email'])) { echo site_url('auth/authenfier');  ?>">Connexion</a><?php } else { echo site_url('auth/deconnexion');  ?>">Deconnexion</a><?php }?></li>
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
        <!--
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript 
        <script src="js/bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <!-- <script src="js/clean-blog.min.js"></script>
        <script src="js/clean-blog.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/testJS.js"></script>
        -->
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