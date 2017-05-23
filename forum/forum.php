<?php
session_start();
require 'includes/form_helper.php';
//require 'includes/load_page.php';

$erreurs = $_SESSION['errors'];
//var_dump($_SESSION);

$form_active = false;
if(isset($_SESSION['form_active'])) {
    $form_active = $_SESSION['form_active'];
}
?><!DOCTYPE html>
<html>
	<head>
		<title>Forum PHP</title>
		<meta charset="UTF-8"/>
		<meta name="description" content="Forum Php réalisé dans le cadre de l'enseignement dispensé au sein de l'intitut G4"/>
		<meta name="keywords" content="Forum, Sujet, Commentaire, Institut G4, Web, PHP, HTML, CSS, 4IM, 4MM"/>
		<meta name="author" content="Tochap Ngassam Lionnel, Bonifay Thomas"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">

		<link rel="stylesheet" href="css/bootstrap.css">

		<link rel="stylesheet" type="text/css" href="css/style.css">
		
	</head>
	<body>

		<div>
			<div class="row-fluid">
				<nav class="navbar navbar-inverse" id="anchor_top">
				  	<div class="container-fluid  width_100">
				    	<div class="navbar-header">
				      	<a class="navbar-brand" href="#">Forum Php Tochap-Bonifay</a>
				   		</div>
					    <ul class="nav navbar-nav">
					      <li class="active navbar"><a href="#">Accueil</a></li>
					      <li class="nav_bar"><a href="Administration.php">Administration</a></li> 
					      <li class="nav_bar"><a href="listpost.php">Forum</a></li> 
					    </ul>
 				 	</div>
				</nav>
			</div>
		</div>

		<div class="row spacetop width_100">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="panel panel-default box_shadow">
 					<div class="panel-body">
 						<div class="row">
 							<div class="col-md-12">
 							<?php if (isset($_SESSION['flash']['success'])) { ?>
 								<div class="alert spacetop spacebot alert-success" id="error_main">
							 		<strong><?php echo $_SESSION['flash']['success']; ?></strong>
								</div><?php } 
								if (isset($_SESSION['flash']['error'])) { ?>
 								<div class="alert spacetop spacebot alert-danger" id="error_main">
							 		<strong><?php echo $_SESSION['flash']['error']; ?></strong>
								</div><?php } ?>
 							</div>
 						</div>
 						<div class="row">
 							<div class="col-md-6"><?php 
 									//Si il y a des erreurs sur le formulaire de connexion
                        			if (COUNT($erreurs) > 0 && $form_active == 'login' ) {
 								 ?>
 								<div class="msg_error spacetop ">
 									<h1 class="align_center titre_error"><span class="glyphicon glyphicon-remove-circle valign"></span> Les informations que vous avez rentrées sont invalides</h1>
 									<ul class="nodeco">
 										<?php 
 											foreach ($_SESSION['errors'] as $error) { ?>
 										<li><?php echo $error; ?></li>
 										<?php	
 											}
 										 ?>
 									</ul>
 								</div><?php } ?>
 								<h1 class="color_violet">Formulaire de connexion</h1>
 								<form id="form_connexion" action="actions/login.php" method="post">
 									<div class="form-group">
									  	<label class="color_violet" for="mail">Email<span>*</span></label>
									  	<input type="text" class="form-control" id="mail" name="mail" value="<?php echo setValue("mail"); ?>"/>
									  	<div class="error_js">
									  		<p class="msg_error spacetop">Le format de l'email que vous avez rentré est invalide</p>
									  	</div>
									</div>
									<div class="form-group">
									  <label class="color_violet" for="password">Mot de passe<span>*</span></label>
									  <input type="password" name="password" class="form-control" id="password">
									  <div class="error_js">
									  	<p class="msg_error spacetop">Le mot doit contenir au moins 6 caractères</p>
									  </div>
									</div>
									<button type="submit" class="btn button btn-block" name="login" type="submit" value="connexion" id="connexion_validate">Connexion</button>
 								</form>
                                                                
 								<div class="spacetop">
 									<span data-toggle="modal" data-target="#Modal_mdp" ><a class="pointer" href="#Modal_mdp">Mot de passe oublié</a></span>
 								</div>

								<div id="Modal_mdp" class="modal fade" role="dialog">
  									<div class="modal-dialog">

								    <!-- Modal content-->
								    	<div class="modal-content">
								      		<div class="modal-header">
								      	 		<h4 class="modal-title color_violet align_center">Changement de mot de passe</h4>
								      		</div>
								      		<div class="modal-body">
								      			<form action="actions/send_mail_updating.php" method="post">
								      				<div class="form-group">
									  					<label class="color_violet" for="mail_modal">Email</label>
									  					<input type="text" class="form-control" id="mail_modal" name="email_update">
									  				<div class="error_js">
									  				<p class="msg_error spacetop">Le format de l'email que vous avez rentré est invalide</p>
									  				</div>
												</div>
												<button type="submit" class="btn button btn-block button">Envoyer moi un mail</button>
								      			</form>
								     		</div>
								     		<div class="modal-footer">
								        		<button type="button" class="btn button btn-default button" data-dismiss="modal">Close</button>
								     		</div>
								    	</div>

							 		</div>
								</div>

 							</div>
 							<div class="col-md-6 vline"><?php
                        
                        	if (COUNT($erreurs) > 0 && $form_active == 'subscribe') {
                        	?>
                        		<div class="msg_error spacetop" id="inscription_error">
 									<h1 class="align_center titre_error"><span class="glyphicon glyphicon-remove-circle valign"></span> Certaines informations que vous avez rentrées sont invalides</h1>
 									<ul><?php 
                            		foreach ($_SESSION['errors'] as $error) {
                                	?>
                                		<li><?echo $error; ?></li>
                            		<?php } ?>
                        			</ul>
 								</div><?php } ?>
 								<h1 class="color_violet">Formulaire d'inscription</h1>
 								<form id="form_inscription" action="actions/subscribe.php" method="post">
 									<div class="form-group">
									  	<label class="color_violet" for="nom">Nom<span>*</span></label>
									  	<input type="text" name="nom" class="form-control" id="nom" value="<?php echo setValue("nom"); ?>"/>
									  	<div class="error_js">
									  		<p class="msg_error spacetop">Ce champ ne doit pas être vide</p>
									  	</div>
									</div>
									<div class="form-group">
									  	<label class="color_violet" for="prenom">Prenom<span>*</span></label>
									  	<input type="text" name="prenom" class="form-control" id="prenom" value="<?php echo setValue("prenom"); ?>"/>
									  	<div class="error_js">
									  		<p class="msg_error spacetop">Ce champ ne doit pas être vide</p>
									  	</div>
									</div>
									<div class="form-group">
									  	<label class="color_violet" for="pseudo">Pseudo<span>*</span></label>
									  	<input type="text" name="pseudo" class="form-control" id="pseudo" value="<?php echo setValue("pseudo"); ?>"/>
									  	<div class="error_js">
									  		<p class="msg_error spacetop">Ce champ ne doit pas être vide</p>
									  	</div>
									</div>
									<div class="form-group">
									  <label class="color_violet" for="mail1">Email<span>*</span></label>
									  <input type="text" name="mail1" class="form-control" id="mail1" value="<?php echo setValue("mail1"); ?>"/>
									  <div class="error_js">
									  	<p class="msg_error spacetop">Le format de l'email rentré est invalide</p>
									  </div>
									</div>
									<div class="form-group">
									  <label class="color_violet" for="password1">Mot de passe<span>*</span></label>
									  <input type="password" name="password1" class="form-control" id="password1">
									  <div class="error_js">
									  	<p class="msg_error spacetop">Ce champ doit contenir au moins 6 caractères</p>
									  </div>
									</div>
									<div class="form-group">
									  <label class="color_violet" for="password1_conf">Confirmation mot de passe<span>*</span></label>
									  <input type="password" name="password1_conf" class="form-control" id="password1_conf">
									  <div class="error_js">
									  	<p class="msg_error spacetop">Ce champ ne peut être vide et doit être identique au mot de passe précédent</p>
									  </div>
									</div>
									<input class="width_100" id="myfile" name="myfile"  type="file">								
									<button type="submit" class="btn button spacetop spacebot btn-block" name="subscribe" value="inscription" id="inscription_validate">Inscription</button>
 								</form>
 							</div>
 						</div>
 					</div>
				</div>
			</div>
			<?php 
            //$_SESSION['auth'] = array();
            $_SESSION['errors']  = array();
            $_SESSION['populate_value'] = array();
            unset($_SESSION['form_active']);
            unset($_SESSION['flash']);
            ?>
			<div class="col-md-2"></div>
		</div>

		<div class="footer row-fluid spacetop">
			<div class="col-md-12 footer">
				<div class="row">
					<div class="col-md-3">
						<a  href="#anchor_top"><img class="img_footer" src="img/Retour_haut.png" alt="Retour haut de page"/></a>
					</div>
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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="js/toch.js"></script>

		
	</body>

</html>