

    <?php 
    
    if ((! isset($_SESSION['panier'])) || (count($_SESSION['panier']) == 0) || (!is_array($_SESSION['panier'])) ) {
        echo 'VOTRE PANIER EST VIDE';
        return FALSE;
    }
    
        foreach ($articlesPanier as $key => $value) {
            
    ?>
<div class="item-panier" id="<?php echo $key; ?>">
            <?php
            echo $key . ' => { ';
            foreach ($value as $t => $val) {
                echo '<div>'.$t . ' = ' . $val . '  </div>';
            }
            $prix_total_prod = $value['prix']*$value['qte'];
            ?>
    <div>Prix_total = <?php echo $prix_total_prod; ?></div>
    <div><a href="<?php echo site_url("index.php?use_case=gererpanier&action=suppr&artId=") . $key; ?>" >Supprimer</a></div>
    <form action="<?php echo site_url("index.php?use_case=gererpanier&action=suppr"); ?>" method="POST" class="form-suppr">
        <input type="hidden" name="artId" value="<?php echo $key; ?>" />
        <input type="submit" name="valider" value="supprimer du panier" />
    </form>
</div>
         <?php } ?>
        <br/>

        } 
    
    <div class="empty">
        <a href="<?php echo site_url('gererpanier/vider'); ?>">Vider votre panier</a>
    </div>
    





