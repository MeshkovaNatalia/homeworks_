<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 10.12.2017
 * Time: 13:13
 */

$files = scandir(__DIR__);
$fi = implode(" ", $files);
$fi = $fi . " ";
preg_match_all("/\.[a-z0-9]{3,4}\s/", $fi, $mas);
foreach ($mas[0] as $value) {
    echo $value."<br>";
}
