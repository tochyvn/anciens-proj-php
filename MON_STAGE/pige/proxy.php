<?php
	if(preg_match('/^https?:\/\//',$_REQUEST['url'])){
		$ch = curl_init();
		$contenu=file_get_contents($_REQUEST['url']);
		curl_setopt($ch, CURLOPT_URL, $_REQUEST['url']);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$body=curl_exec($ch);
		$info=curl_getinfo($ch);
		curl_close($ch);
		
		header('content-type: '.$info['content_type']);
		header('content-length: '.strlen($body));
		echo $body;
	}
	die()
?>