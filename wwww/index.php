<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 24.04.2017
 * Time: 10:15
 *
 * Расширение для работы с MySQL:  mysqli.
 * Практика – PHP+MySQL на примере интернет магазина,
 * пишем админку, добавляем/выводим товары, категории.
 * создание корзины покупателя
 * создание постраничной навигации
 */

global $db, $categoryId, $pNum, $pLimit, $numGoods, $year;

if (isset($_GET['category'])) {
    $categoryId = intval($_GET['category']);
} else {
    $categoryId = 5;
}

$pLimit = 2;
if (isset($_GET['page'])) {
    $pOffset = (intval($_GET['page']) - 1) * $pLimit;
    $pNum = intval($_GET['page']);
} else {
    $pOffset = 0;
    $pNum = 1;
}

require_once 'inc' . DIRECTORY_SEPARATOR . 'session.php';
require_once 'inc' . DIRECTORY_SEPARATOR . 'functions.php';

dbConnect();


$categories = getCategories();

$numGoods = getNumGoodsInCategory($categoryId);

$products = getProductsOnCategoryPage($categoryId, $pLimit, $pOffset);

$year = date('Y');
// $userInfo = var_export($_SESSION['u'], 1);
if (!empty($_SESSION['u'])) {
    $userInfo = '<a href="/logout.php">Log Out</a>';
} else {
    $userInfo = '<a href="/register.php">Register</a></li><li><a href="/login.php">Log In</a>';
}

require_once 'views' . DIRECTORY_SEPARATOR . '_layout_main.php';
