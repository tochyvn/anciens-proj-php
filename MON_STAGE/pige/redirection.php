<?php
	if(preg_match('/^https?:\/\//',$_REQUEST['url'])) header('location: '.$_REQUEST['url']);
	die()
?>