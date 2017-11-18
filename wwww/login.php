<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 24.04.2017
 * Time: 17:52
 */

require_once 'inc' . DIRECTORY_SEPARATOR . 'session.php';
require_once 'inc' . DIRECTORY_SEPARATOR . 'functions.php';

dbConnect();

if (!empty($_POST)) {
    if (empty($_POST['umail'])) {
        die('Error: Email can`t be empty!');
    }
    if (empty($_POST['upass'])) {
        die('Error: Password can`t be empty!');
    }
    $sql = "SELECT * FROM `users` WHERE `email` = '{$_POST['umail']}' AND `active` = 1";
    $res = $db->query($sql);
    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }
    if ($u1 = $res->fetch_assoc()) {
        // die(print_r($u1));
        /*
        $passOptions = [
            'cost' => 11,
            'salt' => $u1['salt'],
        ];
        $passHash = password_hash($_POST['upass'], PASSWORD_BCRYPT, $passOptions)."\n";
        */
        $passHash = getHashedPassword($_POST['upass'], $u1['salt']);
        if ($passHash === $u1['password']) {
            $_SESSION['u'] = [
                'id' => $u1['id'],
                'user' => $u1['email'],
                'is_admin' => $u1['is_admin'],
                'started' => date('Y-m-d H:i:s'),
            ];
            header('Location: /');
        }
        die('Error: Wrong email or password!');
    }
    die('Error: User not found!');
} else {
    die(getLoginForm());
}