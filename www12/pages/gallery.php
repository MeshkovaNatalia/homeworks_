<?php

if (empty($_SESSION['u'])) {
    header('Location: /index.php?page=login');
}

/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 04.10.2017
 * Time: 19:29
 */

$errors = [];
$maxFileSize = 3 * 1024 * 1024; // 3 Mb
$galleryFolder = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'gallery1' . DIRECTORY_SEPARATOR;
$galleriesFolder = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR;
$webFolder = 'files/';
$allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
$allowedType = ['image/jpeg', 'image/gif', 'image/png'];

function getDirs() {
    global $galleriesFolder;

    $dirs = [];

    if (is_dir($galleriesFolder)) {
        if ($dh = opendir($galleriesFolder)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..' && is_dir($galleriesFolder . $file)) {
                    $dirs[] = $file;
                }
            }
            closedir($dh);
        }
    }

    return $dirs;
}

function displayGallery() {
    global $galleriesFolder, $allowedExt, $webFolder;

    $gDirs = getDirs();
    if (!empty($gDirs)) {
        foreach ($gDirs as $dir) {
            $galleryFolder = $galleriesFolder . $dir . DIRECTORY_SEPARATOR;
            $sGalleryImgs = '';
            $sExts = '{' . implode(',', $allowedExt) . '}';
            // echo '$sExts: ' . var_export($sExts, 1) . '<br>';
            // $galleriesFolder . $dir *.{jpg,jpeg,png,gif}
            $imgFiles = glob("$galleryFolder*.$sExts", GLOB_BRACE);
            if (!empty($imgFiles)) {
                $sGalleryImgs .= '<h2>Images in directory ' . $webFolder . $dir . '/' . '</h2>';
                foreach ($imgFiles as $file) {
                    $pInf = pathinfo($file);
                    $sGalleryImgs .= '<a href="'. $webFolder . $dir . '/' . $pInf['basename'] . '"><img class="fancyBox" src="'. $webFolder . $dir . '/' . $pInf['basename'] . '" width="25%" alt="' . $pInf['basename'] . '" title="' . $pInf['basename'] . '" data-fancybox="group-' . $dir . '" data-caption="' . $pInf['basename'] . '"></a>';
                }
            } else {
                $sGalleryImgs .= '<h2>No images in directory ' . $webFolder . $dir . '/' . '</h2>';
            }
            if (!empty($sGalleryImgs)) {
                echo $sGalleryImgs;
            }
        }
    }
}

if (!empty($_FILES)) {
    // die(var_export($_FILES, 1));
    foreach ($_FILES as $file) {
        if (empty($file['name'])) {
            continue;
        }

        $pInf = pathinfo($file['name']);
        if (!in_array(strtolower($pInf['extension']), $allowedExt)) {
            $errors[] = 'Uploaded file has wrong extension: ' . $pInf['extension'] .
                '. Allowed extensions are: ' . var_export($allowedExt, 1) . '<br>';
        }

        if ($file['error'] !== 0) {
            $errors[] = 'Error uploading file: ' . var_export($file['error'], 1) . '<br>';
        }

        if ($file['size'] > $_POST['MAX_FILE_SIZE']) {
            $errors[] = 'Error uploading file: Uploaded file size ' . $file['size'] .
                ' is bigger than max allowed ' . $_POST['MAX_FILE_SIZE'] . '<br>';
        }

        $mimeType = mime_content_type($file['tmp_name']);
        // die('Mime type of uploaded file is: ' . var_export($mimeType, 1));
        if (!in_array($mimeType, $allowedType)) {
            $errors[] = 'Uploaded file Mime type: ' . $mimeType . ' is not allowed to upload. ' .
                'Allowed Mime types are: ' . var_export($allowedType, 1);
        }

        if (empty($errors)) {
            $dstFileName = $galleriesFolder . $_POST['dir'] . DIRECTORY_SEPARATOR . $file['name'];
            if (move_uploaded_file($file['tmp_name'], $dstFileName)) {
                echo 'File ' . $file['name'] . ' was uploaded.' . '<br>';
            } else {
                echo 'Error: can`t move uploaded file to ' . $dstFileName . '<br>';
            }
        } else {
            foreach ($errors as $err) {
                echo $err;
            }
        }
    }
}

?>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <?php

            $maxFileUploads = ini_get('max_file_uploads');
            $numUploads = rand(2, intval($maxFileUploads / 2));
            if ($numUploads == 0) {
                $numUploads = 1;
            }
            $allowExtTxt = $s1 = '';
            foreach ($allowedExt as $ext) {
                $allowExtTxt .= $s1 . $ext;
                $s1 = ', ';
            }
            for ($i = 1; $i <= $numUploads; $i++) {
                echo '<div class="file' . $i . '-upload-container upload-container">
            <label for="file' . $i . '">Choose image #' . $i . ' (' . $allowExtTxt . ') to upload:</label>
            <input type="file" name="file' . $i . '">
        </div>';
            }

        ?>
        <div>
            <select name="dir">
                <?php
                    $dirs = getDirs();
                    if (!empty($dirs)) {
                        $sel = ' selected';
                        foreach ($dirs as $dir) {
                            echo '<option value="' . $dir . '"' . $sel . '>' . $dir . '</option>';
                            $sel = '';
                        }
                    }
                ?>
            </select>
        </div>
        <div>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?=$maxFileSize?>">
            <input type="submit" value="Upload">
        </div>
    </form>
</div>
<hr>
<div class="uploaded-images">
    <?=displayGallery()?>
</div>

<script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="vendor/fancybox-master/dist/jquery.fancybox.js"></script>
<script>

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
