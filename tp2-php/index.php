<?php

$h = new html();
$head = new head();
$body = new body();

$body->setAttribute("id","id1");
$h->addElement($head);
$h->addElement($body);

echo $h->toHTML();

?>