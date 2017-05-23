<p>Bonjour !</p>

<p>Je sais comment tu t'appelles, h&eacute h&eacute. Tu t'appelles <?php echo $_POST['prenom'].'<br/>'; ?>
Aussi vous avez choisi <?php echo $_POST['choix'].'<br/>'; ?>
<br/>
comme Langue vous avez choisi: <?php echo $_POST['langue1']. ' et '.$_POST['langue2'] .'<br/>'; ?>
comme message vous avez saisi:<br/>
<?php echo $_POST['message'].'<br/>'; ?>

!</p>

<p>Si tu veux changer de pr&eacutenom, <a href="form.php">clique ici</a>
pour revenir ˆ la page form.php.</p>

<?php ob_end_clean()