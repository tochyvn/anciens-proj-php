

    
<div class="produits">
    
<?php
/*
foreach ($produits as $key => $value) {  
    echo '<div class="produit">';
            for ($i = 0; $i < count($value); $i++) { 
                echo $value[$i].'<br/>';
            } 
        echo '<div><a href="'.site_url('index1.php?use_case=consulter&action=produit&id=').$key.'">voir l\'article</a></div>';    
    echo '</div>';
    
}
 * 
 */
?>
    
<?php      
for($i = 0; $i < count($produits); $i++) { ?>
    
    <div class="produit">
        <div class="form">
            <form id="form-produits" action="<?php echo site_url('gererpanier/ajout'); ?>" method="post">
                <?php
                foreach ($produits[$i] as $key => $value) { ?>
                
                <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
                <?php
                echo $key. ' => '. $value. '<br/>';
                }
                ?>
                <input type="submit" value="Ajouter à votre panier" name="valider" />
            </form>
        </div>
    </div>
<?php    
}
?>  
    
</div>


