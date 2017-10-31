<?php
/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 11.10.2017
 * Time: 20:22
 */

session_destroy();

if (!empty($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
