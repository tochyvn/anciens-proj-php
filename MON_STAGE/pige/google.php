<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Document sans titre</title>
</head>

<body>
<form method="get" action="">
  <p>
    <label>Mots clefs</label>
    <input type="text" name="mot_clef" /><input type="submit" name="Valider" />

  </p>
</form>
<?php
	$recherche=array('/^\\\x22(.+)\\\x22,0,\\\x22[0-9]+\\\x22$/','/\\\\\\\\u003C/','/\\\\\\\\u003E/','/\\\\\\\\\\//','/\\\\\\\\u0026/');
	$remplacement=array('$1','<','>','/','&');
	if(isset($_REQUEST['mot_clef']))
	{
		$contenu=file_get_contents('http://www.google.fr/s?hl=fr&ds=pr&pq=&xhr=t&q='.urlencode($_REQUEST['mot_clef']).'&cp=13&pf=p&sclient=psy&tbm=shop&source=hp&aq=&aqi=&aql=&oq=&pbx=1&bav=on.2,or.r_gc.r_pw.&fp=a9928b74e4d8c58f&biw=1280&bih=289&bs=1&tch=1&ech=9&psi=qhwXTvKsI86v8QOxwtkw.1310137536825.3');
		$tableau=preg_split('/\/\*""\*\//',$contenu);
		if(preg_match('/\[\[(.+)\]\]/',$tableau[0],$resultat))
		{
			$suggestion=preg_split('/\],\[/',$resultat[1]);
			
			/*print('<pre>');
			print_r(array_map('htmlentities',$suggestion));
			print('</pre>');*/
			
			for($i=0;$i<sizeof($suggestion);$i++)
			{
				$suggestion[$i]=preg_replace($recherche,$remplacement,$suggestion[$i]);
				print(utf8_encode($suggestion[$i]).'<br />');
			}
			
			/*print('<pre>');
			print_r($suggestion);
			print('</pre>');*/
		}
	}
	//phpinfo();
?>
</body>
</html>