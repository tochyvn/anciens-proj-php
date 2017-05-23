<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>PHP - Cours - Exemples 1ère année</title>
    <meta name="description" content="Exemple de PHP">
    <meta name="author" content="Mathieu Shizuka - Développeur Web - Intégrateur - Formateur">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="http://code.jquery.com/jquery-2.1.4.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<style>body {padding: 0px 25%;}</style>

  </head>
  <body>

		<?php

		// Si vous n'arrivez pas à vous connecter à votre WAMP / MAMP renseignez les bonnes informations ici.
		// Et surtout : n'y touchez pas !

				$host="127.0.0.1";
				$root="root";
				$root_password="";

		    try {
		        $dbh = new PDO("mysql:host=$host", $root, $root_password);
		        $dbh->exec("

						CREATE DATABASE IF NOT EXISTS `exemplephpg4` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
				    USE `exemplephpg4`;

				    -- --------------------------------------------------------

				    --
				    -- Structure de la table `etudiants`
				    --

				    CREATE TABLE IF NOT EXISTS `etudiants` (
				      `id` int(11) NOT NULL AUTO_INCREMENT,
				      `nom` varchar(100) NOT NULL,
				      `prenom` varchar(100) NOT NULL,
				      `age` int(11) NOT NULL,
				      PRIMARY KEY (`id`)
				    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

						-- Insertion d'un jeu de test
						-- INSERT INTO `exemplephpg4`.`etudiants` (`id`, `nom`, `prenom`, `age`) VALUES (NULL, 'Mathieu', 'Shizuka', '23');

						");

		    } catch (PDOException $e) {
		        die("DB ERROR: ". $e->getMessage());
		    }
		?>

		<div class="page-header">
		  <h1>Examples PHP</br><small>by ARCAD</small></h1>
		</div>

		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

			<!-- 1. Echo -->
		  <div class="panel panel-success">
		    <div class="panel-heading" role="tab" id="headingOne">
		      <h4 class="panel-title">
		        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
		          #1. Echo
		        </a>
		      </h4>
		    </div>
		    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>&lt;?php</br></br>
						$nom = "Mathieu";</br>
						echo 'Bonjour ';</br>
						echo $nom;</br>
						echo ' !';</br></br>
						?&gt;</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						$nom = "Mathieu";
						echo 'Bonjour ';
						echo $nom;
						echo ' !';

						?>
					</div>
		    </div>
		  </div>

			<!-- 2. Commentaires -->
		  <div class="panel panel-success">
		    <div class="panel-heading" role="tab" id="headingTwo">
		      <h4 class="panel-title">
		        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
		          #2. Commentaires
		        </a>
		      </h4>
		    </div>
		    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>&lt;?php</br></br>
						// Commentaire sur une ligne.</br>
						// Et voici un commentaire sur plusieurs lignes</br>
						/* $nom = "Mathieu";</br>
						echo 'Bonjour ';</br>
						echo $nom;</br>
						echo ' !';*/</br>
					  echo 'Eh non. Le commentaire ne s\'affiche pas !';</br></br>
						?&gt;</code>
					</div>
		    </div>
		  </div>

			<!-- 3. Déclarer des variables -->
		  <div class="panel panel-success">
		    <div class="panel-heading" role="tab" id="headingThree">
		      <h4 class="panel-title">
		        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
		          #3. Déclarer des variables
		        </a>
		      </h4>
		    </div>
		    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							// $nom contient alors une chaîne de caractères.</br>
							$nom = "Mathieu";</br>
							</br>
							// $age contient mon âge.</br>
							$age = 23;</br>
							</br>
							// Cette déclaration n'est pas valide car le nom de la variable commence par un chiffre</br>
							$5toto = "test";</br>
							</br>
							?&gt;
						</code>
					</div>
		    </div>
		  </div>

			<!-- 4. Les tableaux -->
			<div class="panel panel-success">
			  <div class="panel-heading" role="tab" id="headingFour">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
			        #4. Les tableaux
			      </a>
			    </h4>
			  </div>
			  <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							// 1ère façon d'écrire un tableau</br>
							// C'est la plus simple à utiliser</br>
							$infosFruitV1 = array("Tomate", "Rouge", "Baie");</br>
							</br>
							// 2nd façon</br>
							$infosFruitV2 = array(</br>
							  "0" =&gt; "Tomate",</br>
							  "1" =&gt; "Rouge",</br>
							  "2" =&gt; "Baie"</br>
							);</br>
							</br>
							//3ème façon</br>
							$infosFruitV3 = array(</br>
							  "fruit" =&gt; "Tomate",</br>
							  "couleur" =&gt; "Rouge",</br>
							  "famille" =&gt; "Baie",</br>
							  "mutante" =&gt; array("DoubleTomate", "TripleTomate", "QuadrupleTomate")</br>
							);</br>
							</br>
							?&gt;
						</code>
					</div>
			  </div>
			</div>

			<!-- 5. Date / Heure  -->
			<div class="panel panel-success">
			  <div class="panel-heading" role="tab" id="headingFive">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
			        #5. Date / Heure
			      </a>
			    </h4>
			  </div>
			  <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							$date_du_jour = date ("d-m-Y");</br>
							$heure_courante = date ("H:i");</br>
							echo 'Nous sommes le : ';</br>
							echo $date_du_jour;</br>
							echo ' Et il est : ';</br>
							echo $heure_courante;</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						$date_du_jour = date ("d-m-Y");
						$heure_courante = date ("H:i");
						echo 'Nous sommes le : ';
						echo $date_du_jour;
						echo ' Et il est : ';
						echo $heure_courante;

						?>
					</div>
			  </div>
			</div>

			<!-- 6. Concaténation -->
			<div class="panel panel-success">
			  <div class="panel-heading" role="tab" id="headingSix">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
			        #6. Concaténation
			      </a>
			    </h4>
			  </div>
			  <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							$nom = "Mathieu";</br>
							$age = 23;</br>
							echo 'Je suis '.$nom.' ! Et j\'ai '.$age.' ans !';</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						$nom = "Mathieu";
						$age = 23;
						echo 'Je suis '.$nom.' ! Et j\'ai '.$age.' ans !';

						?>
					</div>
			  </div>
			</div>

			<!-- 7. If / Else If / Else -->
			<div class="panel panel-info">
			  <div class="panel-heading" role="tab" id="headingSeven">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
			        #7. If / Else If / Else
			      </a>
			    </h4>
			  </div>
			  <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							$nombre = 11;</br>
							if ($nombre &gt;= 0 &amp;&amp; $nombre &lt; 10) {</br>
								&nbsp;&nbsp;// on teste si la valeur de notre variable est comprise entre 0 et 9</br>
								&nbsp;&nbsp;echo $nombre.' est compris entre 0 et 9';</br>
							}</br>
							elseif ($nombre &gt;= 10 &amp;&amp; $nombre &lt; 20) {</br>
								&nbsp;&nbsp;// on teste si la valeur de notre variable est comprise entre 10 et 19</br>
								&nbsp;&nbsp;echo $nombre.' est compris entre 10 et 19';</br>
							}</br>
							else {</br>
								&nbsp;&nbsp;// si les deux tests précédents n'ont pas abouti, alors on tombe dans ce cas</br>
								&nbsp;&nbsp;echo $nombre.' est plus grand que 19';</br>
							}</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						$nombre = 15;
						if ($nombre >= 0 && $nombre < 10) {
						// on teste si la valeur de notre variable est comprise entre 0 et 9
						echo $nombre.' est compris entre 0 et 9';
						}
						elseif ($nombre >= 10 && $nombre < 20) {
						// on teste si la valeur de notre variable est comprise entre 10 et 19
						echo $nombre.' est compris entre 10 et 19';
						}
						else {
						// si les deux tests précédents n'ont pas abouti, alors on tombe dans ce cas
						echo $nombre.' est plus grand que 19';
						}

						?>
					</div>
			  </div>
			</div>

			<!-- 8. Switch -->
			<div class="panel panel-info">
			  <div class="panel-heading" role="tab" id="heading8">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" aria-controls="collapse8">
			        #8. Switch
			      </a>
			    </h4>
			  </div>
			  <div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							$nom = "Yolo";</br>
							switch ($nom) {</br>
								&nbsp;&nbsp;case 'Anthony' :</br>
								&nbsp;&nbsp;&nbsp;&nbsp;echo 'Votre nom est Anthony.';</br>
								&nbsp;&nbsp;break;</br>
								&nbsp;&nbsp;case 'Jordan' :</br>
								&nbsp;&nbsp;&nbsp;&nbsp;echo 'Votre nom est Jordan.';</br>
								&nbsp;&nbsp;break;</br>
								&nbsp;&nbsp;case 'Mathieu' :</br>
								&nbsp;&nbsp;&nbsp;&nbsp;echo 'Votre nom est Mathieu.';</br>
								&nbsp;&nbsp;break;</br>
								&nbsp;&nbsp;default :</br>
								&nbsp;&nbsp;&nbsp;&nbsp;echo 'Dégage !';</br>
							}</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						$nom = "Yolo";
						switch ($nom) {
							case 'Anthony' :
							echo 'Votre nom est Anthony.';
							break;
							case 'Jordan' :
							echo 'Votre nom est Jordan.';
							break;
							case 'Mathieu' :
							echo 'Votre nom est Mathieu.';
							break;
							default :
							echo 'Dégage !';
						}

						?>
					</div>
			  </div>
			</div>

			<!-- 9. For -->
			<div class="panel panel-info">
			  <div class="panel-heading" role="tab" id="heading9">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="false" aria-controls="collapse9">
			        #9. For
			      </a>
			    </h4>
			  </div>
			  <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							$chiffre = 5;</br></br>
							// Début de la boucle</br>
							for ($i=0; $i &lt; $chiffre; $i++) {</br>
							  &nbsp;&nbsp;&nbsp;echo 'Notre chiffre est différent de '.$i.'&lt;br /&gt;';</br>
							}</br>
							// Fin de la boucle</br></br>
							echo 'Notre chiffre est égal à '.$i;</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						$chiffre = 5;

						// Début de la boucle
						for ($i=0; $i < $chiffre; $i++) {
						   echo 'Notre chiffre est différent de '.$i.'<br />';
						}
						// Fin de la boucle

						echo 'Notre chiffre est égal à '.$i;

						?>
					</div>
			  </div>
			</div>

			<!-- 10. Foreach -->
			<div class="panel panel-info">
			  <div class="panel-heading" role="tab" id="heading10">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="false" aria-controls="collapse10">
			        #10. Foreach
			      </a>
			    </h4>
			  </div>
			  <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							$etudiants = Array();</br>
							$etudiants[0] = 'Mathieu';</br>
							$etudiants[1] = 'Anthony';</br>
							$etudiants[2] = 'Arnaud';</br>
							</br>
							// Début de la boucle</br>
							foreach ($etudiants as $etudiant) {</br>
							&nbsp;&nbsp;&nbsp;echo $etudiant.'&lt;/br&gt;';</br>
							}</br>
							// Fin de la boucle</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						$etudiants = Array();
						$etudiants[0] = 'Mathieu';
						$etudiants[1] = 'Anthony';
						$etudiants[2] = 'Arnaud';

						// Début de la boucle
						foreach ($etudiants as $etudiant) {
						   echo $etudiant.'</br>';
						}
						// Fin de la boucle

						?>
					</div>
			  </div>
			</div>

			<!-- 11. While -->
			<div class="panel panel-info">
			  <div class="panel-heading" role="tab" id="heading11">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse11" aria-expanded="false" aria-controls="collapse11">
			        #11. While
			      </a>
			    </h4>
			  </div>
			  <div id="collapse11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							$chiffre = 5;</br>
							$i = 0;</br>
							</br>
							// Début de la boucle</br>
							while ($i &lt; $chiffre) {</br>
							&nbsp;&nbsp;&nbsp;echo 'Notre chiffre est différent de '.$i.'&lt;br /&gt;';</br>
							&nbsp;&nbsp;&nbsp;$i = $i + 1;</br>
							}</br>
							// Fin de la boucle</br>
							</br>
							echo 'Notre chiffre est égal à '.$i;</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						$chiffre = 5;
						$i = 0;

						// Début de la boucle
						while ($i < $chiffre) {
						   echo 'Notre chiffre est différent de '.$i.'<br />';
						   $i = $i + 1;
						}
						// Fin de la boucle

						echo 'Notre chiffre est égal à '.$i;

						?>
					</div>
			  </div>
			</div>

			<!-- 12. Opérandes -->
			<div class="panel panel-info">
			  <div class="panel-heading" role="tab" id="heading12">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse12" aria-expanded="false" aria-controls="collapse12">
			        #12. Opérandes
			      </a>
			    </h4>
			  </div>
			  <div id="collapse12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading12">
					<div class="panel-body">
					  <strong>Voici la liste des opérateurs que vous pouvez utilisez dans vos conditions.</strong>
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
						  <thead>
						  	<th>Instruction</th>
								<th>Signification</th>
						  </thead>
							<tbody>
								<tr>
									<td>==</td><td>Strictement égal</td>
								</tr>
								<tr>
									<td>!=</td><td>Différent</td>
								</tr>
								<tr>
									<td><</td><td>Strictement inférieur</td>
								</tr>
								<tr>
									<td>></td><td>Strictement supérieur</td>
								</tr>
								<tr>
									<td><=</td><td>Inférieur ou égal</td>
								</tr>
								<tr>
									<td>>=</td><td>Supérieur ou égal</td>
								</tr>
								<tr>
									<td>and ou &&</td><td>ET logique</td>
								</tr>
								<tr>
									<td>or ou ||</td><td>OU logique</td>
								</tr>
							</tbody>
						</table>
					</div>
			  </div>
			</div>

			<!-- 13. Les variables globales -->
			<div class="panel panel-warning">
			  <div class="panel-heading" role="tab" id="heading13">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse13" aria-expanded="false" aria-controls="collapse13">
			        #13. Les variables globales
			      </a>
			    </h4>
			  </div>
			  <div id="collapse13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading13">
					<div class="panel-body">
					  <strong>Va vous permettre de récupérer des données d'un formulaire, des fichiers à partir d'un formulaire, les données stockées dans les cookies et plein d'autre truc encore....</strong>
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
						  <thead>
						  	<th>Variables globales</th>
								<th>Description</th>
						  </thead>
							<tbody>
								<tr>
									<td>$_GET</td><td>Récupération des variables d'un formulaire GET ou des variables passées par une URL</td>
								</tr>
								<tr>
									<td>$_POST</td><td>Récupération des variables passées par un formulaire POST</td>
								</tr>
								<tr>
									<td>$_FILES</td><td>Récupération des variables de fichiers envoyés par un formulaire</td>
								</tr>
								<tr>
									<td>$_COOKIE</td><td>Récupération des valeurs des cookies</td>
								</tr>
								<tr>
									<td>$_SESSION</td><td>Récupération des variables de session</td>
								</tr>
								<tr>
									<td>$_ENV</td><td>Récupération des variables d'environnement</td>
								</tr>
								<tr>
									<td>$_SERVER</td><td>Récupération des variables serveur</td>
								</tr>
							</tbody>
						</table>
					</div>
			  </div>
			</div>

			<!-- 14. Récupérer les données des formulaires  -->
			<div class="panel panel-warning">
			  <div class="panel-heading" role="tab" id="heading14">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse14" aria-expanded="false" aria-controls="collapse14">
			        #14. Récupérer les données des formulaires
			      </a>
			    </h4>
			  </div>
			  <div id="collapse14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading14">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<strong>HTML :</strong> ici l'attribut "action" est vide car je vais exécuter le code PHP dans le même fichier ou se trouve le code HTML.</br>
						Sinon, vous pouvez mettre votre code PHP dans un autre fichier <code>traitement.php</code> et écrire <code>action="traitement.php"</code>.</br></br>
						<code>
							&lt;form action="" method="post"&gt;</br>
							Votre pseudo : &lt;input type = "text" name = "pseudo"&gt;<br />
							Votre fonction : &lt;input type = "text" name = "fonction"&gt;<br />
							&lt;input type="submit" value = "Envoyer"&gt;
						</code>
						</br></br>
						<strong>PHP :</strong>
						</br></br>
						<code>
							&lt;?php</br>
							</br>
							// on teste la déclaration de nos variables</br>
							if (!empty($_POST['pseudo']) && !empty($_POST['fonction'])) {</br>
							&nbsp;&nbsp;// on affiche nos résultats</br>
							&nbsp;&nbsp;echo 'Votre pseudo est '.$_POST['pseudo'].' et votre fonction est '.$_POST['fonction'];</br>
							}</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur : (vous pouvez tester)</strong>
					</div>
					<div class="panel-body">
            <form action="" method="post">
            Votre pseudo : <input type = "text" name = "pseudo" class="form-control"></br>
            Votre fonction : <input type = "text" name = "fonction" class="form-control"></br>
            <input type="submit" value = "Envoyer" class="btn btn-default">
						<br/><br/>
            <?php

            // on teste la déclaration de nos variables
            if (!empty($_POST['pseudo']) && !empty($_POST['fonction'])) {
              // on affiche nos résultats
              echo '<div class="alert alert-success" role="alert">Votre pseudo est '.$_POST['pseudo'].' et votre fonction est '.$_POST['fonction'].'</div>';
              // SCRIPT JS pour que ça se réouvre tout seul
              echo "<script>
                      $(function() {
                          $('#collapse14').collapse('show');
                      });
                    </script>";
            }

            ?>
					</div>
			  </div>
			</div>

			<!-- 15. Les fonctions -->
			<div class="panel panel-warning">
			  <div class="panel-heading" role="tab" id="heading15">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse15" aria-expanded="false" aria-controls="collapse15">
			        #15. Les fonctions
			      </a>
			    </h4>
			  </div>
			  <div id="collapse15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading15">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							function affichage_texte ($taille, $couleur, $texte) {</br>
							&nbsp;&nbsp;echo '&lt;font size = "'.$taille.'" color = "'.$couleur.'"&gt;'.$texte.'&lt;/font&gt;';</br>
							}</br>
							</br>
							// on affiche un texte</br>
							affichage_texte ("2", "red", "Mon texte");</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						function affichage_texte ($taille, $couleur, $texte) {
						  echo '<font size = "'.$taille.'" color = "'.$couleur.'">'.$texte.'</font>';
						}

						// on affiche un texte
						affichage_texte ("2", "red", "Mon texte");

						?>
					</div>
			  </div>
			</div>

			<!-- 16. PDO - Connexion à une BDD -->
			<div class="panel panel-danger">
			  <div class="panel-heading" role="tab" id="heading16">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse16" aria-expanded="false" aria-controls="collapse16">
			        #16. PDO - Connexion à une BDD
			      </a>
			    </h4>
			  </div>
			  <div id="collapse16" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading16">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							&nbsp;&nbsp;$PARAM_hote='127.0.0.1'; // mettre "localhost" ça marche aussi.</br>
							&nbsp;&nbsp;$PARAM_port='3306';</br>
							&nbsp;&nbsp;$PARAM_nom_bd='exemplephpg4'; // le nom de votre base de données que j'ai créé pour vous sans que vous ouvriez phpmyadmin :)</br>
							&nbsp;&nbsp;$PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter</br>
							&nbsp;&nbsp;$PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter</br>
							</br>
							&nbsp;&nbsp;try {</br>
							&nbsp;&nbsp;&nbsp;&nbsp;$connexion = new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);</br>
							&nbsp;&nbsp;&nbsp;&nbsp;echo "Connexion réussi.";</br>
							&nbsp;&nbsp;}</br>
							&nbsp;&nbsp;catch(Exception $e) {</br>
							&nbsp;&nbsp;&nbsp;&nbsp;echo 'Erreur : '.$e->getMessage();</br>
							&nbsp;&nbsp;&nbsp;&nbsp;echo 'N° : '.$e->getCode();</br>
							&nbsp;&nbsp;}</br>
							</br>
							?&gt;
						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						  $PARAM_hote='127.0.0.1'; // mettre "localhost" ça marche aussi.
						  $PARAM_port='3306';
						  $PARAM_nom_bd='exemplephpg4'; // le nom de votre base de données que j'ai créé pour vous sans que vous ouvriez phpmyadmin :)
						  $PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
						  $PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter

						  try {
						    $connexion = new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
                echo '<div class="alert alert-success" role="alert">Connexion réussi.</div>';
						  }
						  catch(Exception $e) {
						    echo 'Erreur : '.$e->getMessage();
						    echo 'N° : '.$e->getCode();
						  }

						?>
					</div>
			  </div>
			</div>

			<!-- 17. Afficher les données de la BDD -->
			<div class="panel panel-danger">
			  <div class="panel-heading" role="tab" id="heading17">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse17" aria-expanded="false" aria-controls="collapse17">
			        #17. Afficher les données de la BDD
			      </a>
			    </h4>
			  </div>
			  <div id="collapse17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading17">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							&nbsp;&nbsp;$sth = $connexion-&gt;prepare("SELECT * FROM etudiants"); // On prépare sa requête</br>
							&nbsp;&nbsp;$sth-&gt;execute(); // On l'exécute</br>
							&nbsp;&nbsp;$results = $sth-&gt;fetchAll();</br>
							</br>
							&nbsp;&nbsp;echo "&lt;table class='table'&gt;";</br>
							&nbsp;&nbsp;echo "&lt;thead&gt;&lt;th&gt;ID&lt;/th&gt;&lt;th&gt;Nom&lt;/th&gt;&lt;th&gt;Prénom&lt;/th&gt;&lt;th&gt;Âge&lt;/th&gt;&lt;/thead&gt;";</br>
							&nbsp;&nbsp;echo "&lt;tbody&gt;";</br>
							&nbsp;&nbsp;foreach ($results as $etudiant) {</br>
							&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;tr&gt;";</br>
							&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;".$etudiant['id']."&lt;/td&gt;";</br>
							&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;".$etudiant['nom']."&lt;/td&gt;";</br>
							&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;".$etudiant['prenom']."&lt;/td&gt;";</br>
							&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;".$etudiant['age']."&lt;/td&gt;";</br>
							&nbsp;&nbsp;echo "&lt;/tr&gt;";</br>
							&nbsp;&nbsp;}</br>
							&nbsp;&nbsp;echo "&lt;/tbody&gt;";</br>
							&nbsp;&nbsp;echo "&lt;/table&gt;";</br>
							</br>
							?&gt;

						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur : (S'il n'y a rien, c'est pour que vous puissiez ajouter en BDD par vous même avec le chapitre #18 !)</strong>
					</div>
					<div class="panel-body">
						<?php

						  $sth = $connexion->prepare("SELECT * FROM etudiants"); // On prépare sa requête
						  $sth->execute(); // On l'exécute
						  $results = $sth->fetchAll();

						  echo "<table class='table'>";
						  echo "<thead><th>ID</th><th>Nom</th><th>Prénom</th><th>Âge</th></thead>";
						  echo "<tbody>";
						  foreach ($results as $etudiant) {
						    echo "<tr>";
						    echo "<td>".$etudiant['id']."</td>";
						    echo "<td>".$etudiant['nom']."</td>";
						    echo "<td>".$etudiant['prenom']."</td>";
						    echo "<td>".$etudiant['age']."</td>";
						  echo "</tr>";
						  }
						  echo "</tbody>";
						  echo "</table>";

						?>
					</div>
			  </div>
			</div>

			<!-- 18. Insérer en BDD -->
			<div class="panel panel-danger">
			  <div class="panel-heading" role="tab" id="heading18">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse18" aria-expanded="false" aria-controls="collapse18">
			        #18. Insérer en BDD
			      </a>
			    </h4>
			  </div>
			  <div id="collapse18" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading18">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
            <code>
              &lt;form action="" method="post"&gt;</br>
              &nbsp;&nbsp;Nom : &lt;input type="text" name="nom"&gt;</br>
              &nbsp;&nbsp;Prénom : &lt;input type="text" name="prenom"&gt;</br>
              &nbsp;&nbsp;Âge : &lt;input type="number" name="age"&gt;</br>
              &nbsp;&nbsp;&lt;input type="submit" name="name"&gt;</br>
              &lt;/form&gt;</br>
              </br>
              &lt;?php</br>
              </br>
              &nbsp;&nbsp;// on teste la déclaration de nos variables</br>
              &nbsp;&nbsp;if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['age'])) {</br>
              &nbsp;&nbsp;&nbsp;&nbsp;// on insère dans la BDD</br>
              &nbsp;&nbsp;&nbsp;&nbsp;$stmt = $dbh-&gt;prepare("INSERT INTO etudiants (nom, prenom, age) VALUES (:nom, :prenom, :age)");</br>
              &nbsp;&nbsp;&nbsp;&nbsp;$stmt-&gt;bindParam(':nom', $_POST['nom']);</br>
              &nbsp;&nbsp;&nbsp;&nbsp;$stmt-&gt;bindParam(':prenom', $_POST['prenom']);</br>
              &nbsp;&nbsp;&nbsp;&nbsp;$stmt-&gt;bindParam(':age', $_POST['age']);</br>
              &nbsp;&nbsp;&nbsp;&nbsp;try {</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$stmt-&gt;execute();</br>
              &nbsp;&nbsp;&nbsp;&nbsp;} catch (Exception $e) {</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// Echoinsert foiré</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "Insert foiré...... *cry cry cry*";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;}</br>
              &nbsp;&nbsp;}</br>
              </br>
              ?&gt;
            </code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur : (Vous pouvez essayez.)</strong>
					</div>
					<div class="panel-body">
						<form action="" method="post">
							Nom : <input type="text" name="nom" class="form-control"><br/>
							Prénom : <input type="text" name="prenom" class="form-control"><br/>
							Âge : <input type="number" name="age" class="form-control"><br/>
							<input type="submit" name="name" class="btn btn-default"></br></br>
						</form>
            <?php

              // on teste la déclaration de nos variables
              if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['age'])) {
                // on insère dans la BDD
                $stmt = $dbh->prepare("INSERT INTO etudiants (nom, prenom, age) VALUES (:nom, :prenom, :age)");
                $stmt->bindParam(':nom', $_POST['nom']);
                $stmt->bindParam(':prenom', $_POST['prenom']);
                $stmt->bindParam(':age', $_POST['age']);
                try {
                  $stmt->execute();
                  echo "<script>
                  $(function() {
                      document.location.href='index.php';
                  });
                  </script>";
                } catch (Exception $e) {
                  // Echoinsert foiré
                  echo "Insert foiré...... *cry cry cry*";
                }
              }

            ?>
					</div>
			  </div>
			</div>

			<!-- 19. Modifier en BDD -->
			<div class="panel panel-danger">
			  <div class="panel-heading" role="tab" id="heading19">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse19" aria-expanded="false" aria-controls="collapse19">
			        #19. Modifier en BDD
			      </a>
			    </h4>
			  </div>
			  <div id="collapse19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading19">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
            <code>
              &lt;?php</br>
              </br>
              &nbsp;&nbsp;$sth = $connexion-&gt;prepare("SELECT * FROM etudiants"); // On prépare sa requête</br>
              &nbsp;&nbsp;$sth-&gt;execute(); // On l'exécute</br>
              &nbsp;&nbsp;$results = $sth-&gt;fetchAll();</br>
              &nbsp;&nbsp;echo "&lt;form action='' method='get'&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;table&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;thead&gt;&lt;th&gt;ID&lt;/th&gt;&lt;th&gt;Nom&lt;/th&gt;&lt;th&gt;Prénom&lt;/th&gt;&lt;th&gt;Âge&lt;/th&gt;&lt;th&gt;Action&lt;/th&gt;&lt;/thead&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;tbody&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;foreach ($results as $etudiant) {</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;tr&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;&lt;input type='hidden' value='".$etudiant['id']."' name='updateId'&gt;".$etudiant['id']."&lt;/td&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;&lt;input type='text' value='".$etudiant['nom']."' name='updateNom'&gt;&lt;/td&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;&lt;input type='text' value='".$etudiant['prenom']."' name='updatePrenom'&gt;&lt;/td&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;&lt;input type='number' value='".$etudiant['age']."' name='updateAge'&gt;&lt;/td&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;&lt;input type='submit' value='Editer'&gt;&lt;/td&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;/tr&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;}</br>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;/tbody&gt;";</br>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;/table&gt;";</br>
              &nbsp;&nbsp;echo "&lt;/form&gt;";</br>
              &nbsp;&nbsp;if(isset($_GET['updateId'])) {</br>
              &nbsp;&nbsp;&nbsp;&nbsp;$connexion-&gt;exec("UPDATE etudiants SET nom='".$_GET['updateNom']."', prenom='".$_GET['updatePrenom']."', age='".$_GET['updateAge']."' WHERE id='".$_GET['updateId']."'");</br>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "UPDATE etudiants SET nom='".$_GET['updateNom']."', prenom='".$_GET['updatePrenom']."', age='".$_GET['updateAge']."' WHERE id='".$_GET['updateId']."'";</br>
              }&nbsp;&nbsp;</br>
              </br>
              ?&gt;
            </code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
            <?php

						  $sth = $connexion->prepare("SELECT * FROM etudiants"); // On prépare sa requête
						  $sth->execute(); // On l'exécute
						  $results = $sth->fetchAll();
              echo "<form action='' method='get'>";
  						  echo "<table class='table'>";
  						  echo "<thead><th>ID</th><th>Nom</th><th>Prénom</th><th>Âge</th><th>Action</th></thead>";
  						  echo "<tbody>";
  						  foreach ($results as $etudiant) {
  						    echo "<tr>";
  						    echo "<td><input type='hidden' value='".$etudiant['id']."' name='updateId'>".$etudiant['id']."</td>";
  						    echo "<td><input type='text' value='".$etudiant['nom']."' class='form-control' name='updateNom'></td>";
  						    echo "<td><input type='text' value='".$etudiant['prenom']."' class='form-control' name='updatePrenom'></td>";
  						    echo "<td><input type='number' value='".$etudiant['age']."' class='form-control' name='updateAge'></td>";
                  echo "<td><input type='submit' class='btn btn-primary' value='Editer'></td>";
  						  echo "</tr>";
  						  }
  						  echo "</tbody>";
  						  echo "</table>";
              echo "</form>";
              if(isset($_GET['updateId'])) {
            		$connexion->exec("UPDATE etudiants SET nom='".$_GET['updateNom']."', prenom='".$_GET['updatePrenom']."', age='".$_GET['updateAge']."' WHERE id='".$_GET['updateId']."'");
                echo "UPDATE etudiants SET nom='".$_GET['updateNom']."', prenom='".$_GET['updatePrenom']."', age='".$_GET['updateAge']."' WHERE id='".$_GET['updateId']."'";
                echo "<script>
                $(function() {
                    document.location.href='index.php';
                });
                </script>";
            	}

						?>
					</div>
			  </div>
			</div>

			<!-- 20. Supprimer en BDD -->
			<div class="panel panel-danger">
			  <div class="panel-heading" role="tab" id="heading20">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse20" aria-expanded="false" aria-controls="collapse20">
			        #20. Supprimer en BDD
			      </a>
			    </h4>
			  </div>
			  <div id="collapse20" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading20">
          <div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
            <code>
              &lt;?php<br/>
              <br/>
              &nbsp;&nbsp;$sth = $connexion-&gt;prepare("SELECT * FROM etudiants");<br/>
              &nbsp;&nbsp;$sth-&gt;execute(); // On l'exécute<br/>
              &nbsp;&nbsp;$results = $sth-&gt;fetchAll();<br/>
              <br/>
              &nbsp;&nbsp;echo "&lt;table&gt;";<br/>
              &nbsp;&nbsp;echo "&lt;thead&gt;&lt;th&gt;ID&lt;/th&gt;&lt;th&gt;Nom&lt;/th&gt;&lt;th&gt;Prénom&lt;/th&gt;&lt;th&gt;Âge&lt;/th&gt;&lt;th&gt;Action&lt;/th&gt;&lt;/thead&gt;";<br/>
              &nbsp;&nbsp;echo "&lt;tbody&gt;";<br/>
              &nbsp;&nbsp;foreach ($results as $etudiant) {<br/>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;tr&gt;";<br/>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;".$etudiant['id']."&lt;/td&gt;";<br/>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;".$etudiant['nom']."&lt;/td&gt;";<br/>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;".$etudiant['prenom']."&lt;/td&gt;";<br/>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;td&gt;".$etudiant['age']."&lt;/td&gt;";<br/>
              &nbsp;&nbsp;&nbsp;&nbsp;echo '&lt;td&gt;&lt;a href="index.php?idEtudiant='.$etudiant['id'].'"&gt;&lt;button type="button"&gt;Supprimer&lt;/button&gt;&lt;/a&gt;&lt;/td&gt;';<br/>
              &nbsp;&nbsp;&nbsp;&nbsp;echo "&lt;/tr&gt;";<br/>
              &nbsp;&nbsp;}<br/>
              &nbsp;&nbsp;echo "&lt;/tbody&gt;";<br/>
              &nbsp;&nbsp;echo "&lt;/table&gt;";<br/>
              <br/>
              &nbsp;&nbsp;if(isset($_GET['idEtudiant'])) {<br/>
              &nbsp;&nbsp;&nbsp;&nbsp;$connexion-&gt;exec("DELETE FROM etudiants WHERE id = '".$_GET['idEtudiant']."'");<br/>
              &nbsp;&nbsp;}<br/>
              <br/>
              ?&gt;
            </code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
            <?php

						  $sth = $connexion->prepare("SELECT * FROM etudiants"); // On prépare sa requête
						  $sth->execute(); // On l'exécute
						  $results = $sth->fetchAll();

						  echo "<table class='table'>";
						  echo "<thead><th>ID</th><th>Nom</th><th>Prénom</th><th>Âge</th><th>Action</th></thead>";
						  echo "<tbody>";
						  foreach ($results as $etudiant) {
						    echo "<tr>";
						    echo "<td>".$etudiant['id']."</td>";
						    echo "<td>".$etudiant['nom']."</td>";
						    echo "<td>".$etudiant['prenom']."</td>";
						    echo "<td>".$etudiant['age']."</td>";
                echo '<td><a href="index.php?idEtudiant='.$etudiant['id'].'"><button type="button" class="btn btn-danger">Supprimer</button></a></td>';
						  echo "</tr>";
						  }
						  echo "</tbody>";
						  echo "</table>";

              if(isset($_GET['idEtudiant'])) {
            		$connexion->exec("DELETE FROM etudiants WHERE id = '".$_GET['idEtudiant']."'");
                echo "<script>
                $(function() {
                    document.location.href='index.php';
                });
                </script>";
            	}

						?>
					</div>
			  </div>
			</div>

			<!-- 21. Débug -->
			<div class="panel panel-danger">
			  <div class="panel-heading" role="tab" id="heading21">
			    <h4 class="panel-title">
			      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse21" aria-expanded="false" aria-controls="collapse21">
			        #21. Débug
			      </a>
			    </h4>
			  </div>
			  <div id="collapse21" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading21">
					<div class="panel-body">
					  <strong>Exemple de code :</strong>
					</div>
					<div class="panel-body">
						<code>
							&lt;?php</br>
							</br>
							$sth = $connexion-?&gt;prepare("SELECT * FROM etudiants");</br>
							$sth-?&gt;execute();</br>
							</br>
							$result = $sth-?&gt;fetchAll();</br>
							var_dump($result);</br>
							</br>
							?&gt;

						</code>
					</div>
					<div class="panel-body">
					  <strong>Résultat du code PHP dans le navigateur :</strong>
					</div>
					<div class="panel-body">
						<?php

						$sth = $connexion->prepare("SELECT * FROM etudiants");
						$sth->execute();

						$result = $sth->fetchAll();
						var_dump($result);

						?>
					</div>
			  </div>
			</div>

		</div>

  </body>
</html>
