<?php

	
	$user_agent='Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36';
	$entete['location'] = "http://www.annoncesjaunes.fr/recherche.html?searchTypeID=1&typeGroupCategoryID=1&transactionId=1&localityIds=101-40019&typeGroupIds=1,2&pageIndex=1&sortPropertyName=ReleaseDate&sortDirection=Descending";
	$socket=curl_init();
	curl_setopt($socket, CURLOPT_URL, ($entete['location']));

	curl_setopt($socket,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($socket,CURLOPT_HEADER,true);
	
	
	
	curl_setopt($socket,CURLOPT_RETURNTRANSFER,true);
	//curl_setopt($socket,CURLOPT_AUTOREFERER,true);
	$document_html=curl_exec($socket);
	echo $document_html;

?>