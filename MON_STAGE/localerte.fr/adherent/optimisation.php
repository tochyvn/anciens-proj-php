<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title>Document sans titre</title>
</head>

<body>
<?php
	$scandir=scandir('js',0);
	for($i=2;$i<sizeof($scandir);$i++) if(is_file('js/'.$scandir[$i])) print('<script src="js/'.$scandir[$i].'" type="text/javascript"></script> ');
	
	$scandir=scandir('img',0);
	for($i=2;$i<sizeof($scandir);$i++) if(is_file('img/'.$scandir[$i])) print('<img src="img/'.$scandir[$i].'" alt="" height="30" width="30"> ');
?>
</body>
</html>