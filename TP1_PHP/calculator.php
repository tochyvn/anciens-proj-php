<?php

require 'fonctions.php';

start_page("Ma calculatrice");
?>

<form action="calcul.php" method="post">
    <h3>Cochez l'opération que vous souhaitez éffectuer</h3>
    <input checked="checked" type="radio" name="op" value="*"/>*<br/>
    <input type="radio" name="op" value="+"/>+<br/>
    <input type="radio" name="op" value="-"/>-<br/>
    <input type="radio" name="op" value="/"/>/<br/>
    <div>
        <input type="number" name="op1" placeholder="Entrer le nombre 1" />
    </div>
    <div>
        <input type="number" name="op2" placeholder="Entrer le nombre 2" /><br/>
    </div>
    <div>
        <input type="submit" value="calculer" />
    </div>
</form>
<?php
end_page();

