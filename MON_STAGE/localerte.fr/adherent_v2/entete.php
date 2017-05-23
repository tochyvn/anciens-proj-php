<?php
	$query=array();
	$query[]=rand(100000,999999);
	if(defined('ALERTE_CARDINALITE'))
		$query[]='ALERTE_CARDINALITE='.urlencode(ALERTE_CARDINALITE);
	if(defined('ALERTE_ALERTE_TYPE_MAX'))
		$query[]='ALERTE_ALERTE_TYPE_MAX='.urlencode(ALERTE_ALERTE_TYPE_MAX);
	if(defined('ADSENSE_LIMITE'))
		$query[]='ADSENSE_LIMITE='.urlencode(ADSENSE_LIMITE);
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Localerte - On cherche pour vous</title>
<link rel="SHORTCUT ICON" href="<?php print(URL_INCLUSION);?>favicon.ico" />
<link rel="stylesheet" href="<?php print(URL_ADHERENT_V2);?>general.css<?php if(sizeof($query)) print('?'.implode('&',$query));?>" type="text/css" />
<script src="<?php print(URL_INCLUSION);?>general.js" language="javascript" type="text/javascript"></script>
