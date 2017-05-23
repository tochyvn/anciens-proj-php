<?php
session_start();
require '../includes/connexion_mysqli.php';
require '../includes/load_page.php';
require '../includes/form_helper.php';

if (isset($_GET['token'], $_GET['id'], $_GET['hash'])) {
    $hashage = $_GET['hash'];
    $id = $_GET['id'];
    $now = time();
    $delai = $now - $_GET['token'];
    $sql = "SELECT * FROM users "
            . "WHERE id_user = ". $id ." AND hashage = '". $hashage. "'";
    $query = $connexion->query($sql);
    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        
        if ($delai <= 3600*24 && $row['hashage'] == $hashage) {
            start_page("Modification de mot de passe", "../css/style1.css");
            ?>
        <div id="masque">
            <div class="popup_block">
                
                <h2>Changement de mot de passe</h2>
                <div class="form_update_password">
                    <form id="form_update" action="../actions/update_password.php" method="post">
                        <div class="error_php">
                        <?php
                        if (count($_SESSION['errors']) != 0) { ?>
                            <ul>
                            <?php
                            foreach ($_SESSION['errors'] as $value) { ?>
                                <li><?php echo $value; ?></li>
                        <?php
                            } ?>
                            </ul>
                        <?php        
                        }
                        ?>
                        </div>
                        <div class="group">
                            <label for="email_update">Email</label>
                            <input type="text" id="email_update"  <?php add_class_error('email_update'); ?> name="email_update" value="<?php echo setValue('email_update') ?>" placeholder="Entrer votre email"  />  
                        </div>
                        <div class="group">
                            <label for="passwd_update">Nouveau mot de passe</label>
                            <input type="password" id="passwd_update"  <?php add_class_error('passwd_update'); ?> name="passwd_update" placeholder="Entrer votre mot de passe"  />  
                        </div>
                        <div class="group">
                            <label for="passwd_conf_update">Confirmation</label>
                            <input type="password" id="passwd_conf_update"  <?php add_class_error('passwd_update'); ?> name="passwd_conf_update" placeholder="Confirmation de mot de passe"  />  
                        </div>
                        <div class="group">
                            <input name="update" type="submit" value="Update your password" id="update_validate" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <?php
            end_page();
        }else {
            $_SESSION['errors']['principale'] = "Ce lien a expir&eacute; ou a deja &eacute;t&eacute; utilis&eacute;";
            header("location:../index.php");
        }
    }else {
        $_SESSION['errors']['principale'] = "Cet utilisateur n'existe pas ou ce lien a deja &eacute;t&eacute; utilis&eacute;";
        header("location:../index.php");
    }
    
}else {
    header("location:../index.php");
}

$_SESSION['errors'] = array();
$_SESSION['populate_value'] = array();