<!DOCTYPE html>

<html>
<head>
    <title>Page Title</title>
</head>

<body>
    <form action="test2.php" method="post">
        
        <div>
            Nom : <input type="text" name="nom" value="" size="20" maxlength="20" />
            Mot de passe : <input type="password" name="mot_de_passe" value="20" maxlength="20" />
            <br/>
            Sexe : <input type="radio" name="sexe" value="M" id="id1" /> <label for="id1">Masculin </label>
            <input type="radio" name="sexe" value="F" id="id2" /> <label for="id2">Feminin </label>
            <input type="radio" name="sexe" value="?" id="id3" checked="checked/> <label for="id3">Ne sait pas</label>
            <br/><br/>
            Photo : <input type="image" name="photo" value="" size="50" />
            <br/><br/>
            Couleurs pr&eacutefer&eacute :
            <input type="checkbox" name="couleurs[0]" id="id4" /><label for="id4">Bleu</label>
            <input type="checkbox" name="couleurs[1]" id="id5" /><label for="id5">Blanc</label>
            <input type="checkbox" name="couleurs[2]" id="id6" /><label for="id6">Blanc</label>
            <input type="checkbox" name="couleurs[3]" id="id7" checked="checked" /><label for="id7">pas</label>
            <br/><br/>
            Langues :
            <select name="langue">
                <option value="A">Anglais</option>
                <option value="E">Espagnol</option>
                <option value="F">Francais</option>
                <option value="I">Italien</option>
            </select>
            <br/><br/>
            Fruits pr&eacutefer&eacute : <br/>
            <select name="fruits[]" multiple="multiple" size="7">
                <option value="A">Abricots</option>
                <option value="C">Cerises</option>
                <option value="F">Fraises</option>
                <option value="P">P&agrave</option>
                <option value="?">Ne sait pas</option>
            </select>
            <br/><br/>
            Commentaires :<br/>
            <textarea name="commentaire" cols="15" rows="15"></textarea>
            <br/><br/>
            <input type="hidden" name="invisible" value="123"><br/>
            <input type="submit" name="soumettre" value="ok"/>
            <input type="image" name="valider" src="valider.gif" />
            <input type="reset" name="effacer" value="effacer" />
            <input type="button" name="action" value="Ne fait rien" />
        </div>
        <br/>
        
        <?php function affiche($tab) {
                foreach($tab as $key=>$value) {
                    if (isset($value))
                        echo "$key=>$value <br/>";
                    if (is_array($value))
                        affiche($value);
                }
            }
            affiche($_POST);
            ?>
    </form>


</body>
</html>
