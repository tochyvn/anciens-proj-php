<?php
header("Content-disposition: attachment; filename=captureTA.txt");
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: text/plain\n");
header("Content-Length: ".filesize('./capture/'.$_REQUEST['f']));
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
header("Expires: 0");
readfile('./capture/'.$_REQUEST['f']);
?>