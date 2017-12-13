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

error_reporting(E_ALL);
ini_set('display_errors', 1);

global $db;

require_once 'inc' . DIRECTORY_SEPARATOR . 'functions.php';

dbConnect();

$catId = intval($_GET['id']);

$sql = "SELECT g.*, c.name as category_name FROM `goods` g INNER JOIN `category` c ON c.`id` = g.`category_id` WHERE g.`category_id` = '{$catId}' AND g.`active` = 1 ORDER BY g.`id` ASC";

$res = $db->query($sql);

if ($db->error) {
    die('Error #' . $db->errno . ': ' . $db->error);
}

echo '<a href="/">К списку категорий</a>';
echo '<ul>';
while ($g1 = $res->fetch_assoc()) {
    echo '<li><a href="#">' . $g1['title'] . '</a> - $' . number_format($g1['mail-price']) . ' ' . $g1['description'] . '</li>';
}
echo '</ul>';