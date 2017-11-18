<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 11.11.2017
 * Time: 16:45
 */
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'db';

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$link) {
    die('<p style="color:red">'.mysqli_connect_errno().' - '.mysqli_connect_error().'</p>');
}

echo "<p>Вы подключились к MySQL!</p>";

