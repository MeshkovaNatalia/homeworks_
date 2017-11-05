<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 05.11.2017
 * Time: 15:29
 */

function myAutoload($class_name) {
    $class_file = $class_name . '.php';
    if (file_exists($class_file) && !class_exists($class_name)) {
        require_once $class_file;
    }
}

spl_autoload_register('myAutoload');

echo 'Количество покупок, совершенных ранее = '.saleCalculation::getOldPurchases();
echo '<hr>';
echo 'Начальная цена товара = '.saleCalculation::getFirstPrice();
echo '<hr>';
echo 'Цена со скидкой = '.saleCalculation::calc_sale();
