<!DOCTYPE html>
<html>
	<head>
		<title>Forum PHP</title>
		<meta charset="UTF-8"/>
		<meta name="description" content="Forum Php rŽalisŽ dans le cadre de l'enseignement dispensŽ au sein de l'intitut G4"/>
		<meta name="keywords" content="Forum, Sujet, Commentaire, Institut G4, Web, PHP, HTML, CSS, 4IM, 4MM"/>
		<meta name="author" content="Tochap Ngassam Lionnel, Bonifay Thomas"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="icon" href="/favicon.png" type="image/png" sizes="16x16">

		<link rel="stylesheet" href="../css/bootstrap.css">

		<link rel="stylesheet" type="text/css" href="../css/style.css">
		
	</head>
	<body>

		<div>
			<div class="row-fluid">
				<nav class="navbar navbar-inverse" id="anchor_top">
				  	<div class="container  width_100">
				    	<div class="navbar-header">
                            <a class="navbar-brand" href="#">Forum Php Tochap-Bonifay</a>
			   			</div>
					    <ul class="nav navbar-nav">
					      <li class="navbar"><a href="/forum.php">Accueil</a></li>
					      <li class="nav_bar"><a href="/pages/admin.php">Administration</a></li> 
					      <li class="nav_bar active"><a href="/pages/listsujet.php">Forum</a></li>
					    </ul>
                        <div class="navbar-header pull-right">
                            <span class="navbar-brand">Connect&eacute; en tant que <?php echo $pseudo; ?></span>
                            <a class="navbar-brand" href="../actions/deconnexion.php">Deconnexion</a>
                        </div>
 				 	</div>
                                        
				</nav>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h1 class="color_violet">Panneau d'administration</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">					
			  		<button type="button" href="#" class="btn btn-primary btn-block spacetop spacebot">Utilisateur</button>
			  		<button type="button" href="#" class="btn btn-primary btn-block spacetop spacebot">Message</button>
			  		<button type="button" href="#" class="btn btn-primary btn-block spacetop spacebot">Sujet</button>					  	
				</div>
				<div class="col-md-10">
				<!-- Partie Utilisateur -->
					<div class="row spacebot">
						<div class="panel panel-default box_shadow">
						 	<div class="panel-body">
						 		<div class="row">
							 		<div class="col-md-3">
							 			<p class="color_violet bold">Pseudo</p>
							 		</div>
							 		<div class="col-md-3">
							 			<p class="color_violet bold">Nom</p>
							 		</div>
							 		<div class="col-md-3">
							 			<p class="color_violet bold">Prenom</p>
							 		</div>
							 		<div class="col-md-1"></div>
							 		<div class="col-md-1"></div>
							 		<div class="col-md-1"></div>
						 		</div>
						 	</div>
						</div>
					</div>
					<div class="row spacebot">
						<div class="panel panel-default box_shadow">
						 	<div class="panel-body">
						 		<div class="row">
							 		<div class="col-md-3">
							 			<p><?php echo $pseudo; ?></p>
							 		</div>
							 		<div class="col-md-3">
							 			<p><?php echo $nom; ?></p>
							 		</div>
							 		<div class="col-md-3">
							 			<p><?php echo $prenom; ?></p>
							 		</div>
							 		<div class="col-md-1"></div>
							 		<div class="col-md-1">
							 			<img src="../img/Bannir.png" alt="Bannir" title="cliquer pour bannir l'utilisateur" class="admin_icon" />
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Supprimer.png" alt="Supprimer" title="cliquer pour supprimer l'utilisateur" class="admin_icon" />
							 		</div>
						 		</div>
						 	</div>
						</div>
					</div>
					<div class="row spacebot">
						<div class="panel panel-default box_shadow">
						 	<div class="panel-body">
						 		<div class="row">
							 		<div class="col-md-3">
							 			<p><?php echo $pseudo; ?></p>
							 		</div>
							 		<div class="col-md-3">
							 			<p><?php echo $nom; ?></p>
							 		</div>
							 		<div class="col-md-3">
							 			<p><?php echo $prenom; ?></p>
							 		</div>
							 		<div class="col-md-1"></div>
							 		<div class="col-md-1">
							 			<img src="../img/Bannir.png" alt="Bannir" title="cliquer pour bannir l'utilisateur" class="admin_icon" />
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Supprimer.png" alt="Supprimer" title="cliquer pour supprimer l'utilisateur" class="admin_icon" />
							 		</div>
						 		</div>
						 	</div>
						</div>
					</div>
				<!-- Fin partie Utilisateur -->
				<!-- Partie Message -->
					<div class="row spacebot">
						<div class="panel panel-default box_shadow">
						 	<div class="panel-body">
						 		<div class="row">
							 		<div class="col-md-3">
							 			<p class="color_violet bold">Pseudo</p>
							 		</div>
							 		<div class="col-md-7">
							 			<p class="color_violet bold">Message</p>
							 		</div>
							 		<div class="col-md-1"></div>
							 		<div class="col-md-1"></div>
						 		</div>
						 	</div>
						</div>
					</div>
					<div class="row spacebot">
						<div class="panel panel-default box_shadow">
						 	<div class="panel-body">
						 		<div class="row">
							 		<div class="col-md-3">
							 			<p><?php echo $pseudo; ?></p>
							 		</div>
							 		<div class="col-md-7">
							 			<p><?php echo $message; ?></p>
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Bannir.png" alt="Bannir" title="cliquer pour bannir l'utilisateur" class="admin_icon" />
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Supprimer.png" alt="Supprimer" title="cliquer pour supprimer l'utilisateur" class="admin_icon" />
							 		</div>
						 		</div>
						 	</div>
						</div>
					</div>
					<div class="row spacebot">
						<div class="panel panel-default box_shadow">
						 	<div class="panel-body">
						 		<div class="row">
							 		<div class="col-md-3">
							 			<p><?php echo $pseudo; ?></p>
							 		</div>
							 		<div class="col-md-7">
							 			<p><?php echo $message; ?></p>
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Bannir.png" alt="Bannir" title="cliquer pour bannir l'utilisateur" class="admin_icon" />
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Supprimer.png" alt="Supprimer" title="cliquer pour supprimer l'utilisateur" class="admin_icon" />
							 		</div>
						 		</div>
						 	</div>
						</div>
					</div>
				<!-- Fin partie Message -->
				<!-- Partie Sujet -->
					<div class="row spacebot">
						<div class="panel panel-default box_shadow">
						 	<div class="panel-body">
						 		<div class="row">
							 		<div class="col-md-3">
							 			<p class="color_violet bold">Pseudo</p>
							 		</div>
							 		<div class="col-md-7">
							 			<p class="color_violet bold">Sujet</p>
							 		</div>
							 		<div class="col-md-1"></div>
							 		<div class="col-md-1"></div>
						 		</div>
						 	</div>
						</div>
					</div>
					<div class="row spacebot">
						<div class="panel panel-default box_shadow">
						 	<div class="panel-body">
						 		<div class="row">
							 		<div class="col-md-3">
							 			<p><?php echo $pseudo; ?></p>
							 		</div>
							 		<div class="col-md-7">
							 			<p><?php echo $sujet; ?></p>
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Bannir.png" alt="Bannir" title="cliquer pour bannir l'utilisateur" class="admin_icon" />
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Supprimer.png" alt="Supprimer" title="cliquer pour supprimer l'utilisateur" class="admin_icon" />
							 		</div>
						 		</div>
						 	</div>
						</div>
					</div>
					<div class="row">
						<div class="panel panel-default box_shadow">
						 	<div class="panel-body">
						 		<div class="row">
							 		<div class="col-md-3">
							 			<p><?php echo $pseudo; ?></p>
							 		</div>
							 		<div class="col-md-7">
							 			<p><?php echo $sujet; ?></p>
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Bannir.png" alt="Bannir" title="cliquer pour bannir l'utilisateur" class="admin_icon" />
							 		</div>
							 		<div class="col-md-1">
							 			<img src="../img/Supprimer.png" alt="Supprimer" title="cliquer pour supprimer l'utilisateur" class="admin_icon" />
							 		</div>
						 		</div>
						 	</div>
						</div>
					</div>
				<!-- Fin partie Sujet -->
				</div>

			</div>
		</div>

		<div class="footer row-fluid spacetop">
			<div class="col-md-12 footer">
				<div class="row">
					
					<div class="col-md-4">
						<p class="container_w3c_css">
							<a href="http://jigsaw.w3.org/css-validator/check/referer">
						    	<img src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !" />
						    </a>
						</p>
					</div>
				</div>	
			</div>
		</div>
	</body>
</html>