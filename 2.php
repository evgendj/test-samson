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

// Функция importXml($a)
function importXml($a) {
	require_once('connect_db.php');
	$xml = file_get_contents($a);
	$product = new SimpleXMLElement($xml);
	try {
		for ($i = 0, $parent_id = 0, $c = 1; $i < $product->Товар->count(); $i++) {

			// Загружаем код и имя продукта, извлекаем id
			$insert_product = $pdo->prepare("INSERT INTO a_product VALUES (NULL, ?, ?)");
			$insert_product->execute([$product->Товар[$i]->attributes()->{'Код'}, $product->Товар[$i]->attributes()->{'Название'}]);
			$product_id = $pdo->lastInsertId();

			// Загружаем цену с типом
			$insert_price = $pdo->prepare("INSERT INTO a_price VALUES ($product_id, ?, ?)");
			foreach ($product->Товар[$i]->Цена as $price) {
				$insert_price->execute([$price['Тип'], $price]);
			}

			// Загружаем свойства
			$insert_properties = $pdo->prepare("INSERT INTO a_property VALUES ($product_id, ?, ?)");
			foreach ($product->Товар[$i]->Свойства as $properties) {
				foreach ($properties as $property => $value) {
					$insert_properties->execute([$property, $value]);
				}
			}

			// Загружаем разделы, вложенность разделов и связь разделов с товаром
			$insert_category = $pdo->prepare("INSERT INTO a_category VALUES (NULL, ?, ?, ?)");
			$product_in_category = $pdo->prepare("INSERT INTO a_product_category VALUES (?, ?)");
			foreach ($product->Товар[$i]->Разделы->Раздел as $category_name) {
				$query_category = $pdo->query("SELECT * FROM a_category WHERE name LIKE '$category_name'");
				$category = $query_category->fetch(PDO::FETCH_ASSOC);
				if ($category['name'] == $category_name) {
					$parent_id = $category['category_id'];
					$product_in_category->execute([$product_id, $category['category_id']]);
				} else {
					$insert_category->execute([$c, $category_name, $parent_id]);
					$parent_id = $pdo->lastInsertId();
					$product_in_category->execute([$product_id, $pdo->lastInsertId()]);
					$c++;
				}
			}
			$parent_id = 0;
		}
	} catch (PDOException $e) {
		echo "Ошибка загрузки в базу данных" . $e->getMessage();
	}
}
// $a = 'product.xml';
// importXml($a);

// Функция exportXml($a, $b)
function exportXml($a, $b) {
	require_once('connect_db.php');
	$xml = '<?xml version="1.0" encoding="UTF-8"?><Товары></Товары>';
	$products = new SimpleXMLElement($xml);

	try {
		// Выбираем категорию с требуемым кодом.
		$category_q = $pdo->query("SELECT * FROM a_category WHERE code = $b");
		$category = $category_q->fetch(PDO::FETCH_ASSOC);

		// Выбираем id товаров, соответствующих требуемой категории. Формируем код и название товара.
		$product_cat_q = $pdo->query("SELECT * FROM a_product_category WHERE category_id = $category[category_id]");
		while ($product_category = $product_cat_q->fetch(PDO::FETCH_ASSOC)) {
			$product_q = $pdo->query("SELECT * FROM a_product WHERE product_id = $product_category[product_id]");
			$product = $product_q->fetch(PDO::FETCH_ASSOC);
			$product_tag = $products->addChild('Товар');
			$product_tag->addAttribute('Код', $product['code']);
			$product_tag->addAttribute('Название', $product['name']);

			// Выбираем цены, формируем тип цены и значение.
			$price_q = $pdo->query("SELECT * FROM a_price WHERE product_id = $product[product_id]");
			while ($price = $price_q->fetch(PDO::FETCH_ASSOC)) {
				$price_tag = $product_tag->addChild('Цена', $price['price']);
				$price_tag->addAttribute('Тип', $price['type']);
			}

			// Выбираем и формируем свойства
			$properties_tag = $product_tag->addChild('Свойства');
			$property_q = $pdo->query("SELECT * FROM a_property WHERE product_id = $product[product_id]");
			while ($property = $property_q->fetch(PDO::FETCH_ASSOC)) {
				$properties_tag->addChild($property['name'], $property['property']);
			}

			// Формируем категории
			$catalogs_tag = $product_tag->addChild('Разделы');
			$catalogs_tag->addChild('Раздел', $category['name']);
		}
	} catch (PDOException $e) {
		echo "Ошибка выполнения запроса " . $e->getMessage();
	}
	$products->asXML($a);
}
// $a = 'a.xml';
// $b = 2;
// exportXml($a, $b);
