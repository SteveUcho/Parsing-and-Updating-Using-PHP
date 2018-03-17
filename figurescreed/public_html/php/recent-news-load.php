<?php

require("simple_html_dom.php");

$wordpress = file_get_html('http://www.figurescreed.moe');
$index = file_get_html('../index.html');
$xml = simplexml_load_file("https://www.figurescreed.moe/feed/") or die("Error: Cannot create object");
$noticias = file_get_html('../noticias/index.html');

$article = $wordpress->find('article');

for ($x = 0; $x < 6; $x++) {
    
  $title = $xml->channel->item[$x]->title;
  $thing = $index->find('#title');
  
  $image = $article[$x]->find('img', 0)->src;
  $thing2 = $index->find('#img-here');

  $thing[$x]->innertext = $title;
  $thing2[$x]->style = 'background-image: url(' . $image . ');';
}

$myfile = fopen("../index.html", "w") or die("Unable to open file!");
fwrite($myfile, $index);
fclose($myfile);

//<!--Noticias vvv -->

for ($x = 0; $x < 10; $x++) 
{
  
  $wordpress->find('.more-link', $x)->class = 'more-link btn btn-lg';
  $wordpress->find('.more-link', $x)->innertext = 'Leer Mas';
  $noticias->find('article', $x)->outertext = $article[$x];
  
}

$myfile = fopen("../noticias/index.html", "w") or die("Unable to open file!");
fwrite($myfile, $noticias);
fclose($myfile);

?>