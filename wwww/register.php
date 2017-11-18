<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 24.04.2017
 * Time: 17:10
 */

require_once 'inc' . DIRECTORY_SEPARATOR . 'functions.php';

dbConnect();

if (!empty($_POST)) {
    if (empty($_POST['umail'])) {
        die('Email can`t be empty!');
    }
    if (!filter_var($_POST['umail'], FILTER_VALIDATE_EMAIL)) {
        die('Email has wrong format!');
    }
    if (empty($_POST['upass']) || empty($_POST['cpass']) || ($_POST['upass'] !== $_POST['cpass'])) {
        die('Empty password or check password mismatch!');
    }
    // $passSalt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
    $passSalt = getSalt();
    $passOptions = [
        'cost' => 11,
        'salt' => $passSalt,
    ];
    $passHash = password_hash($_POST['upass'], PASSWORD_BCRYPT, $passOptions)."\n";
    $sql = "INSERT INTO `users`
SET
`email` = '{$_POST['umail']}',
`registeredDate` = NOW(),
`password` = '{$passHash}',
`salt` = '{$passSalt}',
`active` = 1";
    $res = $db->query($sql);
    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }
    if ($db->insert_id) {
        die('Registered user #' . $db->insert_id);
    }
} else {
    die(getRegisterForm());
}