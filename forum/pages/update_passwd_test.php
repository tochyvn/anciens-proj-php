<?php
require '../includes/load_page.php';
require '../includes/connexion_mysqli.php';
require '../includes/form_helper.php';

start_page("Modification de mot de passe", "../css/style1.css");
?>
        <div id="masque">
            <div class="popup_block">
                
                <h2>Changement de mot de passe</h2>
                <div class="form_update_password">
                    <form id="form_connexion" action="" method="post">
                        <div class="group">
                            <label for="email_update">Email</label>
                            <input type="text" id="email_update"  <?php add_class_error('update_email'); ?> name="email_update" placeholder="Entrer votre email"  />  
                        </div>
                        <div class="group">
                            <label for="passwd">Nouveau mot de passe</label>
                            <input type="password" id="passwd"  <?php add_class_error('passwd'); ?> name="passwd" placeholder="Entrer votre mot de passe"  />  
                        </div>
                        <div class="group">
                            <label for="passwd_conf">Confirmation</label>
                            <input type="password" id="passwd_conf"  <?php add_class_error('passwd_conf'); ?> name="passwd_conf" placeholder="Confirmation de mot de passe"  />  
                        </div>
                        <div class="group">
                            <input name="update" type="submit" value="Update your password" id="update_validate" />
                        </div>
                    </form>
                    <div class="error_php">
                        <?php  
                        if (isset($_SESSION['errors']['update_email']) && $_SESSION['form_active'] == "popup_update") {
                        ?>
                        <span><?php echo $_SESSION['errors']['update_email']; ?></span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
<?php 
end_page();