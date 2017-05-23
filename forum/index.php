<?php
session_start();
require 'includes/form_helper.php';
require 'includes/load_page.php';

$erreur = COUNT($_SESSION['errors']);
//var_dump($_SESSION);

$form_active = false;
if(isset($_SESSION['form_active'])) {
    $form_active = $_SESSION['form_active'];
}

$success = FALSE;
if(isset($_GET['step'])) {
    $success = $_GET['step'];
}
start_page("Accueil du Forum", "css/style.css");
?>

        <div id="masque">
            <div class="popup_block">
                <a class="close" href="#noWhere"><img alt="Fermer" title="Fermer la fenêtre" class="btn_close" src="./images/close_pop.png"></a>
                <!--<img style="float: right; margin: 0 0 0 20px;" alt="Lil bomb dude" src="./images/bomber.gif">-->
                <h2>Changement de mot de passe</h2>
                <div class="form_update_password">
                    <form id="form_update_passwd" action="actions/send_mail_updating.php" method="post">
                        <div class="group">
                            <label for="email_update">Email</label>
                            <input type="text" id="email_update"  <?php add_class_error('update_email'); ?> name="email_update" placeholder="Entrer votre email"  />  
                        </div>
                        <div class="group">
                            <input name="update" type="submit" value="Send me an email" id="update_validate" />
                        </div>
                    </form>
                    
                        <?php  
                        if (isset($_SESSION['errors']['update_email']) && $_SESSION['form_active'] == "popup_update") {
                        ?>
                    <div class="error_php">
                        <span><?php echo $_SESSION['errors']['update_email']; ?></span>
                    </div>
                        <?php
                        }
                        ?>
                    
                </div>
            </div>
        </div>
        <div class="principal">
            <div class="connexion_inscription">
                <?php 
                if (isset($_SESSION['flash'])) {
                ?>
                <div class="main_message">
                    <span><?php echo $_SESSION['flash']; ?></span>
                </div>
                <?php
                }
                ?>
                <div class="form_connexion">
                    <h3>Formulaire de connexion</h3>
                        <?php 
                        //Si il y a des erreurs sur le formulaire de connexion
                        if ($erreur > 0 && $form_active == 'login' ) {
                        ?>
                    <div class="error_php">
                        <h4>Les informations que vous avez rentr&eacute;es sont invalides</h4>
                        <ul>
                            <li>Tous les champs doivent &ecirc;tre obligatoirement renseign&eacute;s</li>
                            <?php
                            //Si le format de l'email ne correspond pas
                            if (isset($_SESSION['errors']['mail'])) {
                            ?>
                            <li>V&eacute;rifier le format de l'email que vous avez rentr&eacute;</li>
                            <?php
                            }
                            //Si le mot de passe a moins de 6 caractères
                            if (isset($_SESSION['errors']['password'])) {
                            ?>
                            <li>Le mot de passe doit contenir au moins 6 caract&egrave;res</li>
                            <?php
                            }
                            //Si le mot de passe ou le username n'existe pas dans la base
                            if (isset($_SESSION['errors']['auth'])) {
                            ?>
                            <li>Cet utilisateur n'existe pas <strong>(Email ou mot de passe incorrect)</strong></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                        <?php
                        }
                        ?>
                    <form id="form_connexion" action="actions/login.php" method="post">
                        <div class="group">
                            <label for="mail">Email<span>*</span></label>
                            <input type="text" id="mail" <?php add_class_error('mail'); ?> name="mail" placeholder="Entrer votre email" value="<?php echo setValue("mail"); ?>"/>
                            <span class="tooltip">Le format de l'email que vous avez rentr&eacute; est invalide</span>
                        </div>
                        <div class="group">
                            <label for="password">Mot de passe<span>*</span></label>
                            <input type="password" id="password" <?php add_class_error('password'); ?> name="password" placeholder="Entrer votre mot de passe" />  
                            <span class="tooltip">Le mot doit contenir au moins 6 caract&egrave;res</span>
                        </div>
                        <div class="group">
                            <input name="login" type="submit" value="connexion" id="connexion_validate" />
                        </div>
                        <div class="change_password">
                            <span><a href="#masque">Mot de passe oubli&eacute;</a></span>
                        </div>
                    </form>
                </div>
                <div class="form_inscription">
                    <h3>Formulaire d'inscription</h3>
                        <?php
                        
                        if ($erreur > 0 && $form_active == 'subscribe') {
                        ?>
                    <div class="error_php">
                        <h4>Certaines informations que vous avez rentr&eacute;es sont invalides</h4>
                        <ul><?php 
                            foreach ($_SESSION['errors'] as $error_message) {
                                ?>
                            <li><?echo $error_message; ?></li>
                            <?php } ?>
                        </ul>
                    </div><?php
                            }
                            ?>
                    <form id="form_inscription" action="actions/subscribe.php" method="post">
                        <div class="group">
                            <label for="nom">Nom<span>*</span></label>
                            <input type="text" id="nom" name="nom" placeholder="Entrer votre nom" <?php add_class_error('nom'); ?>
                                   value="<?php echo setValue("nom"); ?>"/>
                            <span class="tooltip">Ce champ ne doit pas &ecirc;tre vide</span>
                        </div>
                        <div class="group">
                            <label for="prenom">Prenom<span>*</span></label>
                            <input type="text" id="prenom" name="prenom" placeholder="Entrer votre prenom" 
                                   value="<?php echo setValue("prenom"); ?>"/>
                            <span class="tooltip">Ce champ ne doit pas &ecirc; vide</span>
                        </div>
                        <div class="group">
                            <label for="pseudo">Pseudo<span>*</span></label>
                            <input type="text" id="pseudo" name="pseudo" placeholder="Entrer votre pseudonyme" value="<?php echo setValue("pseudo"); ?>"/>
                            <span class="tooltip">Ce champ ne doit pas &ecirc;tre vide</span>
                        </div>
                        <div class="group">
                            <label for="mail1">Email<span>*</span></label>
                            <input type="text" id="mail1" name="mail1" placeholder="Entrer votre email" <?php add_class_error('mail1'); ?>
                                   value="<?php echo setValue("mail1"); ?>"/>
                            <span class="tooltip">Le format de l'email rentr&eacute; est invalide</span>
                        </div>
                        <div class="group">
                            <label for="password1">Mot de passe<span>*</span></label>
                            <input type="password" id="password1" name="password1" placeholder="Entrer votre mot de passe" 
                                   <?php add_class_error('password1'); ?> />
                            <span class="tooltip">Ce champ doit contenir au moins 6 caract&egrave;res</span>
                        </div>
                        <div class="group">
                            <label for="password1_conf">Confirmation de passe<span>*</span></label>
                            <input type="password" id="password1_conf" name="password1_conf" placeholder="Retaper votre mot de passe" 
                                   <?php add_class_error('password1_conf'); ?>/>
                            <span class="tooltip">Ce champ ne peut &ecirc;tre vide et doit &ecirc;tre identique au mot de passe pr&eacute;c&eacute;dent</span>
                        </div>
                        <div class="group">
                            <label for="photo">Charger votre avatar</label>
                            <input type="file" id="photo" name="photo" placeholder="Selectionnez votre image" />
                            <span class="tooltip">Vous devez selectionner une image</span>
                        </div>
                        <div class="group">
                            <input name="subscribe" type="submit" value="inscription" id="inscription_validate" />
                        </div>
                    </form>
                </div>
            </div>
            <?php 
            $_SESSION['auth'] = array();
            $_SESSION['errors']  = array();
            $_SESSION['populate_value'] = array();
            unset($_SESSION['form_active']);
            unset($_SESSION['flash']);
            ?>
        </div>
        <script type="text/javascript" src="js/toch.js"> </script>
<?php 
end_page();
