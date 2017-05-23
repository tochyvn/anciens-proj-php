<?php 
    
    require '../class/db.class.php';
    require '../class/panier.class.php';
    $DB = new DB();
    $panier = new panier($DB);
   //var_dump($DB->query('SELECT * FROM produit'));
?><!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Clean Blog</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/clean-blog.min.css" rel="stylesheet">
	<!-- <link href="../css/icomoon-social.css" rel="stylesheet"> -->
	<link href="../css/leaflet.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <!-- Navigation -->
	<?php include '../include/nav_page.php'; ?>

    <!-- Page Header -->
	<?php include '../include/pageheader_page.php'; ?>

    <!-- Main Content -->
	
	<div class="container">
            <div class="eshop-section section">
                    <h2>Listing societe</h2>
                    <div class="col-lg-8">
                        <div class="row">
                            <?php $products = $DB->query('SELECT * FROM produit'); ?>
                            <?php foreach( $products as $product ): ?>
                            <div class="col-sm-4">
                                <div class="shop-item">
                                        <div class="image">
                                                <img src="../img/product1.jpg" alt="Item Name"></a>
                                        </div>
                                        <div class="title">
                                                <h3><a href="page-product-details.html"><?php echo $product->nomProduitFR ;?></a></h3>
                                        </div>
                                        <div class="price">
                                            <?php echo $product->prixProduit ;?> €
                                        </div>
                                        <div class="description">
                                                <p><?php echo $product->descriptProduitFR ;?></p>
                                        </div>
                                    <button type="button" class="btn btn-primary btn-sm center-block" type="submit"><a class="addPanier" href="addpanier.php?id=<?php echo $product->idProduit; ?>">Ajouter</a></button>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        <div class="pagination-wrapper ">
                            <ul class="pagination pagination-lg">
                                <li class="disabled"><a href="#">Previous</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">6</a></li>
                                <li><a href="#">7</a></li>
                                <li><a href="#">8</a></li>
                                <li><a href="#">9</a></li>
                                <li><a href="#">10</a></li>
                                <li><a href="#">Next</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                            <?php include '../include/panier.php' ?>
                    </div>
		</div>
	</div>

    <hr>

    <!-- Footer -->
    <?php include '../include/footer.php'; ?>

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/clean-blog.min.js"></script>
	
    <!--<script src="../js/panierAjax.js"></script>-->
    <script src="../js/main.js"></script>

</body>

</html>
