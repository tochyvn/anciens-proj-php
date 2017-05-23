<?php
$document = new DOMDocument();
$document->loadHTMLFile('toch.html');
//echo $document;
echo $document->documentElement->childNodes->item(1)->getElementsByTagName('span')->item(0)->nodeName;
?>