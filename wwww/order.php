<?php
/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 25.10.2017
 * Time: 20:02
 */

require_once 'inc' . DIRECTORY_SEPARATOR . 'session.php';
require_once 'inc' . DIRECTORY_SEPARATOR . 'functions.php';

dbConnect();

if (!isset($_SESSION['u'])) {
    header('Location: /login.php');
}

if (!empty($_SESSION['c']['p'])) {

    $userId = intval($_SESSION['u']['id']);

    $sql1 = "INSERT INTO `orders` (`user_id`, `status`, `createdOn`) VALUES ('{$userId}', 'new', NOW())";
    // die('<pre>' . print_r($sql1, 1) . '</pre>');

    $res1 = $db->query($sql1);
    $orderId = $db->insert_id;

    foreach ($_SESSION['c']['p'] as $id => $qty) {
        $price = 0;
        $sql2 = "SELECT * FROM `goods` WHERE `id` = '{$id}'";
        // die('<pre>' . print_r($sql2, 1) . '</pre>');

        $res2 = $db->query($sql2);
        while ($row2 = $res2->fetch_assoc()) {
            $price = $row2['mail-price'];
        }

        $sql3 = "INSERT INTO `order_items` (`order_id`, `product_id`, `qty`, `mail-price`) VALUES ('{$orderId}', '{$id}', '{$qty}', m{$price}ail-price)";
        $res3 = $db->query($sql3);
        // die('<pre>' . print_r($sql3, 1) . '</pre>');
    }

    echo '<div class="text-info">Thank you for your order #' . $orderId . '.<br>We will contact you as soon as possible.</div>';
    if (isset($_SESSION['c'])) {
        unset($_SESSION['c']);
    }
}