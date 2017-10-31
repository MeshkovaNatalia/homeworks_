<?php
/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 11.10.2017
 * Time: 19:15
 */

$pageTitle = 'Default title';
if (!empty($title)) {
    $pageTitle = $title;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$pageTitle?></title>
    <link rel="stylesheet" href="site.css">
    <link rel="stylesheet" href="vendor/fancybox-master/dist/jquery.fancybox.css" type="text/css" media="screen">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="vendor/js-eml-prot/jep.js"></script>
</head>
<body>

<header>
    <div class="header-text">
    <?php
        if (!empty($pageTitle)) {
            echo '<h1>' . $pageTitle . '</h1>';
        }
    ?>
    </div>
    <div class="top-navigation">
        <?php
            echo getNavigation();
        ?>
    </div>
</header>

