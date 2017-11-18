<?php
/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 25.10.2017
 * Time: 19:30
 */

require_once 'inc' . DIRECTORY_SEPARATOR . 'functions.php';

dbConnect();

$newSalt = getSalt();
$newPassword = getHashedPassword('NN4)123?Tt-voi}r3E)v', $newSalt);

$sql = "UPDATE `users` SET `password` = '{$newPassword}', `salt` = '{$newSalt}',  `is_admin` = 1 WHERE `id` = 1";
$res = $db->query($sql);
if ($db->error) {
    die('Error #' . $db->errno . ': ' . $db->error);
}

echo 'UPDATE result: ' . print_r($res, 1);