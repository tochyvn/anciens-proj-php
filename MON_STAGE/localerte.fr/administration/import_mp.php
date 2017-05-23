<?php
    require_once('configuration.php');
    require_once(PWD_INCLUSION.'sql.php');
    require_once(PWD_INCLUSION.'liste.php');
?>

<?php


$base=new ld_sql(); // connecteur mysql
	
	if(isset($_REQUEST['import_submit'])){

	// Copie dans le repertoire du script avec un nom
	// incluant l'heure a la seconde pres 
	$type_csv='application/vnd.ms-excel';
	$import_fichier_erreur=0;;
	$import_fichier_succes=false;
	$import_fichier_type=false;
	$import_type_succes=false;
	$message='';
	$resultat='';
	$file_ext='';

		switch($_REQUEST['import_submit'])
		{
			case 'Enregistrer':
				if(!isset($_FILES['import_fichier']))
					$import_fichier_erreur=UPLOAD_ERR_NO_FILE;
				elseif($_FILES['import_fichier']['error'])
					$import_fichier_erreur=$_FILES['import_fichier']['error'];
				elseif($_FILES['import_fichier']['type'] != $type_csv){
					$import_fichier_type=$_FILES['import_fichier']['type'];
				}else
					$file_ext =strrchr(basename($_FILES['import_fichier']), ".");
					$import_fichier_succes=true;
				break;
		}

		if($import_fichier_succes==true){

			$repertoireDestination = "tmp/";
			$idfichier=md5(uniqid(rand(), true));
			$nomDestination = $idfichier."_import_tmp.csv";

			$email= array();


			if (is_uploaded_file($_FILES["import_fichier"]["tmp_name"])) {
			    if (move_uploaded_file($_FILES['import_fichier']['tmp_name'],$repertoireDestination.$nomDestination)) {
			        $resultat= htmlentities('Le fichier temporaire '.$_FILES["import_fichier"]["tmp_name"].
			                " a été déplacé; vers ".$repertoireDestination.$nomDestination);

			    // ON DESABONNE LES ADRESSES EN QUESTION.
				$nUnsubscribe=0;
				$isEverUnsubscribed=0;
			    $x=0;// curseur
        		if (($handle = fopen($repertoireDestination.$nomDestination, "r")) !== FALSE){

            		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE){
            				$x++;
            				if ($x > 1){             // pour sauter la première ligne d'entête

								$base->ouvrir();	// on ouvre l'acces à la BDD
            					
								// Verification que la personne n'est pas deja desabonne
								$sql = 'SELECT date_resiliation FROM adherent WHERE email="'.htmlentities($data[0]).'"';
								$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
								$value = mysql_fetch_array($req);
								
								// Si la personne n'est pas desabonne
								if($value[0]===NULL){
									// La requête SQL
            						$sql = 'UPDATE  adherent SET abonne = "NON" WHERE email = "'.htmlentities($data[0]).'"'; // req pour désabonner la cible.
									// // On lance la requête et on impose un message d'erreur.
									$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());

									$sql = 'UPDATE  adherent SET date_abonnement = NULL WHERE email = "'.htmlentities($data[0]).'"'; // req pour date abonnement = null.
									// // On lance la requête et on impose un message d'erreur.
									$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());

									$sql = 'UPDATE  adherent SET date_resiliation = NOW() WHERE email = "'.htmlentities($data[0]).'"'; // req pour date resiliation = now.
									// // On lance la requête et on impose un message d'erreur.
									$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());

									// // on recupere le resultat sous forme d'un tableau
									// $reponse_sql = mysql_fetch_array($req);
									// // on libère l'espace mémoire alloué pour cette interrogation de la base
									// mysql_free_result ($req);
									$nUnsubscribe ++; 
								}else{
									$isEverUnsubscribed ++;
								}

   								mysql_close (); // On ferme l'accès mysql


            				// echo '--'.$data[0].htmlentities('-adresse désabonnée-');    //email
            				$email[$x] = $data[0];
            				'<br/>';
           					}  
             		}
           		}
           		echo 'fin du traitement';

			    } else {
			        $resultat='Le d&eacute;placement du fichier temporaire a &eacute;chou&eacute;'.
			                 ' v&eacute;rifiez l\'existence du r&eacute;pertoire '.$repertoireDestination;
			    }          
			} else {
			    $resultat='Le fichier n\'a pas &eacute;t&eacute; upload&eacute; (trop gros ?)';
		}

		}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>

<body>

<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php');?></td>
    <td valign="top">
	
			<table cellspacing="0" cellpadding="4">
		 		<tr>
		 			<td valign="top">

		    	 <form enctype="multipart/form-data" action="import_mp.php" method="post">
		    		  <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
		    			  Upload CSV <input type="file" name="import_fichier" />
		    		  <input type="submit" name="import_submit" value="Enregistrer"/>
		    	</form>

		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			Message: <?php echo $message.'-'. $resultat .'-ext-'. $file_ext; ?> <br/>		
  					</td>
  				</tr>
  				<tr><td>
  						R&eacute;sultat: <br />
  						<?php 
  						if(isset($_REQUEST['import_submit'])){
  							// print(echo 'tab:'.$email);
  							echo $nUnsubscribe . 'email desinscrit et ' .$isEverUnsubscribed .' deja desinscrite.' ;
  						}
							
  						  ?> <br />
  				</td></tr>
		    </table>
	</td>
  </tr>
  	

</table>

</body>
</html>