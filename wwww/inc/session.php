<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 24.04.2017
 * Time: 19:19
 */

if (isset($_COOKIE['session_id'])) {
    session_id($_COOKIE['session_id']);
    session_start();
} else {
    session_start();
    setcookie('session_id', session_id());
}
