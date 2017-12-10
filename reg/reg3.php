<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 10.12.2017
 * Time: 13:14
 */

if (preg_match("/^[a-zA-Z0-9_\sа-яА-Я]+$/", $_POST['username'] )) {
    echo "valid_name";
} else {
    echo "invalid_name";
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<form method="POST" action="">
    <input type="text" name="username" value="User1"/>
    <input type="submit" value="Submit"/>
</form>
</body>
</html>