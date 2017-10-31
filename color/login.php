<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 13.10.2017
 * Time: 20:32
 */

session_start();
setcookie('color',$_POST['colors'], time()+3,'/');
$users = array( array('login' => 'natalia', 'password' => 'abc123'), array('login' => 'ivan', 'password' => 'ivan123'));
$loggined = false;

if (!empty($_POST)) {

        if(isset($_POST['login']) && isset($_POST['pass'])){
            foreach ($users as $user){
                if($user['login'] == $_POST['login'] && $user['password'] == $_POST['pass']) {
                    $_SESSION['user'] = $user['login'];
                    $loggined = true;
                    echo 'Добро пожаловать, '.$_SESSION['user'];
                    break;
                }
                if (!$loggined) {
                    echo 'Ошибка: Неверный логин или пароль!';
                    break;
                }
            }

        }
print_r($_COOKIE);

}

if (isset($_GET['param']) && $_GET['param'] == 'exit'){
    header("Location: index.html");
    session_destroy();
}




?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>
<body>
<form method="GET" action="">
    <a href="login.php?param=exit">Выйти</a>
</form>
</body>
</html>


