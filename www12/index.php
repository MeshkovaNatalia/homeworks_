<?php
/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 11.10.2017
 * Time: 19:12
 */

session_start();

require 'includes' . DIRECTORY_SEPARATOR . 'functions.php';

ob_start();

$page = 'home';
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

$title = 'Home page';
if (!empty($pages)) {
    foreach ($pages as $pg) {
        if ($pg['uri'] == $page) {
            $title = $pg['title'];
        }
    }
}

require 'templates' . DIRECTORY_SEPARATOR . 'header.php';
$pageFile = 'pages' . DIRECTORY_SEPARATOR . $page . '.php';
if (file_exists($pageFile)) {
    require $pageFile;
}
require 'templates' . DIRECTORY_SEPARATOR . 'footer.php';

$content = ob_get_contents();
ob_end_clean();

echo $content;