<?php
require_once('connect_db.php');


// Создание таблиц Самсон
try {
  $a_product = $pdo->exec(
    "CREATE TABLE a_product (
      product_id INT(11) NOT NULL AUTO_INCREMENT,
      code VARCHAR(255),
      name VARCHAR(255),
      PRIMARY KEY (product_id)
    )"
  );

  $a_property = $pdo->exec(
    "CREATE TABLE a_property (
      product_id INT(11) NOT NULL,
      name VARCHAR(255),
      property VARCHAR(255)
    )"
  );

  $a_price = $pdo->exec(
    "CREATE TABLE a_price (
      product_id INT(11) NOT NULL,
      type VARCHAR(255),
      price DECIMAL(15,2)
    )"
  );

  $a_category = $pdo->exec(
    "CREATE TABLE a_category (
      category_id INT(11) NOT NULL AUTO_INCREMENT,
      code VARCHAR(255),
      name VARCHAR(255),
      parent_id INT(11) NOT NULL DEFAULT 0,
      PRIMARY KEY (category_id)
    )"
  );

  $a_product_category = $pdo->exec(
    "CREATE TABLE a_product_category (
      product_id INT(11) NOT NULL,
      category_id INT(11) NOT NULL,
      PRIMARY KEY (product_id, category_id)
    )"
  );

} catch (PDOEXception $e) {
  echo "Не удалось создать таблицу " . $e->getMessage();
}


/*
// Чистка таблиц
try {
  $del1 = $pdo->exec("DELETE FROM a_product");
  $del2 = $pdo->exec("DELETE FROM a_property");
  $del3 = $pdo->exec("DELETE FROM a_price");
  $del4 = $pdo->exec("DELETE FROM a_category");
  $del5 = $pdo->exec("DELETE FROM a_product_category");
} catch (PDOEXception $e) {
  echo "Не удалось очистить таблицу " . $e->getMessage();
}
*/
