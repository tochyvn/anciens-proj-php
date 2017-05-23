
<?php //include 'fonctions/generate_url.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Site e-Commerce</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css"  href="<?php echo site_url('css/toch.css'); ?>"/>
        <script type="text/javascript" src="<?php echo site_url('js/toch.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('js/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/jquery-ui-1.11.4/jquery-ui.min.js'); ?>"></script>
        <link rel="stylesheet" href="<?php echo site_url('assets/jquery-ui-1.11.4/jquery-ui.min.css'); ?>" />
        
        <!--
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        -->
        
    </head>
    <body>
        <div class="header"></div>
        <div class="nav">
            <ul>
                <li><a href="<?php echo site_url('consulter/produits'); ?>" >Catalogue</a></li>
                <li><a href=<?php echo site_url(''); ?> >Sociétés</a></li>
                <li><a href=<?php echo site_url(); ?> >Histoires</a></li>
                <li><a href=<?php echo site_url(); ?> >Architectures</a></li>
                <li><a href=<?php echo site_url('auth/authenfier'); ?> >Connexion</a></li>
                <li><a href=<?php echo site_url('auth/subscribe'); ?> >Inscription</a></li>
                <li><a href=<?php echo site_url('gererpanier/voir'); ?> >Panier</a></li>
            </ul>                                       
        </div>
        <div class="content">