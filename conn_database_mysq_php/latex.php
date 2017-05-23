<?php

//$file = fopen(slideO.tex, 'r');
$str = htmlentities(file_get_contents('slides-latex_Final_V2/slideO.tex'));
//echo $str;
$str1 = preg_replace('#\]\{(.*\.png)\}\}#',']{/Users/silnti/Desktop/DocTeX/slides-latex_Final_V2/images/$1}}', $str);
echo $str1;
///Users/silnti/Desktop/DocTeX/slides-latex_Final_V2/images/$1


?>