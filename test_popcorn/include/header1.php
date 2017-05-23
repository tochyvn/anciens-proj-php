
<?php include 'fonctions/generate_url.php'; ?>
<html>
    <head>
        <title>Header 1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            div.header{
                border: aqua solid thick;
                background-color: blue;
                position: absolute;
                top: 0;
                height: 100px;
                width: 98%;
                margin: auto;
            }
            
            div.footer{
                background-color: red;
                border: aqua solid thick;
                position: absolute;
                bottom: 0;
                height: 100px;
                width: 98%;
            }
            
            div.nav ul {
                list-style-type: none;
            }
            
            ul li {
                display: inline-block;
                opacity: 1;
                color: white;
                margin-right: 50px;
            }
            
            div.nav {
                background-color: blue;
                //opacity: 0.1;
                position: relative;
                top: 100px;
            }
            
            li a {
                text-decoration: none;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="header"></div>
        <div class="nav">
            <ul>
                <li><a href=<?php echo site_url(); ?> >Catalogue</a></li>
                <li><a href=<?php echo site_url(); ?> >Sociétés</a></li>
                <li><a href=<?php echo site_url(); ?> >Histoire</a></li>
                <li><a href=<?php echo site_url(); ?> >Architectures</a></li>
                <li><a href=<?php echo site_url(); ?> >Connexion</a></li>
                <li><a href=<?php echo site_url(); ?> >Panier</a></li>
            </ul>
        </div>