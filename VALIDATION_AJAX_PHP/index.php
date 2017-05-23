<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link type="text/css" rel="stylesheet" href="bootstrap/dist/css/bootstrap-theme.min.css" />
        <link type="text/css" rel="stylesheet" href="css/toch.css" />
    </head>
    <body>
        
        <div class="container">
            <div class="row" style="border: 1px #204d74 solid;">
                <div class="col-lg-2">
                    sds
                </div>
                <div class="col-lg-8">
                    <form id="form_subscription" action="" method="POST" >
                        <fieldset>
                            <legend>Formulaire d'inscription</legend>
                            <div>
                                <label for="name">Nom : </label>
                                <input type="text" name="name" id="name" placeholder="Entrer votre nom" />
                            </div>
                            <div>
                                <label for="adresse">Adresse : </label>
                                <input type="text" id="adresse" id="adresse" placeholder="Entrer votre adresse" />
                            </div>
                            <div>
                                <label for="ville">Ville : </label>
                                <input type="text" id="ville" name="ville" placeholder="Entre votre ville" />
                            </div>
                            <div>
                                <label for="cp">Code Postal : </label>
                                <input type="text" id="cp" name="cp" readonly />
                            </div>
                    
                            <div>
                                <label for="email">Code Postal : </label>
                                <input type="email" id="email" name="email" placeholder="Entrer votre email" />
                            </div>
                    
                            <div>
                                <label for="passwd">Mot de passe : </label>
                                <input type="password" id="passwd" name="passwd" placeholder="Entrer votre mot de passe" />
                            </div>
                            <div>
                                <label for="passwd1">Confirmation : </label>
                                <input type="password" id="passwd1" name="passwd1" placeholder="Retapez votre mot de passe" />
                            </div>
                            <div>
                                <input type="submit" name="valider" value="Soumettre"  />
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="col-lg-2">
                    sdsd
                </div>
            </div>
        </div>
        
        <script type="text/javascript" src="bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/toch.js"></script>
    </body>
</html>
