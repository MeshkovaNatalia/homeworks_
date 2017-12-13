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

require_once 'inc' . DIRECTORY_SEPARATOR . 'session.php';
require_once 'inc' . DIRECTORY_SEPARATOR . 'functions.php';

dbConnect();

if (!isset($_SESSION['u'])) {
    header('Location: /login.php');
}

echo 'Hello, <strong>' . $_SESSION['u']['user'] . '</strong>.<hr><br>Cart items:<br>';

if (!isset($_SESSION['c'])) {
    $_SESSION['c'] = [];

    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
        $_SESSION['c']['p'] = [
            $productId => 1,
        ];
    }
} else {
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
        if (isset($_SESSION['c']['p'][$productId])) {
            $_SESSION['c']['p'][$productId] += 1;
        } else {
            $_SESSION['c']['p'][$productId] = 1;
        }
    }
}

echo '<pre>' . var_export($_SESSION['c']['p'], 1) . '</pre>';

if (!empty($_SESSION['c']['p'])) {
    $gIds = implode(',', array_keys($_SESSION['c']['p']));
    $sql = "SELECT g.*, c.name as category_name FROM `goods` g INNER JOIN `category` c ON c.`id` = g.`category_id` WHERE g.`id` IN ($gIds) AND g.`active` = 1";
    $res = $db->query($sql);
    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }
    $products = [];
    while ($p1 = $res->fetch_assoc()) {
        $products[] = $p1;
    }
    $pr1Html = '';
    $pr1Html .= '<div id="cart-items-container">';
    if (!empty($products)) {
        $totalSum = 0;
        foreach ($products as $pr1) {
            $total = $_SESSION['c']['p'][$pr1['id']] * $pr1['mail-price'];
            $totalSum += $total;

            $pr1Html .= '<div class="prodContainer">' .
                $pr1['category_name'] . ' ---> ' .
                $pr1['title'] . ' ---> $' . $pr1['mail-price'] .
                ' quantity: ' . $_SESSION['c']['p'][$pr1['id']] .
                ' total: ' . $total .
                '</div>';
        }
        $pr1Html .= '<div><hr>Cart total: $' . $totalSum . '</div>';
        $pr1Html .= '<div class="text-right"><a href="#" class="btn btn-success" id="buy">Buy</a></div>';
        $pr1Html .= '</div>';
        $pr1Html .= '<div id="cart-msg"></div>';
    }

    echo $pr1Html;
}

?>

<script>
    /* Submit Order */
    $('#buy').on('click', function(ev){
        ev.preventDefault();

        $.ajax({
            'url': '/order.php',
            'method': 'POST',
            'success': function(data) {
                $('#cart-msg').html(data);
                $('#cart-items-container').hide();
            }
        });

        return false;
    });
</script>
