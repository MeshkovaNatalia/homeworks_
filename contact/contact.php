<?php

$errors = array();
$file = 'coments.dat';

function getComments(){
    global $file;
    if(file_exists($file)) {
        $commentsStr = file_get_contents($file);
        if (!empty($commentsStr)){
            $comments = unserialize($commentsStr);
        } else {
            $comments = array();
        }
    }
    return($comments);
}

function dataValid ($data) {
    global $errors;
    $validResult = true;
    if (empty($data['username']) or !isset($data['username'])){
        $validResult = false;
        array_push($errors, " ! Введите ваше имя");
    }
    if (empty($data['message']) or !isset($data['message'])){
        $validResult = false;
        array_push($errors, " ! Добавьте комментарий");
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $validResult = false;
        array_push($errors, " ! Введите корректный электронный адрес");
    }
    return $validResult;
}

function listErrors() {
    global $errors;
    if (!empty($errors)){
        foreach ($errors as $msg) {
            echo  $msg ."<br>";
        }
    }
}

function addComments($data) {
    global $file;
    $data['add'] = date('H:i:s Y-m-d');
    $data['username'] = trim(strip_tags($data['username']));
    $data['message'] = trim(htmlentities($data['message'], ENT_COMPAT));
    $previousComments = getComments();
    $allComments = array_merge($previousComments, [$data]);
    $listComments = serialize($allComments);
    file_put_contents($file, $listComments);

}

function listComments() {
    $comments = getComments();
    if(!empty($comments)) {
        $comments = array_reverse($comments);
        foreach ($comments as $comment) {
                $listComments = "<pre class='text'>Добавлено пользователем  </pre><pre class='name'><a href='#'>{$comment['username']}</a></pre><pre class='text'>  в   </pre><pre class='date'
>{$comment['add']}</pre> <pre class='text'>сообщение:</pre><br><span class='message'>{$comment['message']}</span><br><br>";
                echo $listComments;
        }
    }
    else {
        $listComments = "<div class='text'>Добавьте первый комментарий</div>";
        echo $listComments;
    }

    return $listComments;
}



if(!empty($_POST)){
    if(dataValid($_POST)) {
        addComments($_POST);
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавить коментарий</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="border" align="center">
<div class="errors"><b><?php listErrors()?></b></div>
<form method="POST" action="">
    <input type="text" name="username" placeholder="Ваше имя"><br><br>
    <input type="text" name="email" placeholder="Ваша почта"><br><br>
    <textarea name="message" rows="5" cols="40" placeholder="Введите комментарий"></textarea><br><br>
    <input type="submit" value="Добавить комментарий"><br><hr><br><br>
</form>
<?php listComments()?>
</div>
</body>
</html>