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
			<a class="navbar-brand" href="index.html">Start Bootstrap</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="index.php">Acceuil</a>
				</li>
				<li>
					<a href="page/decouvrir.php">Decouvrir</a>
				</li>
				<li>
					<a href="page/evenement.php">Evenement</a>
				</li>
				<li>
					<a href="page/societe.php">Societe</a>
				</li>
				<li>
					<a href="page/moncompte.php">Mon compte</a>
				</li>
				<li>
					<a href="#">Langue </a>
				</li>
                                <?php// var_dump ($_SESSION['user']);?>
                                <?php// if(!isset($_SESSION['user'])){ ?>
				<li>
                                    <a href="include/connexion.php">Connexion</a>
				</li>
                                <?php //} else{ ?>
                                <li>
                                    <a href="include/scriptDeco.php">Déconnexion</a>
                                </li>
                                <?php //}?>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>