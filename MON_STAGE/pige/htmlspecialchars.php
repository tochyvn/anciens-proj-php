<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
	if(isset($_POST['querystring']))
		print('Resultat : <pre>'.htmlentities(htmlspecialchars($_POST['querystring'])).'</pre><br>');
?>
<form action="" method="post">
<input name="querystring" type="text" value="<?php if(isset($_POST['querystring'])) print(htmlspecialchars($_POST['querystring']));?>" size="100">
<input name="submit" type="submit">
</form>
</body>
</html>