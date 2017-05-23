


 <div class="content">
    <div class="item-select">
     
     <?php foreach ($produit as $key => $value) {
        echo $key .' => '.$value.'<br/>';
     }?>
    <a href="<?php echo site_url('index.php?use_case=gererpanier&action=ajout&artId=').$produit['idProduit']; ?>">Ajouter Panier</a>
     
    </div>
     
 </div>
 