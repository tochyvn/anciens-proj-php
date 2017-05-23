<p>
    Cette page ne contient que du HTML.<br />
    Veuillez taper votre pr&eacute;nom :
</p>

<form action="cible.php" method="post">
<p>
    <input type="text" name="prenom" />
    <input type="submit" value="Valider" />
    <br/></br>
    <textarea name="message" rows="8" cols="50">Saisissez votre message ici</textarea>
    <br/></br>
    <select name="choix">
        <option value="choix1">choix1</option>
        <option value="choix2">choix2</option>
        <option value="choix3">choix3</option>
    </select>
    <br/></br>
    Langues:
    <input type="checkbox" name="langue1" id="check1" value="espagnol" /> <label for="check1">Français</label>
    <input type="checkbox" name="langue2" id="check2" value="Anglais" /> <label for="check2">Anglais</label>
    <br/>
    <input type="hidden" name="pseudo" value="Mateo21" /><br/>
    
    Aimez-vous les frites ?
    <input type="radio" name="frites" value="oui" id="oui" checked="checked" /> <label for="oui">Oui</label>
    <input type="radio" name="frite" value="non" id="non" /> <label for="non">Non</label>
</p>
</form>