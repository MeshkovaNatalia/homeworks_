<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 11.11.2017
 * Time: 16:45
 */
$db_host = 'localhost';
$db_user = 'rootr';
$db_password = '';
$db_name = 'les15';

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$link) {
    die('<p style="color:red">'.mysqli_connect_errno().' - '.mysqli_connect_error().'</p>');
}

echo "<p>Мы подключились к базе данных!</p>";

$result_set = $link->query('SELECT users.id, users.`name`, news.item FROM users JOIN news ON users.id = news.user_id GROUP BY user_id ORDER BY RAND() LIMIT 7;');

while ($row = $result_set->fetch_assoc()) {
    echo "Пользователь '".$row['name']."' с id '".$row['id']."' написал первую новость: '".$row['item']."''";
    echo "<br />";
}
$result_set->close();
$link->close();