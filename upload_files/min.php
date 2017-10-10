<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 09.10.2017
 * Time: 21:55
 */
$errors = array();
if (isset($_POST['galleryfolder'])) {
    $fol = $_POST['galleryfolder'];
} else {
    $fol = 'gallery1/';
}
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
            $galleryImages .= '<a href="'. $fol . $p_inf['basename'] . '"><img src="'. $fol . $p_inf['basename'] . '" width="25%" alt="'.$p_inf['basename'] .$p_inf['basename'] . '"></a>';
        }
    }  else {
        $galleryImages = '<h2>Нет файлов в папке '.substr($fol,0,8).'</h2>';
    }
    if(!empty($galleryImages)){
        echo $galleryImages;
    }
}

if (!empty($_POST['galleryfolder'])){

    if(!empty($_FILES)) {
        foreach ($_FILES as $file) {
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
        }
    }
    if(empty($errors)) {
        $folder_first = $_FILES['userfile']['tmp_name'];
        $name = $_FILES['userfile']['name'];
        if (move_uploaded_file($folder_first, $folder . $name)) {
            echo "Файл успешно загружен!";
        } else {
            echo "Произошла ошибка загрузки файла";
        }

    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
} else {
    echo "Выберите директорию: <br>";
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
    <select name="galleryfolder">
        <option value="gallery1/">gallery1</option>
        <option value="gallery2/">gallery2</option>
    </select><br><br>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000">
    Выберите файл: <input name="userfile" type="file">
    <input type="submit" value="Загрузить">
</form>
<div><?php displayGallery()?></div>
</body>
</html>