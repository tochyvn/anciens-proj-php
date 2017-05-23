<!DOCTYPE HTML>
<html lang="fr">
    <head>
    <title><?php echo $titre; ?></title>
    <meta name="description" content="<?php echo $meta; ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap/css/bootstrap.css'?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/front.css'?>"/>
    <script src="<?php echo base_url().'assets/js/jquery-1.11.1.min.js'; ?>"></script>
    <script src="<?php echo base_url().'assets/bootstrap/js/bootstrap.js'; ?>"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <?php echo $output; ?>
            </div>
        </div>
    </body>
    <script src="http://www.google.com/adsense/search/ads.js" type="text/javascript"></script>
</html>