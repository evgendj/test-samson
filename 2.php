<?php
/* Результат выполнения тестового задания №2 от Гузун ЕА */
function debug($data) {
	echo "<pre>" . print_r($data, 1) . "</pre>";
}

// Функция convertString($a, $b)
// $a = "Text 1234 or text 1234 and 1234";
// $b = "1234";
function convertString($a, $b) {
	if (strpos($a, $b, strpos($a, $b) + 1)) {
		$i = strpos($a, $b, strpos($a, $b) + 1);
	}
	$rev = substr_replace($a, strrev($b), $i, strlen($b));
	return $rev;
	// echo $rev;
}
// convertString($a, $b);
