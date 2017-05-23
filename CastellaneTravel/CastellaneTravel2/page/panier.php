<?php 
    require '../class/db.class.php';
    require '../class/panier.class.php';
    $DB = new DB();
    $panier = new panier($DB);
    //var_dump($_SESSION);
    if(isset($_GET['del'])){
        $panier->del($_GET['del']);
    }
?>

<!DOCTYPE html>
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
        <div class="row">
            <div class="panel panel-success">
                <div class="panel-heading">Panel with panel-primary class</div>
                <div class="panel-body">
                    <form method="post" action="panier.php">
                    <div class="table-responsive">          
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Object</th>
                                    <th>Quantité</th>
                                    <th>prix</th>
                                    <th>suppr</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $ids = array_keys($_SESSION['panier']);
                                    if(empty($ids)){
                                        $products=array();
                                    } else {
                                        $products = $DB->query('SELECT * FROM produit WHERE idProduit IN ('.implode(',',$ids).')') ;
                                    }
                                    foreach($products as $product):
                                ?>
                                <tr>
                                    <td><?php echo $product->nomProduitFR ;?></td>
                                    <td><?php echo $product->prixProduit ;?> €</td>
                                    <td><input type ="text" name="panier[quantity][<?php echo $product->idProduit ?>]" with="30" value="<?php echo $_SESSION['panier'][$product->idProduit] ?>"></input></td>
                                    <td></td>
                                    <td>
                                        <a href="panier.php?del=<?php echo $product->idProduit ;?>"> supr </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                                
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary btn-sm">Recalculer</button>
                        <button type="button" class="btn btn-primary btn-sm">Finish</button>
                        <?php echo $panier->total() ?>
                    </div>
                    </form>
                </div>
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
    <script src="../js/main.js"></script>
</body>

</html>