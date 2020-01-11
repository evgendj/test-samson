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

// Функция mySortForKey($a, $b)
// $a = [['a'=>[4, 5, 8, 1, 3],'b'=>1,'4'=>52],['a'=>[20, 15, 18, 11, 13],'b'=>3]];
// $b = 'a';
function mySortForKey($a, $b) {
	foreach ($a as $key => $value) {
		foreach ($a[$key] as $k => $v) {
			if (array_key_exists($b, $a[$key])) {
				if (is_array($a[$key][$b]) && $k == $b) {
					sort($a[$key][$k]);
				}
			} else {
				throw new Exception("Индекс неправильного массива - $key");
			}
		}
	}
	// debug($a);
	return $a;
}
// mySortForKey($a, $b);
