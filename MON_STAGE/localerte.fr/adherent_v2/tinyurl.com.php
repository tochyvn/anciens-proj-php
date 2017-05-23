<?php
	$uniqid=rand(1000,9999).'-'.uniqid();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Refresh" content="2; url=<?php print('http://tinyurl.com/'.$uniqid);?>">
</head>

<body>
<iframe style="visibility:hidden; width:100%; height:2000px;" src="<?php print('http://tinyurl.com/create.php?url='.urlencode($_REQUEST['url'].'#'.$uniqid).'&alias='.$uniqid);?>"></iframe>
</body>
</html>