<?php

$content = file_get_contents('product.xml');
$product = new SimpleXMLElement($content);
foreach ($product->xpath('//Товар') as $price) {
  echo $price['Название'], ' ';
}


// https://www.php.net/manual/ru/simplexml.examples-basic.php
