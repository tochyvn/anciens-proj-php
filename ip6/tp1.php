<!DOCTYPE html>
<html lang="fr">
        <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
                <title>Bienvenue sur mon site web </title>
        </head>
        <body>
<?php
function de(){
	return isset($_POST['submit']);
	
}
if(de()) print_r($_POST);
?>
<?php
$erreurs=1;
ob_start();
?>
 <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
 
nom:<input type="text" name="nom"  value=<?php if (de()) echo $_POST['nom'];?>><br/>
age:<select name="age">
<option value="@@@@@@">selectionner dans la liste---</option>
<?php
for($i=1;$i<100;$i++)
{
	#pour laisser la valeur de l'age sélectionné par défaut
	echo "<option value='$i' " ;
	if(de() && ($_POST['age']==$i)) echo "selected='selected' ";
	 echo ">$i</option>";
}
?>
<br/>     
</select><br/>
sexe:<br/>
<?php
$sexe=["Masculin"=>1,"Feminin"=>2,"Autre"=>3];
foreach($sexe as $k=>$v)
{
  echo "<input type=\"radio\" name=\"sexe\" value=\"$v\" ";
   if (isset($_POST['sexe'])&& $_POST['sexe']==$v) echo "checked=\"checked\" ";
   echo "/> : $k<br/>";
}

?>
langues parlees:<br/>
<?php
$langues=["Français"=>1,"Anglais"=>2,"Espagnol"=>3];
foreach($langues as $k=>$v)
{
echo "<input type=\"checkbox\" name=\"langues[]\" value=\"$v\" ";
if(isset($_POST['langues']) && in_array($v,$_POST['langues'])) echo " checked=\"checked\" ";
echo "/> :$k<br/>";
}
?>

loisirs:<br/>
<select multiple ="multiple" name="loisirs[]>";
<?php
$loisirs=["sport"=>1,"lecture"=>2,"internet"=>3];
foreach($loisirs as $k=>$v)
echo "<option value=\"$v\">$k</option>";

?>
</select><br/>
commentaires:
<textarea name="commentaires"></textarea><br/>
<input type="submit" name="submit" value="envoyer"/>
</form>
<?php
$f=ob_get_clean();
        if (de()&&!$erreurs)
        {
        	echo "formulaire ok";
		}
			else
        echo $f;	
        ?>    
</body>
</html>
Fin de la conversation
