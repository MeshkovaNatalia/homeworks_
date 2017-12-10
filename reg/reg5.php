<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 10.12.2017
 * Time: 13:15
 */

$var = '7hg_hfS7fgdfgfdgdfgdgdgdgfgdgd7';
if (preg_match("/^[a-zA-Z0-9_]{3,16}$/", $var)) {
    echo "yes";
} else {
    echo "no";
}