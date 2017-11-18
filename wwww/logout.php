<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 24.04.2017
 * Time: 19:27
 */

require_once 'inc' . DIRECTORY_SEPARATOR . 'session.php';

if (!empty($_SESSION['c'])) {
    unset($_SESSION['c']);
}
if (!empty($_SESSION['u'])) {
    unset($_SESSION['u']);
}
session_destroy();
header('Location: /');
