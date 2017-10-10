<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 10.10.2017
 * Time: 21:29
 */


$errors = array();
$fol = 'gallery1/';
$folder = __DIR__.DIRECTORY_SEPARATOR.$fol.DIRECTORY_SEPARATOR;
$allowedFiles = array('jpg', 'jpeg', 'png', 'gif');
$allowedTypes = array('image/jpeg', 'image/gif', 'image/png', 'image/jpg');

function displayGallery () {
    global $folder, $allowedFiles, $fol;
    $Exts = '{'.implode(',',$allowedFiles).'}';
    $imageFiles = glob("$folder*.$Exts", GLOB_BRACE);
    if(!empty($imageFiles)){
        $galleryImages = '<h2>Файлы в папке '.substr($fol,0,8).'</h2>';
        foreach ($imageFiles as $file) {
            $p_inf = pathinfo($file);
            $galleryImages .= '<a href="'. $fol . $p_inf['basename'] . '"><img src="'. $fol . $p_inf['basename'] . '" width="25%" alt="'.$p_inf['basename'] .$p_inf['basename'] . '" data-fancybox="group" data-caption="' . $p_inf['basename'] . '"></a>';
        }
    }  else {
        $galleryImages = '<h2>Нет файлов в папке '.substr($fol,0,8).'</h2>';
    }
    if(!empty($galleryImages)){
        echo $galleryImages;
    }
}

if (!empty($_FILES)) {
    foreach ($_FILES as $file) {

        $pinf = pathinfo($file['name']);
        if ($file['error'] !== 0) {
            array_push($errors, "Ошибка загрузки файла " . $file['name']);
        }

        $file_type = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_type), $allowedFiles)) {
            array_push($errors, "Неверный формат файла " . $file['name']);
        }
        if ($file['size'] > $_POST['MAX_FILE_SIZE']) {
            array_push($errors, "Файл " . $file['name'] . " имеет слишком большой размер");
        }
        if (!in_array($file['type'], $allowedTypes)) {
            array_push($errors, "Неверный тип файла " . $file['name']);
        }

        if (empty($errors)) {
            $new_folder = dirname(__FILE__)  . DIRECTORY_SEPARATOR . $fol . DIRECTORY_SEPARATOR;
            $newFileName = $new_folder . $file['name'];
            if (move_uploaded_file($file['tmp_name'], $newFileName)) {
                echo 'Файл ' . $file['name'] . ' был загружен.' . '<br>';
            } else {
                echo 'Error: can`t move uploaded file to ' . $dstFileName . '<br>';
            }
        } else {
            foreach ($errors as $error) {
                echo $error;
            }
        }
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <link rel="stylesheet" href="vendor/fancybox-master/dist/jquery.fancybox.css" type="text/css" media="screen">
</head>
<body>
<form enctype="multipart/form-data" action="" method="POST">
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form">
                <div>
                    <label for="file1">Choose image #1 (png, jpeg or gif) to upload:</label>
                    <input type="file" name="file1">
                </div>
                <div>
                    <label for="file2">Choose image #2 (png, jpeg or gif) to upload:</label>
                    <input type="file" name="file2">
                </div>
            </div>
            <div>
                <span class="on">Добавить</span>&nbsp;<span class="off">Удалить</span>
            </div>
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
    <input type="submit" value="Загрузить">
</form>
<div><?php displayGallery()?></div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="vendor/fancybox-master/dist/jquery.fancybox.js"></script>
        <script>

            $("body").on("click", ".on", function() {
                $(".form div:last").clone().appendTo(".form");
                var countElements = $('.form').children().length;
                $(".form div:last label").attr("for", "file" + countElements);
                $(".form div:last label").text("Choose image #" + countElements + " (png, jpeg or gif) to upload:");
                $(".form div:last input").attr("name", "file" + countElements);
            });

            $("body").on("click", ".off", function() {
                if($('.form').children().length>1) {
                    $(".form div:last").remove();
                }
            });


            $(document).ready(function() {
                $("a.fancyBox").fancybox({
                    'transitionIn'	:	'elastic',
                    'transitionOut'	:	'elastic',
                    'speedIn'		:	600,
                    'speedOut'		:	200,
                    'overlayShow'	:	false
                });
            });

        </script>
</body>
</html>