<?php
/* Результат выполнения тестового задания №1 от Гузун ЕА */

require_once 'classes/BaseMath.php';
require_once 'classes/F1.php';

function debug($data) {
	echo "<pre>" . print_r($data, 1) . "</pre>";
}

// Массив простых чисел findSimple()
function findSimple($a, $b) {
	for ($i = 0, $array = []; $a <= $b; $i++, $a++) {
		for ($j = 2, $s = 0; $j < $a; $j++) {
			if ($a % $j == 0) {
				$s++;
				break;
			}
		}
		if ($s == 0) {
			$array[] = $a;
		}
	}
	return $array;
}
// Двумерный массив a, b, c createTrapeze()
function createTrapeze($a) {
	for ($i = 0, $j = 0, $array = []; $i < count($a)/3; $i++) {
		for($let = 'a'; $let <= 'c'; $let++, $j++) {
			$array[$i][$let] = $a[$j];
		}
	}
	return $array;
}
// Расчет площади трапеции squareTrapeze()
function squareTrapeze($a) {
	for($i = 0; $i < count($a); $i++) {
		$a[$i]['s'] = 0.5 * $a[$i]['c']*($a[$i]['a'] + $a[$i]['b']);
	}
	return $a;
}
// Максимальная площадь getSizeForLimit()
function getSizeForLimit($a, $b) {
	for($i = 0, $m = 0, $array = []; $i < count($a); $i++) {
		if ($a[$i]['s'] > $m && $a[$i]['s'] < $b) {
			$array = $a[$i];
		}
	}
	return $array;
}
// Минимальное число в массиве getMin()
$array3 = array('один' => 2000, 'два' => 3000, 'три' => 500);
function getMin($a) {
	$min === null;
	foreach($a as $v) {
		if($min > $v or $min === null) {
			$min = $v;
		}
	}
	return $min;
}
// Таблицы с размерами трапеций printTrapeze()
function printTrapeze($a) {
	echo "
		<table border='2'>
		    <tr>
		        <th></th>
		        <th>Сторона - a</th>
		        <th>Сторона - b</th>
		        <th>Высота - h(c)</th>
		        <th>Площадь - s</th>
		    </tr>";
	for($i = 0; $i < count($a); $i++) {
		if(($a[$i]['s'] - floor($a[$i]['s'])) != 0 || $a[$i]['s'] % 2 === 0) {
			echo "
				<tr>";
		} else {
			echo "
			<tr bgcolor='#d0d0d0'>";
		}
		echo "
			<td>Трапеция № ".($i+1	)."</td>
		        <td>".$a[$i]['a']."</td>
		        <td>".$a[$i]['b']."</td>
		        <td>".$a[$i]['c']."</td>
		        <td>".$a[$i]['s']."</td>
		    </tr>";
	}
	echo "</table>";
}

// Вывод
$a = [9,2,3,6,15,2,17,9,12];

// Реализовать функцию getSizeForLimit($a, $b). $a – массив результата выполнения функции squareTrapeze(), $b – максимальная площадь. Результат ее выполнение: массив размеров трапеции с максимальной площадью, но меньше или равной $b.
// Замечание. Вызов функция getSizeForLimit([['s' => 2], ['s' => 3], ['s' => 1]], 2) возвращает неправильный результат, должен вернуть ['s' => 2].
// Я наверное не совсем правильно понял задачу. Ниже в дебаги я подаю массив, который содержит в значениях стороны и площадь для нескольких трапеций. Вторым аргументом я задаю максимальную площадь. Функция возвращает трапецию, у которой площадь максимальная в диапазоне до значения записанного в аргумнте b.

echo "Создан массив, разбит на тройки, прибавлена площадь:";
debug(squareTrapeze(createTrapeze($a)));
echo "Подаем в функцию массив, выводим массив с максимальной площадью, но меньше 20";
debug(getSizeForLimit(squareTrapeze(createTrapeze($a)), 20));
echo "Подаем в функцию массив, выводим массив с максимальной площадью, но меньше 50";
debug(getSizeForLimit(squareTrapeze(createTrapeze($a)), 50));
echo "Подаем в функцию массив, выводим массив с максимальной площадью, но меньше 500";
debug(getSizeForLimit(squareTrapeze(createTrapeze($a)), 500));
echo "<hr>";
printTrapeze(squareTrapeze(createTrapeze($a)));
echo "<hr>";

$abc = new F1 (11, 22, 33);
// debug($abc);
echo $abc->getValue() . "<br>";
