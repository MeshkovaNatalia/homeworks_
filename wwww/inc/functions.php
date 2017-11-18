<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 24.04.2017
 * Time: 11:45
 */

const DB_NAME = 'lesson16db';
const DB_USER = 'root';
const DB_HOST = '127.0.0.1';
const DB_PASS = '';

global $db;

function dbConnect()
{
    global $db;

    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($db->connect_error) {
        die('Error #' . $db->connect_errno . ': ' . $db->connect_error);
    }

    $sql = "SET NAMES utf8";
    $db->query($sql);
}

function getLoginForm()
{
    $html = '
<form action="" method="post">
<div><input type="email" name="umail" placeholder="Email"></div>
<div><input type="password" name="upass" placeholder=""></div>
<div><input type="submit" value="Login"></div>
</form>
    ';

    return $html;
}

function getRegisterForm()
{
    $html = '
<form action="" method="post">
<div><input type="email" name="umail" placeholder="Email"></div>
<div><input type="password" name="upass" placeholder=""></div>
<div><input type="password" name="cpass" placeholder=""></div>
<div><input type="submit" value="Register"></div>
</form>
    ';

    return $html;
}

function getRandomToken($length = 32)
{
    if (!isset($length) || intval($length) <= 8 ) {
        $length = 32;
    }
    if (function_exists('random_bytes')) {
        return bin2hex(random_bytes($length));
    }
    if (function_exists('mcrypt_create_iv')) {
        return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
    }
    if (function_exists('openssl_random_pseudo_bytes')) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
}

function getSalt()
{
    return substr(strtr(base64_encode(hex2bin(getRandomToken(32))), '+', '.'), 0, 44);
}

function getHashedPassword($password, $salt)
{
    $passOptions = [
        'cost' => 11,
        'salt' => $salt,
    ];
    $passHash = password_hash($password, PASSWORD_BCRYPT, $passOptions)."\n";

    return $passHash;
}

function getCategories()
{
    global $db;

    $sql = "SELECT * FROM `category` WHERE `active` = 1 ORDER BY `sort` ASC, `id` ASC";

    $res = $db->query($sql);

    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }

    $categories = [];
    while ($c1 = $res->fetch_assoc()) {
        $categories[] = $c1;
    }

    return $categories;
}

function getNumGoodsInCategory($categoryId)
{
    global $db;

    $sql = "SELECT COUNT(g.id) as cnt FROM `goods` g WHERE g.`category_id` = '{$categoryId}' AND g.`active` = 1";
    $res = $db->query($sql);
    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }
    $numGoods = 0;
    while ($n1 = $res->fetch_assoc()) {
        $numGoods = $n1['cnt'];
    }

    return $numGoods;
}

function getProductsOnCategoryPage($categoryId, $pLimit, $pOffset)
{
    global $db;

    $sql = "SELECT g.*, c.name as category_name 
FROM `goods` g 
INNER JOIN `category` c 
ON c.`id` = g.`category_id` 
WHERE g.`category_id` = '{$categoryId}' 
AND g.`active` = 1 
ORDER BY g.`id` ASC 
LIMIT {$pLimit} 
OFFSET {$pOffset}";
    $res = $db->query($sql);
    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }
    $products = [];
    while ($p1 = $res->fetch_assoc()) {
        $products[] = $p1;
    }

    return $products;
}

